<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The browse view file of package module of ChanZhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@xirangit.com>
 * @package     package
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><?php echo $lang->survey->common;?></strong>
    <?php
    echo '&nbsp; &nbsp; &nbsp;';
    echo html::a(inlink('surveytype', "status=survey_type"),   $lang->survey->survey_type,   $status == 'survey_type' ? "class='active'" : '');
    echo html::a(inlink('surveytheme', "status=survey_theme"), $lang->survey->survey_theme, $status == 'survey_theme' ? "class='active'" : '');
    echo html::a(inlink('surveycontent', "status=survey_content"), $lang->survey->survey_content,   $status == 'survey_content' ? "class='active'" : '');
    echo html::a(inlink('addsurvey', "status=survey_type"), $lang->survey->addsurvey);
    ?>
    <div class='panel-actions'>
      &nbsp;
    </div>
  </div>
  <div class='panel-body'>
  <div class='cards'>
    	<table width="100%" cellpadding="10">
    		<tr class="page-header">
    		<td>调查标题</td>
    		<td>状态</td>
    		<td>类型</td>
    		<td>开始时间</td>
    		<td>结束时间</td>	
    		<td>操作</td>
    		</tr>
    	<?php foreach($surveys as $survey):?>
    		<tr>
    		<td><?php echo $survey->title;?></td>
    		<td><?php echo $lang->survey->statusList[$survey->status];?></td>
    		<td><?php echo $lang->survey->typesList[$survey->type];?></td>
    		<td><?php echo $survey->beginDate?></td>
    		<td><?php echo $survey->endDate;?></td>
    		<td><a href="/admin.php?m=survey&f=editsurvey&status=survey_type&id=<?php echo $survey->id;?>">编辑</a> <a href="javascript:;" data="<?php echo $survey->id?>" class="survey-del">删除</a></td>
    		</tr>
      	<?php endforeach;?>
      	</table>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
	$('.survey-del').click(function() {
		$.post('/admin.php?m=survey&f=surveyDel', {sid : $(this).attr('data')}, function(res) {
			if(res.result == 'success') {
				if(res.locate) {
					window.location.href = '/admin.php?m=survey&f=surveytype&status=survey_type';
				}
			}
			alert(res.message);
		}, 'json');
	});
});
</script>
<?php include '../../common/view/footer.admin.html.php';?>
