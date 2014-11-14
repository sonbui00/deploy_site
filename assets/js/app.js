/**
 * Created by sonbv on 13/11/2014.
 */
var App = App || {};
App.ajaxRequesting = false;
App.isAjaxRequesting = function() {
    if (this.ajaxRequesting) {
        return true;
    }
    return false;
}
$(function () {
    $('.ui.selection.dropdown')
        .dropdown()
    ;

    $('.ui.checkbox')
        .checkbox()
    ;

    $('#git-form')
        .form({
           branch: {
               identifier: "branch",
               rules: [
                   {
                       type: 'empty',
                       prompt: 'Please select branch'
                   }
               ]
           }
        });

    var ajaxBeforeSubmit = function (formData, jqForm, options) {
        if (App.isAjaxRequesting()) {
            sweetAlert('You cannot submit.', 'Had a ajax requesting!!!', 'warning');
            return false;
        }
        App.ajaxRequesting = true;
        jqForm.addClass('loading');
    }

    var optionsDeployAjax = {
        beforeSubmit: ajaxBeforeSubmit,
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
            App.ajaxRequesting = false;
        }
    }
    $('#deploy-form').ajaxForm(optionsDeployAjax);

    var optionsGitAjax = {
        beforeSubmit: ajaxBeforeSubmit,
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
            $('#git-form').removeClass('loading');
            App.ajaxRequesting = false;
        }
    }
    $('#git-form').ajaxForm(optionsGitAjax);
});