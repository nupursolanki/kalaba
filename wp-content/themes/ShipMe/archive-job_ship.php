<?php
/* * *************************************************************************
 *
 * 	shipme - copyright (c) - sitemile.com
 * 	The only project theme for wordpress on the world wide web.
 *
 * 	Coder: Andrei Dragos Saioc
 * 	Email: sitemile[at]sitemile.com | andreisaioc[at]gmail.com
 * 	More info about the theme here: http://sitemile.com/products/wordpress-project-freelancer-theme/
 * 	since v1.2.5.3
 *
 * ************************************************************************* */

global $query_string;

function shipme_posts_join4($join) {
    global $wp_query, $wpdb;

    $join .= " LEFT JOIN (
				SELECT post_id, meta_value as featured_due
				FROM $wpdb->postmeta
				WHERE meta_key =  'featured' ) AS DD
				ON $wpdb->posts.ID = DD.post_id ";


    return $join;
}

//------------------------------------------------------

function shipme_posts_orderby4($orderby) {
    global $wpdb;
    $orderby = " featured_due+0 desc, $wpdb->posts.post_date desc ";
    return $orderby;
}

//add_filter('posts_join', 'shipme_posts_join4');
//add_filter('posts_orderby', 'shipme_posts_orderby4');
//print_r(query_posts($prs_string_qu));

$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$term_title = $term->name;

//======================================================

get_header();
?>

<div class="container_ship_ttl_wrap">	
    <div class="container_ship_ttl">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
            <?php
            if (empty($term_title))
                echo __("All Posted Jobs", 'shipme');
            else
                echo sprintf(__("Latest Posted Jobs in %s", 'shipme'), $term_title);
            ?>
        </div>

        <?php
        if (function_exists('bcn_display')) {
            echo '<div class="my_box3 no_padding  breadcrumb-wrap col-xs-12 col-sm-12 col-lg-12"> ';
            bcn_display();
            echo '</div> ';
        }
        ?>	

    </div>
</div>





<?php
$shipme_adv_code_cat_page_above_content = stripslashes(get_option('shipme_adv_code_cat_page_above_content'));
if (!empty($shipme_adv_code_cat_page_above_content)):

    echo '<div class="full_width_a_div">';
    echo $shipme_adv_code_cat_page_above_content;
    echo '</div>';

endif;
?>




<div class="container_ship_no_bk mrg_topo">
    <div class="job-content-area col-xs-12 col-sm-4 col-lg-3">
        <!--        <ul style="list-style: none"><li class="">-->
        <p>Pickup Location (address/zip)</p>
        <p><input type="text" value="" placeholder="eg: Ahmedabad, India" name="pickup_location" class="form-control" id="autocomplete_pickup" onfocus="geolocate_pickup()" size="20" autocomplete="off"></p>

        <p>Delivery Location (address/zip)</p>
        <p><input type="text" value="" placeholder="eg: Surat, India" name="delivery_location" class="form-control" id="autocomplete_delivery" onfocus="geolocate_delivery()" class="do_input form-control" size="20" autocomplete="off"></p>
        <a  class="submit_bottom2 search-location" href="javascript:void(0)"> Search</a>

        <div id="slider"></div>
        <div id="html5"></div>
        <div class="clearfix"><input type="text" id="price-1" name="price-1" style="float:left; width:30%"/> <input type="text" id="price-2" name="price-2" style="float:right; width:30%"/></div>
        <p></p>
        <p><a  class="submit_bottom2 search-location" href="javascript:void(0)"> Price Filter </a></p>

        <!--         </li>
                </ul> -->
    </div>
    <link href="<?php echo get_template_directory_uri(); ?>/css/nouislider.min.css" rel="stylesheet"> 
    <style>
        #slider {
            width: 250px;
            margin: 100px auto;
        }
    </style>
    <script src="<?php echo get_template_directory_uri(); ?>/js/nouislider.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/js/wNumb.js"></script>
    <script>

            var select = document.getElementById('price-2');
            var option = document.getElementById('price-1');
            var html5Slider = document.getElementById('html5');
            noUiSlider.create(html5Slider, {
                start: [0, 100000],
                connect: true,
                step: 100,
                range: {
                    'min': 0,
                    'max': 99999
                },
                format: wNumb({
                    decimals: 0,
                    //postfix:' Rs.'
                })
            });
            var inputNumber = document.getElementById('input-number');
            html5Slider.noUiSlider.on('update', function (values, handle) {

                var value = values[handle];
                if (handle) {
                    select.value = value;
                } else {
                    option.value = value;
                }
            });
            select.addEventListener('change', function () {
                html5Slider.noUiSlider.set([null, this.value]);
            });
            option.addEventListener('change', function () {
                html5Slider.noUiSlider.set([this.value, null]);
            });</script>
    <div class="col-xs-12 col-sm-8 col-lg-9">
        <div class="job-content-area col-xs-12 col-sm-12 col-lg-12">

            <select class="filter-drop-down"  style="margin-bottom: 10px; float: right;">
                <option value="recently-added">Recently Added</option>
                <option value="price-heigh-low">Price: Heigh-Low</option>
                <option value="price-low-heigh">Price: Low-Heigh</option>
                <option value="pickup-a-z">Pickup: A-Z</option>
                <option value="pickup-z-a">Pickup: Z-A</option>
                <option value="delivery-a-z">Delivery: A-Z</option>
                <option value="delivery-z-a">Delivery: Z-A</option>
                <option value="title-a-z">Title: A-Z</option>
                <option value="pickup-date-a-z">Pickup Date: DESC</option>
                <option value="pickup-date-z-a">Pickup Date: ASC</option>
                <option value="delivery-date-a-z">Delivery Date: DESC</option>
                <option value="delivery-date-z-a">Delivery Date: ASC</option>

            </select>
        </div> 
        <div class="job-content-area-inner col-xs-12 col-sm-12 col-lg-12">

        </div>
    </div>
    <!--For Ajax Jobs Display-->
    <script>
        $(document).ready(function () {
            var offset = 0;
            var ajax = '';
            $(".job-content-area-inner").html("<img src='<?php echo get_template_directory_uri(); ?>/images/loading.gif' alt='Loading...'/>");
            ajax = $.ajax({url: "<?php echo get_template_directory_uri(); ?>/page-templates/all_post_ajax.php", type: "POST", data: {"offset": offset}, success: function (result) {
                    $(".job-content-area-inner").html(result);
                    offset = 10;
                }});
            function ajax_call_filter() {
                if (ajax) {
                    ajax.abort();
                }
                $(".job-content-area-inner").html("<img src='<?php echo get_template_directory_uri(); ?>/images/loading.gif' alt='Loading...'/>");
                ajax = $.ajax({url: "<?php echo get_template_directory_uri(); ?>/page-templates/all_post_ajax.php", type: "POST", data: {"offset": offset, "pickup_location": $('#autocomplete_pickup').val(), "delivery_location": $('#autocomplete_delivery').val(), "sort_by_post": $('.filter-drop-down').val(), "price-1": $('#price-1').val(), "price-2": $('#price-2').val()}, success: function (result) {
                        $(".job-content-area-inner").html(result);
                        offset = 10;
                    }});
            }
            $('.filter-drop-down').change(function () {
                ajax_call_filter();
            });
            $('.search-location').click(function () {
                ajax_call_filter();
            });
            $(document).on('click', '.load_more_job', function () {
                $(document).find('.load_more_job').hide();
                $(".job-content-area-inner").append("<img src='<?php echo get_template_directory_uri(); ?>/images/loading.gif' class='image-load' alt='Loading...'/>");
                $.ajax({url: "<?php echo get_template_directory_uri(); ?>/page-templates/all_post_ajax.php", type: "POST", data: {"offset": offset, "pickup_location": $('#autocomplete_pickup').val(), "delivery_location": $('#autocomplete_delivery').val(), "sort_by_post": $('.filter-drop-down').val(), "price-1": $('#price-1').val(), "price-2": $('#price-2').val()}, success: function (result) {
                        $(document).find('.image-load').hide();
                        $(".job-content-area-inner").append(result);
                        offset = offset + 5;
                    }});
            });
        });
        jQuery(document).ready(function () {
            jQuery('#pickup_date').pickadate({min: new Date(), onSet: function (thingSet) {
                    jQuery("#pickup_date_hidden").val(thingSet.select / 1000 + 12400);
                }});
            jQuery('#delivery_date').pickadate({min: new Date(), onSet: function (thingSet) {
                    jQuery("#delivery_date_hidden").val(thingSet.select / 1000 + 12400);
                }});
        });
        // This example displays an address form, using the autocomplete feature
        // of the Google Places API to help users fill in the information.

        var placeSearch, autocomplete, autocomplete2;
        function initAutocomplete() {
            // Create the autocomplete object, restricting the search to geographical
            // location types.
            autocomplete = new google.maps.places.Autocomplete(
                    /** @type {!HTMLInputElement} */(document.getElementById('autocomplete_pickup')),
                    {types: ['(cities)']});
            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete.addListener('place_changed', fillInAddress);
            //-------------------------------------------------------------------

            autocomplete2 = new google.maps.places.Autocomplete(
                    /** @type {!HTMLInputElement} */(document.getElementById('autocomplete_delivery')),
                    {types: ['(cities)']});
            // When the user selects an address from the dropdown, populate the address
            // fields in the form.
            autocomplete2.addListener('place_changed', fillInAddress2);
        }

        // [START region_fillform]
        function fillInAddress() {
            // Get the place details from the autocomplete object.
            var place = autocomplete.getPlace();
            var lat = place.geometry.location.lat();
            var lng = place.geometry.location.lng();
            document.getElementById('pickup_lat').value = lat;
            document.getElementById('pickup_lng').value = lng;
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

        // [END region_geolocation]

    </script>
    <script src="https://maps.googleapis.com/maps/api/js?signed_in=true&libraries=places&callback=initAutocomplete" async defer></script>

    <div id="left-sidebar" class="account-right-sidebar col-xs-12 col-sm-4 col-lg-3  ">
        <ul class="virtual_sidebar" id="six-years2">
            <?php dynamic_sidebar('other-page-area'); ?>
        </ul>
    </div>

</div> 

<?php
get_footer();
?>