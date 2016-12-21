<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of index module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     index
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class index extends control
{
    /**
     * Construct, must create this contruct function since there's index() also
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The index page of whole site.
     * 
     * @access public
     * @return void
     */
    public function index($categoryID = 0, $pageID = 1)
    {
        if(isset($this->config->site->type) and $this->config->site->type == 'blog')
        {
            $param = ($categoryID == 0 and $pageID == 1) ? '' : "categoryID={$categoryID}&pageID={$pageID}";
            $this->locate($this->createLink('blog', 'index', $param));
        }

        //SMART 产品分类信息
        $product = $this->dao->select('id,name')->from('es_category')
                    ->where('type')->eq('product')
                    ->andWhere('parent')->eq(1)
                    ->andWhere('lang')->eq('zh-cn')
                    ->fetchAll();

        foreach ($product as &$top) {
            $top->child = $this->dao->select('*')->from('es_category')
                            ->where('type')->eq('product')
                            ->andWhere('parent')->eq($top->id)
                            ->andWhere('lang')->eq('zh-cn')
                            ->fetchAll();
        }
        //变更通知部分
        $field = $this->dao->select('t1.id,t1.title,t1.addedDate')->from('es_article')->alias('t1')
                    ->leftJoin('es_relation')->alias('t2')->on('t1.id = t2.id')
                    ->where('t2.category')->eq(19)->orderBy('id_desc')->limit(5)
                    ->fetchAll();
        //公司新闻
        $company = $this->dao->select('t1.id,t1.title')->from('es_article')->alias('t1')
                    ->leftJoin('es_relation')->alias('t2')->on('t1.id = t2.id')
                    ->where('t2.category')->eq(20)->limit(3)
                    ->fetchAll();
        //应用与解决方案
        $solution = $this->dao->select('id,name')->from('es_category')
                    ->where('type')->eq('article')
                    ->andWhere('parent')->eq(2)
                    ->andWhere('lang')->eq('zh-cn')
                    ->fetchAll();

        /*获取header分类总数*/
        $category_total = $this->dao->select('count(*) as count')->from('es_category')->fetchAll();
        $this->view->header_tag = $category_total[0]->count;

        /*获取尾部footer*/
        $category_total = $this->dao->select('count(*) as count')->from('es_block')->fetchAll();
        $this->view->footer_tag = $category_total[0]->count;

        $this->view->title      = $this->config->site->indexKeywords;
        $this->view->mobileURL  = helper::createLink('index', 'index', '', '', 'mhtml');
        $this->view->desktopURL = helper::createLink('index', 'index', '', '', 'html');
        $this->view->product    = $product;
        $this->view->field      = $field;
        $this->view->company    = $company;
        $this->view->solution   = $solution;
        $this->display();
    }
}
