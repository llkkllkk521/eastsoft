$(document).ready(function()
{
    //给下拉添加多选功能
    $("select[multiple='multiple']").each(function(){
        $(this).multiselect();
    });

});
