<?php if(!defined("RUN_MODE")) die();?>
<?php
$webRoot        = $config->webRoot;
$cssRoot        = $webRoot . "css/";
$jsRoot         = $webRoot . "js/";

js::exportConfigVars();
css::import($cssRoot   . 'my.css');

js::import($jsRoot     . 'all.js');
js::import($jsRoot     . 'my.js');
?>
<!DOCTYPE html>
<head>
	<meta charset="utf-8">
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="Cache-Control"  content="no-transform">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- developing -->
	<link rel="stylesheet/less" type="text/css" href="<?php echo $cssRoot; ?>my.less" />
	<script type="text/javascript" src="<?php echo $jsRoot; ?>less/min.js"></script>
	<!-- developing -->
	<style type="text/css">
        * {
            font-family: "Microsoft YaHei" ! important;
        }
	    .logo {width: 400px;
		    height: 38px;
		    margin: 30px 40px;
		    background: url(../img/logo.png);
		    background-size: 100% 100%;}
    </style>
</head>
<body style="overflow-x: auto; margin: 0; padding: 0 20px;">

<div class="logo">
	
</div>

<div class="btns">
	<input type="button" id="reset_filter" value="Reset" class='btn'/>
</div>

<div class="product-box">
<form method="post" id="param_form">
	<table class='parameters' id="param_table">
		<thead>
			<tr>
				<th>Chip</th>
				<?php foreach ($attr as $atr) { ?>
				<th><?php echo $atr->name; ?></th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<!-- 属性筛选部分开始 -->
			<tr>
				<td></td>
				<?php foreach ($attr as $atr) { ?>
				<?php
				$drop = $this->dao->select('DISTINCT value, id, attr')->from('es_product_detail')
						->where('attr')->eq($atr->id)
						->andWhere('is_delete')->eq('n')
						->fetchGroup("value");

				$drop = array_values($drop);
				?>
				<td>
				<select class='filter_select' name='<?php echo $atr->id ?>'>
					<option value='0'>Filter</option>
					<?php foreach ($drop as $options) { ?>
						<?php if (isset($filter[$atr->id]) && isset($filter[$atr->id]['id']) && $filter[$atr->id]['id'] == $options[0]->id) { ?>
						<option value="<?php echo $options[0]->id; ?>" selected="selected">
							<?php echo $options[0]->value; ?>
						</option>
						<?php }else{ ?>
						<option value="<?php echo $options[0]->id; ?>">
							<?php echo $options[0]->value; ?>
						</option>
						<?php } ?>
					<?php } ?>
				</select>
				</td>
				<?php } ?>
			</tr>
			<!-- 属性筛选部分结束 -->
			<?php foreach ($products as $value) { ?>
			<tr>
				<td class='product-name'>
					<a href="<?php echo $this->createLink('index.php/product', 'view', 'productID=' . $value->id); ?>">
					<?php echo $value->name ?>
					<?php echo $value->unsaleable ? "<i class='new-icon'></i>" : ''; ?>
					</a>
				</td>
				<?php foreach ($attr as $atr) { ?>
					<?php

					$product_atr = $this->dao->select('t1.*, t2.*')->from('es_product_custom')->alias('t1')
				                ->leftJoin('es_product_detail')->alias('t2')->on('t1.value = t2.id')
				                ->where('t1.product')->eq($value->id)
				                ->andWhere('t1.label')->eq($atr->id)
				                ->fetchAll();
				
					?>
					<td>
					<?php if ($product_atr) { ?>

						<?php foreach ($product_atr as $k => $p_a) { ?>
							
							<?php if ($k%2) { ?>
								<div class="atr-block gray-back">
								<?php echo $p_a->value; ?>
								</div>
							<?php }else{ ?>
								<div class="atr-block">
								<?php echo $p_a->value; ?>
								</div>
							<?php } ?>

							<!-- 如果有筛选，并且删选的值符合当前属性的值，那么就把这一行的序号记录下来，在 js 做隐藏其他行的处理 -->
							<?php if ( isset($filter[$atr->id]) && isset($filter[$atr->id]['detail_value']) && $filter[$atr->id]['detail_value'] == $p_a->value ) { ?>
								<input type="hidden" name="layer_<?php echo $layer+1 ?>" value='<?php echo $k ?>'/>
							<?php } ?>

						<?php } ?>

					<?php }else{ ?>
						<div class="atr-block"></div>
					<?php } ?>
					</td>
				<?php } ?>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</form>
</div>

<script type="text/javascript">

	$("#param_table").find('tbody').find('tr').each(function(tri){

		var old_arr = [];
		var v = {};

		$(this).find('td').each(function(tdi){

			var hidd = $(this).find("input[type='hidden']");

			if (hidd.length) {
				v[tdi] = [];
			}
			//v 中储存每个 td 中需要显示的 block 的序号，会在之后求每个需要数据的交集
			$(this).find("input[type='hidden']").each(function(){

				v[tdi].push( parseInt($(this).val()) );

			});

		});


		for (var param in v) {

			if (old_arr.length) {
				old_arr = intersect_safe(old_arr,v[param]);
			}else{
				old_arr = v[param];
			}
		}


		$(this).find('td').each(function(){

			$(this).find('.atr-block').each(function(blk){

				if (old_arr.length) {
					if ( $.inArray(blk, old_arr) == -1 ){
						$(this).css('display', 'none');
					}
				}
			});

		});

	});


	$("#param_table").find('tbody').find('tr').each(function(i){

		if (i) {

			var h = $(this).height();
			var l = $(this).find('td').eq(1).find('.atr-block').length;
			var r = h/l;

			$(this).find('.atr-block').height(r);
		}

	});

	$("select.filter_select").each(function(){

		$(this).change(function(){
			$("#param_form").submit();
		});

	});

	$("#reset_filter").click(function(){
		$("select.filter_select").each(function(){
			$(this).val('0');
		});
		$("#param_form").submit();
	});


	function intersect_safe(a, b)
	{
	  var ai=0, bi=0;
	  var result = [];

	  while( ai < a.length && bi < b.length )
	  {
	     if      (a[ai] < b[bi] ){ ai++; }
	     else if (a[ai] > b[bi] ){ bi++; }
	     else /* they're equal */
	     {
	       result.push(a[ai]);
	       ai++;
	       bi++;
	     }
	  }

	  return result;
	}
	
</script>
</body>
</html>