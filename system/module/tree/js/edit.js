$(document).ready(function()
{
    $.setAjaxForm('#editForm', function()
    {
        /* After the form posted, refresh the treeMenuBox content. */
        source = createLink('tree', 'browse', 'type=' + v.type) + ' #treeMenuBox';
        $('#treeMenuBox').parent().load(source, function()
        {
            /* Rebuild the tree menu after treeMenuBox refreshed. */
            $(".tree").treeview({collapsed: false, unique: false});

            /* enable palceholder for ie8 */
            if($.fn.placeholder) $('[placeholder]').placeholder();
        });
    });

    $('#isLink').change(function()
    {   
        if($(this).prop('checked'))
        {   
            $('.categoryInfo').hide();
            $('.link').show();
        }   
        else
        {   
            $('.categoryInfo').show();
            $('.link').hide();
        }   
    }); 

    $('#isLink').change();


    var editForm    = $("#editForm"),
        attrDOM     = "<div class='form-group'>" +
                        "<label class='col-md-2 control-label'>分类属性</label>" +
                        "<div class='col-md-4'>" +
                          "<input type='hidden' name='attr_id[]'/>" +
                          "<input type='text' name='attr_name[]' class='form-control' placeholder='分类的属性' />" +
                        "</div>" +
                        "<div class='col-md-2'>" +
                          "<a href='javascript:;'>" +
                            "<i class='icon-plus' data-type='attr'></i>" +
                          "</a>" +
                        "</div>" +
                      "</div>";

    editForm.find(".icon-plus").each(function(i){
        
        var type = $(this).data().type;
        
        $(this).click(function(){

            if (type == 'attr') {

                $(attrDOM).insertBefore('#edit_submit');
                
            }else if (type == 'detail') {

                var attr        = $(this).parents('.form-group').find("input[type='hidden'][name='detail_attr[]']").val(),
                    detailDOM   = "<div class='form-group'>" +
                                    "<label class='col-md-2 control-label'>属性包含的值</label>" +
                                    "<div class='col-md-1'>" +
                                    "</div>" +
                                    "<div class='col-md-4'>" +
                                      "<input type='hidden' name='detail_id[]' value=''/>" +
                                      "<input type='hidden' name='detail_attr[]' value='" + attr + "'/>" +
                                      "<input type='text' name='detail_value[]' class='form-control' value=''/>" +
                                    "</div>" +
                                    "<div class='col-md-2'>" +
                                      "<a href='javascript:;'>" +
                                        "<i class='icon-plus' data-type='detail'></i>" +
                                      "</a>" +
                                    "</div>" +
                                  "</div>";

                $(this).parents('.detail').append(detailDOM);
            }

        });

    })



});
