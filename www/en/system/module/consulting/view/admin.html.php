<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The admin view file of zhaopin of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     zhaopin
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-th-large"></i> </strong>
  <?php if($type != 'contribution'):?>
  <div class='panel-actions'>
    <form method='get' class='form-inline form-search'>
      <?php echo html::hidden('m', 'consulting');?>
      <?php echo html::hidden('f', 'admin');?>
      <?php echo html::hidden('orderBy', $orderBy);?>
      <?php echo html::hidden('recTotal', $recTotal);?>
      <?php echo html::hidden('recPerPage', $recPerPage);?>
      <?php echo html::hidden('pageID', $pageID);?>
      <div class="input-group">
        <?php echo html::input('searchWord', $this->get->searchWord, "class='form-control search-query'");?>
        <span class="input-group-btn"><?php echo html::submitButton($lang->search->common, "btn btn-primary"); ?></span>
      </div>
    </form>
   </div>
  <?php endif;?>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr>
       <th class='w-60px'>用户名</th>
       <th class='w-60px'>移动电话</th>
       <th class='w-60px'>固定电话</th>
       <th class='w-60px'>电子邮件</th>
       <th class='w-60px'>需求类型</th>
       <th class='w-60px'>应用领域</th>
       <th class='w-60px'>产品</th>
       <th class='w-60px'>购买时间</th>
       <th class='w-60px'>销售服务单位</th>
       <th class='w-60px'>操作</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($consultings as $consulting):?>
      <tr>
        <td><?php echo $consulting->realname;?></td>
        <td><?php echo $consulting->mobile;?></td>
        <td><?php echo $consulting->phone;?></td>
        <td><?php echo $consulting->email;?></td>
        <td><?php echo $consulting->needtype;?></td>
        <td><?php echo $consulting->application;?></td>
        <td><?php echo $consulting->product;?></td>
        <td><?php echo $consulting->buyDate;?></td>
        <td><?php echo $consulting->company;?></td>
        
        <td><a href="javascript:window.open('/admin.php?m=consulting&f=dayin&consultingID=<?php echo $consulting->id;?>','newwindow','height=500, width=800');">查看</a>&nbsp;&nbsp;<?php commonModel::printLink('consulting', 'delete', "consultingeID=$consulting->id", $lang->delete, 'class="deleter"');?></td>
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
