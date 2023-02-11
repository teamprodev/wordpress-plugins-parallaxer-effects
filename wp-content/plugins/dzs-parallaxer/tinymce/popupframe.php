<?php
// some total cache vars that needs to be like this

function dzsprx_shortcode_builder(){


  global $dzsprx;

//    print_r($dzsprx->db_layouts);



  ?>

  <style>.setting #wp-content-editor-tools{ padding-top: 0; } body .sidenote{ color: #777777; }</style>
  <div class="wpdzsprx-sel" style="display: none;">
    <?php if(isset($_GET['sel'])){
      $aux = str_replace(array("\r","\r\n","\n"),'',$_GET['sel']);
      $aux = str_replace("'",'"',$aux);


      $aux = stripslashes($aux);
      $aux = preg_replace("/ layers=\"(.*?)\"]/", "layers='$1'", $aux);

      echo $aux;
    }else{
      ?>
      <?php
    }


    ?>
  </div>
  <div class="wrap wrap-for-dzsprx-shortcode-builder">
  <h3><?php echo __("Parallaxer Shortcode Generator"); ?></h3>
  <hr>



  <?php


  //            print_r($dzsprx->options_array_parallax);


  /*
   *
   * [dzs_parallaxer media="http://localhost:8888/wordpress/wp-content/uploads/revslider/clean-news-slider/nature3.jpg" parallax_content_type="gmaps" gmaps_lat="test" gmaps_long="" clip_height="400" total_height="150%" direction="normal" use_loading="on" mode="normal" height_is_based_on_content="off" enable_layers="on" layers='{patratstart}{"title":"Title","media":"","position":"center center","layer_transition_in":"fade-in","layer_transition_out":"slide-out","layer_transition_custom":"eyJsZWZ0Ijp7ImluaXRpYWwiOiItNSIsIm1pZCI6IjAiLCJmaW5hbCI6IjUifSwidG9wIjp7ImluaXRpYWwiOiItMTIxIiwibWlkIjoiMCIsImZpbmFsIjoiMTUwIn0sInJvdGF0ZSI6eyJpbml0aWFsIjoiLTEwMCIsIm1pZCI6IjAiLCJmaW5hbCI6IjEwMCJ9LCJvcGFjaXR5Ijp7ImluaXRpYWwiOiIwLjUiLCJtaWQiOiIxIiwiZmluYWwiOiIwLjUifX0="}{patratend}']test[/dzs_parallaxer]


  $ilab = 0;
  $options_array = array();
  foreach($dzsprx->options_array_parallax as $lab => $opt){

//                $options_array[$ilab] = array(
//                    'type'=>$opt['type'],
//                    'param_name'=>$lab,
//                    'heading' => $opt['title'],
////            'context' => $opt['context'],
//                );
//
//                if(isset($opt['type'])){
//                    $options_array[$ilab]['type'] = $opt['type'];
//                    if($opt['type']=='select'){
//                        $options_array[$ilab]['type'] = 'dropdown';
//                    }
//                    if($opt['type']=='text'){
//                        $options_array[$ilab]['type'] = 'textfield';
//                    }
//                    if($opt['type']=='image'){
//                        $options_array[$ilab]['type'] = 'attach_image';
//                    }
//                    if($opt['type']=='upload'){
//                        $options_array[$ilab]['type'] = 'dzs_add_media_att';
//                    }
//                }
//                if(isset($opt['sidenote'])){
//                    $options_array[$ilab]['description'] = $opt['sidenote'];
//                }
//                if(isset($opt['holder'])){
//                    $options_array[$ilab]['holder'] = $opt['holder'];
//                }
//                if(isset($opt['default'])){
//                    $options_array[$ilab]['std'] = $opt['default'];
//                    $options_array[$ilab]['default'] = $opt['default'];
//                }
//                if(isset($opt['options'])){
//                    $options_array[$ilab]['value'] = $opt['options'];
//                }
//
//                if(isset($opt['library_type'])){
//                    $options_array[$ilab]['library_type'] = $opt['library_type'];
//                }
//
//                if(isset($opt['class'])){
//                    $options_array[$ilab]['class'] = $opt['class'];
//                }


      ?>
      <div class="setting setting-medium setting-three-floats">
          <div class="setting-label"><?php echo $opt['title']; ?></div>


          <div class="preview-media-con-left"></div>
          <div class="change-media-con">
              <button class="button-secondary btn-add-media"><i class="fa fa-plus-square-o"></i> <?php echo __(" Add Media"); ?></button>
          </div>
          <div class="setting-input type-input overflow-it">

              <input class="setting-field dzsprx-preview-changer" type="<?php echo $lab; ?>" name="media"/>
          </div>
          <div class="clear"></div>
      </div>

      <?php




      $ilab++;
  }

  */

  ?>

  <div class="dzs-row">
    <div class="dzs-col-md-12">
      <select class="dzs-style-me  opener-listbuttons option-display-block skin-btn-secondary repeater-field dzs-dependency-field " name="parallax_content_type">
        <option value="image"></option>
        <option value="video"></option>
        <option value="gmaps"></option>

      </select>
      <ul class="dzs-style-me-feeder">

        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text"><?php echo esc_html__("Image",'dzsprx'); ?></span></li>
        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text"><?php echo esc_html__("Video",'dzsprx'); ?></span></li>
        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text"><?php echo esc_html__("Google maps",'dzsprx'); ?></span></li>

      </ul>
    </div>
  </div>

  <div class="dzs-row">
    <div class="dzs-col-md-6">

      <?php
      $dependency = array(

        array(
          'label'=>'parallax_content_type',
          'value'=>array('image'),
        ),
      );

      ?>
      <div class="setting  big-preview" data-dependency='<?php echo json_encode($dependency); ?>'>



        <div class="preview-media-con-left">
          <div class="preview-media-overlay preview-media-overlay-top"></div>
          <div class="preview-media-overlay preview-media-overlay-bottom"></div>
        </div>
        <div class="change-media-con">
        </div>
        <div class="setting-input type-input overlay-upload-buttons">

          <input class="setting-field dzsprx-preview-changer" type="text" name="media"/>
          <button class="button-secondary btn-add-media"><i class="fa fa-plus-square-o"></i><?php echo __(" Add Media"); ?></button>
        </div>
        <div class="clear"></div>
      </div>




      <?php
      $dependency = array(

        array(
          'label'=>'parallax_content_type',
          'value'=>array('video'),
        ),
      );

      ?>


      <div class="setting  " data-dependency='<?php echo json_encode($dependency); ?>'>



        <div class="setting-input type-input setting-three-floats">

          <input class="setting-field dzsprx-preview-changer" type="text" name="video_media"/>
          <button class="button-secondary btn-add-media"><i class="fa fa-external-link"></i> <?php echo esc_html__("Add Media",'dzsprx'); ?></button>

        </div>
        <div class="sidenote sidenote-simple"><?php echo esc_html__("Add Media",'dzsprx'); ?></div>
        <div class="clear"></div>
      </div>




      <?php
      $dependency = array(

        array(
          'label'=>'parallax_content_type',
          'value'=>array('gmaps'),
        ),
      );

      ?>



      <div class="setting  " data-dependency='<?php echo json_encode($dependency); ?>'>



        <div class="setting-input type-input ">

          <div class="setting-label"><?php echo esc_html__("Latitude",'dzsprx'); ?></div>

          <input class="setting-field " type="text" name="gmaps_lat"/>
        </div>
        <div class="clear"></div>
      </div>

      <div class="setting  " data-dependency='<?php echo json_encode($dependency); ?>'>



        <div class="setting-input type-input ">

          <div class="setting-label"><?php echo esc_html__("Longitude",'dzsprx'); ?></div>

          <input class="setting-field " type="text" name="gmaps_long"/>
        </div>
        <div class="clear"></div>
      </div>



    </div>
    <div class="dzs-col-md-6">
      <div class="setting">

        <?php
        $lab = 'enable_layers';
        //		                echo DZSHelpers::generate_input_text($lab, array('id' => $lab, 'val' => 'off', 'class' => 'fake-input', 'input_type' => 'hidden'));
        ?>
        <h4 class="setting-label"><?php echo __('Enable Layers', 'dzsprx'); ?></h4>
        <div class="dzscheckbox skin-nova">
          <?php
          echo DZSHelpers::generate_input_checkbox($lab, array('id' => $lab, 'val' => 'on', 'class' => 'dzs-dependency-field', 'seekval' => 'off')); ?>
          <label for="<?php echo $lab; ?>"></label>
        </div>

      </div>


      <?php





      // -- for future we can do a logical set like "(" .. ")" .. "AND" .. "OR"
      $dependency = array(

        array(
          'label'=>'enable_layers',
          'value'=>array('on'),
        ),
      );


      ?>
      <div class="setting" data-dependency='<?php echo json_encode($dependency); ?>'>

        <input type="text" class="disabled repeater-con-target" name="layers" id=" " value='' size="20"/>
        <div class="repeater-main-con">
          <div class="repeaters-con">
            <div class="repeater-con active repeater-con-for-clone">

              <div class="repeater-con--header">

                <div class="table-row">
                  <div class="table-cell-full toggle-active">
                    <div class="the-title"><?php echo __("Title",'antfarm'); ?></div>
                  </div>

                  <div class="table-cell-right">
                    <div class="repeater-btn delete-btn">
                      <i aria-hidden="true"  class="fa fa-times"></i>
                    </div>
                    <div class="repeater-btn move-btn">
                      <i aria-hidden="true"  class="fa fa-arrows-v"></i>
                    </div>
                  </div>
                </div>



              </div>

              <div class="repeater-con--body">

                <div class="dzs-row dzs-row-inline align-items-top">
                  <div class="dzs-col-md-6">
                    <div class="setting">

                      <h6><span class="customize-control-title"><?php echo __("Title",'dzsprx'); ?></span></h6>
                      <input type="text" class="repeater-field" value=""  data-repeater_name="title" />
                    </div>
                  </div>
                  <div class="dzs-col-md-6">

                    <div class="setting">

                      <h6><span class="customize-control-title"><?php echo __("Media type",'dzsprx'); ?></span></h6>

                      <div class="setting-input type-input setting-three-floats ">

                        <select class="dzs-style-me-clone  opener-listbuttons option-display-block skin-btn-secondary repeater-field dzs-dependency-field " data-repeater_name="media_type">
                          <option value="image"></option>
                          <option value="html"></option>

                        </select>
                        <ul class="dzs-style-me-feeder">

                          <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Image</span></li>
                          <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Html</span></li>

                        </ul>
                      </div>

                    </div>

                    <?php

                    $dependency = array(

                      array(
                        'label'=>'media_type',
                        'value'=>array('html'),
                      ),
                    );
                    ?>
                    <div class="setting check-parent3" data-custom-label-to-check-for-dependency="data-repeater_name" data-dependency='<?php echo json_encode($dependency); ?>'>

                      <h6><span class="customize-control-title"><?php echo __("Media html",'dzsprx'); ?></span></h6>

                      <div class="setting-input type-input setting-three-floats  "  >

                        <textarea rows="3" class="media-html-input setting-field repeater-field "  type="text" data-repeater_name="media_html"></textarea>
                      </div>

                    </div>

                    <?php

                    $dependency = array(

                      array
                      (
                        'label'=>'media_type',
                        'value'=>array('image'),
                      ),
                    )
                    ;
                    ?>

                    <div class="setting check-parent3" data-custom-label-to-check-for-dependency="data-repeater_name" data-dependency='<?php echo json_encode($dependency); ?>'>

                      <h6><span class="customize-control-title"><?php echo __("Media",'dzsprx'); ?></span></h6>

                      <div class="setting-input type-input setting-three-floats ">

                        <input class="setting-field repeater-field " type="text" data-repeater_name="media"/>
                        <button class="button-secondary btn-add-media"><i class="fa fa-external-link"></i><?php echo __(" Add"); ?></button>
                      </div>

                    </div>
                  </div>
                </div>




                <!--                                    <div class="setting">-->
                <!--                                        <h6><span class="customize-control-title">--><?php //echo __("Link",'antfarm'); ?><!--</span></h6>-->
                <!--                                        <input type="text" class="repeater-field" value=""   />-->
                <!--                                    </div>-->


                <div class="dzs-row dzs-row-inline align-items-top">
                  <div class="dzs-col-md-6">

                    <div class="setting">
                      <h6 class="customize-control-title"><?php echo __("Position",'antfarm'); ?></h6>

                      <div style="max-width: 200px">
                        <select class="repeater-field  opener-listbuttons option-display-block skin-gamma " name="the_layout_3" data-repeater_name="position">
                          <option value="top left"></option>
                          <option value="top center"></option>
                          <option value="top right"></option>
                          <option value="center left"></option>
                          <option value="center center"></option>
                          <option value="center right"></option>
                          <option value="bottom left"></option>
                          <option value="bottom center"></option>
                          <option value="bottom right"></option>
                        </select>
                        <ul class="dzs-style-me-feeder">

                          <li class="bigoption fig-position"><figure class="fig-position--inner"><span class="the-text">TL</span></figure></li>
                          <li class="bigoption fig-position"><figure class="fig-position--inner"><span class="the-text">TC</span></figure></li>
                          <li class="bigoption fig-position"><figure class="fig-position--inner"><span class="the-text">TR</span></figure></li>

                          <li class="bigoption fig-position"><figure class="fig-position--inner"><span class="the-text">CL</span></figure></li>
                          <li class="bigoption fig-position"><figure class="fig-position--inner"><span class="the-text">CC</span></figure></li>
                          <li class="bigoption fig-position"><figure class="fig-position--inner"><span class="the-text">CR</span></figure></li>

                          <li class="bigoption fig-position"><figure class="fig-position--inner"><span class="the-text">BL</span></figure></li>
                          <li class="bigoption fig-position"><figure class="fig-position--inner"><span class="the-text">BC</span></figure></li>
                          <li class="bigoption fig-position"><figure class="fig-position--inner"><span class="the-text">BR</span></figure></li>

                        </ul>

                      </div>
                    </div>
                  </div>
                  <div class="dzs-col-md-6">

                    <div class="setting setting-deprecated">

                      <h6 class="customize-control-title"><?php echo __("Transition in",'dzsprx'); ?></h6>


                      <select class="dzs-style-me-clone  opener-listbuttons option-display-block skin-btn-secondary repeater-field " data-repeater_name="layer_transition_in">
                        <option value="fade-in"></option>
                        <option value="slide-in"></option>
                        <option value="fade-slide-in"></option>
                        <option value="rotate-in"></option>
                        <option value="scale-in"></option>

                      </select>
                      <ul class="dzs-style-me-feeder">

                        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Fade in </span></li>
                        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Slide in</span></li>
                        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Slide and Fade in</span></li>
                        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Rotate in</span></li>

                        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Scale in</span></li>

                      </ul>
                    </div>

                    <style>.setting-deprecated{display: none; }</style>
                    <div class="setting setting-deprecated">

                      <h6 class="customize-control-title"><?php echo __("Transition out",'antfarm'); ?></h6>


                      <select class="dzs-style-me-clone  opener-listbuttons option-display-block skin-btn-secondary repeater-field " data-repeater_name="layer_transition_out">
                        <option value="fade-out"></option>
                        <option value="slide-out"></option>
                        <option value="fade-slide-out"></option>
                        <option value="rotate-out"></option>
                        <option value="scale-out"></option>

                      </select>
                      <ul class="dzs-style-me-feeder">

                        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Fade out </span></li>
                        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Slide out</span></li>
                        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Slide and Fade out</span></li>
                        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Rotate out</span></li>

                        <li class="bigoption fig-position selector-btn-secondary"><span class="the-text">Scale out</span></li>

                      </ul>
                    </div>

                    <div class="setting setting-for-transition">

                      <h6 class="customize-control-title"><?php echo esc_html__("Transition property",'dzsprx'); ?></h6>


                      <input class=" repeater-field repeater-custom-transition-input" type="text" data-repeater_name="layer_transition_custom"/>
                      <div data-property-name="left" class="bigoption dzstooltip-con fig-position selector-btn-secondary"><span class="tooltip-indicator"><span class="the-text"><?php echo esc_html__("Left",'dzsprx'); ?></span></span><div class="dzstooltip talign-end arrow-right style-rounded color-dark-light"><div class="dzstooltip--inner">
                            <h4><?php echo esc_html__("Initial",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="initial" value="-100"/>
                            <h4><?php echo esc_html__("Mid",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="mid" value="0"/>
                            <h4><?php echo esc_html__("Final",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="final" value="100"/>
                          </div></div>

                      </div>


                      <div data-property-name="top" class="bigoption dzstooltip-con fig-position selector-btn-secondary"><span class="tooltip-indicator"><span class="the-text"><?php echo esc_html__("Top",'dzsprx'); ?></span></span><div class="dzstooltip talign-end arrow-bottom style-rounded color-dark-light"><div class="dzstooltip--inner">
                            <h4><?php echo esc_html__("Initial",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="initial" value="-100"/>
                            <h4><?php echo esc_html__("Mid",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="mid" value="0"/>
                            <h4><?php echo esc_html__("Final",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="final" value="100"/>
                          </div></div>

                      </div>


                      <div data-property-name="scale" class="bigoption dzstooltip-con fig-position selector-btn-secondary"><span class="tooltip-indicator"><span class="the-text"><?php echo esc_html__("Scale",'dzsprx'); ?></span></span><div class="dzstooltip talign-end arrow-bottom style-rounded color-dark-light"><div class="dzstooltip--inner">
                            <h4><?php echo esc_html__("Initial",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="initial" value="0.5"/>
                            <h4><?php echo esc_html__("Mid",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="mid" value="1"/>
                            <h4><?php echo esc_html__("Final",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="final" value="0.5"/>
                          </div></div>

                      </div>


                      <div data-property-name="rotate" class="bigoption dzstooltip-con fig-position selector-btn-secondary"><span class="tooltip-indicator"><span class="the-text"><?php echo esc_html__("Rotate",'dzsprx'); ?></span></span><div class="dzstooltip talign-end arrow-bottom style-rounded color-dark-light"><div class="dzstooltip--inner">
                            <h4><?php echo esc_html__("Initial",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="initial" value="-100"/>
                            <h4><?php echo esc_html__("Mid",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="mid" value="0"/>
                            <h4><?php echo esc_html__("Final",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="final" value="100"/>
                          </div></div>

                      </div>


                      <div data-property-name="opacity" class="bigoption dzstooltip-con fig-position selector-btn-secondary"><span class="tooltip-indicator"><span class="the-text"><?php echo esc_html__("Opacity",'dzsprx'); ?></span></span><div class="dzstooltip talign-end arrow-bottom style-rounded color-dark-light"><div class="dzstooltip--inner">
                            <h4><?php echo esc_html__("Initial",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="initial" value="0.5"/>
                            <h4><?php echo esc_html__("Mid",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="mid" value="1"/>
                            <h4><?php echo esc_html__("Final",'dzsprx'); ?></h4>
                            <input type="text" data-property_repeater_name="final" value="0.5"/>
                          </div></div>

                      </div>


                      <div class="sidenote sidenote-simple"><?php echo esc_html__("Click the tooltip bubble to activate effect",'dzsprx'); ?></div>
                    </div>
                  </div>
                </div>


              </div>

            </div>
          </div>


          <p><button class="btn-add-repeater-field button-secondary" href="#"><?php echo __("Add New",'antfarm'); ?></button></p>
        </div>
      </div>
    </div>
  </div>


  <div class="dzspb_lay_con">
    <div class="dzspb_layb_one_third">


      <div class="setting">
        <div class="setting-label"><?php echo __("Mode"); ?></div>
        <select class="dzs-style-me skin-beige dzs-dependency-field" name="settings_mode">
          <option value="normal"><?php echo __("Normal"); ?></option>
          <option value="fromtop"><?php echo __("From Top"); ?></option>
          <option value="simple"><?php echo __("Simple"); ?></option>
          <option value="mouse_body"><?php echo __("Follow Mouse"); ?></option>
          <option value="oneelement"><?php echo __("One Element"); ?></option>
          <option value="horizontal"><?php echo __("Horizontal loop"); ?></option>
        </select>
        <div class="sidenote  sidenote-show-on-setting-hover"><?php echo __('select the parallaxer mode');     echo '<br><br>'; echo sprintf('<strong>%s</strong> - %s',__("Normal"), __("normal custom height image parallaxing based on scroll"));              echo '<br>'; echo sprintf('<strong>%s</strong> - %s',__("From Top"), __("ideal for images that start from the absolute top of the page"));        echo '<br>';
          echo sprintf('<strong>%s</strong> - %s',__("Simple"), __("this will render a full size background parallax image , note that it s great for fullwidth / big parallax blocks, not for small images"));       echo '<br>';
          echo sprintf('<strong>%s</strong> - %s',__("Follow mouse"), __("follow the mouse instead of the scroll position"));       echo '<br>';
          echo sprintf('<strong>%s</strong> - %s',__("One Element"), __("this will discard the background image used and scroll only the content inside / can be text"));        ?></div>
      </div>

      <div class="setting mode-oneelement">
        <div class="setting-label"><?php echo __("Box Type"); ?></div>
        <select class="dzs-style-me skin-beige" name="box_type">
          <option value=""><?php echo __("Normal"); ?></option>
          <option value="dark-grey-box"><?php echo __("Dark Grey Box"); ?></option>
          <option value="darker-grey-box"><?php echo __("Darker Grey Box"); ?></option>
          <option value="light-grey-box"><?php echo __("Light Grey Box"); ?></option>
          <option value="lighter-grey-box"><?php echo __("Lighter Grey Box"); ?></option>
          <option value="white-white-box"><?php echo __("White Box"); ?></option>
        </select>
        <div class="sidenote  sidenote-show-on-setting-hover"><?php echo __('you can select a box type for the content inside');        ?></div>
      </div>

      <?php
      $dependency = array(
        array(
          'lab'=>'settings_mode',
          'val'=>array('mouse_body'),
        ),
      );
      ?>

      <div class="setting" data-dependency='<?php echo json_encode($dependency); ?>'>
        <div class="setting-label"><?php echo __("Move horizontal after mouse"); ?></div>
        <select class="dzs-style-me skin-beige dzs-dependency-field" name="settings_movexaftermouse">
          <option value="off"><?php echo __("Off"); ?></option>
          <option value="on"><?php echo __("On"); ?></option>
        </select>
        <div class="sidenote sidenote-show-on-setting-hover"><?php echo wp_kses(sprintf(__("you will need a total width higher then clip width like %s",'dzsprx'),
            '<strong>120%</strong>'
          ),$dzsprx->allowed_tags); ?></div>
      </div>

      <div class="setting">
        <div class="setting-label"><?php echo __("Adapt to Content Height"); ?></div>
        <select class="dzs-style-me skin-beige dzs-dependency-field" name="height_is_based_on_content">
          <option value="off"><?php echo __("Off"); ?></option>
          <option value="on"><?php echo __("On"); ?></option>
        </select>
        <div class="sidenote  sidenote-show-on-setting-hover"><?php
          echo __('the ultimate responsive mode. the parallaxer will be used as a background to your custom content inside the shortcode');
          ?></div>
      </div>
      <div class="setting">
        <div class="setting-label"><?php echo __('Lazy Loading'); ?></div>
        <select class="dzs-style-me skin-beige" name="use_loading">
          <option value="on"><?php echo __("On"); ?></option>
          <option value="off"><?php echo __("Off"); ?></option>
        </select>
        <div class="sidenote  sidenote-show-on-setting-hover"><?php echo __('enable or disable lazy loading ( loading only when the image gets scrolled in view )'); ?></div>
      </div>

      <div class="setting">
        <div class="setting-label"><?php echo __('Direction'); ?></div>
        <select class="dzs-style-me skin-beige" name="direction">
          <option value="normal"><?php echo __("Normal"); ?></option>
          <option value="reverse"><?php echo __("Reverse"); ?></option>
        </select>
        <div class="sidenote  sidenote-show-on-setting-hover"><?php echo __('select the direction of scroll'); ?></div>
      </div>


      <br>


    </div>
    <div class="dzspb_layb_one_third">
      <div class="setting">
        <div class="setting-label"><?php echo __("Enable Easing Scrollbar"); ?></div>
        <select class="dzs-style-me skin-beige" name="enable_scrollbar">
          <option value="off"><?php echo __("Off"); ?></option>
          <option value="on"><?php echo __("On"); ?></option>
        </select>
        <div class="sidenote  sidenote-show-on-setting-hover"><?php echo __('enable dzs scroller to ease the scrolling on this page'); ?></div>
      </div>
      <div class="setting">
        <div class="setting-label"><?php echo __('Break out of container');?></div>
        <select class="dzs-style-me skin-beige" name="breakout">
          <option value="off"><?php echo __("Off"); ?></option>
          <option value="trybreakout"><?php echo __("Javascript Breakout"); ?></option>
          <?php

          if($dzsprx->db_mainoptions['theme_breakout_initial']) {
            echo '<option value="themebreakout">' . __("Theme Breakout") . '</option>';
          }
          ?>
          <!--                    <option value="1">--><?php //echo __("Break out of 1 container"); ?><!--</option>-->
          <!--                    <option value="2">--><?php //echo __("Break out of 2 containers"); ?><!--</option>-->
          <!--                    <option value="3">--><?php //echo __("Break out of 3 containers"); ?><!--</option>-->
          <!--                    <option value="4">--><?php //echo __("Break out of 4 containers"); ?><!--</option>-->
          <!--                    <option value="5">--><?php //echo __("Break out of 5 containers"); ?><!--</option>-->
          <!--                    <option value="6">--><?php //echo __("Break out of 6 containers"); ?><!--</option>-->
          <!--                    <option value="7">--><?php //echo __("Break out of 7 containers"); ?><!--</option>-->
          <!--                    <option value="8">--><?php //echo __("Break out of 8 containers"); ?><!--</option>-->
        </select>
        <div class="sidenote  sidenote-show-on-setting-hover"><?php echo __("break out of container to display a full width parallaxer / theme breakout requirse setup in Parallaxer menu"); ?></div>
      </div>

      <div class="setting">
        <div class="setting-label"><?php echo __('Parallax Horizontally'); ?></div>
        <select class="dzs-style-me skin-beige" name="scroll_axis_x">
          <option value="off"><?php echo __("Disable"); ?></option>
          <option value="on"><?php echo __("Enable"); ?></option>
        </select>
        <div class="sidenote  sidenote-show-on-setting-hover"><?php echo __('select where or not the parallax effect is horizontal'); ?></div>
      </div>

      <div class="setting">
        <div class="setting-label"><?php echo __('Parallax Vertically'); ?></div>
        <select class="dzs-style-me skin-beige" name="scroll_axis_y">
          <option value="off"><?php echo __("Disable"); ?></option>
          <option value="on" selected><?php echo __("Enable"); ?></option>
        </select>
        <div class="sidenote  sidenote-show-on-setting-hover"><?php echo __('select where or not the parallax effect is horizontal'); ?></div>
      </div>



      <div class="setting mode-oneelement mode-simple">
        <div class="setting-label"><?php echo __("Scroll Offset"); ?></div>
        <?php echo DZSHelpers::generate_input_text('settings_mode_oneelement_max_offset', array(
          'seekval'=>'30'
        )); ?>
        <div class="sidenote  sidenote-show-on-setting-hover"><?php
          echo __('the scroll offset');
          ?></div>
      </div>
    </div>

    <div class="dzspb_layb_one_third">


      <?php



      // -- for future we can do a logical set like "(" .. ")" .. "AND" .. "OR"
      $dependency = array(
        array(
          'lab'=>'height_is_based_on_content',
          'val'=>array('off'),
        ),
      );

      ?>

      <div class=" dzstoggle skin-default content-must-be-visible active toggle1" >

        <div class="toggle-title" style=""><?php echo __('Dimensions Options'); ?></div>
        <div class="toggle-content" style="height: auto; margin: 15px 0;">


          <div class="dzspb_lay_con">
            <div class="dzspb_layb_one_half">
              <div class="setting" data-dependency='<?php echo json_encode($dependency); ?>'>
                <div class="setting-label"><?php echo esc_html__('Clip Height', 'dzsprx'); ?></div>
                <input class="input-dimension" type="text" name="clip_height" value="400"/>
                <div class="sidenote sidenote-show-on-setting-hover"><?php echo __('insert this size in pixels or in percent ( 100% )'); ?></div>
              </div>

              <div class="setting">
                <div class="setting-label"><?php echo __("Total Height"); ?></div>
                <input class="input-dimension" type="text" name="total_height" value="150%"/>
                <div class="sidenote  sidenote-show-on-setting-hover"><?php echo sprintf(__('this is the total height of the container, it should be bigger then the clip height in order to make space for the parallax effect. You can also place values like %s which means %s height of the clip container'),'<strong>150%</strong>','<strong>1.5x</strong>'); ?></div>
              </div>
            </div>
            <div class="dzspb_layb_one_half">
              <div class="setting" data-dependency='<?php echo json_encode($dependency); ?>'>
                <div class="setting-label"><?php echo __('Clip Width'); ?></div>
                <input type="text" name="clip_width" value="100%"/>
                <div class="sidenote sidenote-show-on-setting-hover"><?php echo __('insert this size in pixels or in percent ( 100% )'); ?></div>
              </div>

              <div class="setting">
                <div class="setting-label"><?php echo __("Total Width"); ?></div>
                <input type="text" name="total_width" value="100%"/>
                <div class="sidenote  sidenote-show-on-setting-hover"><?php echo sprintf(__('this is the total height of the container, it should be bigger then the clip height in order to make space for the parallax effect. You can also place values like %s which means %s height of the clip container'),'<strong>150%</strong>','<strong>1.5x</strong>'); ?></div>
              </div>
            </div>
          </div>




          <br>
        </div>
      </div>

      <br>

      <?php

      ?>

      <div class=" dzstoggle toggle1" data-dependency='<?php echo json_encode($dependency); ?>'>

        <div class="toggle-title" style=""><?php echo __('Responsive Options'); ?></div>
        <div class="toggle-content">

          <h4><?php echo __('Reference Width'); ?></h4>

          <div class="setting setting-small">
            <input class="setting-field " type="text" name="responsive_reference_width"/>
          </div>

          <h4><?php echo __('Reference Height'); ?></h4>

          <div class="setting setting-small">
            <input class="setting-field " type="text" name="responsive_optimal_height"/>
          </div>



          <div class="setting setting-small">
            <div class="setting-label"><?php echo __('Disable effect on mobile'); ?></div>
            <select class="dzs-style-me skin-beige setting-field" name="disable_effect_on_mobile">
              <option value="off"><?php echo __("Default"); ?></option>
              <option value="on"><?php echo __("Disable on mobile"); ?></option>
            </select>
            <div class="sidenote  sidenote-show-on-setting-hover"><?php echo __('select where or not the parallax effect is horizontal'); ?></div>
          </div>

          <div class="sidenote  " style="margin-top: 20px;"><?php echo __('If you want your parallaxer to scale responsively, you need to set a refence width and height. For example a container with a reference width of <strong>1000</strong> and a refence height of <strong>500</strong> will have, at a 500px mobile resolution, an actual height of 250. And at a 250px mobile resolution, an actual height of 125px.'); ?></div>


          <br>
        </div>
      </div>

    </div>
  </div>


  <div class="setting">
    <div class="setting-label"><?php echo __("Content"); ?></div>
    <?php wp_editor('','content'); ?>
    <p><button class="button-secondary" onclick='window.insert_to_wp_tinymce(("<div class=\"big-text center-it\">This is some optional overlay text.</div>" )); return false;'>Add Big Centered Text</button> <button class="button-secondary" onclick='window.insert_to_wp_tinymce(("<div class=\"semi-black-overlay\"></div>" )); return false;'>Add Semi Black Overlay</button>
      <button class="button-secondary" onclick='window.insert_to_wp_tinymce("[dzsprx_separator type=\"bigcurvedline\"]" ); return false;'>Add Separator</button>
      <button class="button-secondary" onclick='window.insert_team_module(); return false;'>Add Team Module</button></p>
    <div class="sidenote  ">you can add some overlay html to the parallaxer here ( in the Text editor ) like:
      <ul>
        <li>&lt;div class=&quot;semi-black-overlay&quot;&gt;&lt;/div&gt; - for a black gradient overlay</li>
        <li>&lt;div class=&quot;big-text center-it&quot;&gt;This is some optional overlay text.&lt;/div&gt; - for some centered big text</li>
      </ul>
      or any custom html </div>
  </div>
  <div class="setting hide-on-mode-oneelement">
    <div class="setting-label"><?php echo __('Enable Custom Content','dzsprx'); ?></div>
    <div class="dzscheckbox skin-nova">
      <?php $lab = 'enable_custom_content'; echo DZSHelpers::generate_input_checkbox($lab,array('id' => $lab, 'val' => 'on')); ?>
      <label for="<?php echo $lab; ?>"></label>
    </div>
    <div class="sidenote  sidenote-show-on-setting-hover"><?php echo __('you can have custom content scrolled by parallaxer','dzsprx'); ?></div>
  </div>



  <div class="setting the-custom-content" style="display: none;">
    <div class="setting-label">Custom Content</div>
    <?php wp_editor('','custom_content', array(
      'tinymce'=>false,
      'teeny'=>true,
      'textarea_rows'=>4,
      'editor_height'=>200,
    )); ?>
  </div>
  <div class="setting">
    <div class="setting-label"><?php echo __("Extra Classes"); ?></div>
    <?php echo DZSHelpers::generate_input_text('extra_classes', array(

    )); ?>
    <div class="sidenote  sidenote-show-on-setting-hover"><?php
      echo __('some extra classes you can use to style the parallaxer');
      ?></div>
  </div>


  <?php
  $lab = 'dzsprx_notice_sample_data';

  $notice_sample_data = get_option($lab);

  if($notice_sample_data=='seen'){


  ?>
  <div class="setting dzstoggle toggle1 ">

    <div class="toggle-title" style=""><?php echo __('Sample Data'); ?></div>
    <?php
    }else{

    ?>

    <span class="" style="color: #cb1919;"></span>

    <div class="setting content-must-be-visible dzstoggle toggle1 active ">

      <div class="toggle-title dzstooltip-con  js for-hover" style=""><span class="tooltip-indicator"><?php echo __('Sample Data'); ?></span><span class="dzstooltip arrow-bottom talign-start active" style=""><?php echo __("Did you know you can import sample data from the demo with one click ?")?> <a href="#" class="hide-notice" data-notice="<?php echo $lab; ?>"><?php echo __("hide"); ?></a></span></div>
      <?php
      }


      ?>


      <div class="toggle-content">

        <div class="sidenote  sidenote-show-on-setting-hover" style="font-size:14px;"><?php echo __('Import any of these examples with one click. ','dzsprx'); ?></div>

        <div class="dzs-container">
          <div class="one-fourth ">
            <div class="feat-sample-con  import-sample import-sample-1">

              <img class="feat-sample " src="<?php echo $dzsprx->the_url; ?>img/sample_1.png"/>
              <h4><?php echo __("Sample Layers"); ?></h4>
            </div>
          </div>
          <div class="one-fourth ">
            <div class="feat-sample-con  import-sample import-sample-2">

              <img class="feat-sample " src="https://lh3.googleusercontent.com/fkHrcyaKs4QQzoeY_6zrYHvTZmr00LRdoWfKEaO4EaUhozR64tjI2g4BoR-rVcGw56Mba867wCs=w2560-h1440-rw-no"/>
              <h4><?php echo __("Heading Left"); ?></h4>
            </div>
          </div>
          <div class="one-fourth ">
            <div class="feat-sample-con  import-sample import-sample-3">

              <img class="feat-sample " src="https://lh3.googleusercontent.com/Ce8kVLG7Nl7Hf-Oh9evXp0hOxcuR8xIXXSmf_WRTHicLKllb564fFkuqvFnIZR81EfA34LBpZzE=w2560-h1440-rw-no"/>
              <h4><?php echo __("Parallax Slider"); ?></h4>
            </div>
          </div>
          <div class="one-fourth ">
            <div class="feat-sample-con  import-sample import-sample-4">

              <img class="feat-sample " src="https://lh3.googleusercontent.com/ZCGJXcRrkvQa2qiL5m1dAQ5erkvdmvISyC4lEc4yzeYWXPs8hg4nn9LqFaw44VgCfKV_WF8VuLDr-IGd4aLPUFdy4IDJDZr958ELy1sdHGpwF70LAKZPx5s_g9_MVkyp3q8I_jA5vMNOeLFJPeJfJaqzRKQlrl11jj2Jb5rUQgELdqfRfswvJBWL-Ob4MwJHXdsoxr9PaLCOnK4eRlILQKJSqHHY2q7MDbi99s81msY3wR9YEhVTNOnmDPsJuNi0ZNndVELYWRGNg9k0_zZicUrgKaYy-I6RKbdDd3jPBh9m23xQVi0aMuhZHcjPortx999Z6xvWzFJo9ppJqcC7sIjQLxSmrl68c0PNmkuCBgCR3EQCJifJqNFXQmAwOHKSusd0lpY4_tfXBJEpceZU-DsMP6eSLf0gifhjpp9QbEfwozoYjKS1Ll52KkH-Pfyt2z2G-8ROvBgqdVGzzmtTCOyc1bAUOwX2ths9a9Ut57H5rLgPyjL2sG-gg1x1juKRpNVjGUUG9hMc19h6jUhHUxK8IWsAiPC9AMtgsnLnAnMA6KmEuR8029HcxrQqMXPZjTSW9K8S3B2L7yaNRfD31Cxm9lKR61WugR_7eGaCVzA=w320-h180-no"/>

              <h4><?php echo __("Team Fullwidth"); ?></h4>
            </div>
          </div>
        </div>
        <div class="dzs-row">
          <div></div>
        </div>
        <div class="dzs-container">
          <div class="one-fourth ">
            <div class="feat-sample-con  import-sample import-sample-5">

              <!--                                <img class="feat-sample " src="https://lh3.googleusercontent.com/aqN00BwiyIRIIY9l0BF2R0fsGQoIBm_9Lo0U9n5EzSdVDKH20la-lP6PAtTJUdllyo-GFsSeAx2U31nFmk59eRcaswBcQxvMN9LD1FTOdlCuXEyN6sTuGjmoYVZ3FH6oiDH_W2FAQO33Dt1SihyeZupEci1S5QfJVLwKQjJW6spHYekRNaI2Ldcwqb-65FPcJSkYSltvFIdijeZCeUObb8r-i53U94Mfjy593B5nqThSXFje1gLQ9aWZceL7F86BlikefryoSSi09BnDaNPMZ_FbGryWGbaHCftTvnav0TiI7va_9HtXKBkJ3u7MhNUxb9EQSxKV9-d4xT1fZBYmHGTFX42GAti7csKLXfySOXsWrf0pK91ebb0YOHYCksDTgh-y0npUR33LbckU1JY3UeKL4WQtBothqNKhy3x47njHQh6AEmLVEpRErLd-_h-QpT69UvXMEqE40sl4mSVvZXN8WiF9cqEqHE9nI99_N8St4UL9L8KmW-XhW3C8kdV4uginC9sZnAWPLHAsobH8Kmsvb_g_Nc-OrXoQT56f7o8mYXYiVrTxyl0Cr_nprnAQe_S2ShCPM7LRdmMOX7rPVqzpHM97qWnNCwIQ4pOtq3U=w320-h180-no"/>-->

              <div class="model-box">

                <iframe src='https://gfycat.com/ifr/ScarceBreakableHoopoe' frameborder='0' scrolling='no' width='100%' height='100%' style="" allowfullscreen></iframe>
              </div>


              <h4><?php echo __("Text Oneelement"); ?></h4>
            </div>
          </div>

        </div>

        <br>
      </div>
    </div>

    <br>
    <br>
    <button class="button-primary btn-insert-shortcode"><?php echo esc_html__("Insert shortcode",'dzsprx'); ?></button>

    <br>
    <div class="shortcode-output"></div>
  </div>
  <?php
}