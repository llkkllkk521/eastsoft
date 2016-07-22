<?php if(!defined("RUN_MODE")) die();?>
<?php
include TPL_ROOT . 'common/header.html.php';

$path = array_keys($category->pathNames);
js::set('path', $path);
js::set('categoryID', $category->id);

include TPL_ROOT . 'common/treeview.html.php';
?>
<style>
.zhaopinview {
    font-size: 14px;
    line-height: 27px;
    width:100%;
    background-color: #ecf5fc;
    color:#107bb3;
	font-weight: bold;
	
}
.zhaopinview td {
	padding:10px 0 0 15px;
}
.zhaopin-content {
    font-size: 14px;
    line-height: 27px;
    width:100%;
	
}
.zhaopin-content td {
	padding:10px 0 0 15px;
}

</style>
<div class="main-content">
  <?php echo $common->printPositionBar($category);?>

  <div class="main-box">
    <!-- 左边分类列表开始 -->
    <div class="left">
      <?php foreach ($children as $sub1) { ?>
        <a href="<?php echo $webRoot . "index.php/article/c" . $sub1->id . ".html"; ?>" class='sub1'>
          <div class="arrow-h"></div>
          <div class="tran-h"></div>
          <?php echo $sub1->name; ?>
        </a>
        <div class="sub-wrapper">
        <?php foreach ($sub1->sub as $sub2) { ?>
          <?php if($sub2->abbr=='zhaopin'):?>
          <a href="<?php echo $webRoot . 'index.php/' .$sub2->abbr."/c" . $sub2->id . ".html"; ?>" class='sub2'>
            <?php echo $sub2->name; ?>
          </a>
          <?php else:?>
          <a href="<?php echo $webRoot . "index.php/article/c" . $sub2->id . ".html"; ?>" class='sub2'>
            <?php echo $sub2->name; ?>
          </a>
          <?php endif;?>
        <?php } ?>
        </div>
      <?php } ?>
    </div>
    <!-- 左边分类列表结束 -->
    <!-- 右边分类列表开始 -->
    <div class="right">
      <div class="top" style="margin-bottom:5px;">
          <div class="name"><?php echo $category->name; ?></div><div style="float:right;font-size: 18px;"><a href="javascript:history.go(-1);">返回上页>></a></div>
      </div>

        <div class="mid">
        <?php echo $category->desc; ?>
        </div>

      
      <table class="zhaopinview">
      	<tr><td style="font-size:20px;" colspan="2"><?php echo $article->title;?></td></tr>
      	<tr><td><?php echo $region;?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo $article->department;?>&nbsp;&nbsp;|&nbsp;&nbsp;招聘人数：<?php echo is_numeric($article->total_number) ? $article->total_number.'人' : $article->total_number;?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font style="color:#ccc;">发布时间：<?php echo substr($article->editedDate, 0, 10);?></font></td><td style="padding-right:10px;" align="right">招聘邮箱：job@essemi.com</td></tr>
	  </table>
	  <table class="zhaopin-content">
      	<tr><td>主要职责：</br><?php echo $article->summary;?></td></tr>
	  	<tr><td>任职要求：</br><?php echo $article->content;?></td></tr>
	  </table>
      
    </div>
    <!-- 右边分类列表结束 -->
  </div>
</div>

<?php include TPL_ROOT . 'common/footer.html.php';?>
