<?php
//******************************************
//
//	Shipme theme- theme started on aug 2015
//	www.sitemile.com
//
//******************************************

function shipme_theme_my_account_profile_settings_new()
{

	ob_start();
	
	global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;
	
	
	
?>
<div class="container_ship_ttl_wrap">	
    <div class="container_ship_ttl">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
            <?php _e('Profile Settings','shipme') ?>
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

<?php
	
	do_action('shipme_account_at_top');

?>

<div class="container_ship_no_bk">

<?php 		echo shipme_get_users_links(); ?>

<div class="account-content-area col-xs-12 col-sm-8 col-lg-9">


<?php
				
				if(isset($_POST['save-info']))
				{
					$personal_info = strip_tags(nl2br($_POST['personal_info']), '<br />');
					update_user_meta($uid, 'personal_info', substr($personal_info,0,500));
					
					update_user_meta($uid, 'user_location', $_POST['job_location_cat']);
					
					
					
					if(isset($_POST['password']))
					{
						
						
						if(  !empty($_POST['password'])):
						$p1 = trim($_POST['password']);
						$p2 = trim($_POST['reppassword']);
						
						if($p1 == $p2)
						{
						
							global $wpdb;
							$newp = md5($p1);
							$sq = "update ".$wpdb->prefix."users set user_pass='$newp' where ID='$uid'" ;
							$wpdb->query($sq);
						} else echo '<div class="error">'.__('Password was not changed. It does not match the password confirmation.','shipme').'</div>';
						endif;
					}
					
					
					$personal_info = trim($_POST['paypal_email']);
					update_user_meta($uid, 'paypal_email', $personal_info);
					
					$user_full_name = trim($_POST['user_full_name']);
					update_user_meta($uid, 'user_full_name', $user_full_name);
					
					require_once(ABSPATH . "wp-admin" . '/includes/file.php');
					require_once(ABSPATH . "wp-admin" . '/includes/image.php');
					
					if(!empty($_FILES['avatar']["name"]))
					{
						
						$upload_overrides 	= array( 'test_form' => false );
               			$uploaded_file 		= wp_handle_upload($_FILES['avatar'], $upload_overrides);
						
						$file_name_and_location = $uploaded_file['file'];
                		$file_title_for_media_library = $_FILES['avatar'  ]['name'];
						
						$file_name_and_location = $uploaded_file['file'];
						$file_title_for_media_library = $_FILES['avatar']['name'];
								
						$arr_file_type 		= wp_check_filetype(basename($_FILES['avatar']['name']));
						$uploaded_file_type = $arr_file_type['type'];
						$urls  = $uploaded_file['url'];
						
					 
						
						if($uploaded_file_type == "image/png" or $uploaded_file_type == "image/jpg" or $uploaded_file_type == "image/jpeg" or $uploaded_file_type == "image/gif" )
						{
						
							$attachment = array(
											'post_mime_type' => $uploaded_file_type,
											'post_title' => 'User Avatar',
											'post_content' => '',
											'post_status' => 'inherit',
											'post_parent' =>  0,			
											'post_author' => $uid,
										);
								
					 
									 
							$attach_id = wp_insert_attachment( $attachment, $file_name_and_location, 0 );
							$attach_data = wp_generate_attachment_metadata( $attach_id, $file_name_and_location );
							wp_update_attachment_metadata($attach_id,  $attach_data);
							
							
							$_wp_attached_file = get_post_meta($attach_id,'_wp_attached_file',true);
						
							if(!empty($_wp_attached_file))
							update_user_meta($uid, 'avatar_ship', ($attach_id) );
							
						 
						
						}

						
						
						 
					}
					
					
						echo '<div class="saved_thing">'.__("Information saved!","shipme").'</div>';
					
				}
				
				?>


		<ul class="virtual_sidebar">
			
			<li class="widget-container widget_text">            	 
                <div class="my-only-widget-content">
             		 	<form method="post" enctype="multipart/form-data">
                  <ul class="post-new3">
    
        
        <li>
        	<h2><?php echo __('Your Full Name','shipme'); ?>:</h2>
        	<p><input type="text" class="do_input" name="user_full_name" value="<?php echo get_user_meta($uid, 'user_full_name', true); ?>" size="40" /></p>
        </li>
        
        
          
          <li>
        	<h2><?php echo __('New Password', "shipme"); ?>:</h2>
        	<p><input type="password" value="" class="do_input" name="password" size="40" /></p>
        </li>
        
        
        <li>
        	<h2><?php echo __('Repeat Password', "shipme"); ?>:</h2>
        	<p><input type="password" value="" class="do_input" name="reppassword" size="40"  /></p>
        </li>
        
        
        
            <li>
        	<h2><?php echo __('PayPal Email','shipme'); ?>:</h2>
        	<p><input type="text" class="do_input" name="paypal_email" value="<?php echo get_user_meta($uid, 'paypal_email', true); ?>" size="40" /></p>
        </li>
        
        
        
        <li>
        	<h2><?php echo __('Profile Description','shipme'); ?>:</h2>
        	<p><textarea type="textarea" cols="30" class="do_input" rows="5" name="personal_info"><?php echo get_user_meta($uid, 'personal_info', true); ?></textarea></p>
        </li>
        
        
        <li>
        	<h2><?php echo __('Profile Avatar','shipme'); ?>:</h2>
        	<p> <input type="file" class="do_input" name="avatar" /> <br/>
           <?php _e('max file size: 2mb. Formats: jpeg, jpg, png, gif', 'shipme'); ?>
            <br/>
            <img width="50" height="50" border="0" src="<?php echo shipme_get_avatar($uid,50,50); ?>" /> 
            </p>
        </li>
        
        <li>
        <h2>&nbsp;</h2>
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