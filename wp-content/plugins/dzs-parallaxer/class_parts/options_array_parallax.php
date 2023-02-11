<?php

//print_r($this);

$arr_sliders2 = array();


//print_r($arr_sliders2);

$arr_separations = array(
    array(
        'label'=>__("none"),
        'value'=>"normal",
    ),
    array(
        'label'=>__("Pages"),
        'value'=>"pages",
    ),
    array(
        'label'=>__("Scroll"),
        'value'=>"scroll",
    ),
    array(
        'label'=>__("Button"),
        'value'=>"button",
    ),
);







$arr_modes = array(
    array(
        'label'=>__("Scroll"),
        'value'=>"scroll",
        'img'=>$this->base_url."tinymce/img/mode_scroll.png",
    ),
    array(
        'label'=>__("Horizontal Loop"),
        'value'=>"horizontal",
        'img'=>$this->base_url."tinymce/img/mode_horizontal.png",
    ),
    array(
        'label'=>__("Follow Mouse"),
        'value'=>"mouse_body",
        'img'=>$this->base_url."tinymce/img/mode_mousemove.png",
    ),
    array(
        'label'=>__("Single Mode"),
        'value'=>"onelement",
        'img'=>$this->base_url."tinymce/img/mode_scroll.png",
    ),
);

$arr_types = array(
    array(
        'label'=>__("Detect"),
        'value'=>"detect",
        'img'=>$this->base_url."tinymce/img/type_detect.png",
    ),
    array(
        'label'=>__("Image"),
        'value'=>"image",
        'img'=>$this->base_url."tinymce/img/type_image.png",
    ),
    array(
        'label'=>__("Map"),
        'value'=>"gmaps",
        'img'=>$this->base_url."tinymce/img/type_maps.png",
    ),
    array(
        'label'=>__("Custom Content"),
        'value'=>"html",
        'img'=>$this->base_url."tinymce/img/type_inline.png",
    ),
);

$this->options_array_parallax = array(


    'mode' => array(
        'type' => 'select',
        'title' => __("Mode"),
        'sidenote' => __("create galleries in video gallery admin"),

        'holder' => 'div',
        'context' => 'content',
        'options' => $arr_modes,
        'default' => 'default',
        'select_type' => 'with_graphics',
    ),

    'type' => array(
        'type' => 'select',
        'title' => __("Type"),
        'sidenote' => __("create galleries in video gallery admin"),

        'holder' => 'div',
        'context' => 'content',
        'options' => $arr_types,
        'default' => 'default',
        'select_type' => 'with_graphics',
    ),
);