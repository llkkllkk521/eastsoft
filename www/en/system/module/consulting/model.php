<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of article module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class consultingModel extends model
{
    /** 
     * Get an article by id.
     * 
     * @param  int      $articleID 
     * @param  bool     $replaceTag 
     * @access public
     * @return bool|object
     */
    public function getByID($consultingID, $replaceTag = true)
    {   
        $consulting = $this->dao->select('*')->from(TABLE_CONSULTING)->where('id')->eq($consultingID)->fetch();

        if(!$consulting) return false;

        return $consulting;
    }

    /** 
     * Get article list.
     *
     * @param  string  $type 
     * @param  array   $categories 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @access public
     * @return array
     */
    public function getList($orderBy, $pager = null)
    {
        $searchWord = $this->get->searchWord;
        //$region = $this->get->region;
        if($searchWord) {
        	$consultings = $this->dao->select('*')->from(TABLE_CONSULTING)
        	->where('realname')->like("%{$searchWord}%")
        	->orWhere('mobile')->like("%{$searchWord}%")
        	->orderBy($orderBy)
        	->page($pager)
        	->fetchAll();
        } else {
        	$consultings = $this->dao->select('*')->from(TABLE_CONSULTING)
        	->page($pager)
        	->fetchAll();
        }
        return $consultings;
    }

    /**
     * Create an consulting.
     * 
     * @param  string $type 
     * @access public
     * @return int|bool
     */
    public function create()
    {
        $now = helper::now();
        $consulting = fixer::input('post')
            ->setDefault('addedDate', $now)
            ->remove('verifycode')
            ->remove('vc')
            ->get();
        
        //实例化redis
        $redis = new Redis();
        //连接redis
        $redis->connect('127.0.0.1', 6379);
        $vcode = $redis->get($this->post->vc);
        if(!$this->post->verifycode) {
        	return array('result' => 'fail', 'message' => '验证码不能为空！<a href="javascript:history.back();">返回</a>');
        }
        if(!$vcode) {
        	return array('result' => 'fail', 'message' => '验证码不能为空！<a href="javascript:history.back();">返回</a>');
        }
        if($this->post->verifycode != $vcode) {
        	return array('result' => 'fail', 'message' => '验证码错误！<a href="javascript:history.back();">返回</a>');
        } else {
        	$redis->delete($this->post->vc);
        }
        
		$consult = $this->dao->select('*')->from(TABLE_CONSULTING)
		->where('realname')->eq($consulting->realname)
		->andWhere('mobile')->eq($consulting->mobile)
		->andWhere('email')->eq($consulting->email)
		->fetch();
		if($consult) {
			return array('result' => 'fail', 'message' => '请不要重复提交！<a href="javascript:history.back();">返回</a>');
		} else {
			$this->dao->insert(TABLE_CONSULTING)
			->data($consulting)
			->exec();
			$consultingID = $this->dao->lastInsertID();
			
			if(dao::isError()) return array('result' => 'fail', 'message' => dao::getError());
			
			return array('result' => 'success', 'message' => '提交成功！');
		}
    }
        
    /**
     * Delete an article.
     * 
     * @param  int      $articleID 
     * @access public
     * @return void
     */
    public function delete($consultingID, $null = null)
    {
        $article = $this->getByID($consultingID);
        if(!$article) return false;
        $this->dao->delete()->from(TABLE_CONSULTING)->where('id')->eq($consultingID)->exec();
        return true;
    }
    
    function getRegions($p_region_id) {
    	if(is_numeric($p_region_id)) {
    		$rs = $this->dbh->query("SELECT * FROM ".TABLE_REGIONS." WHERE p_region_id=$p_region_id");
    		$regions = $rs->fetchAll(PDO::FETCH_ASSOC);
    		foreach($regions AS $value) {
    			$regions_array[$value['region_id']] = $value['local_name'];
    		}
    	} else {
	    	$rs = $this->dbh->query("SELECT * FROM ".TABLE_REGIONS." WHERE p_region_id is null");
	    	$regions = $rs->fetchAll(PDO::FETCH_ASSOC);
	    	foreach($regions AS $value) {
	    		$regions_array[$value['region_id']] = $value['local_name'];
	    	}
    	}
    	return $regions_array;
    }
    
    function getRegionsId2Name($region_id) {
    	if($region_id) {
    		$rs = $this->dbh->query("SELECT * FROM ".TABLE_REGIONS." WHERE region_id=$region_id");
    		$region = $rs->fetch(PDO::FETCH_ASSOC);
    	}
    	return $region['local_name'];
    }
    
    public function cateList() {
    	$regions = $this->dao->select('*')->from(TABLE_REGIONS)->where('region_grade')->eq('1')->fetchAll();
    	$str = '<select name="region" class="region">';
    	$str .= '<option value="">全部城市</option>';
    	foreach($regions AS $r) {
    		$str .= '<option value="'.$r->region_id.'">'.$r->local_name.'</option>';
    		$children = $this->cateChildren($r->region_id);
    		foreach($children AS $c) {
    			$str .= '<option value="'.$c->region_id.'">&nbsp;&nbsp;&nbsp;'.$c->local_name.'</option>';
    		}
    	}
    	$str .= '</select>';
    	echo  $str;
    }
    
    public function cateChildren($region_id) {
    	$regions = $this->dao->select('*')->from(TABLE_REGIONS)->where('p_region_id')->eq($region_id)->fetchAll();
    	return $regions;
    }
	
	public function getRandomString($length = 6, $type = 'string') {
		if ($type == 'string') {
			$init_string = "0123456789abcdefghijklmnopqrstuvwxyz";
		} else {
			$init_string = "0123456789";
		}
		
		$random_string = "";
		$start = 0;
		
		while ($start < $length) {
			$random_string .= $init_string[rand() % strlen($init_string)];
			$start++;
		}
		
		return $random_string;
	}
}