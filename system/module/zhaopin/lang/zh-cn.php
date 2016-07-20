<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The zhaopin category zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     zhaopin
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->zhaopin->setting     = '招聘设置';
$lang->zhaopin->common      = '招聘维护';
$lang->zhaopin->createDraft = '保存草稿';
$lang->zhaopin->post        = '创建投稿';
$lang->zhaopin->check       = '审核投稿';
$lang->zhaopin->reject      = '驳回投稿';

$lang->zhaopin->id         = '编号';
$lang->zhaopin->category   = '类目';
$lang->zhaopin->categories = '类目';
$lang->zhaopin->title      = '职位';
$lang->zhaopin->alias      = '别名';
$lang->zhaopin->content    = '任职资格';
$lang->zhaopin->source     = '来源';
$lang->zhaopin->copySite   = '来源网站';
$lang->zhaopin->copyURL    = '来源URL';
$lang->zhaopin->keywords   = '关键字';
$lang->zhaopin->summary    = '岗位职责';
$lang->zhaopin->author     = '作者';
$lang->zhaopin->editor     = '编辑';
$lang->zhaopin->addedDate  = '发布时间';
$lang->zhaopin->editedDate = '编辑时间';
$lang->zhaopin->status     = '状态';
$lang->zhaopin->type       = '类型';
$lang->zhaopin->views      = '阅读';
$lang->zhaopin->comments   = '评论';
$lang->zhaopin->stick      = '置顶';
$lang->zhaopin->order      = '排序';
$lang->zhaopin->isLink     = '跳转';
$lang->zhaopin->link       = '链接';
$lang->zhaopin->css        = 'CSS';
$lang->zhaopin->js         = 'JS';

$lang->zhaopin->forward2Blog     = '转至博客';
$lang->zhaopin->forward2Forum    = '转至论坛';
$lang->zhaopin->selectCategories = '选择类目';
$lang->zhaopin->selectBoard      = '选择版块';
$lang->zhaopin->confirmReject    = '确认驳回这篇投稿？';

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
$lang->contribution->typeList['zhaopin'] = '招聘';
$lang->contribution->typeList['blog']    = '博客';

$lang->zhaopin->list          = '招聘列表';
$lang->zhaopin->admin         = '维护招聘';
$lang->zhaopin->create        = '发布招聘';
$lang->zhaopin->setcss        = '设置CSS';
$lang->zhaopin->setjs         = '设置JS';
$lang->zhaopin->edit          = '编辑招聘';
$lang->zhaopin->files         = '附件';
$lang->zhaopin->images        = '图片';

$lang->zhaopin->contribution    = '投稿';
$lang->zhaopin->submissionTime  = '投递时间';

$lang->zhaopin->contributionOptions = new stdclass;
$lang->zhaopin->contributionOptions->open  = '开启';
$lang->zhaopin->contributionOptions->close = '关闭';

$lang->blog->admin  = '维护博客';
$lang->blog->list   = '博客列表';
$lang->blog->create = '发布博客';
$lang->blog->edit   = '编辑博客';

$lang->page->admin  = '维护单页';
$lang->page->list   = '单页列表';
$lang->page->create = '添加单页';
$lang->page->edit   = '编辑单页';

$lang->zhaopin->sourceList['original']      = '原创';
$lang->zhaopin->sourceList['copied']        = '转贴';
$lang->zhaopin->sourceList['translational'] = '翻译';
$lang->zhaopin->sourceList['zhaopin']       = '转自招聘';

$lang->zhaopin->statusList['normal'] = '正常';
$lang->zhaopin->statusList['draft']  = '草稿';

$lang->zhaopin->sticks[0] = '不置顶';
$lang->zhaopin->sticks[1] = '类目置顶';
$lang->zhaopin->sticks[2] = '全局置顶';

$lang->zhaopin->successStick   = '置顶成功';
$lang->zhaopin->successUnstick = '取消置顶成功';

$lang->zhaopin->confirmDelete = '您确定删除该招聘吗？';
$lang->zhaopin->categoryEmpty = '类目不能为空';

$lang->zhaopin->lblAddedDate = '<strong>添加时间：</strong> %s &nbsp;&nbsp;';
$lang->zhaopin->lblAuthor    = "<strong>作者：</strong> %s &nbsp;&nbsp;";
$lang->zhaopin->lblSource    = '<strong>来源：</strong>';
$lang->zhaopin->lblViews     = ' <strong>阅读：</strong>%s';
$lang->zhaopin->lblEditor    = '最后编辑：%s 于 %s';
$lang->zhaopin->lblComments  = '<strong>评论：</strong> %s';

$lang->zhaopin->none      = '没有了';
$lang->zhaopin->previous  = '上一篇';
$lang->zhaopin->next      = '下一篇';
$lang->zhaopin->directory = '返回目录';
$lang->zhaopin->noCssTag  = '不需要&lt;style&gt;&lt;/style&gt;标签';
$lang->zhaopin->noJsTag   = '不需要&lt;script&gt;&lt;/script&gt;标签';

$lang->zhaopin->placeholder = new stdclass();
$lang->zhaopin->placeholder->addedDate = '可以延迟到选定的时间发布。';
$lang->zhaopin->placeholder->link      = '输入链接，可以是站外链接';

$lang->zhaopin->approveMessage = '您投递的招聘 <strong>《%s》</strong> 已通过审核，奖励 <strong>+%s</strong> 积分，感谢您的支持。';
$lang->zhaopin->rejectMessage  = '您投递的招聘 <strong>《%s》</strong> 未通过审核，您可以编辑后再次提交审核，感谢您的支持。';

$lang->zhaopin->forwardFrom = '转发自';

$lang->zhaopin->total_number = '招聘人数';
$lang->zhaopin->area = '地区';
$lang->zhaopin->department = '部门';
