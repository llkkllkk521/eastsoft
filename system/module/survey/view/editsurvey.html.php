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
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/kindeditor.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><?php echo $lang->survey->common;?></strong>
    <?php
    echo '&nbsp; &nbsp; &nbsp;';
    echo html::a(inlink('surveytype', "status=survey_type"),   $lang->survey->survey_type,   $status == 'survey_type' ? "class='active'" : '');
    echo html::a(inlink('surveytheme', "status=survey_theme"), $lang->survey->survey_theme, $status == 'survey_theme' ? "class='active'" : '');
    echo html::a(inlink('surveycontent', "status=survey_content"), $lang->survey->survey_content,   $status == 'survey_content' ? "class='active'" : '');
    ?>
    <div class='panel-actions'>
      <?php commonModel::printLink('package', 'upload', '', $lang->survey->upload, "class='btn btn-primary' data-toggle='modal'");?>
      <?php commonModel::printLink('package', 'obtain', '', $lang->survey->obtain, "class='btn btn-primary'");?>
    </div>
  </div>
  <div class='panel-body'>
  	<div>
  	<form method='post' role='form' id='ajaxForm'>
    	<table width="100%">
    		<tr>
    			<td width="10%">调查名称</td>
    			<td><?php echo html::input('title', $survey->title, "class='title form-control' placeholder=''");?></td>
    		</tr>
    		<tr>
    			<td>调查介绍</td>
    			<td><?php echo html::textarea('intro', $survey->intro, "rows='10' class='form-control'");?></td>
    		</tr>
    		<tr>
    			<td>开启状态</td>
    			<td><?php echo html::radio('status', $lang->survey->statusList, $survey->status);?></td>
    		</tr>
    		<tr>
    			<td>调查类型</td>
    			<td><?php echo html::radio('type', $lang->survey->typesList, $survey->type);?></td>
    		</tr>
    		<tr>
    			<td>开始时间</td>
    			<td class="input-append date">
    			<?php echo html::input('beginDate', $survey->beginDate, "class='form-control'");?>
    			<span class='add-on'><button class="btn btn-default" type="button"><i class="icon-calendar"></i></button></span>
    			</td>
    		</tr>
    		<tr>
    			<td>结束时间</td>
    			<td class="input-append date">
    			<?php echo html::input('endDate', $survey->endDate, "class='form-control'");?>
    			<span class='add-on'><button class="btn btn-default" type="button"><i class="icon-calendar"></i></button></span>
    			</td>
    		</tr>
    		<tr>
    			<td>&nbsp;</td>
    			<td><?php echo html::submitButton();?></td>
    		</tr>
    	</table>
    </form>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
	$("#addcontent").click(function() {
		console.log($('.content-type').html());
		var content_type = '<?php echo $content_type;?>';
		$("#survey_content").append('<tr><td width="10%">&nbsp;</td><td><input type="text" name="weight[]" class="survey-content-weight" value="" placeholder="权重"></td><td width="10%">&nbsp;</td><td><input type="text" name="content[]" value="" class="form-control survey-content" placeholder="标题"></td><td>'+content_type+'</td></tr>');
	});

	$('#save').click(function() {
		var survey_content_weight = survey_content = survey_content_type = new Array();
		$('.survey-content-weight').each(function(k){
			survey_content_weight[k] = $(this).val();
		});
		var scw = survey_content_weight.join(',');
		$('.survey-content').each(function(k){
			survey_content[k] = $(this).val();
		});
		var sc = survey_content.join(',');
		$('.survey-content-type').each(function(k){
			survey_content_type[k] = $(this).val();
		});
		var sct = survey_content_type.join(',');
		$.post('/admin.php?m=survey&f=surveycontentpost', {st : $('.survey-type').val(), stitle : $('.title').val(), scw : scw, sc : sc, sct : sct}, function(res) {
				if(res.result == 'success') {
					$('.msg').css({'padding' : 6, 'color' : '#fff', 'background-color' : '#47A447', 'font-weight' : 'bold'});
					$('.msg').html(res.message);
					if(res.locate) {
						setTimeout("window.location.href='"+res.locate+"';", 5010);
					}
				} else {
					$('.msg').css({'padding' : 6, 'color' : 'red', 'font-weight' : 'bold'});
					$('.msg').html(res.message);
				}
				setTimeout("$('.msg').html('');$('.msg').css({'padding' : 0});", 5000);
		}, 'json');
	});
});
</script>
<?php include '../../common/view/footer.admin.html.php';?>
