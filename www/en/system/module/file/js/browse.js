$(document).ready(function()
{   
    $.setAjaxForm('#fileForm', function(data)
    {
        if(data.result == 'success') $.reloadAjaxModal(1500);
    }); 
    $.setAjaxLoader('.edit', '#ajaxModal');
    $(document).on('click', 'a.option', function(data)
    {
        $.getJSON($(this).attr('href'), function(data) 
        {
            if(data.result == 'success')
            {
                $.reloadAjaxModal();
            }
            else
            {
                alert(data.message);
            }
        });
        return false;
    });

    $(".modal-backdrop").click(function()
    {
        $('.modal').modal('hide');
    });
});
