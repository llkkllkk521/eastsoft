<?php if(!defined("RUN_MODE")) die();?>
<?php include TPL_ROOT . 'common/header.html.php';?>
<div class='page-user-control'>
  <div class='row'>
    <?php include TPL_ROOT . 'user/side.html.php';?>
    <div class='col-md-10'>
      <div>
      	  	<style>
			.title td{background-color: #fafbfd;font-weight: bold;padding:10px; border: 1px solid #ccc;}
			.content td{border: 1px solid #ccc;}
			</style>
      	  <div class="top">
              <div class="name"><?php echo $_title; ?></div>
          </div>
         	<table style="width:100%;border: 1px solid #ccc;">
	            <tr class="title">
                    <td>Software  name</td>
                    <td align="center">Release</td>
                    <!--  	              <td align="center">大小</td>-->
                    <td align="center">Version</td>
                    <td align="center">Download</td>
	            </tr>
	            <?php foreach($articlelist as $article):?>
	            <?php  $file=$this->loadModel('file')->getByObject('article', $article->id);?>
	            <?php $size=ceil($file[0]->size/1024);?>
	            <tr class="content">
	              <td style="color:#1370be;"><?php echo $article->title;?></td>
	              <td align="center"><?php echo substr($article->editedDate, 0, 10);?></td>
<!--	              <td align="center">--><?php //echo $size.'KB';?><!--</td>-->
	              <td align="center"><?php echo $article->summary;?></td>
	              <td style="color:#1370be;" align="center"><?php echo $file[0]->id ? html::a(helper::createLink('file', 'download', "fileID={$file[0]->id}&mouse=left"), '下载', "target='_blank' title='{$file[0]->title}'") : '';?></td>
	            </tr>
	            <?php endforeach;?>
	          </table>
      </div>
    </div>
  </div>
</div>
<?php include TPL_ROOT . 'common/footer.html.php';?>
