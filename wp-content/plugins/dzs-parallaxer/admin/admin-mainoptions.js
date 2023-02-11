jQuery(document).ready(function($){





    function mo_saveall(){
        var mainarray = jQuery('form.mainsettings').serialize();
        var data = {
            action: 'dzsprx_ajax_mo',
            postdata: mainarray
        };
        jQuery('.saveconfirmer').html('Options saved.');
        jQuery('.saveconfirmer').fadeIn('fast').delay(2000).fadeOut('fast');
        jQuery.post(ajaxurl, data, function(response) {
            if(window.console !=undefined ){
                console.log('Got this from the server: ' + response);
            }
        });

        return false;
    }


    $('.saveconfirmer').fadeOut('slow');
    $('.save-mainoptions').bind('click', mo_saveall);
});