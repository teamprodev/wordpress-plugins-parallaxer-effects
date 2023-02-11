<?php
// some total cache vars that needs to be like this

function dzsprx_shortcode_builder_for_features(){


    global $dzsprx;

//    print_r($dzsprx->db_layouts);

?>

    <style>.setting #wp-content-editor-tools{ padding-top: 0; } body .sidenote{ color: #777777; } .update-nag{display: none; } #wpfooter{ margin-left:10px; }</style>
    <script>
    <?php if(isset($_GET['sel'])){
    $aux = str_replace(array("\r","\r\n","\n"),'',$_GET['sel']);
    $aux = str_replace("'",'"',$aux);
    echo 'window.dzsprx_sel = \''.stripslashes($aux).'\'';
    }?>
    </script>
        <div class="wrap wrap-for-module-features">
            <h3>Parallaxer Module - Features Generator</h3>
            <hr>

            <div class="setting">
                <div class="setting-label"><?php echo __('Break out of container');?></div>
                <select class="styleme" name="breakout">
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
                <div class="sidenote">break out of container to display a full width parallaxer</div>
            </div>
            <div class="setting ">
                <div class="feature-items-con">

                    <div class="items-con">

<!--                        <div class="ui-state-highlight"></div>-->




<!--                        <div class="feature-item dzstoggle toggle1">-->
<!---->
<!--                            <div class="toggle-title" style="">Item&nbsp;&nbsp;<i class="sortable-handler fa fa-th-large"></i></div>-->
<!--                            <div class="toggle-content">-->
<!---->
<!--                                <h4>Media</h4>-->
<!---->
<!--                                <div class="setting setting-medium setting-three-floats">-->
<!--                                    <div class="preview-media-con-left"></div>-->
<!--                                    <div class="change-media-con">-->
<!--                                        <button class="button-secondary btn-add-media"><i class="fa fa-plus-square-o"></i> Add Media</button>-->
<!--                                    </div>-->
<!--                                    <div class="setting-input type-input overflow-it">-->
<!---->
<!--                                        <input class="setting-field dzsprx-preview-changer feature-item--media" type="text" name=""/>-->
<!--                                    </div>-->
<!--                                    <div class="clear"></div>-->
<!--                                </div>-->
<!---->
<!---->
<!--                                <h4>Text</h4>-->
<!--                                <textarea class="feature-item--textarea"></textarea>-->
<!--                            </div>-->
<!--                        </div>-->


                    </div>

                    <button class="button-secondary btn-add-item"><i class="fa fa-plus-square-o"></i> Add Item</button>

                </div>
            </div>








            <br>
            <br>
            <button class="button-primary btn-insert-shortcode">Insert Shortcode</button>

            <br>
            <textarea class="shortcode-output"></textarea>
        </div>
<?php
}