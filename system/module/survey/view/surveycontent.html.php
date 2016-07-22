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
    ?>
    <div class='panel-actions'>
 
    </div>
  </div>
  <div class='panel-body'>
  <div class='cards'>
    	<table width="100%" cellpadding="10">
    		<tr class="page-header">
    		<td>时间</td>
    		<td>答题人</td>
    		<td>所属调查</td>
    		<td>查看</td>
    		<!-- <td>项目大类</td>
    		<td>项目</td>
    		<td>答案</td>
    		<td>内容</td> -->
    		</tr>
    	<?php foreach($surveys as $survey):?>
    		<?php 
    		$s1=$this->loadModel('survey')->getSurvey($survey->survey_id);
    		$s2=$this->loadModel('survey')->getSurvey($s1->parent);
    		$user=$this->loadModel('survey')->getUserInfo($survey->user_id);
    		?>
    		<tr>
    		<td><?php echo $survey->addedDate;?></td>
    		<td><?php echo $user->account;?></td>
    		<td><?php echo $s2->title;?></td>
    		<td><?php echo '<a href="/admin.php?m=survey&f=viewsurvey&status=survey_content&sid='.$survey->id.'">点击查看</a>';?></td>
    		<!-- <td><?php echo $s1->theme;?></td>
    		<td><?php echo $s1->title?></td>
    		<td><?php echo $survey->value;?></td>
    		<td><?php echo $survey->content;?></td> -->
    		</tr>
      	<?php endforeach;?>
      	</table>
      	<div style="margin-top:10px;border-top:">
      	<link href="css/jquery-ui.css" rel="stylesheet">
		<script src="js/jquery-ui.js"></script>
      	<form method='post' action="admin.php?m=survey&f=surveycontent&status=survey_content" class="search-content">
      	开始日：<input type="text" name="datebegin" value="<?php echo $datebegin;?>" id="datebegin" class="datebegin">
		结束日：<input type="text" name="dateend" value="<?php echo $dateend;?>" id="dateend" class="dateend">
        <?php echo html::select('user', $this->loadModel('survey')->getUserAll(), (empty($account) ?  'a' : $account), "class='user'");?>
        <?php //echo html::select('surveytype', $this->loadModel('survey')->getThemeType(), (empty($surveytype) ?  'a' : $surveytype), "class='survey-type'");?>
		<input type="submit" value="搜索" class="btn btn-primary search-survey-content">
		<input type="button" value="删除" class="btn btn-primary del-survey-content" >
		<input type="button" value="导出" class="btn btn-primary survey-content-export">
		</form>
      	</div>
      	<div class="export-url" style="margin-top:20px;"></div>
      	<?php $pager->show();?>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){

	$('.del-survey-content').click(function() {
		$.post('/admin.php?m=survey&f=delSurveyContent', {uid : $('.user').val(), st : $('.survey-type').val(), datebegin : $('.datebegin').val(), dateend : $('.dateend').val()}, function(res) {
			if(res.result == 'success') {
				if(res.locate) {
					window.location.href = res.locate;
				}
			} else {
				alert(res.message);
			}
		}, 'json');
	});

	$('.survey-content-export').click(function() {
		$.post('/admin.php?m=survey&f=urveyContentExport', {uid : $('.user').val(), st : $('.survey-type').val(), datebegin : $('.datebegin').val(), dateend : $('.dateend').val()}, function(res) {
			$('.export-url').html(res.message);
		}, 'json');
	});

	$("#datebegin").datepicker({});
	$("#dateend").datepicker({});
	$.datepicker.regional['zh-CN'] = {
			numberOfMonths:1,//显示几个月  
	        showButtonPanel:true,//是否显示按钮面板
	        closeText: '关闭',  
	        prevText: '<上月',  
	        nextText: '下月>',  
	        currentText: '今天',  
	        monthNames: ['一月','二月','三月','四月','五月','六月',  
	        '七月','八月','九月','十月','十一月','十二月'],  
	        monthNamesShort: ['一','二','三','四','五','六',  
	        '七','八','九','十','十一','十二'],  
	        dayNames: ['星期日','星期一','星期二','星期三','星期四','星期五','星期六'],  
	        dayNamesShort: ['周日','周一','周二','周三','周四','周五','周六'],  
	        dayNamesMin: ['日','一','二','三','四','五','六'],  
	        weekHeader: '周',  
	        dateFormat: 'yy-mm-dd',  
	        firstDay: 1,  
	        isRTL: false,  
	        showMonthAfterYear: true,  
	        yearSuffix: '年'};  
	    $.datepicker.setDefaults($.datepicker.regional['zh-CN']);
});


</script>
<?php include '../../common/view/footer.admin.html.php';?>
