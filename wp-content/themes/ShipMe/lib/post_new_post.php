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

global $projectOK, $MYerror, $class_errors;
$projectOK = 0;

global $wp_query;
$pid = $wp_query->query_vars['jobid'];


do_action('shipme_post_new_post_post', $pid);

if (isset($_POST['job_submit_step1'])) {

    $projectOK = 1;
    //echo $_POST['need_a_helper'];exit;
    update_post_meta($pid, 'featured', $_POST['featured']);
    update_post_meta($pid, 'sealed_bidding', $_POST['sealed_bidding']);
    update_field('field_567054c74e4e6', $_POST['need_a_helper'], $pid);
    update_field('field_567056a74e4a7', $_POST['fragile_materials'], $pid);
    update_field('field_5670571a4e4a8', $_POST['commercial_purpose'], $pid);
    update_field('field_5670574e4e4a9', $_POST['packing_services'], $pid);

    $arr = $_POST['custom_field_id'];
    for ($i = 0; $i < count($arr); $i++) {
        $ids = $arr[$i];
        $value = $_POST['custom_field_value_' . $ids];

        $s1 = "select * from " . $wpdb->prefix . "ship_custom_fields where id='$ids'";
        $r1 = $wpdb->get_results($s1);
        $row1 = $r1[0];
        $mm = 0;

        //---------------------------

        if (is_array($value)) {
            delete_post_meta($pid, "custom_field_ID_" . $ids);
            $rr = 0;
            for ($j = 0; $j < count($value); $j++) {
                add_post_meta($pid, "custom_field_ID_" . $ids, $value[$j]);
                $rr++;
            }

            if ($rr == 0)
                $mm = 1;
        }
        else {
            update_post_meta($pid, "custom_field_ID_" . $ids, $value);
            if (empty($value))
                $mm = 1;
        }

        if ($row1->is_mandatory == 1 and $mm == 1) {
            $projectOK = 0;
            $MYerror['custom_field_' . $ids] = sprintf(__('You cannot leave the field: "<b>%s</b>" blank!', 'shipme'), $row1->name);
            $class_errors['custom_field_' . $ids] = 'error_class_post_new';
        }
    }


//	if($projectOK == 1)
//	{
//	
//		$stp = 3;
//		$stp = apply_filters('shipme_redirect_after_submit_step2',$stp);
//		
//		wp_redirect(shipme_post_new_with_pid_stuff_thg($pid, $stp));  
//		exit;	
//	}
    
}


if (isset($_POST['job_submit_step1'])) {
    $projectOK = 1;


    $job_title = trim($_POST['job_title']);
    $job_description = trim($_POST['job_description']);

    //---------------

    $pickup_lat = $_POST['pickup_lat'];
    $pickup_lng = $_POST['pickup_lng'];

    $delivery_lat = $_POST['delivery_lat'];
    $delivery_lng = $_POST['delivery_lng'];

    $delivery_date_hidden = $_POST['delivery_date'];
    $pickup_date_hidden = $_POST['pickup_date'];

    $pickup_location = trim($_POST['pickup_location']);
    $delivery_location = trim($_POST['delivery_location']);
    $jb_category = $_POST['job_ship_cat_cat'];

    $price = trim($_POST['price']);

    //------------------------------------------------

    update_post_meta($pid, "pickup_lat", $pickup_lat);
    update_post_meta($pid, "pickup_lng", $pickup_lng);

    update_post_meta($pid, "delivery_lat", $delivery_lat);
    update_post_meta($pid, "delivery_lng", $delivery_lng);

    update_post_meta($pid, "pickup_date", $pickup_date_hidden);
    update_post_meta($pid, "delivery_date", $delivery_date_hidden);

    update_post_meta($pid, "pickup_location", $pickup_location);
    update_post_meta($pid, "delivery_location", $delivery_location);

    update_post_meta($pid, "price", $price);


    //$weight = $_POST['weight'];
    //$height = $_POST['height'];
    //$width = $_POST['width'];
    //$length = $_POST['length'];
    //update_post_meta($pid, "length", 		trim($_POST['length']));
    //update_post_meta($pid, "weight", 		trim($_POST['weight']));
    //update_post_meta($pid, "height", 		trim($_POST['height']));
    //update_post_meta($pid, "width", 		trim($_POST['width']));
    //if(empty($width))
    //{
    //	$projectOK = 0;
    //	$MYerror['width'] 	= __('You need to type in a value.','shipme');
    //	$class_errors['width']		= 'error_class_post_new';  
    //
	//}
    //
	//if(empty($height))
    //{
    //	$projectOK = 0;
    //	$MYerror['height'] 	= __('You need to type in a value.','shipme');
    //	$class_errors['height']		= 'error_class_post_new';  
    //
	//}
    //
	//if(empty($weight))
    //{
    //	$projectOK = 0;
    //	$MYerror['weight'] 	= __('You need to type in a value.','shipme');
    //	$class_errors['weight']		= 'error_class_post_new';  
    //
	//}
    //
	//if(empty($length))
    //{
    //	$projectOK = 0;
    //	$MYerror['length'] 	= __('You need to type in a value.','shipme');
    //	$class_errors['length']		= 'error_class_post_new';  
    //
	//}
    update_post_meta($pid, "package_detail", $_POST['package_detail']);
    if (isset($_POST['package_detail'])) {
        if (!empty($_POST['package_detail'])) {
            foreach ($_POST['package_detail'] as $single_package) {
                foreach ($single_package as $single_value) {
                    if (!is_numeric($single_value)) {
                        $projectOK = 0;
                        $MYerror['num_of_package'] = __('You need to enter ineteger value in Length,Height,Width,Number Of package.', 'shipme');
                        $class_errors['num_of_package'] = 'You need to enter ineteger value in Length,Height,Width,Number Of package.';
                    }
                }
            }
        }
    }
    if (empty($_POST['package_detail'])) {

        $projectOK = 0;
        $MYerror['num_of_package'] = __('You need to enter ineteger value in Length,Height,Width,Number Of package.', 'shipme');
        $class_errors['num_of_package'] = 'You need to enter ineteger value in Length,Height,Width,Number Of package.';
        //$class_errors['pickup_location']		= 'error_class_post_new'; 
    }

    if (empty($pickup_location)) {
        $projectOK = 0;
        $MYerror['pickup_location'] = __('You need to type in a pickup location.', 'shipme');
        $class_errors['pickup_location'] = 'error_class_post_new';
    }

    if (empty($delivery_location)) {
        $projectOK = 0;
        $MYerror['delivery_location'] = __('You need to type in a delivery location.', 'shipme');
        $class_errors['delivery_location'] = 'error_class_post_new';
    }


    if (empty($pickup_date_hidden)) {
        $projectOK = 0;
        $MYerror['pickup_date'] = __('You need to select a pickup date.', 'shipme');
        $class_errors['pickup_date'] = 'error_class_post_new';
    }

    if (empty($delivery_date_hidden)) {
        $projectOK = 0;
        $MYerror['delivery_date'] = __('You need to select a delivery date.', 'shipme');
        $class_errors['delivery_date'] = 'error_class_post_new';
    }

    //---------------------------------------------------

    $ending = current_time('timestamp', 0) + 30 * 3600 * 24;
    update_post_meta($pid, 'ending', $ending);
    //added closed and paid for active job display
    update_post_meta($pid, 'closed', '0');
    update_post_meta($pid, 'paid', '1');
    //End added closed and paid for active job display
    $my_post = array();

    $my_post['post_title'] = $job_title;
    $my_post['post_status'] = 'draft';
    $my_post['ID'] = $pid;
    $my_post['post_content'] = $job_description;

    wp_update_post($my_post);

    //---------------------------------

    if (empty($job_title) or strlen($job_title) < 5) {
        $projectOK = 0;
        $MYerror['job_title'] = __('Your job title needs to be at least 5 characters!', 'shipme');
        $class_errors['job_title'] = 'error_class_post_new';
    }

    if (empty($job_description) or strlen($job_description) < 10) {
        $projectOK = 0;
        $MYerror['job_description'] = __('Your job description needs to be at least 10 characters!', 'shipme');
        $class_errors['job_description'] = 'error_class_post_new';
    }


    if (empty($price) or ! is_numeric($price)) {
        $projectOK = 0;
        $MYerror['price'] = __('The job price must not be empty and must be numeric.', 'shipme');
        $class_errors['price'] = 'error_class_post_new';
    }

    //---------------------------------
    /*
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
     */
    
    if (!is_user_logged_in()) {

        if ($_POST['user_tp'] == 'login_user') {
            //echo 111;exit;
            $user_login = $_POST['log'];
            $user_login = sanitize_user($user_login);
            $user_pass = $_POST['user_pwd'];
            $rememberme = 1;
            do_action('wp_authenticate', $user_login, $user_pass);
            //echo $user_login.$user_pass;exit;
            if ($user_login && $user_pass) {
                // echo 11;exit;
                $user = new WP_User(0, $user_login);

                // If the user can't edit posts, send them to their profile.
                //if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' ) )
                //	$redirect_to = get_settings('siteurl') . '/' . 'my-account';

                if (wp_login($user_login, $user_pass, $using_cookie)) {
                    if (!$using_cookie){
                        $user = get_user_by( 'login', $user_login );
                    wp_set_current_user($user->ID);
                    wp_set_auth_cookie($user->ID);
                    }
//                    if (!$using_cookie)
//                        wp_setcookie($user_login, $user_pass, false, '', '', $rememberme);
//                    do_action('wp_login', $user_login);
                    //   wp_redirect($redirect_to);
                    // exit;
                } else {
                    $projectOK = 0;
                    $MYerror['login'] = __('Incorrect Usernam Or Password Please Re-enter.', 'shipme');
                    if ($using_cookie){
                        $projectOK = 0;
                        $MYerror['login'] = __('Incorrect Usernam Or Password Please Re-enter.', 'shipme');
                    }
                }
            } else if ($user_login || $user_pass) {
                $projectOK = 0;
                $MYerror['login'] = __('<strong>Error</strong>: The password field is empty.', 'shipme');
            } else {
                $projectOK = 0;
                $MYerror['login'] = __('<strong>Error</strong>: The Username/password field is empty.', 'shipme');
            }
        }
        if ($_POST['user_tp'] == 'register_user') {

            $regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";
            $user_login = $_POST['reg_number'];
            $user_email = trim($_POST['reg_email']);
            $name = $_POST['reg_name'];
            $user_pwd = $_POST['reg_pwd'];
            $user_con_pwd = $_POST['reg_repwd'];
            $sanitized_user_login = sanitize_user($user_login);

            //  echo $user_login.$user_email.$user_pwd.$user_con_pwd.$name;exit;
            if ($user_login == '' || !preg_match($regex, $user_login)) {
                $projectOK = 0;
                $MYerror['login'] = __(' <strong>Error</strong>: Mobile Number is Invalid. Please Enter Mobile Number', 'shipme');
            } else {
                if ($name == '') {
                    $projectOK = 0;
                    $MYerror['login'] = __(' <strong>Error</strong>: Name is Invalid. Please Enter Name', 'shipme');
                } else {
                    if ($user_email == '' || filter_var($user_email, FILTER_VALIDATE_EMAIL) === false) {
                        $projectOK = 0;
                        $MYerror['login'] = __(' <strong>Error</strong>: Email is Invalid. Please Email Name', 'shipme');
                    } else {
                        if ($user_pwd == '' || $user_con_pwd == '' || $user_pwd != $user_con_pwd) {
                            $projectOK = 0;
                            $MYerror['login'] = __(' <strong>Error</strong>: Password is Invalid. Please Password Name', 'shipme');
                        } else {
//                            echo $_POST['reg_number'];exit;
                            if (username_exists($user_login)) {
                                $projectOK = 0;
                                $MYerror['login'] = __(' <strong>Error</strong>: Mobile Number Already Exists....Please Try with another Number.', 'shipme');
                            } else {
                                $user_id = wp_create_user($sanitized_user_login, $user_pwd, $user_email);

                                if (!$user_id || $user_id==1) {
                                    $projectOK = 0;
                                    $MYerror['login'] = __('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', 'shipme');
                                } else {
                                    wp_update_user(array('ID' => $user_id, 'role' => 'contractor'));
                                    update_user_meta($user_id, 'first_name', $name);

                                    wp_set_current_user($user_id);
                                    wp_set_auth_cookie($user_id);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
//    echo get_current_user_id();
//    echo $pid;
//    exit;
    if (is_user_logged_in()) {
//        echo get_current_user_id();
//        echo $pid;
//        exit;
        $arg = array(
            'post_type' => 'job_ship',
            'ID' => $pid,
            'post_author' => get_current_user_id(),
        );
        wp_update_post($arg);
    }
    

    if ($projectOK == 1) {

        $stp = 4;
        $stp = apply_filters('shipme_redirect_after_submit_step1', $stp);

        wp_redirect(shipme_post_new_with_pid_stuff_thg($pid, $stp));
        exit;
    }
}
?>