<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of package module of ChanZhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@xirangit.com>
 * @package     package
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class surveyModel extends model {
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
	public function getList($table, $type, $categories, $orderBy, $pager = null)
	{
		
		switch($table) {
			case 'survey_type' :
				$_table = 'es_survey';
				break;
			case 'survey_theme' :
				$_table = 'es_survey';
				break;
			case 'survey_content' :
				$_table = 'es_survey_content';
				break;
			default:
				$_table = 'es_survey';
				break;
		}
		switch($type) {
			
		}
		
		if($table == 'survey_type') {
			$surveys = $this->dao->select('*')->from($_table)
			->where('parent')->eq(0)
			->orderBy($orderBy)
			->page($pager)
			->fetchAll();
		} elseif($table == 'survey_theme') {
			$orderBy = 'parent desc,theme desc';
			$surveys = $this->dao->select('*')->from($_table)
			->where('parent')->ne(0)
			->orderBy($orderBy)
			->page($pager)
			->fetchAll();
		} else {
			$user = $_POST['user'] ? ($_POST['user']=='a' ? '' : $_POST['user']) : '';;
			//$surveytype = $_POST['surveytype'] ? ($_POST['surveytype']=='a' ? '' : $_POST['surveytype']) : '';
			$datebegin = $_POST['datebegin'] ? $_POST['datebegin'].' 00:00:00' : '';
			$dateend = $_POST['dateend'] ? $_POST['dateend'].' 23:59:59' : '';
			
			if($user && $surveytype && $datebegin && $dateend) {
				$surveys = $this->dao->select('*')->from($_table)
				->Where('addedDate')->ge($datebegin)
				->andWhere('addedDate')->le($dateend)
				->andWhere('user_id')->eq($user)
				->andWhere('survey_id')->eq($surveytype)
				->groupBy('addedDate')
				->orderBy($orderBy)
				->page($pager)
				->fetchAll();
			} elseif($user && $surveytype && !$datebegin && !$dateend) {
				$surveys = $this->dao->select('*')->from($_table)
				->Where('user_id')->eq($user)
				->andWhere('survey_id')->eq($surveytype)
				->groupBy('addedDate')
				->orderBy($orderBy)
				->page($pager)
				->fetchAll();
			} elseif($user && !$surveytype && !$datebegin && !$dateend) {
				$surveys = $this->dao->select('*')->from($_table)
				->Where('user_id')->eq($user)
				->groupBy('addedDate')
				->orderBy($orderBy)
				->page($pager)
				->fetchAll();
			} elseif(!$user && $surveytype && !$datebegin && !$dateend) {
				$surveys = $this->dao->select('*')->from($_table)
				->Where('survey_id')->eq($surveytype)
				->groupBy('addedDate')
				->orderBy($orderBy)
				->page($pager)
				->fetchAll();
			} elseif(!$user && !$surveytype && $datebegin && $dateend) {
				$surveys = $this->dao->select('*')->from($_table)
				->Where('addedDate')->ge($datebegin)
				->andWhere('addedDate')->le($dateend)
				->groupBy('addedDate')
				->orderBy($orderBy)
				->page($pager)
				->fetchAll();
			} else {
				$surveys = $this->dao->select('*')->from($_table)
				->groupBy('addedDate')
				->orderBy($orderBy)
				->page($pager)
				->fetchAll();
			}
		}
		if(!$surveys) return array();
	
		return $surveys;
	}
	
    public function get_content_type($id) {
    	$survey_content_type = $this->dao->select('*')->from(TABLE_SURVEY_CONTENT_TYPE)->fetchAll();
    	$s = '<select name="content_type[]" class="survey-content-type" style="width:300px;">';
    	$s .= '<option value="">选择类型</option>';
    	foreach($survey_content_type AS $k => $v) {
    		if($v->title) {
    			$opt = explode('|', $v->title);
    			foreach($opt AS $_v) {
    				 $_opt .= $_v.'&nbsp;';
    			}
    		}
    		$s .= $id == $v->id ? '<option value="'.$v->id.'" selected="selected">'.$_opt.'</option>' : '<option value="'.$v->id.'">'.$_opt.'</option>';
    		$_opt = '';
    	}
    	$s .= '</select>';
    	return $s;
    }
    
    public function saveTheme() {
    	$data = $msg = array();
    	$data['parent'] = $this->post->st;//调查类型
    	$data['theme'] = $this->post->theme;//调查项目大类
    	$scw = explode(',', $this->post->scw);//权重
    	$sti = explode(',', $this->post->sti);//调查项目
    	$sc = explode(',', $this->post->sc);//调查项目内容
    	$sct = explode(',', $this->post->sct);//调查项目类型
    	$se = explode(',', $this->post->se);//意见或建议
    	$flag = false;
    	if(!$data['parent']) {
    		exit(json_encode(array('result' => 'fail', 'message' => $this->lang->survey->selectSurveyType)));
    	}
    	if(!$data['theme']) {
    		exit(json_encode(array('result' => 'fail', 'message' => $this->lang->survey->title)));
    	}
    	if(!$this->post->sc || !$this->post->sct) {
    		exit(json_encode(array('result' => 'fail', 'message' => $this->lang->survey->content)));
    	}
    	$arrm = 0;
    	foreach($sti AS $k => $v) {
    		if(empty($v) || empty($sct[$k])) {
    			$arrm += 1;
    		}
    	}
    	if($arrm) {
    		exit(json_encode(array('result' => 'fail', 'message' => $this->lang->survey->content)));
    	}
    	foreach($scw AS $k => $v) {
    		$data['weight'] = $v;
    		$data['title'] = $sti[$k];
    		$data['content'] = $sc[$k];
    		$data['type'] = $sct[$k];
    		$data['explain'] = $se[$k];
    		$theme = $this->dao->select('*')->from(TABLE_SURVEY)
    		->where('theme')->eq($data['theme'])
    		->andWhere('title')->eq($data['title'])
    		->andWhere('content')->eq($data['content'])
    		->andWhere('type')->eq($data['type'])
    		->fetch();
    		if(!$theme && $data['title'] && $data['type']) {
    			$this->dao->insert(TABLE_SURVEY)->data($data)->exec();
    			if(dao::isError()) {
    				exit(json_encode(array('result' => 'fail', 'message' => dao::isError())));
    			}
    		}
    	}
    	exit(json_encode(array('result' => 'success', 'message' => $this->lang->survey->saveSuccess, 'locate'=>inlink('surveytheme', "status=survey_theme"))));
    }
    
    public function saveEditTheme() {
    	$data = $msg = array();
    	$data['parent'] = $this->post->st;//调查类型
    	$data['theme'] = $this->post->theme;//调查项目大类
    	$scw = explode(',', $this->post->scw);//权重
    	$sti = explode(',', $this->post->sti);//调查项目
    	$sc = explode(',', $this->post->sc);//调查项目内容
    	$sct = explode(',', $this->post->sct);//调查项目类型
    	$se = explode(',', $this->post->se);//意见或建议
    	$flag = false;
    	if(!$data['parent']) {
    		exit(json_encode(array('result' => 'fail', 'message' => $this->lang->survey->selectSurveyType)));
    	}
    	if(!$data['theme']) {
    		exit(json_encode(array('result' => 'fail', 'message' => $this->lang->survey->title.$this->post->theme)));
    	}
    	if(!$this->post->sc || !$this->post->sct) {
    		exit(json_encode(array('result' => 'fail', 'message' => $this->lang->survey->content)));
    	}
    	$arrm = 0;
    	foreach($sti AS $k => $v) {
    		if(empty($v) || empty($sct[$k])) {
    			$arrm += 1;
    		}
    	}
    	if($arrm) {
    		exit(json_encode(array('result' => 'fail', 'message' => $this->lang->survey->content)));
    	}
    	foreach($scw AS $k => $v) {
    		$data['weight'] = $v;
    		if(strpos($sti[$k], '&') !== false) {
    			$_sti = explode('&', $sti[$k]);
    			$data['title'] = $_sti[0];
    		} else {
    			$data['title'] = $sti[$k];
    		}
    		$data['content'] = $sc[$k];
    		$data['type'] = $sct[$k];
    		$data['explain'] = $se[$k];
    		$theme = $this->dao->select('*')->from(TABLE_SURVEY)
    		->where('theme')->eq($data['theme'])
    		->andWhere('title')->eq($data['title'])
    		->andWhere('content')->eq($data['content'])
    		->andWhere('type')->eq($data['type'])
    		->fetch();
    		if(isset($_sti[1]) && $_sti[1]) {
    			$this->dao->update(TABLE_SURVEY)->data($data)
    			->where('id')->eq($_sti[1])
    			->exec();
    			if(dao::isError()) {
    				exit(json_encode(array('result' => 'fail', 'message' => dao::isError())));
    			}
    		} else {
    			if(!$theme && $data['title'] && $data['type']) {
    				$this->dao->insert(TABLE_SURVEY)->data($data)->exec();
    				if(dao::isError()) {
    					exit(json_encode(array('result' => 'fail', 'message' => dao::isError())));
    				}
    			}
    		}
    		unset($_sti);
    	}
    	exit(json_encode(array('result' => 'success', 'message' => $this->lang->survey->saveSuccess, 'locate'=>inlink('surveytheme', "status=survey_theme"))));
    }
    
    public function getThemeType($id) {
    	$tts = $this->dao->select('*')->from(TABLE_SURVEY)
    	->where('parent')->eq(0)
    	->fetchAll();
    	/* $sel = '<select name="surveytype" class="survey-type" style="width:150px;">';
    	$sel .= '<option value="">请选择调查类型</option>';
    	foreach($tts AS $value) {
    		$sel .= $id == $value->id ? '<option value="'.$value->id.'" selected="selected">'.$value->title.'</option>' : '<option value="'.$value->id.'">'.$value->title.'</option>';
    	}
    	$sel .= '</select>'; */
    	$_tts['a'] = '请选择';
    	foreach($tts AS $v) {
    		$_tts[$v->id] = $v->title;
    	}
    	return $_tts;
    }
    
    public function getThemeAllTitle() {
    	if($this->get->id) {
    		$s = $this->dao->select('*')->from(TABLE_SURVEY)
    		->where('id')->eq($this->get->id)
    		->fetch();
    	}
    	if($s) {
    		$ss = $this->dao->select('*')->from(TABLE_SURVEY)
    		->where('parent')->eq($s->parent)
    		->andWhere('theme')->eq($s->theme)
    		->fetchAll();
    		return $ss;
    	}
    }
    
    public function getSurvey($sid) {
    	$sid = $this->get->id ? $this->get->id : $sid;
    	if($sid) {
    		$s = $this->dao->select('*')->from(TABLE_SURVEY)
    		->where('id')->eq($sid)
    		->fetch();
    		return $s;
    	}
    }
    
    /**
     * 删除调查
     */
    public function surveyDelete() {
    	$this->dao->delete()->from(TABLE_SURVEY)->where('id')->eq($this->post->sid)->exec();
    	if(dao::isError()) {
    		echo json_encode(array('result' => 'fail', 'message' => dao::isError()));
    	}
    	echo json_encode(array('result' => 'success', 'message' => $this->lang->survey->surveydel, 'locate'=>inlink('surveytheme', "status=survey_theme")));
    }
    
    /**
     * 获取调查内容类型
     * @param unknown $sid
     */
    public function getSurveyContentType($sctid) {
    	$sctid = $this->get->sctid ? $this->get->sctid : $sctid;
    	if($sctid) {
    		$sct = $this->dao->select('*')->from(TABLE_SURVEY_CONTENT_TYPE)
    		->where('id')->eq($sctid)
    		->fetch();
    		return $sct;
    	}
    }
    
    /**
     * 创建调查
     * @return boolean|unknown
     */
    public function create() {
    	$now = helper::now();
    	$survey = $_POST;
    	$survey['addedDate'] = $now;
    	unset($survey['uid']);
    	$this->dao->insert(TABLE_SURVEY)
    	->data($survey)
    	->exec();
    	$surveyID = $this->dao->lastInsertID();
    
    	if(dao::isError()) return false;
    
    	return $surveyID;
    }
    
    public function editsurvey() {
    	$now = helper::now();
    	$survey = $_POST;
    	unset($survey['uid']);
    	$this->dao->update(TABLE_SURVEY)
    	->data($survey)
    	->where('id')->eq($this->get->id)
    	->exec();
    	
    	if(dao::isError()) return false;
    	
    	return true;
    }
    
    /**
     * 获取会员信息
     * @param unknown $uid
     * @return unknown
     */
    public function getUserInfo($uid) {
    	$user = $this->dao->select('account')->from(TABLE_USER)
    	->where('id')->eq($uid)
    	->fetch();
    	return $user;
    }
    
    /**
     * 获取全部会员信息
     * @return unknown
     */
    public function getUserAll() {
    	$users = $this->dao->select('id, account')->from(TABLE_USER)
    	->where('admin')->ne('super')
    	->fetchAll();
    	$_users['a'] = '请选择会员';
    	foreach($users AS $v) {
    		$_users[$v->id] = $v->account;
    	}
    	return $_users;
    }
    
    public function deleteSurveyContent() {
    	$datebegin = $this->post->datebegin ? $this->post->datebegin.' 00:00:00' : '';
    	$dateend = $this->post->dateend ? $this->post->dateend.' 23:59:59' : '';
    	
    	// || !$this->post->st
    	$this->post->uid = $this->post->uid == 'a' ? '' : $this->post->uid;
    	/* if(!$this->post->uid) {
    		exit(json_encode(array('result' => 'fail', 'message' => '请选择会员！')));
    	} */
    	if($this->post->uid || ($datebegin && $dateend)) {
    		if($this->post->uid && $this->post->datebegin && $this->post->dateend) {
    			$scs = $this->dao->select('*')->from(TABLE_SURVEY_CONTENT)
    			->where('user_id')->eq($this->post->uid)
    			->andWhere('addedDate')->ge($datebegin)
    			->andWhere('addedDate')->le($dateend)
    			->fetchAll();
    		} elseif($this->post->uid && !$datebegin && !$dateend) {
    			$scs = $this->dao->select('*')->from(TABLE_SURVEY_CONTENT)
    			->where('user_id')->eq($this->post->uid)
    			->fetchAll();
    		} elseif(!$this->post->uid && $datebegin && $dateend) {
    			$scs = $this->dao->select('*')->from(TABLE_SURVEY_CONTENT)
    			->Where('addedDate')->ge($datebegin)
    			->andWhere('addedDate')->le($dateend)
    			->fetchAll();
    		}
    		
    		foreach($scs AS $value) {
    			//$st = $this->getSurvey($value->survey_id);
    			//if($this->post->st == $st->parent) {
    				$this->dao->delete()->from(TABLE_SURVEY_CONTENT)->where('id')->eq($value->id)->exec();
    			//}
    		}
    	}
    	if(dao::isError()) {
    		echo json_encode(array('result' => 'fail', 'message' => dao::isError()));
    	}
    	if($scs) {
    		echo json_encode(array('result' => 'success', 'message' => $this->lang->survey->surveydel, 'locate'=>inlink('surveycontent', "status=survey_content")));
    	} else {
    		echo json_encode(array('result' => 'fail', 'message' => '没有要删除的数据！'));
    	}
    	
    }
    
    
    public function urveyContentExport() {
    	require_once dirname(__FILE__) . '/PHPExcel/PHPExcel.php';
    	
    	$objPHPExcel = new PHPExcel();
    	
    	$objPHPExcel->getActiveSheet()->setCellValue('A1', '会员');
    	$objPHPExcel->getActiveSheet()->setCellValue('B1', '调查类型');
    	$objPHPExcel->getActiveSheet()->setCellValue('C1', '项目大类');
    	$objPHPExcel->getActiveSheet()->setCellValue('D1', '标题');
    	$objPHPExcel->getActiveSheet()->setCellValue('E1', '选择答案');
    	$objPHPExcel->getActiveSheet()->setCellValue('F1', '评分');
    	$objPHPExcel->getActiveSheet()->setCellValue('G1', '输入答案');
    	$objPHPExcel->getActiveSheet()->setCellValue('H1', '时间');
    	
    	$user = $_POST['uid'] ? ($_POST['uid']=='a' ? '' : $_POST['uid']) : '';
    	//$surveytype = $_POST['st'] ? ($_POST['st']=='a' ? '' : $_POST['st']) : '';;
    	$datebegin = $_POST['datebegin'] ? $_POST['datebegin'].' 00:00:00' : '';
    	$dateend = $_POST['dateend'] ? $_POST['dateend'].' 23:59:59' : '';
    	
    	if($user && $surveytype && $datebegin && $dateend) {
    		$where = 'WHERE user_id='.$user.' AND  survey_id='.$surveytype.' AND addedDate>="'.$datebegin.'" AND addedDate<="'.$dateend.'" GROUP BY addedDate';
    		$rs = $this->dbh->query("SELECT * FROM ".TABLE_SURVEY_CONTENT." $where");
    		$surveys = $rs->fetchAll(PDO::FETCH_ASSOC);
    	} elseif($user && $surveytype && !$datebegin && !$dateend) {
    		$where = 'WHERE user_id='.$user.' AND  survey_id='.$surveytype.' GROUP BY addedDate';
    		$rs = $this->dbh->query("SELECT * FROM ".TABLE_SURVEY_CONTENT." $where");
    		$surveys = $rs->fetchAll(PDO::FETCH_ASSOC);
    	} elseif($user && !$surveytype && !$datebegin && !$dateend) {
    		$where = 'WHERE user_id='.$user.' GROUP BY addedDate';
    		$rs = $this->dbh->query("SELECT * FROM ".TABLE_SURVEY_CONTENT." $where");
    		$surveys = $rs->fetchAll(PDO::FETCH_ASSOC);
    	} elseif(!$user && $surveytype && !$datebegin && !$dateend) {
    		$where = 'WHERE survey_id='.$surveytype.' GROUP BY addedDate';
    		$rs = $this->dbh->query("SELECT * FROM ".TABLE_SURVEY_CONTENT." $where");
    		$surveys = $rs->fetchAll(PDO::FETCH_ASSOC);
    	} elseif(!$user && !$surveytype && $datebegin && $dateend) {
    		$where = 'WHERE addedDate>="'.$datebegin.'" AND addedDate<="'.$dateend.'" GROUP BY addedDate';
    		$rs = $this->dbh->query("SELECT * FROM ".TABLE_SURVEY_CONTENT." $where");
    		$surveys = $rs->fetchAll(PDO::FETCH_ASSOC);
    	} else {
    		$where = ' GROUP BY addedDate';
    		$rs = $this->dbh->query("SELECT * FROM ".TABLE_SURVEY_CONTENT." $where");
    		$surveys = $rs->fetchAll(PDO::FETCH_ASSOC);
    	}
    	if($surveys) {
    		$j = 1;
    		foreach($surveys AS $v) {
    			$_surveys = $this->dao->select('*')->from(TABLE_SURVEY_CONTENT)
    			->Where('addedDate')->eq($v['addedDate'])
    			->fetchAll();
    			
    			if($_surveys) {
    				$i = 2;
    				foreach($_surveys AS $_v) {
    					$survey = $this->dao->select('*')->from(TABLE_SURVEY)
    					->Where('id')->eq($_v->survey_id)
    					->fetch();
    					
    					$_survey = $this->dao->select('*')->from(TABLE_SURVEY)
    					->Where('id')->eq($survey->parent)
    					->fetch();
    					
    					$account = $this->dao->select('*')->from(TABLE_USER)
    					->Where('id')->eq($_v->user_id)
    					->fetch();
    					
    					$title = $_survey->title;
    					$_user = $account->account;
    					$date = $_v->addedDate;
    					$content_arr = explode('|', $_v->content);
    					$content_str = implode(',', $content_arr);
    					
    					$objPHPExcel->getActiveSheet()->setCellValue('A' . $i, $account->account);
    					$objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $_survey->title);
    					$objPHPExcel->getActiveSheet()->setCellValue('C' . $i, $survey->theme);
    					$objPHPExcel->getActiveSheet()->setCellValue('D' . $i, $survey->title);
    					$objPHPExcel->getActiveSheet()->setCellValue('E' . $i, $_v->value);
    					$objPHPExcel->getActiveSheet()->setCellValue('F' . $i, $this->get_evaluate($_v->value));
    					$objPHPExcel->getActiveSheet()->setCellValue('G' . $i, $content_str);
    					$objPHPExcel->getActiveSheet()->setCellValue('H' . $i, $date);
    					$i++;
    					
    				}
    				
    				$outputFileName = 'survey'.time().$j.'.xls';
    				$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
					$objWriter->save(str_replace('.php', $outputFileName, __FILE__));
					
					$datauplode = explode('system', dirname(__FILE__));
					
					if(rename(dirname(__FILE__).'/model'.$outputFileName, $datauplode[0].'www/data/upload/excel/'.$outputFileName)) {
						$url .= '<a href="data/upload/excel/'.$outputFileName.'" alt="点击下载" title="点击下载">'.$title.'-'.$_user.'-'.$date.'-'.$outputFileName.'</a><br>';
					}
    				
					$title = $_user = $date = '';
    			}
    			$j++;
    		}
    	}
    	
    	if($url) {
    		return json_encode(array('result' => 'success', 'message' => $url));
    	} else {
    		return json_encode(array('result' => 'fail', 'message' => '导出失败！'));
    	}
    }
    
    public function get_evaluate($value) {
    	$surveys_type = $this->dao->select('*')->from(TABLE_SURVEY_CONTENT_TYPE)
    	->orderBy('id ASC')
    	->fetchAll();
    	$grade = array(5,4,3,2,1);
    	foreach($surveys_type AS $v) {
    		$ta = explode('|', $v->title);
    		if(in_array($value, $ta)) {
    			return $grade[array_search($value, $ta)];
    		}
    	}
    }
    
    public function surveyView($survey_id) {
    	$content = array();
    	if($survey_id) {
    		$survey = $this->dao->select('*')->from(TABLE_SURVEY_CONTENT)
    		->Where('id')->eq($survey_id)
    		->fetch();
    		 
    		$surveys = $this->dao->select('*')->from(TABLE_SURVEY_CONTENT)
    		->Where('addedDate')->eq($survey->addedDate)
    		->orderBy('id ASC')
    		->fetchAll();
    		 if($surveys) {
    		 	foreach($surveys AS $_v) {
    		 		$survey = $this->dao->select('*')->from(TABLE_SURVEY)
    		 		->Where('id')->eq($_v->survey_id)
    		 		->fetch();
    		 	
    		 		$_survey = $this->dao->select('*')->from(TABLE_SURVEY)
    		 		->Where('id')->eq($survey->parent)
    		 		->fetch();
    		 	
    		 		$account = $this->dao->select('*')->from(TABLE_USER)
    		 		->Where('id')->eq($_v->user_id)
    		 		->fetch();
    		 	
    		 		$content[] = array($account->account, $_survey->title, $survey->theme, $survey->title, $_v->value, $this->get_evaluate($_v->value), $_v->content, $_v->addedDate);
    		 	}
    		 }
    	}
    	
    	
    	return $content;
    }
}
