<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class block extends control
{
    /**
     * Browse blocks admin.
     * 
     * @access public
     * @return void
     */
    public function admin()
    {
        $template = $this->config->template->{$this->device}->name;
        $this->block->loadTemplateLang($template);

        $this->session->set('blockList', $this->app->getURI());

        $this->view->template = $template;
        $this->view->blocks   = $this->block->getList($template);
        $this->view->title    = $this->lang->block->common;
        $this->display();
    }

    /**
     * Pages admin list.
     * 
     * @access public
     * @return void
     */
    public function pages()
    {
        $template = $this->config->template->{$this->device}->name;
        $this->block->loadTemplateLang($template);

        $this->view->template = $template;
        $this->display();       
    }

    /**
     * Create a block.
     * 
     * @param  string $type    html|php
     * @access public
     * @return void
     */
    public function create($type = 'html')
    {
        $template = $this->config->template->{$this->device}->name;
        $theme    = $this->config->template->{$this->device}->theme;
        $this->block->loadTemplateLang($template);

        if($_POST)
        {
            if($type == 'phpcode' and !$this->loadModel('guarder')->verify()) $this->send(array('result' => 'fail', 'reason' => 'captcha', 'message' => dao::getError()));

            $blockID = $this->block->create($template, $theme);
            if(!dao::isError()) $this->send(array('result' => 'success', 'locate' => $this->inlink('admin'), 'blockID' => $blockID));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->type     = $type;
        $this->view->template = $template;
        $this->view->theme    = $theme;
        $this->display();
    }

    /**
     * Edit a block.
     * 
     * @param int      $blockID 
     * @param string   $type 
     * @access public
     * @return void
     */
    public function edit($blockID, $type = '')
    {
        $template = $this->config->template->{$this->device}->name;
        $theme    = $this->config->template->{$this->device}->theme;
        $this->block->loadTemplateLang($template);

        if(!$blockID) $this->locate($this->inlink('admin'));

        if($_POST)
        {
            if($this->post->type == 'phpcode' and !$this->loadModel('guarder')->verify()) $this->send(array('result' => 'fail', 'reason' => 'captcha', 'message' => dao::getError()));

            $this->block->update($template, $theme);
            if(!dao::isError()) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->template = $template;
        $this->view->theme    = $theme;
        $this->view->block    = $this->block->getByID($blockID);
        $this->view->type     = $this->get->type ? $this->get->type : $this->view->block->type;
        $this->display();
    }

    /**
     * Set the layouts of one region.
     * 
     * @param string   $page 
     * @param string   $region 
     * @access public
     * @return void
     */
    public function setRegion($page, $region)
    {
        $template = $this->config->template->{$this->device}->name;
        $theme    = $this->config->template->{$this->device}->theme;
        $this->block->loadTemplateLang($template);

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $result = $this->block->setRegion($page, $region, $template, $theme);

            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => inlink('pages')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $blocks = $this->block->getRegionBlocks($page, $region, $template, $theme);
        if(empty($blocks)) $blocks = array(new stdclass());

        $this->view->title        = "<i class='icon-cog'></i> " . $this->lang->block->setPage . ' - '. $this->lang->block->{$template}->pages[$page] . ' - ' . $this->lang->block->$template->regions->{$page}[$region];
        $this->view->modalWidth   = 900;
        $this->view->page         = $page;
        $this->view->region       = $region;
        $this->view->blocks       = $blocks;
        $this->view->blockOptions = $this->block->getPairs($template);
        $this->view->template     = $template; 

        $this->display();
    }

    /**
     * Delete a block from page region.
     * 
     * @param string $blockID 
     * @access public
     * @return void
     */
    public function delete($blockID)
    {
        $result = $this->block->delete($blockID);

        if($result)  $this->send(array('result' => 'success'));
        if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Show block form.
     * 
     * @param  string  $type 
     * @param  int     $id 
     * @access public
     * @return void
     */
    public function blockForm($type, $id = 0)
    {
        if($id > 0) $this->view->block = $this->block->getByID($id); 

        $this->view->type = $type;
        $this->display();
    }
}
