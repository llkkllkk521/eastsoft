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
<?php include '../../common/view/dayin.header.admin.html.php';?>
<style>
.consultingview {
    margin-left:50px;
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
<table class="consultingview">
      	<tr>
	      	<td width="20%">用户名：</td>
	      	<td><?php echo $consulting->realname;?></td>
      	</tr>
      	<tr>
	      	<td>移动电话：</td>
	      	<td><?php echo $consulting->mobile;?></td>
      	</tr>
      	<tr>
	      	<td>固定电话：</td>
	      	<td><?php echo $consulting->phone;?></td>
      	</tr>
      	<tr>
	      	<td>电子邮件：</td>
	      	<td><?php echo $consulting->email;?></td>
      	</tr>
      	<tr>
	      	<td>地址：</td>
	      	<td>
	      	<?php echo $consulting->province;?>
	      	<?php echo $consulting->city;?>
	      	<?php echo $consulting->county;?>
	      	<?php echo $consulting->address;?>
	      	</td>
      	</tr>
      	<tr>
	      	<td>需求类型：</td>
	      	<td><?php echo $consulting->needtype;?></td>
      	</tr>
      	<tr>
	      	<td>需求内容：</td>
	      	<td><?php echo $consulting->needcontent;?></td>
      	</tr>
      	<tr>
	      	<td>产品：</td>
	      	<td><?php echo $consulting->product;?></td>
      	</tr>
      	<tr>
	      	<td>应用领域：</td>
	      	<td><?php echo $consulting->application;?></td>
      	</tr>
      	<tr>
	      	<td>类型：</td>
	      	<td><?php echo $consulting->tooltype;?></td>
      	</tr>
      	<tr>
	      	<td>购买时间：</td>
	      	<td><?php echo $consulting->buyDate;?></td>
      	</tr>
      	<tr>
	      	<td>销售服务单位：</td>
	      	<td><?php echo $consulting->company;?></td>
      	</tr>
      	<tr>
	      	<td>用户需求：</td>
	      	<td><?php echo $consulting->need;?></td>
      	</tr>
      	<tr>
	      	<td>&nbsp;</td>
	      	<td><input type="button" value="打印" class="btn btn-primary" 　onclick="javascript:window.print()"></td>
      	</tr>
	  </table>
<?php include '../../common/view/footer.admin.html.php';?>
