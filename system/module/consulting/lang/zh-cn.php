<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The consulting category zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     consulting
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->consulting->setting     = '招聘设置';
$lang->consulting->common      = '招聘维护';
$lang->consulting->createDraft = '保存草稿';
$lang->consulting->post        = '创建投稿';
$lang->consulting->check       = '审核投稿';
$lang->consulting->reject      = '驳回投稿';

$lang->consulting->id         = '编号';
$lang->consulting->category   = '类目';
$lang->consulting->categories = '类目';
$lang->consulting->title      = '职位';
$lang->consulting->alias      = '别名';
$lang->consulting->content    = '任职资格';
$lang->consulting->source     = '来源';
$lang->consulting->copySite   = '来源网站';
$lang->consulting->copyURL    = '来源URL';
$lang->consulting->keywords   = '关键字';
$lang->consulting->summary    = '岗位职责';
$lang->consulting->author     = '作者';
$lang->consulting->editor     = '编辑';
$lang->consulting->addedDate  = '发布时间';
$lang->consulting->editedDate = '编辑时间';
$lang->consulting->status     = '状态';
$lang->consulting->type       = '类型';
$lang->consulting->views      = '阅读';
$lang->consulting->comments   = '评论';
$lang->consulting->stick      = '置顶';
$lang->consulting->order      = '排序';
$lang->consulting->isLink     = '跳转';
$lang->consulting->link       = '链接';
$lang->consulting->css        = 'CSS';
$lang->consulting->js         = 'JS';

$lang->consulting->forward2Blog     = '转至博客';
$lang->consulting->forward2Forum    = '转至论坛';
$lang->consulting->selectCategories = '选择类目';
$lang->consulting->selectBoard      = '选择版块';
$lang->consulting->confirmReject    = '确认驳回这篇投稿？';

$lang->contribution= new stdclass();
$lang->contribution->check   = '审核';
$lang->contribution->list    = '投稿列表';
$lang->contribution->publish = '发布';
$lang->contribution->reject  = '驳回';

$lang->contribution->status[0] = '';
$lang->contribution->status[1] = '<span class="label label-xsm label-primary">' . '待审核' .'</span>';
$lang->contribution->status[2] = '<span class="label label-xsm label-success">' . '通过' . '</span>';
$lang->contribution->status[3] = '驳回';

$lang->contribution->typeList = array();
$lang->contribution->typeList['consulting'] = '招聘';
$lang->contribution->typeList['blog']    = '博客';

$lang->consulting->list          = '招聘列表';
$lang->consulting->admin         = '维护招聘';
$lang->consulting->create        = '提交咨询';
$lang->consulting->setcss        = '设置CSS';
$lang->consulting->setjs         = '设置JS';
$lang->consulting->edit          = '编辑招聘';
$lang->consulting->files         = '附件';
$lang->consulting->images        = '图片';

$lang->consulting->contribution    = '投稿';
$lang->consulting->submissionTime  = '投递时间';

$lang->consulting->contributionOptions = new stdclass;
$lang->consulting->contributionOptions->open  = '开启';
$lang->consulting->contributionOptions->close = '关闭';

$lang->blog->admin  = '维护博客';
$lang->blog->list   = '博客列表';
$lang->blog->create = '发布博客';
$lang->blog->edit   = '编辑博客';

$lang->page->admin  = '维护单页';
$lang->page->list   = '单页列表';
$lang->page->create = '添加单页';
$lang->page->edit   = '编辑单页';

$lang->consulting->sourceList['original']      = '原创';
$lang->consulting->sourceList['copied']        = '转贴';
$lang->consulting->sourceList['translational'] = '翻译';
$lang->consulting->sourceList['consulting']       = '转自招聘';

$lang->consulting->statusList['normal'] = '正常';
$lang->consulting->statusList['draft']  = '草稿';

$lang->consulting->sticks[0] = '不置顶';
$lang->consulting->sticks[1] = '类目置顶';
$lang->consulting->sticks[2] = '全局置顶';

$lang->consulting->successStick   = '置顶成功';
$lang->consulting->successUnstick = '取消置顶成功';

$lang->consulting->confirmDelete = '您确定删除该招聘吗？';
$lang->consulting->categoryEmpty = '类目不能为空';

$lang->consulting->lblAddedDate = '<strong>添加时间：</strong> %s &nbsp;&nbsp;';
$lang->consulting->lblAuthor    = "<strong>作者：</strong> %s &nbsp;&nbsp;";
$lang->consulting->lblSource    = '<strong>来源：</strong>';
$lang->consulting->lblViews     = ' <strong>阅读：</strong>%s';
$lang->consulting->lblEditor    = '最后编辑：%s 于 %s';
$lang->consulting->lblComments  = '<strong>评论：</strong> %s';

$lang->consulting->none      = '没有了';
$lang->consulting->previous  = '上一篇';
$lang->consulting->next      = '下一篇';
$lang->consulting->directory = '返回目录';
$lang->consulting->noCssTag  = '不需要&lt;style&gt;&lt;/style&gt;标签';
$lang->consulting->noJsTag   = '不需要&lt;script&gt;&lt;/script&gt;标签';

$lang->consulting->placeholder = new stdclass();
$lang->consulting->placeholder->addedDate = '可以延迟到选定的时间发布。';
$lang->consulting->placeholder->link      = '输入链接，可以是站外链接';

$lang->consulting->approveMessage = '您投递的招聘 <strong>《%s》</strong> 已通过审核，奖励 <strong>+%s</strong> 积分，感谢您的支持。';
$lang->consulting->rejectMessage  = '您投递的招聘 <strong>《%s》</strong> 未通过审核，您可以编辑后再次提交审核，感谢您的支持。';

$lang->consulting->forwardFrom = '转发自';

$lang->consulting->total_number = '招聘人数';
$lang->consulting->area = '地区';
$lang->consulting->department = '部门';

$lang->consulting->needtypeList['技术支持'] = '技术支持';
$lang->consulting->needtypeList['报修'] = '报修';
$lang->consulting->needtypeList['投诉'] = '投诉';
$lang->consulting->needtypeList['其它'] = '其它';

$lang->consulting->needContent['芯片'] = '芯片';
$lang->consulting->needContent['工具'] = '工具';
$lang->consulting->needContent['方案及其他'] = '方案及其他';

$lang->consulting->applicationList['消费电子'] = '消费电子';
$lang->consulting->applicationList['汽车电子'] = '汽车电子';
$lang->consulting->applicationList['工业控制'] = '工业控制';
$lang->consulting->applicationList['物联网'] = '物联网';
$lang->consulting->applicationList['健康医疗'] = '健康医疗';

$lang->consulting->productList['微处理器MCU'] = '微处理器MCU';
$lang->consulting->productList['电容式触控IC'] = '电容式触控IC';
$lang->consulting->productList['电容式触摸按键IC'] = '电容式触摸按键IC';
$lang->consulting->productList['计量芯片'] = '计量芯片';
$lang->consulting->productList['射频芯片'] = '射频芯片';
$lang->consulting->productList['其它芯片'] = '其它芯片';
