<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The create view file of article module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php js::set('type', $type);?>
<?php js::set('contribution', $this->config->article->contribution);?>
<?php js::set('categoryID', $currentCategory);?>
<?php include '../../common/view/kindeditor.html.php';?>
<?php include '../../common/view/chosen.html.php';?>

<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-plus'></i>&nbsp;
    <?php if($type == 'blog'):?>
    <?php echo $lang->blog->create;?>
    <?php elseif($type == 'page'):?>
    <?php echo $lang->page->create;?>
    <?php else:?>
    <?php echo $lang->zhaopin->create;?>
    <?php endif;?>
  </strong></div>
  <div class='panel-body'>
    <form method='post' role='form' id='ajaxForm'>
      <table class='table table-form'>
        <?php if($type != 'page'):?>
        <tr>
          <th class='w-100px'><?php echo $lang->zhaopin->category;?></th>
          <td class='w-p40'><?php echo html::select("categories[]", $categories, $currentCategory, "multiple='multiple' class='form-control chosen'");?></td><td></td>
        </tr>
        <tbody class='articleInfo'> 
        <tr>
          <th><?php echo $lang->zhaopin->author;?></th>
          <td><?php echo html::input('author', $app->user->realname, "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->zhaopin->source;?></th>
          <?php array_pop($lang->zhaopin->sourceList);?>
          <td><?php echo html::select('source', $lang->zhaopin->sourceList, 'original', "class='form-control chosen'");?></td>
          <td>
            <div class='row' id='copyBox'>
              <div class='col-md-4'><?php echo html::input('copySite', '', "class='form-control' placeholder='{$lang->zhaopin->copySite}'"); ?> </div>
              <div class='col-md-8'><?php echo html::input('copyURL',  '', "class='form-control' placeholder='{$lang->zhaopin->copyURL}'"); ?></div>
            </div>
          </td>
        </tr>
        </tbody>
        <?php endif; ?>
        <tr>
          <th class='w-100px'><?php echo $lang->zhaopin->title;?></th>
          <td colspan='2'>
            <div class='row order input-group'>
              <div class="col-sm-<?php echo $type == 'page' ? '9' : '12';?>"><?php echo html::input('title', '', "class='form-control'");?></div>
              <?php if($type == 'page'):?>
              <div class='col-sm-3 order'>
                <div class='input-group'>
                  <span class="input-group-addon"><?php echo $lang->zhaopin->order;?></span>
                  <?php echo html::input('order', $order, "class='form-control'");?>
                </div>
              </div>
              <?php endif;?>
              <span class="input-group-addon w-70px">
                <label class='checkbox'>
                <?php echo "<input type='checkbox' name='isLink' id='isLink' value='1' /><span>{$lang->zhaopin->isLink}</span>" ?>
                </label>
              </span>
            </div>
          </td>
        </tr>
        <tr class='link'>
          <th><?php echo $lang->zhaopin->link;?></th>
          <td colspan='2'>
            <div class='required required-wrapper'></div>
            <?php echo html::input('link', '', "class='form-control' placeholder='{$lang->zhaopin->placeholder->link}'");?>
          </td>
        </tr>
        <tbody class='articleInfo'>
        <tr>
          <th><?php echo $lang->zhaopin->alias;?></th>
          <td colspan='2'>
            <div class='input-group'>
              <?php if($type == 'page'):?>
              <span class='input-group-addon'>http://<?php echo $this->server->http_host . $config->webRoot;?>page/</span>
              <?php else:?>
              <span class='input-group-addon'>http://<?php echo $this->server->http_host . $config->webRoot . $type;?>/id_</span>
              <?php endif;?>
              <?php echo html::input('alias', '', "class='form-control' placeholder='{$lang->alias}'");?>
              <span class="input-group-addon w-70px">.html</span>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->zhaopin->keywords;?></th>
          <td colspan='2'><?php echo html::input('keywords', '', "class='form-control' placeholder='{$lang->keywordsHolder}'");?></td>
        </tr>
        <tr>
        <th><?php echo $lang->zhaopin->total_number;?></th>
        <td colspan='2'> <?php echo html::input('total_number', '', "class='form-control' placeholder=''");?></td>
      </tr>
      <tr>
        <th><?php echo $lang->zhaopin->area;?></th>
        <td colspan='2'>
        <?php echo html::select("regions1", $regions1, '21', "' class='form-control chosen'");?>
        <?php echo html::select("regions2", $regions2, '', "' class='form-control'");?>
        <?php echo html::select("regions3", $regions3, '', "' class='form-control'");?>
        </td>
      </tr>
      <tr>
        <th><?php echo $lang->zhaopin->department;?></th>
        <td colspan='2'> <?php echo html::input('department', '', "class='form-control' placeholder=''");?></td>
      </tr>
        <tr>
          <th><?php echo $lang->zhaopin->summary;?></th>
          <td colspan='2'><?php echo html::textarea('summary', '', "rows='12' class='form-control'");?></td>
        </tr>
        </tbody>
        <tbody class='articleInfo'>
        <tr>
          <th><?php echo $lang->zhaopin->content;?></th>
          <td colspan='2'><?php echo html::textarea('content', '', "rows='12' class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->zhaopin->addedDate;?></th>
          <td>
            <div class="input-append date">
              <?php echo html::input('addedDate', date('Y-m-d H:i'), "class='form-control'");?>
              <span class='add-on'><button class="btn btn-default" type="button"><i class="icon-calendar"></i></button></span>
            </div>
          </td>
          <td><span class="help-inline"><?php echo $lang->zhaopin->placeholder->addedDate;?></span></td>
        </tr>
        <tr>
          <th><?php echo $lang->zhaopin->status;?></th>
          <td><?php echo html::radio('status', $lang->zhaopin->statusList, 'normal');?></td>
        </tr>
        </tbody>
        <tr>
          <td></td>
          <td colspan='2'><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script>
$(document).ready(function() {
    $('#regions1').change(function() {
        $.post('<?php echo $webRoot.'admin.php?m=zhaopin&f=getArea'?>', {p_region_id:$(this).val()}, function(data) {
            $('#regions2').empty();
            $('#regions2').append(data);
        });
    });
    $('#regions2').change(function() {
        $.post('<?php echo $webRoot.'admin.php?m=zhaopin&f=getArea'?>', {p_region_id:$(this).val()}, function(data) {
            $('#regions3').empty();
            $('#regions3').append(data);
        });
    });
});
</script>
<?php include '../../common/view/footer.admin.html.php';?>
