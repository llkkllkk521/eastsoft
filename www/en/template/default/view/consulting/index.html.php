<?php if(!defined("RUN_MODE")) die();?>
<?php
include TPL_ROOT . 'common/header.html.php';

$path = array_keys($category->pathNames);
js::set('path', $path);
js::set('categoryID', $category->id);

include TPL_ROOT . 'common/treeview.html.php';
include TPL_ROOT . 'common/datepicker.html.php';
?>
<style>
.consultingview {
    
}
.consultingview td {
	height:50px;
}
.consulting-content {
    font-size: 14px;
    line-height: 27px;
    width:100%;
	
}
.consulting-content td {
	padding:10px 0 0 15px;
}
.star-must {
	color:red;
	padding:5px 6px 0 0;
	font-size:16px;
}
</style>
<div class="main-content">
  <?php echo $common->printPositionBar($category);?>

  <div class="main-box">
    <!-- 左边分类列表开始 -->
    <div class="left">
      <?php foreach ($children as $sub1) { ?>
        <a href="<?php echo $webRoot . "index.php/article/c" . $sub1->id . ".html"; ?>" class='sub1'>
          <div class="arrow-h"></div>
          <div class="tran-h"></div>
          <?php echo $sub1->name; ?>
        </a>
        <div class="sub-wrapper">
        <?php foreach ($sub1->sub as $sub2) { ?>
          <?php if($sub2->abbr=='consulting'):?>
          <a href="<?php echo $webRoot . 'index.php/' .$sub2->abbr."/c" . $sub2->id . ".html"; ?>" class='sub2'>
            <?php echo $sub2->name; ?>
          </a>
          <?php else:?>
          <a href="<?php echo $webRoot . "index.php/article/c" . $sub2->id . ".html"; ?>" class='sub2'>
            <?php echo $sub2->name; ?>
          </a>
          <?php endif;?>
        <?php } ?>
        </div>
      <?php } ?>
    </div>
    <!-- 左边分类列表结束 -->
    <!-- 右边分类列表开始 -->
    <div class="right">
      <div class="top" style="margin-bottom:5px;">
          <div class="name"><?php echo $category->name; ?></div>
      </div>
      <form action="/index.php?m=consulting&f=post" method="post" class="consult-post">
       <table class="consultingview table table-form">
      	<tr>
	      	<td align="left">姓名<b class="star-must">*</b>：</td>
	      	<td><input type="text" name="realname" class="realname" value=""></td>
      	</tr>
      	<tr>
	      	<td align="left">移动电话<b class="star-must">*</b>：</td>
	      	<td><input type="text" name="mobile" class="mobile" value="">&nbsp;&nbsp;&nbsp;固定电话：<input type="text" name="phone" class="phone" value=""></td>
      	</tr>
      	<tr>
	      	<td align="left">电子邮件<b class="star-must">*</b>：</td>
	      	<td><input type="text" name="email" class="email" value=""></td>
      	</tr>
      	<tr>
	      	<td align="left">地址<b class="star-must">*</b>：</td>
	      	<td><input type="text" name="province" class="province" value="">省&nbsp;&nbsp;<input type="text" name="city" class="city" value="">市&nbsp;&nbsp;<input type="text" name="county" class="county" value="">区&nbsp;&nbsp;<input type="text" name="address" class="address" value="" placeholder="请填写快递可到达的地址"></td>
      	</tr>
      	<tr>
	      	<td align="left">需求类型<b class="star-must">*</b>：</td>
	      	<td><?php echo html::radio('needtype', $lang->consulting->needtypeList, '技术支持', ' class="needtype"');?></td>
      	</tr>
      	<tr>
	      	<td align="left">需求内容<b class="star-must">*</b>：</td>
	      	<td><?php echo html::radio('needcontent', $lang->consulting->needContent, '芯片', ' class="needcontent"');?></td>
      	</tr>
      	<tr>
	      	<td align="left">产品：</td>
	      	<td><?php echo html::radio('product', $lang->consulting->productList, '', ' class="product"');?></td>
      	</tr>
      	<tr>
	      	<td align="left">应用领域<b class="star-must">*</b>：</td>
	      	<td><?php echo html::radio('application', $lang->consulting->applicationList, '消费电子', ' class="application"');?></td>
      	</tr>
      	<tr>
	      	<td align="left"><span class="pt">产品型号</span>：</td>
	      	<td><input type="text" name="tooltype" class="tooltype" value=""></td>
      	</tr>
      	<tr class="gmsj">
	      	<td align="left">购买时间：</td>
	      	<td class="input-append date">
			<?php echo html::input('buyDate', date('Y-m-d H:i'), "class='form-control'");?>
    			<span class='add-on' style="margin-top:9px"><button class="btn btn-default" type="button"><i class="icon-calendar"></i></button></span>
			</td>
      	</tr>
      	<tr class="xsfwdw">
	      	<td align="left">销售服务单位：</td>
	      	<td><input type="text" name="company" class="company" value=""></td>
      	</tr>
      	<tr>
	      	<td align="left">用户需求<b class="star-must">*</b>：</td>
	      	<td><textarea name="need" class="need" rows="5" cols="60"></textarea></td>
      	</tr>
		<tr>
	      	<td align="left">验证码：<b class="star-must">*</b>：</td>
	      	<td><img src="/verifycode.php?vc=<?php echo $vc;?>" id="getcode_num" title="看不清，点击换一张">&nbsp;<input type="text" name="verifycode" class="verifycode" value="" size="7"><input type="hidden" name="vc" class="vc" value="<?php echo $vc;?>"></td>
      	</tr>
      	<tr>
	      	<td>&nbsp;</td>
	      	<td><input type="button" value="提交" class="btn btn-primary" ></td>
      	</tr>
	  </table>
	  </form>
    </div>
    <!-- 右边分类列表结束 -->
  </div>
</div>
<script type="text/javascript">
$(function() {
	$('.needcontent').click(function() {
		switch($('input:radio[name="needcontent"]:checked').val()) {
			case '芯片':
				$('.pt').html('产品型号');
				$('.gmsj').show();
				$('.xsfwdw').show();
				break;
			case '工具':
				$('.pt').html('工具型号');
				$('.gmsj').show();
				$('.xsfwdw').show();
				break;
			case '方案及其他':
				$('.gmsj').hide();
				$('.xsfwdw').hide();
				break;
		}
	});
	$('.btn-primary').click(function() {
		var msg = '';
		if(!$('.realname').val()) {
			msg = '用户姓名不能为空 \r';
		}
		if(!$('.mobile').val()) {
			msg += '移动电话不能为空\r';
		}
		if(!$('.email').val()) {
			msg += '电子邮件不能为空 \r';
		}
		if(!$('.address').val()) {
			msg += '地址不能为空\r';
		}
		var nt = '';
		$('.needtype').each(function(i) {
			var c = $('input:radio[name="'+$(this).attr('name')+'"]:checked').val();//选中的
			if(c == '技术支持' || c == '报修') {
				nt = c;
			}
		});
		if(nt == '技术支持' || nt == '报修') {
			var pc = 0;
			$('.product').each(function(i) {
				c = $('input:radio[name="'+$(this).attr('name')+'"]:checked').val();//选中的
				if(c) {
					pc += 1 ;
				}
			});
			if(!pc) {
					msg += '请选择产品\r';
			}
		}
		if(!$('.application').val()) {
			msg += '请选择应用领域\r';
		}
		if(!$('.need').val()) {
			msg += '用户需求不能为空\r';
		}
		if(msg) {
			alert(msg);
			return false;
		}
		$('.consult-post').submit();
	});
	
	$('#getcode_num').click(function(){
		$.post('/index.php?m=consulting&f=getverifycode', {}, function(res) {
			$('#getcode_num').attr('src','/verifycode.php?vc=' + res);
			$('.vc').val(res);
		});
	});
});
$('.navigation').css('min-height','260px');
$('.carrousel').css('height','210px');
</script>

<?php include TPL_ROOT . 'common/footer.html.php';?>
