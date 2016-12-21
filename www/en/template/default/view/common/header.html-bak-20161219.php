<?php if(!defined("RUN_MODE")) die();?>
<?php if(helper::isAjaxRequest()):?>
<?php
$webRoot   = $config->webRoot;
$jsRoot    = $webRoot . "js/";
$themeRoot = $webRoot . "theme/";
if(isset($pageCSS)) css::internal($pageCSS);
?>
<div class="modal-dialog" style="width:<?php echo empty($modalWidth) ? 1000 : $modalWidth;?>px;">
  <div class="modal-content">
    <div class="modal-header">
      <?php echo html::closeButton();?>
      <strong class="modal-title"><?php if(!empty($title)) echo $title; ?></strong>
      <?php if(!empty($subtitle)):?>
      <small><?php echo $subtitle;?></small>
      <?php endif;?>
    </div>
    <div class="modal-body">
<?php else:?>

<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>

<?php include TPL_ROOT . 'common/header.lite.html.php';?>

<!-- 头部 -->
<div class="header">
  <div class="main-content">
    <div class="left">
      <div class="logo"></div>
    </div>
    <div class="right">
      <div class="customer">客服热线：</div>
      <div class="tel"></div>
      <div class="login">

        <?php if ($this->app->user->id) { ?>
          <p>
          <?php echo sprintf($lang->welcome, "<a href='" . $webRoot . "user-profile.html'>". $this->app->user->realname . "</a>"); ?>
          </p>
        <?php }else{ ?>
          <a href="<?php echo $siteRoot . 'user-login'?>" class="butn signin">登录</a>
          <a href="<?php echo $siteRoot . 'user-register'?>" class="butn register">注册</a>
        <?php } ?>
        
      </div>
    </div>
  </div>
</div>

<!-- 导航栏 -->
<div class="navigation">
<?php $topNavs = $this->loadModel('nav')->getNavs('desktop_top');?>

  <!-- 顶级导航栏 -->
  <div class="navi-bar">
    <div class="main-content">
      <?php foreach ($topNavs as $topNavi){ ?>
      		<a class='top-navi' href="<?php echo $topNavi->url ?>" target="<?php echo $topNavi->target ?>">
	<?php if ($topNavi->title === '我想'){ ?>
            <i class='people'></i>
          <?php } ?>
          <span <?php echo $topNavi->title === '我想' ? "class='fl'" : ''; ?>>
            <?php echo $topNavi->title; ?>

            <div class="navi-light">
              <div class="shinning"></div>
            </div>
          </span>
        </a>
      <?php } ?>
      <div class="search">
        <div class="select">全部</div>
        <form action="<?php echo $siteRoot . 'search.html' ?>" method="get">
          <input type='text' name='words' placeholder="请输入搜索关键字"></input>
          <input type='submit' class='mag' value=''></input>
        </form>
      </div>
    </div>
  </div>

<?php
  //轮播图
  $carrousel = $this->dao->select('pathname')->from('es_file')
                ->where('objectType')->eq('carrousel')
                ->orderBy('`id`, editor_desc')
                ->fetchAll();
  if($article->id && $category->id) {
  	$_cat = explode(',', $category->path);
  	//$top_id = $_cat[1];
  }
  if($top_id) {
  	$categoryImage = $this->dao->select('pathname')->from('es_file')
  	->where('objectType')->eq('category')
  	->andWhere('objectID')->eq($top_id)
  	->fetch();
  }
  
?>
  <!-- 轮播图 -->
  <div class="carrousel">
      
      <?php if($top_id && $categoryImage && ($thisModuleName != 'index' || $thisModuleName != 'forum' || $thisModuleName != 'thread')) {?>
      <div class="main-content1">
	        <img src="<?php echo $webRoot . 'data/upload/' . $categoryImage->pathname ?>" />
      </div>
      <?php } elseif($thisModuleName == 'index' || $thisModuleName == '') {?>
      <style></style>
      <div class="main-content">
	      <?php foreach ($carrousel as $key => $value) { ?>
	      	<img src="<?php echo $webRoot . 'data/upload/' . $value->pathname ?>" <?php echo $key ? "style='display:none'" : ''; ?> />
		  <?php } ?>
		  <div class="carrousel-panel">
			  <?php foreach ($carrousel as $key => $value) { ?>
			  <div class="panel-btn <?php echo $key ? '' : 'white-back'; ?>"></div>
			  <?php } ?>
		   </div>
      </div>
      <?php } elseif($thisModuleName == 'forum' || $thisModuleName == 'thread') {?>
      <div class="main-content1">
		  <img src="<?php echo $webRoot . 'img/forum.jpg' ?>" />
	  </div>  
	   <?php } else {?>
      <div class="main-content1">
		  <img src="<?php echo $webRoot . 'img/forum.jpg' ?>" />
	  </div> 
      <?php }?>
      
    
  </div>

  <!-- 导航栏下拉 -->
  <div class="navi-drop">
  <?php foreach ($topNavs as $topNavi){ ?>
    <div class="main-content">
      <?php if ($topNavi->children){ ?>
      <!-- 下拉左边，子导航部分 -->
      <div class="left">
      <?php foreach ($topNavi->children as $subNavi) { ?>
        <div class="sub-block">
          <a class="sub-navi" href="javascript:" target="<?php echo $subNavi->target; ?>">
            <?php echo $subNavi->title; ?>
          </a>
          <!-- 三级导航部分 -->
          <?php if ($subNavi->children) { ?>
          <?php foreach ($subNavi->children as $thirdNavi) { ?>
            <a class="third-navi" href="index.php<?php echo $thirdNavi->url; ?>" target="<?php echo $thirdNavi->target; ?>">
            <?php echo $thirdNavi->title; ?>
          </a>
          <?php } ?>
          <?php } ?>
          
        </div>
      <?php } ?>
      </div>
      <!-- 下拉右边，文章图片部分 -->
      <div class="right">
        <?php if ($topNavi->key == 1) { ?>

          
          
        <?php }elseif ($topNavi->key == 2) { ?>
          <!-- 获取公司新闻下的 2 个置顶文章 -->
          <?php $navArticle = $this->loadModel('article')->getLatest(20, 1); ?>

          <?php foreach ($navArticle as $articles) { ?>

            <a class="article-block" href="<?php echo $siteRoot . $articles->type . '/' . $articles->id . '.html'; ?>">
              <img src="<?php echo $articles->image->primary->fullURL; ?>"/>
              <div class="title">
                <?php echo $articles->title; ?>
              </div>
              
            </a>
            
          <?php } ?>
          

        <?php }elseif ($topNavi->key == 3) { ?>



        <?php }elseif ($topNavi->key == 4) { ?>


          
        <?php } ?>
      </div>

      <?php } ?>
    </div>
    <?php } ?>
  </div>
</div>

<?php endif;?>

<!-- 主体部分 -->
<div class="body-container body-middle-container">


