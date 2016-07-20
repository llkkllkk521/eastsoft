<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of tree module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class tree extends control
{
    const NEW_CHILD_COUNT        = 5;
    const WEICHAT_MAINMENU_COUNT = 3;
    const WEICHAT_SUBMENU_COUNT  = 5;

    /**
     * Browse the categories and print manage links.
     * 
     * @param  string $type 
     * @param  int    $root 
     * @access public
     * @return void
     */
    public function browse($type = 'article', $root = 0)
    {
        $isWechatMenu = treeModel::isWechatMenu($type);
        if($isWechatMenu)
        {
            $this->lang->tree             = $this->lang->wechatMenu;
            $this->lang->category         = $this->lang->wechatMenu;
            $this->lang->tree->menu       = $this->lang->wechat->menu;
            $this->lang->menuGroups->tree = 'wechat';
        }
        else
        {
            $this->tree->fixLang($type);
            $this->tree->fixMenu($type);
            if($type == 'express')
            {
                $this->lang->category->common = $this->lang->express->name;
                $this->lang->category->name   = $this->lang->express->name;
            }
        }

        $modelName  = class_exists('exttreeModel') ? 'exttreeModel' : 'treeModel';
        $userFunc   = $isWechatMenu ? array($modelName, 'createWechatMenuLink') : array($modelName, 'createManageLink');
        $this->view->treeMenu = $this->tree->getTreeMenu($type, 0, $userFunc);

        $this->view->title        = $this->lang->category->common;
        $this->view->type         = $type;
        $this->view->root         = $root;
        $this->view->children     = $this->tree->getChildren($root, $type);
        $this->view->isWechatMenu = $isWechatMenu;

        $this->display();
    }

    /**
     * Edit a category.
     * 
     * @param  int      $categoryID 
     * @access public
     * @return void
     */
    public function edit($categoryID)
    {
        /* Get current category. */
        $category = $this->tree->getById($categoryID);

        $this->tree->fixLang($category->type);
        $this->tree->fixMenu($category->type);

        if(!empty($_POST))
        {
            //保存分类下的相关属性开始
            foreach ($_POST['attr_id'] as $key => $attr_id) {
                $data = new stdClass();
                //有对应的 attr_id ，则做修改或者删除操作
                if ($attr_id) {
                    //有对应的值，则修改
                    if ($_POST['attr_name'][$key] !== '') {
                        
                        $data->category = $categoryID;
                        $data->name     = $_POST['attr_name'][$key];
                        $this->dao->update('es_product_attr')->data($data)
                            ->where('id')->eq($attr_id)->limit(1)->exec();
                    //没有对应的值，则修改该条信息状态为删除
                    }else{

                        $data->is_delete = 'y';
                        $this->dao->update('es_product_attr')->data($data)
                            ->where('id')->eq($attr_id)->limit(1)->exec();
                    }
                //没有对应的 attr_id ，则为新增
                }else{
                    //有对应的值，则新增一条
                    if ($_POST['attr_name'][$key] !== '') {
                        
                        $data->category = $categoryID;
                        $data->name     = $_POST['attr_name'][$key];
                        $this->dao->insert('es_product_attr')->data($data)->exec();
                    }
                }
            }

            //保存属性下面对应的详情
            foreach ($_POST['detail_id'] as $key => $detail_id) {
                $detail = new stdClass();
                //如果有详情的ID，则做修改或者删除操作
                if ($detail_id) {
                    //有对应的值，则修改
                    if ($_POST['detail_value'][$key] !== '') {
                        
                        $detail->attr  = $_POST['detail_attr'][$key];
                        $detail->value = $_POST['detail_value'][$key];
                        $this->dao->update('es_product_detail')->data($detail)
                            ->where('id')->eq($detail_id)->limit(1)->exec();
                    //没有对应的值，则修改该条信息状态为删除
                    }else{

                        $detail->is_delete = 'y';
                        $this->dao->update('es_product_detail')->data($detail)
                            ->where('id')->eq($detail_id)->limit(1)->exec();
                    }
                //如果没有ID，则做新增操作
                }else{

                    if ($_POST['detail_value'][$key] !== '') {

                        $detail->attr  = $_POST['detail_attr'][$key];
                        $detail->value = $_POST['detail_value'][$key];
                        $this->dao->insert('es_product_detail')->data($detail)->exec();
                    }
                }

            }

            //将传过来的属性部分的数据删除，否则在保存分类时会出错
            unset($_POST['attr_id']);
            unset($_POST['attr_name']);
            unset($_POST['detail_id']);
            unset($_POST['detail_attr']);
            unset($_POST['detail_value']);
            //保存分类下的相关属性结束

            $result = $this->tree->update($categoryID);
            if($result === true) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
            $this->send(array('result' => 'fail', 'message' => dao::isError() ? dao::getError() : $result));
        }

        /* Get option menu and remove the families of current category from it. */
        $optionMenu = $this->tree->getOptionMenu($category->type);
        $families   = $this->tree->getFamily($categoryID);
        foreach($families as $member) unset($optionMenu[$member]);

        $this->view->category   = $category;
        $this->view->optionMenu = $optionMenu;
        $this->view->aliasAddon = trim("http://" . $this->server->http_host . $this->config->webRoot, '/' ). '/';

        if(strpos('forum,blog', $category->type) !== false) $this->view->aliasAddon .=  $category->type . '/';

        $attr = $this->dao->select('*')->from('es_product_attr')
                ->where('category')->eq($categoryID)
                ->andWhere('is_delete')->eq('n')->fetchAll();

        foreach ($attr as $key => $value) {
            $attr[$key]->detail = $this->dao->select('*')->from('es_product_detail')
                                    ->where('attr')->eq($value->id)
                                    ->andWhere('is_delete')->eq('n')->fetchAll();
        }

        $this->view->attr = $attr;

        $this->display();
    }

    /**
     * Manage children.
     *
     * @param  string    $type 
     * @param  int       $category    the current category id.
     * @access public
     * @return void
     */
    public function children($type, $category = 0)
    {
        $this->tree->fixLang($type);
        if($type == 'forum')
        {
            $this->view->boardChildrenCount = $this->dao->select('count(*) as count')->from(TABLE_CATEGORY)->where('grade')->eq(2)->andWhere('type')->eq('forum')->fetch('count');
        }

        if($type == 'express')
        {
            $this->lang->category->common = $this->lang->express->name;
            $this->lang->category->name   = $this->lang->express->name;
        }

        $isWechatMenu = treeModel::isWechatMenu($type);
        if($isWechatMenu) $this->lang->category = $this->lang->wechatMenu;

        if(!empty($_POST))
        { 
            $result = $this->tree->manageChildren($type, $this->post->parent, $this->post->children);
            $locate = $this->inLink('browse', "type=$type&root={$this->post->parent}");
            if($result === true) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $locate));
            $this->send(array('result' => 'fail', 'message' => dao::isError() ? dao::getError() : $result));
        }
            
        $this->view->isWechatMenu  = $isWechatMenu;
        $this->view->title         = $this->lang->tree->manage;
        $this->view->type          = $type;
        $this->view->children      = $this->tree->getChildren($category, $type);
        $this->view->origins       = $this->tree->getOrigin($category);
        $this->view->parent        = $category;

        $this->display();
    }

    /**
     * Delete a category.
     * 
     * @param  int    $categoryID 
     * @access public
     * @return void
     */
    public function delete($categoryID)
    {
        /* If type is 'forum' and has children, warning. */
        $category = $this->tree->getByID($categoryID);
        $children = $this->tree->getChildren($categoryID, $category->type); 
        if($children) $this->send(array('result' => 'fail', 'message' => $this->lang->tree->hasChildren));
 
        if($this->tree->delete($categoryID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Redirect to tree browse when no categories
     * 
     * @param  string $message 
     * @access public
     * @return void
     */
    public function redirect($type = 'article', $message = '')
    {
        unset($this->lang->tree->menu);
        $this->view->message = ($message && $message != '') ? $message : $this->lang->tree->noCategories;
        $this->view->type    = $type;

        $this->display();
    }
}
