<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The survey module zh-cn file of ChanZhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@xirangit.com>
 * @survey     survey
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->survey->common        = '调查管理';
$lang->survey->browse        = '浏览插件';
$lang->survey->survey_type       = '调查类型';
$lang->survey->survey_theme = '调查项目';
$lang->survey->survey_content = '调查内容';
$lang->survey->installAuto   = '自动安装';
$lang->survey->installForce  = '强制安装';
$lang->survey->uninstall     = '卸载';
$lang->survey->activate      = '激活';
$lang->survey->deactivate    = '禁用';
$lang->survey->obtain        = '获得插件';
$lang->survey->view          = '详情';
$lang->survey->download      = '下载插件';
$lang->survey->downloadAB    = '下载';
$lang->survey->upload        = '本地安装';
$lang->survey->erase         = '清除';
$lang->survey->upgrade       = '升级插件';
$lang->survey->agreeLicense  = '我同意该授权';
$lang->survey->settemplate   = '设置模板';

$lang->survey->structure   = '目录结构';
$lang->survey->installed   = '已安装';
$lang->survey->deactivated = '被禁用';
$lang->survey->available   = '已下载';

$lang->survey->id          = '编号';
$lang->survey->name        = '名称';
$lang->survey->code        = '插件代号';
$lang->survey->version     = '版本';
$lang->survey->compatible  = '适用版本';
$lang->survey->latest      = '<small>最新版本<strong><a href="%s" target="_blank" class="survey">%s</a></strong>，兼容蝉知<a href="http://api.chanzhi.org/goto.php?item=latest" target="_blank" class="alert-link"><strong>%s</strong></a></small>';
$lang->survey->author      = '作者';
$lang->survey->license     = '授权';
$lang->survey->intro       = '详情';
$lang->survey->abstract    = '简介';
$lang->survey->site        = '官网';
$lang->survey->addedTime   = '添加时间';
$lang->survey->updatedTime = '更新时间';
$lang->survey->downloads   = '下载量';
$lang->survey->public      = '下载方式';
$lang->survey->compatible  = '兼容性';
$lang->survey->grade       = '评分';
$lang->survey->depends     = '依赖';

$lang->survey->publicList[0] = '手工下载';
$lang->survey->publicList[1] = '直接下载';

$lang->survey->compatibleList[0] = '未知';
$lang->survey->compatibleList[1] = '兼容';

$lang->survey->byDownloads   = '最多下载';
$lang->survey->byAddedTime   = '最新添加';
$lang->survey->byUpdatedTime = '最近更新';
$lang->survey->bySearch      = '搜索';
$lang->survey->byCategory    = '分类浏览';
$lang->survey->byIndustry    = '行业分组';
$lang->survey->byColor       = '主题色调';

$lang->survey->installFailed            = '%s失败，错误原因如下:';
$lang->survey->uninstallFailed          = '卸载失败，错误原因如下:';
$lang->survey->confirmUninstall         = '卸载插件会删除或修改相关的数据库，是否继续卸载？';
$lang->survey->noticeBackupDB           = '卸载前，建议备份数据库。';
$lang->survey->installFinished          = '恭喜您，插件顺利的%s成功！';
$lang->survey->refreshPage              = '刷新页面';
$lang->survey->uninstallFinished        = '插件已经成功卸载';
$lang->survey->deactivateFinished       = '插件已经成功禁用';
$lang->survey->activateFinished         = '插件已经成功激活';
$lang->survey->eraseFinished            = '插件已经成功清除';
$lang->survey->unremovedFiles           = '有一些文件或目录未能删除，需要手工删除';
$lang->survey->executeCommands          = '<h3>执行下面的命令来修正这些问题：</h3>';
$lang->survey->successDownloadedsurvey = '成功下载插件';
$lang->survey->successUploadedsurvey   = '成功上传插件';
$lang->survey->successCopiedFiles       = '成功拷贝文件';
$lang->survey->successInstallDB         = '成功安装数据库';
$lang->survey->viewInstalled            = '查看已安装插件';
$lang->survey->viewAvailable            = '查看可安装插件';
$lang->survey->viewDeactivated          = '查看已禁用插件';
$lang->survey->backDBFile               = '插件相关数据已经备份到 %s 文件中！';

$lang->survey->upgradeExt     = '升级';
$lang->survey->installExt     = '安装';
$lang->survey->upgradeVersion = '（从%s升级到%s）';

$lang->survey->waring = '警告';

$lang->survey->errorOccurs                  = '错误：';
$lang->survey->errorGetModules              = '从www.chanzhi.org获得插件分类失败。可能是因为网络方面的原因，请检查后重新刷新页面。';
$lang->survey->errorGetsurveys             = '从www.chanzhi.org获得插件失败。可能是因为网络方面的原因，您可以到 <a href="http://www.chanzhi.org/extesion" target="_blank" class="alert-link">www.chanzhi.org</a> 手工下载插件，然后上传安装。';
$lang->survey->errorDownloadPathNotFound    = '插件下载存储路径<strong>%s</strong>不存在。<br />linux下面请执行命令：<strong>mkdir -p %s</strong>来修正。';
$lang->survey->errorDownloadPathNotWritable = '插件下载存储路径<strong>%s</strong>不可写。<br />linux下面请执行命令：<strong>sudo chmod 777 %s</strong>来修正。';
$lang->survey->errorsurveyFileExists       = '下载路径已经有一个名为的<strong>%s</strong>附件。<a href="%s" class="btn btn-primary loadInModal">重新%s</a>';
$lang->survey->errorDownloadFailed          = '下载失败，请重新下载。如果多次重试还不行，请尝试手工下载，然后通过上传功能上传。';
$lang->survey->errorMd5Checking             = '下载文件不完整，请重新下载。如果多次重试还不行，请尝试手工下载，然后通过上传功能上传。';
$lang->survey->errorExtracted               = '包文件<strong> %s </strong>解压缩失败，可能不是一个有效的zip文件。错误信息如下：<br />%s';
$lang->survey->errorCheckIncompatible       = '该插件与蝉知版本不兼容，%s后可能无法使用。。<h3>您可以选择 <a href="%s" class="loadInModal">强制%s</a> 或者 <a href="#" onclick=parent.location.href="%s">取消</a></h3>';
$lang->survey->errorFileConflicted          = '有以下文件冲突：<br />%s <h3>您可以选择 <a href="%s">覆盖</a> 或者 <a href="#" onclick=parent.location.href="%s">取消</a></h3>';
$lang->survey->errorsurveyNotFound         = '包文件 <strong>%s </strong>没有找到，可能是因为自动下载失败。您可以尝试再次下载。';
$lang->survey->errorTargetPathNotWritable   = '目标路径 <strong>%s </strong>不可写。';
$lang->survey->errorTargetPathNotExists     = '目标路径 <strong>%s </strong>不存在。';
$lang->survey->errorInstallDB               = '执行数据库语句失败。错误信息如下：%s';
$lang->survey->errorConflicts               = '与插件“%s”冲突！';
$lang->survey->errorDepends                 = '以下依赖插件没有安装或版本不正确：<br /><br /> %s';
$lang->survey->errorIncompatible            = '该插件与您的蝉知版本不兼容';
$lang->survey->errorUninstallDepends        = '插件“%s”依赖该插件，不能卸载';

$lang->survey->selectSurveyType = '请选择调查类型！';
$lang->survey->saveSuccess = '保存成功！';
$lang->survey->title = '请填写项目大类！';
$lang->survey->content = '请添加调查项目，填写调查项目，选择类型！';
$lang->survey->saveEerror = '请填写主题内容！';
$lang->survey->surveydel = '删除成功！';
$lang->survey->addtheme = '添加调查项目';
$lang->survey->addsurvey = '添加调查';
$lang->survey->statuson = '开启';
$lang->survey->statusoff = '关闭';
$lang->survey->statusList['on'] = '开启';
$lang->survey->statusList['off']  = '关闭';
$lang->survey->delSurveyContent = '删除';
$lang->survey->typesList['zd'] = '终端客户';
$lang->survey->typesList['dls']  = '代理商';