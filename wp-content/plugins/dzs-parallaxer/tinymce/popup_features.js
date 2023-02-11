jQuery(document).ready(function($) {
    var coll_buffer = 0;
    var fout = '';

    var dzsprx_sel = '';


    if(window.dzsprx_sel){
        dzsprx_sel = window.dzsprx_sel;
    }

    var its_arr = []
        ,descs_arr = []
        ,its_desc_arr = []
    ;

    var _shortcodeItemsCon = $('.shortcode-items-con').eq(0);

    //if(parent.mceeditor_sel){
    //
    //    dzsprx_sel = parent.mceeditor_sel;
    //
    //}
    //if(parent.htmleditor_sel){
    //
    //    dzsprx_sel = parent.htmleditor_sel;
    //
    //}
    console.log(dzsprx_sel,window.htmleditor_sel,window.mceeditor_sel);

    if(dzsprx_sel){



        var regex_1 = /breakout="(.*?)"/g;

        var aux_a = regex_1.exec(dzsprx_sel);

        if(aux_a && aux_a[1]){
            //console.log(aux_a,$('input[name="media"]'));
            $('select[name="breakout"]').val(aux_a[1]);
        }

        //
        //var regex_2 = /hover="(.*?)"/g;
        //
        //aux_a = regex_2.exec(dzsprx_sel);
        //
        //if(aux_a && aux_a[1]){
        //    $('select[name="the_hover"]').val(aux_a[1]);
        //}
        //
        //
        //
        //var regex_cont = /\[dzs_parallaxer.*?\]([\s|\S]*.?)\[\/dzs_parallaxer]/g;
        //
        //aux_a = regex_cont.exec(dzsprx_sel);
        //
        //if(aux_a && aux_a[1]){
        //    $('textarea[name="content"]').val(aux_a[1]);
        //}
        //
        var regex_items = /\[dzsprx_feature_img\]([\s|\S]*?)\[\/dzsprx_feature_img\]/g;


        var i23 = 0;
        while(aux_a = regex_items.exec(dzsprx_sel)){
            //console.info(aux_a);


            if(aux_a[1]){

                its_arr[i23] = aux_a[1];
            }



            i23++;
        }


        regex_items = /\[dzsprx_feature_html\]([\s|\S]*?)\[\/dzsprx_feature_html\]/g;
        i23 = 0;
        while(aux_a = regex_items.exec(dzsprx_sel)){

            if(aux_a[1]){

                descs_arr[i23] = aux_a[1];
            }


            i23++;
        }

        console.log(its_arr, descs_arr);

        for(i=0;i<its_arr.length;i++){



            var aux23 = '<div class="feature-item dzstoggle toggle1"><div class="toggle-title" style=""><span class="toggle-label">Item</span><i class="sortable-handler fa fa-bars"></i></div><div class="toggle-content"><h4>Media</h4><div class="setting setting-medium setting-three-floats"><div class="preview-media-con-left"></div><div class="change-media-con"><button class="button-secondary btn-add-media"><i class="fa fa-plus-square-o"></i> Add Media</button></div><div class="setting-input type-input overflow-it"><input class="setting-field dzsprx-preview-changer feature-item--media" type="text" name="" value="'+its_arr[i]+'"/></div><div class="clear"></div></div><h4>Text</h4><textarea class="feature-item--textarea">'+descs_arr[i]+'</textarea><div class="delete-btn">delete <i class="fa fa-times-circle"></i></div></div></div>';
            $('.feature-items-con .items-con').append(aux23);
        }


        //
        setTimeout(function(){
            $('input').trigger('change');
        },300)

    }
    //console.log($('.layouts-selecter .dzsprxouter'));

    jQuery('.items-con').sortable({
        placeholder: "ui-state-highlight"
        ,handle: ".sortable-handler"
        //,update: item_onsorted
    })

    $(document).delegate('.btn-add-media','click', handle_mouse);
    $(document).delegate('.toggle-content > .delete-btn','click', handle_mouse);
    $('.btn-add-item').bind('click', handle_mouse);
    $('.btn-insert-shortcode').bind('click', handle_mouse);
    //$('*[name=enable_custom_content]').bind('change', handle_change);
    //
    //
    //$('*[name=enable_custom_content]').trigger('change');


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

    function handle_mouse(e){
        var _t = $(this);
        var _con = null;

        if(e.type=='click'){
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
            if(_t.hasClass('btn-add-item')){


                $('.feature-items-con .items-con').eq(0).append('<div class="feature-item dzstoggle toggle1"><div class="toggle-title" style=""><span class="toggle-label">Item</span><i class="sortable-handler fa fa-bars"></i></div><div class="toggle-content"><h4>Media</h4><div class="setting setting-medium setting-three-floats"><div class="preview-media-con-left"></div><div class="change-media-con"><button class="button-secondary btn-add-media"><i class="fa fa-plus-square-o"></i> Add Media</button></div><div class="setting-input type-input overflow-it"><input class="setting-field dzsprx-preview-changer feature-item--media" type="text" name=""/></div><div class="clear"></div></div><h4>Text</h4><textarea class="feature-item--textarea"><h3>Demo Title</h3>\n<p>DZS Parallaxer is a script that turns any content into a cool parallax effect. It uses an algorithm to calculate visible and total height to calculate the scrollarea. It uses the latest CSS3 and Javascript tehniques to deliver a super smooth experience. </p></textarea><div class="delete-btn">delete <i class="fa fa-times-circle"></i></div></div><div class="clear"></div></div>');

                setTimeout(function(){

                    dzstoggle_initalltoggles();
                },10)

                return false;

            }
            if(_t.hasClass('btn-insert-shortcode')){


                prepare_fout();

                if(parent!=window && typeof(parent.dzsprx_receiver)=='function'){
                    parent.dzsprx_receiver(fout);
                }else{
                    console.info('ceva', parent!=window,$('.shortcode-output'), fout)
                    $('.shortcode-output').html(fout);
                }



                return false;
            }
            if(_t.hasClass('delete-btn')){


                _t.parent().parent().remove();

                return false;
            }
        }
    }


    function prepare_fout(){
        var _c,
            _c2
            ;


        fout='';
        fout+='[dzs_parallaxer_features';


        var lab = 'breakout';
        _c = $('*[name='+lab+']');
        if(_c.val() && _c.val()!=''){
            fout+=' '+lab+'="' + _c.val() + '"';
        }

        fout+=']';
        var _c,
            _c2
            ;


        $('.feature-items-con .feature-item').each(function(){
            var _t = $(this);

            fout+='[dzsprx_feature_img]';
            fout+= _t.find('.feature-item--media').val();
            fout+='[/dzsprx_feature_img] ';

        })


        $('.feature-items-con .feature-item').each(function(){
            var _t = $(this);

            fout+='[dzsprx_feature_html]';
            fout+= _t.find('.feature-item--textarea').val();
            fout+='[/dzsprx_feature_html] ';

        })

        fout+='[/dzs_parallaxer_features]';
    }


});
function reskin_select(){

    var iz = 0;
    for(iz=0;iz<jQuery('select').length;iz++){
        var $cache = jQuery('select').eq(iz);
        //console.log($cache.parent().attr('class'));
		
        if($cache.hasClass('styleme')==false || $cache.parent().hasClass('select_wrapper') || $cache.parent().hasClass('select-wrapper')){
            continue;
        }
        var sel = ($cache.find(':selected'));
        $cache.wrap('<div class="select-wrapper"></div>')
        $cache.parent().prepend('<span>' + sel.text() + '</span>')
    }
    jQuery('.select-wrapper select').unbind();
    jQuery(document).on('change','.select-wrapper select',change_select);	
        
    function change_select(){
        var selval = (jQuery(this).find(':selected').text());
        jQuery(this).parent().children('span').text(selval);
    }
}
window.insert_team_module= function(){
//console.info('ceva');

    jQuery('#content').val(jQuery('#content').val() + '<div class="dzs-colcontainer dzsparallaxer--team-members-con center-it"> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: center; width: 20%;" data-parallaxanimation=\'[{property:"opacity",value:"{{val}}",initial:"0",mid:"1",final:"0"},{property:"transform",value:"translate3d(0,{{val}}px,0)",initial:"-30",mid:"0",final:"0"}]\'> <img src="http://dummyimage.com/200x200/000/fff"/> <div class="team-member--title"> King Doe Joseph </div> <div class="team-member--subtitle"> General Manager </div> </div> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: center; width: 20%;" data-parallaxanimation=\'[{property:"opacity",value:"{{val}}",initial:"0",mid:"1",final:"1"},{property:"transform",value:"translate3d(0,{{val}}px,0)",initial:"30",mid:"0",final:"0"}]\'> <img src="http://dummyimage.com/200x200/000/fff"/> <div class="team-member--title"> Smith James </div> <div class="team-member--subtitle"> Tehnical Engineer </div> </div> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: center; width: 20%;" data-parallaxanimation=\'[{property:"opacity",value:"{{val}}",initial:"0",mid:"1",final:"0"},{property:"transform",value:"translate3d(0,{{val}}px,0)",initial:"-30",mid:"0",final:"0"}]\'> <img src="http://dummyimage.com/200x200/000/fff"/> <div class="team-member--title"> Sarah May </div> <div class="team-member--subtitle"> Finance </div> </div> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: center; width: 20%;" data-parallaxanimation=\'[{property:"opacity",value:"{{val}}",initial:"0",mid:"1",final:"1"},{property:"transform",value:"translate3d(0,{{val}}px,0)",initial:"30",mid:"0",final:"0"}]\'> <img src="http://dummyimage.com/200x200/000/fff"/> <div class="team-member--title"> Prett Scott </div> <div class="team-member--subtitle"> Communcation </div> </div> <div class="dzs-col-3 dzsparallaxer--team-member-con" style="text-align: center; width: 20%;" data-parallaxanimation=\'[{property:"opacity",value:"{{val}}",initial:"0",mid:"1",final:"0"},{property:"transform",value:"translate3d(0,{{val}}px,0)",initial:"-30",mid:"0",final:"0"}]\'> <img src="http://dummyimage.com/200x200/000/fff"/> <div class="team-member--title"> Martin James </div> <div class="team-member--subtitle"> Communcation </div> </div> </div>');
}