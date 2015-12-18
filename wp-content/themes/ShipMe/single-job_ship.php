<?php

	function shipme_colorbox_stuff()
	{	
	
		echo '<link media="screen" rel="stylesheet" href="'.get_bloginfo('template_url').'/css/colorbox.css" />';
		/*echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>'; */
		echo '<script src="'.get_bloginfo('template_url').'/js/jquery.colorbox.js"></script>';
		
		$get_bidding_panel = 'get_bidding_panel';
		$get_bidding_panel = apply_filters('shipme_get_bidding_panel_string', $get_bidding_panel) ;
		
?>
		
		<script>
		
		var $ = jQuery;
		
			jQuery(document).ready(function(){
				
				jQuery("a[rel='image_gal1']").colorbox();
				jQuery("a[rel='image_gal2']").colorbox();
				
				
 
				
				jQuery('.get_bidding_panel').click( function () {
					
					var myRel = jQuery(this).attr('rel');
					 
					
					jQuery.colorbox({href: "<?php bloginfo('siteurl'); ?>/?get_bidding_panel=" + myRel  });
					return false;
				});
				
				
				jQuery("#report-this-link").click( function() {
					
					if(jQuery("#report-this").css('display') == 'none')					
					jQuery("#report-this").show('slow');
					else
					jQuery("#report-this").hide('slow');
					
					return false;
				});
				
				
				jQuery("#contact_seller-link").click( function() {
					
					if(jQuery("#contact-seller").css('display') == 'none')					
					jQuery("#contact-seller").show('slow');
					else
					jQuery("#contact-seller").hide('slow');
					
					return false;
				});
				
		});
		</script>

<?php
	}
	
	add_action('wp_head','shipme_colorbox_stuff');	

	
	get_header();
	global $post;

 
?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


<?php
	
	$pid = get_the_ID();
	
	$ending = get_post_meta($pid,'ending',true);
	$closed = get_post_meta($pid,'closed',true);

?>

<div class="container_ship_ttl_wrap_jb" >	
    <div class="container_ship_ttl_jb">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
            <h1 class="super-job-title"><?php the_title() ?></h1>
        </div>
    
        <?php 
    
            if(function_exists('bcn_display'))
            {
                echo '<div class="my_box3 no_padding  breadcrumb-wrap col-xs-12 col-sm-12 col-lg-12"><div class="padd10">';	
                bcn_display();
                echo '</div></div>';
            }
        ?>	
    
    </div>
</div>

<!-- ###################################### -->

<div id="map" style="width: 100%; height: 550px;border-bottom:1px solid #ccc; margin:auto"></div>
				
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript"> 
   


window.onload = function () {
	
	
	  var geocoder;
  	var map;
	var markers = [];
	 geocoder = new google.maps.Geocoder();
		
		 geocoder.geocode( { 'address': '<?php echo get_post_meta(get_the_ID(),'pickup_location',true) ?>'}, function(results, status) {  
      if (status == google.maps.GeocoderStatus.OK) {
        
 
  
  
		
		
		markers.push({
                "title": '<?php echo get_post_meta(get_the_ID(),'pickup_location',true) ?>',
                "lat": results[0].geometry.location.lat(),
                "lng": results[0].geometry.location.lng(),                 
				"icon": '<?php bloginfo('template_url') ?>/images/beachflag.png',
								"description": '<?php echo sprintf(__("<strong>Pickup:</strong> %s", 'shipme'), get_post_meta(get_the_ID(),'pickup_location',true) ) ?>'
            });
			
			
			geocoder2 = new google.maps.Geocoder();
				
						 geocoder2.geocode( { 'address': '<?php echo get_post_meta(get_the_ID(),'delivery_location',true) ?>'}, function(results2, status2) {
					  if (status2 == google.maps.GeocoderStatus.OK) {
						
						
						
						markers.push( {
								"title": '<?php echo get_post_meta(get_the_ID(),'delivery_location',true) ?>',
								"lat": results2[0].geometry.location.lat(),
								"lng": results2[0].geometry.location.lng(),                 
								"icon": '<?php bloginfo('template_url') ?>/images/finish.png',
								"description": '<?php echo sprintf(__("<strong>Delivery:</strong> %s", 'shipme'), get_post_meta(get_the_ID(),'delivery_location',true) ) ?>'
							});
							
							 
									//-------------------------
										
										
																				
												var mapOptions = {
													center: new google.maps.LatLng(markers[0].lat, markers[0].lng),
													zoom: 5,
													mapTypeId: google.maps.MapTypeId.ROADMAP
												};
												var map = new google.maps.Map(document.getElementById("map"), mapOptions);
												
map.set('styles', [{"featureType":"all","stylers":[{"saturation":0},{"hue":"#D1EDE8"}]},{"featureType":"road","stylers":[{"saturation":-70}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"visibility":"simplified"},{"saturation":-20}]}]);
												
												
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
												var poly = new google.maps.Polyline({ map: map, strokeColor: '#ff0000' });
										 
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
															
															jQuery('#distance_distance').html(Math.round(result.routes[0].legs[0].distance.value / 1000) + "<?php _e('Km','shipme') ?>");
															
															
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
			
           <?php if(shipme_is_owner_of_post()): ?>
            
            <li class="widget-container widget_text  ">
            <div class="my-only-widget-content ">
            	<?php
					
					$mm = '<a class="green_btn" href="">'.__('Edit Job','shipme').'</a> <a class="green_btn" href="">'.__('Delete Job','shipme').'</a>';
				
				?>
            	<?php printf(__('You are the owner of this job. Your options are: %s','shipme'), $mm); ?>
                </div>            
            </li>
            
            
            <?php endif; ?>
            
            <li class="widget-container widget_text  ">
            	<h3 class="widget-title"><?php _e('Main Details','shipme') ?></h3>
                <div class="my-only-widget-content " id='content-of-jb'>
             			
                        <ul class="main_details_1">
                        	<li>
                            	<h3><?php printf(__('%s Category:','shipme'), '<i class="fa fa-folder"></i>'); ?></h3>
                                <p><?php echo get_the_term_list( get_the_ID(), 'job_ship_cat', '', ', ', '' ); ?></p>
                            </li>
                            
                            
                            <li>
                            	<h3><?php printf(__('%s Distance:','shipme'), '<i class="fa fa-map"></i>'); ?></h3>
                                <p id="distance_distance"><?php echo __('calculating...','shipme'); ?></p>
                            </li>
                            
                            
                            <li>
                            	<h3><?php printf(__('%s Quotes:','shipme'), '<i class="fa fa-briefcase"></i>'); ?></h3>
                                <p><?php echo  shipme_number_of_bid( get_the_ID() ); ?></p>
                            </li>
                            
                            <li>
                            	<h3><?php printf(__('%s Date Listed:','shipme'), '<i class="fa fa-calendar"></i>'); ?></h3>
                                <p><?php the_time("jS F Y g:i A"); ?></p>
                            </li>
                            
                            
                            <?php if($closed == "1"): ?>
                            
                              <li>
                            	<h3><?php printf(__('%s Ending In:','shipme'), '<i class="fa fa-clock-o"></i>'); ?></h3>
                                <p class=" "><?php   echo __("Expired/Closed",'shipme') ; ?></p>
                            </li>
                            
                            
                            <?php else: ?>
                            <li>
                            	<h3><?php printf(__('%s Ending In:','shipme'), '<i class="fa fa-clock-o"></i>'); ?></h3>
                                <p class="expiration_project_p"><?php echo ($closed == "0" ?  ($ending - current_time('timestamp',0)) 
								: __("Expired/Closed",'shipme')); ?></p>
                            </li>
                            
                            <?php endif; ?>
                            
                            
                           
                            <li><h3>&nbsp;</h3></li>
                            
                            <li>
                            	<h3><?php printf(__('%s Pickup Longitude:','shipme'), '<i class="fa fa-location-arrow"></i>'); ?></h3>
                                <p><?php echo get_post_meta(get_the_ID(), 'pickup_lng',true); ?></p>
                            </li>
                            
                            <li>
                            	<h3><?php printf(__('%s Pickup Latitude:','shipme'), '<i class="fa fa-location-arrow"></i>'); ?></h3>
                                <p><?php echo get_post_meta(get_the_ID(), 'pickup_lat',true); ?></p>
                            </li>
                            
                            
                            <li><h3>&nbsp;</h3></li>
                            
                             <li>
                            	<h3><?php printf(__('%s Delivery Longitude:','shipme'), '<i class="fa fa-location-arrow"></i>'); ?></h3>
                                <p><?php echo get_post_meta(get_the_ID(), 'delivery_lat',true); ?></p>
                            </li>
                            
                            <li>
                            	<h3><?php printf(__('%s Delivery Latitude:','shipme'), '<i class="fa fa-location-arrow"></i>'); ?></h3>
                                <p><?php echo get_post_meta(get_the_ID(), 'delivery_lng',true); ?></p>
                            </li>
                        
                        </ul>
                        
                </div>
			</li>
            
            
			<li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Job Description','shipme') ?></h3>
                <div class="my-only-widget-content " id='content-of-jb'>
             			<?php the_content() ?>
                </div>
			</li>
            
            
            
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Job Aplicants','shipme') ?></h3>
                <div class="my-only-widget-content " >
             		<?php
				$shipme_enable_project_files = get_option('shipme_enable_project_files');
				$winner = get_post_meta(get_the_ID(), 'winner', true);
				$post = get_post(get_the_ID());
				global $wpdb;
				$pid = get_the_ID();
				
				$bids = "select * from ".$wpdb->prefix."ship_bids where pid='$pid' order by id DESC";
				$res  = $wpdb->get_results($bids);
			
				if($post->post_author == $uid) $owner = 1; else $owner = 0;
				
				if(count($res) > 0)
				{
					
					if($private_bids == 'yes' or $private_bids == '1' or $private_bids == 1)
					{
						if ($owner == 1) $show_stuff = 1;
						else if(shipme_current_user_has_bid($uid, $res)) $show_stuff = 1;
						else $show_stuff = 0;
					}
					else $show_stuff = 1;
					
					//------------
					
					if($show_stuff == 1):
					
						echo '<div id="my_bids" width="100%">';
						 
					
					endif;
					
					//-------------
					
					foreach($res as $row)
					{
						
						if ($owner == 1) $show_this_around = 1;
						else
						{
							if($private_bids == 'yes' or $private_bids == '1' or $private_bids == 1)
							{
								if($uid == $row->uid) 	$show_this_around = 1;
								else $show_this_around = 0;
							}
							else
							$show_this_around = 1;
							
						}
						 
						if($show_this_around == 1):
						
						$user = get_userdata($row->uid);
						echo '<div class="myrow">';
						echo '<div><i class="bid-person"></i> <a href="'.shipme_get_user_profile_link($user->ID).'">'.$user->user_login.'</a></div>';
						echo '<div><i class="bid-money"></i>  '.shipme_get_show_price($row->bid).'</div>';
						echo '<div><i class="bid-clock"></i> '.date_i18n("d-M-Y H:i:s", $row->date_made).'</div>';
						echo '<div><i class="bid-days"></i> '. sprintf(__("%s days" ,"shipme"), $row->days_done) .'</div>';
						if ($owner == 1 ) {
							
							$nr = 7;
							if(empty($winner)) // == 0)
								echo '<div><i class="bid-select"></i>  <a href="'.get_bloginfo('siteurl').'/?p_action=choose_winner&pid='.get_the_ID().'&bid='.$row->id.'">'.__('Select as Winner','shipme').'</a></div>';						
							
							if($shipme_enable_project_files != "no")
							{
								if(shipme_see_if_project_files_bid(get_the_ID(), $row->uid) == true)
								{
								echo '<div> <i class="bid-days"></i> ';								
								echo '<a href="#" class="get_files" rel="'.get_the_ID().'_'.$row->uid.'">'.__('See Bid Files','shipme').'</a> ';							
								echo '</div>';
								}
							
							}
							echo '<div><i class="bid-env"></i> <a href="'.shipme_get_priv_mess_page_url('send', '', '&uid='.$row->uid.'&pid='.get_the_ID()).'">'.__('Send Message','shipme').'</a></div>';
						}
						else $nr = 4;
						
						if($closed == "1") { if($row->winner == 1) echo '<div>'.__('Project Winner','shipme').'</div>';   }
						
						 
						
						 
						echo '<div class="my_td_with_border">'.$row->description.'</div>';
						echo '</div>';
						endif;
					}
					
					echo ' </div> ';
				}
				else { echo '<div class="padd10">'; _e("No proposals placed yet.",'shipme'); echo '</div>'; }
				?>	 
                </div>
			</li>
            
            
            
            
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Picture Gallery','shipme') ?></h3>
                <div class="my-only-widget-content " >
              
                    
                    <?php
				
				$arr = shipme_get_post_images(get_the_ID());
				$xx_w = 600;
				$shipme_width_of_project_images = get_option('shipme_width_of_project_images');
				
				if(!empty($shipme_width_of_project_images)) $xx_w = $shipme_width_of_project_images;
				if(!is_numeric($xx_w)) $xx_w = 600;
				
				if($arr)
				{
					
				
				echo '<ul class="image-gallery">';
				foreach($arr as $image)
				{
					echo '<li><a href="'.shipme_generate_thumb($image, 900,$xx_w).'" rel="image_gal2"><img src="'.shipme_generate_thumb($image, 100,80).'" width="100" class="img_class" /></a></li>';
				}
				echo '</ul>';
				
				}
				else { echo __('There are no pictures attache.','shipme') ;}
				
				?> 
                </div>
			</li>
            
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Extra Requirements','shipme') ?></h3>
                <?php if(get_field('need_a_helper', $pid, true)=='1'){ ?>
                <div class="my-only-widget-content " id='content-of-jb'>
             			<?php
							echo 'Need Helper For Carry Package';
							?>
							
                </div>
			<?php	} ?>
            
            <?php if(get_field('fragile_materials', $pid, true)=='1'){ ?>
                <div class="my-only-widget-content " id='content-of-jb'>
             			<?php
							echo 'There is Fragile Materials';
							?>
							
                </div>
			<?php	} ?>
            
            <?php if(get_field('commercial_purpose', $pid, true)=='1'){ ?>
                <div class="my-only-widget-content " id='content-of-jb'>
             			<?php
							echo 'For Commercial Purpose';
							?>
							
                </div>
			<?php	} ?>
            
            <?php if(get_field('packing_services', $pid, true)=='1'){ ?>
                <div class="my-only-widget-content " id='content-of-jb'>
             			<?php
							echo 'Packing Services';
							?>
							
                </div>
			<?php	} ?>
			</li>
            
            
        </ul>    
    </div>
    
    <!-- ##################### -->
    
    <div id="left-sidebar" class="account-right-sidebar col-xs-12 col-sm-4 col-lg-3  ">
    	
        <ul class="virtual_sidebar" id="six-years2">
			
            
            <li class="widget-container widget_text"> 
			<div class="apply-for-this price-jb1">
            	<?php echo shipme_get_show_price(get_post_meta(get_the_ID(),'price',true)); ?>
            </div>
            </li>
            
            
            
			<li class="widget-container widget_text"> 
			<div class="apply-for-this">
			 		<a href="#" class="get_bidding_panel ye_buut"   ><i class="fa fa-check-circle"></i> <?php _e('Apply for this job','shipme'); ?></a>
            </div>
			</li>
            
            
            
             <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Item(s) Pickup','shipme') ?></h3>
                <div class="my-only-widget-content " >
             			
                    <ul class="rms1"> 
                        <li>   
                                <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/beachflag.png" /></p> 
                                <p class="rf2"><?php echo get_post_meta(get_the_ID(),'pickup_location',true); ?></p>	
                        </li>
                    </ul> 
                </div>
			</li>
            
            
            
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Item(s) Delivery','shipme') ?></h3>
                <div class="my-only-widget-content " >
                
                 <ul class="rms1"> 
                        <li>   
                                <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/finish.png" /></p> 
                                <p class="rf2"><?php echo get_post_meta(get_the_ID(),'delivery_location',true); ?></p>	
                        </li>
                    </ul> 
                
                
             	 
                </div>
			</li>
            
            
            
             <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Package Dimensions','shipme') ?></h3>
                <div class="my-only-widget-content " >
             		  	
                     	  	<?php  $package_detail_display = get_post_meta($pid,'package_detail',true);
						if ( count( $package_detail_display ) > 0 && is_array($package_detail_display) ) {
							foreach( $package_detail_display as $track ) {
								?>
                                
                                <ul class="rms1" > 
                        <li>   
                                <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/bullet_accept.png" width="22" /></p> 
                                <p class="rf2">Number Of Package: <?php echo $track['num_of_package']; ?></p>	
                        </li>
                        
                        
                         <li>   
                                <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/bullet_accept.png" width="22" /></p> 
                                <p class="rf2">Height: <?php echo $track['height'].'cm'; ?></p>	
                        </li>
                        
                        
                         <li>   
                                <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/bullet_accept.png" width="22" /></p> 
                                <p class="rf2">Width: <?php echo $track['width'].'cm'; ?></p>	
                        </li>
                        
                        
                         <li>   
                                <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/bullet_accept.png" width="22" /></p> 
                                <p class="rf2">Length: <?php echo $track['length'].'cm'; ?></p>	
                        </li>
                        
                        <li style="border-bottom: 1px solid #e7e7e7">   
                                <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/bullet_accept.png" width="22" /></p> 
                                <p class="rf2">Weight: <?php echo $track['weight'].'kg'; ?></p>	
                        </li>
                        
                    </ul> 
                                <?php
							}
						}
						 ?>
                        
                        
                      
                        
                        
                </div>
			</li>
            
            
            
                 
             <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Attached Documents','shipme') ?></h3>
                <div class="my-only-widget-content " >
               <?php
			    	//---------------------
	// build the exclude list
	//---------------------
	// build the exclude list
		$exclude = array();
		
	$args = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'post_mime_type' => 'image',
	'post_parent'    => $pid,
	'numberposts'    => -1,
	'post_status'    => null,
	);
	
	$attachments = get_posts($args);
 
	foreach($attachments as $att) $exclude[] = $att->ID;
	
	//-0------------------
	
	
	
	$args = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'meta_key' => 'is_bidding_file',
	'meta_value' => '1',
	'post_parent'    => $pid,
	'numberposts'    => -1,
	'post_status'    => null,
	);
	
	$attachments = get_posts($args);
 
	foreach($attachments as $att) $exclude[] = $att->ID;
	
	//------------------
	
	$args = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'post_parent'    => $pid,
	'exclude'    => $exclude, 
	'numberposts'    => -1,
	'post_status'    => null,
	);
	$attachments = get_posts($args);

	

	 

				
				if(count($attachments) == 0) echo __('No document files.','shipme');
				
				foreach($attachments as $at)
				{
					 
			
					 
				?>
                
                <li> <a href="<?php echo wp_get_attachment_url($at->ID); ?>"><?php echo $at->post_title; ?></a>
				</li> 
			<?php }   ?>	
                
                </div>
                </li>
            
              <li class="widget-container widget_text"><div class="apply-for-this">
            <!-- AddThis Button BEGIN -->
							<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
							<a class="addthis_button_preferred_1"></a>
							<a class="addthis_button_preferred_2"></a>
							<a class="addthis_button_preferred_3"></a>
							<a class="addthis_button_preferred_4"></a>
							<a class="addthis_button_compact"></a>
							<a class="addthis_counter addthis_bubble_style"></a>
							</div>
							<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4df68b4a2795dcd9"></script>
							<!-- AddThis Button END -->
            
            </div></li>
            
            </ul>
    
    </div>
    
    
    </div>
				

<?php endwhile; ?>

<?php
	get_footer();
?>