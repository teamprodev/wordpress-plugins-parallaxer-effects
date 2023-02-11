<?php

$feed_mode_opts = array(

	array(
		'label'=>esc_html__('scroll background','dzsprx'),
		'value'=>'normal',
	),

	array(
		'label'=>esc_html__('from top','dzsprx'),
		'value'=>'fromtop',
	),
	array(
		'label'=>esc_html__('scroll full background','dzsprx'),
		'value'=>'simple',
	),
	array(
		'label'=>esc_html__('scroll element','dzsprx'),
		'value'=>'oneelement',
	),
	array(
		'label'=>esc_html__('horizontal loop','dzsprx'),
		'value'=>'horizontal',
	),


//    'normal' => 'normal',
//    'fromtop' => 'fromtop',
//    'simple' => 'simple',
//    'oneelement' => esc_html__('scroll inside','dzsprx'),
);
$feed_direction_opts = array(
    "normal" => "normal",
    "reverse" => "reverse",
);
$feed_scrollbar_opts = array(
    'off' => 'off',
    'on' => 'on',
);
$feed_breakout_opts = array(
    'off' => 'off',
    'trybreakout' => 'trybreakout',
);


if(function_exists('vc_map')){
    vc_map(array(
        "name" => __("Parallaxer"),
        "base" => "dzs_parallaxer",
        "class" => "",
        "icon" => $this->the_url.'assets/icons/vc_icon.png',

        "show_settings_on_create" => false,
        "content_element" => true,
        "as_parent" => array('only' => 'dzs_parallaxer_layer,vc_row'),
        "is_container" => true,
        "js_view" => 'VcColumnView',
        "admin_enqueue_js" => $this->base_url.'vc/backbone.js',
        "front_enqueue_js" => $this->the_url.'vc/frontend_backbone.js',
        "category" => __('Content'),
        "params" => array(


	        array(
		        'type' => 'dropdown',
		        'heading' => __('Background Type'),
		        "admin_label" => true,
		        'param_name' => 'parallax_content_type',
		        'value' => array(
			        array(
				        'label'=>esc_html__("Image",'dzsprx'),
				        'value'=>'image',
			        ),
			        array(
				        'label'=>esc_html__("Video",'dzsprx'),
				        'value'=>'video',
			        ),
			        array(
				        'label'=>esc_html__("Google Maps",'dzsprx'),
				        'value'=>'gmaps',
			        ),


		        ),
		        'description' => esc_html__('select the parallaxer mode','dzsprx'),
	        ),


            array(
                "type" => "dzs_add_media",
//                "holder" => "div",
                "class" => "",
                "heading" => __("Background image"),
                "param_name" => "media",
                "value" => __(""),
                "description" => __('This is the image that will go on background you are going to use.'),


                "dependency" => array(
	                "element" => "parallax_content_type",
	                "value" => array("image"),
                ),
            ),


            array(
                "type" => "dzs_add_media",
//                "holder" => "div",
                "class" => "",
                "heading" => __("Video",'dzsprx'),
                "param_name" => "video_media",
                "value" => __(""),
                "description" => __('input self hosted video path, or youtube link or vimeo link','dzsprx'),


                "dependency" => array(
	                "element" => "parallax_content_type",
	                "value" => array("video"),
                ),
            ),
	        array(
		        "type" => "textfield",
		        //                "holder" => "div",
		        "class" => "",
//		        "admin_label" => true,
		        "heading" => __("Latitude"),
		        "param_name" => "lat",
		        "value" => '10',
		        "description" => esc_html__('latitute'),

		        "dependency" => array(
			        "element" => "parallax_content_type",
			        "value" => array("gmaps"),
		        ),
	        ),
	        array(
		        "type" => "textfield",
		        //                "holder" => "div",
		        "class" => "",
		        "heading" => __("Longitude"),
		        "param_name" => "long",
		        "value" => '10',
		        "description" => esc_html__('Longitude'),

		        "dependency" => array(
			        "element" => "parallax_content_type",
			        "value" => array("gmaps"),
		        ),
	        ),
            array(
                "type" => "textfield",
//                "holder" => "div",
                "class" => "",
                "admin_label" => true,
                "heading" => __("Clip Height"),
                "param_name" => "clip_height",
                "value" => '400',
                "description" => __('insert this size in pixels or in percent ( 100% )')
            ),
            array(
                "type" => "textfield",
//                "holder" => "div",
                "class" => "",
                "heading" => __("Total Height"),
                "param_name" => "total_height",
                "value" => '150%',
                "description" => __('this is the total height of the container, it should be bigger then the clip height in order to make space for the parallax effect')
            ),





	        array(
		        "type" => "textfield",
		        //                "holder" => "div",
		        "class" => "",
		        "admin_label" => true,
		        "heading" => __("Scroll element - max offset"),
		        "param_name" => "settings_mode_oneelement_max_offset",
		        "value" => '100',
		        "description" => __('the max offset in which to scroll this element')
	        ),



            array(
                'type' => 'dropdown',
                'heading' => __('Mode'),
                'param_name' => 'settings_mode',
                'value' => $feed_mode_opts,
                'description' => __('select the parallaxer mode')
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Enable Easing Scrollbar'),
                'param_name' => 'enable_scrollbar',
                'value' => $feed_scrollbar_opts,
                'description' => __('enable dzs scroller to ease the scrolling on this page')
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Break out of container'),
                'param_name' => 'breakout',
                'value' => $feed_breakout_opts,
                'description' => __("Javascript Breakout")
            ),
            array(
                'type' => 'dropdown',
                'heading' => __('Direction'),
                'param_name' => 'direction',
                'value' => $feed_direction_opts,
                'description' => __('select the direction of scroll')
            ),
            array(
                "type" => "textarea_html",
//                "holder" => "div",
                "class" => "",
                "heading" => __("Text"),
                "param_name" => "content",
                "value" => __("<p>I am test text block. Click edit button to change this text.</p>"),
                "description" => __("Enter your text for skins that receive a text parameter.")
            )
        )
    ));
    vc_map(array(
        "name" => __("Parallaxer Row Start"),
        "base" => "dzs_parallaxer_row_start",
        "class" => "",
        "icon" => $this->the_url.'assets/icons/vc_icon_row_start.png',
        "front_enqueue_js" => $this->the_url.'vc/frontend_backbone.js',
        "category" => __('Content'),
        "params" => array(




	        array(
		        'type' => 'dropdown',
		        'heading' => __('Background Type'),
		        'param_name' => 'parallax_content_type',
		        'value' => array(
			        array(
				        'label'=>esc_html__("Image",'dzsprx'),
				        'value'=>'image',
			        ),
			        array(
				        'label'=>esc_html__("Video",'dzsprx'),
				        'value'=>'video',
			        ),
			        array(
				        'label'=>esc_html__("Google Maps",'dzsprx'),
				        'value'=>'gmaps',
			        ),


		        ),
		        'description' => esc_html__('select the parallaxer mode','dzsprx'),
	        ),



	        array(
		        "type" => "dzs_add_media",
		        //                "holder" => "div",
		        "class" => "",
		        "heading" => __("Background image"),
		        "param_name" => "media",
		        "value" => __(""),
		        "description" => __('This is the image that will go on background you are going to use.'),


		        "dependency" => array(
			        "element" => "parallax_content_type",
			        "value" => array("image"),
		        ),
	        ),


	        array(
		        "type" => "dzs_add_media",
		        //                "holder" => "div",
		        "class" => "",
		        "heading" => __("Video",'dzsprx'),
		        "param_name" => "video_media",
		        "value" => __(""),
		        "description" => __('input self hosted video path, or youtube link or vimeo link','dzsprx'),

		        "dependency" => array(
			        "element" => "parallax_content_type",
			        "value" => array("video"),
		        ),
	        ),




	        array(
		        "type" => "textfield",
		        //                "holder" => "div",
		        "class" => "",
		        "admin_label" => true,
		        "heading" => __("Latitude"),
		        "param_name" => "lat",
		        "value" => '10',
		        "description" => esc_html__('latitute'),
		        "dependency" => array(
			        "element" => "parallax_content_type",
			        "value" => array("gmaps"),
		        ),
	        ),
	        array(
		        "type" => "textfield",
		        //                "holder" => "div",
		        "class" => "",
		        "admin_label" => true,
		        "heading" => __("Longitude"),
		        "param_name" => "long",
		        "value" => '10',
		        "description" => esc_html__('Longitude'),
		        "dependency" => array(
			        "element" => "parallax_content_type",
			        "value" => array("gmaps"),
		        ),
	        ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Total Height"),
                "param_name" => "total_height",
                "value" =>'130%',
                "description" => __('this is the total height of the container, it should be bigger then the clip height in order to make space for the parallax effect'),
            ),
            array(
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => __("Extra Classes"),
                "param_name" => "extra_classes",
                "value" => __(""),
                "description" => 'padding0 - '.__(' - nopadding').'<br>'.'padding30 - '.__(' - 30px padding').'<br>',
                "dependency" => array(
	                "element" => "parallax_content_type",
	                "value" => array("image"),
                ),
            ),
        )
    ));
    vc_map(array(
        "name" => __("Parallaxer Row End"),
        "base" => "dzs_parallaxer_row_end",
        "class" => "",
        "icon" => $this->the_url.'assets/icons/vc_icon_row_end.png',
        "front_enqueue_js" => $this->the_url.'vc/frontend_backbone.js',
        "category" => __('Content'),
        "params" => array(

        )
    ));



	vc_map(array(
		"name" => __("Parallaxer Layer"),
		"base" => "dzs_parallaxer_layer",
		"js_view" => 'ParallaxerLayer',
		'allowed_container_element' => 'dzs_parallaxer',
		'content_element' => true,
		"class" => "",


		"category" => __('Content'),
		"params" => array(





			array(
				'type' => 'dropdown',
				'heading' => __('Layer type'),
				'param_name' => 'media_type',
				'value' => array(
					array(
						'label'=>esc_html__("Image",'dzsprx'),
						'value'=>'image',
					),
					array(
						'label'=>esc_html__("HTML",'dzsprx'),
						'value'=>'html',
					),


				),
				'description' => esc_html__('select the layer mode','dzsprx'),
			),




			array(
				'type' => 'dropdown',
				'admin_label'=>true,
//				"holder" => "div",
				'heading' => __('Layer position'),
				'param_name' => 'position',
				'value' => array(
					array(
						'label'=>esc_html__("Top left",'dzsprx'),
						'value'=>'top left',
					),
					array(
						'label'=>esc_html__("Top center",'dzsprx'),
						'value'=>'top center',
					),
					array(
						'label'=>esc_html__("Top right",'dzsprx'),
						'value'=>'top right',
					),
					array(
						'label'=>esc_html__("Center left",'dzsprx'),
						'value'=>'center left',
					),
					array(
						'label'=>esc_html__("Center center",'dzsprx'),
						'value'=>'center center',
					),
					array(
						'label'=>esc_html__("Center right",'dzsprx'),
						'value'=>'center right',
					),
					array(
						'label'=>esc_html__("Bottom left",'dzsprx'),
						'value'=>'bottom left',
					),
					array(
						'label'=>esc_html__("Bottom center",'dzsprx'),
						'value'=>'bottom center',
					),
					array(
						'label'=>esc_html__("Bottom right",'dzsprx'),
						'value'=>'bottom right',
					),


				),
				'description' => esc_html__('select the parallaxer mode','dzsprx'),
			),


			array(
				"type" => "dzs_add_media",
				"holder" => "div",
				"class" => "",
				"heading" => __("Image"),
				"param_name" => "media",
				"value" => __(""),
				"description" => __('This is the media you are going to use.'),

				"dependency" => array(
					"element" => "media_type",
					"value" => array("image"),
				),

			),
			array(
				"type" => "textarea_html",
				//                "holder" => "div",
				"class" => "",
				"heading" => __("Text"),
				"param_name" => "content",
				"description" => __("entering text here will remove image"),

				"dependency" => array(
					"element" => "media_type",
					"value" => array("html"),
				),
			),
			array(
				"type" => "textfield",
				"holder" => "div",
				"class" => "",
				"heading" => __("Extra Classes"),
				"param_name" => "extra_classes",
				"value" => '',
				"description" => ''
			),
			array(
				"type" => "dzs_transition_custom",
				"class" => "",
				"heading" => __("Transition custom"),
				"param_name" => "layer_transition_custom",
				"value" => '',
				"description" => ''
			),

		)
	));
}




if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_Dzs_Parallaxer extends WPBakeryShortCodesContainer {
	}
}
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Dzs_Parallaxer_Layer extends WPBakeryShortCode {
	}
}