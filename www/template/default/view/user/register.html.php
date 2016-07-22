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
	font-weight:blod;
}
.form-control {
    display: block;
    width: 40%;
    height: 32px;
    padding: 5px 10px;
    font-size: 13px;
    line-height: 1.53846154;
    color: #222;
    vertical-align: middle;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 3px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    float:left;
}
.btn-primary {
    width: 30%;
    height: 35px;
    padding: 5px 10px;
    font-size: 13px;
    line-height: 1.53846154;
    color: #fff;
    vertical-align: middle;
    background-color: #E11920;
    border: 1px solid #E11920;
    border-radius: 3px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075);
    -webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
    -o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
}
.ok {
	background:url('/img/ok.jpg') no-repeat;
	padding:0px 0 5px 20px;
	height:45px;
}
.error {
	background:url('/img/error.jpg') no-repeat;
	padding:0px 0 5px 20px;
	height:45px;
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
          <div class="name">会员注册</div>
      </div>
      
			<form method='post' class='form-horizontal'>
            <div class='form-group' style="margin-top:45px;">
              <label class='col-sm-3 control-label'><span class="star-must">*</span>账号：</label>
              <div class='col-sm-9'>
              <?php echo html::input('account', '', "class='form-control' autocomplete='off' placeholder='" . $lang->user->register->lblAccount . "'");?>
              <span class="account-validate"></span>
              </div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><span class="star-must">*</span>设置密码：</label>
              <div class='col-sm-9'>
              <?php echo html::password('password1', '', "class='form-control' autocomplate='off' placeholder='" . $lang->user->register->lblPassword . "'");?>
              <span class="password1-validate"></span>
              </div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><span class="star-must">*</span>确认密码：</label>
              <div class='col-sm-9'>
              <?php echo html::password('password2', '', "class='form-control'");?>
              <span class="password2-validate"></span>
              </div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><span class="star-must">*</span>联系电话：</label>
              <div class='col-sm-9'>
              <?php echo html::input('phone', '', "class='form-control' autocomplete='off'");?>
              <span class="phone-validate"></span>
              </div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><span class="star-must">*</span>电子邮箱：</label>
              <div class='col-sm-9'>
              <?php echo html::input('email', '', "class='form-control' autocomplete='off'") . '';?>
              <span class="email-validate"></span>
              </div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><span class="star-must">*</span><?php echo $lang->user->utype;?>：</label>
              <div class='col-sm-9'><?php echo html::radio('utype', $lang->user->membertype, 'dls') . '';?></div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><span class="star-must">*</span>地区：</label>
              <div class='col-sm-9'>
              	<?php echo html::select("regions1", $regions1, '21', "' class='regions1'");?>
        		<?php echo html::select("regions2", $regions2, '', "' class='regions2'");?>
        		<?php echo html::select("regions3", $regions3, '', "' class='regions3'");?>
              </div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><span class="star-must">*</span><?php echo $lang->user->addressHistory;?>：</label>
              <div class='col-sm-9'>
              <?php echo html::input('address', '', "class='form-control' autocomplete='off'");?>
              <span class="address-validate"></span>
              </div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><span class="star-must">*</span><?php echo $lang->user->position;?>：</label>
              <div class='col-sm-9'>
              <?php echo html::input('position', '', "class='form-control' autocomplete='off'");?>
              <span class="position-validate"></span>
              </div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><span class="star-must">*</span><?php echo $lang->user->company;?>：</label>
              <div class='col-sm-9'>
              <?php echo html::input('company', '', "class='form-control'");?>
              <span class="company-validate"></span>
              </div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><?php echo $lang->user->zipcode;?>：</label>
              <div class='col-sm-9'><?php echo html::input('zipcode', '', "class='form-control'");?></div>
            </div>
            <div class='form-group'>
              <label class="col-sm-3 control-label"><?php echo $lang->user->productserver;?></label>
              <div class='col-sm-9'><?php echo html::textarea('productserver', '', "rows='2' class='form-control'");?>：</div>
            </div>
             <div class='form-group'>
              <label class="col-sm-3 control-label"><?php echo $lang->user->application;?>：</label>
              <div class='col-sm-9'>
				<input type="checkbox" id="application1" name="application[]" value="家电"> 家电  <input type="checkbox" id="application2" name="application[]" value="小家电"> 小家电  <input type="checkbox" id="application3" name="application[]" value="汽车电子"> 汽车电子  <input type="checkbox" id="application4" name="application[]" value="工业控制"> 工业控制  <input type="checkbox" id="application5" name="application[]" value="智能仪表"> 智能仪表  <input type="checkbox" id="application6" name="application[]" value="其他"> 其他
			  </div>
            </div>
             <div class='form-group'>
              <label class="col-sm-3 control-label"><?php echo $lang->user->other;?>：</label>
              <div class='col-sm-9'><?php echo html::textarea('other', '', "rows='2' class='form-control'");?></div>
            </div>
             <div class='form-group'>
              <label class="col-sm-3 control-label">更新通知：</label>
              <div class='col-sm-9'>
              <input type="radio" id="informupdate1" name="informupdate" value="month"> 每月定期通知  <input type="radio" id="informupdate2" name="informupdate" value="week" checked="checked"> 每周定期通知  <input type="radio" id="informupdate3" name="informupdate" value="timely"> 即时接受通知  <input type="radio" id="informupdate4" name="informupdate" value="no"> 不接受更新通知
			  </div>
            </div>
            <div class='form-group'>
              <div class="col-sm-3"></div>
              <div class='col-sm-9'><?php echo html::submitButton($lang->register,'butn btn-primary savereg', '') . html::hidden('referer', $referer);?></div>
            </div>
          </form>
    </div>
    <!-- 右边分类列表结束 -->
  </div>
</div>
<script type="text/javascript">
$(function() {
	$('.savereg').click(function() {
		var _account = /^[a-zA-Z0-9]+$/;
		var account = $('#account').val();
		if(!_account.test(account) || account.length < 3 || account.length > 11) {
			$('.account-validate').html('用户名格式不正确！').addClass('error');
			$('#account').focus().select();
			return false;
		} else {
			$('.account-validate').html('').removeClass('error').addClass('ok');
		}

		var _password = /^[a-zA-Z0-9]+$/;
		var password1 = $('#password1').val();
		if(!_password.test(password1) || password1.length < 6 || password1.length > 20) {
			$('.password1-validate').html('密码格式不正确！').addClass('error');
			$('#password1').focus().select();
			return false;
		} else {
			$('.password1-validate').html('').removeClass('error').addClass('ok');
		}

		var password2 = $('#password2').val();
		if(!_password.test(password2) || password2.length < 6 || password2.length > 20) {
			$('.password2-validate').html('密码格式不正确！').addClass('error');
			$('#password2').focus().select();
			return false;
		} else {
			$('.password2-validate').html('').removeClass('error').addClass('ok');
		}

		if(password1 != password2) {
			$('.password2-validate').html('重复密码与密码不一致！').addClass('error');
			$('#password2').focus().select();
			return false;
		} else {
			$('.password2-validate').html('').removeClass('error').addClass('ok');
		}

		var _phone = /^[0-9]+.?[0-9]*$/;
		var phone = $('#phone').val();
		if(!_phone.test(phone)) {
			$('.phone-validate').html('电话格式不正确！').addClass('error');
			$('#phone').focus().select();
			return false;
		} else {
			$('.phone-validate').html('').removeClass('error').addClass('ok');
		}

		var _email = /\w+[@]{1}\w+[.]\w+/;
		var email = $('#email').val();
		if(!_email.test(email)) {
			$('.email-validate').html('email格式不正确！').addClass('error');
			$('#email').focus().select();
			return false;
		} else {
			$('.email-validate').html('').removeClass('error').addClass('ok');
		}

		if(!$('#address').val()) {
			$('.address-validate').html('请填写地址！').addClass('error');
			$('#address').focus().select();
			return false;
		} else {
			$('.address-validate').html('').removeClass('error').addClass('ok');
		}

		if(!$('#position').val()) {
			$('.position-validate').html('请填写职位！').addClass('error');
			$('#position').focus().select();
			return false;
		} else {
			$('.position-validate').html('').removeClass('error').addClass('ok');
		}

		if(!$('#company').val()) {
			$('.company-validate').html('请填写公司学校名称！').addClass('error');
			$('#company').focus().select();
			return false;
		} else {
			$('.company-validate').html('').removeClass('error').addClass('ok');
		}
	});

	$('#regions1').change(function() {
        $.post('<?php echo $webRoot.'index.php?m=zhaopin&f=getArea'?>', {p_region_id:$(this).val()}, function(data) {
            $('.regions2').empty();
            $('.regions2').append(data);
        });
    });
    $('#regions2').change(function() {
        $.post('<?php echo $webRoot.'index.php?m=zhaopin&f=getArea'?>', {p_region_id:$(this).val()}, function(data) {
            $('.regions3').empty();
            $('.regions3').append(data);
        });
    });
});
</script>
<?php include TPL_ROOT . 'common/footer.html.php';?>
