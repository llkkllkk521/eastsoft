<?php if(!defined("RUN_MODE")) die();?>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<!-- <div class='blocks all-bottom row' data-region='all-bottom'>
    <?php $this->loadModel('block')->printRegion($layouts, 'all', 'bottom', true);?>
  </div>
  </div>
  </div> -->
<!-- end div.page-content then div.page-wrapper in header.html.php -->

</div>
<!-- end body-container -->

<div class="footer">
    <div class="main-content big" style="clear: both">
        <div class="block">

            <?php
            $abt_top = $this->dao->select('id,name')->from('es_category')
                ->where('id')->eq(28)->fetch();

            $aboutus = $this->dao->select('id,name')->from('es_category')
                ->where('parent')->eq(28)->limit(5)
                ->fetchAll();
            ?>
            <p class="top">
                <a href="<?php echo $siteRoot . 'article/c' . $abt_top->id . '.html'; ?>">
                    <?php echo $abt_top->name; ?>
                </a>
            </p>
            <?php foreach ($aboutus as $key => $value) { ?>
                <p class="sub">
                    <a href="<?php echo $siteRoot . 'article/c' . $value->id . '.html'; ?>">
                        <?php echo $value->name; ?>
                    </a>
                </p>
            <?php } ?>

        </div>
        <div class="block">

            <p class="top">
                <a href="<?php echo $siteRoot . 'product/c1.html'; ?>">Product</a>
            </p>
            <!--        --><?php //
            //        $products = $this->dao->select('*')->from('es_category')
            //                ->where('type')->eq('product')
            //                ->andWhere('parent')->eq(1)->orderBy('`order`')->limit(5)
            //                ->fetchAll();
            //        ?>
            <!--        --><?php //foreach ($products as $key => $value) { ?>
            <!--        <p class="sub">-->
            <!--          <a href="--><?php //echo $value->id==8 ? 'javascript:' : $siteRoot . 'product/c'.$value->id.'.html'; ?><!--">-->
            <!--            --><?php //echo $value->name; ?>
            <!--          </a>-->
            <!--        </p>-->
            <!--        --><?php //} ?>

            <p class="sub">
                <a href="/product/c108.html">
                    Security（S）
                </a>
            </p>
            <p class="sub">
                <a href="/product/c11.html">
                    MCU（M）
                </a>
            </p>
            <p class="sub">
                <a href="/product/c15.html">
                    ASIC（A）
                </a>
            </p>
            <p class="sub">
                <a href="/product/c13.html">
                    RF Transceiver（R）
                </a>
            </p>
            <p class="sub">
                <a href="/product/c17.html">
                    Touch Key（T）
                </a>
            </p>

        </div>
        <div class="block">

            <?php
            $tch_top  = $this->dao->select('id,name')->from('es_category')
                ->where('id')->eq(3)->fetch();

            $tech     = $this->dao->select('id,name')->from('es_category')
                ->where('parent')->eq(3)->limit(3)
                ->fetchAll();
            ?>
            <p class="top">
                <a href="<?php echo $siteRoot . 'article/c' . $tch_top->id . '.html'; ?>">
                    <?php echo $tch_top->name; ?>
                </a>
            </p>
            <?php foreach ($tech as $key => $value) { ?>
                <p class="sub">
                    <a href="<?php echo $siteRoot . 'article/c' . $value->id . '.html'; ?>">
                        <?php echo $value->name; ?>
                    </a>
                </p>
            <?php } ?>
            <p class="sub">
                <a href="<?php echo $siteRoot . 'article/c81.html'; ?>">培训中心</a>
            </p>
            <p class="sub">
                <a href="<?php echo $siteRoot . 'article/c83.html'; ?>">应用文档</a>
            </p>

        </div>
        <div class="block">

            <?php
            $news_top  = $this->dao->select('id,name')->from('es_category')
                ->where('id')->eq(29)->fetch();

            $news     = $this->dao->select('id,name')->from('es_category')
                ->where('parent')->eq(29)->limit(5)
                ->fetchAll();
            ?>
            <p class="top">
                <a href="<?php echo $siteRoot . 'article/c' . $news_top->id . '.html'; ?>">
                    <?php echo $news_top->name; ?>
                </a>
            </p>
            <?php foreach ($news as $key => $value) { ?>
                <p class="sub">
                    <a href="<?php echo $siteRoot . 'article/c' . $value->id . '.html'; ?>">
                        <?php echo $value->name; ?>
                    </a>
                </p>
            <?php } ?>

        </div>
        <div class="block">

            <?php
            $news_top  = $this->dao->select('id,name')->from('es_category')
                ->where('id')->eq(84)->fetch();

            $news     = $this->dao->select('id,name')->from('es_category')
                ->where('parent')->eq(84)->limit(5)
                ->fetchAll();
            ?>
            <p class="top">
                <a href="<?php echo $siteRoot . 'article/c' . $news_top->id . '.html'; ?>">
                    <?php echo $news_top->name; ?>
                </a>
            </p>
            <?php foreach ($news as $key => $value) { ?>
                <p class="sub">
                    <a href="<?php echo $siteRoot . 'article/c' . $value->id . '.html'; ?>">
                        <?php echo $value->name; ?>
                    </a>
                </p>
            <?php } ?>

        </div>
    </div>

    <div class="main-content" style="margin-top: 10px;margin-bottom: 10px;">
        <div class="footmenu" style="float: left;">
            <a class="s1" target="_blank" rseat="Join us" title="Join us" rel="nofollow" href="/en/index.php/zhaopin/c78.html">Join us</a>
            <span style="padding-left: 3px;padding-right: 3px;">|</span>
            <a target="_blank" rseat="Partners" title="Partners" rel="nofollow" href="/en/index.php/page/54.html">Partners</a>
            <span style="padding-left: 3px;padding-right: 3px;">|</span>
            <a target="_blank" rseat="Links" title="Links" rel="nofollow" href="/en/index.php/page/55.html">Links</a>
            <span style="padding-left: 3px;padding-right: 3px;">|</span>
            <a target="_blank" rseat="Sitemap" title="Sitemap" rel="nofollow" href="/en/index.php/sitemap.html">Sitemap</a>
            <span style="padding-left: 3px;padding-right: 3px;">|</span>
            <a target="_blank" rseat="Legal" title="Legal" rel="nofollow" href="/en/index.php/page/56.html">Legal</a>
        </div><script src="http://s95.cnzz.com/z_stat.php?id=1259291737&web_id=1259291737 
" language="JavaScript"></script>
        <div style="float: right;">Copyright 2016&nbsp; <a href="/">上海东软载波微电子有限公司</a>版权所有 沪ICP备07005227号</div>
    </div>
 <div style="text-align:center;"><img src="../../img/foot.jpg"  alt="" width="327" height="48"/><a href='http://www.sgs.gov.cn/lz/licenseLink.do?method=licenceView&entyId=20120227152149763' target='_blank'><img src='../../img/gs.png' border=0></a>
</div>
<script>(function(){var c=document.createElement("script"),s=document.getElementsByTagName("script")[0];c.src="//kefu.qycn.com/vclient/state.php?webid=41014";s.parentNode.insertBefore(c,s);})();</script>
</div>
 
<script type="text/javascript">
    var p = window.location.pathname;

    if (p !== '/' && p !== '/index.php' && p !== '/index.html') {
        $('.navigation').css('min-height', '260px');
        $('.navigation').find('.carrousel').height(210);
        $('.navigation').find('.carrousel').find('.main-content').height(190);
    }

</script>

<!-- <footer id='footer' class='clearfix'>
    <div class='wrapper'>
      <div id='footNav'>
        <?php
echo html::a($this->createLink('sitemap', 'index'), "<i class='icon-sitemap'></i> " . $lang->sitemap->common, "class='text-link'");

if(empty($this->config->links->index) && !empty($this->config->links->all)) echo '&nbsp;' . html::a($this->createLink('links', 'index'), "<i class='icon-link'></i> " . $this->lang->link);
?>
      </div>
      <span id='copyright'>
        <?php
$copyright = empty($config->site->copyright) ? '' : $config->site->copyright . '-';
$contact   = json_decode($config->company->contact);
$company   = (empty($contact->site) or $contact->site == $this->server->http_host) ? $config->company->name : html::a('http://' . $contact->site, $config->company->name, "target='_blank'");
echo "&copy; {$copyright}" . date('Y') . ' ' . $company . '&nbsp;&nbsp;';
?>
      </span>
      <span id='icpInfo'>
        <?php if(!empty($config->site->icpLink) and !empty($config->site->icpSN)) echo html::a(strpos($config->site->icpLink, 'http://') !== false ? $config->site->icpLink : 'http://' . $config->site->icpLink, $config->site->icpSN, "target='_blank'");?>
        <?php if(empty($config->site->icpLink) and !empty($config->site->icpSN))  echo $config->site->icpSN;?>
      </span>
      <div id='powerby'>
        <?php printf($lang->poweredBy, $config->version, k(), "<span class='icon icon-chanzhi'><i class='ic1'></i><i class='ic2'></i><i class='ic3'></i><i class='ic4'></i><i class='ic5'></i><i class='ic6'></i><i class='ic7'></i></span> <span class='name'>" . $lang->chanzhiEPSx . '</span>' . $config->version); ?>
      </div>
    </div>
  </footer> -->
<?php
if($config->debug) js::import($jsRoot . 'jquery/form/min.js');
if(isset($pageJS)) js::execute($pageJS);

/* Load hook files for current page. */
$extPath      = dirname(__FILE__) . '/ext/';
$extHookRule  = $extPath . 'footer.front.*.hook.php';
$extHookFiles = glob($extHookRule);
if($extHookFiles) foreach($extHookFiles as $extHookFile) include $extHookFile;

/* Load hook file for site.*/
$siteExtPath  = dirname(__FILE__) . DS . "ext/_{$config->site->code}/";
$extHookRule  = $siteExtPath . 'footer.front.*.hook.php';
$extHookFiles = glob($extHookRule);
if($extHookFiles) foreach($extHookFiles as $extHookFile) include $extHookFile;
?>
<a href='#' id='go2top' class='icon-arrow-up' data-toggle='tooltip' title='<?php echo $lang->back2Top; ?>'></a>
</div><?php /* end "div.page-container" in "header.html.php" */ ?>
<?php $qrcode = isset($this->config->ui->QRCode) ? $this->config->ui->QRCode : 1;?>
<?php if($qrcode) include dirname(__FILE__) . DS . 'qrcode.html.php';?>
<div class='hide'><?php if(RUN_MODE == 'front') $this->loadModel('block')->printRegion($layouts, 'all', 'footer');?></div>
<?php if(commonModel::isAvailable('shop')) include TPL_ROOT . 'common/cart.html.php';?>
<?php include TPL_ROOT . 'common/log.html.php';?>
<?php if(commonModel::isAvailable('score') and (!isset($this->config->site->resetMaxLoginDate) or $this->config->site->resetMaxLoginDate < date('Y-m-d'))):?>
    <script>$.get(createLink('score', 'resetMaxLogin'));</script>
<?php endif;?>
</body>
</html>
