(function() {
    tinymce.create('tinymce.plugins.dzsscroller', {
 
        init : function(ed, url){
            //console.log(url)
            //console.log('ceva');
			
            ed.addButton('dzsscroller', {
                title : 'Insert opacity effect',
                onclick : function() {
                    //console.log(tinyMCE.activeEditor.selection.getBookmark());
                    window.tinymce_cursor = tinyMCE.activeEditor.selection.getBookmark();
                    window.tinymce_tempcontent = (ed.selection.getContent());
                    tb_show('DZS Scroller', url + '/popup.php?width=630&height=800');
                },
                image: url + "/img/icon.png"
            });
        }
    });
 
    tinymce.PluginManager.add('dzsscroller', tinymce.plugins.dzsscroller);
    
})();
function removeClasses(arg){
    arg = jQuery(arg).removeClass('effectopacity effectmove effectzoom effectoverlay');
    arg.attr('alt', '');
    return arg;
}
/*
 * 
			aux=ed.selection.getContent();
			aux=removeClasses(aux);
			aux=jQuery(aux).addClass('effectopacity');			
			aux2 = jQuery('<div>').append(aux.clone()).remove().html();
			aux2=aux2.replace('alt=""', 'alt="0.5;1"');	
                 ed.execCommand('mceReplaceContent',false,aux2);
 */