<?php if(!defined("RUN_MODE")) die();?>
<?php include TPL_ROOT . 'common/header.html.php';?>
<div class='panel panel-body'>
  <div class='panel panel-pure' id='reset'>
    <div class='panel-heading'><strong><?php echo $lang->user->sendRecoverEmail;?></strong></div>
    <div class='panel-body'>
      <form method='post' id='ajaxForm'>
        <div class='form-group'>
          <?php echo html::input('account', '', "class='form-control' placeholder='{$lang->user->inputAccountOrEmail}'");?>
        </div>
        <?php echo html::submitButton($lang->user->submit,'btn btn-primary btn-block');?>
      </form>
    </div>
  </div>  
</div>
<?php include TPL_ROOT . 'common/footer.html.php';?>
