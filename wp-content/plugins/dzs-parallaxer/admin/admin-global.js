function b64EncodeUnicode(str) {
    // first we use encodeURIComponent to get percent-encoded UTF-8,
    // then we convert the percent encodings into raw bytes which
    // can be fed into btoa.
    return btoa(encodeURIComponent(str).replace(/%([0-9A-F]{2})/g,
        function toSolidBytes(match, p1) {
            return String.fromCharCode('0x' + p1);
        }));
}

b64EncodeUnicode('✓ à la mode'); // "4pyTIMOgIGxhIG1vZGU="
b64EncodeUnicode('\n'); // "Cg=="


function b64DecodeUnicode(str) {
    // Going backwards: from bytestream, to percent-encoding, to original string.
    return decodeURIComponent(atob(str).split('').map(function(c) {
        return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
    }).join(''));
}

console.info(b64DecodeUnicode('4pyTIMOgIGxhIG1vZGU=')); // "✓ à la mode"
b64DecodeUnicode('Cg=='); // "\n"



function get_query_arg(purl, key){
    if(purl.indexOf(key+'=')>-1){
        //faconsole.log('testtt');
        var regexS = "[?&]"+key + "(.+?)(?=&|$)";
        var regex = new RegExp(regexS);
        var regtest = regex.exec(purl);


        //console.info(regex, regtest);
        if(regtest != null){
            //var splitterS = regtest;


            if(regtest[1]){
                var aux = regtest[1].replace( /=/g, '');
                return aux;
            }else{
                return '';
            }


        }
        //$('.zoombox').eq
    }
}


function add_query_arg(purl, key,value){
    key = encodeURIComponent(key); value = encodeURIComponent(value);

    //if(window.console) { console.info(key, value); };

    var s = purl;
    var pair = key+"="+value;

    var r = new RegExp("(&|\\?)"+key+"=[^\&]*");


    //console.info(pair);

    s = s.replace(r,"$1"+pair);
    //console.log(s, pair);
    var addition = '';
    if(s.indexOf(key + '=')>-1){


    }else{
        if(s.indexOf('?')>-1){
            addition = '&'+pair;
        }else{
            addition='?'+pair;
        }
        s+=addition;
    }

    //if value NaN we remove this field from the url
    if(value=='NaN'){
        var regex_attr = new RegExp('[\?|\&]'+key+'='+value);
        s=s.replace(regex_attr, '');
    }


    //if(!RegExp.$1) {s += (s.length>0 ? '&' : '?') + kvp;};

    return s;
}


jQuery(document).ready(function($){




    var aux =window.location.href;

    setTimeout(function(){

        // console.info(get_query_arg(aux, 'dzsprx_purchase_remove_binded'))
        if(get_query_arg(aux, 'dzsprx_purchase_remove_binded')=='on'){

            window.location.href = add_query_arg(aux, 'dzsprx_purchase_remove_binded', '');
        }
    },500)

    if(aux.indexOf('plugins.php')>-1){



        setTimeout(function(){
            jQuery.get( "http://zoomthe.me/cronjobs/cache/dzsprx_get_version.static.html", function( data ) {

//            console.info(data);
                var newvrs = Number(data);
                if(newvrs > Number(dzsprx_settings.version)){
                    jQuery('.version-number').append('<span class="new-version info-con" style="width: auto;"> <span class="new-version-text">/ new version '+data+'</span><div class="sidenote">Download the new version by going to your CodeCanyon accound and accessing the Downloads tab.</div></div> </span>')

                    if($('#the-list > #dzs-parallaxer').next().hasClass('plugin-update-tr')==false){
                        $('#the-list > #dzs-parallaxer').addClass('update');
                        $('#the-list > #dzs-parallaxer').after('<tr class="plugin-update-tr"><td colspan="3" class="plugin-update colspanchange"><div class="update-message">There is a new version of DZS Parallaxer available. <form action="admin.php?page=dzsprx-autoupdater" class="mainsettings" method="post"> &nbsp; <br> <button class="button-primary" name="action" value="dzsprx_update_request">Update</button></form></td></tr>');
                    }
                }
            });
        }, 300);
    }



    $(document).on('change', '.wrap-for-dzsprx-shortcode-builder *[name="mode"], .vc_col-xs-12 *[data-property_repeater_name]', handle_change);
    $(document).on('change.dzsdepe', '.dzs-dependency-field',handle_change);
    $(document).on( 'click', '.vc_col-xs-12 .setting-for-transition .selector-btn-secondary > .tooltip-indicator',handle_mouse);


    function handle_mouse(e) {
        var _t = $(this);
        var _con = null;

        if (e.type == 'click') {
            if (_t.hasClass('tooltip-indicator')) {
                _t.parent().toggleClass('property-active');

                repeater_custom_transition_generate();
            }
        }
    }

    function handle_change(e){

        var _t = $(this);
        var _con = null;



        if(e.type=='change'){
            // console.info(_t);



            if(_t.attr('data-property_repeater_name')){

                // console.info('ceva');
                repeater_custom_transition_generate();
            }

            if(_t.hasClass('dzs-dependency-field')){
                // console.info("ceva");
                check_dependency_settings();
            }

            if(_t.attr('name')=='mode'){


                if(_t.parent().parent().parent().parent().parent().hasClass('wrap-for-dzsprx-shortcode-builder')){
                    _con = _t.parent().parent().parent().parent().parent();
                }

                // console.info(_con);

                _con.removeClass('mode-normal mode-fromtop mode-simple mode-oneelement');

                _con.addClass('mode-'+_t.val());
            }


            
        }
    }


    function check_dependency_settings(pargs){




        var margs = {
            target_attribute: 'name'
        }

        if(pargs){
            margs = jQuery.extend(margs,pargs);
        }

        $('*[data-dependency]').each(function(){
            var _t = $(this);


            // console.info(_t);
            var dep_arr = {};


            var aux_depedency = _t.attr('data-dependency');


            // return false;

            // console.warn('aux_depedency - ',aux_depedency);

            if(aux_depedency.indexOf('"')==0){
                aux_depedency = aux_depedency.substr(1, aux_depedency.length);
                aux_depedency = aux_depedency.substr(0, aux_depedency.length-1);
            }

            // console.warn('aux_depedency - ',aux_depedency);
            aux_depedency = aux_depedency.replace(/{quotquot}/g, '"');

            // console.warn('aux_depedency - ',aux_depedency);
            try{
                dep_arr = JSON.parse(aux_depedency);

                //console.warn(_t, dep_arr);

                if(dep_arr[0]){


                    //console.info(dep_arr[0]);

                    var _c = null;



                    var target_attribute = margs.target_attribute;

                    var target_con = $(document);


                    if(_t.hasClass('check-label')){
                        target_attribute = 'data-label';
                    }

                    if(_t.attr('data-custom-label-to-check-for-dependency')){
                        target_attribute = _t.attr('data-custom-label-to-check-for-dependency');
                    }
                    if(_t.hasClass('check-parent1')){
                        target_con = _t.parent();
                    }
                    if(_t.hasClass('check-parent2')){
                        target_con = _t.parent().parent();
                    }
                    if(_t.hasClass('check-parent3')){
                        target_con = _t.parent().parent().parent();
                    }






                    // console.warn('target_con - ',target_con);
                    // console.warn('target_attribute - ',target_attribute);


                    if(dep_arr[0].lab){
                        _c = target_con.find('*['+target_attribute+'="'+dep_arr[0].lab+'"]:not(.fake-input)').eq(0);
                    }
                    if(dep_arr[0].label){
                        _c = target_con.find('*['+target_attribute+'="'+dep_arr[0].label+'"]:not(.fake-input)').eq(0);
                    }
                    if(dep_arr[0].element){
                        _c = target_con.find('*['+target_attribute+'="'+dep_arr[0].element+'"]:not(.fake-input)').eq(0);
                    }

                    if(_t.hasClass('check-parent3')){
                        // console.info('_t - ',_t);
                        // console.info('target_con - ',target_con);
                        // console.info('_c - ',_c);
                    }

                    // console.info(_c, dep_arr[0].val);


                    var cval = _c.val();


                    if(_c.attr('type')=='checkbox'){
                        if(_c.prop('checked')){

                        }else{
                            cval = '';
                        }
                    }

                    var sw_show = false;

                    if(dep_arr[0].val) {
                        for (var i3 in dep_arr[0].val) {

                            //console.info(_c, cval, dep_arr[0].val[i3]);
                            if (cval == dep_arr[0].val[i3]) {
                                sw_show = true;
                                break;

                            }
                        }
                    }

                    if(dep_arr.relation){



                        // console.error(dep_arr.relation);

                        for(var i in dep_arr){
                            if(i=='relation'){
                                continue;
                            }


                            if(dep_arr[i].value){
                                if(dep_arr.relation=='AND'){
                                    sw_show=false;
                                }



                                if(dep_arr[0].element){
                                    _c = target_con.find('*['+target_attribute+'="'+dep_arr[i].element+'"]:not(.fake-input)').eq(0);
                                }


                                for(var i3 in dep_arr[i].value) {


                                    // console.info('_c.val() -  ',_c.val(), dep_arr[i].value[i3]);
                                    if (_c.val() == dep_arr[i].value[i3]) {


                                        if(_c.attr('type')=='checkbox'){
                                            if(_c.val() == dep_arr[i].value[i3] && _c.prop('checked')){

                                                sw_show = true;
                                            }
                                        }else{

                                            sw_show = true;
                                        }

                                        break;

                                    }


                                    if(dep_arr[i].value[i3]=='anything_but_blank' && cval){

                                        sw_show=true;
                                        break;
                                    }
                                }

                                // console.info('sw_show - ',sw_show);
                            }

                        }

                    }else{

                        if(dep_arr[0].value){

                            for(var i3 in dep_arr[0].value) {
                                if (_c.val() == dep_arr[0].value[i3]) {


                                    if(_c.attr('type')=='checkbox'){
                                        if(_c.val() == dep_arr[0].value[i3] && _c.prop('checked')){

                                            sw_show = true;
                                        }
                                    }else{

                                        sw_show = true;
                                    }

                                    break;

                                }


                                if(dep_arr[0].value[i3]=='anything_but_blank' && cval){

                                    sw_show=true;
                                    break;
                                }
                            }
                        }
                    }


                    if(sw_show){
                        _t.show();
                    }else{
                        _t.hide();
                    }


                }


            }catch(err){
                console.info('cannot parse depedency json', "'",aux_depedency, "'", err, _t);
            }
        })


















        /*


        $('*[data-dependency]').each(function(){
            var _t = $(this);

            var margs = {
                target_attribute: 'name'
            }


            // console.info(_t, _t.attr('data-dependency'));

            var str_dependency = _t.attr('data-dependency');
            str_dependency = str_dependency.replace(/{{quot}}/g, '"');
            var dep_arr = [];


            try{
                dep_arr = JSON.parse(str_dependency);

                var target_attribute = margs.target_attribute;

                var target_con = $(document);

                //console.warn(dep_arr);

                if(dep_arr[0]){
                    var _c = null;


                    if(dep_arr[0].lab){
                        _c = $('*[name="'+dep_arr[0].lab+'"]:not(.fake-input)').eq(0);
                    }
                    if(dep_arr[0].label){
                        _c = $('*[name="'+dep_arr[0].label+'"]:not(.fake-input)').eq(0);
                    }
                    if(dep_arr[0].element){
                        _c = $('*[name="'+dep_arr[0].element+'"]:not(.fake-input)').eq(0);
                    }



                    if(_t.hasClass('big-preview')){

                        // console.info('_c - ',_c, dep_arr[0].label, dep_arr,str_dependency);
                    }


                    if(_c){

                        var cval = _c.val();

                        // console.info(_c, dep_arr[0].val);

                        var sw_show = false;


                        if(dep_arr[0].val){

                            for(var i3 in dep_arr[0].val) {
                                if (_c.val() == dep_arr[0].val[i3]) {
                                    sw_show = true;
                                    break;

                                }
                            }
                        }


                        if(dep_arr.relation){



                            // console.error(dep_arr.relation);

                            for(var i in dep_arr){
                                if(i=='relation'){
                                    continue;
                                }


                                if(dep_arr[i].value){
                                    if(dep_arr.relation=='AND'){
                                        sw_show=false;
                                    }



                                    if(dep_arr[0].element){
                                        _c = target_con.find('*['+target_attribute+'="'+dep_arr[i].element+'"]:not(.fake-input)').eq(0);
                                    }


                                    for(var i3 in dep_arr[i].value) {


                                        // console.info('_c.val() -  ',_c.val(), dep_arr[i].value[i3]);
                                        if (_c.val() == dep_arr[i].value[i3]) {


                                            if(_c.attr('type')=='checkbox'){
                                                if(_c.val() == dep_arr[i].value[i3] && _c.prop('checked')){

                                                    sw_show = true;
                                                }
                                            }else{

                                                sw_show = true;
                                            }

                                            break;

                                        }


                                        if(dep_arr[i].value[i3]=='anything_but_blank' && cval){

                                            sw_show=true;
                                            break;
                                        }
                                    }

                                    if(dep_arr.relation=='AND'){
                                        if(sw_show==false){
                                            break;
                                        }
                                    }
                                    // console.info('sw_show - ',sw_show);
                                }

                            }

                        }else{

                            if(dep_arr[0].value){

                                for(var i3 in dep_arr[0].value) {
                                    if (_c.val() == dep_arr[0].value[i3]) {


                                        if(_c.attr('type')=='checkbox'){
                                            if(_c.val() == dep_arr[0].value[i3] && _c.prop('checked')){

                                                sw_show = true;
                                            }
                                        }else{

                                            sw_show = true;
                                        }

                                        break;

                                    }


                                    if(dep_arr[0].value[i3]=='anything_but_blank' && cval){

                                        sw_show=true;
                                        break;
                                    }
                                }
                            }
                        }



                        if(_t.hasClass('big-preview')){

                            // console.info('sw_show - ',sw_show, _c);
                        }



                        if(sw_show){
                            _t.show();
                        }else{
                            _t.hide();
                        }
                    }


                }
            }catch(err){
                console.error('json dependency error - ',str_dependency);
                console.error(err);
            }

        })
            */
    }



    $(document).delegate('.dzsprx-btn-add-media', 'click', function(){
        var _t = $(this);

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
    })
    $(document).delegate('.dzsprx-preview-changer', 'change', function(){
        var _t = $(this);

        _t.parent().parent().find('.preview-media-con-left').eq(0).addClass('hasimage').css('background-image', 'url('+_t.val()+')')
        return false;
    })



    window.upload_from_mg_to_input = upload_from_mg_to_input;




    $(document).undelegate(".upload_file", "click", window.upload_from_mg_to_input);
    $(document).delegate(".upload_file", "click", window.upload_from_mg_to_input);

    function upload_from_mg_to_input(){
        var _t = $(this);
        var targetInput = _t.prev();

        var searched_type = '';

        if(targetInput.hasClass('upload-type-audio')){
            searched_type = 'audio';
        }
        if(targetInput.hasClass('upload-type-image')){
            searched_type = 'image';
        }



        if(typeof wp!='undefined' && typeof wp.media!='undefined'){
            uploader_frame = wp.media.frames.dzsprx_addmedia = wp.media({
                // Set the title of the modal.
                title: "Insert Media Modal",
                multiple:true,
                // Tell the modal to show only images.
                library: {
                    type: searched_type
                },

                // Customize the submit button.
                button: {
                    // Set the text of the button.
                    text: "Insert Media",
                    // Tell the button not to close the modal, since we're
                    // going to refresh the page when the image is selected.
                    close: false
                }
            });

            // When an image is selected, run a callback.
            uploader_frame.on( 'select', function() {
                //console.info(uploader_frame.state().get('selection'), uploader_frame.state().get('selection').length, uploader_frame.state().get('selection')._source);
                var attachment = uploader_frame.state().get('selection').first();

                //console.log(attachment.attributes, $('*[name*="video-player-config"]'));
                /*
                 var arg = '[zoomsounds source="'+attachment.attributes.url+'" config="'+jQuery('*[name*="audio-player-config"]').val()+'"]';

                 if(typeof(top.dzsap_receiver)=='function'){
                 top.dzsap_receiver(arg);
                 }
                 */

                if(targetInput.hasClass('upload-prop-id')){
                    targetInput.val(attachment.attributes.id);
                }else{
                    targetInput.val(attachment.attributes.url);

                }


                targetInput.trigger('change');
                uploader_frame.close();
            });

            // Finally, open the modal.
            uploader_frame.open();
        }else{
            tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true&amp;post_id=1&amp;width=640&amp;height=105');
            var backup_send_to_editor      = window.send_to_editor;
            var intval      = window.setInterval(function() {
                if ( jQuery('#TB_iframeContent').attr('src')!=undefined && jQuery('#TB_iframeContent').attr('src').indexOf( "&field_id=" ) !== -1 ) {
                    jQuery('#TB_iframeContent').contents().find('#tab-type_url').hide();
                }
                jQuery('#TB_iframeContent').contents().find('.savesend .button').val("Upload to Video Gallery");
            }, 50);
            window.send_to_editor = function (arg) {
                var fullpath = arg
                    ,fullpathArray = fullpath.split('>');
                //fullpath = fullpathArray[1] + '>';


                var aux3 = jQuery(fullpath).attr('href');


                targetInput.val(aux3);
                targetInput.trigger('change');
                tb_remove();
                window.clearInterval(intval);
                window.send_to_editor = backup_send_to_editor;
            };
        }





        return false;
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

});