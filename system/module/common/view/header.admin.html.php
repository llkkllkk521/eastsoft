<?php if(!defined("RUN_MODE")) die();?>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php include 'header.lite.html.php';?>
<nav class='navbar navbar-inverse navbar-fixed-top' role='navigation' id='mainNavbar'>
<!--  <div class='navbar-header'>-->
<!--    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#mainNavbarCollapse'>-->
<!--      <span class='icon-bar'></span>-->
<!--      <span class='icon-bar'></span>-->
<!--      <span class='icon-bar'></span>-->
<!--    </button>-->
<!--    --><?php //echo html::a($this->createLink($this->config->default->module), $lang->chanzhiEPSx, "class='navbar-brand'");?>
<!--    <div class='dropdown navbar-header-item'>--><?php //include 'selectlang.html.php';?><!--</div>-->
<!--    <div class='navbar-header-divider angle'></div>-->
<!--  </div>-->
  <div class='collapse navbar-collapse' id='mainNavbarCollapse'>
    <?php echo commonModel::createMainMenu($this->moduleName);?>
    <ul class='nav navbar-nav' id='navbarSwitcher'>
      <li><a href='###'><i class='icon-chevron-sign-right icon-large'></i></a></li>
    </ul>
    <?php echo commonModel::createManagerMenu();?>
  </div>
</nav>

<div class="clearfix row-main">
  <?php $moduleName = $this->moduleName; ?>
  <?php $menuGroup  = zget($lang->menuGroups, $moduleName);?>
  <?php if($moduleName != 'ui' && $menuGroup != 'ui'): ?>
  <?php $moduleMenu = commonModel::createModuleMenu($this->moduleName);?>
  <?php if($moduleMenu or !empty($treeModuleMenu)):?>
  <div class='col-md-2'>
    <div class="leftmenu affix hiddden-xs hidden-sm">
      <?php if($moduleMenu) echo $moduleMenu;?>
      <?php if(!empty($treeModuleMenu)):?>
      <div class='panel category-nav'>
        <div class='panel-body'>
          <?php echo $treeModuleMenu;?>
          <?php if(!empty($treeManageLink)):?>
          <div class='text-right'><?php if(commonModel::hasPriv('tree', 'browse')) echo $treeManageLink;?></div>
          <?php endif;?>
        </div>
      </div>
      <?php endif;?>
    </div>
  </div>
  <div class='col-md-10'>
  <?php endif;?>
  <?php else:?>
  <?php include '../../ui/view/header.html.php';?>
  <?php if(!empty($treeModuleMenu)):?>
  <div class='col-md-2'>
    <div class="leftmenu affix hiddden-xs hidden-sm">
      <div class='panel category-nav'>
        <div class='panel-body'>
          <?php echo $treeModuleMenu;?>
          <?php if(!empty($treeManageLink)):?>
          <div class='text-right'><?php if(commonModel::hasPriv('tree', 'browse')) echo $treeManageLink;?></div>
          <?php endif;?>
        </div>
      </div>
    </div>
  </div>
  <div class='col-md-10'>
  <?php endif;?>
  <?php endif;?>
