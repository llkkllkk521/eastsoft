<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The browse view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-columns'></i> <?php echo $lang->block->browseRegion;?></strong></div>
  <table class='table table-bordered table-hover table-striped'>
    <tr>
      <th class='w-200px'><?php echo $lang->block->page;?></th>
      <th class='text-center'><?php echo $lang->block->regionList;?></th>
    </tr>
    <?php foreach($this->lang->block->$template->pages as $page => $name):?>
    <?php if(empty($lang->block->$template->regions->$page)) continue;?>
    <tr>
      <td><?php echo $name;?></td>
      <td>
      <?php
      $regions = $lang->block->$template->regions->$page;
      foreach($regions as $region => $regionName)
      {
          commonModel::printLink('block', 'setregion', "page={$page}&region={$region}", $regionName, "class='btn btn-xs' data-toggle='modal'");
      }
      ?>
      </td>
    </tr>
    <?php endforeach;?>
  </table>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
