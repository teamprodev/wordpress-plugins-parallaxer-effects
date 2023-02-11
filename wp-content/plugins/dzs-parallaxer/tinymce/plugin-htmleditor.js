window.htmleditor_sel = '';
window.mceeditor_sel = '';
window.dzsprx_sel = '';
jQuery(document).ready(function($){





    var _btnCon = null;


    if($('#wp-content-media-buttons').length){

        _btnCon = $('#wp-content-media-buttons').eq(0);
    }else{

        if($('#wp-content-editor-tools').length){

            _btnCon = $('#wp-content-editor-tools').eq(0);
        }

    }

    if(_btnCon){

        _btnCon.append('<button type="button" id="dzsprx-shortcode-generator" class="dzs-shortcode-button button " data-editor="content"><span class="the-icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 612 612" style="enable-background:new 0 0 612 612;" xml:space="preserve">\n' +
            '<g>\n' +
            '\t<g>\n' +
            '\t\t<path d="M582.515,220.85H29.43C13.192,220.85,0,205.863,0,187.476c0-18.387,13.192-33.347,29.43-33.347h553.084    c16.267,0,29.485,14.96,29.485,33.347C612,205.863,598.781,220.85,582.515,220.85z M582.325,181.302L29.43,181.329    c-0.326,0.19-2.23,2.203-2.23,6.147c0,3.971,1.904,5.984,2.448,6.229l552.731-0.027c0.734-0.435,2.421-2.638,2.421-6.202    C584.8,183.804,583.032,181.574,582.325,181.302z" fill="#696a6b"/>\n' +
            '\t\t<path d="M582.515,339.361H29.43c-16.238,0-29.43-14.96-29.43-33.374C0,287.6,13.192,272.64,29.43,272.64h553.084    c16.267,0,29.485,14.96,29.485,33.348C612,324.401,598.781,339.361,582.515,339.361z M582.325,299.812L29.43,299.839    c-0.326,0.19-2.23,2.203-2.23,6.147c0,3.971,1.904,5.983,2.475,6.229l552.704-0.027c0.734-0.407,2.421-2.638,2.421-6.201    C584.8,302.314,583.032,300.084,582.325,299.812z" fill="#696a6b"/>\n' +
            '\t\t<path d="M582.515,457.871H29.43c-16.238,0-29.43-14.96-29.43-33.374c0-18.387,13.192-33.347,29.43-33.347h553.084    c16.267,0,29.485,14.96,29.485,33.347C612,442.911,598.781,457.871,582.515,457.871z M582.325,418.322L29.43,418.35    c-0.326,0.19-2.23,2.203-2.23,6.147c0,3.971,1.904,5.984,2.448,6.229l552.731-0.026c0.734-0.381,2.421-2.611,2.421-6.174    C584.8,420.852,583.032,418.594,582.325,418.322z" fill="#696a6b"/>\n' +
            '\t</g>\n' +
            '</svg></span> <span class="the-label"> '+dzsprx_settings.translate_add_parallaxer+'</span></button>');
    }



    // var aux = '<a class="shortcode_opener" id="dzsprx_shortcode" style="cursor:pointer; display: inline-block; vertical-align: middle;width:auto; height:28px; margin-right: 5px; background-color: #ffffff; color: #726b6b; padding-right: 10px; border: 1px solid rgba(0,0,0,0.3); border-radius:3px; line-height: 1; font-size:13px; padding-left:0;"><i class="" style="  background-size:cover; background-repeat: no-repeat; background-position: center center; background-image: url('+dzsprx_settings.the_url+'tinymce/img/shortcodes-small-retina.png); width:28px; height: 28px; display:inline-block;  vertical-align: middle; margin-right: 5px; " ></i> <span style="display: inline-block; vertical-align: middle; font-size: 11px; font-weight: bold;">'+window.dzsprx_settings.translate_add_parallaxer+'</span></a>';
    //
    //
    // var aux_shortcode_generators_container = '<div class="dzs-shortcode-generators-container"></div>';
    //
    //
    // if($('#wp-content-media-buttons').length){
    //     $('#wp-content-media-buttons').append(aux);
    // }else{
    //     if($('#wp-content-wrap').length){
    //         if($('#wp-content-wrap').eq(0).prev().hasClass('dzs-shortcode-generators-container')==false){
    //
    //             $('#wp-content-wrap').eq(0).before(aux_shortcode_generators_container);
    //         }
    //         $('#wp-content-wrap').eq(0).prev().append(aux);
    //     }
    // }




    if(window.dzsprx_settings.enable_module_features=='on'){
        aux = '<a class="shortcode_opener" id="dzsprx_shortcode_features" style="cursor:pointer; display: inline-block; vertical-align: middle;width:auto; height:28px; margin-right: 5px; background-color: #ffffff; color: #726b6b; padding-right: 10px; border: 1px solid rgba(0,0,0,0.3); border-radius:3px; line-height: 1; font-size:13px; padding-left:0;"><i class="" style="  background-size:cover; background-repeat: no-repeat; background-position: center center; background-image: url('+dzsprx_settings.the_url+'tinymce/img/shortcodes-small-retina.png); width:28px; height: 28px; display:inline-block;  vertical-align: middle; margin-right: 5px; " ></i> <span style="display: inline-block; vertical-align: middle; font-size: 11px; font-weight: bold;">'+window.dzsprx_settings.translate_add_parallaxer_features+'</span></a>';


        if($('#wp-content-media-buttons').length){
            $('#wp-content-media-buttons').append(aux);
        }else{
            if($('#wp-content-wrap').length){
                if($('#wp-content-wrap').eq(0).prev().hasClass('dzs-shortcode-generators-container')==false){

                    $('#wp-content-wrap').eq(0).before(aux_shortcode_generators_container);
                }
                $('#wp-content-wrap').eq(0).prev().append(aux);
            }
        }
    }


    $('#dzsprx-shortcode-generator').bind('click', function(){
        
        var parsel = '';
    if(window.tinyMCE == undefined || window.tinyMCE.activeEditor==null){
        var textarea = document.getElementById("content");
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var sel = textarea.value.substring(start, end);

        //console.log(sel);

        //textarea.value = 'ceva';
        if(sel!=''){
            parsel+='&sel=' + encodeURIComponent(sel);
            window.htmleditor_sel = sel;
        }else{
            window.htmleditor_sel = '';
        }
    }else{
        //console.log(window.tinyMCE.activeEditor);
        var ed = window.tinyMCE.activeEditor;
        var sel=ed.selection.getContent();
        
        if(sel!=''){
            parsel+='&sel=' + encodeURIComponent(sel);
            window.mceeditor_sel = sel;
        }else{
            window.mceeditor_sel = '';
        }
        //console.log(aux);
    }

    //console.log(dzsprx_builder_settings.the_url + 'tinymce/popupframe.php?iframe=true&width=700&height=500' + parsel);
    //jQuery.prettyPhoto.open(dzsprx_builder_settings.the_url + 'tinymce/popupframe.php?iframe=true&width=700&height=500' + parsel, 'dzsprx', '');
    //     window.dzszb_open(dzsprx_settings.shortcode_generator_url + parsel, 'iframe', {bigwidth: 700, bigheight: 700,forcenodeeplink: 'on', dims_scaling: 'fill'});




        window.open_ultibox(null,{

            type: 'iframe'
            ,source: dzsprx_settings.shortcode_generator_url + parsel
            ,scaling: 'fill' // -- this is the under description
            ,suggested_width: 1100 // -- this is the under description
            ,suggested_height: 700 // -- this is the under description
            ,item: null // -- we can pass the items from here too

        })
        
        return false;
    });

    $('#dzsprx_shortcode_features').bind('click', function(){

        var parsel = '';
        window.htmleditor_sel = '';
        window.mceeditor_sel = '';
    if(window.tinyMCE == undefined || window.tinyMCE.activeEditor==null){
        var textarea = document.getElementById("content");
        var start = textarea.selectionStart;
        var end = textarea.selectionEnd;
        var sel = textarea.value.substring(start, end);

        console.log(sel,start, end);

        //textarea.value = 'ceva';
        if(sel!=''){
            parsel+='&sel=' + encodeURIComponent(sel);
            window.htmleditor_sel = sel;
        }else{
            window.htmleditor_sel = '';
        }


        //console.log(window.htmleditor_sel,window.mceeditor_sel);
    }else{
        //console.log(window.tinyMCE.activeEditor);
        var ed = window.tinyMCE.activeEditor;
        var sel=ed.selection.getContent();

        if(sel!=''){
            parsel+='&sel=' + encodeURIComponent(sel);
            window.mceeditor_sel = sel;
        }else{
            window.mceeditor_sel = '';
        }


        //console.log(window.htmleditor_sel,window.mceeditor_sel);
        //console.log(aux);
    }

    //console.log(dzsprx_builder_settings.the_url + 'tinymce/popupframe.php?iframe=true&width=700&height=500' + parsel);
    //jQuery.prettyPhoto.open(dzsprx_builder_settings.the_url + 'tinymce/popupframe.php?iframe=true&width=700&height=500' + parsel, 'dzsprx', '');
        window.dzszb_open(dzsprx_settings.module_features_shortcode_generator_url + parsel, 'iframe', {bigwidth: 700, bigheight: 700,forcenodeeplink: 'on', dims_scaling: 'fill'});


        return false;
    });
})