window.InlineShortcodeView_dzs_parallaxer = window.InlineShortcodeView.extend({
    render: function() {
        window.InlineShortcodeView_dzs_parallaxer.__super__.render.call(this);

        var _tel = this.$el;
        console.info(jQuery('.dzsparallaxer'), _tel);

        _tel.find('.dzsparallaxer').each(function(){
            var _t = jQuery(this);
//            console.info(_t);

            if(_t.hasClass('inited')){

            }else{
                if(window.dzsprx_init){
                    window.dzsprx_init(_t, {init_each:true})
                }else{
                    console.warning("parallaxer not defined");
                }

            }



        })
        // setTimeout(function(){
        //     jQuery(window).trigger('resize');
        // },50);
        return this;
    }
});