<?php if(!defined("RUN_MODE")) die();?>
<?php include TPL_ROOT . 'common/header.html.php';?>
<div class='page-user-control'>
  <div class='row'>
    <?php include TPL_ROOT . 'user/side.html.php';?>
    <div class='col-md-10'>
      <div>
      		
         <?php if($survey):?>
         <div class="top">
              <div class="name"><?php echo $survey->title; ?></div>
          </div>
          <form method="post" action="/index.php/user-surveytwostep.html" class="survey-submit">
	          <table style="width:100%;height:150px;">
	            <tr>
	              <td valign="top" style="padding-top:15px;">
	                <?php echo $survey->intro;?>
	              </td>
	            </tr>
	            <tr><td>1、你目前使用的上海东软载波微电子芯片产品是？（必填）<input type="text" name="surveyone[]" class="surveyone-1" /></td></tr>
	            <tr><td>2、请您对上海东软载波微电子本年度整体服务如何评价？（必填）<input type="text" name="surveyone[]" class="surveyone-2" /></td></tr>
	            <tr><td><?php echo html::radio('myd', $lang->user->mydList, '非常满意');?></td></tr>
	            <tr><td>3、总体评价<?php echo html::textarea('surveyone[]', '', "rows='5' class='form-control surveyone-3'");?></td></tr>
	            <tr><td><input type="button" value="开始调查" class="survey-begin"></td></tr>
	          </table>
          </form>
          <?php else:?>
          	无调查
          <?php endif;?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function() {
	$('.survey-begin').click(function() {
		if(!$('.surveyone-1').val() || !$('.surveyone-2').val() || !$('.surveyone-3').val()) {
			alert('请填写全部调查内容！');
			return false;
		}
		$('.survey-submit').submit();
	});
});
</script>
<?php include TPL_ROOT . 'common/footer.html.php';?>
