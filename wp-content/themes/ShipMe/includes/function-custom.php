<?php
add_action('add_meta_boxes', 'add_custom_box_package');

/* Do something with the data entered */
add_action('save_post', 'save_postdata_package');

/* Code For add package */

function add_custom_box_package() {
    add_meta_box(
            'dynamic_sectionid', __('Package', 'myplugin_textdomain'), 'inner_custom_box_package', 'job_ship');
}

/* Prints the box content */

function inner_custom_box_package() {
    global $post;
    // Use nonce for verification
    wp_nonce_field(plugin_basename(__FILE__), 'dynamicMeta_noncename');
    ?>
    <div id="meta_inner">
        <?php
        //get the saved meta as an arry
        $package_detail = array();
        $package_detail = get_post_meta($post->ID, 'package_detail', true);


        $c = 0;
        if (count($package_detail) > 0 && is_array($package_detail)) {
            foreach ($package_detail as $track) {
                if (isset($track['num_of_package']) || isset($track['height']) || isset($track['width']) || isset($track['length']) || isset($track['weight'])) {
                    printf('<table class="package_detail"><tr><td>Number of package :</td><td> <input type="text" name="package_detail[%1$s][num_of_package]" value="%2$s" placeholder="Number Of Package" /></td> </tr><tr><td>Height :</td><td> <input type="text" name="package_detail[%1$s][height]" value="%3$s" placeholder="cm" /></td></tr> <tr><td>Width :</td><td> <input type="text" name="package_detail[%1$s][width]" value="%4$s" placeholder="cm" /></td></tr> <tr><td>Length :</td><td> <input type="text" name="package_detail[%1$s][length]" value="%5$s" placeholder="cm" /></td></tr> <tr><td>Weight :</td><td> <input type="text" name="package_detail[%1$s][weight]" value="%6$s" placeholder="kg" /></td></tr> <tr><td></td><td><span class="remove preview  button button-primary button-large">%7$s</span></td></tr></table>', $c, $track['num_of_package'], $track['height'], $track['width'], $track['length'], $track['weight'], __('Remove Track'));
                    $c = $c + 1;
                }
            }
        }
        ?>
        <span id="here"></span>
        <span class="add button"><?php _e('Add Packages'); ?></span>
        <style>.package_detail input{width:100%}</style>
        <script>
            var $ = jQuery.noConflict();
            $(document).ready(function () {
                var count = <?php echo $c; ?>;
                $(".add").click(function () {
                    count = count + 1;

                    $('#here').append('<table class="package_detail"><tr><td>Number of package :</td><td> <input type="text" name="package_detail[' + count + '][num_of_package]" value="" placeholder="Number of package" /></td></tr><tr><td>Height :</td><td> <input type="text" name="package_detail[' + count + '][height]" value="" placeholder="cm" /> </td></tr><tr><td>Width :</td><td> <input type="text" name="package_detail[' + count + '][width]" value="" placeholder="cm" /></td> </tr><tr><td>Length :</td> <td><input type="text" name="package_detail[' + count + '][length]" value="" placeholder="cm" /></td> </tr><tr><td>Weight :</td><td> <input type="text" name="package_detail[' + count + '][weight]" value=""  placeholder="kg"/> </td></tr> <tr><td> </td><td><span style="" class="remove preview  button button-primary button-large">Remove Track</span></td></tr></table>');
                    return false;
                });
                $(".remove").live('click', function () {
                    $(this).parent().parent().parent().remove();
                });
            });
        </script>
    </div><?php
}

/* When the post is saved, saves our custom data */

function save_postdata_package($post_id) {
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if (!isset($_POST['dynamicMeta_noncename']))
        return;

    if (!wp_verify_nonce($_POST['dynamicMeta_noncename'], plugin_basename(__FILE__)))
        return;

    // OK, we're authenticated: we need to find and save the data

    $package_detail = $_POST['package_detail'];

    update_post_meta($post_id, 'package_detail', $package_detail);
}

/* End Code For add package */

//code for add Extra fields to User
add_action('show_user_profile', 'user_extra_field_show');
add_action('edit_user_profile', 'user_extra_field_show');

function user_extra_field_show($user) {
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


    <h3><?php _e("Profile information", "blank"); ?></h3>
    <table class="form-table form-table-transporter" style="display: none">
        <tr><td>
        <table class=" form-table transporter-section-inner">
                                                <?php
                                                $c = 0;
                                                $i=1;
                                                $tra_office_address=get_the_author_meta('tra_office_address', $user->ID);
                                                if (isset($tra_office_address)) {
                                                    $c = count($tra_office_address);
                                                    if (count($tra_office_address) > 0 && is_array($tra_office_address)) {
                                                        foreach ($tra_office_address as $track) {
                                                            ?>
                                                            <tr><td>							 
                                                                    <label for="tra_office_address"><?php _e('Office Address Area:', 'shipme') ?></label></td>
                                                                <td><input type="text" size="50" onFocus="geolocate_delivery()" id="autocomplete_delivery<?php echo $i; ?>" placeholder="<?php _e('eg: New York, 15th ave', 'shipme') ?>" class="do_input autocomplete_delivery" name="tra_office_address[<?php echo $i; ?>]" id="tra_office_address" size="50" maxlength="100" value="<?php echo $track; ?>" />
                                                                <a href="javascript:void(0)" class="remove_office button-secondary"> <?php _e('Remove Office Address', 'shipme') ?></a>
                                                                <input type="hidden" value="<?php echo $con_address_lat; ?>"  name="off_address_lat" id="lat_autocomplete_deliver<?php echo $i; ?>"  />
                                            <input type="hidden" value="<?php echo $con_address_lng; ?>"  name="off_address_lng" id="lng_autocomplete_deliver<?php echo $i; ?>"  />
                                                                </td></tr>
                                                            <?php
                                                            $i++;
                                                        }
                                                    }
                                                }
                                                ?>
                                                            
                                                

                                            
                                            
        </table></td></tr>
        <tr><td><table><tr>
                                                <td><label for="add_address">&nbsp;</label></td>
                                                <td><a href="javascript:void(0)" class="submit_bottom2 add_address button button-primary"> <?php _e('Add Office Address', 'shipme') ?></a></td>
                                            </tr></table></td></tr>
        <tr><td>
                                            <table class="form-table preffered-section-inner" >
                                                            <?php
                                                $c1 = 0;
                                                $i1=1;
                                                $tra_preffered_address=get_the_author_meta('tra_preffered_address', $user->ID);
                                                if (isset($tra_preffered_address)) {
                                                    $c1 = count($tra_preffered_address);
                                                    if (count($tra_preffered_address) > 0 && is_array($tra_preffered_address)) {
                                                        foreach ($tra_preffered_address as $track) {
                                                            ?>
                                                <tr><td>							 
                                                        <label for="tra_preffered_address"><?php _e('Preffered Area:', 'shipme') ?></label></td>
                                                    <td> <input type="text" size="50" onFocus="geolocate_delivery()" id="preffered_autocomplete_delivery<?php echo $i1; ?>" placeholder="<?php _e('eg: New York, 15th ave', 'shipme') ?>" class="do_input autocomplete_delivery" name="tra_preffered_address[<?php echo $i1; ?>]" id="tra_preffered_address" size="50" maxlength="100" value="<?php echo $track; ?>" />
                                                                <a href="javascript:void(0)" class="tra_preffered_address button-secondary"> <?php _e('Remove Office Address', 'shipme') ?></a>
                                                                <input type="hidden" value="<?php echo $con_address_lat; ?>"  name="lat_tra_preffered_address" id="lat_tra_preffered_address<?php echo $i1; ?>"  />
                                            <input type="hidden" value="<?php echo $con_address_lng; ?>"  name="lng_tra_preffered_address" id="lng_tra_preffered_address<?php echo $i1; ?>"  />
                                                    </td> </tr>
                                                            <?php
                                                            $i1++;
                                                        }
                                                    }
                                                }
                                                ?>
                                            
                                            
                                            </table>
                                            
            </td></tr>
        <tr><td><table><tr><td>
                                                    <label for="preffered_address">&nbsp;</label></td>
                                                <td><a href="javascript:void(0)" class="submit_bottom2 preffered_address button button-primary"> <?php _e('Add Preffered Address', 'shipme') ?></a></td>
                                            </tr></table></td></tr>
    </table>
    
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

                $('.transporter-section-inner').append('<tr><td><label for="tra_office_address"><?php _e('Office Address Area:', 'shipme') ?></label></td><td><input size="50" id="' + newid + '" onFocus="geolocate_delivery()" type="text" placeholder="<?php _e('eg: New York, 15th ave', 'shipme') ?>" class="do_input" name="tra_office_address[' + count + ']" id="tra_office_address" size="50" maxlength="100" value="" /><a href="javascript:void(0)" class="remove_office button-secondary"> <?php _e('Remove Office Address', 'shipme') ?></a><input type="hidden" value=""  name="off_address_lat" id="lat_' + newid + '"  /><input type="hidden" value=""  name="off_address_lng" id="lng_' + newid + '"  /></td></tr>');
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

                $('.preffered-section-inner').append('<tr><td><label for="tra_preffered_address"><?php _e('Preffered Area:', 'shipme') ?></label></td><td><input type="text" size="50" onFocus="geolocate_delivery()" id="' + newid1 + '" placeholder="<?php _e('eg: New York, 15th ave', 'shipme') ?>" class="do_input" name="tra_preffered_address[' + count1 + ']" id="tra_preffered_address" size="50" maxlength="100" value="" /><a href="javascript:void(0)" class="tra_preffered_address button-secondary"> <?php _e('Remove Office Address', 'shipme') ?></a><input type="hidden" value=""  name="lat_' + newid1 + '" id="lat_tra_preffered_address' + count1 + '"  /><input type="hidden" value=""  name="lng_tra_preffered_address" id="lng_tra_preffered_address' + count1 + '"  /></td></tr>');
                number1 = number1 + 1;
                initAutocomplete_transporter(newid1);
                return false;
            });

            $(document).on('click', '.remove_office', function () {
                //alert('aa');
                $(this).closest('tr').remove();
            });
            $(document).on('click', '.tra_preffered_address', function () {
                //alert('aa');
                $(this).closest('tr').remove();
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
    <table class="form-table form-table-contracter" style="display: none">
        <tr>
            <th><label for="con_address"><?php _e('Address Area:', 'shipme') ?></label></th>
            <td>
                <p>	

                    <input type="text" size="50" onFocus="geolocate_pickup()" id="autocomplete_pickup" class="do_input" name="con_address" 
                           placeholder="<?php _e('eg: New York, 15th ave', 'shipme') ?>" value="<?php echo esc_attr(get_the_author_meta('con_address', $user->ID)); ?>" /></p>

<!--                <input type="hidden" value="<?php echo $con_address_lat; ?>"  name="con_address_lat" id="con_address_lat"  />
                <input type="hidden" value="<?php echo $con_address_lng; ?>"  name="con_address_lng" id="con_address_lng"  />-->
            </td>
        </tr>
    </table>
    <?php
}

add_action('personal_options_update', 'user_extra_field_save');
add_action('edit_user_profile_update', 'user_extra_field_save');

function user_extra_field_save($user_id) {
    $saved = false;
    if (current_user_can('edit_user', $user_id)) {
        //update_user_meta( $user_id, 'phone', $_POST['phone'] );
        if (isset($_POST['con_address'])) {
            update_user_meta($user_id, 'con_address', $_POST['con_address']);
        }
        if (isset($_POST['con_address_lat'])) {
            update_user_meta($user_id, 'con_address_lat', $_POST['con_address_lat']);
        }
        if (isset($_POST['con_address'])) {
            update_user_meta($user_id, 'con_address_lng', $_POST['con_address_lng']);
        }
        if (isset($_POST['tra_office_address'])) {
            update_user_meta($user_id, 'tra_office_address', $_POST['tra_office_address']);
        }
        if (isset($_POST['tra_preffered_address'])) {
            update_user_meta($user_id, 'tra_preffered_address', $_POST['tra_preffered_address']);
        }
        $saved = true;
    }
    return true;
}

//End code for add Extra fields to User

