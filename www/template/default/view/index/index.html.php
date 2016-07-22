<?php if(!defined("RUN_MODE")) die();?>
<?php include TPL_ROOT . 'common/header.html.php';?>
<?php include TPL_ROOT . 'common/treeview.html.php';?>

<?php
    if(is_file($_SERVER['DOCUMENT_ROOT'].'360safe/360webscan.php')){
        require_once($_SERVER['DOCUMENT_ROOT'].'360safe/360webscan.php');
    }
?>

<!-- <div id='focus' class='block-list'>
  <div class='row focus-top blocks' data-grid='12' data-region='index_index-top'><?php $this->block->printRegion($layouts, 'index_index', 'top', true);?></div>
  <div class='row focus-middle blocks' data-grid='4' data-region='index_index-middle'><?php $this->block->printRegion($layouts, 'index_index', 'middle', true);?></div>
  <div class='row focus-bottom blocks' data-grid='6' data-region='index_index-bottom'><?php $this->block->printRegion($layouts, 'index_index', 'bottom', true);?></div>
</div> -->

<style>
    .trd0{margin-top: -10px;}
    .trd1{margin-top: 5px;}
</style>

<div class="main-content">
    <!-- 首页内容第一层 -->
    <div class="tier">
        <!-- 左边 SMART 产品 -->
        <div class="home-smart">
            <div class="title-box">
                <div class="chi-title">
                    <a href="<?php echo $siteRoot ?>product/c1.html">SMART产品线</a>
                </div>
                <div class="eng-title">
                    <span>/</span>SMART PRODUCT SERIES
                </div>
            </div>
            <?php foreach ($product as $value) { ?>
                <div class="ctg-block">
                    <div class="left">
                        <div class="triangle"></div>
                    </div>
                    <div class="right">
                        <a href="<?php echo $siteRoot; ?>product/c<?php echo $value->id; ?>.html" class="snd">
                            <?php echo $value->name; ?>
                        </a>
                        <?php foreach ($value->child as $k=>$v) { ?>
                            <a href="<?php echo $siteRoot; ?>product/c<?php echo $v->id; ?>.html" class="trd<?php echo $k; ?>" style="display:block;height:20px;width:100px;text-wrap:normal;color:#6f6f6f;">
                                <?php echo $v->name; ?>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
            <a href="<?php echo $siteRoot ?>product/c1.html" class="more">
                更多 >>
            </a>
        </div>
        <!-- 中间变更通知 -->
        <div class="home-field">
            <div class="title-box">
                <div class="chi-title">
                    <a href="<?php echo $siteRoot ?>article/c19.html">变更通知</a>
                </div>
                <div class="eng-title">
                    <span>/</span>FIELD ORDER
                </div>
            </div>

            <?php foreach ($field as $value) { ?>
            <div class="article-list">
                <div class="dot"></div>
                <a href="<?php echo $siteRoot ?>article/<?php echo $value->id ?>.html">
                    <?php echo mb_substr($value->title, 0, 30, 'utf-8'); ?>
                </a>
                <span class="add-date">
                    <?php echo substr($value->addedDate, 0, 10); ?>
                </span>
            </div>
            <?php } ?>
            <a href="<?php echo $siteRoot ?>article/c19.html" class="more">
                更多 >>
            </a>
        </div>
        <!-- 右边公司新闻 -->
        <div class="home-news">
            <div class="title-box">
                <div class="chi-title">
                    <a href="<?php echo $siteRoot ?>article/c20.html">公司新闻</a>
                </div>
                <div class="eng-title">
                    <div class="eng-title">
                    <span>/</span>COMPANY NEWS
                </div>
                </div>
            </div>
            <?php foreach ($company as $value) { ?>
            <div class="article-list">
                <div class="dot"></div>
                <a href="<?php echo $siteRoot ?>article/<?php echo $value->id ?>.html">
                    <?php echo mb_substr($value->title, 0, 18, 'utf-8'); ?>
                </a>
            </div>
            <?php } ?>
            <a href="<?php echo $siteRoot ?>article/c20.html" class="more" style="bottom: 70px;">
                更多 >>
            </a>
            <div style="margin-top: 40px;" class="download-icon" onmouseover="this.style.cursor='pointer'" onclick="document.location='<?php echo $siteRoot ?>article/c83.html';"></div>
        </div>
    </div>
    <!-- 首页第二层 -->
    <div class="tier">
        <!-- 应用于解决方案 -->
        <div class="home-solution">
            <div class="title-box">
                <div class="chi-title">
                    <a href="<?php echo $siteRoot ?>article/c2.html">应用与解决方案</a>
                </div>
                <div class="eng-title">
                    <div class="eng-title">
                    <span>/</span>APPLICATION AND SOLUTION
                </div>
                </div>
            </div>
            <div class="roll-bar">
                <div class="roll-left">
                    <div class="left-button">
                    </div>
                    <div class="white"></div>
                </div>
                <div class="roll-view">
                <div class="roll-container">

                    <?php foreach ($solution as $value) { ?>
                    <div class="roll-block">
                        <div class="title">
                            <i class="icon ico<?php echo $value->id; ?>"></i>
                            <a href="<?php echo $siteRoot ?>article/c<?php echo $value->id ?>.html">
                                <?php echo $value->name; ?>
                            </a>
                        </div>
                        <a href="<?php echo $siteRoot ?>article/c<?php echo $value->id ?>.html" class="desc">
                            <?php echo $value->desc; ?>
                            <?php
                            $img_url  = $this->dao->select('pathname')->from('es_file')
                                ->where('objectID')->eq($value->id)->limit(5)->fetch();

                            ?>
                            <img src="/data/upload/<?php echo $img_url->pathname; ?>" alt="" />
                        </a>
                    </div>
                    <?php } ?>

                    <?php foreach ($solution as $value) { ?>
                    <div class="roll-block">
                        <div class="title">
                            <i class="icon ico<?php echo $value->id; ?>"></i>
                            <a href="<?php echo $siteRoot ?>article/c<?php echo $value->id ?>.html">
                                <?php echo $value->name; ?>
                            </a>
                        </div>
                        <a href="<?php echo $siteRoot ?>article/c<?php echo $value->id ?>.html" class="desc">
                            <?php
                            $img_url  = $this->dao->select('pathname')->from('es_file')
                                ->where('objectID')->eq($value->id)->limit(1)->fetch();

                            ?>
                            <img src="/data/upload/<?php echo $img_url->pathname; ?>" alt="" />
                        </a>
                    </div>
                    <?php } ?>

                    <?php foreach ($solution as $value) { ?>
                    <div class="roll-block">
                        <div class="title">
                            <i class="icon ico<?php echo $value->id; ?>"></i>
                            <a href="<?php echo $siteRoot ?>article/c<?php echo $value->id ?>.html">
                                <?php echo $value->name; ?>
                            </a>
                        </div>
                        <a href="<?php echo $siteRoot ?>article/c<?php echo $value->id ?>.html" class="desc">
                            <?php
                            $img_url  = $this->dao->select('pathname')->from('es_file')
                                ->where('objectID')->eq($value->id)->limit(1)->fetch();
                            ?>
                            <img src="/data/upload/<?php echo $img_url->pathname; ?>" alt="" />
                        </a>
                    </div>
                    <?php } ?>

                </div>
                </div>
                <div class="roll-right">
                    <div class="right-button">
                    </div>
                    <div class="white"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include TPL_ROOT . 'common/footer.html.php';?>
