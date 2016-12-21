<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The setbasic view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      xiying Guang <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<?php js::set('location', $location)?>
<?php include '../../common/view/kindeditor.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->site->setSmtp;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='securityForm' class='form-inline'>
      <table class='table table-form'>
        <tr>
          <th class='w-200px'>发信人邮箱</th>
          <td colspan='3'>
            <?php echo html::input('usermail', $this->config->crontab->usermail, "");?>
          </td>
        </tr>
        <tr>
          <th class='w-200px'>smtp服务器地址</th>
          <td colspan='3'>
            <?php echo html::input('smtpserver', $this->config->crontab->smtpserver, "");?>
          </td>
        </tr>
        <tr>
          <th class='w-200px'>smtp服务器端口</th>
          <td colspan='3'>
            <?php echo html::input('smtpport', $this->config->crontab->smtpport, "");?>
          </td>
        </tr>
        <tr>
          <th class='w-200px'>smtp密码</th>
          <td colspan='3'>
            <?php echo html::password('smtppasswd', $this->config->crontab->smtppasswd, "");?>
          </td>
        </tr>
        <tr>
          <th></th>
          <td colspan='2'>
            <?php echo html::a($this->createLink('guarder', 'validate', "url=&target=modal&account=&type=okFile"), $lang->save, "data-toggle='modal' class='hidden captchaModal'")?>
            <?php echo html::submitButton();?>
          </td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.modal.html.php';?>
