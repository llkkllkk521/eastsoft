<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of package module of ChanZhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@xirangit.com>
 * @package     package
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class survey extends control
{
	
	public function __construct()
	{
		parent::__construct();
	}
	
    /**
     * Browse surveys.
     *
     * @param  string   $status
     * @access public
     * @return void
     */
    public function browse($status = 'installed')
    {
        $packages = $this->survey->getLocalPackages($status);
        $versions = array();
        if($packages and $status == 'installed')
        {
            /* Get latest release from remote. */
            $extCodes = helper::safe64Encode(join(',', array_keys($packages)));
            $results = $this->survey->getPackagesByAPI('bycode', $extCodes, $recTotal = 0, $recPerPage = 1000, $pageID = 1);
            if(isset($results->extensions))
            {
                $remoteReleases = $results->extensions;
                foreach($remoteReleases as $release)
                {
                    if(!isset($packages[$release->code])) continue;

                    $package = $packages[$release->code];
                    $package->viewLink = $release->viewLink;
                    if(isset($release->latestRelease) and $package->version != $release->latestRelease->releaseVersion and $this->package->checkVersion($release->latestRelease->chanzhiCompatible))
                    {
                        $upgradeLink = inlink('upgrade', "package=$release->code&downLink=" . helper::safe64Encode($release->latestRelease->downLink) . "&md5={$release->latestRelease->md5}&type=$release->type");
                        $upgradeLink = ($release->latestRelease->charge or !$release->latestRelease->public) ? $release->latestRelease->downLink : $upgradeLink;
                        $package->upgradeLink = $upgradeLink;
                    }
                }
            }
        }

        $this->view->title      = $this->lang->survey->browse;
        $this->view->position[] = $this->lang->survey->browse;
        $this->view->tab        = $status;
        $this->view->packages   = $packages;
        $this->view->versions   = $versions;
        $this->view->status     = $status;
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
    public function admin($status = 'survey_theme', $type = 'admin', $categoryID = 0, $orderBy = '`id` desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {
    
    	$this->app->loadClass('pager', $static = true);
    	$pager = new pager($recTotal, $recPerPage, $pageID);
    	$surveys = $this->survey->getList($status, $type, $families, $orderBy, $pager);
    	$this->view->type       = $type;
    	$this->view->categoryID = $categoryID;
    	$this->view->surveys   = $surveys;
    	$this->view->pager      = $pager;
    	$this->view->orderBy    = $orderBy;
    	$this->view->status     = $status;
    
    	$this->display();
    }
    
    /**
     * 调查类型
     * @param string $status
     * @param string $type
     * @param number $categoryID
     * @param string $orderBy
     * @param number $recTotal
     * @param number $recPerPage
     * @param number $pageID
     */
    public function surveytype($status = 'survey_theme', $type = 'admin', $categoryID = 0, $orderBy = '`id` desc', $recTotal = 0, $recPerPage = 20, $pageID = 1) {
    
    	$this->app->loadClass('pager', $static = true);
    	$pager = new pager($recTotal, $recPerPage, $pageID);
    	$surveys = $this->survey->getList($status, $type, $families, $orderBy, $pager);
    	$this->view->type       = $type;
    	$this->view->categoryID = $categoryID;
    	$this->view->surveys   = $surveys;
    	$this->view->pager      = $pager;
    	$this->view->orderBy    = $orderBy;
    	$this->view->status     = $this->get->status;
    
    	$this->display();
    }
    
    /**
     * 调查主题
     * @param string $status
     * @param string $type
     * @param number $categoryID
     * @param string $orderBy
     * @param number $recTotal
     * @param number $recPerPage
     * @param number $pageID
     */
    public function surveytheme($status = 'survey_theme', $type = 'admin', $categoryID = 0, $orderBy = '`id` desc', $recTotal = 0, $recPerPage = 20, $pageID = 1) {
    
    	$this->app->loadClass('pager', $static = true);
    	$pager = new pager($recTotal, $recPerPage, $pageID);
    	$surveys = $this->survey->getList($status, $type, $families, $orderBy, $pager);
    	$this->view->type       = $type;
    	$this->view->categoryID = $categoryID;
    	$this->view->surveys   = $surveys;
    	$this->view->pager      = $pager;
    	$this->view->orderBy    = $orderBy;
    	$this->view->status     = $this->get->status;
    
    	$this->display();
    }
    
    /**
     * 调查内容
     * @param string $status
     * @param string $type
     * @param number $categoryID
     * @param string $orderBy
     * @param number $recTotal
     * @param number $recPerPage
     * @param number $pageID
     */
    public function surveycontent($status = 'survey_theme', $type = 'admin', $categoryID = 0, $orderBy = '`id` desc', $recTotal = 0, $recPerPage = 20, $pageID = 1) {
    
    	$this->app->loadClass('pager', $static = true);
    	$pager = new pager($recTotal, $recPerPage, $pageID);
    	$surveys = $this->survey->getList($status, $type, $families, $orderBy, $pager);
    	$this->view->type       = $type;
    	$this->view->categoryID = $categoryID;
    	$this->view->surveys   = $surveys;
    	$this->view->pager      = $pager;
    	$this->view->orderBy    = $orderBy;
    	$this->view->status     = $this->get->status;
    	
    	$this->view->datebegin = $_POST['datebegin'];
    	$this->view->dateend = $_POST['dateend'];
    	$this->view->account = $_POST['user'];
    	$this->view->surveytype = $_POST['surveytype'];
    
    	$this->display();
    }
    
    /**
     * 创建调查
     */
    public function addsurvey() {
    	if($_POST) {
    		 $this->survey->create();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate'=>inlink('surveytype', "status=".$this->get->status)));
    	}
    	$this->view->status = $this->get->status;
    	$this->display();
    }
    
    /**
     * 编辑调查
     */
    public function editsurvey() {
    	if($_POST) {
    		$this->survey->editsurvey();
    		if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
    		$this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate'=>inlink('surveytype', "status=".$this->get->status)));
    	}
    	$this->view->survey = $this->survey->getSurvey();
    	$this->view->status = $this->get->status;
    	$this->display();
    }
    
    public function addtheme($status = 'survey_theme') {
    	$this->view->content_type = $this->survey->get_content_type();
    	$this->view->status     = $status;
    	$this->display();
    }
    
    public function edittheme($status = 'survey_theme') {
    	$this->view->sts = $this->survey->getThemeAllTitle();
    	$this->view->content_type = $this->survey->get_content_type();
    	$this->view->status     = $this->get->status;
    	$s = $this->survey->getSurvey();
    	$this->view->sid = $s->parent;
    	$this->view->stitle = $s->theme;
    	$this->display();
    }
    
    public function surveyContentEditPost() {
    	$this->survey->saveEditTheme();
    }
    
    public function surveyContentPost() {
    	$this->survey->saveTheme();
    }
    
    /**
     * 删除调查类型
     */
    public function surveyDel() {
    	$this->survey->surveyDelete();
    }

    /**
     * 删除调查内容
     */
    public function delSurveyContent() {
    	$this->survey->deleteSurveyContent();
    }
    
    /**
     * 导出调查
     */
    public function urveyContentExport() {
    	echo $this->survey->urveyContentExport();
    }
    
    /**
     * 查看调查内容
     */
    public function viewsurvey() {
    	$this->view->status = $this->get->status;
    	$this->view->contents = $this->survey->surveyView($this->get->sid);
    	$this->display();
    }

    /**
     * 点击导出
     */
    public function clickexportsurvey() {
        $this->view->status = $this->get->status;
        $this->view->exportinfo = $this->survey->clickExportSurvey($this->get->sid);
        $this->display();
    }
}
