function dzsprx_receiver(arg){

    var aux = '';
    var bigaux = '';
    //console.log(arg);
    if(window.console) { console.info(arg); };

    //console.log(jQuery('#dzspb-pagebuilder-con'), jQuery('#dzspb-pagebuilder-con').css);
    if(jQuery('#dzspb-pagebuilder-con').length > 0 && jQuery('#dzspb-pagebuilder-con').eq(0).css('display')=='block' && typeof top.dzspb_lastfocused!='undefined'){
        jQuery(top.dzspb_lastfocused).val(arg);
        jQuery(top.dzspb_lastfocused).trigger('change');
    }else{
        if(window.tinyMCE && window.tinyMCE.activeEditor!=null && jQuery('#content_parent').css('display')!='none'){
            if(window.mceeditor_sel==''){
                if(typeof window.tinyMCE!='undefined'){
                    if(typeof window.tinyMCE.activeEditor!='undefined') {
                        window.tinyMCE.activeEditor.selection.moveToBookmark(window.tinymce_cursor);
                    }
                    if(typeof window.tinyMCE.execInstanceCommand!='undefined') {
                        window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, arg);
                    }else{

                        if(typeof window.tinyMCE.execCommand!='undefined') {
                            window.tinyMCE.get('content').execCommand('mceInsertContent', false, arg);
                        }
                    }
                }


            }else{

                window.tinyMCE.execCommand('mceReplaceContent',false, arg);
            }
        }else{
            aux = jQuery("#content").val();
            bigaux = aux+arg;
            if(window.htmleditor_sel!=undefined && window.htmleditor_sel!=''){
                bigaux = aux.replace(window.htmleditor_sel,arg);
            }
            jQuery("#content").val( bigaux );
        }
    }
    //console.log(bigaux);

    if(jQuery.fn.zoomBox){

        jQuery.fn.zoomBox.close();
    }



    if(window.close_ultibox){

        close_ultibox();
    }
}