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
      &nbsp;
    </div>
  </div>
  <div class='panel-body'>
  	<div class='cards'>
    	<table width="100%">
    		<tr>
    			<td width="10%">调查类型</td>
    			<td colspan="4">
				<?php echo html::select('surveytype', $this->loadModel('survey')->getThemeType(), (empty($sid) ?  'a' : $sid), "class='survey-type form-control'");?>
				</td>
    		</tr>
    		<tr>
    			<td width="10%">项目大类</td>
    			<td colspan="4"><?php echo html::input('theme', $stitle, "class='theme form-control' placeholder=''");?></td>
    		</tr>
    	</table>
    	<table id="survey_content" width="100%">
    		<?php foreach($sts as $st):?>
    		<tr>
	    		<td width="10%">&nbsp;</td>
	    		<td><input type="text" name="weight[]" class="survey-content-weight" value="<?php echo $st->weight;?>" placeholder="权重"></td>
	    		<td><input type="text" name="title[]" dataid="<?php echo $st->id;?>" value="<?php echo $st->title;?>" class="form-control survey-title" placeholder="调查项目"></td>
	    		<td><input type="text" name="content[]" value="<?php echo $st->content;?>" class="form-control survey-content" placeholder="调查内容"></td>
	    		<td><?php echo $this->loadModel('survey')->get_content_type($st->type);?></td>
	    		<td><input type="text" name="explain[]" value="<?php echo $st->explain;?>" class="form-control survey-explain" placeholder="意见或建议"></td>
    		</tr>
    		<?php endforeach;?>
    	</table>
    	<table width="100%" cellpadding="10" style="margin-top:30px;line-height:20px">
    		<tr>
    			<td width="10%">&nbsp;</td>
    			<td colspan="4"><input type="button" id="addcontent" value="添加调查项目"></td>
    		</tr>
    		<tr>
    			<td width="10%">&nbsp;</td>
    			<td colspan="4"><input type="button" id="save" value="保存" class="btn btn-primary"><span class="msg"></span></td>
    		</tr>
    	</table>
    	
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
	$("#addcontent").click(function() {
		console.log($('.content-type').html());
		var content_type = '<?php echo $content_type;?>';
		$("#survey_content").append('<tr><td width="10%">&nbsp;</td><td><input type="text" name="weight[]" class="survey-content-weight" value="" placeholder="权重"></td><td><input type="text" name="title[]" value="" class="form-control survey-title" placeholder="调查项目"></td><td><input type="text" name="content[]" value="" class="form-control survey-content" placeholder="调查内容"></td><td>'+content_type+'</td><td><input type="text" name="explain[]" value="" class="form-control survey-explain" placeholder="意见或建议"></td></tr>');
	});

	$('#save').click(function() {
		var survey_content_weight = survey_title = survey_content = survey_content_type = survey_explain = new Array();
		$('.survey-content-weight').each(function(k){
			survey_content_weight[k] = $(this).val();
		});
		var scw = survey_content_weight.join(',');
		
		$('.survey-title').each(function(k){
			survey_title[k] = $(this).val()+($(this).attr('dataid') ? '&'+$(this).attr('dataid') : '');
		});
		var sti = survey_title.join(',');
		
		$('.survey-content').each(function(k){
			survey_content[k] = $(this).val();
		});
		var sc = survey_content.join(',');
		
		$('.survey-content-type').each(function(k){
			survey_content_type[k] = $(this).val();
		});
		var sct = survey_content_type.join(',');

		$('.survey-explain').each(function(k){
			survey_explain[k] = $(this).val();
		});
		var se = survey_explain.join(',');
		
		$.post('/admin.php?m=survey&f=surveyContentEditPost', {st : ($('.survey-type').val()=='a'?'':$('.survey-type').val()), theme : $('.theme').val(), scw : scw, sti : sti, sc : sc, sct : sct, se : se}, function(res) {
				if(res.result == 'success') {
					$('.msg').css({'padding' : 6, 'color' : '#fff', 'background-color' : '#47A447', 'font-weight' : 'bold'});
					$('.msg').html(res.message);
					if(res.locate) {
						setTimeout("window.location.href='"+res.locate+"';", 5010);
					}
				} else {
					$('.msg').css({'padding' : 6, 'color' : 'red', 'font-weight' : 'bold', 'background-color' : '#fff'});
					$('.msg').html(res.message);
				}
				setTimeout("$('.msg').html('');$('.msg').css({'padding' : 0});", 5000);
		}, 'json');
	});
});
</script>
<?php include '../../common/view/footer.admin.html.php';?>
