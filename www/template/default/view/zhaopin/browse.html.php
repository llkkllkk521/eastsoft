<?php if(!defined("RUN_MODE")) die();?>
<?php
include TPL_ROOT . 'common/header.html.php';

$path = array_keys($category->pathNames);
js::set('path', $path);
js::set('categoryID', $category->id);

include TPL_ROOT . 'common/treeview.html.php';
?>
<style>
.zhaopin {
    font-size: 12px;
    line-height: 27px;
    width:100%;
    border: 1px solid #ccc;
}
.zhaopin a {
	color:#75AADA;
	font-weight: bold;
}
.tdbg {
	background-color: #eaeaea;
	font-weight: bold;
}
.zhaopin td {
	text-align:center;
    border: 1px solid #ccc;
}
.region-search {
	padding:5px;
	cursor:pointer;
	font-weight: bold;
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
          <div class="name"><?php echo $category->name; ?></div>
      </div>
      <div class="name"><?php echo $category->desc; ?></div>
      <!-- 如果当前页面请求的就是顶级分类 -->
      <?php if ($top_id === $category->id) { ?>
        
        <div class="top">
          <div class="name"><?php echo $category->name; ?></div>
        </div>

        <div class="mid">
          <?php foreach ($children as $sub1) { ?>
          <div class="block">
            <div class="icon">
              <i class="ico<?php echo $sub1->id; ?>"></i>
            </div>
            <div class="ctgs">
              <div class="ctg-sub1">
                <!-- 二级分类不可点击 -->
                <a class='name' ><?php echo $sub1->name; ?></a>
              </div>
              <?php foreach ($sub1->sub as $sub2) { ?>
                <a class="ctg-sub2" href="<?php echo $webRoot . 'index.php/article/c' . $sub2->id . '.html'; ?>">
                  <?php echo $sub2->name; ?>
                </a>
              <?php } ?>
            </div>
            
          </div>
          <?php } ?>
        </div>

      <?php }else{ ?>
      <table width="100%">
      	<tr><td width="75%" align="left">招聘邮箱：<font color=" #077ac7">job@essemi.com</font></td><td align="right" height="30" ><span><?php $this->loadModel('zhaopin')->cateList();?></span><span class="region-search">筛选</span></td></tr>
      </table>
      <table class="zhaopin">
      	<tr class="tdbg"><td>职位</td><td>招聘人数</td><td>工作地点</td><td>更新时间</td></tr>
		<?php foreach($zhaopins as $article):?>
		<tr><td><a href="<?php echo $webRoot.'index.php/'.$article->type.'/'.$article->id.'.html';?>"><?php echo $article->title;?></a></td><td><?php echo $article->total_number;?></td><td><?php echo $this->loadModel('zhaopin')->getRegionsId2Name($article->regions2);;?></td><td><?php echo substr($article->editedDate, 0, 10);?></td></tr>  
		<?php endforeach;?>
	  </table>
	  <?php $pager->show('right', 'short');?>
      <?php } ?>
    </div>
    <!-- 右边分类列表结束 -->
  </div>
</div>
<script>
$(function(){
	$('.region-search').click(function() {
		window.location.href = '/index.php/zhaopin/c<?php echo $category->id;?>.html?region='+$('.region').val();
	});
});
</script>
<?php include TPL_ROOT . 'common/footer.html.php';?>