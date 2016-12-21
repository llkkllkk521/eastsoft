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
<!--          <dd data-toggle='tooltip' data-placement='top' data-original-title='<?php printf($lang->article->lblAddedDate, formatTime($article->addedDate));?>'><i class='icon-time icon-large'></i> <?php echo formatTime($article->addedDate); ?></dd>
          <dd data-toggle='tooltip' data-placement='top' data-original-title='--><?php //printf($lang->article->lblAuthor, $article->author);?><!--'><i class='icon-user icon-large'></i> --><?php //echo $article->author; ?><!--</dd>-->
<!--          --><?php //if($article->source != 'original' and $article->copyURL != ''):?>
<!--          <dt>--><?php //echo $lang->article->sourceList[$article->source] . $lang->colon;?><!--</dt>-->
<!--          --><?php //if($article->source == 'article') $article->copyURL = $this->loadModel('common')->getSysURL() . $this->article->createPreviewLink($article->copyURL);?>
<!--          <dd>--><?php //$article->copyURL ? print(html::a($article->copyURL, $article->copySite, "target='_blank'")) : print($article->copySite); ?><!--</dd>-->
<!--          --><?php //else: ?>
<!--          <span class='label label-success'>--><?php //echo $lang->article->sourceList[$article->source]; ?><!--</span>-->
<!--          --><?php //endif;?>
          <dd class='pull-right'>
            <?php
            if(!empty($this->config->oauth->sina))
            {
                $sina = json_decode($this->config->oauth->sina);
                if(isset($sina->widget)) echo "<div class='sina-widget'>" . $sina->widget . '</div>';
            }
            ?>
            <span class='label label-warning' data-toggle='tooltip' data-placement='top' data-original-title='<?php printf($lang->article->lblViews, $article->views);?>'><i class='icon-eye-open'></i> <?php echo $article->views; ?></span>
          </dd>
        </dl>
        <?php if($article->summary):?>
        <section class='abstract'><strong><?php echo $lang->article->summary;?></strong><?php echo $lang->colon . $article->summary;?></section>
        <?php endif; ?>
      </header>
      <section class='article-content'>
        <?php echo $article->content;?>
      </section>
      <?php if($this->loadModel('article')->getRelevanceProduct($article->id)):?>
      <section class='article-files'></section>
      <section class='article-content'>
        <table class="table table-kindeditor table-bordered " style="width:100%;margin-top:20px;" border="1" cellspacing="0" cellpadding="2">
        <tbody>
        <tr>
	        <td style="background-color:#DFC5A4;">&nbsp;BLOCK</td>
			<td style="background-color:#DFC5A4;">推荐产品名</td>
			<!-- <td style="background-color:#DFC5A4;">特点等</td> -->
		</tr>
		<tr>
			<td><?php echo $article->author;?></td>
			<td>
				<?php foreach($this->loadModel('article')->getRelevanceProduct($article->id) AS $product):?>
			    <?php echo '<span style="padding:0 6px 0 0;"><a href="/en/index.php/product/'.$product->id.'.html" target="_blank">'.$product->name.'</a></span>';?>
			    <?php endforeach;?>
			</td>
			<!-- <td>8位高抗干扰MCU</td> -->
		</tr>
		</tbody>
		</table>
      </section>
      <?php endif;?>
      <?php if(!$this->loadModel('article')->checkRelevance($article->id, 103)):?>
	      <?php if(!empty($article->files)):?>
	      <section class="article-files">
	        <?php $this->loadModel('file')->printFiles($article->files);?>
	      </section>
	      <?php endif;?>
      <?php else:?>
      		<section class="article-files">
	  		<?php if($this->loadModel('user')->isLogon()):?>
				  <?php if(!empty($article->files)):?>
			        <?php $this->loadModel('file')->printFiles($article->files);?>
			      <?php endif;?>
      		<?php else:?>
      		<?php echo html::a('/en/index.php/user-login', $lang->article->loginviewfile);?>
      		<?php endif;?>
      		</section>
      <?php endif;?>
      <footer>
        
        <?php extract($prevAndNext);?>
        <ul class='pager pager-justify'>
          <?php if($prev): ?>
          <li class='previous'><?php echo str_replace('en', 'en/index.php', html::a(inlink('view', "id=$prev->id", "category={$category->alias}&name={$prev->alias}"), '<i class="icon-arrow-left"></i> ' . $prev->title)); ?></li>
          <?php else: ?>
          <li class='preious disabled'><a href='###'><i class='icon-arrow-left'></i> <?php print($lang->article->none); ?></a></li>
          <?php endif; ?>
          <?php if($next):?>
          <li class='next'><?php echo str_replace('en', 'en/index.php', html::a(inlink('view', "id=$next->id", "category={$category->alias}&name={$next->alias}"), $next->title . ' <i class="icon-arrow-right"></i>')); ?></li>
          <?php else:?>
          <li class='next disabled'><a href='###'> <?php print($lang->article->none); ?><i class='icon-arrow-right'></i></a></li>
          <?php endif; ?>
        </ul>
      </footer>
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
<?php include TPL_ROOT . 'common/jplayer.html.php'; ?>
<?php include TPL_ROOT . 'common/footer.html.php'; ?>
