

function get_shortcode_attr(arg, argtext){

    var regex_aattr = new RegExp(' '+arg+'="(.*?)"');


    if(arg == 'layers'){
        regex_aattr = new RegExp(arg+'=\'(.*?)\'');
    }

    // console.log(regex_aattr, argtext);

    var aux = regex_aattr.exec(argtext);

    // console.warn('aux for arg - ', arg, aux);

    if(aux){
        var foutobj = {'full' : aux[0], 'val' : aux[1]};
        return foutobj;
    }



    return false;
}




jQuery(document).ready(function($) {
    var coll_buffer = 0;
    var fout = '';

    var dzsprx_sel = '';

    var _previewOverlay_top = $('.preview-media-overlay-top');
    var _previewOverlay_bottom = $('.preview-media-overlay-bottom');



    if($('.wpdzsprx-sel').length){
        dzsprx_sel = $('.wpdzsprx-sel').eq(0).html();
    }

    var _shortcodeItemsCon = $('.shortcode-items-con').eq(0);


    if(dzsprx_sel){

        //console.log(dzsprx_sel);


        var regex_1 = /media="(.*?)"/g;

        var aux_a = regex_1.exec(dzsprx_sel);

        if(aux_a && aux_a[1]){
            //console.log(aux_a,$('input[name="media"]'));
            $('input[name="media"]').val(aux_a[1]);
        }

        var regex_1 = /responsive_reference_width="(.*?)"/g;

        var aux_a = regex_1.exec(dzsprx_sel);

        if(aux_a && aux_a[1]){
            //console.log(aux_a,$('input[name="media"]'));
            $('input[name="responsive_reference_width"]').val(aux_a[1]);
        }

        var regex_1 = /responsive_optimal_height="(.*?)"/g;

        var aux_a = regex_1.exec(dzsprx_sel);

        if(aux_a && aux_a[1]){
            //console.log(aux_a,$('input[name="media"]'));
            $('input[name="responsive_optimal_height"]').val(aux_a[1]);
        }

        var regex_1 = /settings_mode="(.*?)"/g;

        var aux_a = regex_1.exec(dzsprx_sel);

        if(aux_a && aux_a[1]){
            //console.log(aux_a,$('input[name="media"]'));
            $('*[name="settings_mode"]').val(aux_a[1]);
        }




        var regex_2 = /hover="(.*?)"/g;

        aux_a = regex_2.exec(dzsprx_sel);

        if(aux_a && aux_a[1]){
            $('select[name="the_hover"]').val(aux_a[1]);
        }





        aux_a = /scroll_axis_x="(.*?)"/g.exec(dzsprx_sel);

        if(aux_a && aux_a[1]){
            $('select[name="scroll_axis_x"]').val(aux_a[1]);
        }


        aux_a = /scroll_axis_y="(.*?)"/g.exec(dzsprx_sel);

        if(aux_a && aux_a[1]){
            $('select[name="scroll_axis_y"]').val(aux_a[1]);
        }



        var regex_cont = /\[dzs_parallaxer.*?(?!\})\]([\s|\S]*.?)\[\/dzs_parallaxer]/g;

        aux_a = regex_cont.exec(dzsprx_sel);

        if(aux_a && aux_a[1] && aux_a[1]!='\']'){

            if(aux_a[1].indexOf('\']')==0){
                aux_a[1] = aux_a[1].replace('\']','');
            }
            $('textarea[name="content"]').val(aux_a[1]);
        }

        var regex_items = /\[dzs_layouter_item.*?\[\/dzs_layouter_item\]/g;


        while(aux_a = regex_items.exec(dzsprx_sel)){
            //console.info(aux_a);


            _shortcodeItemsCon.append(window.dzsprx_settings_shortcode_item);

            var regex_item_1 = /media="(.*?)"/g;

            var aux_a2 = regex_item_1.exec(aux_a[0]);

            //console.info(aux_a2);



        }

        setTimeout(function(){
            $('input').trigger('change');
        },300);





        var arr_settings = ['height_is_based_on_content', 'breakout','clip_width','total_width','enable_layers','layers','parallax_content_type','video_media','gmaps_lat','gmaps_long'];

        // arr_settings = $.extend(arr_settings, standard_options);

        // $('.dzsvg-admin').append('<div class="misc-initSetup"><h5>Start Setup</h5></h5><p>'+htmlEncode(top.dzsvg_startinit)+'</p></div>');


        var res;
        var lab='';
        for(var key in arr_settings){

            lab = arr_settings[key];
            res = get_shortcode_attr(lab, dzsprx_sel);
            // console.info('lab - ',lab, res, lab, dzsprx_sel);
            if(res){
                if(lab=='id'){
                    lab = 'dzsvg_selectid';
                }
                if(lab=='db'){
                    lab = 'dzsvg_selectdb';
                }
                if(lab=='cat'){
                    var res_arr = String(res['val']).split(',');


                    $('*[name="'+lab+'[]"').each(function(){
                        var _t2 = $(this);

                        // console.warn(_t2, _t2.val(), res_arr);
                        for(var ij in res_arr){

                            // console.info(ij);

                            if(_t2.val()==res_arr[ij]){
                                _t2.prop('checked',true);
                                _t2.trigger('change');
                            }
                        }
                        _t2.parent().attr('data-init_categories',res['val']);
                    })


                }else{

                    // console.info('lab - ',lab, res);


                    var _c = $('*[name="'+lab+'"]:not(.fake-input)').eq(0);

                    if(_c.attr('type')=='checkbox'){

                        // console.warn(_c.val(), res['val']);

                        if(_c.val()==res['val']){
                            _c.prop('checked',true);
                        }
                    }else{

                        _c.val(res['val']);
                    }
                    _c.trigger('change');
                }
            }
        }

    }
    //console.log($('.layouts-selecter .dzsprxouter'));






    $('.btn-insert-shortcode').bind('click', handle_mouse);
    $('*[name=enable_custom_content]').bind('change', handle_change);


    $('*[name=enable_custom_content]').trigger('change');


    $(document).on( 'click', '.import-sample, .hide-notice,.btn-add-media,.setting-for-transition .selector-btn-secondary > .tooltip-indicator',handle_mouse);
    $(document).on( 'change', '.input-dimension',function(){
        adjust_preview_overlay();
    });


    adjust_preview_overlay();





    $(document).on('click.antfarmrep', '.btn-add-repeater-field,.repeater-btn.delete-btn, .repeater-con .toggle-active', handle_mouse_repeater);
    $(document).on('change.antfarmrep', '.repeater-con:not(.repeater-con-for-clone) .repeater-field, *[data-property_repeater_name]', handle_change_repeater);

    setup_repeater_cons();


    setTimeout(function(){

        // var _c = $('.repeater-con-for-clone').find('select.dzs-style-me');
        //
        // if(_c.get(0) && _c.get(0).api_destroy){
        //     _c.get(0).api_destroy();
        // }

    },100);



    function handle_mouse_repeater(e){
        var _t3 = $(this);

        if(e.type=='click'){
            if(_t3.hasClass('toggle-active')){


                var _con = _t3.parent().parent().parent();


                if(_con.hasClass('active')==false){

                    _con.parent().children().removeClass('active');
                }


                _con.toggleClass('active');

            }
            if(_t3.hasClass('btn-add-repeater-field')){



                add_repeater_field(_t3.parent().parent());

                repeater_generate_serialized(_t3.parent().parent());
                return false;
            }
            if(_t3.hasClass('delete-btn')){


                var _con = _t3.parent().parent().parent().parent().remove().remove();

                repeater_generate_serialized(_con);
            }
        }
    }

    function handle_change_repeater(e){
        var _t3 = $(this);

        if(e.type=='change'){

            if(_t3.attr('data-property_repeater_name')){

                // console.info('ceva');
                repeater_custom_transition_generate();
            }
            if(_t3.hasClass('repeater-field')){


                // console.info(_t3.data('repeater-con-main'));

                var _rCM = null;

                if(_t3.data('repeater-con-main')){
                    _rCM = _t3.data('repeater-con-main');
                }

                if(_t3.parent().parent().parent().parent().parent().hasClass('repeater-main-con')){
                    _rCM = _t3.parent().parent().parent().parent().parent();
                }

                if(_t3.parent().parent().parent().parent().parent().parent().parent().hasClass('repeater-main-con')){
                    _rCM = _t3.parent().parent().parent().parent().parent().parent().parent();
                }
                if(_t3.parent().parent().parent().parent().parent().parent().parent().parent().hasClass('repeater-main-con')){
                    _rCM = _t3.parent().parent().parent().parent().parent().parent().parent().parent();
                }


                // console.info('changed repeater field - _rCM - ',_rCM);
                // console.info('changed repeater field - _t3 - ',_t3);


                repeater_generate_serialized(_rCM,{
                    "call_from":"change_field"
                });


            }

            if(_t3.attr('data-repeater_name')=='title'){
                _t3.parent().parent().parent().find('.the-title').eq(0).html(_t3.val());
            }
        }
    }
    function htmlDecode(value){
        return $('<div/>').html(value).text();
    }
    function repeater_generate_serialized(_argRepeaterMainCon,pargs){




        var aux = '';

        var margs = {
            call_from: "default"
        };

        if(pargs){
            margs = $.extend(margs,pargs);
        }

        // console.info(margs);




        var arr = [];


        if(_argRepeaterMainCon){

            _argRepeaterMainCon.find('.repeater-con:not(".repeater-con-for-clone")').each(function(){
                var _t4 = $(this);



                var arr_aux = {};
                _t4.find('*[data-repeater_name]').each(function(){
                    var _t42 = $(this);


                    var lab = _t42.attr('data-repeater_name');
                    var val = _t42.val();


                    if(lab=='media_html'){
                        val = htmlEncode(val);
                        val = val.replace(/\"/g,'{{qq}}');
                    }

                    // console.warn('_t42.parent() - ',_t42.parent());

                    if(_t42.parent().css('display')!='none' && _t42.parent().parent().css('display')!='none' && _t42.parent().parent().parent().css('display')!='none'){

                        arr_aux[_t42.attr('data-repeater_name')] = val;
                    }



                });

                arr.push(arr_aux);
            })


            aux = JSON.stringify(arr);


            aux = aux.replace(/\[/g,'{patratstart}');
            aux = aux.replace(/\]/g,'{patratend}');


            // console.info('arr - ',arr);
            // console.info('aux - ',aux);

            // console.info('_argRepeaterMainCon - ',_argRepeaterMainCon);
            // console.info('_argRepeaterMainCon.prev() - ',_argRepeaterMainCon.prev());

            _argRepeaterMainCon.prev().val(aux);
        }else{


            // console.warn('_argRepeaterMainCon not found - ',_argRepeaterMainCon);
        }

    }


    function add_repeater_field(_arg, pargs){

        var margs = {

            link: '#'
            ,title: 'Title'
            ,icon: ''
            ,position: 'center center'
            ,media: ''
        };






        if(pargs){
            margs = $.extend(margs,pargs);
        }





        _arg.find('.repeaters-con').eq(0).append(_arg.find('.repeater-con-for-clone').clone() );
        var _cach = _arg.find('.repeaters-con').children().last();

        _cach.find('.dzs-style-me-clone').addClass('dzs-style-me');

        _cach.removeClass('repeater-con-for-clone');


        for(var lab in margs){




            var val = margs[lab];



            // console.info('lab - ',lab, _cach.find('*[data-repeater_name="'+lab+'"]'));
            if(lab=='media_html'){
                val = htmlDecode(val);
                val = val.replace(/{{qq}}/g,'"');
            }
            _cach.find('*[data-repeater_name="'+lab+'"]').val(val);

            if(lab=='title'){
                _cach.find('.the-title').eq(0).html(margs[lab]);
            }


            if(lab=='layer_transition_custom'){
                var val = margs[lab];
                console.warn(val);



                var valar = JSON.parse(b64DecodeUnicode(val));

                // console.info(valar);


                for(var lab2 in valar){
                    var val2 = valar[lab2];


                    var _cache = _cach.find('div[data-property-name="'+lab2+'"]');


                    _cache.addClass('property-active');

                    for(var lab3 in val2){
                        var val3 = val2[lab3];

                        _cache.find('*[data-property_repeater_name='+lab3+']').val(val3);


                    }


                }



            }

        }



        setTimeout(function(){

            // console.info('lets dzssel init - ',$('.repeater-con:not(".repeater-con-for-clone") select.opener-listbuttons'));
            dzssel_init('.repeater-con:not(".repeater-con-for-clone") select.opener-listbuttons', {init_each: true});
        },50);

    }



    function generate_repeater_cons(_repeaterMainCon,_t){


        var aux_arr = [];




        if(_repeaterMainCon.data('target-input')){
            try{

                var _inp = _repeaterMainCon.data('target-input');


                if(_inp.val()){


                    var aux = _inp.val();



                    aux = aux.replace(/\{patratstart}/g,'[');
                    aux = aux.replace(/\{patratend}/g,']');

                    aux_arr = JSON.parse(aux);

                    for(var lab in aux_arr){
                        add_repeater_field(_repeaterMainCon, aux_arr[lab]);
                    }
                }
            }catch(err){
                console.info('err in json ' , err);
            }
        }




    }


    function regenerate_repeater_cons(){



        $('.repeater-main-con').each(function(){
            var _t2 = $(this);

            generate_repeater_cons(_t2, _t2.prev())
        })
    }




    function setup_repeater_cons(){






        $('.repeater-con-target').each(function(){
            var _t = $(this);

            var _repeaterMainCon = null;




            if(_t.hasClass('setuped')){
                return;
            }


            _t.addClass('setuped');



            if(_t.next().hasClass('repeater-main-con')){
                _repeaterMainCon = _t.next();

            }

            _t.next().data('target-input',_t);





            // console.warn("_t - ", _t);
            // console.warn("_t.next() - ", _t.next());
            // console.warn("_repeaterMainCon - ", _repeaterMainCon);

            if(_repeaterMainCon.data('setuped')=='on'){  return; }



            if(_t.parent().parent().parent().parent().parent().parent().parent().hasClass('widgets-holder-wrap')){

            }










            var _repeaterTarget = _t;

            var _repeaterCons = null;

            var inter_change_dom = 0;
            if(_repeaterMainCon){

                _repeaterCons = _repeaterMainCon.find('.repeaters-con').eq(0);



                console.info('_repeaterCons - ',_repeaterCons);


                if($.fn.sortable){





                    _repeaterCons.sortable({
                        items: '.repeater-con'
                        ,handle: '.move-btn'
                        ,scrollSensitivity:100,
                        forcePlaceholderSize: true,
                        forceHelperSize: false,
                        helper: 'clone',
                        opacity: 0.7,
                        placeholder: 'repeater-con-placeholder',
                        update: function(event, ui) {

                            // console.info(this);

                            var _t = $(this);

                            if(_t.parent().hasClass('repeater-main-con')){

                                repeater_generate_serialized(_t.parent());
                            }

                            if(_t.parent().parent().hasClass('repeater-main-con')){

                                repeater_generate_serialized(_t.parent().parent());
                            }
                        }
                    });
                }else{
                    console.warn('please include sortable');
                }





                if(_t.parent().parent().hasClass('widget-content')){
                    _t.parent().parent().on('DOMNodeInserted DOMNodeRemoved', function(){



                        if(_t.val()!='[]'){

                            if(_repeaterMainCon.find('.repeater-con').length==1){




                                regenerate_repeater_cons();


                            }

                        }
                        setTimeout(function(){

                        },500);

                    })
                }
            }



            _repeaterMainCon.addClass('setuped');
            _repeaterMainCon.data('setuped','on');
            generate_repeater_cons(_repeaterMainCon);



        })



    }










    function adjust_preview_overlay(){


        var ratio = 80;


        var ch = $('*[name=clip_height]').eq(0).val();
        var th = $('*[name=total_height]').eq(0).val();


        if(th.indexOf('%')>-1){
            ratio = 10000/parseInt(th,10)
        }else{
            ratio = ch / th * 100;
        }


        _previewOverlay_top.css({
            'height': ((100 - ratio )/2)+'%'
        })



        _previewOverlay_bottom.css({
            'bottom': 0
            ,'height': ((100 - ratio )/2)+'%'
        })
    }

    function handle_change(e){
        var _t = $(this);


        if(e.type=='change'){
            if(_t.attr('name')=='enable_custom_content'){
                //console.log(_t.prop('checked'));

                if(_t.prop('checked')){
                    $('.the-custom-content').show();
                }else{

                    $('.the-custom-content').hide();
                }
            }
        }
    }



    function repeater_custom_transition_generate(){



        $('.setting-for-transition').each(function(){
            var _t = $(this);

            if(_t.parent().parent().parent().parent().hasClass('repeater-con-for-clone')){
                return;
            }

            var finar = {};


            // console.info("_t - ",_t);
            // console.info("_t - ",_t.parent().parent().parent().parent());

            _t.children('.bigoption').each(function(){
                var _tc = $(this);



                if(_tc.hasClass('property-active')){

                    finar[_tc.attr('data-property-name')] = {};


                    finar[_tc.attr('data-property-name')].initial = _tc.find('input[data-property_repeater_name="initial"]').val();
                    finar[_tc.attr('data-property-name')].mid = _tc.find('input[data-property_repeater_name="mid"]').val();
                    finar[_tc.attr('data-property-name')].final = _tc.find('input[data-property_repeater_name="final"]').val();


                }

                // console.info(_tc);
            })

            var enc_finar = b64EncodeUnicode(JSON.stringify(finar))


            // -- lets encode transition json

            // console.info('finar - ',finar);
            // console.info('finar encoded - ',enc_finar);
            // console.info('finar decoded - ',JSON.parse(b64DecodeUnicode(enc_finar)) );


            var _inp = _t.children('input').eq(0);
            _inp.val(enc_finar);
            _inp.trigger('change');

            // console.info('_inp - ',_inp);
        })





    }




    function handle_mouse(e){
        var _t = $(this);
        var _con = null;

        if(e.type=='click'){
            if(_t.hasClass('tooltip-indicator')){
                _t.parent().toggleClass('property-active');

                repeater_custom_transition_generate();
            }
            if(_t.hasClass('btn-add-media')){


                item_gallery_frame = wp.media.frames.downloadable_file = wp.media({
                    title: 'Add Items to Parallaxer',
                    button: {
                        text: 'Add to parallaxer'
                    },
                    multiple: false
                });

                item_gallery_frame.on( 'select', function() {

                    var selection = item_gallery_frame.state().get('selection');
                    selection = selection.toJSON();

                    var ik=0;
                    for(ik=0;ik<selection.length;ik++){

                        var _c = selection[ik];
                        //console.info(_c);
                        if(_c.id==undefined){
                            continue;
                        }

                        _t.parent().parent().find('input').eq(0).val(_c.url);
                        _t.parent().parent().find('input').eq(0).trigger('change');

                    }
                });



                // Finally, open the modal.
                item_gallery_frame.open();

                return false;

            }
            if(_t.hasClass('btn-insert-shortcode')){


                var type = 'inpage';

                if(parent!=window && typeof(parent.dzsprx_receiver)=='function'){
                    type = 'parent';
                }else{
                    type = 'inpage';
                }


                prepare_fout(type);

                // console.info(fout)
                if(type=='parent'){
                    parent.dzsprx_receiver(fout);
                }else{
                    $('.shortcode-output').html(fout);
                }



                return false;
            }
            if(_t.hasClass('hide-notice')){


                var data = {
                    action: 'dzsprx_ajax_hide_notice'
                    ,postdata: _t.attr('data-notice')
                };


                jQuery.post(ajaxurl, data, function(response) {
                    if(window.console !=undefined ){
                        console.log('Got this from the server: ' + response);
                    }
                });

                _t.parent().parent().parent().removeClass('active');
                _t.parent().remove();


                return false;
            }
            if(_t.hasClass('import-sample')){

                fout = '';
                if(_t.hasClass('import-sample-1')){

                    fout = '[dzs_parallaxer media="http://localhost/wordpress/wp-content/uploads/2016/01/sample.jpg" clip_height="auto" total_height="120%" breakout="off" direction="normal" use_loading="on" settings_mode="simple" enable_scrollbar="off"] <div class="semi-black-overlay"></div> <div class="dzs-container"> <div class="dzs-row dzs-row-inline"> <div class="dzs-col-md-6 color-white" style="position: relative;"> <h3>Where artists and fans come together.</h3> Connect is a place where fans can engage with their favorite artists. They can see, comment on, like, and share whatever exciting material an artist chooses to post. Unreleased demo tracks, an acoustic version of the latest hit, a video shot in the studio — it’s right here and straight from the source. </div> <div class="dzs-col-md-6"><img class="fullwidth" style="position: relative;" src="https://lh3.googleusercontent.com/8nW6D7tvenCO16K9hDRnntjaooArnIVcSpA_NEBeoI2XLcF8AVNqiKL7bNDQ3l-wkytQp8GGIWN4PlrDsgre8ucqk_aADTnvphji7ngwkxEr3YT2J49a90EYDz1WKc807u1aGu5bcVFu1Lb4FDChu4SahL1ecsyW0qiXE2pSlQs-qn0o4MfIE5zA1a_RPx6Zpp26bhAVnOlO35yQhcSxOWMTVQEDauQp_LxPyIPWU4hovRduSMB1S2bYFkwLBM9tc2IbFlV-WUBt-O3IccAfmLjpwDLg6GP_ACIrQIYVwwrfmw9i7buEb_Tbk_xstgieyao-ciTwq_NMni4XTtIXkXwgoHlSbo2uoYa9jvFd7ArGVvr9kUKTTzEftDVIToOscsRJFr-91F0aj1tVa4bYzaMQDx3mJpdu-P1uEL-dVu-BdJOt3-1lnbh015eUu-6aU7HqfHEkymgAO1lccyKlYfHzoPa70cOwolxgml90MxCRFh96RoS3m7gQRAq5aX2gpYOTYfeuC6m6SGRgezeHtTqNzq2Quqmm00GNCvASqZrk56bZFBI0W3fLGQLLzF11F5Mm=w491-h740-no" alt="" data-parallaxanimation="[{property:&quot;opacity&quot;,value:&quot;{{val}}&quot;,initial:&quot;0&quot;,mid:&quot;1&quot;,final:&quot;1&quot;},{property:&quot;transform&quot;,value:&quot;scale({{val}})&quot;,initial:&quot;1&quot;,mid:&quot;1&quot;,final:&quot;0.5&quot;},{property:&quot;top&quot;,value:&quot;{{val}}px&quot;,initial:&quot;0&quot;,mid:&quot;0&quot;,final:&quot;300&quot;}]" /></div> </div> </div> [/dzs_parallaxer][dzs_parallaxer media="https://lh3.googleusercontent.com/4aqEleaHDXMTOVedK-JHrH24SQjNZ_6ZMTJiQh1BD5XhXxOaJZ9SKB1m3PKSya0-g-nak08ndsTunfm7rIT6c6QYEQ2EMTtYgJ_t9lhpzR_YQOpb0K0HCskN5WfQ8XcObDe8C_VtIm7628MgYj5fY1_oCHXpUEo4xPXhCsPb7CwUFgDB_AK5sMBgKC_5-kYYixiLfbsL2nbFZoiik3dH4A0Jl2tTe_1IrcVkANQdVpXUrliYo27Zm0bJjMC5LQudfdyzPoCt-9cCOBbE4RILRA5sbqt7mSD0TD4h4vpY4vlWjoiBIf0caLPD1ZSq41efNrdLXdzxvi7LnHwyR3miyDiVNjIqNJVoKrm2KIp-a-rd5FK1X5SCj_mpxB_wD04X4KEBpCaiz0d7jp94Z1sAqfZQHbpFwQ6NjnYnKSL4iEk6EOL-UmSIpmN9l7cZtBX3QZM4nu3IowvmRN1cq5gYBiG2IR2q4rTB5yTkl9HDacBLKX45SF_bogq9bj1_tRLN0LtevL4NewSYs0--HTiX-WzSIzz1rSSkGlHq1wogTAkq-lygfDttZkMfvegCnA8q9Q9q=w1626-h904-no" clip_height="auto" total_height="120%" breakout="off" direction="normal" use_loading="on" settings_mode="simple" enable_scrollbar="off"] <div class="dzs-container"> <div class="dzs-row dzs-row-inline"> <div class="dzs-col-md-6 color-white"> </div> <div class="dzs-col-md-6 "> &nbsp; <p> </p> &nbsp; <p> </p> &nbsp; <p> </p> &nbsp; <p> </p> &nbsp; <p> </p> <h3>Where artists and fans come together.</h3> <p>Connect is a place where fans can engage with their favorite artists. They can see, comment on, like, and share whatever exciting material an artist chooses to post. Unreleased demo tracks, an acoustic version of the latest hit, a video shot in the studio — it’s right here and straight from the source.</p> &nbsp; <p> </p> &nbsp; <p> </p> &nbsp; <p> </p> &nbsp; <p> </p> &nbsp; <p> </p> </div> </div> </div> [/dzs_parallaxer] ';
                }
                if(_t.hasClass('import-sample-2')){

                    fout = '[dzs_parallaxer media="http://localhost/wordpress/wp-content/uploads/2016/05/5.jpg" clip_height="400" total_height="600" breakout="trybreakout" direction="normal" use_loading="on" settings_mode="simple" height_is_based_on_content="off" enable_scrollbar="off"] <div class="dzs-colcontainer dzs-colcontainer-w center-it row-inline"> <div class="dzs-col-9 dzsparallaxer--team-member-con" style="text-align: left; width: 75%;" data-parallaxanimation="[{property:&quot;opacity&quot;,value:&quot;{{val}}&quot;,initial:&quot;0&quot;,mid:&quot;1&quot;,final:&quot;-1&quot;},{property:&quot;transform&quot;,value:&quot;translate3d(0,{{val}}px,0)&quot;,initial:&quot;-30&quot;,mid:&quot;0&quot;,final:&quot;0&quot;}]"> <h3 style="color: #fff; padding:0; margin:0; ">King Doe Joseph</h3> </div> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: right; width: 25%;" data-parallaxanimation="[{property:&quot;opacity&quot;,value:&quot;{{val}}&quot;,initial:&quot;0&quot;,mid:&quot;1&quot;,final:&quot;-1&quot;},{property:&quot;transform&quot;,value:&quot;translate3d(0,{{val}}px,0)&quot;,initial:&quot;-30&quot;,mid:&quot;0&quot;,final:&quot;0&quot;}]"> <div class=""><em>7th June 2016</em></div> </div> </div> [/dzs_parallaxer]';
                }
                if(_t.hasClass('import-sample-3')){

                    fout = '[dzs_parallaxer clip_height="400" total_height="600" breakout="off" direction="normal" use_loading="on" settings_mode="normal" height_is_based_on_content="off" enable_scrollbar="off"][dzsprx_custom_content][dzsprx_fullslider][dzsprx_fullslider_item source="https://placeholdit.imgix.net/~text?txtsize=33&txt=placeholder1&w=1400&h=600"][dzsprx_fullslider_item source="https://placeholdit.imgix.net/~text?txtsize=33&txt=placeholder2&w=1400&h=600"][dzsprx_fullslider_item source="https://placeholdit.imgix.net/~text?txtsize=33&txt=placeholder3&w=1400&h=600"][/dzsprx_fullslider][/dzsprx_custom_content][/dzs_parallaxer]';
                }
                if(_t.hasClass('import-sample-4')){

                    fout = '[dzs_parallaxer media="http://loremflickr.com/1400/600/face" clip_height="400" total_height="130%" breakout="trybreakout" direction="normal" use_loading="on" settings_mode="normal" height_is_based_on_content="on" settings_mode_oneelement_max_offset="30" enable_scrollbar="off"]<div class="dzs-container color-white" ><div class="dzs-row"><div class="dzs-col-md-12"><h2>Title</h2><h4>Position</h4><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat </p><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.  </p>  <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.  </p>  </div></div></div>[/dzs_parallaxer][dzs_parallaxer media="http://loremflickr.com/1400/600/portrait" clip_height="400" total_height="130%" breakout="trybreakout" direction="normal" use_loading="on" settings_mode="normal" height_is_based_on_content="on" settings_mode_oneelement_max_offset="30" enable_scrollbar="off"]<div class="dzs-container color-white" ><div class="dzs-row"><div class="dzs-col-md-12"><h2>Title</h2><h4>Position</h4><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat </p><p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.  </p>  <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.  </p>  </div></div></div>[/dzs_parallaxer]';
                }
                if(_t.hasClass('import-sample-5')){

                    fout = ' <div class="dzs-row"> <div class="dzs-col-md-6"> <img src="https://i.imgur.com/5uPMScg.png" width="100%"/> </div> <div class="dzs-col-md-6"> [dzs_parallaxer clip_height="auto" total_height="600" breakout="off" direction="normal" use_loading="on" settings_mode="oneelement" height_is_based_on_content="off" box_type="dark-grey-box" enable_scrollbar="off" settings_mode_oneelement_max_offset="150"]Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.[/dzs_parallaxer] </div> </div>';
                }
                dzsprx_tinymce_add_content(fout);
                return false;
            }
        }
    }


    function prepare_fout(type){
        fout='';
        fout+='[dzs_parallaxer';
        var _c,
            _c2
            ;

        var lab = '';






        _c = $('*[name=media]');
        if(_c.val() && _c.val()!=''){
            fout+=' media="' + _c.val() + '"';
        }



        lab='parallax_content_type';


        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){

            fout+=' '+lab+'="' + _c.val() + '"';

            if(_c.val()=='video'){

                fout+=' video_media="' + $('*[name=video_media]').val() + '"';
            }

            if(_c.val()=='gmaps'){

                fout+=' gmaps_lat="' + $('*[name=gmaps_lat]').val() + '"';
                fout+=' gmaps_long="' + $('*[name=gmaps_long]').val() + '"';
            }
        }


        lab = 'clip_height';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }

        lab = 'total_height';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'breakout';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!='' && _c.val()!='off'){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'direction';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'use_loading';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'settings_mode';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';

            if(_c.val()=='oneelement'){

                lab = 'settings_mode_oneelement_max_offset';
                _c = $('*[name='+lab+']');
                if(_c.val() && _c.val()!=''){
                    fout+=' '+lab+'="' + _c.val() + '"';
                }
            }
        }
        lab = 'height_is_based_on_content';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'extra_classes';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'box_type';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'responsive_reference_width';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'responsive_optimal_height';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'disable_effect_on_mobile';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }


        lab = 'enable_scrollbar';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!='' && _c.val()!='off'){
            fout+=' '+lab+'="' + _c.val() + '"';
        }

        lab = 'scroll_axis_x';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!='' && _c.val()!='off'){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'scroll_axis_y';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!='' && _c.val()!='on'){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'settings_movexaftermouse';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!='' && _c.val()!='off'){
            fout+=' '+lab+'="' + _c.val() + '"';
        }

        lab = 'clip_width';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!='' && _c.val()!='100%'){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'total_width';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!='' && _c.val()!='100%'){
            fout+=' '+lab+'="' + _c.val() + '"';
        }
        lab = 'enable_layers';
        _c = $('*[name='+lab+']');

        console.warn('lab - ', lab,_c, _c.prop('checked'), _c.is(':checked'));
        if(_c.is(':checked')){
            fout+=' '+lab+'="' + 'on' + '"';


            lab = 'layers';
            _c = $('*[name='+lab+']');
            if(_c.val() && _c.val()!=''){
                fout+=' '+lab+'=\'' + _c.val() + '\'';
            }

        }


        fout+=']';


        _c = $('*[name=enable_custom_content]');
        if(_c.val()=='on'){


            _c = $('*[name=custom_content]');
            if(_c.val()){
                fout+='[dzsprx_custom_content]' + _c.val() + '[/dzsprx_custom_content]';
            }

        }
        _c = $('*[name=content]');


        var cont = '';

        if(window.tinyMCE){

            tinyMCE.triggerSave();


            var ed = tinyMCE.get('content');
            // console.info(ed);
            // var eds = tinyMCE.editors;
            // console.info(eds);


            if(ed){
                cont = (ed.getContent({format: 'raw'}));;

                console.info('ed.getContent({format: \'raw\'}) - ',ed.getContent({format: 'raw'}));
            }else{

                if(_c.val()){
                    cont = _c.val();
                }
            }
        }else{

            if(_c.val()){
                cont = _c.val();
            }
        }

        if(type=='inpage'){
            cont = htmlEncode(cont);
        }


        // if(window.tinyMCE == undefined || window.tinyMCE.activeEditor==null){
        //
        // }else{
        //     var aux = tinyMCE.EditorManager.get('custom_content');
        //
        //     var ed = window.tinyMCE.activeEditor;
        //     var sel=ed.getContent();
        //     console.info(aux, ed, sel, tinymce.editors);
        // }

        fout+='' + cont + '';


        fout+='[/dzs_parallaxer]';
    }


});


window.insert_to_wp_tinymce = function(arg){
    if(jQuery('#dzspb-pagebuilder-con').length > 0 && jQuery('#dzspb-pagebuilder-con').eq(0).css('display')=='block' && typeof top.dzspb_lastfocused!='undefined'){
        jQuery(top.dzspb_lastfocused).val(arg);
        jQuery(top.dzspb_lastfocused).trigger('change');
    }else{
        if(window.tinyMCE.activeEditor!=null && jQuery('#content_parent').css('display')!='none'){
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
}


function dzsprx_tinymce_add_content(fout){
    //console.log('tinymce_add_content()', arg);



    if(parent!=window && typeof(parent.dzsprx_receiver)=='function'){
        parent.dzsprx_receiver(fout);
    }else{
        jQuery('.shortcode-output').text((fout));
    }
}

function htmlEncode(value){
    //create a in-memory div, set it's inner text(which jQuery automatically encodes)
    //then grab the encoded contents back out.  The div never exists on the page.
    return jQuery('<div/>').text(value).html();
}

window.insert_team_module= function(){
//console.info('ceva');

    window.insert_to_wp_tinymce('<div class="dzs-colcontainer dzsparallaxer--team-members-con center-it"> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: center; width: 20%;" data-parallaxanimation=\'[{property:"opacity",value:"{{val}}",initial:"0",mid:"1",final:"0"},{property:"transform",value:"translate3d(0,{{val}}px,0)",initial:"-30",mid:"0",final:"0"}]\'> <img src="http://dummyimage.com/200x200/000/fff"/> <div class="team-member--title"> King Doe Joseph </div> <div class="team-member--subtitle"> General Manager </div> </div> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: center; width: 20%;" data-parallaxanimation=\'[{property:"opacity",value:"{{val}}",initial:"0",mid:"1",final:"1"},{property:"transform",value:"translate3d(0,{{val}}px,0)",initial:"30",mid:"0",final:"0"}]\'> <img src="http://dummyimage.com/200x200/000/fff"/> <div class="team-member--title"> Smith James </div> <div class="team-member--subtitle"> Tehnical Engineer </div> </div> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: center; width: 20%;" data-parallaxanimation=\'[{property:"opacity",value:"{{val}}",initial:"0",mid:"1",final:"0"},{property:"transform",value:"translate3d(0,{{val}}px,0)",initial:"-30",mid:"0",final:"0"}]\'> <img src="http://dummyimage.com/200x200/000/fff"/> <div class="team-member--title"> Sarah May </div> <div class="team-member--subtitle"> Finance </div> </div> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: center; width: 20%;" data-parallaxanimation=\'[{property:"opacity",value:"{{val}}",initial:"0",mid:"1",final:"1"},{property:"transform",value:"translate3d(0,{{val}}px,0)",initial:"30",mid:"0",final:"0"}]\'> <img src="http://dummyimage.com/200x200/000/fff"/> <div class="team-member--title"> Prett Scott </div> <div class="team-member--subtitle"> Communcation </div> </div> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: center; width: 20%;" data-parallaxanimation=\'[{property:"opacity",value:"{{val}}",initial:"0",mid:"1",final:"0"},{property:"transform",value:"translate3d(0,{{val}}px,0)",initial:"-30",mid:"0",final:"0"}]\'> <img src="http://dummyimage.com/200x200/000/fff"/> <div class="team-member--title"> Martin James </div> <div class="team-member--subtitle"> Communcation </div> </div> </div>');
}