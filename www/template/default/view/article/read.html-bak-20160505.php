<div id="pdf"></div>
<script src="/js/pdfobject.min.js"></script>
<script type="text/javascript">
window.onload = function (){
	var myPDF = PDFObject.embed("<?php echo $fileurl;?>", "#pdf");
};
</script>
