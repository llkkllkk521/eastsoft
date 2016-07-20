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
    echo html::a(inlink('admin', "status=survey_type"),   $lang->survey->survey_type,   $status == 'survey_type' ? "class='active'" : '');
    echo html::a(inlink('admin', "status=survey_theme"), $lang->survey->survey_theme, $status == 'survey_theme' ? "class='active'" : '');
    echo html::a(inlink('admin', "status=survey_content"), $lang->survey->survey_content,   $status == 'survey_content' ? "class='active'" : '');
    ?>
    <div class='panel-actions'>
      <?php commonModel::printLink('package', 'upload', '', $lang->survey->upload, "class='btn btn-primary' data-toggle='modal'");?>
      <?php commonModel::printLink('package', 'obtain', '', $lang->survey->obtain, "class='btn btn-primary'");?>
    </div>
  </div>
  <div class='panel-body'>
  <div class='cards'>
    <?php
    echo html::a(inlink('addtheme', "status=survey_theme"), $lang->survey->addtheme,   $status == 'survey_content' ? "class='active'" : '');
    ?>
    	<table width="100%" cellpadding="10">
    		<tr class="page-header">
    		<td>所属调查</td>
    		<td>调查主题</td>
    		<td>调查标题</td>
    		<td>权重</td>
    		<td>操作</td>
    		</tr>
    	<?php foreach($surveys as $survey):?>
    		<?php $s=$this->loadModel('survey')->getSurvey($survey->parent);?>
    		<tr>
    		<td><?php echo $s->title;?></td>
    		<td><?php echo $survey->theme;?></td>
    		<td><?php echo $survey->title?></td>
    		<td><?php echo $survey->weight;?></td>
    		<td><a href="/admin.php?m=survey&f=edittheme&status=survey_theme&id=<?php echo $survey->id;?>">编辑</a> <a href="javascript:;" data="<?php echo $survey->id?>" class="survey-del">删除</a></td>
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
					window.location.href = res.locate;
				}
			}
			alert(res.message);
		}, 'json');
	});
});
</script>
<?php include '../../common/view/footer.admin.html.php';?>
