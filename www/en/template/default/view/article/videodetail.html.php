<?php if(!defined("RUN_MODE")) die();?>
<?php
include TPL_ROOT . 'common/header.html.php';
include TPL_ROOT . 'common/treeview.html.php';

/* set categoryPath for topNav highlight. */
js::set('path', $article->path);
js::set('articleID', $article->id);
js::set('categoryID', $category->id);
js::set('categoryPath', explode(',', trim($category->path, ',')));
css::internal($article->css);
js::execute($article->js);
?>
<?php $common->printPositionBar($category, $article);?>
<div class='row blocks' data-region='article_view-topBanner'><?php $this->block->printRegion($layouts, 'article_view', 'topBanner', true);?></div>
<div class='row'>
  <div class='col-md-9 col-main'>
    <div class='row blocks' data-region='article_view-top'><?php $this->block->printRegion($layouts, 'article_view', 'top', true);?></div>
    <div class='article' id='article' data-id='<?php echo $article->id;?>'>
      <header>
        <h1><?php echo $article->title;?></h1>
        <dl class='dl-inline'>
          <dd class='pull-right'>
            <span class='label label-warning' data-toggle='tooltip' data-placement='top' data-original-title='<?php printf($lang->article->lblViews, $article->views);?>'><i class='icon-eye-open'></i> <?php echo $article->views; ?></span>
          </dd>
        </dl>
        <?php if($article->summary):?>
        <section class='abstract'><strong><?php echo $lang->article->summary;?></strong><?php echo $lang->colon . $article->summary;?></section>
        <?php endif; ?>
      </header>
      <section class='article-content'>
        <script src="52player/flowplayer-3.2.11.min.js" type="text/javascript"></script>
		<div id="my52player" style="margin:0 auto;width: 650px; height: 450px;">    </div>
		<script>flowplayer("my52player", "52player/flowplayer-3.2.12.swf", { clip: { url: "<?php echo $article->link?$article->link:'data/upload/'.$videoinfo->pathname;?>", autoPlay: false, autoBuffering: true} });</script>
      </section>
    </div>
    <div class='row blocks' data-region='article_view-bottom'><?php $this->block->printRegion($layouts, 'article_view', 'bottom', true);?></div>
    <?php if(commonModel::isAvailable('message')):?>
    <div id='commentBox'><?php echo $this->fetch('message', 'comment', "objectType=article&objectID={$article->id}");?></div>
    <?php endif;?>
  </div>
  <div class='col-md-3 col-side'>
<!--      <side class='page-side blocks' data-region='article_view-side'>--><?php //$this->block->printRegion($layouts, 'article_view', 'side');?><!--</side>-->
  </div>
</div>
<div class='row blocks' data-region='article_view-bottomBanner'><?php $this->block->printRegion($layouts, 'article_view', 'bottomBanner', true);?></div>
<script type="text/javascript">
$('.navigation').css('min-height','260px');
$('.carrousel').css('height','210px');
</script>
<?php include TPL_ROOT . 'common/footer.html.php'; ?>
