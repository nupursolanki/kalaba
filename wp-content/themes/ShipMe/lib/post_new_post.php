<?php
/***************************************************************************
*
*	shipme - copyright (c) - sitemile.com
*	The only project theme for wordpress on the world wide web.
*
*	Coder: Andrei Dragos Saioc
*	Email: sitemile[at]sitemile.com | andreisaioc[at]gmail.com
*	More info about the theme here: http://sitemile.com/products/wordpress-project-freelancer-theme/
*	since v1.2.5.3
*
***************************************************************************/

global $projectOK, $MYerror, $class_errors;
$projectOK = 0;

global $wp_query;
$pid = $wp_query->query_vars['jobid'];	


do_action('shipme_post_new_post_post',$pid);

if(isset($_POST['job_submit_step2']))
{
	$projectOK = 1;
	
	update_post_meta($pid, 'featured', $_POST['featured']);
	update_post_meta($pid, 'sealed_bidding', $_POST['sealed_bidding']);
	
	$arr = $_POST['custom_field_id'];
		for($i=0;$i<count($arr);$i++)
		{
			$ids 	= $arr[$i];
			$value 	= $_POST['custom_field_value_'.$ids];
			
			$s1 = "select * from ".$wpdb->prefix."ship_custom_fields where id='$ids'";
			$r1 = $wpdb->get_results($s1);
			$row1 = $r1[0];
			$mm = 0;
			
			//---------------------------
			
			if(is_array($value))
			{
				delete_post_meta($pid, "custom_field_ID_".$ids);
				$rr = 0;
				for($j=0;$j<count($value);$j++) {
					add_post_meta($pid, "custom_field_ID_".$ids, $value[$j]);
					$rr++;
				}
				
				if($rr == 0) $mm = 1;
				
			}
			else
			{
				update_post_meta($pid, "custom_field_ID_".$ids, $value);
				if(empty($value)) $mm = 1;
			}
			
			if($row1->is_mandatory == 1 and $mm == 1)
			{
				$projectOK = 0; 
				$MYerror['custom_field_' . $ids] 		= sprintf(__('You cannot leave the field: "<b>%s</b>" blank!','shipme'), $row1->name );
				$class_errors['custom_field_' . $ids]			= 'error_class_post_new';
			}
		 
		}
	
	
	if($projectOK == 1)
	{
	
		$stp = 3;
		$stp = apply_filters('shipme_redirect_after_submit_step2',$stp);
		
		wp_redirect(shipme_post_new_with_pid_stuff_thg($pid, $stp));  
		exit;	
	}

}


if(isset($_POST['job_submit_step1']))
{
	$projectOK = 1;
	
	
	$job_title 			= trim($_POST['job_title']);
	$job_description 	= trim($_POST['job_description']);
	
	//---------------
	
	$pickup_lat = $_POST['pickup_lat'];
	$pickup_lng = $_POST['pickup_lng'];
	
	$delivery_lat = $_POST['delivery_lat'];
	$delivery_lng = $_POST['delivery_lng'];
	
	$delivery_date_hidden = $_POST['delivery_date'];
	$pickup_date_hidden = $_POST['pickup_date'];
	
	$pickup_location = trim($_POST['pickup_location']);
	$delivery_location = trim($_POST['delivery_location']);	
	$jb_category 		= $_POST['job_ship_cat_cat'];
	
	$price = trim($_POST['price']);
	
	//------------------------------------------------

	update_post_meta($pid, "pickup_lat", 		$pickup_lat);
	update_post_meta($pid, "pickup_lng", 		$pickup_lng);
	
	update_post_meta($pid, "delivery_lat", 		$delivery_lat);
	update_post_meta($pid, "delivery_lng", 		$delivery_lng);
	
	update_post_meta($pid, "pickup_date", 		$pickup_date_hidden);
	update_post_meta($pid, "delivery_date", 		$delivery_date_hidden);
	
	update_post_meta($pid, "pickup_location", 		$pickup_location);
	update_post_meta($pid, "delivery_location", 		$delivery_location);	
	
	update_post_meta($pid, "price", 		$price);
	
	
	$weight = $_POST['weight'];
	$height = $_POST['height'];
	$width = $_POST['width'];
	$length = $_POST['length'];
	
	update_post_meta($pid, "length", 		trim($_POST['length']));
	update_post_meta($pid, "weight", 		trim($_POST['weight']));
	update_post_meta($pid, "height", 		trim($_POST['height']));
	update_post_meta($pid, "width", 		trim($_POST['width']));
	
	if(empty($width))
	{
		$projectOK = 0;
		$MYerror['width'] 	= __('You need to type in a value.','shipme');
		$class_errors['width']		= 'error_class_post_new';  
	
	}
	
	if(empty($height))
	{
		$projectOK = 0;
		$MYerror['height'] 	= __('You need to type in a value.','shipme');
		$class_errors['height']		= 'error_class_post_new';  
	
	}
	
	if(empty($weight))
	{
		$projectOK = 0;
		$MYerror['weight'] 	= __('You need to type in a value.','shipme');
		$class_errors['weight']		= 'error_class_post_new';  
	
	}
	
	if(empty($length))
	{
		$projectOK = 0;
		$MYerror['length'] 	= __('You need to type in a value.','shipme');
		$class_errors['length']		= 'error_class_post_new';  
	
	}
	
	
	
	if(empty($pickup_location))
	{
		$projectOK = 0;
		$MYerror['pickup_location'] 	= __('You need to type in a pickup location.','shipme');
		$class_errors['pickup_location']		= 'error_class_post_new';  
	
	}
	
	if(empty($delivery_location))
	{
		$projectOK = 0;
		$MYerror['delivery_location'] 	= __('You need to type in a delivery location.','shipme');
		$class_errors['delivery_location']		= 'error_class_post_new';  
	
	}
	
	
	if(empty($pickup_date_hidden))
	{
		$projectOK = 0;
		$MYerror['pickup_date'] 	= __('You need to select a pickup date.','shipme');
		$class_errors['pickup_date']		= 'error_class_post_new';  
	
	}
	
	if(empty($delivery_date_hidden))
	{
		$projectOK = 0;
		$MYerror['delivery_date'] 	= __('You need to select a delivery date.','shipme');
		$class_errors['delivery_date']		= 'error_class_post_new';  
	
	}
	
	//---------------------------------------------------
	
	$ending = current_time('timestamp',0) + 30*3600*24;
	update_post_meta($pid,'ending', $ending);
	
	$my_post = array();
	
	$my_post['post_title'] 		= $job_title;
	$my_post['post_status'] 	= 'draft';
	$my_post['ID'] 				= $pid;
	$my_post['post_content'] 	= $job_description;
	
	wp_update_post($my_post);
	
	//---------------------------------
	
	if(empty($job_title) or strlen($job_title) < 5)
	{
		$projectOK = 0;
		$MYerror['job_title'] 	= __('Your job title needs to be at least 5 characters!','shipme');
		$class_errors['job_title']		= 'error_class_post_new';  	
	}
	
	if(empty($job_description) or strlen($job_description) < 10)
	{
		$projectOK = 0;
		$MYerror['job_description'] 	= __('Your job description needs to be at least 10 characters!','shipme');
		$class_errors['job_description']		= 'error_class_post_new';  	
	}
	
	
	if(empty($price) or !is_numeric($price))
	{
		$projectOK = 0;
		$MYerror['price'] 	= __('The job price must not be empty and must be numeric.','shipme');
		$class_errors['price']		= 'error_class_post_new';  	
	}
	
	//---------------------------------
	
		if(get_option('shipme_enable_multi_cats') == "yes")
		{
			$slg_arr = array();
			if(isset($_POST['job_ship_cat_cat_multi']))
			{
				if(is_array($_POST['job_ship_cat_cat_multi']))
				{
					foreach($_POST['job_ship_cat_cat_multi'] as $ct)
					{
						$term 			= get_term( $ct, 'job_ship_cat' );	
						$jb_category 	= $term->slug;	
						$slg_arr[] 		= $jb_category;		
					}
				}
			}

			wp_set_object_terms($pid, $slg_arr,'job_ship_cat');	
			
			if(count($_POST['job_ship_cat_cat_multi']) == 0) 
			{ 
				$projectOK = 0; 
				$MYerror['jb_category'] 	= __('You cannot leave the job category blank!','shipme');
				$class_errors['jb_category']		= 'error_class_post_new'; 
			}
			
				
		}
		else
		{ 
			$term 						= get_term( $jb_category, 'job_ship_cat' );	
			$jb_category 				= $term->slug;
			$arr_cats 					= array();
			$arr_cats[] 				= $jb_category;

			
			if(!empty($_POST['subcat']))
			{
				$term = get_term( $_POST['subcat'], 'job_ship_cat' );	
				$jb_category2 = $term->slug;
				$arr_cats[] = $jb_category2;
				 
			}
			
			
			wp_set_object_terms($pid, $arr_cats ,'job_ship_cat');
			
			if(empty($jb_category)) 
			{ 
				$projectOK = 0; 
				$MYerror['jb_category'] 	= __('You cannot leave the job category blank!','shipme');
				$class_errors['jb_category']		= 'error_class_post_new'; 
			}
			
		}
	
	
	if($projectOK == 1)
	{
	
		$stp = 2;
		$stp = apply_filters('shipme_redirect_after_submit_step1',$stp);
		
		wp_redirect(shipme_post_new_with_pid_stuff_thg($pid, $stp));  
		exit;	
	}	
 

}

?>