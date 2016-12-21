<?php if(!defined("RUN_MODE")) die();?>
<?php
include TPL_ROOT . 'common/header.html.php';

$path = array_keys($category->pathNames);
js::set('path', $path);
js::set('categoryID', $category->id);

include TPL_ROOT . 'common/treeview.html.php';
?>
<style>
.title td{background-color: #fafbfd;font-weight: bold;padding:10px; border: 1px solid #ccc;}
.content td{border: 1px solid #ccc; height:40px; padding-left:5px;}
p,ul,li,img{ margin:0; padding:0;}
ul,ol,li,a,a:hover{list-style:none;text-decoration: none;}
.gwx{ width:100%; margin:0 auto;}
.gwx ul li{margin-bottom:20px; width:450px; height:210px; float:left;border-bottom:1px dashed #ccc;padding:0px;}
.gwx ul li img{ border:0px;}
.peixun-js ul li{margin-bottom:10px; width:295px; height:185px; float:left;border-bottom:1px dashed #ccc;padding:0px;}
.peixun-js ul li img{ border:0px;}
.peixun-sp ul li{margin-bottom:10px; width:295px; height:140px; float:left;border-bottom:1px dashed #ccc;padding:0px;}
.peixun-sp ul li img{ border:0px;}
.bgtz{width:100%;margin-top:30px;}
.bgtz ul li{width:100%; margin-top:20px;height:20px; float:left;border-bottom:1px dashed #ccc;padding:0px;}
.sw-search {
	padding:5px;
	cursor:pointer;
	font-weight: bold;
}
</style>
<div class="main-content">
  <?php echo $common->printPositionBar($category);?>

  <div class="main-box">
    <!-- 左边分类列表开始 -->
    <div class="left">
      <?php foreach ($children as $sub1) { ?>
        <a href="<?php echo $sub1->sub ? 'javascript:' : str_replace('en', 'en/index.php', $webRoot . "article/c" . $sub1->id . ".html"); ?>" class='sub1'>
          <div class="arrow-h"></div>
          <div class="tran-h"></div>
          <?php echo $sub1->name; ?>
        </a>
        <div class="sub-wrapper">
        <?php foreach ($sub1->sub as $sub2) { ?>
          <?php if($sub2->abbr=='zhaopin'):?>
          <a href="<?php echo str_replace('en', 'en/index.php', $webRoot . "".$sub2->abbr."/c" . $sub2->id . ".html"); ?>" class='sub2'>
            <?php echo $sub2->name; ?>
          </a>
          <?php else:?>
          <a href="<?php echo str_replace('en', 'en/index.php', $webRoot . "article/c" . $sub2->id . ".html"); ?>" class='sub2'>
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
      <!-- 如果当前页面请求的是顶级分类 -->
      <?php if ($category->grade == 1) { ?>
        
        <div class="top">
          <div class="name"><?php echo $category->name; ?></div>
        </div>

        <div class="mid">
          <?php foreach ($children as $sub1) { ?>
          <div class="block" style="height: auto">
            <div class="icon">
              <i class="ico<?php echo $sub1->id; ?>"></i>
            </div>
            <div class="ctgs">
              <div class="ctg-sub1">
                <!-- 二级分类不可点击 -->
                <a class='name' ><?php echo $sub1->name; ?></a>
              </div>
              <?php foreach ($sub1->sub as $sub2) { ?>
              <?php
              //有些地方找不到三级分类的ID，所以下面是用path的正则匹配最后一个ID号
              //至于为什么找不到三级分类的ID，原因不明
              if ($sub2->id) {
                $sub2_id = $sub2->id;
              }else{
                preg_match('/\,(\d+)\,$/', $sub2->path, $match);
                $sub2_id = $match[1];
              }
              ?>
                <a class="ctg-sub2" href="<?php echo str_replace('en', 'en/index.php', $webRoot . 'article/c' . $sub2_id . '.html'); ?>">
                  <?php echo $sub2->name; ?>
                </a>
              <?php } ?>
            </div>
            
          </div>
          <?php } ?>
        </div>
      <!-- 如果当前页面是二级分类 -->
      <?php }elseif ($category->grade == 2) { ?>

      <!-- 开发工具开始 -->
      <?php if ($category->id == 53) { ?>

        <div class="top">
          <div class="name"><?php echo $category->name; ?></div>
        </div>

          <div class="fixed-top margin-top">
              <div class="a">产品</div>
              <div class="b">芯片型号</div>
              <div class="c">
                  <div class="c-a">
                      开发工具
                  </div>
                  <div class="c-b">
                      <div class="c-b-a">HR10M</div>
                      <div class="c-b-b">HR_Link</div>
                  </div>
                  <div class="c-c">
                      <div class="c-c-a">仿真支持</div>
                      <div class="c-c-b">编程支持</div>
                      <div class="c-c-c">仿真适配器（选配件）</div>
                      <div class="c-c-d">编程适配版（选配件）</div>
                      <div class="c-c-e">仿真</div>
                      <div class="c-c-f">编程</div>
                  </div>
              </div>
              <div class="d">
                  <div class="d-a">量产编程工具</div>
                  <div class="d-b">HR50S</div>
                  <div class="d-c">
                      <div class="d-c-a">编程支持</div>
                      <div class="d-c-b">ISP编程支持</div>
                  </div>
              </div>
          </div>

        <div class="product-win deve-margin" id="productwin">

          <div class="product-box">

            <table class='parameters' id="param_table">
              <tbody>
                <?php foreach ($deve_data as $key => $value) { ?>
                <tr>
                  <td><?php echo $key ?></td>
                  <?php for ($i=0; $i < count($value[0]); $i++) { ?>
                  <td>
                    <?php for ($j=0; $j < count($value); $j++) { ?>
                    <div class="atr-block td-<?php echo $i;?>">
                      <?php echo $value[$j][$i]->value; ?>
                    </div>
                    <?php } ?>
                  </td>
                  <?php } ?>
                </tr>
                <?php } ?>
              </tbody>
            </table>

          </div>
        </div>

      <!-- 开发工具结束 -->

      <?php }else{ ?>
      
            <div class="top">
                <div class="name"><?php echo $category->name; ?></div>
            </div>

            <div class="name"><?php echo $category->desc; ?></div>
  		  <?php if(in_array($category->id, array(52,53,56,57,58,59,74,80))) {?>
  	          <?php $url = inlink('view', "id=$article->id", "category={$article->category->alias}&name=$article->alias");?>
  	          <table style="width:100%;border: 1px solid #ccc;">
  	            <tr class="title">
  	              <td>软件名称</td>
  	              <td align="center">发布时间</td>
<!--  	              <td align="center">大小</td>-->
  	              <td align="center">版本号</td>
  	              <td align="center">操作</td>
  	            </tr>
  	            <?php foreach($articlelist as $article):?>
  	            <?php  $file=$this->loadModel('file')->getByObject('article', $article->id);?>
  	            <?php $size=ceil($file[0]->size/1024);?>
  	            <tr class="content">
  	              <td style="color:#1370be;"><?php echo $article->title;?></td>
  	              <td align="center"><?php echo substr($article->editedDate, 0, 10);?></td>
<!--  	              <td align="center">--><?php //echo $size.'KB';?><!--</td>-->
  	              <td align="center"><?php echo $article->content;?></td>
  	              <td style="color:#1370be;" align="center"><?php echo str_replace('data', 'en/data', $article->summary ? html::a($article->summary, '下载', "target='_blank' title='{$file[0]->title}'") :($file[0]->id ? html::a(helper::createLink('file', 'download', "fileID={$file[0]->id}&mouse=left"), '下载', "target='_blank' title='{$file[0]->title}'") : ''));?></td>
  	            </tr>
  	            <?php endforeach;?>
  	          </table>
  	      <?php  } elseif(in_array($category->id, array(81))) {?>
  	      <?php  } elseif(in_array($category->id, array(82))) {?>
  		  <?php  } elseif(in_array($category->id, array(19))) {?>
  		  
  	            <div class="bgtz">
	  	            <ul>
	  	            <?php foreach($articlelist as $article):?>
	  	            	<li><span><?php echo str_replace('en', 'en/index.php', html::a(inlink('view', "id=$article->id", "category={$article->category->alias}&name=$article->alias"), $article->title));?></span><span style="float:right;"><?php echo substr($article->editedDate, 0, 10);?></</span></li>
	  	            <?php endforeach;?>
	  	            </ul>
  	            </div>
  	      
  		  <?php } else {?>
  		  
	  		  <?php if($top_id == 2):?><!-- 二级类目中的顶级类目id是2的 -->
	  		  
	  		  <div style="height:10px">&nbsp;</div>
	  		  <div class="gwx">
	  		  	<ul>
		  		  	<?php foreach($articlelist as $article):?>
		  		  	<?php $url = inlink('view', "id=$article->id", "category={$article->category->alias}&name=$article->alias");?>
		  		  	<li>
			  		  	<table width="100%" height="100">
						  <tr>
						    <td rowspan="2" width="50%" valign="top"><?php echo $article->image->primary->middleURL ? html::image($article->image->primary->middleURL, " class='thumbnail' width='190' height='180'" ) : '';?></td>
						    <td valign="top" colspan="2" height="20"><?php echo str_replace('en', 'en/index.php', html::a($url, $article->title));?></td>
						  </tr>
						  <tr>
						    <td width="15%" height="80" valign="top">推荐产品：</td>
							<td valign="top">
								<?php foreach($this->loadModel('article')->getRelevanceProduct($article->id) AS $product):?>
			                    <?php echo '<div style="padding:0 10px 0 10px;"><a href="/en/index.php/product/'.$product->id.'.html" target="_blank">'.$product->name.'</a></div>';?>
			                    <?php endforeach;?>
							</td>
						  </tr>
						</table>
		  		  	</li>
		  		  	<?php endforeach;?>
	  		  	</ul>
	  		  	<div style="clear:both;"></div>
	  		  </div>
	  		  <div style="margin-bottom:50px;">&nbsp;</div>
	  		  
	  		  <?php else:?>
	            <?php foreach($articlelist as $article):?>
	            <?php $url = inlink('view', "id=$article->id", "category={$article->category->alias}&name=$article->alias");?>
	            <table style="width:100%;height:150px;">
	              <tr>
	                <td valign="top" style="padding-top:15px;border-bottom:1px dashed #ccc;">
	                  <?php echo $article->image->primary->middleURL ? html::image($article->image->primary->middleURL, " class='thumbnail' style='width:190px;height:180px;'" ) : '';?>
	                </td>
	                <td width="75%" valign="top" style="border-bottom:1px dashed #ccc;">
	
	                <table width="100%" cellpadding="3">
	                  <tr>
	                    <td width="85%" style="padding-top:15px;">
	                      <?php echo str_replace('en', 'en/index.php', html::a($url, $article->title));?>
	                    </td>
	                    <td style="color:#ccc;padding-top:15px;" align="right">
	                      <?php if(!$this->loadModel('article')->getRelevanceProduct($article->id)):?><?php echo substr($article->editedDate, 0, 10);?><?php endif;?>
	                    </td>
	                  </tr>
	                  <tr>
	                    <td colspan="2" style="padding-top:15px;">
	                    <?php echo $article->summary;?>
	                    <?php if($this->loadModel('article')->getRelevanceProduct($article->id)):?>
	                    推荐产品：
	                    <?php foreach($this->loadModel('article')->getRelevanceProduct($article->id) AS $product):?>
	                    <?php echo '<span style="padding:0 10px 0 10px;"><a href="/en/index.php/product/'.$product->id.'.html" target="_blank">'.$product->name.'</a></span>';?>
	                    <?php endforeach;?>
	                    <?php endif;?>
	                    </td>
	                  </tr>
	                </table>
	
	                </td>
	              </tr>
	            </table>
	            <?php endforeach;?>
	           <?php endif;?>
            
            <?php }?>

        <?php } ?>

      <!-- 如果当前页面是三级分类 -->
      <?php }elseif ($category->grade == 3) { ?>

        <?php if ($top_id == 2) { //判断是哪一个顶级分类，2是应用于解决方案的ID号?>

          <div class="top">
              <div class="name"><?php echo $category->name; ?></div>
          </div>

          <div class="desc">
            <?php echo $category->desc; ?>
          </div>

          <div style="height:10px">&nbsp;</div>
	  		  <div class="gwx">
	  		  	<ul>
		  		  	<?php foreach($articlelist as $article):?>
		  		  	<?php $url = inlink('view', "id=$article->id", "category={$article->category->alias}&name=$article->alias");?>
		  		  	<li>
			  		  	<table width="100%" height="100">
						  <tr>
						    <td rowspan="2" width="50%" valign="top"><?php echo $article->image->primary->middleURL ? html::image($article->image->primary->middleURL, " class='thumbnail' width='190' height='180'" ) : '';?></td>
						    <td valign="top" colspan="2" height="20"><?php echo str_replace('en', 'en/index.php', html::a($url, $article->title));?></td>
						  </tr>
						  <tr>
						    <td width="15%" height="80" valign="top">推荐产品：</td>
							<td valign="top">
								<?php foreach($this->loadModel('article')->getRelevanceProduct($article->id) AS $product):?>
			                    <?php echo '<div style="padding:0 10px 0 10px;"><a href="/en/index.php/product/'.$product->id.'.html" target="_blank">'.$product->name.'</a></div>';?>
			                    <?php endforeach;?>
							</td>
						  </tr>
						</table>
		  		  	</li>
		  		  	<?php endforeach;?>
	  		  	</ul>
	  		  	<div style="clear:both;"></div>
	  		  </div>
	  		  <div style="margin-bottom:50px;">&nbsp;</div>

        <?php
        //顶级分类是应用于解决方案的二、三级分类的结束位置
        //顶级分类是技术支持的二、三级分类的结束位置
        }else{
        ?>

          <div class="top">
              <div class="name"><?php echo $category->name; ?></div>
          </div>
          <div class="name"><?php echo $category->desc; ?></div>
		  <?php if(in_array($category->id, array(52,53,56,57,58,59,74,80,83))) {?>
		  	  <?php if(in_array($category->id, array(80))):?>
  		  	  
  		  	  <table width="100%" style="background-color:#edf2f5;padding:6px;margin:10px 0 10px 0;">
		      	<tr><td width="75%" align="left" style="padding-left:6px;">软件下载</td><td align="right" height="30" ><span><?php echo $search_software;?></span><span class="sw-search">搜索</span></td></tr>
		      </table>
  		  	  <?php endif;?>
	          <?php $url = inlink('view', "id=$article->id", "category={$article->category->alias}&name=$article->alias");?>
	          <table style="width:100%;border: 1px solid #ccc;">
	            <tr class="title">
	              <td>软件名称</td>
	              <td align="center">发布时间</td>
<!--	              <td align="center">大小</td>-->
	              <td align="center">版本号</td>
	              <td align="center">操作</td>
	            </tr>
	            <?php foreach($articlelist as $article):?>
	            <?php  $file=$this->loadModel('file')->getByObject('article', $article->id);?>
	            <?php $size=ceil($file[0]->size/1024);?>
	            <tr class="content">
	              <td style="color:#1370be;"><?php echo $article->title;?></td>
	              <td align="center"><?php echo substr($article->editedDate, 0, 10);?></td>
<!--	              <td align="center">--><?php //echo $size.'KB';?><!--</td>-->
	              <td align="center"><?php echo $article->content;?></td>
	              <td style="color:#1370be;" align="center"><?php echo $article->summary ? html::a($article->summary, '下载', "target='_blank' title='{$file[0]->title}'") :($file[0]->id ? html::a(helper::createLink('file', 'download', "fileID={$file[0]->id}&mouse=left"), '下载', "target='_blank' title='{$file[0]->title}'") : '');?></td>
	            </tr>
	            <?php endforeach;?>
	          </table>
	      <?php } elseif(in_array($category->id, array(81))) {?>
	      	  <div style="height:10px">&nbsp;</div>
	  		  <div class="peixun-js">
	  		  	<ul>
		  		  	<?php foreach($articlelist as $article):?>
		  		  	<?php  $file=$this->loadModel('file')->getByObject('article', $article->id);?>
		  		  	<?php $url = inlink('view', "id=$article->id", "category={$article->category->alias}&name=$article->alias");?>
		  		  	<li>
			  		  	<table width="100%">
						  <tr>
						    <td valign="top" align="center"><?php echo html::image($article->image->primary->middleURL ? $article->image->primary->middleURL : '/img/smallppt.jpg', " class='thumbnail' width='180' height='120'" );?></td>
						  </tr>
						  <tr>
						    <td valign="top" align="center"><?php echo html::a('/en/index.php?m=article&f=read&fid='.$file[0]->id, $article->title, "target='_blank' title='{$file[0]->title}'");?></td>
						  </tr>
						  <tr>
							<td valign="top" align="center"><?php echo html::a(helper::createLink('file', 'download', "fileID={$file[0]->id}&mouse=left"), html::image('/img/down.gif', " class='thumbnail' width='111'" ), "target='_blank' title='{$file[0]->title}'");?></td>
						  </tr>
						</table>
		  		  	</li>
		  		  	<?php endforeach;?>
	  		  	</ul>
	  		  	<div style="clear:both;"></div>
	  		  </div>
	  		  <div style="margin-bottom:20px;">&nbsp;</div>
  	      <?php } elseif(in_array($category->id, array(82))) {?>
  	      	  <div style="height:10px">&nbsp;</div>
	  		  <div class="peixun-sp">
	  		  	<ul>
		  		  	<?php foreach($articlelist as $article):?>
		  		  	<?php  $file=$this->loadModel('file')->getByObject('article', $article->id);?>
		  		  	<?php $url = inlink('view', "id=$article->id", "category={$article->category->alias}&name=$article->alias");?>
		  		  	<li>
			  		  	<table width="100%">
						  <tr>
						    <td valign="top" align="center"><?php echo html::image($article->image->primary->middleURL ? $article->image->primary->middleURL : '/img/ice.jpg', " class='thumbnail' width='180' height='110'" );?></td>
						  </tr>
						  <tr>
						    <td valign="top" align="center"><?php echo html::a($article->link? $article->link : '/en/index.php?m=article&f=videodetail&aid='.$article->id, $article->title, "target='_blank' title='{$file[0]->title}'");?></td>
						  </tr>
						</table>
		  		  	</li>
		  		  	<?php endforeach;?>
	  		  	</ul>
	  		  	<div style="clear:both;"></div>
	  		  </div>
	  		  <div style="margin-bottom:20px;">&nbsp;</div>
		  <?php } else {?>
	          <?php foreach($articlelist as $article):?>
	          <?php $url = inlink('view', "id=$article->id", "category={$article->category->alias}&name=$article->alias");?>
	          <table style="width:100%;height:150px;">
	            <tr>
	              <td valign="top" style="padding-top:15px;border-bottom:1px dashed #ccc;">
	                <?php echo $article->image->primary->middleURL ? html::image($article->image->primary->middleURL, " class='thumbnail' style='width:190px;height:180px;'" ) : '';?>
	              </td>
	              <td width="75%" valign="top" style="border-bottom:1px dashed #ccc;">
	
	              <table width="100%" cellpadding="3">
	                <tr>
	                  <td width="85%" style="padding-top:15px;">
	                    <?php echo str_replace('en', 'en/index.php', html::a($url, $article->title));?>
	                  </td>
	                  <td style="color:#ccc;padding-top:15px;" align="right">
	                    <?php if(!$this->loadModel('article')->getRelevanceProduct($article->id)):?><?php echo substr($article->editedDate, 0, 10);?><?php endif;?>
	                  </td>
	                </tr>
	                <tr>
	                  <td colspan="2" style="padding-top:15px;">
	                  <?php echo $article->summary;?>
	                  <?php if($this->loadModel('article')->getRelevanceProduct($article->id)):?>
	                  推荐产品：
	                  <?php foreach($this->loadModel('article')->getRelevanceProduct($article->id) AS $product):?>
	                  <?php echo '<span style="padding:0 10px 0 10px;"><a href="/en/index.php/product/'.$product->id.'.html" target="_blank">'.$product->name.'</a></span>';?>
	                  <?php endforeach;?>
	                  <?php endif;?>
	                  </td>
	                </tr>
	              </table>
	
	              </td>
	            </tr>
	          </table>
	          <?php endforeach;?>
	        <?php }?>

        <?php } //判断是哪一个顶级分类的结束位置?>

      <?php } //判断是顶级分类，还是二、三分类的结束位置?>

        <?php if ($top_id <> 2) { //判断是哪一个顶级分类，2是应用于解决方案的ID号?>
                <?php $pager->show('right', 'short');?>
        <?php } //判断是顶级分类，还是二、三分类的结束位置?>
    </div>
    <!-- 右边分类列表结束 -->
  </div>
</div>
<script>
$(function(){
	$('.sw-search').click(function() {
		window.location.href = '/en/index.php/article/c<?php echo $category->id;?>.html?searchWord='+$('.searchWord').val();
	});
});
</script>
<?php include TPL_ROOT . 'common/footer.html.php';?>
