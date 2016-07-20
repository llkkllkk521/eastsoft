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
<?php include '../../common/view/treeview.html.php';?>
<?php js::set('categoryID', $categoryID);?>
<div class='panel'>
  <div class='panel-heading'>
  <strong><i class="icon-th-large"></i> <?php echo $lang->$type->list;?></strong>
  <?php if($type != 'contribution'):?>
  <div class='panel-actions'>
    <form method='get' class='form-inline form-search'>
      <?php echo html::hidden('m', 'zhaopin');?>
      <?php echo html::hidden('f', 'admin');?>
      <?php echo html::hidden('type', $type);?>
      <?php echo html::hidden('categoryID', $categoryID);?>
      <?php echo html::hidden('orderBy', $orderBy);?>
      <?php echo html::hidden('recTotal', isset($this->get->recTotal) ? $this->get->recTotal : 0);?>
      <?php echo html::hidden('recPerPage', isset($this->get->recPerPage) ? $this->get->recPerPage : 10);?>
      <?php echo html::hidden('pageID', isset($this->get->pageID) ? $this->get->pageID :  1);?>
      <div class="input-group">
        <?php echo html::input('searchWord', $this->get->searchWord, "class='form-control search-query'");?>
        <span class="input-group-btn"><?php echo html::submitButton($lang->search->common, "btn btn-primary"); ?></span>
      </div>
    </form>
     <?php if($type == 'page') commonModel::printLink('zhaopin', 'create', "type={$type}", '<i class="icon-plus"></i> ' . $lang->page->create, 'class="btn btn-primary"');?>
     <?php if($type != 'page') commonModel::printLink('zhaopin', 'create', "type={$type}&category={$categoryID}", '<i class="icon-plus"></i> ' . $lang->zhaopin->create, 'class="btn btn-primary"');?>
   </div>
  <?php endif;?>
  </div>
  <table class='table table-hover table-striped tablesorter'>
    <thead>
      <tr>
        <?php $vars = "type=$type&categoryID=$categoryID&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
        <th class='text-center w-60px'><?php commonModel::printOrderLink('id', $orderBy, $vars, $lang->zhaopin->id);?></th>
        <th class='text-center'><?php commonModel::printOrderLink('title', $orderBy, $vars, $lang->zhaopin->title);?></th>
        <?php if($type != 'page' and $type != 'contribution'):?>
        <th class='text-center w-200px'><?php commonModel::printOrderLink('category', $orderBy, $vars, $lang->zhaopin->category);?></th>
        <?php endif;?>
        <th class='text-center w-160px'><?php commonModel::printOrderLink('addedDate', $orderBy, $vars, $lang->zhaopin->addedDate);?></th>
        <th class='text-center w-70px'><?php commonModel::printOrderLink('views', $orderBy, $vars, $lang->zhaopin->views);?></th>
        <?php if($type != 'page' and commonModel::isAvailable('contribution')):?>
        <th class='text-center w-70px'> <?php commonModel::printOrderLink('contribution', $orderBy, $vars, $lang->zhaopin->status);?></th>
        <?php endif;?>
        <?php $actionClass = $type == 'page' ? 'w-220px' : 'w-260px';?>
        <th class="text-center <?php echo $actionClass;?>"><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php $maxOrder = 0; foreach($articles as $article):?>
      <tr>
        <td class='text-center'><?php echo $article->id;?></td>
        <td>
          <?php echo $article->title;?>
          <?php if($article->sticky):?><span class='label label-danger'><?php echo $lang->zhaopin->stick;?></span><?php endif;?>
          <?php if($article->status == 'draft') echo '<span class="label label-xsm label-warning">' . $lang->zhaopin->statusList[$article->status] .'</span>';?>
        </td>
        <?php if($type != 'page' and $type != 'contribution'):?>
        <td class='text-center'><?php foreach($article->categories as $category) echo $category->name . ' ';?></td>
        <?php endif;?>
        <td class='text-center'><?php echo $article->addedDate;?></td>
        <td class='text-center'><?php echo $article->views;?></td>
        <?php
        if($type != 'page' and commonModel::isAvailable('contribution'))
        {
            echo "<td class='text-center'>" . $lang->contribution->status[$article->contribution] . '</td>';
        }
        ?>
        <td class='text-center'>
          <?php if($type == 'contribution'):?>
          <?php
          if($article->contribution != 2) commonmodel::printlink('zhaopin', 'check', "articleid=$article->id", $lang->contribution->check); 
          else commonModel::printLink('zhaopin', 'edit', "articleID=$article->id&type=$article->type", $lang->edit);
          commonModel::printLink('zhaopin', 'delete', "articleID=$article->id", $lang->delete, 'class="deleter"');
          ?>
          <?php else:?>
          <?php
          commonModel::printLink('zhaopin', 'edit', "articleID=$article->id&type=$article->type", $lang->edit);
          echo html::a($this->zhaopin->createPreviewLink($article->id), $lang->preview, "target='_blank'");
          commonModel::printLink('file', 'browse', "objectType=$article->type&objectID=$article->id&isImage=1", $lang->zhaopin->images, "data-toggle='modal'");
          commonModel::printLink('file', 'browse', "objectType=$article->type&objectID=$article->id&isImage=0", $lang->zhaopin->files, "data-toggle='modal'");
          ?>
          <?php if($type != 'page'):?>
          <span class='dropdown'>
            <a data-toggle='dropdown' href='###'><?php echo $lang->zhaopin->stick; ?><span class='caret'></span></a>
            <ul class='dropdown-menu' role='menu' aria-labelledby='dLabel'>
            <?php
              foreach($lang->zhaopin->sticks as $stick => $label)
              {
                  if($article->sticky != $stick)
                  {
                      echo '<li>';
                      commonModel::printLink('zhaopin', 'stick', "zhaopin=$article->id&stick=$stick", $label, "class='jsoner'");
                      echo '</li>';
                  }
                  else
                  {
                      echo '<li class="active"><a href="###">' . $label . '</a></li>';
                  }
              }
              ?>
            </ul>
          </span>
      <?php endif;?>
          <span class='dropdown'>
            <a data-toggle='dropdown' href='javascript:;'><?php echo $this->lang->more;?><span class='caret'></span></a>
            <ul class='dropdown-menu pull-right'>    
              <li><?php commonModel::printLink('zhaopin', 'delete', "articleID=$article->id", $lang->delete, 'class="deleter"');?></li>
              <li><?php commonModel::printLink('zhaopin', 'setcss', "articleID=$article->id", $lang->zhaopin->css, "data-toggle='modal'");?></li>
              <li><?php commonModel::printLink('zhaopin', 'setjs',  "articleID=$article->id", $lang->zhaopin->js, "data-toggle='modal'");?></li>
              <?php if($type == 'zhaopin'):?>
              <li><?php commonmodel::printlink('zhaopin', 'forward2blog', "articleid=$article->id", $lang->zhaopin->forward2Blog, "data-toggle='modal'");?></li>
              <li><?php commonmodel::printlink('zhaopin', 'forward2forum', "articleid=$article->id", $lang->zhaopin->forward2Forum, "data-toggle='modal'");?></li>
              <?php endif;?>
            </ul>
          </span>
        </td>
      </tr>
      <?php endif;?>
      <?php endforeach;?>
    </tbody>
    <tfoot><tr><td colspan='7'><?php $pager->show();?></td></tr></tfoot>
  </table>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
