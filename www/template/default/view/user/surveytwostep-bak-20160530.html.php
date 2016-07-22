<?php if(!defined("RUN_MODE")) die();?>
<?php include TPL_ROOT . 'common/header.html.php';?>
<div class='page-user-control'>
  <div class='row'>
    <?php include TPL_ROOT . 'user/side.html.php';?>
    <div class='col-md-10'>
      <div>
      	<style>
      	.survey{margin-bottom:10px;padding:10px;}
      	.surveytheme{float:right;padding:10px 0 10px 0;font-weight: bold;font-size:16px;}
      	.surveytitle{width:100%;margin-bottom:10px;}
      	.surveyanswer{padding:5px 0 10px 0;border-bottom:1px dashed #ccc;margin-bottom:10px;}
      	</style>
         <?php if($survey):?>
          <input type="hidden" name="surveyone" value="<?php echo $surveyone;?>" />
          <form class="survey-all" method="post" action="/index.php/user-surveythreestep.html">
          	  <?php $total=count($surveys);?>
	          <?php foreach($surveys AS $k1=>$s):?>
	          <?php $k11=$k1+1;?>
	          <div class="survey s<?php echo $k11;?>" style="<?php echo $k11==1?'':'display:none;';?>">
	          		
		          	<table class="surveytitle">
		          		<tr><td width="20%" style="border-bottom:3px solid #077ac7;"><?php echo $survey->title; ?></td><td width="70%" align="right" style="border-bottom:1px solid #6f6f6f;color:#077ac7;"><?php echo $s->theme;?></td><td align="right" style="border-bottom:1px solid #6f6f6f;">调查进度<?php echo $k11.'/'.$total?></td></tr>
		          	</table>
	          		<?php foreach($this->user->getSurveyList($s->theme) AS $k2=>$v):?>
	            		<?php $k22=$k2+1;?>
	            		<div style="font-weight:bold;font-size:14px;"><?php echo $k22.'、'.$v->title.($v->content ? '<br>'.$v->content : '');?></div>
	            		<div class="surveyanswer"><?php echo $this->user->getSurveyContentType($v->id, $v->type);?></div>
	            	<?php endforeach;?>
	            	<div style="text-align:center;"><span class="btn btn-primary save" datasur="<?php echo $k11;?>" data="<?php echo $k11>=$total?'finish':$k11;?>"><?php echo $k11>=$total?'提交':'下一步';?></span></div>
	          </div>
	          <?php endforeach;?>
	          
          </form>
          <?php else:?>
          	无调查
          <?php endif;?>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
	$('.save').click(function() {
		var iptarr = ipt = val_all = new Array();
		var sur = $(this).attr('datasur');
		$('.s'+sur+' input').each(function(k){
		    iptarr[k] = $(this).attr('name');
		});
		//var arrlen = undulpicate(iptarr).length;
		var vc = 0;
		$.each(undulpicate(iptarr), function(i,val){      
			var _val = val.split('_');
			if(_val[0] == 'radio') {
				if($('input:radio[name="'+val+'"]:checked').val()) {
					vc += 1;
				}
			}
			var cb = '';
			if(_val[0] == 'checkbox') {
				$("[name='"+val+"']:checked").each(function() {
					cb += $(this).val();
				});
				cb ? vc += 1 : '';
			}
			if(_val[0] == 'text') {
				$("[name='"+val+"']") ? vc += 1 : '';
			}
		});

		//-统计必须要输入或选中的
		var micr = 0;
		$.each(undulpicate(iptarr), function(i,val){
			var _val = val.split('_');
			if(_val[0] == 'radio' || _val[0] == 'checkbox' || _val[0] == 'text') {
				micr += 1;
			}
		});
		//-end
		console.info(vc +'=='+ micr);
		//-必须填写的输入框是否已经填写
		var mi = _mi = 0;
		$.each($('.mi'), function(i){
			if($(this).attr('type') == 'text') {
				mi  += 1;
			}
			
		});
		$.each($('.mi'), function(i){
			if($(this).attr('type') == 'text') {
				if($(this).val()) {
					_mi += 1;
				}
			}
			
		});
		//-end
		
		var _wr = '';
		if(vc<micr || _mi<mi) {
			_wr += vc<micr ? '请选择答案' : '';
			_wr += _mi<mi ? ' 填写文本框' : '';
			alert(_wr);
		} else {
			if($(this).attr('data') != 'finish') {
				$('.s'+sur).css({'display':'none'});
				var sur = parseInt(sur) + parseInt(1);
				$('.s'+sur).css({'display':''});
			} else if($(this).attr('data') == 'finish') {
				$('.survey-all input').each(function(k){
				    ipt[k] = $(this).attr('name');
				});
				$.each(undulpicate(ipt), function(i,val){      
					var _val = val.split('_');
					var cb = '';
					if(_val[0] == 'radio') {
						if($('input:radio[name="'+val+'"]:checked').val()) {
							val_all[i] = val+'&'+$('input:radio[name="'+val+'"]:checked').val()+'&'+$("[name='mi_"+_val[1]+"']").val();
						}
					} else if(_val[0] == 'checkbox') {
						$("[name='"+val+"']:checked").each(function() {
							cb += $(this).val()+' ';
						});
						val_all[i] = val+'&'+cb+'&'+$("[name='mi_"+_val[1]+"']").val();
					} else if(_val[0] == 'text') {
						val_all[i] = val+'&'+$("[name='"+val+"']").val()+'&'+$("[name='mi_"+_val[1]+"']").val();
					}
				});
				if(val_all.join(',')) {
					$.post('/index.php/user-savesurveycontent.html', {surveyone:$("[name='surveyone']").val(), surveyall:val_all.join(',')}, function(res) {
						alert(res.message);
						window.location.href = res.locate;
					}, 'json');
				}
			}
		}
	});

	$('.showipt').click(function(){
		var iptnv = $(this).attr('name');
		var _iptnv = iptnv.split('_');
		$('.mi-'+_iptnv[1]).attr('type', 'text');
	});

	$('.hideipt').click(function(){
		var iptnv = $(this).attr('name');
		var _iptnv = iptnv.split('_');
		$('.mi-'+_iptnv[1]).attr('type', 'hidden');
	});
	
	function undulpicate(array){
		for(var i=0;i<array.length;i++) {
			for(var j=i+1;j<array.length;j++) {
				//注意 ===
				if(array[i]===array[j]) {
					array.splice(j,1);
					j--;
				}
			}
		}
		return array;
	}
});
</script>
<?php include TPL_ROOT . 'common/footer.html.php';?>
