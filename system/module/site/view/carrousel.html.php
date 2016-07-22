<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The setlog view file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php js::set('score', commonModel::isAvailable('score'));?>
<?php js::set('setCounts', $lang->site->setCounts);?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-globe'></i> <?php echo $lang->site->setStat;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-inline'>
      <table class='table table-form'>
        <tr>
          <th class='w-100px'><?php echo $lang->site->saveDays;?></th> 
          <td class='w-180px'>
            <div class='input-group'>
              <?php echo html::input('saveDays', isset($this->config->site->saveDays) ? $this->config->site->saveDays : '30', "class='form-control'");?>
              <span class='input-group-addon'><?php echo $lang->date->day;?></span>
            </div>
          </td>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>

<table class='table table-bordered'>
  <thead>
    <tr>
      <th class='text-center'><?php echo $lang->file->id;?></th>
      <th class='text-center'><?php echo $lang->file->common;?></th>
      <th class='text-center'><?php echo $lang->file->extension;?></th>
      <th class='text-center'><?php echo $lang->file->size;?></th>
      <th class='text-center'><?php echo $lang->file->addedBy;?></th>
      <th class='text-center'><?php echo $lang->file->addedDate;?></th>
      <th class='text-center'><?php echo $lang->file->downloads;?></th>
      <th class='text-center'><?php echo $lang->actions;?></th>
    </tr>          
  </thead>
  <tbody>
    <?php foreach($files[null] as $file):?>
    <tr class='text-middle'>
      <td><?php echo $file->id;?></td>
      <td>
        <?php
        if($file->isImage)
        {
            echo html::a(inlink('download', "id=$file->id"), html::image($file->smallURL, "class='image-small' title='{$file->title}'"), "target='_blank'");
            if($file->primary == 1) echo '<small class="label label-success">'. $lang->file->primary .'</small>';
        }
        else
        {
            echo html::a(inlink('download', "id=$file->id"), "{$file->title}.{$file->extension}", "target='_blank'");
        }
        ?>
      </td>
      <td><?php echo $file->extension;?></td>
      <td><?php echo $file->size;?></td>
      <td><?php echo $file->addedBy;?></td>
      <td><?php echo $file->addedDate;?></td>
      <td><?php echo $file->downloads;?></td>
      <td>
      <a href="/admin.php?m=file&amp;f=delete&amp;id=<?php echo $file->id ?>" class="deleter">
        <?php echo $lang->delete; ?>
        </a>
      <!-- <a href="/eastsoft/www/admin.php?m=file&amp;f=setPrimary&amp;id=<?php echo $file->id ?>" class="option">
        <?php echo $lang->file->setPrimary; ?>
      </a> -->
      </td>
    </tr>
    <?php endforeach;?>
  </tbody>

</table>
<form id="fileForm" method='post' enctype='multipart/form-data' action="<?php echo $webRoot ?>admin.php?m=file&f=upload&objectType=carrousel&objectID=">
  <table class='table table-form'>
    <?php if($writeable):?>
    <tr>
      <td class='text-middle'><?php echo $lang->file->upload . sprintf($lang->file->limit, $this->config->file->maxSize / 1024 /1024);?></td>
      <td><?php echo $this->fetch('file', 'buildForm');?></td>
    </tr>
    <tr><td colspan='2' class='text-center'><?php echo html::submitButton();?></td></tr>
    <?php else:?>
    <tr><td colspan='2'><h5 class='text-danger'><?php echo $lang->file->errorUnwritable;?></h5></td></tr>
    <?php endif;?>
  </table>
</form>

<?php include '../../common/view/footer.admin.html.php';?>
