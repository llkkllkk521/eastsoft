<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of article module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class consulting extends control
{
    /** 
     * The index page, locate to the first category or home page if no category.
     * 
     * @access public
     * @return void
     */
    public function index() {   
    	$category = $this->loadModel('tree')->getByID(86, 'article');
    	$this->view->title       = '咨询';
    	$this->view->keywords    = $keywords;
    	$this->view->desc        = $desc;
    	$this->view->category   = $category;
    	//如果当前分类不是顶级分类，则寻找当前分类的顶级分类的ID
    	$this->view->top_id     = $this->loadModel('article')->getTop($category);
    	//获取当前分类的顶级分类下的子分类
    	$this->view->children   = $this->loadModel('article')->getChildren($this->view->top_id);
        $this->display();
    }
    
    /**
     * Browse article in admin.
     * 
     * @param string $type        the article type
     * @param int    $categoryID  the category id
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function admin($orderBy = '`id` desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
		
    	$recPerPage = $this->get->recPerPage ? $this->get->recPerPage : $this->config->consulting->recPerPage;
        $recTotal = $this->get->recTotal ? $this->get->recTotal : 0;
        $pageID = $this->get->pageID ? $this->get->pageID :  1;
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        
        $this->view->consultings   = $this->consulting->getList($orderBy, $pager);
        $this->view->recTotal = $recTotal;
        $this->view->recPerPage = $recPerPage;
        $this->view->pageID = $pageID;
        $this->view->pager      = $pager;
        $this->view->orderBy    = $orderBy;
        
        $this->display();
    }
    
    function getArea() {
    	$r = $this->consulting->getRegions($_POST['p_region_id']);
    	$str .= '<option value="">请选择</option>';
    	foreach($r AS $k => $v) {
    		$str .= '<option value="'.$k.'">'.$v.'</option>';
    	}
    	echo $str;
    	echo $_POST['p_region_id'];
    }

    /**
     * Create an contribution.
     * 
     * @param  string $type 
     * @param  int    $categoryID
     * @access public
     * @return void
     */
    public function post() {
        if($_POST) {
            $this->view->result = $this->consulting->create();
        }
        $category = $this->loadModel('tree')->getByID(86, 'article');
        $this->view->category   = $category;
        //如果当前分类不是顶级分类，则寻找当前分类的顶级分类的ID
        $this->view->top_id     = $this->loadModel('article')->getTop($category);
        //获取当前分类的顶级分类下的子分类
        $this->view->children   = $this->loadModel('article')->getChildren($this->view->top_id);
        $this->view->title = $this->lang->consulting->create;
        $this->display();
    }
    
    /**
     * Delete an article.
     * 
     * @param  int      $articleID 
     * @access public
     * @return void
     */
    public function delete($articleID)
    {
        if($this->consulting->delete($articleID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }
    
    public function dayin() {
    	$this->view->consulting = $this->consulting->getByID($this->get->consultingID);
    	$this->display();
    }
}
