<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The browse view file of product of chanzhiEPS.
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
$path = isset($category->pathNames) ? array_keys($category->pathNames) : array(0);
js::set('path', $path);
js::set('categoryID', $category->id);

include TPL_ROOT . 'common/treeview.html.php';
?>

<div class="main-content">
<?php echo $common->printPositionBar($category, isset($product) ? $product : '');?>

  <div class="main-box">
    <!-- 左边分类列表开始 -->
    <div class="left">
      <?php foreach ($children as $sub1) { ?>
        <a href="javascript:" class='sub1'>
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
      <!-- 如果当前页面请求的就是顶级分类 -->
      <?php if ($top_id === $category->id) { ?>

          <div class="top">
              <div class="name"><?php echo $category->name; ?></div>
          </div>

<!--针对产品顶级分类页面的独立样式-->
        <?php if ($category->id == 1) { ?>

              <div class="mid">
                  <?php foreach ($children as $sub1) { ?>
                      <div class="label-block">
                          <div class="icon">
<!--                              <i class="ico--><?php //echo $sub1->id; ?><!--"></i>-->
                          </div>
                          <div class="ctgs">
                              <div class="ctg-sub1">
                                  <!-- 二级分类不可点击 -->
                                  <a class='name' ><?php echo $sub1->name; ?></a>
                              </div>
                              <?php foreach ($sub1->sub as $sub2) { ?>
                                  <a class="ctg-sub2" href="<?php echo $siteRoot . 'product/c' . $sub2->id . '.html'; ?>">
                                      <?php echo $sub2->name; ?>
                                  </a>
                              <?php } ?>
                          </div>

                      </div>
                  <?php } ?>
              </div>

<!--其他顶级分类的样式-->
        <?php }else{ ?>

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
                                  <a class="ctg-sub2" href="<?php echo $siteRoot . 'product/c' . $sub2->id . '.html'; ?>">
                                      <?php echo $sub2->name; ?>
                                  </a>
                              <?php } ?>
                          </div>

                      </div>
                  <?php } ?>
              </div>

        <?php } ?>


      <!-- 如果当前页面请求的不是顶级分类，以下布局只针对有商品的三级分类，对于二级分类没有考虑 -->
      <?php }else{ ?>
        
        <div class="top">
          <div class="name"><?php echo $category->name; ?></div>
        </div>

        <div class="desc">
          <?php echo $category->desc; ?>
        </div>

        <div class="show-all">
          <a href="<?php echo $this->createLink('product', 'showall', 'categoryID=' . $category->id) ?>" target="_blank">
            <span class='r'>ALL</span>
            <span class='b'>显示所有参数</span>
          </a>
            <a href="/data/source/Cat.03.2016.SMART-03.pdf" style="float: right;">
                <img src="/img/pdf.png">选型手册下载
            </a>
        </div>
        <!--参数表表头，不跟随滑动。开始-->
        <div class="product-box">
            <table class='parameters ctgs' id="param_table">
              <thead>
              <tr>
                  <th align="center">
                      <div class="thHead thHead0">
                      芯片
                      </div>
                  </th>
                  <?php foreach ($attr as $key=>$atr) { ?>
                      <th align="center">
                          <div class="thHead thHead<?php echo $key+1 ?>">
                          <?php echo $atr->name; ?>
                          </div>
                      </th>
                  <?php } ?>
              </tr>
              </thead>
            </table>
        </div>
        <!--参数表表头结束-->
        <!--参数表开始-->
        <div class="product-win" id="productwin">
        
          <div class="product-box">

            <table class='parameters ctgs' id="param_table">

              <tbody>
                <?php foreach ($products as $value) { ?>
                <tr>
                  <td class='product-name'>
                    <div class="thHead thHead0">
                    <a href="<?php echo $this->createLink('product', 'view', 'productID=' . $value->id); ?>">
                    <?php echo $value->name; ?>
                    <?php echo $value->unsaleable ? "<i class='new-icon'></i>" : ''; ?>
                    </a>
                    </div>
                  </td>
                  <?php foreach ($attr as $key=>$atr) { ?>
                    <?php
                    $product_atr = $this->dao->select('t1.*, t2.*')->from('es_product_custom')->alias('t1')
                                    ->leftJoin('es_product_detail')->alias('t2')->on('t1.value = t2.id')
                                    ->where('t1.product')->eq($value->id)
                                    ->andWhere('t1.label')->eq($atr->id)->fetchAll();
                    ?>

                    <td>
                    <div class="thHead thHead<?php echo $key+1 ?>">
                    <?php if ($product_atr) { ?>

                      <?php foreach ($product_atr as $k => $p_a) { ?>

                        <?php if ($k%2) { ?>
                          <div class="atr-block gray-back" style="width: 117%;">
                          <?php echo $p_a->value; ?>
                          </div>
                        <?php }else{ ?>
                          <div class="atr-block" style="width: 117%;">
                          <?php echo $p_a->value; ?>
                          </div>
                        <?php } ?>

                      <?php } ?>

                    <?php }else{ ?>
                      <div class="atr-block"></div>
                    <?php } ?>
                    </div>
                    </td>

                  <?php } ?>
                </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>

        </div><!--.product-win #productwin-->
        <!--参数表结束-->
      <?php } ?>
    </div>
    <!-- 右边分类列表结束 -->
  </div>
</div>

<?php include TPL_ROOT . 'common/footer.html.php';?>
