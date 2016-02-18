<?php

//******************************************
//
//	Shipme theme- theme started on aug 2015
//	www.sitemile.com
//
//******************************************

function shipme_theme_my_account_profile_settings_new() {

    ob_start();
    $c = 0;
    $c1 = 0;
    global $current_user;
    get_currentuserinfo();
    $uid = $current_user->ID;
    ?>
    <div class="container_ship_ttl_wrap">	
        <div class="container_ship_ttl">
            <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
                <?php _e('Profile Settings', 'shipme') ?>
            </div>

            <?php
            if (function_exists('bcn_display')) {
                echo '<div class="my_box3 no_padding  breadcrumb-wrap col-xs-12 col-sm-12 col-lg-12"><div class="padd10">';
                bcn_display();
                echo '</div></div>';
            }
            ?>	

        </div>
    </div>

    <?php
    do_action('shipme_account_at_top');
    ?>

    <div class="container_ship_no_bk">

        <?php echo shipme_get_users_links(); 
        
        ?>

        <div class="account-content-area col-xs-12 col-sm-8 col-lg-9">


            <?php
            if (isset($_POST['save-info'])) {

//                echo '<pre>';
//                print_r($_POST);
//              //  exit;

                $personal_info = strip_tags(nl2br($_POST['personal_info']), '<br />');
                update_user_meta($uid, 'personal_info', substr($personal_info, 0, 500));

                update_user_meta($uid, 'user_location', $_POST['job_location_cat']);



                if (isset($_POST['password'])) {


                    if (!empty($_POST['password'])):
                        $p1 = trim($_POST['password']);
                        $p2 = trim($_POST['reppassword']);

                        if ($p1 == $p2) {

                            global $wpdb;
                            $newp = md5($p1);
                            $sq = "update " . $wpdb->prefix . "users set user_pass='$newp' where ID='$uid'";
                            $wpdb->query($sq);
                        } else
                            echo '<div class="error">' . __('Password was not changed. It does not match the password confirmation.', 'shipme') . '</div>';
                    endif;
                }
                if (isset($_POST['email_id'])) {
                    $email_id = $_POST['email_id'];
                    if (filter_var($email_id, FILTER_VALIDATE_EMAIL) === false && $email_id != '') {
                        echo '<div class="error">' . __('In valid Email ID', 'shipme') . '</div>';
                    } else {
                        wp_update_user(array('ID' => $uid, 'user_email' => $email_id));
                    }
                }

                if (isset($_POST['con_address'])) {
                    update_user_meta($uid, 'con_address', $_POST['con_address']);
                }

                if (isset($_POST['tra_office_address'])) {
                    update_user_meta($uid, 'tra_office_address', $_POST['tra_office_address']);
                }
                if ($_POST['tra_office_address']=='') {
                    update_user_meta($uid, 'tra_office_address', $_POST['tra_office_address']);
                }

                if (isset($_POST['tra_preffered_address'])) {
                    update_user_meta($uid, 'tra_preffered_address', $_POST['tra_preffered_address']);
                }
                if ($_POST['tra_preffered_address']=='') {
                    update_user_meta($uid, 'tra_preffered_address', $_POST['tra_preffered_address']);
                }
                if (isset($_POST['off_address_lat'])) {
                    update_user_meta($uid, 'off_address_lat', $_POST['off_address_lat']);
                }
                if (isset($_POST['off_address_lng'])) {
                    update_user_meta($uid, 'off_address_lat', $_POST['off_address_lng']);
                }
                if ($_POST['off_address_lat']=='') {
                    update_user_meta($uid, 'off_address_lat', $_POST['off_address_lat']);
                }
                if ($_POST['off_address_lng']=='') {
                    update_user_meta($uid, 'off_address_lat', $_POST['off_address_lng']);
                }


                $personal_info = trim($_POST['paypal_email']);
                update_user_meta($uid, 'paypal_email', $personal_info);

                $user_full_name = trim($_POST['user_full_name']);
                update_user_meta($uid, 'first_name', $user_full_name);
                update_user_meta($uid, 'last_name', '');

                require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                require_once(ABSPATH . "wp-admin" . '/includes/image.php');

                if (!empty($_FILES['avatar']["name"])) {

                    $upload_overrides = array('test_form' => false);
                    $uploaded_file = wp_handle_upload($_FILES['avatar'], $upload_overrides);

                    $file_name_and_location = $uploaded_file['file'];
                    $file_title_for_media_library = $_FILES['avatar']['name'];

                    $file_name_and_location = $uploaded_file['file'];
                    $file_title_for_media_library = $_FILES['avatar']['name'];

                    $arr_file_type = wp_check_filetype(basename($_FILES['avatar']['name']));
                    $uploaded_file_type = $arr_file_type['type'];
                    $urls = $uploaded_file['url'];



                    if ($uploaded_file_type == "image/png" or $uploaded_file_type == "image/jpg" or $uploaded_file_type == "image/jpeg" or $uploaded_file_type == "image/gif") {

                        $attachment = array(
                            'post_mime_type' => $uploaded_file_type,
                            'post_title' => 'User Avatar',
                            'post_content' => '',
                            'post_status' => 'inherit',
                            'post_parent' => 0,
                            'post_author' => $uid,
                        );



                        $attach_id = wp_insert_attachment($attachment, $file_name_and_location, 0);
                        $attach_data = wp_generate_attachment_metadata($attach_id, $file_name_and_location);
                        wp_update_attachment_metadata($attach_id, $attach_data);


                        $_wp_attached_file = get_post_meta($attach_id, '_wp_attached_file', true);

                        if (!empty($_wp_attached_file))
                            update_user_meta($uid, 'avatar_ship', ($attach_id));
                    }
                }


                echo '<div class="saved_thing">' . __("Information saved!", "shipme") . '</div>';
            }
            ?>
            <?php $user_data = get_userdata($uid); ?>

            <ul class="virtual_sidebar">

                <li class="widget-container widget_text">            	 
                    <div class="my-only-widget-content">
                        <form method="post" enctype="multipart/form-data">
                            <ul class="post-new3">


                                <li>
                                    <h2><?php echo __('Your Full Name', 'shipme'); ?>:</h2>
                                    <p><input type="text" class="do_input" name="user_full_name" value="<?php echo get_user_meta($uid, 'first_name', true) . ' ' . get_user_meta($uid, 'last_name', true); ?>" size="40" /></p>
                                </li>

                                <li>
                                    <h2><?php echo __('Email ID', 'shipme'); ?>:</h2>
                                    <p><input type="text" class="do_input" name="email_id" value="<?php echo $user_data->user_email; ?>" size="40" /></p>
                                </li>



                                <li>
                                    <h2><?php echo __('New Password', "shipme"); ?>:</h2>
                                    <p><input type="password" value="" class="do_input" name="password" size="40" /></p>
                                </li>


                                <li>
                                    <h2><?php echo __('Repeat Password', "shipme"); ?>:</h2>
                                    <p><input type="password" value="" class="do_input" name="reppassword" size="40"  /></p>
                                </li>

                                <?php
                                $user_by = get_user_by('ID', $uid);
                                $user_by_roles = $user_by->roles;
                                //print_r($user_by->roles);exit; 
                                ?>

                                <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        if (jQuery('#role').attr("value") == "transporter") {
                                            jQuery(".form-table-contracter").hide();
                                            jQuery(".form-table-transporter").show();
                                        }
                                        if (jQuery('#role').attr("value") == "contractor") {
                                            jQuery(".form-table-transporter").hide();
                                            jQuery(".form-table-contracter").show();
                                        }
                                        jQuery('#role').change(function () {

                                            if (jQuery(this).attr("value") == "transporter") {
                                                jQuery(".form-table-contracter").hide();
                                                jQuery(".form-table-transporter").show();
                                            }
                                            if (jQuery(this).attr("value") == "contractor") {
                                                jQuery(".form-table-transporter").hide();
                                                jQuery(".form-table-contracter").show();
                                            }

                                        });
                                    });


                                    // This example displays an address form, using the autocomplete feature
                                    // of the Google Places API to help users fill in the information.

                                    var placeSearch, autocomplete, autocomplete2;


                                    function initAutocomplete_transporter(autocomplete2) {
                                        // Create the autocomplete object, restricting the search to geographical
                                        // location types.
                                        //                                                autocomplete = new google.maps.places.Autocomplete(
                                        //                                                        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete_pickup')),
                                        //                                                        {types: ['geocode']});
                                        //
                                        //                                                // When the user selects an address from the dropdown, populate the address
                                        //                                                // fields in the form.
                                        //                                                autocomplete.addListener('place_changed', fillInAddress);


                                        //-------------------------------------------------------------------
                                        //console.log(autocomplete2);
                                        id = autocomplete2;
                                        autocomplete2 = new google.maps.places.Autocomplete(
                                                /** @type {!HTMLInputElement} */(document.getElementById(autocomplete2)),
                                                {types: ['geocode']});

                                        // When the user selects an address from the dropdown, populate the address
                                        // fields in the form.
                                        autocomplete2.addListener('place_changed', fillInAddress_transporter(id));


                                    }


                                    function initAutocomplete() {
                                        // Create the autocomplete object, restricting the search to geographical
                                        // location types.
                                        autocomplete = new google.maps.places.Autocomplete(
                                                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete_pickup')),
                                                {types: ['geocode']});

                                        // When the user selects an address from the dropdown, populate the address
                                        // fields in the form.
                                        autocomplete.addListener('place_changed', fillInAddress);


                                        //-------------------------------------------------------------------

                                        //                                                autocomplete2 = new google.maps.places.Autocomplete(
                                        //                                                        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete_delivery')),
                                        //                                                        {types: ['geocode']});
                                        //
                                        //                                                // When the user selects an address from the dropdown, populate the address
                                        //                                                // fields in the form.
                                        //                                                autocomplete2.addListener('place_changed', fillInAddress2);


                                    }


                                    // [START region_fillform]
                                    function fillInAddress() {
                                        // Get the place details from the autocomplete object.
                                        var place = autocomplete.getPlace();
                                        var lat = place.geometry.location.lat();
                                        var lng = place.geometry.location.lng();


                                        document.getElementById('con_address_lat').value = lat;
                                        document.getElementById('con_address_lng').value = lng;

                                    }


                                    function fillInAddress_transporter(id) {
                                        // Get the place details from the autocomplete object.
                                        console.log(autocomplete2);
                                        var place = autocomplete2.getPlace();
                                        var lat = place.geometry.location.lat();
                                        var lng = place.geometry.location.lng();

                                        var latid = 'lat_' + id;
                                        var lngid = 'lng_' + id;
                                        console.log(latid, lat);
                                        console.log(latid, lng);
                                        document.getElementById(latid).value = lat;
                                        document.getElementById(lngid).value = lng;

                                    }

                                    function fillInAddress2() {
                                        // Get the place details from the autocomplete object.
                                        var place = autocomplete2.getPlace();
                                        var lat = place.geometry.location.lat();
                                        var lng = place.geometry.location.lng();


                                        document.getElementById('delivery_lat').value = lat;
                                        document.getElementById('delivery_lng').value = lng;

                                    }
                                    // [END region_fillform]

                                    // [START region_geolocation]
                                    // Bias the autocomplete object to the user's geographical location,
                                    // as supplied by the browser's 'navigator.geolocation' object.
                                    function geolocate_pickup() {
                                        if (navigator.geolocation) {
                                            navigator.geolocation.getCurrentPosition(function (position) {
                                                var geolocation = {
                                                    lat: position.coords.latitude,
                                                    lng: position.coords.longitude
                                                };
                                                var circle = new google.maps.Circle({
                                                    center: geolocation,
                                                    radius: position.coords.accuracy
                                                });
                                                autocomplete.setBounds(circle.getBounds());
                                            });
                                        }
                                    }



                                    function geolocate_delivery() {
                                        if (navigator.geolocation) {
                                            navigator.geolocation.getCurrentPosition(function (position) {
                                                var geolocation = {
                                                    lat: position.coords.latitude,
                                                    lng: position.coords.longitude
                                                };
                                                var circle = new google.maps.Circle({
                                                    center: geolocation,
                                                    radius: position.coords.accuracy
                                                });
                                                autocomplete.setBounds(circle.getBounds());
                                            });
                                        }
                                    }


                                </script>
                                <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete_transporter" async defer></script>



                                <?php if (in_array('transporter', $user_by_roles)) { ?>

                                    <li style="border-bottom:0px;">
                                        <h2><?php echo __('Office Address Area', "shipme"); ?>:</h2>
                                        <p class="transporter-section-inner">
                                            <?php
                                            $c = 0;
                                            $i = 1;
                                            $tra_office_address = get_the_author_meta('tra_office_address', $uid);
                                            if (isset($tra_office_address)) {
                                                $c = count($tra_office_address);
                                                if (count($tra_office_address) > 0 && is_array($tra_office_address)) {
                                                    foreach ($tra_office_address as $track) {
                                                        ?>


                                                        <input type="text" size="40" onFocus="geolocate_delivery()" id="autocomplete_delivery<?php echo $i; ?>" placeholder="<?php _e('eg: New York, 15th ave', 'shipme') ?>" class="do_input autocomplete_delivery" name="tra_office_address[<?php echo $i; ?>]" id="tra_office_address" size="50" maxlength="100" value="<?php echo $track; ?>" />
                                                        <a href="javascript:void(0)" class="remove_office button-secondary"> <?php _e('Remove Office Address', 'shipme') ?></a> <br><br>
                                                        <input type="hidden" value="<?php echo $con_address_lat; ?>"  name="off_address_lat" id="lat_autocomplete_deliver<?php echo $i; ?>"  />
                                                        <input type="hidden" value="<?php echo $con_address_lng; ?>"  name="off_address_lng" id="lng_autocomplete_deliver<?php echo $i; ?>"  />


                                                        <?php
                                                        $i++;
                                                    }
                                                }
                                            }
                                            ?>


                                        </p>
                                    </li>
                                    <li><h2></h2>
                                        <p><a href="javascript:void(0)" class="submit_bottom2 add_address button button-primary"> <?php _e('Add Office Address', 'shipme') ?></a></p>
                                    </li>

                                    <li style="border-bottom:0px;">
                                        <h2><?php echo __('Preffered Area', "shipme"); ?>:</h2>
                                        <p class="preffered-section-inner">
                                            <?php
                                            $c1 = 0;
                                            $i1 = 1;
                                            $tra_preffered_address = get_the_author_meta('tra_preffered_address', $uid);
                                            if (isset($tra_preffered_address)) {
                                                $c1 = count($tra_preffered_address);
                                                if (count($tra_preffered_address) > 0 && is_array($tra_preffered_address)) {
                                                    foreach ($tra_preffered_address as $track) {
                                                        ?>
                                                        <input type="text" size="40" onFocus="geolocate_delivery()" id="preffered_autocomplete_delivery<?php echo $i1; ?>" placeholder="<?php _e('eg: New York, 15th ave', 'shipme') ?>" class="do_input autocomplete_delivery" name="tra_preffered_address[<?php echo $i1; ?>]" id="tra_preffered_address" size="50" maxlength="100" value="<?php echo $track; ?>" />
                                                        <a href="javascript:void(0)" class="tra_preffered_address button-secondary"> <?php _e('Remove Office Address', 'shipme') ?></a><br><br>
                                                        <input type="hidden" value="<?php echo $con_address_lat; ?>"  name="lat_tra_preffered_address" id="lat_tra_preffered_address<?php echo $i1; ?>"  />
                                                        <input type="hidden" value="<?php echo $con_address_lng; ?>"  name="lng_tra_preffered_address" id="lng_tra_preffered_address<?php echo $i1; ?>"  />

                                                        <?php
                                                        $i1++;
                                                    }
                                                }
                                            }
                                            ?>
                                        </p>

                                    </li>
                                    <li><h2></h2>
                                        <p><a href="javascript:void(0)" class="submit_bottom2 preffered_address button button-primary"> <?php _e('Add Preffered Address', 'shipme') ?></a></p>
                                    </li>
                                <?php } ?>



                                <script>
                                    var $ = jQuery.noConflict();

                                    $(document).ready(function () {
                                        var count = <?php echo $c; ?>;
                                        //                                                for(i=0;i<=count;i++){
                                        //                                                    oldid='autocomplete' + i;
                                        //                                                     initAutocomplete_transporter(oldid);
                                        //                                                }
                                        number = 1;
                                        $(".add_address").click(function () {
                                            count = count + 1;
                                            newid = 'autocomplete' + count;

                                            $('.transporter-section-inner').append('<input size="40" id="' + newid + '" onFocus="geolocate_delivery()" type="text" placeholder="<?php _e('eg: New York, 15th ave', 'shipme') ?>" class="do_input" name="tra_office_address[' + count + ']" id="tra_office_address" size="50" maxlength="100" value="" /><a href="javascript:void(0)" class="remove_office button-secondary"> <?php _e('Remove Office Address', 'shipme') ?></a><input type="hidden" value=""  name="off_address_lat" id="lat_' + newid + '"  /><input type="hidden" value=""  name="off_address_lng" id="lng_' + newid + '"  /><br><br>');
                                            number = number + 1;
                                            initAutocomplete_transporter(newid);
                                            return false;
                                        });
                                        var count1 = <?php echo $c1; ?>;
                                        //                                                for(i=0;i<=count;i++){
                                        //                                                    oldid='autocomplete' + i;
                                        //                                                     initAutocomplete_transporter(oldid);
                                        //                                                }
                                        number1 = 1;
                                        $(".preffered_address").click(function () {
                                            count1 = count1 + 1;
                                            newid1 = 'preffered_autocomplete_delivery' + count1;

                                            $('.preffered-section-inner').append('<input type="text" size="40" onFocus="geolocate_delivery()" id="' + newid1 + '" placeholder="<?php _e('eg: New York, 15th ave', 'shipme') ?>" class="do_input" name="tra_preffered_address[' + count1 + ']" id="tra_preffered_address" size="50" maxlength="100" value="" /><a href="javascript:void(0)" class="tra_preffered_address button-secondary"> <?php _e('Remove Office Address', 'shipme') ?></a><input type="hidden" value=""  name="lat_' + newid1 + '" id="lat_tra_preffered_address' + count1 + '"  /><input type="hidden" value=""  name="lng_tra_preffered_address" id="lng_tra_preffered_address' + count1 + '"  /><br><br>');
                                            number1 = number1 + 1;
                                            initAutocomplete_transporter(newid1);
                                            return false;
                                        });

                                        $(document).on('click', '.remove_office', function () {
                                            //alert('aa');

                                            $(this).prev('input').remove();
                                            $(this).remove();
                                        });
                                        $(document).on('click', '.tra_preffered_address', function () {
                                            //alert('aa');

                                            $(this).prev('input').remove();
                                            $(this).remove();
                                        });
                                        $(document).on('focus', '#autocomplete_pickup', function () {
                                            //alert('aa');
                                            initAutocomplete_transporter('autocomplete_pickup');
                                        });
                                        $(document).on('focus', '.autocomplete_delivery', function () {
                                            //alert('aa');
                                            $(this).attr('id');
                                            //                                                    alert($(this).attr('id'));
                                            initAutocomplete_transporter($(this).attr('id'));
                                        });
                                    });
                                </script>

                                <?php if (in_array('contractor', $user_by_roles)) { ?>
                                    <li>
                                        <h2><?php echo __('Address Area', "shipme"); ?>:</h2>
                                        <p>
                                            <input type="text" size="40" onFocus="geolocate_pickup()" id="autocomplete_pickup" class="do_input" name="con_address" 
                                                   placeholder="<?php _e('eg: New York, 15th ave', 'shipme') ?>" value="<?php echo esc_attr(get_the_author_meta('con_address', $uid)); ?>" /></p>

                                        </p>
                                    </li>
                                <?php } ?>



                                <!--            <li>
                                                <h2><?php echo __('PayPal Email', 'shipme'); ?>:</h2>
                                                <p><input type="text" class="do_input" name="paypal_email" value="<?php echo get_user_meta($uid, 'paypal_email', true); ?>" size="40" /></p>
                                        </li>
                                        
                                        
                                        
                                        <li>
                                                <h2><?php echo __('Profile Description', 'shipme'); ?>:</h2>
                                                <p><textarea type="textarea" cols="30" class="do_input" rows="5" name="personal_info"><?php echo get_user_meta($uid, 'personal_info', true); ?></textarea></p>
                                        </li>
                                        
                                        
                                        <li>
                                                <h2><?php echo __('Profile Avatar', 'shipme'); ?>:</h2>
                                                <p> <input type="file" class="do_input" name="avatar" /> <br/>
                                <?php _e('max file size: 2mb. Formats: jpeg, jpg, png, gif', 'shipme'); ?>
                                            <br/>
                                            <img width="50" height="50" border="0" src="<?php echo shipme_get_avatar($uid, 50, 50); ?>" /> 
                                            </p>
                                        </li>-->

                                <li>
                                    <h2>&nbsp;</h2>
                                    <!--<p><input type="submit" name="save-info" value="<?php _e("Save", 'shipme'); ?>" /></p>-->
                                     <p><input type="submit" name="save-info" value="<?php _e("Save" ,'shipme'); ?>" /></p>
                                </li>

                            </ul>
                        </form>
                    </div>
                </li>



            </ul>



        </div>



    </div>


    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
?>