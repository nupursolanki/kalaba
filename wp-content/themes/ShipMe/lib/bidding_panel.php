<?php

	if(!is_user_logged_in())
	{
		echo '<div class="padd10"><div class="padd10">';
		echo sprintf(__('You are not logged in. In order to bid please <a href="%s">login</a> or <a href="%s">register</a> an account','shipme'),
		get_bloginfo('siteurl').'/wp-login.php' ,get_bloginfo('siteurl').'/wp-login.php?action=register');
		echo '</div></div>';
		exit;	
	}



	global $wpdb,$wp_rewrite,$wp_query;
	$pid = $_GET['pid'];
	
	global $current_user;
	get_currentuserinfo();
	$cid = $current_user->ID;
	$cwd = str_replace('wp-admin','',getcwd());
	$post = get_post($pid);
	
	//---------
	
	if($post->post_author == $cid)
	{
		echo '<div class="padd10"><div class="padd10">';
		echo sprintf(__('You cannot submit proposals to your own jobs.','shipme'));
		echo '</div></div>';
		exit;	
	}
	
	$closed = get_post_meta($pid,'closed', true);
	if($closed == '1')
	{
		echo '<div class="padd10"><div class="padd10">';
		echo sprintf(__('This job has expired or is closed. You cannot submit anymore proposals.','shipme'));
		echo '</div></div>';
		exit;	
	}
	
	//----------------------
	
	$cwd .= 'wp-content/uploads';
	
	
	
	$query = "select * from ".$wpdb->prefix."project_bids where uid='$cid' AND pid='$pid'";
	$r = $wpdb->get_results($query); $bd_plc = 0;
	
	if(count($r) > 0) { $row = $r[0]; $bid = $row->bid; $description = $row->description; $days_done = $row->days_done; $bd_plc = 1; }
	
	do_action('shipme_display_bidding_panel', $pid);
	
	//====================================================================
	
 
	$is_it_allowed = true;
	$is_it_allowed = apply_filters('shipme_is_it_allowed_place_bids', $is_it_allowed);
	
	if($is_it_allowed != true):
	
	do_action('shipme_is_it_not_allowed_place_bids_action');	
?>



<?php else: ?>	


<script type="text/javascript">

function check_submits()
{
	if(!jQuery('#submits_crt_check').is(':checked'))
	{
		alert("<?php _e('Please accept you can do the work.','shipme'); ?>");
		return false;
	}
	
 
	if( jQuery("#bid").val().length == 0 ) 
	{
		alert("<?php _e('Please type in a bid value.','shipme'); ?>");
		return false;	
	}
	
	
	return true;
}


</script>

<div class="super_bid_panel">

	<div class="bid_panel_box_title"><?php echo sprintf(__("Submit Your Proposal",'shipme')); ?></div>
  	<div class="bid_panel" >
    <?php
	
	$do_not_show = 0;
	$uid = $cid;
	
	$shipme_enable_custom_bidding = get_option('shipme_enable_custom_bidding');
	if($shipme_enable_custom_bidding == "yes")
	{
		$shipme_get_project_primary_cat = shipme_get_project_primary_cat($pid);	
		$shipme_theme_bidding_cat_ = get_option('shipme_theme_bidding_cat_' . $shipme_get_project_primary_cat);
		
		if($shipme_theme_bidding_cat_ > 0)
		{
			$shipme_get_credits = shipme_get_credits($uid);
			
			if(	$shipme_get_credits < $shipme_theme_bidding_cat_) { $do_not_show = 1;	
				$prc = shipme_get_show_price($shipme_theme_bidding_cat_);
			}
		}
		
	}
    
	if($do_not_show == 1 and $bd_plc != 1)
	{
		echo '<div class="padd10">';
		echo sprintf(__('You need to have at least %s in your account to bid. <a href="%s">Click here</a> to deposit money.','shipme'), $prc, get_permalink(get_option('shipme_my_account_payments_id')));		
		echo '</div>';
	}
	else
	{
		?>
    
                <div class="padd10">
                <form onsubmit="return check_submits();" method="post" action="<?php echo get_permalink($pid); ?>"> 
                <input type="hidden" name="control_id" value="<?php echo base64_encode($pid); ?>" /> 
                	<ul class="post-new3" style="width:100%">
		                           
                            <li>
								<h2><?php _e('Your Bid','shipme'); ?></h2>
								<p><input type="text" name="bid" id="bid" class="do_input" value="<?php echo $bid; ?>" size="10" /> 
                                <?php 
								
								$currency = shipme_currency();
								$currency = apply_filters('shipme_currency_in_bidding_panel', $currency);
								
								echo $currency; ?>
                                </p>
							</li>
                            
                            
                               <li>
								<h2><?php _e('Your Message','shipme'); ?></h2>
								<p>
                                
                                <textarea name="description2" cols="28" class="do_input" rows="3"><?php echo $description; ?></textarea><br/>
                             
                                <input type="hidden" name="control_id" value="<?php echo base64_encode($pid); ?>" />
                                </p>
							</li>
                            
                            
                      
                           <?php
						   
						   	$shipme_enable_project_files = get_option('shipme_enable_project_files');
						   
						   	if($shipme_enable_project_files != "no"):
						   
						   ?> 
                            
                            <li>
								<h2><?php _e('Attach Files','shipme'); ?></h2>
								 
                                <!-- ################### -->
                                
         <div class="cross_cross2">



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
	url: "<?php bloginfo('siteurl') ?>/?my_upload_of_project_files=1",
};
 
var myDropzone = new Dropzone('div#myDropzoneElement', myDropzoneOptions);

myDropzone.on("sending", function(file, xhr, formData) {
  formData.append("author", "<?php echo $cid; ?>"); // Will send the filesize along with the file as POST data.
  formData.append("ID", "<?php echo $pid; ?>"); // Will send the filesize along with the file as POST data.
});

   
    <?php

	if(empty($cid)) $cid = -1;
	
	$args = array(
	'order'          => 'ASC',
	'post_type'      => 'attachment',
	'post_parent'    => $pid,
		'post_author'    => $cid,
	'meta_key'		 => 'is_bidding_file',
	'meta_value'	 => '1',
	'numberposts'    => -1,
	'post_status'    => null,
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
 			if($attachment->post_author == $cid)
			{
			
			?>

					var mockFile = { name: "<?php echo $attachment->post_title ?>", size: 12345, serverId: '<?php echo $attachment->ID ?>' };
					myDropzone.options.addedfile.call(myDropzone, mockFile);
					myDropzone.options.thumbnail.call(myDropzone, mockFile, "<?php echo bloginfo('template_url') ?>/images/file_icon.png");
					 
			
			<?php
			}
	  
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
						url : '<?php echo get_bloginfo('siteurl');?>/index.php/?_ad_delete_pid='+id,
						dataType : 'text',
						success: function (text) {   jQuery('#image_ss'+id).remove();  }
					 });
		  //alert("a");
	
	}

	
 
	
	
	</script>

	<?php _e('Click the grey area below to add project files. Images are not accepted.','shipme') ?>
    <div class="dropzone dropzone-previews" id="myDropzoneElement" ></div>
 
    
	</div>                        
           
 
                                
                                
                                
                                <!-- ################### -->
                                
							</li>
                            <?php endif; ?>
                            
                         
                            
                            <li>
								<h2> </h2>
								<p>
                                
                                
                                <input type="checkbox" name="accept_trms" id="submits_crt_check" value="1" /><?php _e("I can perform work where/when described in post.",'shipme'); ?> </p>
							</li>
                            
                            <li>
								<h2> </h2>
								<p>
                                
                                
                                <input class="my-buttons" id="submits_crt" type="submit" name="bid_now_reverse" value="<?php _e("Place Bid",'shipme'); ?>" /></p>
							</li>
                            
                	</ul>
                   </form>
                </div> <?php } ?>
                </div> </div> <?php endif; ?>