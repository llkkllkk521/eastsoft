<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The view file of product module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php
include TPL_ROOT . 'common/header.html.php';
include TPL_ROOT . 'common/treeview.html.php';

/* set categoryPath for topNav highlight. */
js::set('path',  $product->path);
js::set('productID', $product->id);
js::set('categoryID', $category->id);
js::set('categoryPath', explode(',', trim($category->path, ',')));
js::set('addToCartSuccess', $lang->product->addToCartSuccess);
js::set('gotoCart', $lang->product->gotoCart);
js::set('goback', $lang->product->goback);
js::set('stockOpened', $stockOpened);
js::set('stock', $product->amount);
css::internal($product->css);
js::execute($product->js);
?>
<div class="main-content">
<?php $common->printPositionBar($category, $product);?>

  <div class="main-box">
    <!-- 左边分类列表开始 -->
    <div class="left">
      <?php foreach ($children as $sub1) { ?>
        <a href="<?php echo $siteRoot . "product/c" . $sub1->id . ".html"; ?>" class='sub1'>
          <div class="arrow-h"></div>
          <div class="tran-h"></div>
          <?php echo $sub1->name; ?>
        </a>
        <div class="sub-wrapper">
        <?php foreach ($sub1->sub as $sub2) { ?>
          <a href="<?php echo $siteRoot . "product/c" . $sub2->id . ".html"; ?>" class='sub2'>
            <?php echo $sub2->name; ?>
          </a>
        <?php } ?>
        </div>
      <?php } ?>
    </div>
    <!-- 左边分类列表结束 -->
    <!-- 右边分类列表开始 -->
    <div class="right">
      <div class="title-box">
        <div class="chi-title"><?php echo $product->name ?></div>
      </div>

      <div class="product-content-title">
        芯片简介
      </div>
      <div class="product-desc">
        <?php
          $product_img = $product->images;
          if (is_array($product_img)) {
            $product_img = $product_img[0]->fullURL;
        ?>
        <div class="product-right-top">
          <img src="<?php echo $product_img ?>">

          <?php foreach ($linked_article as $la) { ?>
            <p>
              <a href="<?php echo $this->createLink('article', 'view', '$articleID=' . $la->id) ?>">
                <?php echo $la->title; ?>
              </a>
            </p>
          <?php } ?>
        </div>
        <?php
          }
        ?>

        <?php echo $product->desc; ?>
      </div>
      <div class="product-content-title">
        文档
        <div class="wrapper">
          <div class="tran"></div>
        </div>
      </div>
      <div class="product-document">
		<?php if($document_article):?>
        <table>

          <tbody>
          <?php foreach ($document_article as $key => $value) { ?>
            <tr class='main-ctg'>
              <td class="a"><?php echo $key ?></td>
              <td class="b">上次更新时间</td>
<!--              <td class="b">大小</td>-->
              <td class="b">操作</td>
            </tr>

            <?php
              $files = array();

              $files = $this->dao->select('*')->from('es_file')
                        ->where('objectType')->eq('article')
                        ->andWhere('objectID')->in(implode(',', $value))
                        ->fetchAll();
            ?>

            <?php foreach ($files as $file) { ?>
              <tr class='document-files'>
                <td class="a"><img src="<?php echo $webRoot ?>img/<?php echo $file->extension ?>.png"><?php echo $file->title; ?></td>
                <td class="b"><?php echo substr($file->addedDate, 0, 10) ?></td>
                <!-- <td></td> -->
                <td class="b">
                  <a href="<?php echo 'file-download-'.$file->id.'-left.html'; ?>" download="<?php echo $file->title; ?>">下载</a>
                </td>
              </tr>
            <?php } ?>

          <?php } ?>
          </tbody>

        </table>
        
        <?php endif;?>
        
      </div>

      <div class="product-content-title">
        产品订购信息
        <div class="wrapper">
          <div class="tran"></div>
        </div>
      </div>

      <div class="product-ctnt">
        <?php echo $product->content; ?>
      </div>

      <div class="product-content-title">
        开发工具
        <div class="wrapper">
          <div class="tran"></div>
        </div>
      </div>

      <div class="product-document">

        <?php if ($deve_data) { ?>
        
        <div class="product-win deve-margin" id="productwin">

          <div class="product-box">

            <div class="fixed-top">
              <div class="a">产品</div>
              <div class="b">芯片型号</div>
              <div class="c">
                <div class="c-a">
                  开发工具
                </div>
                <div class="c-b">
                  <div class="c-b-a">HR10M</div>
                  <div class="c-b-b">HR_Link</div>
                </div>
                <div class="c-c">
                  <div class="c-c-a">仿真支持</div>
                  <div class="c-c-b">编程支持</div>
                  <div class="c-c-c">仿真适配器（选配件）</div>
                  <div class="c-c-d">编程适配版（选配件）</div>
                  <div class="c-c-e">仿真</div>
                  <div class="c-c-f">编程</div>
                </div>
              </div>
              <div class="d">
                <div class="d-a">量产编程工具</div>
                <div class="d-b">HR50S</div>
                <div class="d-c">
                  <div class="d-c-a">编程支持</div>
                  <div class="d-c-b">ISP编程支持</div>
                </div>
              </div>
            </div>

            <table class='parameters' id="param_table">
              <tbody>
                <?php foreach ($deve_data as $key => $value) { ?>
                <tr>
                  <td style="border: 1px solid #000;">
                    <div class="tdw-p">
                    <?php echo $key ?>
                    </div>
                  </td>
                  <?php for ($i=0; $i < count($value[0]); $i++) { ?>
                  <td style="border: 1px solid #000;">
                    <?php for ($j=0; $j < count($value); $j++) { ?>
                    <div class="atr-block tdw-<?php echo $i;?>">
                      <?php echo $value[$j][$i]->value; ?>
                    </div>
                    <?php } ?>
                  </td>
                  <?php } ?>
                </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>
        </div>
        <?php } ?>

      </div>
      
    </div>
  </div>


</div>
<?php include TPL_ROOT . 'common/jplayer.html.php'; ?>
<?php include TPL_ROOT . 'common/footer.html.php'; ?>
