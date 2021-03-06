<?php
if ($_POST) {


    $bid = $_POST['bid'];
    $description2 = $_POST['description2'];
    $pid = get_the_id();
    $cid = get_current_user_id();
    $cdate = date('d-M-Y');

    $wpdb->insert(
            'tf_ship_bids', array(
        'bid' => $bid,
        'uid' => $cid,
        'pid' => $pid,
        'description' => $description2,
        'date_made' => $cdate,
            )
    );
    echo "<meta http-equiv='refresh' content='0'>";
}

function shipme_colorbox_stuff() {

    echo '<link media="screen" rel="stylesheet" href="' . get_bloginfo('template_url') . '/css/colorbox.css" />';
    /* echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>'; */
    echo '<script src="' . get_bloginfo('template_url') . '/js/jquery.colorbox.js"></script>';

    $get_bidding_panel = 'get_bidding_panel';
    $get_bidding_panel = apply_filters('shipme_get_bidding_panel_string', $get_bidding_panel);
    ?>

    <script>

        var $ = jQuery;

        jQuery(document).ready(function () {

            jQuery("a[rel='image_gal1']").colorbox();
            jQuery("a[rel='image_gal2']").colorbox();

            jQuery('.get_bidding_panel').click(function () {

                var myRel = jQuery(this).attr('rel');

                jQuery.colorbox({href: "<?php bloginfo('siteurl'); ?>/?get_bidding_panel=" + myRel + "&postid=<?php echo get_the_id(); ?>"});
                //jQuery.colorbox({href: "<?php bloginfo('siteurl'); ?>/?get_bidding_panel=" + myRel  });
                return false;
            });


            jQuery("#report-this-link").click(function () {

                if (jQuery("#report-this").css('display') == 'none')
                    jQuery("#report-this").show('slow');
                else
                    jQuery("#report-this").hide('slow');

                return false;
            });


            jQuery("#contact_seller-link").click(function () {

                if (jQuery("#contact-seller").css('display') == 'none')
                    jQuery("#contact-seller").show('slow');
                else
                    jQuery("#contact-seller").hide('slow');

                return false;
            });

        });
    </script>

    <?php
}

add_action('wp_head', 'shipme_colorbox_stuff');


get_header();
global $post;
?>

<?php if (have_posts()) while (have_posts()) : the_post(); ?>


        <?php
        $pid = get_the_ID();

        $ending = get_post_meta($pid, 'ending', true);
        $closed = get_post_meta($pid, 'closed', true);
        ?>

        <!--        <div class="container_ship_ttl_wrap_jb" >	
                    <div class="container_ship_ttl_jb">
                        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
                            <h1 class="super-job-title"><?php //the_title()                                 ?></h1>
                        </div>

        <?php
//                if (function_exists('bcn_display')) {
//                    echo '<div class="my_box3 no_padding  breadcrumb-wrap col-xs-12 col-sm-12 col-lg-12"><div class="padd10">';
//                    bcn_display();
//                    echo '</div></div>';
//                }
        ?>	

                    </div>
                </div>-->

        <!-- ###################################### -->

        <div id="map" style="width: 100%; height: 550px;border-bottom:1px solid #ccc; margin:auto"></div>

        <script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script> 
        <script type="text/javascript">

        window.onload = function () {
            var geocoder;
            var map;
            var markers = [];
            geocoder = new google.maps.Geocoder();

            geocoder.geocode({'address': '<?php echo get_post_meta(get_the_ID(), 'pickup_location', true) ?>'}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    markers.push({
                        "title": '<?php echo get_post_meta(get_the_ID(), 'pickup_location', true) ?>',
                        "lat": results[0].geometry.location.lat(),
                        "lng": results[0].geometry.location.lng(),
                        "icon": '<?php bloginfo('template_url') ?>/images/beachflag.png',
                        "description": '<?php echo sprintf(__("<strong>Pickup:</strong> %s", 'shipme'), get_post_meta(get_the_ID(), 'pickup_location', true)) ?>'
                    });


                    geocoder2 = new google.maps.Geocoder();

                    geocoder2.geocode({'address': '<?php echo get_post_meta(get_the_ID(), 'delivery_location', true) ?>'}, function (results2, status2) {
                        if (status2 == google.maps.GeocoderStatus.OK) {

                            markers.push({
                                "title": '<?php echo get_post_meta(get_the_ID(), 'delivery_location', true) ?>',
                                "lat": results2[0].geometry.location.lat(),
                                "lng": results2[0].geometry.location.lng(),
                                "icon": '<?php bloginfo('template_url') ?>/images/finish.png',
                                "description": '<?php echo sprintf(__("<strong>Delivery:</strong> %s", 'shipme'), get_post_meta(get_the_ID(), 'delivery_location', true)) ?>'
                            });
                            //-------------------------
                            var mapOptions = {
                                center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
                                zoom: 5,
                                scrollwheel: false,
                                mapTypeId: google.maps.MapTypeId.ROADMAP,
                                disableDoubleClickZoom: true,
                                draggable: false,
                                keyboardShortcuts: false,
                            };
                            var map = new google.maps.Map(document.getElementById("map"), mapOptions);

                            map.set('styles', [{"featureType": "all", "stylers": [{"saturation": 0}, {"hue": "#D1EDE8"}]}, {"featureType": "road", "stylers": [{"saturation": -70}]}, {"featureType": "transit", "stylers": [{"visibility": "off"}]}, {"featureType": "poi", "stylers": [{"visibility": "off"}]}, {"featureType": "water", "stylers": [{"visibility": "simplified"}, {"saturation": -20}]}]);


                            var infoWindow = new google.maps.InfoWindow();
                            var lat_lng = new Array();
                            var latlngbounds = new google.maps.LatLngBounds();

                            for (i = 0; i < markers.length; i++) {
                                var data = markers[i]

                                var myLatlng = new google.maps.LatLng(data.lat, data.lng);
                                lat_lng.push(myLatlng);
                                var marker = new google.maps.Marker({
                                    position: myLatlng,
                                    map: map,
                                    icon: data.icon,
                                    title: data.title
                                });
                                latlngbounds.extend(marker.position);
                                (function (marker, data) {
                                    google.maps.event.addListener(marker, "click", function (e) {
                                        infoWindow.setContent(data.description);
                                        infoWindow.open(map, marker);
                                    });
                                })(marker, data);
                            }
                            map.setCenter(latlngbounds.getCenter());
                            map.fitBounds(latlngbounds);

                            //***********ROUTING****************//

                            //Initialize the Path Array
                            var path = new google.maps.MVCArray();

                            //Initialize the Direction Service
                            var service = new google.maps.DirectionsService();

                            //Set the Path Stroke Color
                            var poly = new google.maps.Polyline({map: map, strokeColor: '#ff0000'});

                            //Loop and Draw Path Route between the Points on MAP
                            for (var i = 0; i < lat_lng.length; i++) {
                                if ((i + 1) < lat_lng.length) {
                                    var src = lat_lng[i];
                                    var des = lat_lng[i + 1];
                                    path.push(src);
                                    poly.setPath(path);
                                    service.route({
                                        origin: src,
                                        destination: des,
                                        travelMode: google.maps.DirectionsTravelMode.DRIVING
                                    }, function (result, status) {
                                        if (status == google.maps.DirectionsStatus.OK) {

                                            jQuery('#distance_distance').html(Math.round(result.routes[0].legs[0].distance.value / 1000) + "<?php _e('Km', 'shipme') ?>");


                                            for (var i = 0, len = result.routes[0].overview_path.length; i < len; i++) {
                                                path.push(result.routes[0].overview_path[i]);
                                            }
                                        }
                                    });
                                }
                            }
                            //--------------------------	  
                        } else {
                            alert("Geocode was not successful for the following reason: " + status);
                        }
                    });
                } else {
                    alert("Geocode was not successful for the following reason: " + status);
                }
            });
        }
        </script> 

        <div class="container_ship_no_bk mrg_topo">


            <div class="job-content-area col-xs-12 col-sm-8 col-lg-9">
                <ul class="virtual_sidebar" id="six-years">

                    <?php if (shipme_is_owner_of_post()): ?>

                        <li class="widget-container widget_text  ">
                            <div class="my-only-widget-content ">
                                <?php
                                $mm = '<a class="green_btn" href="' . get_site_url() . '/post-new-transport-job/?post_new_step=1&jobid=' . get_the_ID() . '">' . __('Edit Job', 'shipme') . '</a> <a class="green_btn delete_job" href="' . get_site_url() . '/my-account-area/?action=delete&jobid=' . get_the_ID() . '">' . __('Delete Job', 'shipme') . '</a>';
                                ?>
                                <script>
                                    $(document).on('click', '.delete_job', function () {
                                        if (confirm("Are Yor Really Want to Delete Job ?") == true) {
                                            return true;
                                        }
                                        else {
                                            return false;
                                        }
                                        //                        confirm('Are Yor Really Want to Delete Job ?');
                                    });
                                </script>
                                <?php printf(__('You are the owner of this job. Your options are: %s', 'shipme'), $mm); ?>
                            </div>            
                        </li>


                    <?php endif; ?>

                    <li class="widget-container widget_text  ">
                        <h3 class="widget-title"><?php the_title() ?></h3>
                        <div class="my-only-widget-content " id='content-of-jb'>
                            <!--
                                                        <ul class="main_details_1">
                                                            <li>
                                                                <h3><?php //printf(__('%s Category:', 'shipme'), '<i class="fa fa-folder"></i>');                                 ?></h3>
                                                                <p><?php //echo get_the_term_list(get_the_ID(), 'job_ship_cat', '', ', ', '');                                 ?></p>
                                                            </li>
                                                            <li>
                                                                <h3><?php //printf(__('%s Quotes:', 'shipme'), '<i class="fa fa-briefcase"></i>');                                 ?></h3>
                                                                <p><?php //echo shipme_number_of_bid(get_the_ID());                                 ?></p>
                                                            </li>
                            
                            
                                                            <li>
                                                                <h3><?php //printf(__('%s Date Listed:', 'shipme'), '<i class="fa fa-calendar"></i>');                                 ?></h3>
                                                                <p><?php //the_time("jS F Y g:i A");                                 ?></p>
                                                            </li>
                            
                            
                            <?php //if ($closed == "1"):  ?>
                            
                                                                <li>
                                                                    <h3><?php //printf(__('%s Ending In:', 'shipme'), '<i class="fa fa-clock-o"></i>');                                 ?></h3>
                                                                    <p class=" "><?php //echo __("Expired/Closed", 'shipme');                                 ?></p>
                                                                </li>
                            
                            
                            <?php //else:  ?>
                                                                <li>
                                                                    <h3><?php //printf(__('%s Ending In:', 'shipme'), '<i class="fa fa-clock-o"></i>');                                ?></h3>
                                                                    <p class="expiration_project_p"><?php //echo ($closed == "0" ? ($ending - current_time('timestamp', 0)) : __("Expired/Closed", 'shipme'));
                            ?></p>
                                                                </li>
                            
                            <?php //endif;  ?>
                            
                            
                            
                                                            <li><h3>&nbsp;</h3></li>
                            
                                                            <li>
                                                                <h3><?php //printf(__('%s Pickup Longitude:', 'shipme'), '<i class="fa fa-location-arrow"></i>');                                 ?></h3>
                                                                <p><?php //echo get_post_meta(get_the_ID(), 'pickup_lng', true);                                 ?></p>
                                                            </li>
                            
                                                            <li>
                                                                <h3><?php //printf(__('%s Pickup Latitude:', 'shipme'), '<i class="fa fa-location-arrow"></i>');                                 ?></h3>
                                                                <p><?php //echo get_post_meta(get_the_ID(), 'pickup_lat', true);                                 ?></p>
                                                            </li>
                            
                            
                                                            <li><h3>&nbsp;</h3></li>
                            
                                                            <li>
                                                                <h3><?php //printf(__('%s Delivery Longitude:', 'shipme'), '<i class="fa fa-location-arrow"></i>');                                 ?></h3>
                                                                <p><?php //echo get_post_meta(get_the_ID(), 'delivery_lat', true);                                 ?></p>
                                                            </li>
                            
                                                            <li>
                                                                <h3><?php //printf(__('%s Delivery Latitude:', 'shipme'), '<i class="fa fa-location-arrow"></i>');                                 ?></h3>
                                                                <p><?php //echo get_post_meta(get_the_ID(), 'delivery_lng', true);                                 ?></p>
                                                            </li>
                                                            
                                                              
                            
                            
                                                        </ul>-->

                            <ul class="main_details_1">
                                <li>
                                    <h3><?php printf(__('%s Distance :', 'shipme'), '<i class="fa fa-map"></i>'); ?></h3>
                                    <p id="distance_distance"><?php echo __('calculating...', 'shipme'); ?></p>
                                </li>
                            </ul>
                            <div class="pick_main_div">
                                <div class="pick_div1">
                                    <h3 class="pick_title"><?php _e('Item(s) Pickup', 'shipme') ?></h3>
                                    <br/>
                                    <p class="pick_p"><img src="<?php bloginfo('template_url') ?>/images/beachflag.png" /> <?php echo ' ' . get_post_meta(get_the_ID(), 'pickup_location', true); ?></p>	 
                                </div>
                                <div class="pick_div2" >
                                    <h3 class="pick_title"><?php _e('Item(s) Delivery', 'shipme') ?></h3>
                                    <br/>
                                    <p class="pick_p"><img src="<?php bloginfo('template_url') ?>/images/finish.png" /><?php echo ' ' . get_post_meta(get_the_ID(), 'delivery_location', true); ?></p>    
                                </div>
                            </div>
                        </div>
                    </li>

                    <?php
                    if (get_field('need_a_helper', $pid, true) == '1' || get_field('fragile_materials', $pid, true) == '1' || get_field('commercial_purpose', $pid, true) == '1' || get_field('packing_services', $pid, true) == '1') {
                        ?>
                        <li class="widget-container widget_text">
                            <h3 class="widget-title"><?php _e('Job Description', 'shipme') ?></h3>
                            <?php if (get_field('need_a_helper', $pid, true) == '1') { ?>
                                <div class="my-only-widget-content " id='content-of-jb'>
                                    <?php
                                    echo 'Need Helper For Carry Package';
                                    ?>
                                </div>
                            <?php } ?>

                            <?php if (get_field('fragile_materials', $pid, true) == '1') { ?>
                                <div class="my-only-widget-content " id='content-of-jb'>
                                    <?php
                                    echo 'There is Fragile Materials';
                                    ?>
                                </div>
                            <?php } ?>

                            <?php if (get_field('commercial_purpose', $pid, true) == '1') { ?>
                                <div class="my-only-widget-content " id='content-of-jb'>
                                    <?php
                                    echo 'For Commercial Purpose';
                                    ?>

                                </div>
                            <?php } ?>

                            <?php if (get_field('packing_services', $pid, true) == '1') { ?>
                                <div class="my-only-widget-content " id='content-of-jb'>
                                    <?php
                                    echo 'Packing Services';
                                    ?>

                                </div>
                            <?php } ?>
                        </li>
                    <?php
                    }
                    $special = get_the_content();
                    if ($special != '' || $special != null) {
                        ?>
                        <li class="widget-container widget_text">
                            <h3 class="widget-title">Special Instructions</h3>
                            <div class="my-only-widget-content " id='content-of-jb'>
                            <?php echo $special; ?>
                            </div>
                        </li>
                        <?php
                    }

                    $shipme_enable_project_files = get_option('shipme_enable_project_files');
                    $winner = get_post_meta(get_the_ID(), 'winner', true);
                    $post = get_post(get_the_ID());
                    global $wpdb;
                    $pid = get_the_ID();

                    $bids = "select * from " . $wpdb->prefix . "ship_bids where pid='$pid' order by id DESC";
                    $res = $wpdb->get_results($bids);

                    if ($post->post_author == $uid)
                        $owner = 1;
                    else
                        $owner = 0;

                    if (count($res) > 0) {
                        ?> 
                        <li class="widget-container widget_text">
                            <h3 class="widget-title"><?php _e('Job Aplicants', 'shipme') ?></h3>
                            <div class="my-only-widget-content " >
                                <?php
                                if ($private_bids == 'yes' or $private_bids == '1' or $private_bids == 1) {
                                    if ($owner == 1)
                                        $show_stuff = 1;
                                    else if (shipme_current_user_has_bid($uid, $res))
                                        $show_stuff = 1;
                                    else
                                        $show_stuff = 0;
                                } else
                                    $show_stuff = 1;

                                //------------

                                if ($show_stuff == 1):

                                    echo '<div id="my_bids" width="100%">';


                                endif;

                                //-------------
                                ?>
                                <table id="example" class="display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Bid Amount</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>       
                                    <tbody>
                                        <?php
                                        foreach ($res as $row) {

                                            if ($owner == 1)
                                                $show_this_around = 1;
                                            else {
                                                if ($private_bids == 'yes' or $private_bids == '1' or $private_bids == 1) {
                                                    if ($uid == $row->uid)
                                                        $show_this_around = 1;
                                                    else
                                                        $show_this_around = 0;
                                                } else
                                                    $show_this_around = 1;
                                            }

                                            if ($show_this_around == 1):

                                                $user = get_userdata($row->uid);
//						echo '<div class="myrow">';
//						echo '<div><i class="bid-person"></i> <a href="'.shipme_get_user_profile_link($user->ID).'">'.$user->user_login.'</a></div>';
//						echo '<div><i class="bid-money"></i>  '.shipme_get_show_price($row->bid).'</div>';
//						echo '<div><i class="bid-clock"></i> '.date_i18n("d-M-Y H:i:s", $row->date_made).'</div>';
//						echo '<div><i class="bid-days"></i> '. sprintf(__("%s days" ,"shipme"), $row->days_done) .'</div>';
//						if ($owner == 1 ) {
//							
//							$nr = 7;
//							if(empty($winner)) // == 0)
//								echo '<div><i class="bid-select"></i>  <a href="'.get_bloginfo('siteurl').'/?p_action=choose_winner&pid='.get_the_ID().'&bid='.$row->id.'">'.__('Select as Winner','shipme').'</a></div>';						
//							
//							if($shipme_enable_project_files != "no")
//							{
//								if(shipme_see_if_project_files_bid(get_the_ID(), $row->uid) == true)
//								{
//								echo '<div> <i class="bid-days"></i> ';								
//								echo '<a href="#" class="get_files" rel="'.get_the_ID().'_'.$row->uid.'">'.__('See Bid Files','shipme').'</a> ';							
//								echo '</div>';
//								}
//							
//							}
//							echo '<div><i class="bid-env"></i> <a href="'.shipme_get_priv_mess_page_url('send', '', '&uid='.$row->uid.'&pid='.get_the_ID()).'">'.__('Send Message','shipme').'</a></div>';
//						}
//						else $nr = 4;
//						
//						if($closed == "1") { if($row->winner == 1) echo '<div>'.__('Project Winner','shipme').'</div>';   }
//						
//						 
//						
//						 
//						echo '<div class="my_td_with_border">'.$row->description.'</div>';
//						echo '</div>';
//						endif;
//					}
//					
//					echo ' </div> ';
//				}
//				else { echo '<div class="padd10">';  '</div>'; }
                                                ?>	 
                                                <!--                </div>
                                                                        </li>-->

                                                <?php
                                                $currentuser = wp_get_current_user();
                                                $userRolesArry = $currentuser->roles;
                                                $contraLInk = '';

                                                if (in_array('transporter', $userRolesArry)) {
                                                    if (shipme_is_owner_of_post()) {
                                                        $contraLInk = '<td><a href="' . get_site_url() . '/user-profile/?user_id=' . $user->ID . '">' . $user->first_name . '</td>';
                                                    } else {
                                                        $contraLInk = '<td>' . $user->first_name . '</td>';
                                                    }
                                                } else {
                                                    $contraLInk = '<td><a href="' . get_site_url() . '/user-profile/?user_id=' . $user->ID . '">' . $user->first_name . '</td>';
                                                }
                                                ?>
                                                <?php
                                                $user = get_userdata($row->uid);

                                                echo ' <tr>';
                                                echo $contraLInk;
                                                //echo '<td>' . shipme_get_show_price($row->bid) . '</td>';
                                                echo '<td>' . $row->bid . ' Rs.</td>';
                                                echo '<td>' . $row->date_made . '</td>';
                                                echo ' </tr>';
                                                if ($owner == 1) {

                                                    $nr = 7;
                                                    if (empty($winner)) // == 0)
                                                        echo '<div><i class="bid-select"></i>  <a href="' . get_bloginfo('siteurl') . '/?p_action=choose_winner&pid=' . get_the_ID() . '&bid=' . $row->id . '">' . __('Select as Winner', 'shipme') . '</a></div>';

                                                    if ($shipme_enable_project_files != "no") {
                                                        if (shipme_see_if_project_files_bid(get_the_ID(), $row->uid) == true) {
                                                            echo '<div> <i class="bid-days"></i> ';
                                                            echo '<a href="#" class="get_files" rel="' . get_the_ID() . '_' . $row->uid . '">' . __('See Bid Files', 'shipme') . '</a> ';
                                                            echo '</div>';
                                                        }
                                                    }
                                                    echo '<div><i class="bid-env"></i> <a href="' . shipme_get_priv_mess_page_url('send', '', '&uid=' . $row->uid . '&pid=' . get_the_ID()) . '">' . __('Send Message', 'shipme') . '</a></div>';
                                                } else
                                                    $nr = 4;

                                                if ($closed == "1") {
                                                    if ($row->winner == 1)
                                                        echo '<div>' . __('Project Winner', 'shipme') . '</div>';
                                                }
                                                //echo '<div class="my_td_with_border">' . $row->description . '</div>';
                                                echo '</div>';
                                            endif;
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <?php
                                echo ' </div> ';
                                ?>
                            </div>
                        </li>
                        <?php
                    }
//        else {
////            echo '<div class="padd10">';
////            _e("No proposals placed yet.", 'shipme');
////            echo '</div>';
//        }
                    ?>	 



                    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.dataTables.min.js"></script>
                    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/natural.js"></script>

                    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/css/jquery.dataTables.min.css" />

                    <script type="text/javascript">
                                    jQuery(document).ready(function () {
                                        $('#example').DataTable({
                                            columnDefs: [
                                                {type: 'natural', targets: 2},
                                                {type: 'natural', targets: 1},
                                                // {type: 'natural', targets: 0}
                                            ]
                                        });

                                    });
                    </script>

                    <?php
                    $arr = shipme_get_post_images(get_the_ID());
                    if ($arr) {
                        ?>


                        <li class="widget-container widget_text">
                            <h3 class="widget-title"><?php _e('Picture Gallery', 'shipme') ?></h3>
                            <div class="my-only-widget-content " >


                                <?php
                                $xx_w = 600;
                                $shipme_width_of_project_images = get_option('shipme_width_of_project_images');

                                if (!empty($shipme_width_of_project_images))
                                    $xx_w = $shipme_width_of_project_images;
                                if (!is_numeric($xx_w))
                                    $xx_w = 600;

                                if ($arr) {


                                    echo '<ul class="image-gallery">';
                                    foreach ($arr as $image) {
                                        echo '<li><a href="' . shipme_generate_thumb($image, 900, $xx_w) . '" rel="image_gal2"><img src="' . shipme_generate_thumb($image, 100, 80) . '" width="100" class="img_class" /></a></li>';
                                    }
                                    echo '</ul>';
                                } else {
                                    echo __('There are no pictures attache.', 'shipme');
                                }
                                ?> 
                            </div>
                        </li>

                        <?php
                    }
                    ?>
                </ul>    
            </div>

            <!-- ##################### -->

            <div id="left-sidebar" class="account-right-sidebar col-xs-12 col-sm-4 col-lg-3  ">

                <ul class="virtual_sidebar" id="six-years2">


                    <li class="widget-container widget_text"> 
                        <div class="apply-for-this price-jb1">
        <?php echo shipme_get_show_price(get_post_meta(get_the_ID(), 'price', true)); ?>
                        </div>
                    </li>

                    <?php
                    $user = wp_get_current_user();
                    $userRolesArry = $user->roles;
                    // print_r($userRolesArry);
                    $contraLInk = '';
                    if ((!in_array('contractor', $userRolesArry))) {
                        if (!shipme_is_owner_of_post()) {
                            ?>
                            <li class="widget-container widget_text"> 
                                <div class="apply-for-this">
                                    <a href="#" class="get_bidding_panel ye_buut"   ><i class="fa fa-check-circle"></i> <?php _e('Apply for this job', 'shipme'); ?></a>
                                </div>
                            </li>

                            <?php
                        }
                    }
                    ?>

                    <!--                    <li class="widget-container widget_text">
                                            <h3 class="widget-title"><?php //_e('Item(s) Pickup', 'shipme')                                 ?></h3>
                                            <div class="my-only-widget-content " >
                    
                                                <ul class="rms1"> 
                                                    <li>   
                                                        <p class="rf1"><img src="<?php // bloginfo('template_url')                                 ?>/images/beachflag.png" /></p> 
                                                        <p class="rf2"><?php //echo get_post_meta(get_the_ID(), 'pickup_location', true);                                 ?></p>	
                                                    </li>
                                                </ul> 
                                            </div>
                                        </li>-->



                    <!--                    <li class="widget-container widget_text">
                                            <h3 class="widget-title"><?php //_e('Item(s) Delivery', 'shipme')                            ?></h3>
                                            <div class="my-only-widget-content " >
                    
                                                <ul class="rms1"> 
                                                    <li>   
                                                        <p class="rf1"><img src="<?php //bloginfo('template_url')                            ?>/images/finish.png" /></p> 
                                                        <p class="rf2"><?php //echo get_post_meta(get_the_ID(), 'delivery_location', true);                            ?></p>	
                                                    </li>
                                                </ul> 
                    
                    
                    
                                            </div>
                                        </li>-->



                    <li class="widget-container widget_text">
                        <h3 class="widget-title"><?php _e('Package Dimensions', 'shipme') ?></h3>
                        <div class="my-only-widget-content " >

                            <?php
                            $package_detail_display = get_post_meta($pid, 'package_detail', true);
                            if (count($package_detail_display) > 0 && is_array($package_detail_display)) {
                                foreach ($package_detail_display as $track) {
                                    ?>

                                    <ul class="rms1" > 
                                        <li>   
                                            <!--<p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/bullet_accept.png" width="22" /></p>--> 
                                            <p class="rf2">Quantity: <?php echo $track['num_of_package']; ?></p>
                                            <p class="rf2">Weight: <?php echo $track['weight'] . 'Kg'; ?></p>	
                                            <p class="rf2">Dimension: <?php echo $track['height'] . $track['dimention'] . ' (H) x ' . $track['width'] . $track['dimention'] . ' (W) x ' . $track['length'] . $track['dimention'] . ' (L)'; ?></p>	
                                        </li>


                                        <!--                                        <li>   
                                                                                    <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/bullet_accept.png" width="22" /></p> 
                                                                                    <p class="rf2">Height: <?php echo $track['height'] . $track['dimention']; ?></p>	
                                                                                </li>
                                        
                                        
                                                                                <li>   
                                                                                    <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/bullet_accept.png" width="22" /></p> 
                                                                                    <p class="rf2">Width: <?php echo $track['width'] . $track['dimention']; ?></p>	
                                                                                </li>
                                        
                                        
                                                                                <li>   
                                                                                    <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/bullet_accept.png" width="22" /></p> 
                                                                                    <p class="rf2">Length: <?php echo $track['length'] . $track['dimention']; ?></p>	
                                                                                </li>
                                        
                                                                                <li style="border-bottom: 1px solid #e7e7e7">   
                                                                                    <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/bullet_accept.png" width="22" /></p> 
                                                                                    <p class="rf2">Weight: <?php echo $track['weight'] . 'Kg'; ?></p>	
                                                                                </li>-->

                                    </ul> 
                                    <?php
                                }
                            }
                            ?>





                        </div>
                    </li>




                    <!--                    <li class="widget-container widget_text">
                                            <h3 class="widget-title"><?php _e('Attached Documents', 'shipme') ?></h3>
                                            <div class="my-only-widget-content " >-->
                    <?php
                    //---------------------
                    // build the exclude list
                    //---------------------
                    // build the exclude list
//                            $exclude = array();
//
//                            $args = array(
//                                'order' => 'ASC',
//                                'post_type' => 'attachment',
//                                'post_mime_type' => 'image',
//                                'post_parent' => $pid,
//                                'numberposts' => -1,
//                                'post_status' => null,
//                            );
//
//                            $attachments = get_posts($args);
//
//                            foreach ($attachments as $att)
//                                $exclude[] = $att->ID;
//
//                            //-0------------------
//
//
//
//                            $args = array(
//                                'order' => 'ASC',
//                                'post_type' => 'attachment',
//                                'meta_key' => 'is_bidding_file',
//                                'meta_value' => '1',
//                                'post_parent' => $pid,
//                                'numberposts' => -1,
//                                'post_status' => null,
//                            );
//
//                            $attachments = get_posts($args);
//
//                            foreach ($attachments as $att)
//                                $exclude[] = $att->ID;
//
//                            //------------------
//
//                            $args = array(
//                                'order' => 'ASC',
//                                'post_type' => 'attachment',
//                                'post_parent' => $pid,
//                                'exclude' => $exclude,
//                                'numberposts' => -1,
//                                'post_status' => null,
//                            );
//                            $attachments = get_posts($args);
//
//
//
//
//
//
//                            if (count($attachments) == 0)
//                                echo __('No document files.', 'shipme');
//
//                            foreach ($attachments as $at) {
                    ?>

                                                                                                                                                                                                                <!--                                <li> <a href="<?php echo wp_get_attachment_url($at->ID); ?>"><?php echo $at->post_title; ?></a>
                                                                                                                                                                                                                                                </li> -->
        <?php //}          ?>	

                    <!--                        </div>
                                        </li>-->

                    <!--                    <li class="widget-container widget_text"><div class="apply-for-this">
                                                 AddThis Button BEGIN 
                                                <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                                                    <a class="addthis_button_preferred_1"></a>
                                                    <a class="addthis_button_preferred_2"></a>
                                                    <a class="addthis_button_preferred_3"></a>
                                                    <a class="addthis_button_preferred_4"></a>
                                                    <a class="addthis_button_compact"></a>
                                                    <a class="addthis_counter addthis_bubble_style"></a>
                                                </div>
                                                <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4df68b4a2795dcd9"></script>
                                                 AddThis Button END 
                    
                                            </div></li>-->

                </ul>

            </div>


        </div>


    <?php endwhile; ?>
<?php
get_footer();
?>