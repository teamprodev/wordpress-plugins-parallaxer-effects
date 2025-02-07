<?php

if (!function_exists('dzs_savemeta')) {

    function dzs_savemeta($id, $arg2, $arg3 = '') {
        //echo htmlentities($_POST[$arg2]);
        if ($arg3 == 'html') {
            update_post_meta($id, $arg2, htmlentities($_POST[$arg2]));
            return;
        }


        if (isset($_POST[$arg2]))
            update_post_meta($id, $arg2, esc_attr(strip_tags($_POST[$arg2])));
        else
        if ($arg3 == 'checkbox')
            update_post_meta($id, $arg2, "off");
    }

}

if (!function_exists('print_rr')) {


	function print_rr($arg=array(), $pargs=array()){
		$margs = array(
			'echo'=>true,
			'encode_html'=>false,
		);

		if($pargs){
			$margs = array_merge($margs,$pargs);
		}


		$fout = '';
		if($margs['echo']==false){
			ob_start();
		}

		echo '<pre>';

		if($margs['encode_html']){

			echo htmlentities(print_r($arg, true));
		}else{

			print_r($arg);
		}
		echo '</pre>';


		if($margs['echo']==false){
			$fout = ob_get_clean();

			return $fout;
		}


	}


}


if (!function_exists('dzs_checked')) {

    function dzs_checked($arg1, $arg2, $arg3 = 'checked', $echo = true) {
        $func_output = '';
        if (isset($arg1) && $arg1 == $arg2) {
            $func_output = $arg3;
        }
        if ($echo == true)
            echo $func_output;
        else
            return $func_output;
    }

}

if (!function_exists('dzs_find_string')) {

    function dzs_find_string($arg, $arg2) {
        $pos = strpos($arg, $arg2);

        if ($pos === false)
            return false;

        return true;
    }

}


if (!function_exists('dzs_get_excerpt')) {

    //echo 'dzs_get_excerpt 
    //version 1.2';
      function dzs_get_excerpt($pid = 0, $pargs = array()) {

        // -- $pid - -1 no post
        //print_r($pargs);
        global $post;
        $fout = '';
        $excerpt = '';
        if ($pid == 0 && isset($post->ID)) {
            $pid = $post->ID;
        }
        //echo $pid;
        $po = null;
        if(function_exists('get_post') && intval($pid) && intval($pid)>0 ){
            $po = (get_post($pid));
        }


        $margs = array(
            'maxlen' => 400
        , 'striptags' => false
        , 'stripshortcodes' => false
        , 'forceexcerpt' => false //if set to true will ignore the manual post excerpt
        , 'try_to_close_unclosed_tags' => false // -- this will try to close unclosed tags
        , 'readmore' => 'auto'
        , 'readmore_markup' => ''
        , 'content' => ''
        , 'call_from' => 'default'
        );
        $margs = array_merge($margs, $pargs);

        //        print_r($margs);

        if ($margs['content']) {
            $margs['forceexcerpt'] = true;
        }



        if (isset($po->post_excerpt) && $po->post_excerpt != '' && $margs['forceexcerpt'] == false) {
            $fout = $po->post_excerpt;


            //==== replace the read more with given markup or theme function or default
            if ($margs['readmore_markup'] != '') {
                $fout = str_replace('{readmore}', $margs['readmore_markup'], $fout);
            } else {
                if (function_exists('continue_reading_link')) {
                    $fout = str_replace('{readmore}', continue_reading_link($pid), $fout);
                } else {
                    $fout = str_replace('{readmore}', '<div class="readmore-con"><a href="' . get_permalink($pid) . '">' . __('Read More') . '</a></div>', $fout);
                }
            }
            //==== replace the read more with given markup or theme function or default END
            return $fout;
        }

        $content = '';
        if ($margs['content']) {
            $content = $margs['content'];
        } else {
            if($po){

                $content = $po->post_content;
            }
        }


        $maxlen = intval($margs['maxlen']);
        if ($margs['stripshortcodes'] === true) {
            if(function_exists('strip_shortcodes')){

                $excerpt = strip_shortcodes(stripslashes($excerpt));
            }
        }


        if ($margs['striptags'] == true) {
            $content = strip_tags($content);
        }

        if (strlen($content) > $maxlen) {
            //===if the content is longer then the max limit
            //            echo 'initial content - '.$content. ' ||| '. $maxlen .' ||| ';
            $excerpt.=substr($content, 0, $maxlen);


            //            echo 'initial excerpt - '.$excerpt;

            if ($margs['striptags'] != true && $margs['try_to_close_unclosed_tags']) {


                //                echo 'leeen - '.strpos($excerpt, '</').' '.strlen($excerpt).' '.substr($excerpt,0,strlen($excerpt)-2);
                if(strpos($excerpt, '<')===strlen($excerpt)-1){

                    $excerpt = substr($excerpt,0,strlen($excerpt)-1);
                }
                if(strpos($excerpt, '</')===strlen($excerpt)-2){

                    $excerpt = substr($excerpt,0,strlen($excerpt)-2);
                }
                if(strpos($excerpt, '</p')===strlen($excerpt)-3){

                    $excerpt = substr($excerpt,0,strlen($excerpt)-3);
                }

                if(class_exists('DOMDocument')){
                    $doc = new DOMDocument();
                    @$doc->loadHTML($excerpt);

                    $aux_body_html = '';


                    $children = $doc->childNodes;
                    $scriptTags = $doc->getElementsByTagName('script');


                    foreach ($scriptTags as $script) {
                        if ($script->childNodes->length && $script->firstChild->nodeType == 4) {
                            $cdata = $script->removeChild($script->firstChild);
                            $text = $doc->createTextNode($cdata->nodeValue);
                            $script->appendChild($text);
                        }
                    }

                    foreach ($children as $child) {
                        //                        print_r($child);
                        //                        echo $child->ownerDocument->saveXML( $child );
                        $aux_body_html .= $child->ownerDocument->saveXML($child);
                    }


                    $aux_body_html = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"><html><body>','',$aux_body_html);
                    $aux_body_html = str_replace('</body></html>','',$aux_body_html);

                    $aux_body_html = str_replace(array('<![CDATA['),'',$aux_body_html);
                    $aux_body_html = str_replace(array('&#13;'),'',$aux_body_html);
                    //                    echo 'final excerpt - '.$aux_body_html;
                }
            }

            //            echo 'initialz excerpt - '.$excerpt.' ||| '.$margs['striptags'].' ||| ';

            //            echo 'final excerpt - '.$excerpt;
            if ($margs['stripshortcodes'] == false && function_exists('do_shortcode')) {
                $excerpt = do_shortcode(stripslashes($excerpt));
            }

            $fout.=$excerpt;

            //            print_r($margs); echo "\n\n";
            if ($margs['readmore'] == 'auto' || $margs['readmore'] == 'on') {
                $fout .= '{readmore}';
            }
        } else {
            //===if the content is not longer then the max limit just add the content
            $fout.=$content;
            if ($margs['readmore'] == 'on') {
                $fout .= '{readmore}';
            }
        }

        //        echo $fout.' <-- fout';
        //==== replace the read more with given markup or theme function or default
        if ($margs['readmore_markup'] != '') {
            $fout = str_replace('{readmore}', $margs['readmore_markup'], $fout);
        } else {
            if (function_exists('continue_reading_link')) {
                $fout = str_replace('{readmore}', continue_reading_link($pid), $fout);
            } else {
                if(function_exists('get_permalink')){
                    $fout = str_replace('{readmore}', '<div class="readmore-con"><a href="' . get_permalink($pid) . '">' . __('read more') . ' &raquo;</a></div>', $fout);
                }

            }
        }


        //        echo ' final fout -- '. $fout;
        //==== replace the read more with given markup or theme function or default END
        return $fout;
    }

}


if (!function_exists('dzs_print_menu')) {

    function dzs_print_menu() {
        $args = array('menu' => 'mainnav', 'menu_class' => 'menu sf-menu', 'container' => false, 'theme_location' => 'primary', 'echo' => '0');
        $aux = wp_nav_menu($args);
        $aux = preg_replace('/<ul>/', '<ul class="sf-menu">', $aux, 1);
        if (preg_match('/<div class="sf-menu">/', $aux)) {
            $aux = preg_replace('/<div class="sf-menu">/', '', $aux, 1);
            $aux = $rest = substr($aux, 0, -7);
        }
        // $aux_char = '/';
        //$aux = preg_replace('/<div>/', '', $aux, 1);
        print_r($aux);
    }

}
if (!function_exists('dzs_post_date')) {

    function dzs_post_date($pid) {
        $po = get_post($pid);
        //print_r($po);
        if ($po) {
            echo mysql2date('l M jS, Y', $po->post_date);
        }
    }

}


if (!function_exists('dzs_pagination')) {

    function dzs_pagination($pages = '', $range = 2) {
        global $paged;
        $fout = '';
        $showitems = ($range * 2) + 1;

        if (empty($paged))
            $paged = 1;

        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }

        if (1 != $pages) {
            $fout.= "<div class='dzs-pagination'>";
            if ($paged > 2 && $paged > $range + 1 && $showitems < $pages)
                $fout.= "<a href='" . get_pagenum_link(1) . "'>&laquo;</a>";
            if ($paged > 1 && $showitems < $pages)
                $fout.= "<a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo;</a>";

            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems )) {
                    $fout.= ( $paged == $i) ? "<span class='current'>" . $i . "</span>" : "<a href='" . get_pagenum_link($i) . "' class='inactive' >" . $i . "</a>";
                }
            }

            if ($paged < $pages && $showitems < $pages)
                $fout.= "<a href='" . get_pagenum_link($paged + 1) . "'>&rsaquo;</a>";
            if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages)
                $fout.= "<a href='" . get_pagenum_link($pages) . "'>&raquo;</a>";
            $fout.= '<div class="clearfix"></div>';
            $fout.= "</div>
                ";
        }
        return $fout;
    }

}


if (!function_exists('replace_in_matrix')) {

    function replace_in_matrix($arg1, $arg2, &$argarray) {
        foreach ($argarray as &$newi) {
            //print_r($newi);
            if (is_array($newi)) {
                foreach ($newi as &$newj) {
                    if (is_array($newj)) {
                        foreach ($newj as &$newk) {
                            if (!is_array($newk)) {
                                $newk = str_replace($arg1, $arg2, $newk);
                            }
                        }
                    } else {
                        $newj = str_replace($arg1, $arg2, $newj);
                    }
                }
            } else {
                $newi = str_replace($arg1, $arg2, $newi);
            }
        }
    }

}


if (!function_exists('dzs_curr_url')) {

    function dzs_curr_url() {
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $page_url .= "https://";
        } else {
            $page_url = 'http://';
        }
        if ($_SERVER["SERVER_PORT"] != "80") {
            $page_url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
        } else {
            $page_url .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
        }
        return $page_url;
    }

}


if (!function_exists('dzs_addAttr')) {

    function dzs_addAttr($arg1, $arg2) {
        $fout = '';
        //$arg2 = str_replace('\\', '', $arg2);
        if (isset($arg2) && $arg2 != "undefined" && $arg2 != '')
            $fout.= ' ' . $arg1 . "='" . $arg2 . "' ";
        return $fout;
    }

}


if(!function_exists('dzs_addSwfAttr')){
    function dzs_addSwfAttr($arg1, $arg2, $first=false) {
        $fout='';
        //$arg2 = str_replace('\\', '', $arg2);

        //sanitaze for object input
        $lb   = array('"' ,"\r\n", "\n", "\r", "&", "`", '???', "'");
        $arg2 = str_replace(' ', '%20', $arg2);
        //$arg2 = str_replace('<', '', $arg2);
        $arg2 = str_replace($lb, '', $arg2);

        if (isset ($arg2)  && $arg2 != "undefined" && $arg2 != ''){
            if($first==false){
                $fout.='&amp;';
            }
            $fout.= $arg1 . "=" . $arg2 . "";
        }
        return $fout;
    }
}


if (!function_exists('dzs_clean')) {

    function dzs_clean($var) {
        if (!function_exists('sanitize_text_field')) {
            return $var;
        } else {
            return sanitize_text_field($var);
        }
    }

}

if (!class_exists('DZSHelpers')) {

    class DZSHelpers {

        static function get_contents($url, $pargs = array()) {
            $margs = array(
                'force_file_get_contents' => 'off',
            );
            $margs = array_merge($margs, $pargs);
            if (function_exists('curl_init') && $margs['force_file_get_contents'] == 'off') { // if cURL is available, use it...
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $cache = curl_exec($ch);
                curl_close($ch);
            } else {
                $cache = @file_get_contents($url); // ...if not, use the common file_get_contents()
            }
            return $cache;
        }
        
        static function remove_wpautop( $content, $autop = false ) {

            if ($autop && function_exists('wpautop')){
                $content = wpautop( preg_replace( '/<\/?p\>/', "\n", $content ) . "\n" );
            }
            if(function_exists('shortcode_unautop')){
                return do_shortcode( shortcode_unautop( $content) );
            }else{
                return $content;
            }
            
        }

        static function wp_savemeta($id, $arg2, $arg3 = '') {
            //echo htmlentities($_POST[$arg2]);
            if ($arg3 == 'html') {
                update_post_meta($id, $arg2, htmlentities($_POST[$arg2]));
                return;
            }


            if (isset($_POST[$arg2]))
                update_post_meta($id, $arg2, esc_attr(strip_tags($_POST[$arg2])));
            else
            if ($arg3 == 'checkbox')
                update_post_meta($id, $arg2, "off");
        }

        static function wp_get_excerpt($pid = 0, $pargs = array()) {
//            print_r($pargs);
            global $post;
            $fout = '';
            $excerpt = '';
            if ($pid == 0) {
                $pid = $post->ID;
            } else {
                $pid = $pid;
            }

//            echo $pid;
            $po = (get_post($pid));

            $margs = array(
                'maxlen' => 400
                , 'striptags' => false
                , 'stripshortcodes' => false
                , 'forceexcerpt' => false //if set to true will ignore the manual post excerpt
                , 'aftercutcontent_html' => '' // you can put here something like [..]
                , 'readmore' => 'auto'
                , 'readmore_markup' => ''
                , 'content' => '' // forced content
            );
            $margs = array_merge($margs, $pargs);

            if ($margs['content'] != '') {
                $margs['readmore'] = 'off';
                $margs['forceexcerpt'] = true;
            }

            
            
//                print_r($margs);

            if ($po->post_excerpt != '' && $margs['forceexcerpt'] == false) {
                $fout = do_shortcode($po->post_excerpt);


                //==== replace the read more with given markup or theme function or default
                if ($margs['readmore_markup'] != '') {
                    $fout = str_replace('{readmore}', $margs['readmore_markup'], $fout);
                } else {
                    if (function_exists('continue_reading_link')) {
                        $fout = str_replace('{readmore}', continue_reading_link($pid), $fout);
                    } else {
                        if (function_exists('dzs_excerpt_read_more')) {
                            $fout = str_replace('{readmore}', dzs_excerpt_read_more($pid), $fout);
                        } else {
                            //===maybe in the original function you can parse readmore
                            //$fout = str_replace('{readmore}', '<div class="readmore-con"><a href="' . get_permalink($pid) . '">' . __('read more') . ' &raquo;</a></div>', $fout);
                        }
                    }
                }
                //==== replace the read more with given markup or theme function or default END
                return $fout;
            }
            
            

            $content = '';
            if ($margs['content'] != '') {
                $content = $margs['content'];
            } else {
                if ($margs['striptags'] == false) {
                    if ($margs['stripshortcodes'] == false) {
                        $content = do_shortcode($po->post_content);
                    }else{
                        $content = $po->post_content;
                    }
                    
                } else {
//                    echo 'pastcontent'.$content;
                    $content = strip_tags($po->post_content);
//                    echo 'nowcontent'.$content;
                }
            }

//            echo 'nowcontent'.$content.'/nowcontent';

            $maxlen = intval($margs['maxlen']);
            
//            echo 'maxlen'.$maxlen;

            if (strlen($content) > $maxlen) {
                //===if the content is longer then the max limit
                $excerpt.=substr($content, 0, $maxlen);

                if ($margs['striptags'] == true) {
                    $excerpt = strip_tags($excerpt);
                    //echo $excerpt;
                }
                if ($margs['stripshortcodes'] == false) {
                    $excerpt = do_shortcode(stripslashes($excerpt));
                } else {
                    $excerpt = strip_shortcodes(stripslashes($excerpt));
                    $excerpt = str_replace('[/one_half]', '', $excerpt);
                    $excerpt = str_replace("\n", " ", $excerpt);
                    $excerpt = str_replace("\r", " ", $excerpt);
                    $excerpt = str_replace("\t", " ", $excerpt);
                }

                $fout.=$excerpt.$margs['aftercutcontent_html'];
                if ($margs['readmore'] == 'auto') {
                    $fout .= '{readmore}';
                }
            } else {
                //===if the content is not longer then the max limit just add the content
                $fout.=$content;
                if ($margs['readmore'] == 'on') {
                    $fout .= '{readmore}';
                }
            }

            //==== replace the read more with given markup or theme function or default
            if ($margs['readmore_markup'] != '') {
                $fout = str_replace('{readmore}', $margs['readmore_markup'], $fout);
            } else {
                if (function_exists('continue_reading_link')) {
                    $fout = str_replace('{readmore}', continue_reading_link($pid), $fout);
                } else {
                    if (function_exists('dzs_excerpt_read_more')) {
                        $fout = str_replace('{readmore}', dzs_excerpt_read_more($pid), $fout);
                    } else {
                        //===maybe in the original function you can parse readmore
                        //$fout = str_replace('{readmore}', '<div class="readmore-con"><a href="' . get_permalink($pid) . '">' . __('read more') . ' &raquo;</a></div>', $fout);
                    }
                }
            }
            //echo $fout;
            //==== replace the read more with given markup or theme function or default END
            return $fout;
        }
    
        static function generate_input_text($argname, $otherargs = array()) {
            $fout = '';
        
            $margs = array(
                'class' => '',
                'val' => '', // === default value
                'seekval' => '', // ===the value to be seeked
                'type' => '',
                'extraattr'=>'',
                'slider_min'=>'10',
                'slider_max'=>'80',
                'input_type'=>'text',
            );
            $margs = array_merge($margs, $otherargs);
        
            $fout.='<input type="'.$margs['input_type'].'"';
            $fout.=' name="' . $argname . '"';
        
        
            if ($margs['type'] == 'colorpicker') {
                $margs['class'].=' with_colorpicker';
            }
        
            $val = '';


            $fout.=' class ="';
//            print_r($margs);
            if ($margs['class'] != '') {
                $fout.=' ' . $margs['class'] . '';
            }
    
            if ($margs['type'] == 'slider') {
                $fout.=' disabled';
            }
            
            $fout.='"';
            if (isset($margs['seekval']) && $margs['seekval'] != '') {
                //echo $argval;
                $fout.=' value="' . $margs['seekval'] . '"';
                $val = $margs['seekval'];
            } else {
                $fout.=' value="' . $margs['val'] . '"';
                $val = $margs['val'];
            }
    
            if ($margs['type'] == 'slider') {
//                $fout.=' disabled';
            }
        
            if ($margs['extraattr'] != '') {
                $fout.='' . $margs['extraattr'] . '';
            }
        
            $fout.='/>';
        
        
        
            //print_r($args); print_r($otherargs);
            if ($margs['type'] == 'slider') {
                
                $tempval = $val;
                
                if($tempval == '' || intval($tempval)==false){
                    $tempval = 0;
                }
                
                $fout.='<div id="' . $argname . '_slider" style="width:200px;"></div>';
                $fout.='<script>
jQuery(document).ready(function($){
$( "#' . $argname . '_slider" ).slider({
range: "max",
min: '.$margs['slider_min'].',
max: '.$margs['slider_max'].',
value: '.$tempval.',
stop: function( event, ui ) {
//console.log($( "*[name=' . $argname . ']" ));
$( "*[name=' . $argname . ']" ).val( ui.value );
$( "*[name=' . $argname . ']" ).trigger( "change" );
}
});
});</script>';
            }
            if ($margs['type'] == 'colorpicker') {
                $fout.='<div class="picker-con"><div class="the-icon"></div><div class="picker"></div></div>';
                $fout.='<script>
jQuery(document).ready(function($){
jQuery(".with_colorpicker").each(function(){
        var _t = jQuery(this);
        if(_t.hasClass("treated")){
            return;
        }
        if(jQuery.fn.farbtastic){
        //console.log(_t);
        _t.next().find(".picker").farbtastic(_t);
            
        }else{ if(window.console){ console.info("declare farbtastic..."); } };
        _t.addClass("treated");

        _t.bind("change", function(){
            //console.log(_t);
            jQuery("#customstyle_body").html("body{ background-color:" + $("input[name=color_bg]").val() + "} .dzsportfolio, .dzsportfolio a{ color:" + $("input[name=color_main]").val() + "} .dzsportfolio .portitem:hover .the-title, .dzsportfolio .selector-con .categories .a-category.active { color:" + $("input[name=color_high]").val() + " }");
        });
        _t.trigger("change");
        _t.bind("click", function(){
            if(_t.next().hasClass("picker-con")){
                _t.next().find(".the-icon").eq(0).trigger("click");
            }
        })
    });
});</script>';
            }
        
            return $fout;
        }

        static function generate_input_checkbox($argname, $argopts) {
            $fout = '';
            $auxtype = 'checkbox';

            if (isset($argopts['type'])) {
                if ($argopts['type'] == 'radio') {
                    $auxtype = 'radio';
                }
            }
            $fout.='<input type="' . $auxtype . '"';
            $fout.=' name="' . $argname . '"';
            if (isset($argopts['class'])) {
                $fout.=' class="' . $argopts['class'] . '"';
            }

            if (isset($argopts['id'])) {
                $fout.=' id="' . $argopts['id'] . '"';
            }

            $theval = 'on';
            if (isset($argopts['val'])) {
                $fout.=' value="' . $argopts['val'] . '"';
                $theval = $argopts['val'];
            } else {
                $fout.=' value="on"';
            }
            //print_r($this->mainoptions); print_r($argopts['seekval']);
            if (isset($argopts['seekval'])) {
                $auxsw = false;
                if (is_array($argopts['seekval'])) {
                    //echo 'ceva'; print_r($argopts['seekval']);
                    foreach ($argopts['seekval'] as $opt) {
                        //echo 'ceva'; echo $opt; echo 
                        if ($opt == $argopts['val']) {
                            $auxsw = true;
                        }
                    }
                } else {
                    //echo $argopts['seekval']; echo $theval;
                    if ($argopts['seekval'] == $theval) {
                        //echo $argval;
                        $auxsw = true;
                    }
                }
                if ($auxsw == true) {
                    $fout.=' checked="checked"';
                }
            }
            $fout.='/>';
            return $fout;
        }

        static function generate_input_textarea($argname, $otherargs = array()) {
            $fout = '';
            $fout.='<textarea';
            $fout.=' name="' . $argname . '"';

            $margs = array(
                'class' => '',
                'id' => '',
                'val' => '', // === default value
                'seekval' => '', // ===the value to be seeked
                'type' => '',
                'extraattr'=>'',
            );
            $margs = array_merge($margs, $otherargs);



            if ($margs['class'] != '') {
                $fout.=' class="' . $margs['class'] . '"';
            }
            if ($margs['id'] != '') {
                $fout.=' id="' . $margs['id'] . '"';
            }
            if ($margs['extraattr'] != '') {
                $fout.='' . $margs['extraattr'] . '';
            }
            $fout.='>';
            if (isset($margs['seekval']) && $margs['seekval'] != '') {
                $fout.='' . $margs['seekval'] . '';
            } else {
                $fout.='' . $margs['val'] . '';
            }
            $fout.='</textarea>';

            return $fout;
        }


        static function add_query_arg($url,$key,$value){
            $a = parse_url($url);

//            echo 'wwhat what';



            $result = '';

            if(strpos($url,$key.'=')!==false){


                $result = preg_replace("/".$key."=(.*?)&?$/", $key."=".urlencode($value), $url);;
            }else{

                if(strpos($url,'?')!==false){

                    $result =  $url.'&' . $key.'='.urlencode($value);
                }else{

                    $result =  $url.'?' . $key.'='.urlencode($value);
                }
            }


//            echo "\n"."\n".'result - '.$result;
            return $result;
        }

        static function generate_select($argname, $pargopts) {
            //-- DZSHelpers::generate_select('label', array('options' => array('peritem','off', 'on'), 'class' => 'styleme', 'seekval' => $this->mainoptions[$lab]));

            $fout = '';
            $auxtype = 'select';

            if($pargopts==false){
                $pargopts = array();
            }

            $margs = array(
                'options' => array(),
                'class' => '',
                'seekval' => '',
                'extraattr'=>'',
            );

            $margs = array_merge($margs, $pargopts);

            $fout.='<select';
            $fout.=' name="' . $argname . '"';
            if (isset($margs['class'])) {
                $fout.=' class="'.$margs['class'].'"';
            }
            if ($margs['extraattr'] != '') {
                $fout.='' . $margs['extraattr'] . '';
            }

            $fout.='>';

            //print_r($margs['options']);

            foreach ($margs['options'] as $opt) {
                $val = '';
                $lab = '';



                if (is_array($opt) && isset($opt['lab']) && isset($opt['val'])) {
                    $val = $opt['val'];
                    $lab = $opt['lab'];
                } else {
                    if (is_array($opt) && isset($opt['label']) && isset($opt['value'])) {

                        $val = $opt['value'];
                        $lab = $opt['label'];
                    }else{
                        $val = $opt;
                        $lab = $opt;
                    }

                }


                $fout.='<option value="' . $val . '"';
                if ($margs['seekval'] != '' && $margs['seekval'] == $val) {
                    $fout.=' selected';
                }

                $fout.='>' . $lab . '</option>';
            }
            $fout.='</select>';
            return $fout;
        }
        static function get_query_arg($url, $key) {
            //-- DZSHelpers::get_query_arg('
//            echo 'ceva';
            if(strpos($url, $key)!==false){
                //faconsole.log('testtt');

//                $pattern = '/[?&]'.$key.'=(.+)/';
                $pattern = '/[?&]'.$key.'=(.+?)(?=&|$)/';
                preg_match($pattern, $url, $matches);

//                print_r($matches);
                if($matches && $matches[1]){
                    return $matches[1];
                }
                //$('.zoombox').eq
            }
        }
        static function transform_to_str_size($arg) {
            //-- DZSHelpers::transform_to_str_size(400%);
            $fout = $arg;
            if(strpos($arg,'auto')!==false || strpos($arg,'%')!==false){

            }else{
                $fout.='px';
            }
            return $fout;
        }

    }

}