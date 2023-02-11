var coll_buffer=0;
var func_output='';
var fout = '';
jQuery(document).ready(function($){
    reskin_select();
    $('.sc-insert').click(function(){
        fout = '';
        var _c= $(this).parent();
        
        fout = '[scroller';
        
        fout+=' w="'
        fout+=_c.find('input[name=sc-w]').val();
        fout+='"';
        
        fout+=' h="'
        fout+=_c.find('input[name=sc-h]').val();
        fout+='"';
        
        if(_c.find('input[name=sc-iw]').val()!=''){
            fout+=' iw="'
            fout+=_c.find('input[name=sc-iw]').val();
            fout+='"';
        }
        
        if(_c.find('input[name=sc-ih]').val()!=''){
            fout+=' ih="'
            fout+=_c.find('input[name=sc-ih]').val();
            fout+='"';
        }
        
        fout+=' settings_skin="'
        fout+=_c.find('select[name=sc-skin]').find(':selected').text();
        fout+='"';
        
        fout+=']';
        fout+=window.tinymce_tempcontent;
        fout+='[/scroller]';
        
        //console.log(fout);
        tinymce_add_content(fout);
        return false;
    })
       
});
function tinymce_add_content(arg){
    if(window.tinyMCE)
    {
        if(window.tinyMCE.activeEditor!=null){
            window.tinyMCE.activeEditor.selection.moveToBookmark(window.tinymce_cursor);
            window.tinyMCE.execInstanceCommand('content', 'mceInsertContent', false, arg);
        }else{
            var aux = jQuery("#content").val();
            jQuery("#content").val( aux + arg );
        }
        tb_remove();
    }
}


function reskin_select(){
	for(i=0;i<jQuery('select').length;i++){
		var $cache = jQuery('select').eq(i);
		//console.log($cache.parent().attr('class'));
		
		if($cache.hasClass('styleme')==false || $cache.parent().hasClass('select_wrapper') || $cache.parent().hasClass('select-wrapper')){
		continue;
		}
		var sel = ($cache.find(':selected'));
		$cache.wrap('<div class="select-wrapper"></div>')
		$cache.parent().prepend('<span>' + sel.text() + '</span>')
	}
}