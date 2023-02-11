



jQuery(document).ready(function($){





    function reskin_select(){
        $(document).undelegate(".select-wrapper select", "change");
        $(document).delegate(".select-wrapper select", "change",  change_select);

//        console.info($('select'));
        $('select.styleme').each(function(){

            var _cache = $(this);
//            console.log(_cache);

            if(_cache.parent().hasClass('select_wrapper') || _cache.parent().hasClass('select-wrapper')){
                return;
            }
            var sel = (_cache.find(':selected'));
//            console.info(sel, _cache.val());
            _cache.wrap('<div class="select-wrapper"></div>')
            _cache.parent().prepend('<span>' + sel.text() + '</span>');
            _cache.trigger('change');
        })


        function change_select(){
            var selval = ($(this).find(':selected').text());
            $(this).parent().children('span').text(selval);
        }

    }
});


