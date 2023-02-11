<?php

class DZSParallaxer{

  public $the_url = '';
  public $base_url = '';


  private $frontend_errors = array();
  private $the_shortcode = 'parallaxer';

  public $db_mainoptions = array();
  public $db_mainoptions_default = array();
  public $dbname_layouts = 'dzsprx_items';
  public $dbname_mainoptions = 'dzsprx_mainoptoins';

  public $pagename_mainoptions = 'dzsprx_mainoptions';
  public $adminpagename_autoupdater = 'dzsprx-autoupdater';

  private $pluginmode = 'plugin';
  private $include_settings = 'off';
  private $layout_index = 0;
  private $enable_scrollbar = 'off';

  private $cap_admin = 'publish_posts';
  public $options_array_parallax = array();

  private $last_th = 0; // -- the last total height used for the parallaxer



  public $allowed_tags = array(
    'p'=>array(
      'class'=>array(),
      'style' => array(),
    ),
    'strong'=>array(),
    'em'=>array(),
    'br'=>array(),
    'a'=>array(
      'href' => array(),
      'target' => array(),
      'style' => array(),
    ),
  );



  function __construct(){


    if ($this->pluginmode == 'theme') {
      $this->the_url = THEME_URL.'plugins/dzs-parallaxer/';
    } else {
      $this->the_url = plugins_url('',__FILE__).'/';
    }

    $this->base_url = $this->the_url;

    $this->db_mainoptions_default = array(
      'always_embed' => 'off',
      'extra_css' => '',
      'dzsprx_purchase_code' => '',
      'dzsprx_purchase_code_binded' => 'off',
      'enable_module_features' => 'off',
      'capabilities_added' => 'off',
      'theme_breakout_initial' => '',
      'theme_breakout_final' => '',
    );

    $this->db_mainoptions = get_option($this->dbname_mainoptions);

    if(is_array($this->db_mainoptions)){

      $this->db_mainoptions=array_merge($this->db_mainoptions_default, $this->db_mainoptions);
    }else{

      $this->db_mainoptions=$this->db_mainoptions_default;
    }

    require_once("class_parts/options_array_parallax.php");

    // --- check posts
    if(isset($_GET['dzsprx_shortcode_builder']) && $_GET['dzsprx_shortcode_builder']=='on'){
//            dzsprx_shortcode_builder();

      include_once(dirname(__FILE__).'/tinymce/popupframe.php');
      define('DONOTCACHEPAGE', true);
      define('DONOTMINIFY', true);

    }
    if(isset($_GET['dzsprx_features_builder']) && $_GET['dzsprx_features_builder']=='on'){
//            dzsprx_shortcode_builder();

      include_once(dirname(__FILE__).'/tinymce/popupframe_features.php');
      define('DONOTCACHEPAGE', true);
      define('DONOTMINIFY', true);

    }
    if(isset($_POST['action']) && $_POST['action']=='dzsprx_ajax_mo'){
      $this->post_save_mainoptions();
    }
    if(isset($_POST['action']) && $_POST['action']=='dzsprx_ajax_hide_notice'){
      update_option($_POST['postdata'],'seen');
      die();
    }


//        if (isset($_POST['dzsprx_importdb'])) {
//
//            $this->import_database();
//        }
//        if (isset($_POST['dzsprx_exportdb'])) {
//
//            header('Content-Type: text/plain');
//            header('Content-Disposition: attachment; filename="'."dzsprx_backup.txt".'"');
//            echo serialize($this->db_layouts);
//            die();
//        }

    add_action('init', array($this, 'handle_init'));
    add_action('admin_init',array($this,'admin_init'));
    add_action('admin_head', array($this, 'handle_admin_head'));
    add_action('wp_head', array($this, 'handle_wp_head'));
    add_action('wp_footer', array($this, 'handle_wp_footer'));
    add_action('admin_menu', array($this, 'handle_admin_menu'));
    add_action('save_post',array($this,'admin_meta_save'));

    add_shortcode($this->the_shortcode, array($this, 'shortcode_main') );
    add_shortcode('dzs_'.$this->the_shortcode, array($this,'shortcode_main') );
    add_shortcode('dzs_'.$this->the_shortcode.'_row_start', array($this,'shortcode_row_start') );
    add_shortcode('dzs_'.$this->the_shortcode.'_row_end', array($this,'shortcode_row_end') );
    add_shortcode('dzsprx_custom_content', array($this,'shortcode_custom_content') );
    add_shortcode('dzsprx_separator', array($this,'shortcode_separator') );
    add_shortcode('dzsprx_fullslider', array($this,'shortcode_fullslider') );
    add_shortcode('dzsprx_fullslider_item', array($this,'shortcode_fullslider_item') );
    add_shortcode('dzs_parallaxer_layer', array($this,'shortcode_layer') );


    add_shortcode('dzsprx_layer_img', array($this, 'shortcode_dzsprx_layer_img') );
    add_shortcode('dzsprx_layer_div', array($this, 'shortcode_dzsprx_layer_div') );


    if($this->db_mainoptions['enable_module_features']==='on'){

      add_shortcode('dzs_parallaxer_features', array($this, 'module_features_shortcode_main') );
      add_shortcode('dzsprx_feature_img', array($this, 'module_features_shortcode_img') );
      add_shortcode('dzsprx_feature_html', array($this, 'module_features_shortcode_html') );

    }
  }

  function handle_init(){

    wp_enqueue_script('jquery');
    if(is_admin()){


      wp_enqueue_style('dzstlt',$this->the_url.'libs/dzstooltip/dzstooltip.css');
      wp_enqueue_script('dzstlt',$this->the_url.'libs/dzstooltip/dzstooltip.js');


      wp_enqueue_script('dzsprx.admin.global', $this->the_url . 'admin/admin-global.js');
      wp_enqueue_style('dzsprx.admin.global', $this->the_url . 'admin/admin-global.css');
      if (current_user_can('edit_posts') || current_user_can('edit_pages')) {

        wp_enqueue_style('dzs.zoombox', $this->the_url . 'zoombox/zoombox.css');
        wp_enqueue_script('dzs.zoombox', $this->the_url . 'zoombox/zoombox.js');
        wp_enqueue_style('dzsulb', $this->the_url . 'libs/ultibox/ultibox.css');
        wp_enqueue_script('dzsulb', $this->the_url . 'libs/ultibox/ultibox.js');


        if(current_user_can('manage_options') || current_user_can('dzsprx_make_shortcode')){

//                    echo 'ceva';
          wp_enqueue_script('dzsprx_htmleditor', $this->the_url . 'tinymce/plugin-htmleditor.js');
        }

        wp_enqueue_script('dzsprx_configreceiver', $this->the_url . 'tinymce/receiver.js');
        $this->include_settings = 'on';
      }



      if(isset($_GET['page']) && $_GET['page']===$this->pagename_mainoptions){

        wp_enqueue_style('fontawesome', $this->the_url.'fontawesome/font-awesome.min.css');
        wp_enqueue_style('dzs.checkbox', $this->the_url.'dzscheckbox/dzscheckbox.css');



        if(isset($_GET['dzsprx_shortcode_builder']) && $_GET['dzsprx_shortcode_builder']=='on'){

          wp_enqueue_style('dzsprx_shortcode_builder_style', $this->the_url . 'tinymce/popup.css');
          wp_enqueue_script('dzsprx_shortcode_builder', $this->the_url . 'tinymce/popup.js');
          wp_enqueue_style('dzs.dzstoggle',$this->the_url.'dzstoggle/dzstoggle.css');
          wp_enqueue_script('dzs.dzstoggle',$this->the_url.'dzstoggle/dzstoggle.js');
          wp_enqueue_media();
        }else{
          if(isset($_GET['dzsprx_features_builder']) && $_GET['dzsprx_features_builder']=='on'){

            wp_enqueue_script('jquery-ui-core');
            wp_enqueue_script('jquery-ui-sortable');



            wp_enqueue_style('dzsprx_shortcode_builder_style', $this->the_url . 'tinymce/popup.css');
            wp_enqueue_script('dzsprx_features_builder', $this->the_url . 'tinymce/popup_features.js');
            wp_enqueue_style('dzs.dzstoggle',$this->the_url.'dzstoggle/dzstoggle.css');
            wp_enqueue_script('dzs.dzstoggle',$this->the_url.'dzstoggle/dzstoggle.js');
            wp_enqueue_media();
          }else {


            wp_enqueue_style('dzsprx_mo', $this->the_url . 'admin/admin-mainoptions.css');
            wp_enqueue_script('dzsprx_mo', $this->the_url . 'admin/admin-mainoptions.js');


            wp_enqueue_style('codemirror', $this->the_url . 'codemirror/codemirror.css');
            wp_enqueue_script('codemirror', $this->the_url . 'codemirror/codemirror.js');
            wp_enqueue_script('codemirror_css', $this->the_url . 'codemirror/css.js');
//                    wp_enqueue_script('codemirror_closetag', $this->the_url . 'codemirror/closetag.js');
          }
        }

//                wp_enqueue_script('dzs.layouter.data', $this->the_url.'db/dzsparallaxer.data.js');
      }





    }else{

      if($this->db_mainoptions['always_embed']==='on'){

        wp_enqueue_style('dzs.parallaxer', $this->the_url.'dzsparallaxer/dzsparallaxer.css');
        wp_enqueue_script('dzs.parallaxer', $this->the_url.'dzsparallaxer/dzsparallaxer.js');

        wp_enqueue_script('scroller', $this->the_url . 'dzsscroller/scroller.js');
        wp_enqueue_style('scroller', $this->the_url . 'dzsscroller/scroller.css');
      }
    }



    if(function_exists('vc_add_shortcode_param')){
      vc_add_shortcode_param('dzs_add_media', array($this,'vc_dzs_add_media') );
      vc_add_shortcode_param('dzs_transition_custom', array($this,'vc_dzs_transition_custom') );
    }
    include_once(dirname(__FILE__).'/vc/part-vcintegration.php');

    add_action( 'vc_frontend_editor_render', array($this,'vc_enqueue_editor_scripts_befe') );



    if(function_exists('vc_map')==false){
      add_shortcode('vc_row',array($this,'vc_fallback_vc_row'));
      add_shortcode('vc_row_inner',array($this,'vc_fallback_vc_row'));
      add_shortcode('vc_column',array($this,'vc_fallback_vc_column'));
      add_shortcode('vc_column_inner',array($this,'vc_fallback_vc_column'));
      add_shortcode('vc_column_text',array($this,'vc_fallback_vc_column_text'));
      add_shortcode('vc_single_image',array($this,'vc_fallback_vc_single_image'));
      add_shortcode('vc_custom_heading',array($this,'vc_fallback_vc_custom_heading'));
    }
  }

  function vc_fallback_vc_custom_heading($pargs='',$content=''){


    $margs = array(
      'el_class' => '',
      'text' => '',
    );



    $margs = array_merge($margs,$pargs);


    $fout = '';

    $fout.='<h3 class="dzs-heading '.$margs['el_class'].'">'.$margs['text'].'</h3>';



    return $fout;


  }
  function vc_fallback_vc_single_image($pargs='',$content=''){


    $margs = array(
      'el_class' => '',
    );



    $margs = array_merge($margs,$pargs);
    $fout = '';

    $fout.='<img class="fullwidth" src="'.$margs['custom_src'].'"/>';



    return $fout;


  }
  function vc_fallback_vc_row($pargs='',$content=''){




    $margs = array(
      'el_class' => '',
    );



    $margs = array_merge($margs,$pargs);


    $fout = '';

    $fout.='<div class="dzs-row '.$margs['el_class'].'">'.do_shortcode($content).'</div>';



    return $fout;
  }
  function vc_fallback_vc_column($pargs='',$content=''){




    $margs = array(
      'width' => '1/1',
      'el_class' => '',
    );



    $margs = array_merge($margs,$pargs);


    $fout = '';


    preg_match("/(\d.*?)\/(\d.*?)($| )/", $margs['width'], $output_array);
//		echo 'width - '.floatval(($margs['width'])).'|';



    $col_wid_perc = (floatval(floatval($output_array[1])/floatval($output_array[2])));


//        print_rr($output_array);
//        echo 'init w - '.$margs['width'];
//        echo 'final num - '.$col_wid_perc;
//        echo 'final num css - '.($col_wid_perc * 100);

    if(is_nan($col_wid_perc)){
      $col_wid_perc = 1;
    }

    $fout.='<div class="dzs-col '.$margs['el_class'].'" style="width: '.($col_wid_perc * 100).'%">'.do_shortcode($content).'</div>';



    return $fout;
  }

  function vc_fallback_vc_column_text($pargs='',$content=''){




    $margs = array(
      'width' => '1/1',
      'el_class' => '',
    );



    $margs = array_merge($margs,$pargs);


    $fout = '';

    $fout.='<div class="dzs-text '.$margs['el_class'].'">'.do_shortcode($content).'</div>';



    return $fout;
  }

  function vc_enqueue_editor_scripts_befe(){


    wp_enqueue_style('dzs.parallaxer', $this->the_url.'dzsparallaxer/dzsparallaxer.css');
    wp_enqueue_script('dzs.parallaxer', $this->the_url.'dzsparallaxer/dzsparallaxer.js');
  }

  function admin_init() {




    add_meta_box('dzsprx_meta_options',__('DZS Parallaxer Meta'),array($this,'admin_meta_options'),'post','normal','low');
    add_meta_box('dzsprx_meta_options',__('DZS Parallaxer Meta'),array($this,'admin_meta_options'),'page','normal','low');



    if($this->db_mainoptions['capabilities_added']=='off'){

      $role = get_role( 'administrator' );

      // This only works, because it accesses the class instance.
      // would allow the author to edit others' posts for current theme only
      $role->add_cap( 'dzsprx_make_shortcode');
//            $role->remove_cap( 'upload_files' );


      $this->db_mainoptions['capabilities_added'] = 'on';
      update_option($this->dbname_mainoptions, $this->db_mainoptions);


    }
  }



  function admin_meta_options() {
    global $post;
    ?>
      <input type="hidden" name="dzsprx_nonce" value="<?php echo wp_create_nonce('dzsprx_nonce'); ?>" />
      <h4><?php _e("Fullscreen Background Parallaxer",'dzsvg'); ?></h4>
      <input class="textinput styleme" name="dzsprx_post_bg" value="<?php echo get_post_meta($post->ID,'dzsprx_post_bg',true); ?>"/> <button class="button-secondary action upload_file ">Upload</button>
      <div class="clear"></div>

      <div class="sidenote">
        <?php echo __('Try to place a parallax scrolling background. This is general and should work in most themes. But because it is theme structure dependent and there is a big variety of themes out there, it might need some css adjusting.','dzsprx'); ?><br/>
      </div>
    <?php
  }

  function admin_meta_save($post_id) {
    global $post;
    if (!$post) {
      return;
    }
    if (isset($post->post_type) && !($post->post_type == 'post' || $post->post_type == 'page')) {
      return $post_id;
    }
    /* Check autosave */
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    }
    if (isset($_REQUEST['dzsprx_nonce'])) {
      $nonce = $_REQUEST['dzsprx_nonce'];
      if (!wp_verify_nonce($nonce,'dzsprx_nonce'))
        wp_die('Security check');
    }
    if (isset($_POST['dzsprx_post_bg'])) {
      dzs_savemeta($post->ID,'dzsprx_post_bg',$_POST['dzsprx_post_bg']);
    }
  }

  function vc_dzs_add_media($settings, $value) {

    $dependency = '';

    if(function_exists('vc_generate_dependencies_attributes')){
      $dependency = vc_generate_dependencies_attributes($settings);
    }


    $fout = '';

    $fout.= '    <div class="setting setting-medium setting-three-floats">
<div class="preview-media-con-left"></div>
<div class="change-media-con">
    <button class="button-secondary dzsprx-btn-add-media"><i class="fa fa-plus-square-o"></i> Add Media</button>
</div>
<div class="setting-input type-input overflow-it">
<input style="" name="'.esc_attr($settings['param_name'])
      .'" class="wpb_vc_param_value wpb-textinput setting-field dzsprx-preview-changer '
      .$settings['param_name'].' '.$settings['type'].'_field';


    $fout.= esc_attr( $settings['param_name'] ) . ' ' .esc_attr( $settings['type'] );




    $fout.='" type="text" value="'.$value.'" ' . $dependency . '/>
</div>
<div class="clear"></div>
</div>';

    return $fout;
  }
  function vc_dzs_transition_custom($settings, $value) {

    $dependency = '';

    if(function_exists('vc_generate_dependencies_attributes')){
      $dependency = vc_generate_dependencies_attributes($settings);
    }













    $fout = '';


    $fout.='<div class="setting setting-for-transition">

                                                <h6 class="customize-control-title">'.esc_html__("Transition property",'dzsprx').'</h6>


                                                <input   name="'.esc_attr($settings['param_name'])
      .'" class="wpb_vc_param_value wpb-textinput repeater-field repeater-custom-transition-input setting-field dzsprx-preview-changer '
      .$settings['param_name'].' '.$settings['type'].'_field';


    $fout.= esc_attr( $settings['param_name'] ) . ' ' .esc_attr( $settings['type'] );




    $fout.='" type="text" value="'.$value.'" ' . $dependency . '/>';




    $fout.='<div data-property-name="left" class="bigoption dzstooltip-con fig-position selector-btn-secondary"><span class="tooltip-indicator"><span class="the-text">'.esc_html__("Left",'dzsprx').'</span></span><div class="dzstooltip talign-end arrow-right style-rounded color-dark-light"><div class="dzstooltip--inner">
                                                            <h4>'.esc_html__("Initial",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="initial" value="-100"/>
                                                            <h4>'.esc_html__("Mid",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="mid" value="0"/>
                                                            <h4>'.esc_html__("Final",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="final" value="100"/>
                                                        </div></div>

                                                </div>


                                                <div data-property-name="top" class="bigoption dzstooltip-con fig-position selector-btn-secondary"><span class="tooltip-indicator"><span class="the-text">'.esc_html__("Top",'dzsprx').'</span></span><div class="dzstooltip talign-end arrow-bottom style-rounded color-dark-light"><div class="dzstooltip--inner">
                                                            <h4>'.esc_html__("Initial",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="initial" value="-100"/>
                                                            <h4>'.esc_html__("Mid",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="mid" value="0"/>
                                                            <h4>'.esc_html__("Final",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="final" value="100"/>
                                                        </div></div>

                                                </div>


                                                <div data-property-name="scale" class="bigoption dzstooltip-con fig-position selector-btn-secondary"><span class="tooltip-indicator"><span class="the-text">'.esc_html__("Scale",'dzsprx').'</span></span><div class="dzstooltip talign-end arrow-bottom style-rounded color-dark-light"><div class="dzstooltip--inner">
                                                            <h4>'.esc_html__("Initial",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="initial" value="0.5"/>
                                                            <h4>'.esc_html__("Mid",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="mid" value="1"/>
                                                            <h4>'.esc_html__("Final",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="final" value="0.5"/>
                                                        </div></div>

                                                </div>


                                                <div data-property-name="rotate" class="bigoption dzstooltip-con fig-position selector-btn-secondary"><span class="tooltip-indicator"><span class="the-text">'.esc_html__("Rotate",'dzsprx').'</span></span><div class="dzstooltip talign-end arrow-bottom style-rounded color-dark-light"><div class="dzstooltip--inner">
                                                            <h4>'.esc_html__("Initial",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="initial" value="-100"/>
                                                            <h4>'.esc_html__("Mid",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="mid" value="0"/>
                                                            <h4>'.esc_html__("Final",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="final" value="100"/>
                                                        </div></div>

                                                </div>


                                                <div data-property-name="opacity" class="bigoption dzstooltip-con fig-position selector-btn-secondary"><span class="tooltip-indicator"><span class="the-text">'.esc_html__("Opacity",'dzsprx').'</span></span><div class="dzstooltip talign-end arrow-bottom style-rounded color-dark-light"><div class="dzstooltip--inner">
                                                            <h4>'.esc_html__("Initial",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="initial" value="0.5"/>
                                                            <h4>'.esc_html__("Mid",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="mid" value="1"/>
                                                            <h4>'.esc_html__("Final",'dzsprx').'</h4>
                                                            <input type="text" data-property_repeater_name="final" value="0.5"/>
                                                        </div></div>

                                                </div>


                                                <div class="sidenote sidenote-simple">'.esc_html__("Click the tooltip bubble to activate effect",'dzsprx').'</div>
                                            </div>';




    return $fout;
  }

  function handle_wp_head(){


    echo "<script>window.init_zoombox_settings = {
settings_zoom_doNotGoBeyond1X:'off'
,design_skin:'skin-nebula'
,settings_enableSwipe:'on'
,settings_enableSwipeOnDesktop:'off'
,settings_galleryMenu:'none'
,settings_useImageTag:'on'
,settings_disableSocial:'on'
};</script>";


    if (isset($this->db_mainoptions['extra_css']) && $this->db_mainoptions['extra_css']) {
      echo '<style>';
      echo $this->db_mainoptions['extra_css'];
      echo '</style>';
    }
  }

  function handle_wp_footer(){


    global $post;

    if($post){
      if(get_post_meta($post->ID, 'dzsprx_post_bg',true)){
        echo '<script>jQuery(document).ready(function($){
$("body").prepend(\'<div class="dzsparallaxer dzsparallaxer-bg auto-init allbody use-loading debug-target" data-options='."\\'".'{ direction: "reverse", mode_scroll: "fromtop"}'."\\'".' style="z-index: -1;"> <div class="divimage dzsparallaxer--target " style="width: 100%; height: 130%; background-image: url('.get_post_meta($post->ID, 'dzsprx_post_bg',true).')"> </div> <div class="preloader-semicircles"></div> </div>\');
}); setTimeout(function(){ dzsprx_init(".dzsparallaxer-bg"); },500);</script>';


        wp_enqueue_style('dzs.parallaxer', $this->the_url.'dzsparallaxer/dzsparallaxer.css');
        wp_enqueue_script('dzs.parallaxer', $this->the_url.'dzsparallaxer/dzsparallaxer.js');

      }
    }

    if($this->enable_scrollbar==='on'){
      echo "<script>jQuery(document).ready(function($){
window.dzsscr_init($('body'),{
'type':'scrollTop'
,'settings_skin':'skin_apple'
,enable_easing: 'on'
,settings_autoresizescrollbar: 'on'
,settings_chrome_multiplier : 0.04
})
});</script>";
    }

  }

  function post_save_mainoptions(){


    $auxarray = array();
    //parsing post data
    parse_str($_POST['postdata'],$auxarray);

    // -- this is an array of the implicit values of some vars that do not get parsed when not checked
    $auxarray23 = array(
      'enable_module_features' => 'off',
    );

    $auxarray = array_merge($auxarray23,$auxarray);

//        print_r($auxarray);

    if (isset($auxarray['use_external_uploaddir']) && $auxarray['use_external_uploaddir'] == 'on') {

      $path_uploadfile = dirname(dirname(dirname(__FILE__))).'/upload.php';
      if (file_exists($path_uploadfile) === false) {
        copy(dirname(__FILE__).'/admin/upload.php',$path_uploadfile);
      }
      $path_uploaddir = dirname(dirname(dirname(__FILE__))).'/upload';
      if (is_dir($path_uploaddir) === false) {
        mkdir($path_uploaddir,0777);
      }
    }

//        print_r($this->db_mainoptions);
    $auxarray = array_merge($this->db_mainoptions, $auxarray);

    update_option($this->dbname_mainoptions,$auxarray);
    die();
  }

  function handle_admin_menu(){

//		add_options_page('Layouter Options', 'Layouter Options', $this->admin_cap, $this->pagename_main, array($this, 'page_mainoptions'));



    $dzsprx_page = add_menu_page(__('Parallaxer Main Options','dzsprx'),__('Parallaxer','dzsprx'),$this->cap_admin,$this->pagename_mainoptions,array($this,'page_mainoptions'),'div');


//        echo $this->pagename_mainoptions;
    $dzsprx_subpage = add_submenu_page($this->pagename_mainoptions,__('Autoupdater','dzsprx'),__('Autoupdater','dzsprx'),$this->cap_admin,$this->adminpagename_autoupdater,array($this,'admin_page_autoupdater'));
  }


  function handle_admin_head(){

    if(is_admin()) {
      if ( (isset($_GET['page']) && $_GET['page'] === $this->pagename_mainoptions) || $this->include_settings==='on') {

        ?><script>
          window.init_zoombox_settings = {
            settings_disableSocial:'on'
          }
          var dzsprx_settings = {

            translate_add_parallaxer : '<?php echo __('Add Parallaxer'); ?>'
            ,translate_add_parallaxer_features : '<?php echo __('Add Parallax Features'); ?>'
            ,the_url: '<?php echo $this->the_url; ?>'
            ,siteurl: '<?php echo site_url(); ?>'
            ,shortcode_generator_url: '<?php echo admin_url('admin.php?page='.$this->pagename_mainoptions) . '&dzsprx_shortcode_builder=on'; ?>'
            ,version: "<?php echo DZSPRX_VERSION; ?>"<?php
            if($this->db_mainoptions['enable_module_features']=='on'){
            ?>
            ,enable_module_features: "<?php echo $this->db_mainoptions['enable_module_features'];?>"
            ,module_features_shortcode_generator_url: '<?php echo admin_url('admin.php?page='.$this->pagename_mainoptions) . '&dzsprx_features_builder=on'; ?>'
            <?php
            }
            ?>
          };
          </script><?php
      }

      if ( (isset($_GET['page']) && $_GET['page'] === $this->pagename_mainoptions) ){
        ?><script>
          jQuery(document).ready(function($){

            if(window.CodeMirror){
              var editor_css = null;

              try{

                editor_css = CodeMirror.fromTextArea(document.getElementById("extra_css_field"), {
                  mode: 'text/css'
                });

                editor_css.on("change",function(){
                  editor_css.save();
                })
              }catch(err){
                console.info(err);
              }
            }
          })
          </script>
        <?php
      }
    }
  }


  function page_mainoptions(){

    if(isset($_GET['dzsprx_shortcode_builder']) && $_GET['dzsprx_shortcode_builder']=='on'){
      dzsprx_shortcode_builder();




      wp_enqueue_style('dzssel', $this->base_url.'libs/dzsselector/dzsselector.css');
      wp_enqueue_script('dzssel', $this->base_url.'libs/dzsselector/dzsselector.js');
      wp_enqueue_style('dzs.dzscheckbox', $this->base_url . 'libs/dzscheckbox/dzscheckbox.css');
    }else{
      if(isset($_GET['dzsprx_features_builder']) && $_GET['dzsprx_features_builder']=='on'){
        dzsprx_shortcode_builder_for_features();
      }else{
        ?>
          <div class="wrap">
              <p>
                  <a class="zoombox button-secondary" href="<?php echo $this->the_url; ?>readme/index.html" data-bigwidth="1100" data-scaling="fill" data-bigheight="700"><?php echo __("Documentation"); ?></a>   <a href="<?php $aux =  add_query_arg( 'dzsprx_shortcode_builder', 'on', dzs_curr_url() ); $aux =  add_query_arg( 'from_mainpage', 'on', $aux ); echo $aux;  ?>" class=" button-secondary" style="" ><?php echo __("Shortcode Generator"); ?></a>
              </p>

              <h2>Main Options</h2>
              <form class="mainsettings">
                  <div class="setting">
                      <div class="setting">
                          <div class="setting-label"><?php echo __('Always Embed Scripts?','dzsprx'); ?></div>
                        <?php $lab = 'always_embed';

                        echo DZSHelpers::generate_input_text($lab,array('input_type' => 'hidden', 'val' => 'off'));
                        ?>
                          <div class="dzscheckbox skin-nova">

                            <?php

                            echo DZSHelpers::generate_input_checkbox($lab,array('id' => $lab, 'val' => 'on','seekval' => $this->db_mainoptions[$lab])); ?>
                              <label for="<?php echo $lab; ?>"></label>
                          </div>
                          <div class="sidenote"><?php echo __('by default scripts and styles from this gallery are included only when needed for optimizations reasons, but you can choose to always use them ( useful for when you are using a ajax theme that does not reload the whole page on url change )','dzsprx'); ?></div>
                      </div>
                  </div>
                  <div class="setting">
                      <div class="setting">
                          <div class="setting-label"><?php echo __('Enable Module - Features?','dzsprx'); ?></div>
                          <div class="dzscheckbox skin-nova">
                            <?php $lab = 'enable_module_features'; echo DZSHelpers::generate_input_checkbox($lab,array('id' => $lab, 'val' => 'on','seekval' => $this->db_mainoptions[$lab])); ?>
                              <label for="<?php echo $lab; ?>"></label>
                          </div>
                          <div class="sidenote"><?php echo __('this enables the Feature Module as seen here - ','dzsprx'); ?></div>
                      </div>
                  </div>

                  <div class="setting">
                      <div class="setting-label"><?php echo __('Theme Breakout Initial','dzsp'); ?></div>
                    <?php $val = '';
                    $lab = 'theme_breakout_initial';
                    if(isset($this->db_mainoptions[$lab])){
                      $val = $this->db_mainoptions[$lab];
                      $val = str_replace('"', '&quot;', $val);
                    }
                    echo DZSHelpers::generate_input_text($lab,array('val' => '','seekval' => $val, 'extraattr'=>'id=""'));
                    ?>
                      <div class="sidenote"><?php echo __('(optional / advanced) enter here the code that closes the main container of the theme you are using','dzsp'); ?></div>
                  </div>

                  <div class="setting">
                      <div class="setting-label"><?php echo __('Theme Breakout Final','dzsp'); ?></div>
                    <?php $val = '';
                    $lab = 'theme_breakout_final';
                    if(isset($this->db_mainoptions[$lab])){
                      $val = $this->db_mainoptions[$lab];
                    }
                    echo DZSHelpers::generate_input_text($lab,array('val' => '','seekval' => $val, 'extraattr'=>'id=""'));
                    ?>
                      <div class="sidenote"><?php echo __('(optional / advanced) enter here the code that opens again the main container of the theme you are using','dzsp'); ?></div>
                  </div>

                  <div class="setting">
                      <div class="setting-label"><?php echo __('Extra CSS','dzsp'); ?></div>
                    <?php $val = '';
                    $lab = 'extra_css';
                    if(isset($this->db_mainoptions[$lab])){
                      $val = $this->db_mainoptions[$lab];
                    }
                    echo DZSHelpers::generate_input_textarea($lab,array('val' => '','seekval' => $val, 'extraattr'=>'id="extra_css_field"'));
                    ?>
                      <div class="sidenote"><?php echo __('','dzsp'); ?></div>
                  </div>
                  <br/>
                  <a href='#' class="button-primary save-mainoptions"><?php echo __('Save Options','dzsprx'); ?></a>

              </form>

              <div class="saveconfirmer" style=""><img alt="" style="" id="save-ajax-loading2" src="<?php echo site_url(); ?>/wp-admin/images/wpspin_light.gif"/></div>
          </div>

        <?php
      }
    }
  }

  function import_database(){

//        print_r($_POST); print_r($_FILES);

    $file_data = file_get_contents($_FILES['dzsprx_importdb_file']['tmp_name']);
    $this->db_layouts = unserialize($file_data);
    print_r($this->db_layouts);
    update_option($this->dbname_layouts,$this->db_layouts);
  }

  function shortcode_custom_content($pargs=array(), $content = null){
    $fout = '';

//        $fout.='<div style="display:none">';
    if($content){

    }

//        $fout.='</div>';

    return $fout;
  }

  function shortcode_separator($pargs=array(), $content = null){
    $fout = '';



    $margs = array(
      'type' => 'bigcurvedline',
      'position' => 'bottom',
      'flipped' => 'off',
      'color' => '#ffffff',
    );



    $margs = array_merge($margs,$pargs);

//        $fout.='<div style="display:none">';
    if($content){


    }

    $fout.='<div class="dzsprxseparator--'.$margs['type'].' '.$margs['position'].'';


    if($margs['flipped']=='on'){
      $fout.=' flippedXY';
    }


    $fout.='" data-color="'.$margs['color'].'"></div>';

//        $fout.='</div>';

    return $fout;
  }

  function shortcode_fullslider($pargs=array(), $content = null){
    $fout = '';



    $margs = array(
      'type' => 'bigcurvedline',
    );


//        $fout.='<div style="display:none">';



    $fout.='<div  class="advancedscroller skin-regen auto-init " style="width:100%; height: '.$this->last_th.='px" data-options=\'{
            settings_mode: "onlyoneitem"
            ,settings_swipe: "off"
            ,settings_swipeOnDesktopsToo: "off"
            ,design_bulletspos: "none"
            ,settings_slideshow: "on"
            ,settings_slideshowTime: "3000"
            ,settings_autoHeight:"off"
            ,settings_transition:"flyout"
            ,settings_centeritems:false
        }\'>
        <div class="preloader-semicircles"></div>
        <ul class="items">';


    if($content){
      $fout.=do_shortcode($content);
    }

    $fout.='</ul>



    </div>';





    wp_enqueue_style('dzs.advancedscroller', $this->the_url.'advancedscroller/plugin.css');
    wp_enqueue_script('dzs.advancedscroller', $this->the_url.'advancedscroller/plugin.js');


//        $fout.='</div>';

    return $fout;
  }
  function shortcode_fullslider_item($pargs=array(), $content = null){
    $fout = '';



    $margs = array(
      'source' => '',
    );
    if($pargs && is_array($pargs)){

      $margs = array_merge($margs, $pargs);
    }



//        $fout.='<div style="display:none">';



    $fout.='<li class="item-tobe needs-loading">
<div class="imagediv" style="background-image:url('.$margs['source'].')"></div>
</li>';


    return $fout;
  }
  function shortcode_dzsprx_layer_img($pargs=array(), $content = null){
    $fout = '';

//
    $margs = array(
      'src' => '',
      'class' => '',
      'style' => '',
      'extraattr' => '',
      'parallaxanimation' => '',
    );

    if($pargs && is_array($pargs)){

      $margs = array_merge($margs, $pargs);
    }

    $fout.='<img src="'.$margs['src'].'" class="'.$margs['class'].'" style="'.$margs['style'].'" '.$margs['extraattr'].'/>';




    return $fout;
  }
  function shortcode_dzsprx_layer_div($pargs=array(), $content = null){
    $fout = '';

//
    $margs = array(
      'class' => '',
      'style' => '',
      'extraattr' => '',
      'parallaxanimation' => '',
    );

    if($pargs && is_array($pargs)){

      $margs = array_merge($margs, $pargs);
    }

    $fout.='<div  class="'.$margs['class'].'" style="'.$margs['style'].'"';

//        print_r($margs);
    if($margs['parallaxanimation']){

//            $margs['parallaxanimation'] = str_replace('"')
//            $fout.=' data-parallaxanimation="['.$margs['parallaxanimation'].']"';
      $fout.=' data-parallaxanimation=\'['.$margs['parallaxanimation'].']\'';
    }

    $fout.=''.$margs['extraattr'].'>'.do_shortcode($content).'</div>';




    return $fout;
  }


  function admin_page_autoupdater(){


    ?>
      <div class="wrap">



        <?php

        $auxarray = array();


        if(isset($_GET['dzsprx_purchase_remove_binded']) && $_GET['dzsprx_purchase_remove_binded']=='on'){

          $this->db_mainoptions['dzsprx_purchase_code_binded']='off';
          $this->db_mainoptions['dzsprx_purchase_code']='';


          update_option($this->dbname_mainoptions,$this->db_mainoptions);

        }
        //            if(isset($_POST['action']) && $_POST['action']=='dzsprx_purchase_code_disable'){
        //
        //                $this->db_mainoptions['dzsprx_purchase_code_binded']='off';
        //                $this->db_mainoptions['dzsprx_purchase_code']='';
        //
        //
        //                update_option($this->dbname_mainoptions,$this->db_mainoptions);
        //
        //            }

        if(isset($_POST['dzsprx_purchase_code'])){
          $this->db_mainoptions['dzsprx_purchase_code'] = $_POST['dzsprx_purchase_code'];
        }
        if(isset($_POST['action']) && $_POST['action']==='dzsprx_update_request'){





          if(isset($_POST['dzsprx_purchase_code'])){
            $auxarray= array('dzsprx_purchase_code' => $_POST['dzsprx_purchase_code']);
            $auxarray = array_merge($this->db_mainoptions, $auxarray);

            $this->mainoptions= $auxarray;


            update_option($this->dbname_mainoptions,$auxarray);
          }



        }

        $extra_class = '';
        $extra_attr = '';
        $form_method = "POST";
        $form_action = "";
        $disable_button = '';

        $lab = 'dzsprx_purchase_code';

        if($this->db_mainoptions['dzsprx_purchase_code_binded']=='on'){
          $extra_attr = ' disabled';
          $disable_button = ' <input type="hidden" name="purchase_code" value="'.$this->db_mainoptions[$lab].'"/><input type="hidden" name="site_url" value="'.site_url().'"/><input type="hidden" name="redirect_url" value="'.add_query_arg('dzsprx_purchase_remove_binded','on',dzs_curr_url()).'"/><button class="button-secondary" name="action" value="dzsprx_purchase_code_disable">'.__("Disable Key").'</button>';
          $form_action=' action="http://zoomthe.me/updater_dzsprx/servezip.php"';
        }





        echo '<form'.$form_action.' class="mainsettings" method="'.$form_method.'">';

        echo '
                <div class="setting">
                    <div class="label">'.__('Purchase Code','dzsprx').'</div>
                    '.DZSHelpers::generate_input_text($lab,array('val' => '','seekval' => $this->db_mainoptions[$lab],'class' => $extra_class,'extra_attr' => $extra_attr)).$disable_button.'
                    <div class="sidenote">'.__('You can <a href="https://lh5.googleusercontent.com/-o4WL83UU4RY/Unpayq3yUvI/AAAAAAAAJ_w/HJmso_FFLNQ/w786-h1179-no/puchase.jpg" target="“_blank”">find it here</a> ','dzsprx').'</div>
                </div>';


        if($this->db_mainoptions['dzsprx_purchase_code_binded']=='on'){
          echo '</form><form class="mainsettings" method="post">';
        }

        echo '<p><button class="button-primary" name="action" value="dzsprx_update_request">'.__("Update").'</button></p>';

        if(isset($_POST['action']) && $_POST['action']==='dzsprx_update_request'){



//            echo 'ceva';


//            die();



          $aux = 'http://zoomthe.me/updater_dzsprx/servezip.php?purchase_code='.$this->db_mainoptions['dzsprx_purchase_code'].'&site_url='.site_url();
          $res = DZSHelpers::get_contents($aux);

//            echo 'hmm'; echo strpos($res,'<div class="error">'); echo 'dada'; echo $res;
          if($res===false){
            echo 'server offline';
          }else{
            if(strpos($res,'<div class="error">')===0){
              echo $res;


              if(strpos($res,'<div class="error">error: in progress')===0){

                $this->db_mainoptions['dzsprx_purchase_code_binded']='on';
                update_option($this->dbname_mainoptions,$this->db_mainoptions);
              }
            }else{




//                        $url = wp_nonce_url('admin.php?page=dzsprx-autoupdater',$this->adminpagename_autoupdater);
//                        if (false === ($creds = request_filesystem_credentials($url, '', false, false, null) ) ) {
//                            return; // stop processing here
//                        }
//
//                        if ( ! WP_Filesystem($creds) ) {
//                            request_filesystem_credentials($url, '', true, false, null);
//                            return;
//                        }
//
//                        global $wp_filesystem;
//                        $wp_filesystem->put_contents(
//                            dirname(__FILE__).'/update.zip',
//                            'Example contents of a file',
//                            FS_CHMOD_FILE // predefined mode settings for WP files
//                        );
//
//
//                        if(class_exists('ZipArchive')) {
//                            $zip = new ZipArchive;
//                            $res = $zip->open(dirname(__FILE__) . '/update.zip');
//                            //test
//                            if ($res === TRUE) {
////                echo 'ok';
//                                $zip->extractTo(dirname(__FILE__));
//                                $zip->close();
//
//
//                                $this->db_mainoptions['dzsprx_purchase_code_binded'] = 'on';
//                                update_option($this->dbname_mainoptions, $this->db_mainoptions);
//
//
//                            } else {
//                                echo 'failed, code:' . $res;
//                            }
//                            echo __('Update done.');
//                        }else {
//
//                            echo 'error - '. __('no ZipArchive support on the server');
//                        }

              $aux = file_put_contents(dirname(__FILE__).'/update.zip', $res);

              if($aux) {
                if (class_exists('ZipArchive')) {
                  $zip = new ZipArchive;
                  $res = $zip->open(dirname(__FILE__) . '/update.zip');
                  //test
                  if ($res === TRUE) {
//                echo 'ok';
                    $zip->extractTo(dirname(__FILE__));
                    $zip->close();


                    $this->db_mainoptions['dzsprx_purchase_code_binded'] = 'on';
                    update_option($this->dbname_mainoptions, $this->db_mainoptions);


                  } else {
                    echo 'failed, code:' . $res;
                  }
                  echo __('Update done.');
                } else {

                  echo __('ZipArchive class not found.');
                }
              }else{

                echo 'error - '. __('permission denied on server');
              }



            }
          }
        }





        ?>
          </form>
      </div>
    <?php
  }


  function shortcode_layer($pargs=array(), $content = ''){




    $margs = array(
      'media_type' => 'image',
      'media_html' => '',
      'media' => '',
      'video_media' => '',
      'parallax_content_type' => 'image',
      'extra_classes' => '',
      'type' => 'detect',
      'clip_width' => '',
      'box_type' => '',
      'total_width' => '',
      'layers' => '',
      'clip_height' => '400',
      'total_height' => '150%',
      'direction' => 'reverse',

      'enable_scrollbar' => 'off',
      'breakout' => 'off',
      'enable_layers' => 'off',
      'scroll_axis_x' => 'off',
      'scroll_axis_y' => 'on',
      'use_loading' => 'on',
      'animation_duration' => '',
      'height_is_based_on_content' => 'off',
      'responsive_reference_width' => '',
      'responsive_optimal_height' => '',
      'call_from' => 'vc',
    );

    if($pargs && is_array($pargs)){

      $margs = array_merge($margs, $pargs);
    }





    $fout = '';

    $parallax_animation_arr = array();


//	    echo 'layers $margs - '; print_rr($margs);


    $margs['media_html']=str_replace('{{qq}}','"',$margs['media_html']);

    include_once('class_parts/parse_layers.php');
    dzsprx_parse_layer($parallax_animation_arr, $margs);

//		                print_rr($parallax_animation_arr);

    $pos = strtolower(str_replace(' ','-',$margs['position']));
    $fout.='<div class="parallax-layer position-'.$pos.'" >';
    $fout.='<div class="parallax-layer--inner" data-parallaxanimation=\''.json_encode($parallax_animation_arr).'\'>';

    if($margs['media_type']=='image'){

      if($margs['media']){
        $fout.='<img class="parallax-layer--media parallax-layer--media-type-'.$margs['media_type'].'" src="'.$margs['media'].'"/>';
      }
    }


    if($margs['media_type']=='html'){

      $fout.='<div class="parallax-layer--media parallax-layer--media-type-'.$margs['media_type'].'" >'.html_entity_decode($margs['media_html']).'</div>';

    }

    if($content){
      $fout.=do_shortcode($content);
    }
    $fout.='</div>';
    $fout.='</div>';

    return $fout;

  }
  function shortcode_main($pargs=array(), $content = ''){

    $fout = '';


    wp_enqueue_style('dzs.parallaxer', $this->the_url.'dzsparallaxer/dzsparallaxer.css');
    wp_enqueue_script('dzs.parallaxer', $this->the_url.'dzsparallaxer/dzsparallaxer.js');

    $margs = array(
      'media' => '',
      'video_media' => '',
      'parallax_content_type' => 'image',
      'extra_classes' => '',
      'type' => 'detect',
      'clip_width' => '',
      'box_type' => '',
      'total_width' => '',
      'layers' => '',
      'clip_height' => '400',
      'total_height' => '150%',
      'direction' => 'normal',
      'mode' => 'normal',
      'settings_mode' => '',
      'enable_scrollbar' => 'off',
      'settings_movexaftermouse' => 'off',
      'breakout' => 'off',
      'enable_layers' => 'off',
      'scroll_axis_x' => 'off',
      'scroll_axis_y' => 'on',
      'use_loading' => 'on',
      'animation_duration' => '',
      'settings_mode_oneelement_max_offset' => '50',
      'height_is_based_on_content' => 'off',
      'responsive_reference_width' => '',
      'responsive_optimal_height' => '',
      'disable_effect_on_mobile' => 'off',
    );

    if($pargs && is_array($pargs)){

      $margs = array_merge($margs, $pargs);
    }


    if($margs['mode']){
      if($margs['settings_mode']==''){
        $margs['settings_mode']=$margs['mode'];
      }
    }


//	    echo 'margs -7'; print_rr($margs);

    $shortcode_index = $this->layout_index;

    $this->last_th = $margs['total_height'];


    if($margs['height_is_based_on_content']=='on'){
      $margs['clip_height'] = 'auto';
    }
    if($margs['settings_mode']=='oneelement'){
      $margs['clip_height'] = 'auto';
    }

//        print_r($margs);
//        print_r($margs['type']);
    /*
     *
     * <div class="" data-options='{   direction: "reverse"}' style="height: 350px;">

        <div class="divimage dzsparallaxer--target " style="width: 101%; height: 600px; background-image: url(img/imgbig1.jpg)">
        </div>
     */


    if($margs['settings_mode']=='oneelement'){
      $margs['use_loading']='off';
    }

    if($margs['enable_scrollbar']==='on'){

      wp_enqueue_script('scroller', $this->the_url . 'dzsscroller/scroller.js');
      wp_enqueue_style('scroller', $this->the_url . 'dzsscroller/scroller.css');
      $this->enable_scrollbar='on';
    }


    $type = $margs['type'];
    $source = $margs['media'];

    if($margs['parallax_content_type']=='video'){

      $type = 'video';
      $source = $margs['video_media'];
    }


//        echo ' source - '.$source;
//        echo ' $type - '.$type;

    if($type==='detect' || $type=='video'){


      if(strpos($source,'.mp4')!==false  || strpos($source,'.m4a')!==false){

        $type='video';

        $content='[dzsprx_custom_content]<div class="vplayer-tobe start-muted auto-init skin_noskin" data-source="'.$source.'" data-loop="on" style="height: 100%;" data-options=\'{"autoplay": "on" }\'></div>[/dzsprx_custom_content]'.$content;


        wp_enqueue_script('dzsvg', $this->the_url . 'libs/videogallery/vplayer.js');
        wp_enqueue_style('dzsvg', $this->the_url . 'libs/videogallery/vplayer.css');
      }





      if(strpos($source,'youtube.com')!==false  || strpos($source,'https://youtu.be/IyIlqsan_EA')!==false){

        $type='video';

        $content='[dzsprx_custom_content]<div class="vplayer-tobe start-muted  auto-init skin_noskin" data-source="'.$source.'" data-loop="on" style="height: 100%;" data-options=\'{"autoplay": "on" }\'></div>[/dzsprx_custom_content]'.$content;


        wp_enqueue_script('dzsvg', $this->the_url . 'libs/videogallery/vplayer.js');
        wp_enqueue_style('dzsvg', $this->the_url . 'libs/videogallery/vplayer.css');
      }




      if(strpos($source,'vimeo.com')!==false){

        $type='video';

        $content='[dzsprx_custom_content]<div class="vplayer-tobe start-muted  auto-init skin_noskin" data-source="'.$source.'" data-loop="on" style="height: 100%;" data-options=\'{"autoplay": "on" }\'></div>[/dzsprx_custom_content]'.$content;


        wp_enqueue_script('dzsvg', $this->the_url . 'libs/videogallery/vplayer.js');
        wp_enqueue_style('dzsvg', $this->the_url . 'libs/videogallery/vplayer.css');
      }
    }

//        echo ' source - '.$source;

    if($type==='detect'){
      $type = 'image';
    }





    $str_h = '';

    if($margs['clip_height']){
      $str_h = ' height: '.DZSHelpers::transform_to_str_size($margs['clip_height']).';';
    }
    $str_th = '';

    if($margs['total_height']){
      $str_th = ' height: '.DZSHelpers::transform_to_str_size($margs['total_height']).';';
    }
    $str_w = '';

    if($margs['clip_width']){
      $str_w = ' width: '.DZSHelpers::transform_to_str_size($margs['clip_width']).';';
    }
    $str_tw = '';

//	    print_rr($margs);
    if($margs['total_width']){
      $str_tw = ' width: '.DZSHelpers::transform_to_str_size($margs['total_width']).';';
    }

//	    echo '$str_tw - '.$str_tw;





    if($margs['settings_mode']=='simple'){
      $str_th = '';
    }



    if($margs['breakout']=='1'){
      $fout.='</div>';
    }
    if($margs['breakout']=='2'){
      $fout.='</div></div>';
    }
    if($margs['breakout']=='3'){
      $fout.='</div></div></div>';
    }


    if($margs['breakout']=='themebreakout'){
      $fout.=$this->db_mainoptions['theme_breakout_initial'];
    }

    $fout.='<div class="dzsparallaxer dzsparallaxer'.$shortcode_index.' auto-init';

    if($margs['use_loading']==='on'){
      $fout.=' use-loading';
    }

    if($margs['settings_mode']==='simple'){
      $fout.=' simple-parallax';
    }

    if($margs['height_is_based_on_content']=='on'){
      $fout.=' height-is-based-on-content';
    }


    if($margs['settings_mode']=='oneelement'){
      if($margs['box_type']){
        $fout.=' '.$margs['box_type'];
      }
    }

    $fout.=' '.strip_tags($margs['extra_classes']);


    if($margs['clip_height']=='auto'){
      $fout.=' do-not-set-js-height';
    }

    $fout.='"  data-options=\'{"direction": "'.$margs['direction'].'"';

    if($margs['settings_mode']){



      if($margs['settings_mode']!='normal' && $margs['settings_mode']!='oneelement' && $margs['settings_mode']!='mouse_body'){
        $fout.=',"mode_scroll":"'. $margs['settings_mode'].'"';
      }

      if($margs['settings_mode']=='oneelement' || $margs['settings_mode']=='horizontal' || $margs['settings_mode']=='mouse_body'){
        $fout.=',"settings_mode": "'.$margs['settings_mode'].'"';
      }

      if($margs['settings_mode']=='oneelement'|| $margs['settings_mode']=='simple'){
        $fout.=',"settings_mode_oneelement_max_offset": "'.$margs['settings_mode_oneelement_max_offset'].'"';
      }
    }
    if($margs['breakout'] && $margs['breakout']=='trybreakout'){
      $fout.=',"js_breakout":"on"';
    }
    if($margs['breakout'] && $margs['breakout']=='trybreakout'){
      $fout.=',"js_breakout":"on"';
    }

    $lab = 'settings_movexaftermouse';
    if($margs[$lab] && $margs[$lab]=='on'){
      $fout.=',"'.$lab.'":"'.$margs[$lab].'"';
    }
    if($margs['disable_effect_on_mobile'] && $margs['disable_effect_on_mobile']=='on'){
      $fout.=',"disable_effect_on_mobile":"'.$margs['disable_effect_on_mobile'].'"';
    }
    if($margs['animation_duration']){
      $fout.=',"animation_duration":"'.$margs['animation_duration'].'"';
    }
    $fout.=',"scroll_axis_x":"'.$margs['scroll_axis_x'].'"';
    $fout.=',"scroll_axis_y":"'.$margs['scroll_axis_y'].'"';





    $fout.='}\' data-parallax_content_type="'.$margs['parallax_content_type'].'" style="'.$str_h.''.$str_w.''.'"';




    if($margs['responsive_reference_width']){
      $fout.=' data-responsive-reference-width="'.$margs['responsive_reference_width'].'"';
    }
    if($margs['responsive_optimal_height']){
      $fout.=' data-responsive-optimal-height="'.$margs['responsive_optimal_height'].'"';
    }


    $fout.='>';



    if($margs['settings_mode']=='oneelement'){
      $fout.='<div>';
    }


    if($margs['settings_mode']!='oneelement'){
      if($content && strpos($content, '[dzsprx_custom_content]')!==false){

//            echo 'we found custom content - '. $content.' <-- ..';

        preg_match_all('/\[dzsprx_custom_content\](.*?)\[\/dzsprx_custom_content\]/s',$content, $aux_a);


//            print_r($aux_a);
        if($aux_a[1]){
          $fout.='<div class="dzsparallaxer--target " style="'.$str_tw.'; '.$str_th.'">'.do_shortcode($aux_a[1][0]).'</div>';
        }


      }else{
        if($type=='image'){




          if($margs['parallax_content_type']=='gmaps'){
            $fout.='<div class=" dzsparallaxer--target " style="'.$str_tw.'; '.$str_th.'; ">
            <div class="actual-map" id="map'.$shortcode_index.'" style="width: 100%; height: 100%; position:absolute; top:0; left:0;" data-lat="'.$margs['gmaps_lat'].'" data-long="'.$margs['gmaps_long'].'"></div>
        </div>';


            wp_enqueue_script('gmaps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCHzgISxOH6cTLGCqBtVV0DNd5xvGjU208');
          }else{

            $fout.='<div class="divimage dzsparallaxer--target "';

            if($margs['use_loading']=='on'){
              $fout.=' data-src="'.$source.'"';
            }

            $fout.='style="'.$str_tw.'; '.$str_th;


            if($margs['use_loading']!='on'){
              $fout.=' background-image:url('.$source.');';
            }

            $fout.='"></div>';
          }
        }
      }
    }




    if($margs['use_loading']=='on') {
      $fout .= '<div class="preloader-semicircles"></div>';
    }



    if($margs['enable_layers']=='on'){

      include_once('class_parts/parse_layers.php');


      $layers_str = $margs['layers'];

      $layers_str = str_replace('{patratstart}','[',$layers_str);
      $layers_str = str_replace('{patratend}',']',$layers_str);

      $parallax_animation_arr = array();




//	        echo 'ceva';

//	        $layers_str = str_replace('"','{quotquot}',$layers_str);
      $layers_str = str_replace(array("\r", "\n"),'',$layers_str);
//            echo ' $layers_str - ('.$layers_str.')';

      try{

        $layers = json_decode($layers_str, true);

//	            print_rr($layers);



        if(is_array($layers)){
          foreach ($layers as $layer){





//		                dzsprx_parse_layer($parallax_animation_arr, $layer);
//		                print_rr($layer);

//		                print_rr($parallax_animation_arr);

//		                $pos = str_replace(' ','-',$layer['position']);
//		                $fout.='<div class="parallax-layer position-'.$pos.'" >';
//		                $fout.='<div class="parallax-layer--inner" data-parallaxanimation=\''.json_encode($parallax_animation_arr).'\'>';
//		                if($layer['media']){
//			                $fout.='<img class="parallax-layer--media" src="'.$layer['media'].'"/>';
//		                }
//
//
//
//
//
//
//
//		                $fout.='</div>';
//		                $fout.='</div>';


            $layer['call_from']='normal_editor';

            $fout.=$this->shortcode_layer($layer);




          }

        }
      }catch(Exception $e){
        error_log("cannot decode ".$layers_str);
      }


    }
    if($content){


      $content = str_replace('"</p>','"',$content);
      $content = str_replace('<p>"','"',$content);
//            $content = str_replace('"','{{qq}}',$content);






      // -- for vc but we don't need this

      /*
  $content = preg_replace("/media_html=\"([\S|\s]*?)\"\]/m", "media_html='$1']", $content);


  preg_match_all("/media_html=\'([\S|\s]*?)\'\]/m", $content, $output_array);

//		    print_rr($output_array);

//		    echo '$content - (('.$content.'))';

      if(isset($output_array[1][0])){

        $inter_media_html =$output_array[1][0];
        $inter_media_html = str_replace(array("\r", "\n"),'',$inter_media_html);

        $content = preg_replace("/media_html=\'([\S|\s]*?)\'\]/m", "media_html='$inter_media_html']", $content);

//	            echo '$content - (('.$content.'))';
      }
      */

      $fout.='<div class="parallaxer-content">'.do_shortcode($content).'</div>';
    }


    if($margs['settings_mode']=='oneelement'){


      $fout.='</div>';
    }





    $fout.='</div>';


    if($margs['breakout']=='1'){
      $fout.='<div>';
    }
    if($margs['breakout']=='2'){
      $fout.='<div><div>';
    }
    if($margs['breakout']=='3'){
      $fout.='<div><div><div>';
    }


    if($margs['breakout']=='themebreakout'){
      $fout.=$this->db_mainoptions['theme_breakout_final'];
    }




    $this->layout_index++;
    return $fout;


  }


  function shortcode_row_start($pargs=array(), $content = ''){

    $fout = '';


    wp_enqueue_style('dzs.parallaxer', $this->the_url.'dzsparallaxer/dzsparallaxer.css');
    wp_enqueue_script('dzs.parallaxer', $this->the_url.'dzsparallaxer/dzsparallaxer.js');

    $margs = array(
      'media' => '',
      'type' => 'detect',
      'clip_height' => '400',
      'total_height' => '130%',
      'direction' => 'reverse',
      'mode' => 'normal',
      'settings_mode' => '',
      'enable_scrollbar' => 'off',
      'breakout' => 'off',
      'use_loading' => 'on',
      'responsive_reference_width' => '',
      'responsive_optimal_height' => '',
      'extra_classes' => '',
    );

    if($pargs && is_array($pargs)){

      $margs = array_merge($margs, $pargs);
    }


    if($margs['mode']){
      if($margs['settings_mode']==''){
        $margs['settings_mode']=$margs['mode'];
      }
    }

    $this->last_th = $margs['total_height'];


    $margs['height_is_based_on_content']='on';
    if($margs['height_is_based_on_content']=='on'){
      $margs['clip_height'] = 'auto';
    }

//        print_r($margs);
//        print_r($margs['type']);
    /*
     *
     * <div class="" data-options='{   direction: "reverse"}' style="height: 350px;">

        <div class="divimage dzsparallaxer--target " style="width: 101%; height: 600px; background-image: url(img/imgbig1.jpg)">
        </div>
     */

    if($margs['enable_scrollbar']==='on'){

      wp_enqueue_script('scroller', $this->the_url . 'dzsscroller/scroller.js');
      wp_enqueue_style('scroller', $this->the_url . 'dzsscroller/scroller.css');
      $this->enable_scrollbar='on';
    }


    if($margs['type']==='detect'){
      $margs['type'] = 'image';
    }





    $str_h = '';



    if($margs['height_is_based_on_content']!='on') {
      if ( $margs['clip_height'] ) {
        $str_h = ' height: ' . DZSHelpers::transform_to_str_size( $margs['clip_height'] ) . ';';
      }
    }


    $str_th = '';

    if($margs['total_height']){
      $str_th = ' height: '.DZSHelpers::transform_to_str_size($margs['total_height']).';';
    }

    if($margs['settings_mode']=='simple'){
      $str_th = '';
    }


    $fout.='<div class="dzsparallaxer dzsparallaxer-row-start dzsparallaxer'.$this->layout_index.' auto-init';

    if($margs['use_loading']==='on'){
      $fout.=' use-loading';
    }

    if($margs['settings_mode']==='simple'){
      $fout.=' simple-parallax';
    }

    if($margs['extra_classes']){
      $fout.=' '.$margs['extra_classes'];
    }

    if($margs['height_is_based_on_content']=='on'){
      $fout.=' height-is-based-on-content';
    }


    if($margs['settings_mode']=='oneelement'){
      if($margs['box_type']){
        $fout.=' '.$margs['box_type'];
      }
    }

    $fout.=' '.strip_tags($margs['extra_classes']);


    if($margs['clip_height']=='auto'){
      $fout.=' do-not-set-js-height';
    }

    $fout.='"  data-options=\'{"direction": "'.$margs['direction'].'"';

    if($margs['settings_mode']){



      if($margs['settings_mode']!='normal' && $margs['settings_mode']!='oneelement'){

        $fout.=',"mode_scroll":"'. $margs['settings_mode'].'"';
      }
      if($margs['settings_mode']=='oneelement'){
        $fout.=',"settings_mode": "oneelement"';
      }
      if($margs['settings_mode']=='oneelement'|| $margs['settings_mode']=='simple'){
        $fout.=',"settings_mode_oneelement_max_offset": "'.$margs['settings_mode_oneelement_max_offset'].'"';
      }
    }
    if($margs['breakout'] && $margs['breakout']=='trybreakout'){
      $fout.=',"js_breakout":"on"';
    }



    $fout.='}\' style="'.$str_h.'"';




    if($margs['responsive_reference_width']){
      $fout.=' data-responsive-reference-width="'.$margs['responsive_reference_width'].'"';
    }
    if($margs['responsive_optimal_height']){
      $fout.=' data-responsive-optimal-height="'.$margs['responsive_optimal_height'].'"';
    }


    $fout.='>';


    if($content && strpos($content, '[dzsprx_custom_content]')!==false){

//            echo 'we found custom content - '. $content.' <-- ..';

      preg_match_all('/\[dzsprx_custom_content\](.*?)\[\/dzsprx_custom_content\]/s',$content, $aux_a);


//            print_r($aux_a);
      if($aux_a[1]){
        $fout.='<div class="dzsparallaxer--target " style="width: 100%; '.$str_th.'">'.do_shortcode($aux_a[1][0]).'</div>';
      }


    }else{
      if($margs['type']=='image'){
        $fout.='<div class="divimage dzsparallaxer--target "';

        if($margs['use_loading']=='on'){
          $fout.=' data-src="'.$margs['media'].'"';
        }

        $fout.='style="width: 100%; '.$str_th;


        if($margs['use_loading']!='on'){
          $fout.=' background-image:url('.$margs['media'].');';
        }

        $fout.='"></div>';
      }
    }





    $this->layout_index++;
    return $fout;


  }


  function shortcode_row_end($pargs=array(), $content = ''){

    $fout = '';


    $fout.='</div>';



    return $fout;


  }


  function module_features_shortcode_main($pargs=array(), $content = null){

    $fout = '';


    wp_enqueue_style('dzs.parallaxer.features', $this->the_url.'dzsparallaxer/dzsprx_module_parallax_features.css');
    wp_enqueue_script('dzs.parallaxer.features', $this->the_url.'dzsparallaxer/dzsprx_module_parallax_features.js');

    $margs = array(
      'media' => '',
      'type' => 'detect',
      'clip_height' => '400',
      'total_height' => '600',
      'direction' => 'reverse',


      'enable_scrollbar' => 'off',
      'breakout' => 'off',
      'use_loading' => 'on',
    );

    if($pargs && is_array($pargs)){

      $margs = array_merge($margs, $pargs);
    }

    $str_breakout = 'off';

    if($margs['breakout']=='trybreakout'){
      $str_breakout = 'on';
    }
    if($margs['breakout']=='themebreakout'){
      $fout.=$this->db_mainoptions['theme_breakout_initial'];
    }

    $fout.='<div class=" dzsparallaxer-features auto-init" data-options=\'{"js_breakout":"'.$str_breakout.'"}\'>';
    $fout .= do_shortcode($content);
    $fout.='<div class="dzsprx-features-container">

            <div class="dzs-colcontainer">





            </div>

        </div>
        </div>';


    if($margs['breakout']=='themebreakout'){
      $fout.=$this->db_mainoptions['theme_breakout_final'];
    }

    return $fout;


  }
  function module_features_shortcode_img($pargs=array(), $content = null){

    $fout = '';
    $margs = array(
      'media' => '',
      'type' => 'detect',
      'clip_height' => '400',
      'total_height' => '600',
      'direction' => 'reverse',

      'enable_scrollbar' => 'off',
      'breakout' => 'off',
      'use_loading' => 'on',
    );

    if($pargs && is_array($pargs)){

      $margs = array_merge($margs, $pargs);
    }


    $fout = '<img class="fullwidth feat-img " src="'.$content.'"/>';
    return $fout;


  }
  function module_features_shortcode_html($pargs=array(), $content = null){

    $fout = '';

    $margs = array(
      'media' => '',
      'type' => 'detect',
      'clip_height' => '400',
      'total_height' => '600',
      'direction' => 'reverse',

      'enable_scrollbar' => 'off',
      'breakout' => 'off',
      'use_loading' => 'on',
    );

    if($pargs && is_array($pargs)){

      $margs = array_merge($margs, $pargs);
    }


    $fout = '<div class="desc-block">'.do_shortcode($content).'</div>';
    return $fout;


  }


}

