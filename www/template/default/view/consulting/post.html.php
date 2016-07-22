<?php if(!defined("RUN_MODE")) die();?>
<?php
include TPL_ROOT . 'common/header.html.php';

$path = array_keys($category->pathNames);
js::set('path', $path);
js::set('categoryID', $category->id);

include TPL_ROOT . 'common/treeview.html.php';
include TPL_ROOT . 'common/datepicker.html.php';
?>
<style>
.consultingview {
    
}
.consultingview td {
	height:50px;
}
.consulting-content {
    font-size: 14px;
    line-height: 27px;
    width:100%;
	
}
.consulting-content td {
	padding:10px 0 0 15px;
}
.star-must {
	color:red;
	padding:5px 6px 0 0;
	font-size:16px;
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
          <?php if($sub2->abbr=='consulting'):?>
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
      <?php echo $result['message'];?>
      <?php if($result['result']=='success') header("Refresh:3;url=/");?>
    </div>
    <!-- 右边分类列表结束 -->
  </div>
</div>

<?php include TPL_ROOT . 'common/footer.html.php';?>