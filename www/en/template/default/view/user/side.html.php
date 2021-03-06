<?php if(!defined("RUN_MODE")) die();?>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<div class='col-md-2'>
  <ul class='nav nav-primary nav-stacked user-control-nav'>
    <li class='nav-heading'><?php echo $lang->user->control->common;?></li>
    <?php
    ksort($lang->user->control->menus);
    foreach($lang->user->control->menus as $menu)
    {
        $class = '';
        list($label, $module, $method) = explode('|', $menu);

        if(in_array($method, array('thread', 'reply')) && !commonModel::isAvailable('forum')) continue;
        if($method == 'message' && !commonModel::isAvailable('message')) continue;

        if($module == $this->app->getModuleName() && $method == $this->app->getMethodName()) $class .= 'active';

        echo '<li class="' . $class . '">' . html::a($this->createLink($module, $method), $label) . '</li>';
    }
    ?>
    <li>
        <a href="<?php echo $siteRoot . 'user-logout.html' ?>">
            <i class="icon-mail-reply"></i> 退出 <i class="icon-chevron-right"></i>
        </a>
    </li>
  </ul>
</div>
