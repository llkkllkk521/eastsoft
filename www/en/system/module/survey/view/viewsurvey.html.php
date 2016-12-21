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
  	<div>
  		<style>
  		.ct{border:1px solid #ccc;}
  		.ct tr td{line-height:35px;height:35px;border:1px solid #ccc;padding:5px;}
  		</style>
    	<table width="100%" class="ct">
    		<tr>
    			<td>会员</td>
    			<td>调查类型</td>
    			<td>项目大类</td>
    			<td>标题</td>
    			<td>选择答案</td>
    			<td>评分</td>
    			<td>输入答案</td>
    			<td>时间</td>
    		</tr>
    	<?php foreach($contents as $k => $content):?>
    		<tr>
    			<td><?php if($k==0) {echo $content[0];}?></td>
    			<td><?php echo $content[1];?></td>
    			<td><?php echo $content[2];?></td>
    			<td><?php echo $content[3];?></td>
    			<td><?php echo $content[4];?></td>
    			<td><?php echo $content[5];?></td>
    			<td><?php echo $content[6];?></td>
    			<td><?php if($k==0) {echo $content[7];}?></td>
    		</tr>
    	<?php endforeach;?>
    	</table>
    </div>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
