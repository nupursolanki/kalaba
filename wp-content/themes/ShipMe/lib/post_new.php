<?php
//******************************************
//
//	Shipme theme- theme started on aug 2015
//	www.sitemile.com
//
//******************************************

function shipme_theme_post_new_function()
{
    
            if (isset($_GET['jobid'])) {
        $jobid = $_GET['jobid'];
        //echo $jobid;
        if (is_user_logged_in()) {
            $post_tmp = get_post($_GET['jobid']);
            $author_id = $post_tmp->post_author;
            if (get_current_user_id() == $author_id) {
               // wp_delete_post($jobid,TRUE); 
                //echo '<div class="total-content-area note-note ">Job Deleted Successfully</div>';
                //echo 'user can edit';exit;
            }
            else
            {
              echo '<div class="total-content-area note-note ">You Can not able To Edit Job.</div>';exit;  
                ?>
<!--<div class="total-content-area note-note ">You Can't Able To Delete This Job</div>-->
<?php
            }
        }
    }

	ob_start();
	
	global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;
 	
	$new_job_step =  $_GET['post_new_step'];
	if(empty($new_job_step)) $new_job_step = 1;
	
	$pid = $_GET['jobid'];
	$post = get_post($pid);
	
?>	

<div class="container_ship_ttl_wrap">	
    <div class="container_ship_ttl">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
            <?php _e('Post New Job','shipme') ?>
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


<div class="container_ship_no_bk">
<div class="total-content-area col-xs-12 col-sm-12 col-lg-12">

 	    <div id="steps">
        <ul>
            <li <?php if($new_job_step == 1): ?> class="active" <?php endif; ?>> <?php echo __('Job Info','shipme') ?> </li>
            <li <?php if($new_job_step == 2): ?> class="active" <?php endif; ?>> <?php echo __('Add Extra Options','shipme') ?></li>
            <li <?php if($new_job_step == 3): ?> class="active" <?php endif; ?>> <?php echo __('Review Job','shipme') ?> </li>
            <li <?php if($new_job_step == 4): ?> class="active" <?php endif; ?>> <?php echo __('Publish','shipme') ?> </li>
 		</ul>
   		</div>
 
<?php
if($new_job_step == "4")
{

	$ending = get_post_meta($pid,'ending',true);
	$closed = get_post_meta($pid,'closed',true);
 

?>
    



<?php 

$catid = shipme_get_job_primary_cat($pid);
	$shipme_get_images_cost_extra = shipme_get_images_cost_extra($pid);
	

	
	//--------------------------------------------------
	// hide job from search engines fee calculation
	
	$shipme_hide_job_fee = get_option('shipme_hide_job_fee');
	if(!empty($shipme_hide_job_fee))
	{
		$opt = get_post_meta($pid,'hide_job',true);
		if($opt == "0") $shipme_hide_job_fee = 0;
		
		
	} else $shipme_hide_job_fee = 0;
	
	
	//---------------------
	
	$made_me_date 	= get_post_meta($pid,'made_me_date',true);
	$tms 			= current_time('timestamp',0);
	$shipme_job_period = get_option('shipme_job_period');
	if(empty($shipme_job_period)) $shipme_job_period = 30;
	
	
	if(empty($made_me_date))
	{
		$ee = $tms + 3600*24*$shipme_job_period;
		update_post_meta($pid,'ending',$ee);		
	}
	else
	{
		$ee = get_post_meta($pid, 'ending', true) + $tms - $made_me_date;
		update_post_meta($pid,'ending',$ee);	
	}
	

	//-------------------------------------------------------------------------------
	// sealed bidding fee calculation
	
	$shipme_sealed_bidding_fee = get_option('shipme_sealed_bidding_fee');
	if(!empty($shipme_sealed_bidding_fee))
	{
		$opt = get_post_meta($pid,'private_bids',true);
		if($opt == "0") { $shipme_sealed_bidding_fee = 0; }
		
		 
	} else $shipme_sealed_bidding_fee = 0;

	
	//-------
	
	$featured	 = get_post_meta($pid, 'featured', true);
	$feat_charge = get_option('shipme_featured_fee');
	
	if($featured != "1" ) $feat_charge = 0;
	

	
	
	$custom_set = get_option('shipme_enable_custom_posting');
	if($custom_set == 'yes')
	{
		$posting_fee = get_option('shipme_theme_custom_cat_'.$catid);
		if(empty($posting_fee)) $posting_fee = 0;		
	}
	else
	{
		$posting_fee = get_option('shipme_base_fee');
	}
	
	$total = $feat_charge + $posting_fee + $shipme_sealed_bidding_fee + $shipme_hide_job_fee + $shipme_get_images_cost_extra;
	
	//-----------------------------------------------
	
		$payment_arr = array();
		
		$base_fee_paid 	= get_post_meta($pid, 'base_fee_paid', true);
		
		if($base_fee_paid != "1" and $posting_fee > 0)
		{
			$my_small_arr = array();
			$my_small_arr['fee_code'] 		= 'base_fee';
			$my_small_arr['show_me'] 		= true;
			$my_small_arr['amount'] 		= $posting_fee;
			$my_small_arr['description'] 	= __('Base Fee','shipme');
			array_push($payment_arr, $my_small_arr);
		}
		//-----------------------
		
		
		$my_small_arr = array();
		$my_small_arr['fee_code'] 		= 'extra_img';
		$my_small_arr['show_me'] 		= true;
		$my_small_arr['amount'] 		= $shipme_get_images_cost_extra;
		$my_small_arr['description'] 	= __('Extra Images Fee','shipme');
		array_push($payment_arr, $my_small_arr);
		//------------------------
		
		$featured_paid  	= get_post_meta($pid,'featured_paid',true);
		$opt 				= get_post_meta($pid,'featured',true);
 
		
		if($feat_charge > 0 and $featured_paid != 1 and $opt == 1)
		{
			$my_small_arr = array();
			$my_small_arr['fee_code'] 		= 'feat_fee';
			$my_small_arr['show_me'] 		= true;
			$my_small_arr['amount'] 		= $feat_charge;
			$my_small_arr['description'] 	= __('Featured Fee','shipme');
			array_push($payment_arr, $my_small_arr);
			//------------------------
		}
		
		$private_bids_paid  = get_post_meta($pid,'private_bids_paid',true);
		$opt 				= get_post_meta($pid,'private_bids',true);
 
		
		if($shipme_sealed_bidding_fee > 0 and $private_bids_paid != 1  and ($opt == 1 or $opt == "yes"))
		{
		
			$my_small_arr = array();
			$my_small_arr['fee_code'] 		= 'sealed_job';
			$my_small_arr['show_me'] 		= true;
			$my_small_arr['amount'] 		= $shipme_sealed_bidding_fee;
			$my_small_arr['description'] 	= __('Sealed Bidding Fee','shipme');
			array_push($payment_arr, $my_small_arr);
		//------------------------
		}
		
		$hide_job_paid 	= get_post_meta($pid,'hide_job_paid',true);
		$opt 				= get_post_meta($pid,'hide_job',true);
		
		if($shipme_hide_job_fee > 0 and $hide_job_paid != "1" and ($opt == "1" or $opt == "yes"))
		{
		
			$my_small_arr = array();
			$my_small_arr['fee_code'] 		= 'hide_job';
			$my_small_arr['show_me'] 		= true;
			$my_small_arr['amount'] 		= $shipme_hide_job_fee;
			$my_small_arr['description'] 	= __('Hide Job From Search Engines Fee','shipme');
			array_push($payment_arr, $my_small_arr);
		
		}
		
		$payment_arr 	= apply_filters('shipme_filter_payment_array', $payment_arr, $pid);
		$new_total 		= 0;
		
		foreach($payment_arr as $payment_item):			
			if($payment_item['amount'] > 0):				
				$new_total += $payment_item['amount'];			
			endif;			
		endforeach;
		
	//-----------------------------------------------
	
	$post 			= get_post($pid);
	$admin_email 	= get_bloginfo('admin_email');

	
	$total = apply_filters('shipme_filter_payment_total', $new_total, $pid);
	
	//----------------------------------------
	$finalize = isset($_GET['finalize']) ? true : false;
	update_post_meta($pid, 'finalised_posted', '1');
  
	//-----------
	
	if($total == 0)
	{
			echo '<div class="txtalign" >';
			echo __('Thank you for posting your job with us.','shipme');
			update_post_meta($pid, "paid", "1");
			
			
			
				if(get_option('shipme_admin_approves_each_job') == 'yes')
				{
					$my_post = array();
					$my_post['ID'] = $pid;
					$my_post['post_status'] = 'draft';
	
					wp_update_post( $my_post );
	
					if($finalize == true){
						shipme_send_email_posted_job_not_approved($pid);
						shipme_send_email_posted_job_not_approved_admin($pid);
					}
					
					echo '<br/>'.__('Your job isn`t live yet, the admin needs to approve it.', 'shipme');
				
				}
				else
				{
					$my_post = array();
					$my_post['ID'] = $pid;
					$my_post['post_status'] = 'publish';
					
					if($finalize == true){
					
						wp_update_post( $my_post );
						wp_publish_post( $pid );
						
						
						shipme_send_email_posted_job_approved($pid);
						shipme_send_email_posted_job_approved_admin($pid);
						
						shipme_send_email_subscription($pid);
					
					}
				}
			 
			echo '</div>';
			
	
	}
	else
	{
			update_post_meta($pid, "paid", "0");
			
			echo '<div >';
			echo __('Thank you for posting your job with us. Below is the total price that you need to pay in order to put your job live.<br/>
			Click the pay button and you will be redirected...', 'shipme');
			echo '</div>';
			
	 
	}
	
	//----------------------------------------
	
	echo '<table style="margin-top:25px">';
	
	$show_payment_table = true;
	$show_payment_table = apply_filters('shipme_filter_payment_show_table', $show_payment_table, $pid);
	
	if($show_payment_table == true and $total > 0)
	{
		

		foreach($payment_arr as $payment_item):
			
			if($payment_item['amount'] > 0):
			
				echo '<tr>';
				echo '<td>'.$payment_item['description'].'&nbsp; &nbsp;</td>';
				echo '<td>'.shipme_get_show_price($payment_item['amount'],2).'</td>';
				echo '</tr>';

			endif;
			
		endforeach;
	
		
		
		
		echo '<tr>';
		echo '<td>&nbsp;</td>';
		echo '<td></td>';
		echo '</tr>';
		
		
		echo '<tr>';
		echo '<td><strong>'.__('Total to Pay','shipme').'</strong></td>';
		echo '<td><strong>'.shipme_get_show_price($total,2).'</strong></td>';
		echo '</tr>';
		
		$shipme_enable_credits_wallet = get_option('shipme_enable_credits_wallet');
		if($shipme_enable_credits_wallet != 'no'):
		
			echo '<tr>';
			echo '<td><strong>'.__('Your Total Credits','shipme').'</strong></td>';
			echo '<td><strong>'.shipme_get_show_price(shipme_get_credits($uid),2).'</strong></td>';
			echo '</tr>';
		
		endif;
		
		echo '<tr>';
		echo '<td>&nbsp;<br/>&nbsp;</td>';
		echo '<td></td>';
		echo '</tr>';
	
	}//endif show this table
	
	if($total == 0 && $finalize == true)
	{
		if(get_option('shipme_admin_approves_each_job') != 'yes'):
		
			echo '<tr>';
			echo '<td></td>';
			echo '<td><div class="clear100"></div><a href="'.get_permalink($pid).'" class="go_back_btn">'.__('See your job','shipme') .'</a></td>';
			echo '</tr>';	
		
		else:
			
			echo '<tr>';
			echo '<td></td>';
			echo '<td><a href="'.get_permalink(get_option('shipme_my_account_page_id')).'" class="go_back_btn">'.__('Go to your account','shipme') .'</a></td>';
			echo '</tr>';	
				
		endif;
		
		echo '</table>';
	}
	elseif($total > 0)
	{
			echo '</table>';
		update_post_meta($pid,'unpaid','1');
		
		
		
						$shipme_enable_credits_wallet = get_option('shipme_enable_credits_wallet');
						if($shipme_enable_credits_wallet != 'no'):
							echo '<a href="'.get_bloginfo('siteurl').'/?p_action=credits_listing&pid='.$pid.'" class="edit_job_pay_cls">'.__('Pay by Credits','shipme').'</a>';
						endif;
						
						global $job_ID;
						$job_ID = $pid;
						
						//-------------------
					
						$shipme_paypal_enable 		= get_option('shipme_paypal_enable');
						$shipme_alertpay_enable 		= get_option('shipme_alertpay_enable');
						$shipme_moneybookers_enable 	= get_option('shipme_moneybookers_enable');
						
						
						if($shipme_paypal_enable == "yes")
							echo '<a href="'.get_bloginfo('siteurl').'/?p_action=paypal_listing&pid='.$pid.'" class="edit_job_pay_cls">'.__('Pay by PayPal','shipme').'</a>';
						
						if($shipme_moneybookers_enable == "yes")
							echo '<a href="'.get_bloginfo('siteurl').'/?p_action=mb_listing&pid='.$pid.'" class="edit_job_pay_cls">'.__('Pay by MoneyBookers/Skrill','shipme').'</a>';
						
						if($shipme_alertpay_enable == "yes")
							echo '<a href="'.get_bloginfo('siteurl').'/?p_action=payza_listing&pid='.$pid.'" class="edit_job_pay_cls">'.__('Pay by Payza','shipme').'</a>';
						
						do_action('shipme_add_payment_options_to_post_new_job', $pid);
						
	
	
	} else  { echo '</table>'; }
	
	
	echo '<div class="clear10"></div>';
	echo '<div class="clear10"></div>';
	echo '<div class="clear10"></div>';
	
	echo '<div class="padd10">';
 
	if($total == 0 && $finalize == false)
	{
	 
		?>
        
        
            <ul class="post-new">
             <li class="czchk1">      	
                       <p><a href="<?php echo shipme_post_new_with_pid_stuff_thg($pid, '3'); ?>" class="submit_bottom2" ><i class="fa fa-backward"></i> <?php _e('Go Back','shipme'); ?></a>
                        <a href="<?php echo shipme_post_new_with_pid_stuff_thg($pid, '4','finalize'); ?>" class="submit_bottom2"    ><i class="fa fa-check-circle"></i> <?php _e('Finalize Job Posting','shipme'); ?></a>
                       </p>
                </li>
             </ul>   
        
        
        <?php
	
	}
	
	echo '</div>';





  } 
 
        

if($new_job_step == "3")
{

	$ending = get_post_meta($pid,'ending',true);
	$closed = get_post_meta($pid,'closed',true);
 

?>

<ul class="post-new">
 <li class="czchk1">      	
           <p><a href="<?php echo shipme_post_new_with_pid_stuff_thg($pid, '2'); ?>" class="submit_bottom2" ><i class="fa fa-backward"></i> <?php _e('Go Back','shipme'); ?></a>
            <a href="<?php echo shipme_post_new_with_pid_stuff_thg($pid, '4'); ?>" class="submit_bottom2"    ><i class="fa fa-check-circle"></i> <?php _e('Publish Job','shipme'); ?></a>
           </p>
    </li>
 </ul>       

</div>

 <div class="container_ship_no_bk mrg_topo">
    
    <div id="map" style="width: 100%; height: 550px; margin-bottom:15px !important; border-radius:5px; margin:auto; border:1px solid #ccc"></div>
    <?php
		echo '<link media="screen" rel="stylesheet" href="'.get_bloginfo('template_url').'/css/colorbox.css" />';
		/*echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>'; */
		echo '<script src="'.get_bloginfo('template_url').'/js/jquery.colorbox.js"></script>';
	
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
        
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
<script type="text/javascript"> 
   


window.onload = function () {
	
	
	  var geocoder;
  	var map;
	var markers = [];
	 geocoder = new google.maps.Geocoder();
		
		 geocoder.geocode( { 'address': '<?php echo get_post_meta($pid,'pickup_location',true) ?>'}, function(results, status) {  
      if (status == google.maps.GeocoderStatus.OK) {
        
 
  
  
		
		
		markers.push({
                "title": '<?php echo get_post_meta($pid,'pickup_location',true) ?>',
                "lat": results[0].geometry.location.lat(),
                "lng": results[0].geometry.location.lng(),                 
				"icon": '<?php bloginfo('template_url') ?>/images/beachflag.png',
								"description": '<?php echo sprintf(__("<strong>Pickup:</strong> %s", 'shipme'), get_post_meta($pid,'pickup_location',true) ) ?>'
            });
			
			
			geocoder2 = new google.maps.Geocoder();
				
						 geocoder2.geocode( { 'address': '<?php echo get_post_meta($pid,'delivery_location',true) ?>'}, function(results2, status2) {
					  if (status2 == google.maps.GeocoderStatus.OK) {
						
						
						
						markers.push( {
								"title": '<?php echo get_post_meta($pid,'delivery_location',true) ?>',
								"lat": results2[0].geometry.location.lat(),
								"lng": results2[0].geometry.location.lng(),                 
								"icon": '<?php bloginfo('template_url') ?>/images/finish.png',
								"description": '<?php echo sprintf(__("<strong>Delivery:</strong> %s", 'shipme'), get_post_meta($pid,'delivery_location',true) ) ?>'
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
    
    
    
    
    <div class="job-content-area col-xs-12 col-sm-8 col-lg-9">
    	<ul class="virtual_sidebar" id="six-years">
			
           
            <li class="widget-container widget_text  ">
            	<h3 class="widget-title"><?php _e('Main Details','shipme') ?></h3>
                <div class="my-only-widget-content " id='content-of-jb'>
             			
                        <ul class="main_details_1">
                        	<li>
                            	<h3><?php printf(__('%s Category:','shipme'), '<i class="fa fa-folder"></i>'); ?></h3>
                                <p><?php echo get_the_term_list( $pid, 'job_ship_cat', '', ', ', '' ); ?></p>
                            </li>
                            
                            
                            <li>
                            	<h3><?php printf(__('%s Distance:','shipme'), '<i class="fa fa-map"></i>'); ?></h3>
                                <p id="distance_distance"><?php echo __('calculating...','shipme'); ?></p>
                            </li>
                            
                            
                            <li>
                            	<h3><?php printf(__('%s Quotes:','shipme'), '<i class="fa fa-briefcase"></i>'); ?></h3>
                                <p><?php echo  shipme_number_of_bid( $pid ); ?></p>
                            </li>
                            
                            <li>
                            	<h3><?php printf(__('%s Date Listed:','shipme'), '<i class="fa fa-calendar"></i>'); ?></h3>
                                <p><?php the_time("jS F Y g:i A"); ?></p>
                            </li>
                            
                            
                            <li>
                            	<h3><?php printf(__('%s Ending In:','shipme'), '<i class="fa fa-clock-o"></i>'); ?></h3>
                                <p class="expiration_job_p"><?php echo ($closed == "0" ?  ($ending - current_time('timestamp',0)) 
								: __("Expired/Closed",'shipme')); ?></p>
                            </li>
                            
                            
                            
                            
                           
                            <li><h3>&nbsp;</h3></li>
                            
                            <li>
                            	<h3><?php printf(__('%s Pickup Longitude:','shipme'), '<i class="fa fa-location-arrow"></i>'); ?></h3>
                                <p><?php echo get_post_meta($pid, 'pickup_lng',true); ?></p>
                            </li>
                            
                            <li>
                            	<h3><?php printf(__('%s Pickup Latitude:','shipme'), '<i class="fa fa-location-arrow"></i>'); ?></h3>
                                <p><?php echo get_post_meta($pid, 'pickup_lat',true); ?></p>
                            </li>
                            
                            
                            <li><h3>&nbsp;</h3></li>
                            
                             <li>
                            	<h3><?php printf(__('%s Delivery Longitude:','shipme'), '<i class="fa fa-location-arrow"></i>'); ?></h3>
                                <p><?php echo get_post_meta($pid, 'delivery_lat',true); ?></p>
                            </li>
                            
                            <li>
                            	<h3><?php printf(__('%s Delivery Latitude:','shipme'), '<i class="fa fa-location-arrow"></i>'); ?></h3>
                                <p><?php echo get_post_meta($pid, 'delivery_lng',true); ?></p>
                            </li>
                        
                        </ul>
                        
                </div>
			</li>
            
            
			<li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Job Description','shipme') ?></h3>
                <div class="my-only-widget-content " id='content-of-jb'>
             			<?php $postat = get_post($pid); echo $postat->post_content; ?>
                </div>
			</li>
            
            
            
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Job Aplicants','shipme') ?></h3>
                <div class="my-only-widget-content " >
             		<?php
				$shipme_enable_job_files = get_option('shipme_enable_job_files');
				$winner = get_post_meta($pid, 'winner', true);
				$post = get_post($pid);
				global $wpdb;
				$pid = $pid;
				
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
								echo '<div><i class="bid-select"></i>  <a href="'.get_bloginfo('siteurl').'/?p_action=choose_winner&pid='.$pid.'&bid='.$row->id.'">'.__('Select as Winner','shipme').'</a></div>';						
							
							if($shipme_enable_job_files != "no")
							{
								if(shipme_see_if_job_files_bid($pid, $row->uid) == true)
								{
								echo '<div> <i class="bid-days"></i> ';								
								echo '<a href="#" class="get_files" rel="'.$pid.'_'.$row->uid.'">'.__('See Bid Files','shipme').'</a> ';							
								echo '</div>';
								}
							
							}
							echo '<div><i class="bid-env"></i> <a href="'.shipme_get_priv_mess_page_url('send', '', '&uid='.$row->uid.'&pid='.$pid).'">'.__('Send Message','shipme').'</a></div>';
						}
						else $nr = 4;
						
						if($closed == "1") { if($row->winner == 1) echo '<div>'.__('Job Winner','shipme').'</div>';   }
						
						 
						
						 
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
				
				$arr = shipme_get_post_images($pid);
				$xx_w = 600;
				$shipme_width_of_job_images = get_option('shipme_width_of_job_images');
				
				if(!empty($shipme_width_of_job_images)) $xx_w = $shipme_width_of_job_images;
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
            	<?php echo shipme_get_show_price(get_post_meta($pid,'price',true)); ?>
            </div>
            </li>
            
 
            
            
             <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Item(s) Pickup','shipme') ?></h3>
                <div class="my-only-widget-content " >
             			
                    <ul class="rms1"> 
                        <li>   
                                <p class="rf1"><img src="<?php bloginfo('template_url') ?>/images/beachflag.png" /></p> 
                                <p class="rf2"><?php echo get_post_meta($pid,'pickup_location',true); ?></p>	
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
                                <p class="rf2"><?php echo get_post_meta($pid,'delivery_location',true); ?></p>	
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

<div>
<!-- ################################################################# -->

<?php

}

if($new_job_step == "2")
{

	?>
    <form method="post"  id="post-new-form" action="<?php echo shipme_post_new_with_pid_stuff_thg($pid, '2');?>">  
 	<input type="hidden" value="11" name="job_submit_step2" />
    
    <ul class="post-new">
     <li>
        	<h3><?php _e('Attach Images','shipme'); ?></h3>
        </li>
        
        
        <li>
        <div class="cross_cross">

 
    
	<script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/js/dropzone.js"></script>     
	<link rel="stylesheet" href="<?php echo get_bloginfo('template_url'); ?>/css/dropzone.css" type="text/css" />
 
    
    
    <script>
 
	
	jQuery(function() {

Dropzone.autoDiscover = false; 	 
var myDropzoneOptions = {
  maxFilesize: 15,
    addRemoveLinks: true,
	acceptedFiles:'image/*',
    clickable: true,
	url: "<?php bloginfo('siteurl') ?>/?my_upload_of_job_files2=1",
};
 
var myDropzone = new Dropzone('div#myDropzoneElement2', myDropzoneOptions);

myDropzone.on("sending", function(file, xhr, formData) {
  formData.append("author", "<?php echo $cid; ?>"); // Will send the filesize along with the file as POST data.
  formData.append("ID", "<?php echo $pid; ?>"); // Will send the filesize along with the file as POST data.
});

   
    <?php

		$args = array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'attachment',
	'post_parent'    => $pid,
	'post_status'    => null,
	'post_mime_type' => 'image',
	'numberposts'    => -1,
	);
	$attachments = get_posts($args);
	
	if($pid > 0)
	if ($attachments) 
	{
	    foreach ($attachments as $attachment) 
		{
			$url = $attachment->guid;
			$imggg = $attachment->post_mime_type; 
			$url = wp_get_attachment_url($attachment->ID);	 
				
				?>	
						var mockFile = { name: "<?php echo $attachment->post_title ?>", size: <?php echo filesize( get_attached_file( $attachment->ID ) ) ?>, serverId: '<?php echo $attachment->ID ?>' };
						myDropzone.options.addedfile.call(myDropzone, mockFile);
						myDropzone.options.thumbnail.call(myDropzone, mockFile, "<?php echo shipme_generate_thumb($attachment->ID, 100, 100) ?>");						 
				
				<?php			
	 	}
	}

	?>
 
	myDropzone.on("success", function(file, response) {
    /* Maybe display some more file information on your page */
	 file.serverId = response;
	 file.thumbnail = "<?php echo bloginfo('template_url') ?>/images/file_icon.png";
	 
	   
  });
  
  
myDropzone.on("removedfile", function(file, response) {
    /* Maybe display some more file information on your page */
	  delete_this2(file.serverId);
	 
  });  	
	
	});
	
	</script>

    

	<?php _e('Click the grey area below to add job images. Other files are not accepted. Use the form below.','shipme') ?>
    <div class="dropzone dropzone-previews" id="myDropzoneElement2" ></div>
 
    
	</div>
        </li>
        
          <li>
        	<h3><?php _e('Attach Files','shipme'); ?></h3>
        </li>
        
        
        <li>
    	 <div class="cross_cross">



	<script type="text/javascript" src="<?php echo get_bloginfo('template_url'); ?>/js/dropzone.js"></script>     
	<link rel="stylesheet" href="<?php echo get_bloginfo('template_url'); ?>/css/dropzone.css" type="text/css" />
    
 
    
    
    <script>
 
	
	jQuery(function() {

Dropzone.autoDiscover = false; 	 
var myDropzoneOptions = {
  maxFilesize: 15,
    addRemoveLinks: true,
	acceptedFiles:'.zip,.pdf,.rar,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.psd,.ai',
    clickable: true,
	url: "<?php bloginfo('siteurl') ?>/?my_upload_of_jb_files_proj=1",
};
 
var myDropzone = new Dropzone('div#myDropzoneElement', myDropzoneOptions);

myDropzone.on("sending", function(file, xhr, formData) {
  formData.append("author", "<?php echo $cid; ?>"); // Will send the filesize along with the file as POST data.
  formData.append("ID", "<?php echo $pid; ?>"); // Will send the filesize along with the file as POST data.
});

   
    <?php

		$args = array(
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
	'post_type'      => 'attachment',
	'meta_key' 		=> 'is_prj_file',
	'meta_value' 	=> '1',	
	'post_parent'    => $pid,
	'post_status'    => null,
	'numberposts'    => -1,
	);
	$attachments = get_posts($args);
	
	if($pid > 0)
	if ($attachments) {
	    foreach ($attachments as $attachment) {
		$url = $attachment->guid;
		$imggg = $attachment->post_mime_type; 
		
		if('image/png' != $imggg && 'image/jpeg' != $imggg)
		{
		$url = wp_get_attachment_url($attachment->ID);
 
			
			?>

					var mockFile = { name: "<?php echo $attachment->post_title ?>", size: <?php echo filesize( get_attached_file( $attachment->ID ) ) ?>, serverId: '<?php echo $attachment->ID ?>' };
					myDropzone.options.addedfile.call(myDropzone, mockFile);
					myDropzone.options.thumbnail.call(myDropzone, mockFile, "<?php echo bloginfo('template_url') ?>/images/file_icon.png");
					 
			
			<?php
			
	  
	}
	}}


	?>
   


myDropzone.on("success", function(file, response) {
    /* Maybe display some more file information on your page */
	 file.serverId = response;
	 file.thumbnail = "<?php echo bloginfo('template_url') ?>/images/file_icon.png";
	 
	   
  });
  
  
myDropzone.on("removedfile", function(file, response) {
    /* Maybe display some more file information on your page */
	  delete_this2(file.serverId);
	 
  });  	
	
	});
	
	</script>

    <script type="text/javascript">
	
	function delete_this2(id)
	{
		 jQuery.ajax({
						method: 'get',
						url : '<?php echo get_bloginfo('siteurl');?>/index.php?_ad_delete_pid='+id,
						dataType : 'text',
						success: function (text) {   jQuery('#image_ss'+id).remove();  }
					 });
		  //alert("a");
	
	}

	
 
	
	
	</script>

	<?php _e('Click the grey area below to add job files. Images are not accepted.','shipme') ?>
    <div class="dropzone dropzone-previews" id="myDropzoneElement" ></div>
 
    
	</div>
        
        </li>
        
        
         <?php
		
		$show_fields_in_step2 = true;
		$show_fields_in_step2 = apply_filters('shipme_show_fields_in_step2', $show_fields_in_step2);
		 
		
		if($show_fields_in_step2 == true):
		
			$catid = shipme_get_job_primary_cat($pid);
			$arr = shipme_get_job_ship_category_fields($catid, $pid);
			 
			
				for($i=0;$i<count($arr);$i++)
				{
					    
       
					
					
							echo '<li class="'.shipme_get_post_new_error_thing('custom_field_' . $arr[$i]['id'] ).'"  >';
							echo shipme_get_post_new_error_thing_display('custom_field_' . $arr[$i]['id']);
							echo '<h2>'.$arr[$i]['field_name'].$arr[$i]['id'].'</h2>';
							echo '<p>'.$arr[$i]['value'].'</p>';
							echo '</li>';
					
					
				}	
		
		endif;
		
		//---------------------------------
 		
		
     //     	$shipme_enable_featured_option = get_option('shipme_enable_featured_option');						   
	//					   	if($shipme_enable_featured_option != "no"):
						   
						   ?>
		
	 <li>
     <h2><?php _e("Need a Helper?",'shipme'); ?></h2>
     <p><input type="checkbox" class="do_input_new" name="need_a_helper" value="1" 
		<?php $feature =  get_field('need_a_helper', $pid, true);  echo ($feature == "1" ? "checked='checked'" : ""); ?>  /> You want Helper For carry Loaded Package?</p>
     </li>
     
     <li>
     <h2><?php _e("Fragile Materials",'shipme'); ?></h2>
     <p><input type="checkbox" class="do_input_new" name="fragile_materials" value="1" 
		<?php $feature =  get_field('fragile_materials', $pid, true);  echo ($feature == "1" ? "checked='checked'" : ""); ?>  /> Is there any fragile materials?</p>
     </li>
     
     <li>
     <h2><?php _e("Commercial Purpose",'shipme'); ?></h2>
     <p><input type="checkbox" class="do_input_new" name="commercial_purpose" value="1" 
		<?php $feature =  get_field('commercial_purpose', $pid, true);  echo ($feature == "1" ? "checked='checked'" : ""); ?>  /> For Commercial Purpose ?</p>
     </li>
     
     <li>
     <h2><?php _e("Packing Services",'shipme'); ?></h2>
     <p><input type="checkbox" class="do_input_new" name="packing_services" value="1" 
		<?php $feature =  get_field('packing_services', $pid, true);  echo ($feature == "1" ? "checked='checked'" : ""); ?>  /> Do you need packing services?</p>
     </li>
      
      
   <!--   
        <li>
        <h2><?php _e("Feature job?",'shipme'); ?></h2>
        <p><input type="checkbox" class="do_input_new" name="featured" value="1" 
		<?php $feature = get_post_meta($pid, 'featured', true); echo ($feature == "1" ? "checked='checked'" : ""); ?> /> 
        <?php 
		
				
		$shipme_featured_fee = get_option('shipme_featured_fee');
		$sl = __('Extra fee is applied','shipme');
		if(empty($shipme_featured_fee) or $shipme_featured_fee <= 0) $sl = '';
		
		
		printf(__("By clicking this checkbox you mark your job as featured. %s", 'shipme'), $sl); ?></p>
        </li>
        
        <?php// endif; ?>
        
        
        
        
        <?php
          	$shipme_enable_sealed_option = get_option('shipme_enable_sealed_option');						   
						   	if($shipme_enable_sealed_option != "no"):
						   
						   ?>
		
	 
      
      
        <li>
        <h2><?php _e("Sealed Bidding?",'shipme'); ?></h2>
        <p><input type="checkbox" class="do_input_new" name="sealed_bidding" value="1" 
		<?php $sealed_bidding = get_post_meta($pid, 'sealed_bidding', true); echo ($sealed_bidding == "1" ? "checked='checked'" : ""); ?>  /> 
        <?php 
		
				
		$shipme_sealed_bidding_fee = get_option('shipme_sealed_bidding_fee');
		$sl = __('Extra fee is applied','shipme');
		if(empty($shipme_sealed_bidding_fee) or $shipme_sealed_bidding_fee <= 0) $sl = '';
		
		
		printf(__("By clicking this checkbox the proposals on your job will be sealed. %s", 'shipme'), $sl); ?></p>
        </li>
        
        <?php endif; ?>
    -->
     <li>
     	&nbsp;
     </li>
    
    
    <li><h2>&nbsp;</h2>        	
           <p><a href="<?php echo shipme_post_new_with_pid_stuff_thg($pid, '1'); ?>" class="submit_bottom2" ><i class="fa fa-backward"></i> <?php _e('Go Back','shipme'); ?></a>
            <a href="#" class="submit_bottom2" onClick="document.getElementById('post-new-form').submit(); return false;"  ><i class="fa fa-check-circle"></i> <?php _e('Next Step','shipme'); ?></a>
           </p>
    </li>
        
    </ul>
    
    </form>    
        
    
    <?php
}


if($new_job_step == "1")
{
	global $MYerror, $jobOK;
	
	if(is_array($MYerror))
	if($jobOK == 0)
	{
		echo '<div class="errrs">';
		
			echo __('Your form has errors. Please check below, correct the errors, then submit again.','shipme');
	
		echo '</div>';
		
	}
	if($MYerror['num_of_package'] != '')
	{
		echo '<div class="errrs">';
		
			echo $MYerror['num_of_package'];
	
		echo '</div>';
		
	}
	
	$cat 		= wp_get_object_terms($pid, 'job_ship_cat', array('order' => 'ASC', 'orderby' => 'term_id' ));
	
	
?>     

 <form method="post"  id="post-new-form" action="<?php echo shipme_post_new_with_pid_stuff_thg($pid, '1');?>">  
 	<input type="hidden" value="11" name="job_submit_step1" />
    <ul class="post-new">
    <?php do_action('shipme_step1_before_title'); ?>
    	
        
        <li>
        	<h3><?php _e('Job Main Information','shipme'); ?></h3>
        </li>
        
        <li class="<?php echo shipme_get_post_new_error_thing('job_title') ?>">
        <?php echo shipme_get_post_new_error_thing_display('job_title') ?>        
        	<h2><?php echo __('Your job title', 'shipme'); ?></h2>
        	<p><input type="text" size="50" class="do_input form-control" name="job_title" id="job_title" placeholder="<?php _e('eg: I need a package moved.','shipme') ?>" value="<?php echo $post->post_title == "Auto Draft" ? "" : $post->post_title ?>" /></p>
        </li>
        
        
        
        
        
        <?php		
			
			$pst = $post->post_content;
			$pst = str_replace("<br />","",$pst);		
		?>
        <li class="<?php echo shipme_get_post_new_error_thing('job_description') ?>">
        <?php echo shipme_get_post_new_error_thing_display('job_description') ?>
        <h2><?php echo __('Description', 'shipme'); ?></h2>
        <p><textarea rows="6" cols="60" class="form-control do_input description_edit" placeholder="<?php _e('Describe here your shipping job scope.','shipme') ?>"  name="job_description"><?php echo trim($pst); ?></textarea></p>
        </li>
        
         
        <li>
        	<h3><?php _e('Items to Transport','shipme'); ?></h3>
        </li>
        <!--
        <li class="<?php echo shipme_get_post_new_error_thing('length') ?>">
        <?php echo shipme_get_post_new_error_thing_display('length') ?>
        <h2><?php echo __('Length', 'shipme'); ?></h2>
        <p><input type="text" size="50" class="do_input form-control" name="length" id="length" placeholder="<?php echo shipme_get_dimensions_measure() ?>" value="<?php echo get_post_meta($pid,'length',true); ?>" /></p>
        </li>
        
        
        <li class="<?php echo shipme_get_post_new_error_thing('width') ?>">
        <?php echo shipme_get_post_new_error_thing_display('width') ?>
        <h2><?php echo __('Width', 'shipme'); ?></h2>
        <p><input type="text" size="50" class="do_input form-control" name="width" id="width" placeholder="<?php echo shipme_get_dimensions_measure() ?>" value="<?php echo get_post_meta($pid,'width',true); ?>" /></p>
        </li>
        
        
        <li class="<?php echo shipme_get_post_new_error_thing('height') ?>">
        <?php echo shipme_get_post_new_error_thing_display('height') ?>
        <h2><?php echo __('Height', 'shipme'); ?></h2>
        <p><input type="text" size="50" class="do_input form-control" name="height" id="height" placeholder="<?php echo shipme_get_dimensions_measure() ?>" value="<?php echo get_post_meta($pid,'height',true); ?>" /></p>
        </li>
        
        
        <li class="<?php echo shipme_get_post_new_error_thing('weight') ?>">
        <?php echo shipme_get_post_new_error_thing_display('weight') ?>
        <h2><?php echo __('Weight', 'shipme'); ?></h2>
        <p><input type="text" size="50" class="do_input form-control" name="weight" id="weight" placeholder="<?php echo shipme_get_weight_measure() ?>" value="<?php echo get_post_meta($pid,'weight',true); ?>" /></p>
        </li>
        -->
        <!--code for add custome box of package -->
        <?php
        $package_detail=array();
    $package_detail = get_post_meta($pid,'package_detail',true);
	

    $c = 0;
    if ( count( $package_detail ) > 0 && is_array($package_detail) ) {
        foreach( $package_detail as $track ) {
            if ( isset( $track['num_of_package'] ) || isset( $track['height'] ) || isset( $track['width'] )|| isset( $track['length'] )|| isset( $track['weight']) ) {
		?>		<div class="package-detail-front">
				<li class="<?php echo shipme_get_post_new_error_thing('num_of_package') ?>">
        <?php echo shipme_get_post_new_error_thing_display('num_of_package') ?>
        <h2><?php echo __('Number of package', 'shipme'); ?></h2>
        <p><input type="text" size="50" class="do_input form-control" name="package_detail[<?php echo $c; ?>][num_of_package]" id="package_detail[<?php echo $c; ?>][num_of_package]" placeholder="<?php echo shipme_get_dimensions_measure() ?>" value="<?php echo $track['num_of_package']; ?>" /></p>
        </li>
        	<li class="<?php echo shipme_get_post_new_error_thing('height') ?>">
        <?php echo shipme_get_post_new_error_thing_display('height') ?>
        <h2><?php echo __('Height', 'shipme'); ?></h2>
        <p><input type="text" size="50" class="do_input form-control" name="package_detail[<?php echo $c; ?>][height]" id="package_detail[<?php echo $c; ?>][height]" placeholder="<?php echo shipme_get_dimensions_measure() ?>" value="<?php echo $track['height']; ?>" /></p>
        </li>
        <li class="<?php echo shipme_get_post_new_error_thing('width') ?>">
        <?php echo shipme_get_post_new_error_thing_display('width') ?>
        <h2><?php echo __('Width', 'shipme'); ?></h2>
        <p><input type="text" size="50" class="do_input form-control" name="package_detail[<?php echo $c; ?>][width]" id="package_detail[<?php echo $c; ?>][width]" placeholder="<?php echo shipme_get_dimensions_measure() ?>" value="<?php echo $track['width']; ?>" /></p>
        </li>
        <li class="<?php echo shipme_get_post_new_error_thing('length') ?>">
        <?php echo shipme_get_post_new_error_thing_display('length') ?>
        <h2><?php echo __('Length', 'shipme'); ?></h2>
        <p><input type="text" size="50" class="do_input form-control" name="package_detail[<?php echo $c; ?>][length]" id="package_detail[<?php echo $c; ?>][length]" placeholder="<?php echo shipme_get_dimensions_measure() ?>" value="<?php echo $track['length']; ?>" /></p>
        </li>
        <li class="<?php echo shipme_get_post_new_error_thing('weight') ?>">
        <?php echo shipme_get_post_new_error_thing_display('weight') ?>
        <h2><?php echo __('Weight', 'shipme'); ?></h2>
        <p><input type="text" size="50" class="do_input form-control" name="package_detail[<?php echo $c; ?>][weight]" id="package_detail[<?php echo $c; ?>][weight]" placeholder="<?php echo shipme_get_dimensions_measure() ?>" value="<?php echo $track['weight']; ?>" /></p>
        </li>
        <li><h2></h2><a href="javascript:void(0)" style="" class="remove preview  submit_bottom2">Remove Package</a></li>
        </div>
				
 <!--               printf( '<table class="package_detail"><tr><td>Number of package :</td><td> <input type="text" name="package_detail[%1$s][num_of_package]" value="%2$s" placeholder="Number Of Package" /></td> </tr><tr><td>Height :</td><td> <input type="text" name="package_detail[%1$s][height]" value="%3$s" placeholder="cm" /></td></tr> <tr><td>Width :</td><td> <input type="text" name="package_detail[%1$s][width]" value="%4$s" placeholder="cm" /></td></tr> <tr><td>Length :</td><td> <input type="text" name="package_detail[%1$s][length]" value="%5$s" placeholder="cm" /></td></tr> <tr><td>Weight :</td><td> <input type="text" name="package_detail[%1$s][weight]" value="%6$s" placeholder="kg" /></td></tr> <tr><td></td><td><span class="remove preview  button button-primary button-large">%7$s</span></td></tr></table>', $c, $track['num_of_package'], $track['height'],$track['width'],$track['length'],$track['weight'],__( 'Remove Track' ) );  -->
     <?php           $c = $c +1;
            }
        }
    }

    ?>
<span id="here"></span>
<li><h2></h2><a href="javascript:void(0)" class=" add submit_bottom2"><?php _e('Add Packages'); ?></a></li>
<style>.package_detail input{width:100%}</style>
<script>
    var $ =jQuery.noConflict();
    $(document).ready(function() {
        var count = <?php echo $c; ?>;
        $(".add").click(function() {
            count = count + 1;


            $('#here').append('<div class="package-detail-front"><li> <h2>Number of package</h2><p><input type="text" size="50" class="do_input form-control" name="package_detail['+count+'][num_of_package]" id="package_detail['+count+'][num_of_package]" placeholder="Number of package"/></p></li><li>    <h2>Height</h2><p><input type="text" size="50" class="do_input form-control" name="package_detail['+count+'][height]" id="package_detail['+count+'][height]" placeholder="cm"/></p> </li><li> <h2>Width</h2><p><input type="text" size="50" class="do_input form-control" name="package_detail['+count+'][width]" id="package_detail['+count+'][width]" placeholder="cm"/></p> </li><li>    <h2>Length</h2><p><input type="text" size="50" class="do_input form-control" name="package_detail['+count+'][length]" id="package_detail['+count+'][length]" placeholder="cm"/></p> </li><li><h2>Weight</h2> <p><input type="text" size="50" class="do_input form-control" name="package_detail['+count+'][weight]" id="package_detail['+count+'][weight]" placeholder="cm"/></p> </li><li><h2></h2><a href="javascript:void(0)" style="" class="remove preview  submit_bottom2">Remove Package</a></li></div>');
		
		
            return false;
        });
        $(document).on('click', '.remove' ,function() {
			//alert('aa');
            $(this).closest('.package-detail-front').remove();
        });
    });
    </script>
        
        
        <!--End for add custome box of package -->
        
        
         <li>
        	<h3><?php _e('Job Specifics','shipme'); ?></h3>
        </li>
       
 
        
            <script>
			
									function display_subcat(vals)
									{
										jQuery.post("<?php bloginfo('siteurl'); ?>/?get_subcats_for_me=1", {queryString: ""+vals+""}, function(data){
											if(data.length >0) {
												 
												jQuery('#sub_cats').html(data);
												 
											}
										});
										
									}
									
									
									function display_subcat2(vals)
									{
										jQuery.post("<?php bloginfo('siteurl'); ?>/?get_locscats_for_me=1", {queryString: ""+vals+""}, function(data){
											if(data.length >0) {
												 
												jQuery('#sub_locs').html(data);
												jQuery('#sub_locs2').html("&nbsp;");
												 
											}
											else
											{
												jQuery('#sub_locs').html("&nbsp;");
												jQuery('#sub_locs2').html("&nbsp;");	
											}
										});
										
									}
									
									function display_subcat3(vals)
									{
										jQuery.post("<?php bloginfo('siteurl'); ?>/?get_locscats_for_me2=1", {queryString: ""+vals+""}, function(data){
											if(data.length >0) {
												 
												jQuery('#sub_locs2').html(data);
												 
											}
										});
										
									}
									
									</script>
        
               
 
        
       <!-- 
        <li class="<?php echo shipme_get_post_new_error_thing('jb_category') ?>">
        <?php echo shipme_get_post_new_error_thing_display('jb_category') ?>
        <h2><?php echo __('Job Category', 'shipme'); ?></h2>
        	 
        	<p class="strom_100">
			
            
            
            <?php if(get_option('shipme_enable_multi_cats') == "yes"): ?>
			<div class="multi_cat_placeholder_thing">
            
            	<?php 
					
					$selected_arr = shipme_build_my_cat_arr($pid);
					echo shipme_get_categories_multiple('job_ship_cat', $selected_arr); 
										
				?>
            
            </div>
            
            <?php else: ?>
            
			<?php	 
			 
			 	echo shipme_get_categories_clck("job_ship_cat",    (is_array($cat) ? $cat[0]->term_id : "") , __('Select Category','shipme'), "form-control do_input", 'onchange="display_subcat(this.value)"' );
								
								
								echo '<br/><span id="sub_cats">';
			 
				
											if(!empty($cat[1]->term_id))
											{
												$args2 = "orderby=name&order=ASC&hide_empty=0&parent=".$cat[0]->term_id;
												$sub_terms2 = get_terms( 'job_cat', $args2 );	
												
												$ret = '<select class="form-control do_input" name="subcat">';
												$ret .= '<option value="">'.__('Select Subcategory','shipme'). '</option>';
												$selected1 = $cat[1]->term_id;
												
												foreach ( $sub_terms2 as $sub_term2 )
												{
													$sub_id2 = $sub_term2->term_id; 
													$ret .= '<option '.($selected1 == $sub_id2 ? "selected='selected'" : " " ).' value="'.$sub_id2.'">'.$sub_term2->name.'</option>';
												
												}
												$ret .= "</select>";
												echo $ret;	
												
												
											}
											
										echo '</span>';			
			
			 ?>
            <?php endif; ?>
            
            
            </p>
        </li>
        
        -->
        
        <li class="<?php echo shipme_get_post_new_error_thing('price') ?>">
        <?php echo shipme_get_post_new_error_thing_display('price') ?>        
        	<h2><?php echo __('Job Price', 'shipme'); ?></h2>
        	<p><input type="text" size="50" class="do_input form-control" name="price" placeholder="<?php echo shipme_get_currency() ?>" value="<?php echo get_post_meta($pid,'price',true); ?>" /></p>
        </li>
        
        
        
              
        <li>
        	<h3><?php _e('Package Pickup','shipme'); ?></h3>
        </li>
        
        <!-- # JS here -->
        
         <script src="<?php bloginfo('template_url') ?>/js/picker.js"  ></script>
         <script src="<?php bloginfo('template_url') ?>/js/picker.date.js"  ></script>
         <script src="<?php bloginfo('template_url') ?>/js/legacy.js"  ></script>
         
         
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url') ?>/css/datepicker/classic.css">
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url') ?>/css/datepicker/classic.date.css">
        
      
        <script>
		
		jQuery( document ).ready(function() {
			jQuery('#pickup_date').pickadate( { min: new Date(),  onSet: function(thingSet) {
    		 jQuery("#pickup_date_hidden").val(thingSet.select/1000 + 12400);
		 
  } });
			jQuery('#delivery_date').pickadate( { min: new Date() ,  onSet: function(thingSet) {
    		 jQuery("#delivery_date_hidden").val(thingSet.select/1000 + 12400);
  }   });
		});
		
		// This example displays an address form, using the autocomplete feature
		// of the Google Places API to help users fill in the information.
		
		var placeSearch, autocomplete, autocomplete2;
 
		
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
		  
		  autocomplete2 = new google.maps.places.Autocomplete(
			  /** @type {!HTMLInputElement} */(document.getElementById('autocomplete_delivery')),
			  {types: ['geocode']});
		
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
			navigator.geolocation.getCurrentPosition(function(position) {
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
			navigator.geolocation.getCurrentPosition(function(position) {
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
               
        <li class="<?php echo shipme_get_post_new_error_thing('pickup_location') ?>">
        <?php echo shipme_get_post_new_error_thing_display('pickup_location') ?>        
        	<h2><?php echo __('Location (address/zip)', 'shipme'); ?></h2>
        	<p><input type="text" size="50" onFocus="geolocate_pickup()" id="autocomplete_pickup" class="do_input form-control" name="pickup_location" 
            placeholder="<?php _e('eg: New York, 15th ave','shipme') ?>" value="<?php echo get_post_meta($pid,'pickup_location',true); ?>" /></p>
        </li>
        
        <input type="hidden" value="<?php echo get_post_meta($pid,'pickup_lat',true) ?>"  name="pickup_lat" id="pickup_lat"  />
        <input type="hidden" value="<?php echo get_post_meta($pid,'pickup_lng',true) ?>"  name="pickup_lng" id="pickup_lng"  />
        
        
        <li class="<?php echo shipme_get_post_new_error_thing('pickup_date') ?>">
        <?php echo shipme_get_post_new_error_thing_display('pickup_date') ?>        
        	<h2><?php echo __('Pickup Date', 'shipme'); ?></h2>
        	<p><input type="text" size="50" class="do_input form-control" id="pickup_date" placeholder="<?php _e('click here to choose date','shipme') ?>" 
            value="<?php $zz = get_post_meta($pid,'pickup_date',true); echo (!empty($zz) ? date("j F, Y", $zz) : '') ; ?>"  /></p>
        </li>
        
        <input type="hidden" value="<?php echo get_post_meta($pid,'pickup_date',true) ?>"  name="pickup_date" id="pickup_date_hidden"  />
  
 
  
  <li>
        	<h3><?php _e('Package Delivery','shipme'); ?></h3>
        </li>
        
        
         
               
        <li class="<?php echo shipme_get_post_new_error_thing('delivery_location') ?>">
        <?php echo shipme_get_post_new_error_thing_display('delivery_location') ?>        
        	<h2><?php echo __('Location (address/zip)', 'shipme'); ?></h2>
        	<p><input type="text" size="50" class="do_input form-control" onFocus="geolocate_delivery()"  id="autocomplete_delivery" name="delivery_location" 
            placeholder="<?php _e('eg: California, San Francisco, Lombard St','shipme') ?>" value="<?php echo get_post_meta($pid,'delivery_location',true); ?>" /></p>
        </li>
        
        <input type="hidden" value="<?php echo get_post_meta($pid,'delivery_lat',true) ?>"  name="delivery_lat" id="delivery_lat"  />
        <input type="hidden" value="<?php echo get_post_meta($pid,'delivery_lng',true) ?>"  name="delivery_lng" id="delivery_lng"  />
        
        
        <li class="<?php echo shipme_get_post_new_error_thing('delivery_date') ?>">
        <?php echo shipme_get_post_new_error_thing_display('delivery_date') ?>        
        	<h2><?php echo __('Delivery Date', 'shipme'); ?></h2>
        	<p><input type="text" size="50" class="do_input form-control" id="delivery_date" placeholder="<?php _e('click here to choose date','shipme') ?>"  
            value="<?php $zz = get_post_meta($pid,'delivery_date',true); echo !empty($zz) ? date("j F, Y", $zz) : '' ; ?>" /></p>
        </li>
        
        
        <input type="hidden" value="<?php echo get_post_meta($pid,'delivery_date',true) ?>"  name="delivery_date" id="delivery_date_hidden"  />
        
        <li><h2>&nbsp;</h2>
        	
            <p><a href="#" class="submit_bottom2" onClick="document.getElementById('post-new-form').submit(); return false;"  ><i class="fa fa-check-circle"></i> <?php _e('Next Step','shipme'); ?></a></p>
        </li>
  
        
        
        </ul>
 </form>   
        
        
 <?php 
 	
	} //end step1
 
  ?>       
 

</div>
</div>


<?php

	
	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
	
}

?>