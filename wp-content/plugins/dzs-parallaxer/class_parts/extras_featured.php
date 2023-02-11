<?php

# -- set featured gallery extra
add_action('admin_init', 'dzsvg_extras_featured_admin_init');

function dzsvg_extras_featured_admin_init(){
    add_meta_box('dzsvg_extras_featured_meta_options',__('DZS Video Gallery Settings'),'dzsvg_extras_featured_admin_meta_options','post','normal','high');
    add_meta_box('dzsvg_extras_featured_meta_options',__('DZS Video Gallery Settings'),'dzsvg_extras_featured_admin_meta_options','page','normal','high');
}





function dzsvg_extras_featured_admin_meta_options() {
    global $post, $dzsvg;
    ?>
    <h4><?php echo __("Featured Gallery",'dzsvg'); ?></h4>
    <select class="textinput styleme" name="dzsvg_extras_featured">
        <option>none</option>
    <?php
    foreach ($dzsvg->mainitems as $it) {
        echo '<option ';
        dzs_checked(get_post_meta($post->ID,'dzsvg_extras_featured',true),$it['settings']['id'],'selected');
        echo '>'.$it['settings']['id'].'</option>';
    }
    ?>
    </select>
    <div class="clear"></div>

    <div class="sidenote">
    <?php echo __('Set a featured gallery. Only for certain themes','dzsvg'); ?><br/>
    </div>
        <?php
    }
    
    
//add_action('it_before_featured_video','dzsvg_extras_featured_show_gallery');
add_action('it_before_featured_image','dzsvg_extras_featured_show_gallery');


function dzsvg_extras_featured_show_gallery(){
    
        global $post;
        if (!$post) {
            return;
        }
        //echo 'ceva';
        $wallid = get_post_meta($post->ID,'dzsvg_extras_featured',true);
        if ($wallid != '' && $wallid != 'none') {
            echo do_shortcode('[videogallery id="'.$wallid.'"]');
            ?>
            <style>
                .featured-image-wrapper{ display: none; }
            </style>
            <?php
        }
}
# -- END set featured gallery extra