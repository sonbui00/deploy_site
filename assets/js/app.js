/**
 * Created by sonbv on 13/11/2014.
 */
$(function () {
    $('.ui.selection.dropdown')
        .dropdown()
    ;

    $('.ui.checkbox')
        .checkbox()
    ;

    var options = {
        beforeSubmit: function (formData, jqForm, options) {
            jqForm.addClass('loading');
        },
        success: function ($data) {
            $('#ajax-report').html( $data);
            $('#ajax-report .modal')
                .modal('setting', {
                    closable  : false,
                    onHide : function() {
                        location.reload();
                    }
                })
                .modal('show')
            ;
            $('#deploy-form').removeClass('loading');
        }
    }
    $('#deploy-form').ajaxForm(options);
});