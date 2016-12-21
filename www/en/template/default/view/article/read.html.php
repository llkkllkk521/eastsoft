<!DOCTYPE HTML>
<html>
  <head>
    <title><?php echo $title;?></title>
  </head>
  <style>
  body{
  	width:100%;
  	height:100%;
  }
  #pdf{
  	width:100%;
  	height:900px;
  }
  </style>
<body>
<div id="pdf"></div>
<script src="/js/pdfobject.min.js"></script>
<script type="text/javascript">
window.onload = function (){
	var myPDF = PDFObject.embed("<?php echo $fileurl;?>", "#pdf");
};
</script>
</body>
</html>