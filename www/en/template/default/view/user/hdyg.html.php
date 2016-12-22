<?php if(!defined("RUN_MODE")) die();?>
<?php include TPL_ROOT . 'common/header.html.php';?>
<div class='page-user-control'>
  <div class='row'>
    <?php include TPL_ROOT . 'user/side.html.php';?>
    <div class='col-md-10'>
      <div>
      		<div class="top">
              <div class="name"><?php echo $_title; ?></div>
          </div>
         <?php foreach($articlelist as $article):?>
          <table style="width:100%;height:150px;">
            <tr>
              <td valign="top" style="padding-top:15px;">
                <?php echo $article->image->primary->middleURL ? html::image($article->image->primary->middleURL, " class='thumbnail' style='width:190px;height:180px;'" ) : '';?>
              </td>
              <td width="78%" valign="top" style="border-bottom:1px dashed #ccc;">

              <table width="100%" cellpadding="3">
                <tr>
                  <td width="85%" style="padding-top:15px;">
                    <?php echo html::a('/article/'.$article->id.'.html', $article->title);?>
                  </td>
                  <td style="color:#ccc;padding-top:15px;" align="right">
                    <?php if(!$this->loadModel('article')->getRelevanceProduct($article->id)):?><?php echo substr($article->editedDate, 0, 10);?><?php endif;?>
                  </td>
                </tr>
                <tr>
                  <td colspan="2" style="padding-top:15px;">
                  <?php if($this->loadModel('article')->getRelevanceProduct($article->id)):?>
                  Recommend：
                  <?php foreach($this->loadModel('article')->getRelevanceProduct($article->id) AS $product):?>
                  <?php echo '<span style="padding:0 10px 0 10px;"><a href="/product/'.$product->id.'.html" target="_blank">'.$product->name.'</a></span>';?>
                  <?php endforeach;?>
                  <?php else:?>
                  <?php echo $article->summary;?>
                  <?php endif;?>
                  </td>
                </tr>
              </table>

              </td>
            </tr>
          </table>
          <?php endforeach;?>
      </div>
    </div>
  </div>
</div>
<?php include TPL_ROOT . 'common/footer.html.php';?>
