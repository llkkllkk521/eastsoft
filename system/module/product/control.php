<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of product module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class product extends control
{

    public function __construct()
    {
        parent::__construct();
        if(RUN_MODE == 'admin')
        {
            $this->view->treeModuleMenu = $this->loadModel('tree')->getTreeMenu('product', 0, array('treeModel', 'createAdminLink'));
            $this->view->treeManageLink = html::a(helper::createLink('product', 'setting'), $this->lang->product->setting, "data-toggle='modal'");
            $this->view->treeManageLink .=   '&nbsp;&nbsp;' . html::a(helper::createLink('tree', 'browse', "type=product"), $this->lang->tree->manage);
        }
    }

    /**
     * Index page of product module.
     * 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function index($pageID = 1)
    {
        /* Display browse page. */
        $this->locate($this->inlink('browse', "categoryID=0&pageID={$pageID}"));
    }

    /** 
     * Browse product in front.
     * 
     * @param int    $categoryID   the category id
     * @param int    $pageID       current page id
     * @access public
     * @return void
     */
    public function browse($categoryID = 0, $pageID = 1)
    {  
        $category = $this->loadModel('tree')->getByID($categoryID, 'product');

        if($category && $category->link) helper::header301($category->link);

        $recPerPage = !empty($this->config->site->productRec) ? $this->config->site->productRec : $this->config->product->recPerPage;
        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, $recPerPage, $pageID);

        $categoryID = is_numeric($categoryID) ? $categoryID : $category->id;
        $products   = $this->product->getList($this->tree->getFamily($categoryID, 'product'), '`order` desc');

        if(!$category and $categoryID != 0) die($this->fetch('error', 'index'));

        if($categoryID == 0)
        {
            $category = new stdclass();
            $category->id       = 0;
            $category->name     = $this->lang->product->home;
            $category->alias    = '';
            $category->keywords = '';
            $category->desc     = '';
        }

        $title    = $category->name;
        $keywords = trim($category->keywords . ' ' . $this->config->site->keywords);
        $desc     = strip_tags($category->desc) . ' ';
        $this->session->set('productCategory', $category->id);

        $this->view->title      = $title;
        $this->view->keywords   = $keywords;
        $this->view->desc       = $desc;
        $this->view->category   = $category;
        $this->view->products   = $products;
        $this->view->pager      = $pager;
        $this->view->contact    = $this->loadModel('company')->getContact();
        $this->view->mobileURL  = helper::createLink('product', 'browse', "categoryID=$categoryID&pageID=$pageID", "category=$category->alias", 'mhtml');
        $this->view->desktopURL = helper::createLink('product', 'browse', "categoryID=$categoryID&pageID=$pageID", "category=$category->alias", 'html');

        //如果当前分类不是顶级分类，则寻找当前分类的顶级分类的ID
        $top_id = $this->product->getTop($category);

        $this->view->top_id     = $top_id;
        //获取当前分类的顶级分类下的子分类
        $this->view->children   = $this->product->getChildren($top_id);
        //获取分类下面的自定义属性
        $this->view->attr       = $this->dao->select('*')->from('es_product_attr')
                                    ->where('category')->eq($categoryID)
                                    ->andWhere('is_delete')->eq('n')
                                    ->limit(6)
                                    ->fetchAll();

        $this->display();
    }

    /**
     * [browse 点击 show-all， 新打开一个标签页，显示分类下的所有产品表格]
     * @AuthorName
     * @DateTime   2016-03-02T13:26:36+0800
     * @param      integer $categoryID [description]
     * @param      integer $pageID [description]
     * @return     [type] [description]
     */
    public function showall($categoryID = 0, $pageID = 1)
    {

        $category = $this->loadModel('tree')->getByID($categoryID, 'product');

        if($category && $category->link) helper::header301($category->link);

        $recPerPage = !empty($this->config->site->productRec) ? $this->config->site->productRec : $this->config->product->recPerPage;
        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, $recPerPage, $pageID);

        $categoryID = is_numeric($categoryID) ? $categoryID : $category->id;
        $products   = $this->product->getList($this->tree->getFamily($categoryID, 'product'), '`order` desc');

        if ($_POST) {
            //$_POST = array('attr_id' => detail_id)
            //如果有搜索的值  detail_id ！= 0
            foreach ($_POST as $key => $value) {
                //如果有搜索的值
                if ($value) {

                    foreach ($products as $k => $pd) {
                        $is_retain = $this->dao->select('*')->from('es_product_custom')
                                        ->where('product')->eq($pd->id)
                                        ->andWhere('value')->eq($value)
                                        ->fetch();

                        if (!$is_retain) {
                            unset($products[$k]);
                        }
                    }

                    $detail_value = $this->dao->select('value')->from('es_product_detail')
                                    ->where("id='" . $value . "'")->fetch();

                    $_POST[$key] = array('id' => $value, 'detail_value' => $detail_value->value);

                }

            }
            
        }


        $this->view->filter     = isset($_POST) ? $_POST : array();
        $this->view->products   = $products;
        $this->view->attr       = $this->dao->select('*')->from('es_product_attr')
                                    ->where('category')->eq($categoryID)
                                    ->andWhere('is_delete')->eq('n')
                                    ->fetchAll();

        $this->display();
    }

    /**
     * Browse product in admin.
     * 
     * @param int    $categoryID  the category id
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function admin($categoryID = 0, $orderBy = '`order` desc', $recTotal = 0, $recPerPage = 20, $pageID = 1)
    {   
        /* Set the session. */
        $this->session->set('productList', $this->app->getURI(true));

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        
        $families = '';
        if($categoryID) $families = $this->loadModel('tree')->getFamily($categoryID, 'product');
        $products = $this->product->getList($families, $orderBy, $pager);

        $this->view->title          = $this->lang->product->admin;
        $this->view->products       = $products;
        $this->view->pager          = $pager;
        $this->view->categoryID     = $categoryID;
        $this->view->orderBy        = $orderBy;
        $this->display();
    }   

    /**
     * Create a product.
     * 
     * @param int    $categoryID  
     * @access public
     * @return void
     */
    public function create($categoryID = '')
    {
        $categories = $this->loadModel('tree')->getOptionMenu('product', 0, $removeRoot = true);
        if(empty($categories))
        {
            die(js::locate($this->createLink('tree', 'redirect', 'type=product')));
        }

        if($_POST)
        {
            $productID = $this->product->create();       
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate'=>inlink('admin')));
        }

        $maxID = $this->dao->select('max(id) as maxID')->from(TABLE_PRODUCT)->fetch('maxID');

        if($categoryID) $this->view->currentCategory = $this->tree->getByID($categoryID, 'product');

        $this->view->title      = $this->lang->product->create;
        $this->view->categoryID = $categoryID;
        $this->view->categories = $categories;
        $this->view->order      = $maxID + 1;
        $this->display();
    }

    /**
     * Edit a product.
     * 
     * @param  int $productID 
     * @access public
     * @return void
     */
    public function edit($productID)
    {
        $categories = $this->loadModel('tree')->getOptionMenu('product', 0, $removeRoot = true);
        if(empty($categories))
        {
            die(js::alert($this->lang->tree->noCategories) . js::locate($this->createLink('tree', 'browse', 'type=product')));
        }

        if($_POST)
        {

            if ($productID) {
                //首先删除产品对应的全部属性
                $this->dao->delete()->from('es_product_custom')->where('product')->eq($productID)->exec();
                //给产品添加自定义属性
                foreach ($_POST as $key => $value) {
                    //属性数组中，包含属性ID的格式是  value- 加 数字
                    if (preg_match('/^value-(\d+)$/', $key, $matches)) {

                        foreach ($value as $v) {

                            $this->dao->insert('es_product_custom')
                            ->set('product')->eq($productID)
                            ->set('label')->eq($matches[1])
                            ->set('value')->eq($v)
                            ->set('order')->eq(0)
                            ->exec();
                        }
                    }
                }
            }
            
            $this->product->update($productID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
        }

        $product = $this->product->getByID($productID);

        if(empty($product->attributes))
        {
            $attribute = new stdclass();
            $attribute->order = 0;
            $attribute->label = '';
            $attribute->value = '';

            $product->attributes = array($attribute);
        }

        $this->view->title      = $this->lang->product->edit;
        $this->view->product    = $product;
        $this->view->categories = $categories;

        foreach ($product->categories as $value) {
            $category = $value->id;
        }

        $attr = $this->dao->select('*')->from('es_product_attr')
                ->where('category')->eq($category)
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
     * Change status 
     * 
     * @param  int    $productID 
     * @param  string $status 
     * @access public
     * @return void
     */
    public function changeStatus($productID, $status)
    {
        $this->dao->update(TABLE_PRODUCT)->set('status')->eq($status)->where('id')->eq($productID)->exec();

        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'locate' => $this->server->http_referer));
    }

    /**
     * View a product.
     * 
     * @param int $productID 
     * @access public
     * @return void
     */
    public function view($productID)
    {
        $product = $this->product->getByID($productID);
        if(!$product) die($this->fetch('error', 'index'));

        /* fetch first category for display. */
        $category = array_slice($product->categories, 0, 1);
        $category = $category[0]->id;

        $currentCategory = $this->session->productCategory;
        if($currentCategory > 0)
        {
            if(isset($product->categories[$currentCategory]))
            {
                $category = $currentCategory;  
            }
            else
            {
                foreach($product->categories as $productCategory)
                {
                    if(strpos($productCategory->path, $currentCategory)) $category = $productCategory->id;
                }
            }
        }
        $category = $this->loadModel('tree')->getByID($category, 'product');

        $title    = $product->name . ' - ' . $category->name;
        $keywords = $product->keywords . ' ' . $category->keywords . ' ' . $this->config->site->keywords;
        $desc     = strip_tags($product->desc);
        
        $this->view->title       = $title;
        $this->view->keywords    = $keywords;
        $this->view->desc        = $desc;
        $this->view->product     = $product;
        $this->view->prevAndNext = $this->product->getPrevAndNext($product->order, $category->id);
        $this->view->category    = $category;
        $this->view->contact     = $this->loadModel('company')->getContact();
        $this->view->stockOpened = isset($this->config->product->stock) && $this->config->product->stock == 1;
        $this->view->mobileURL   = helper::createLink('product', 'view', "productID=$productID", "category=$category->alias&name=$product->alias", 'mhtml');
        $this->view->desktopURL  = helper::createLink('product', 'view', "productID=$productID", "category=$category->alias&name=$product->alias", 'html');

        $this->dao->update(TABLE_PRODUCT)->set('views = views + 1')->where('id')->eq($productID)->exec();

        //如果当前分类不是顶级分类，则寻找当前分类的顶级分类的ID
        $top_id = $this->product->getTop($category);

        $this->view->top_id     = $top_id;
        //获取当前分类的顶级分类下的子分类
        $this->view->children   = $this->product->getChildren($top_id);
        //获取所有 文档下载 的二级分类
        $document   = $this->dao->select('t1.*, t2.*, t3.*, t4.*')->from('es_category')->alias('t1')
                    ->leftJoin('es_relation')->alias('t2')->on('t1.id = t2.category')
                    ->leftJoin('es_article_product')->alias('t3')->on('t2.id = t3.article')
                    ->leftJoin('es_article')->alias('t4')->on('t4.id = t3.article')
                    ->where('t1.parent')->eq(55)
                    ->andWhere('t3.product')->like('%"' . $product->id . '"%')
                    ->fetchAll();
        
        $document_article   = array();

        foreach ($document as $value) {
            $document_article[$value->name][] = $value->id;
        }

        $this->view->document_article = $document_article;

        //获取 应用于解决方案 下面的文章
        $linked__docuemnt   = $this->dao->select('t1.*, t2.*, t3.*, t4.*')->from('es_category')->alias('t1')
                ->leftJoin('es_relation')->alias('t2')->on('t1.id = t2.category')
                ->leftJoin('es_article_product')->alias('t3')->on('t2.id = t3.article')
                ->leftJoin('es_article')->alias('t4')->on('t4.id = t3.article')
                ->where('t1.path')->like(",2,%")
                ->andWhere('t3.product')->like('%"' . $product->id . '"%')
                ->fetchAll();

        $linked_docuemnt_article = array();

        foreach ($linked__docuemnt as $value) {
            $linked_docuemnt_article[$value->name][] = $value->id;
        }

        //获取产品关联的应用与解决方案下面的文章ID，开始
        $linked_article = array();

        foreach ($linked_docuemnt_article as $value) {
            foreach ($value as $v) {
                $linked_article[] = $v;
            }
        }

        $this->view->linked_article = $this->dao->select('id,title')->from('es_article')
                                    ->where('id')->in(implode(',', array_slice($linked_article, 0,4)))
                                    ->fetchAll();
        //获取产品关联的应用与解决方案下面的文章ID，结束

        $develop    = $this->dao->select('t1.*, t2.*, t3.*')->from('es_article_product')->alias('t1')
                    ->leftJoin('es_relation')->alias('t2')->on('t1.article = t2.id')
                    ->leftJoin('es_category')->alias('t3')->on('t3.id = t2.category')
                    ->where('t1.product')->like('%"' . $product->id . '"%')
                    ->andWhere('t3.path')->like(',3,%')
                    ->fetchAll();

        $develop_ids = array();

        foreach ($develop as $value) {
            $develop_ids[] = $value->article;
        }

        $this->view->develop_ids = implode(',', $develop_ids);
        //获取开发工具部分的数据
        $deve_data   = $this->dao->select('*')->from('es_product_attr')
                                ->where('category')->eq(53)
                                ->andWhere('name')->eq($product->name)
                                ->andWhere('is_delete')->eq('n')
                                ->fetchAll();

        foreach ($deve_data as $key => $value) {
            $deve_data[$key]->detail = $this->dao->select('*')->from('es_product_detail')
                                        ->where('attr')->eq($value->id)
                                        ->andWhere('is_delete')->eq('n')
                                        ->fetchAll();
        }

        $new_data = array();

        foreach ($deve_data as $value) {
            $new_data[$value->name][] = $value->detail;
        }

        $this->view->deve_data = $new_data;

        $this->display();
    }

    /**
     * Delete a product.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function delete($productID)
    {
        if($this->product->delete($productID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Set css.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function setCss($productID)
    {
        if($_POST)
        {
            if($this->product->setCss($productID)) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title   = $this->lang->product->css;
        $this->view->product = $this->product->getByID($productID);
        $this->display();
    }


    /**
     * Set js.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function setJs($productID)
    {
        if($_POST)
        {
            if($this->product->setJs($productID)) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title   = $this->lang->product->js;
        $this->view->product = $this->product->getByID($productID);
        $this->display();
    }

    /**
     * Redirect mall of product.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function redirect($productID)
    {
        $product = $this->product->getByID($productID);
        helper::header301(htmlspecialchars_decode($product->mall));
    }

    /**
     * Set currency and stock.
     * 
     * @access public
     * @return void
     */
    public function setting()
    {
        if($_POST)
        {
            $result = $this->product->saveSetting();
            if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }

        $this->view->title = $this->lang->product->setting;
        $this->display();
    }
}
