
/*

 */



console && console.log('admin_enqueue_js.js is loaded');
// Come from vc_map -> 'js_view' => 'ViewTestElement'
window.ParallaxerLayer = vc.shortcode_view.extend({
    // Render method called after element is added( cloned ), and on first initialisation
    render: function () {
        console && console.log('ParallaxerLayer: render method called.', this);
        window.ParallaxerLayer.__super__.render.call(this); //make sure to call __super__. To execute logic fron inherited view. That way you can extend original logic. Otherwise, you will fully rewrite what VC will do at this event

        return this;
    },
    ready: function (e) {
        // console && console.log('ParallaxerLayer: ready method called.');
        window.ParallaxerLayer.__super__.ready.call(this, e);

        return this;
    },
    //Called every time when params is changed/appended. Also on first initialisation
    changeShortcodeParams: function (model) {
        // console && console.log('ParallaxerLayer: changeShortcodeParams method called.');
        // console && console.log(model.getParam('value') + ': this was maped in vc_map() "param_name"  => "value"');
        window.ParallaxerLayer.__super__.changeShortcodeParams.call(this, model);


        setTimeout(function(){

            // console.info(jQuery('.iconselector .iconselector-waiter'))
            jQuery('.iconselector .iconselector-waiter').trigger('change');
        },1000);
    },
    changeShortcodeParent: function (model) {
        // console && console.log('ParallaxerLayer: changeShortcodeParent method called.');
        window.ParallaxerLayer.__super__.changeShortcodeParent.call(this, model);
    },
    deleteShortcode: function (e) {
        // console && console.log('ParallaxerLayer: deleteShortcode method called.');
        window.ParallaxerLayer.__super__.deleteShortcode.call(this, e);
    },
    editElement: function (e) {
        console && console.log('ParallaxerLayer: editElement method called.', this, e);
        window.ParallaxerLayer.__super__.editElement.call(this, e);

        // console.info(this);


        setTimeout(function(){

            // console.info(jQuery('.iconselector .iconselector-waiter'))
            jQuery('.iconselector .iconselector-waiter').trigger('change');


            var _t5 = jQuery('input.wpb_vc_param_value.dzs_transition_custom').eq(0);

            var _cach = _t5.parent();
            var val = _t5.val();

            console.info('_t5 - ',_t5);
            console.info('b64DecodeUnicode(val) - ',b64DecodeUnicode(val));
            var valar = JSON.parse(b64DecodeUnicode(val));

            console.info('valar - ',valar);


            for(var lab2 in valar){
                var val2 = valar[lab2];


                var _cache = _cach.find('div[data-property-name="'+lab2+'"]');


                console.info('_cach.find(\'div[data-property-name="\'+lab2+\'"]\') - ',_cach.find('div[data-property-name="'+lab2+'"]'));

                _cache.addClass('property-active');

                for(var lab3 in val2){
                    var val3 = val2[lab3];

                    _cache.find('*[data-property_repeater_name='+lab3+']').val(val3);


                }


            }
        },1000);
    },
    clone: function (e) {
        // console && console.log('ParallaxerLayer: clone method called.');
        window.ParallaxerLayer.__super__.clone.call(this, e);
    }
});
