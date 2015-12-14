<?php

global $pagenow;
if (   is_admin() && 'themes.php' == $pagenow && isset( $_GET['activated'] ) ) 
{
	
	global $wpdb;
	
	update_option('shipme_right_side_footer', '<a title="WordPress Shipping Carriers Marketplace" href="http://sitemile.com/shipme-wordpress-shipping-carriers-marketplace">Wordpress ShipMe Theme</a>');
	update_option('shipme_left_side_footer', 'Copyright (c) '.date("Y").' - '.get_bloginfo('name'));
	
	update_option('shipme_currency',						'USD');
	update_option('shipme_currency_symbol',					'$');
	update_option('shipme_currency_position',				'front');	
	update_option('shipme_decimal_sum_separator',".");
	update_option('shipme_thousands_sum_separator',",");
	
	
	update_option('shipme_text_caption_1',						'GET YOUR PACKAGE DELIVERED');
	update_option('shipme_text_caption_2',						'Start searching for the best delivery in your area');
	update_option('shipme_text_caption_3',						'List Your Package');
	 
	
	shipme_insert_pages2('shipme_home_page_page_id', 					'HomePage', 		'This is the homepage, you will need to edit it from your wp-admin area, is best to install siteorigin pagebuilder as instructed in admin area.' );
	update_option('page_on_front', get_option('shipme_home_page_page_id'));
	update_option('show_on_front', 'page');
	update_option('siteorigin_panels_home_page_id', get_option('shipme_home_page_page_id'));
	
	
	update_post_meta(get_option('shipme_home_page_page_id'),'panels_data','a:3:{s:7:"widgets";a:6:{i:0;a:5:{s:5:"title";s:20:"Latest Shipping Jobs";s:2:"nr";s:1:"6";s:6:"height";N;s:13:"image_picture";N;s:11:"panels_info";a:6:{s:5:"class";s:35:"shipme_home_latest_posted_jb_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:0;s:5:"style";a:2:{s:10:"background";s:7:"#ffffff";s:18:"background_display";s:4:"tile";}}}i:1;a:3:{s:6:"height";s:3:"550";s:13:"image_picture";s:101:"http://onlinedemo.sitemile.com/shipme/wp-content/uploads/sites/6/2015/10/Red-Truck-e1444032158942.jpg";s:11:"panels_info";a:6:{s:5:"class";s:32:"shipme_home_page_wide_pic_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:1;s:5:"style";a:1:{s:18:"background_display";s:4:"tile";}}}i:2;a:5:{s:5:"title";s:40:"Great services, great shipping companies";s:7:"content";s:260:"Lorem ipsum dolor sit amet, pro an eius debet vituperatoribus, an eam fabellas quaerendum. Aeterno explicari suscipiantur mea in, ex ius paulo altera. Ex quo duis epicuri splendide, sed fabellas sadipscing ad. Solet audire delectus mei ne, nam id enim mandamus";s:8:"disp_pic";s:5:"right";s:13:"image_picture";s:91:"http://onlinedemo.sitemile.com/shipme/wp-content/uploads/sites/6/2015/10/parcel-courier.jpg";s:11:"panels_info";a:6:{s:5:"class";s:28:"shipme_home_page_text_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:2;s:5:"style";a:2:{s:10:"background";s:7:"#ffffff";s:18:"background_display";s:4:"tile";}}}i:3;a:3:{s:6:"height";s:3:"490";s:13:"image_picture";s:104:"http://onlinedemo.sitemile.com/shipme/wp-content/uploads/sites/6/2015/10/piano-movers-e1444030580786.jpg";s:11:"panels_info";a:6:{s:5:"class";s:32:"shipme_home_page_wide_pic_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:3;s:5:"style";a:1:{s:18:"background_display";s:4:"tile";}}}i:4;a:5:{s:5:"title";s:45:"Get quotes from pros for your shipping needs ";s:7:"content";s:279:"Eu utinam denique vis, no sed dolor nullam deleniti, cu mel odio commune. Ei mea assum elitr eloquentiam, ex eleifend honestatis nam, aeque errem concludaturque te vel. Affert mediocritatem ad est. Evertitur deseruisse te his, ei duo ornatus nominati. Nam ex oratio complectitur.";s:8:"disp_pic";s:4:"left";s:13:"image_picture";s:112:"http://onlinedemo.sitemile.com/shipme/wp-content/uploads/sites/6/2015/10/5674731budget-couriers-delivery-man.png";s:11:"panels_info";a:6:{s:5:"class";s:28:"shipme_home_page_text_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:4;s:5:"style";a:2:{s:10:"background";s:7:"#ffffff";s:18:"background_display";s:4:"tile";}}}i:5;a:4:{s:6:"height";s:3:"470";s:2:"nr";s:1:"5";s:11:"panels_info";a:5:{s:5:"class";s:26:"shipme_big_home_map_widget";s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:5;s:5:"style";a:2:{s:27:"background_image_attachment";b:0;s:18:"background_display";s:4:"tile";}}s:13:"image_picture";N;}}s:5:"grids";a:1:{i:0;a:2:{s:5:"cells";i:1;s:5:"style";a:0:{}}}s:10:"grid_cells";a:1:{i:0;a:2:{s:4:"grid";i:0;s:6:"weight";i:1;}}}');
	
	
	
		update_post_meta(get_option('shipme_home_page_page_id'),'_panels_data_preview','a:3:{s:7:"widgets";a:6:{i:0;a:5:{s:5:"title";s:20:"Latest Shipping Jobs";s:2:"nr";s:1:"6";s:6:"height";N;s:13:"image_picture";N;s:11:"panels_info";a:6:{s:5:"class";s:35:"shipme_home_latest_posted_jb_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:0;s:5:"style";a:2:{s:10:"background";s:7:"#ffffff";s:18:"background_display";s:4:"tile";}}}i:1;a:3:{s:6:"height";s:3:"550";s:13:"image_picture";s:101:"http://onlinedemo.sitemile.com/shipme/wp-content/uploads/sites/6/2015/10/Red-Truck-e1444032158942.jpg";s:11:"panels_info";a:6:{s:5:"class";s:32:"shipme_home_page_wide_pic_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:1;s:5:"style";a:1:{s:18:"background_display";s:4:"tile";}}}i:2;a:5:{s:5:"title";s:40:"Great services, great shipping companies";s:7:"content";s:260:"Lorem ipsum dolor sit amet, pro an eius debet vituperatoribus, an eam fabellas quaerendum. Aeterno explicari suscipiantur mea in, ex ius paulo altera. Ex quo duis epicuri splendide, sed fabellas sadipscing ad. Solet audire delectus mei ne, nam id enim mandamus";s:8:"disp_pic";s:5:"right";s:13:"image_picture";s:91:"http://onlinedemo.sitemile.com/shipme/wp-content/uploads/sites/6/2015/10/parcel-courier.jpg";s:11:"panels_info";a:6:{s:5:"class";s:28:"shipme_home_page_text_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:2;s:5:"style";a:2:{s:10:"background";s:7:"#ffffff";s:18:"background_display";s:4:"tile";}}}i:3;a:3:{s:6:"height";s:3:"490";s:13:"image_picture";s:104:"http://onlinedemo.sitemile.com/shipme/wp-content/uploads/sites/6/2015/10/piano-movers-e1444030580786.jpg";s:11:"panels_info";a:6:{s:5:"class";s:32:"shipme_home_page_wide_pic_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:3;s:5:"style";a:1:{s:18:"background_display";s:4:"tile";}}}i:4;a:5:{s:5:"title";s:45:"Get quotes from pros for your shipping needs ";s:7:"content";s:279:"Eu utinam denique vis, no sed dolor nullam deleniti, cu mel odio commune. Ei mea assum elitr eloquentiam, ex eleifend honestatis nam, aeque errem concludaturque te vel. Affert mediocritatem ad est. Evertitur deseruisse te his, ei duo ornatus nominati. Nam ex oratio complectitur.";s:8:"disp_pic";s:4:"left";s:13:"image_picture";s:112:"http://onlinedemo.sitemile.com/shipme/wp-content/uploads/sites/6/2015/10/5674731budget-couriers-delivery-man.png";s:11:"panels_info";a:6:{s:5:"class";s:28:"shipme_home_page_text_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:4;s:5:"style";a:2:{s:10:"background";s:7:"#ffffff";s:18:"background_display";s:4:"tile";}}}i:5;a:4:{s:6:"height";s:3:"300";s:2:"nr";s:1:"5";s:13:"image_picture";N;s:11:"panels_info";a:6:{s:5:"class";s:26:"shipme_big_home_map_widget";s:3:"raw";b:0;s:4:"grid";i:0;s:4:"cell";i:0;s:2:"id";i:5;s:5:"style";a:1:{s:18:"background_display";s:4:"tile";}}}}s:5:"grids";a:1:{i:0;a:2:{s:5:"cells";i:1;s:5:"style";a:0:{}}}s:10:"grid_cells";a:1:{i:0;a:2:{s:4:"grid";i:0;s:6:"weight";i:1;}}}');
	
	
	
	
	
	
	
	shipme_insert_pages('shipme_post_new_page_id', 					'Post New Transport Job', 		'[shipme_theme_post_new]' );
	shipme_insert_pages('shipme_transporters_page_id', 					'Search Transporters', 		'[shipme_theme_transporters]' );
	shipme_insert_pages('shipme_account_page_id', 					'My Account Area', 				'[shipme_theme_my_account_home_new]' );
	shipme_insert_pages('shipme_finances_page_id', 					'Finances', 					'[shipme_theme_my_account_finances_new]', get_option('shipme_account_page_id') );
	shipme_insert_pages('shipme_private_messages_page_id', 					'Private Messages', 					'[shipme_theme_my_account_pm_new]' , get_option('shipme_account_page_id'));
	shipme_insert_pages('shipme_profile_settings_page_id', 					'Profile Settings', 					'[shipme_theme_my_account_profile_settings_new]', get_option('shipme_account_page_id') );
	shipme_insert_pages('shipme_profile_feedback_page_id', 					'Reviews/Feedback', 					'[shipme_theme_my_account_reviews_new]', get_option('shipme_account_page_id') );
	
	update_option('shipme_button_link',						get_permalink(get_option('shipme_post_new_page_id')));
	//--------------------------------------------------------
	
	shipme_insert_pages('shipme_posted_bids_page_id', 					'My Posted Offers', 					'[shipme_theme_my_account_posted_offers_new]', get_option('shipme_account_page_id') );
	shipme_insert_pages('shipme_pending_jobs_page_id', 					'My Pending Jobs', 					'[shipme_theme_my_account_pending_jobs_new]', get_option('shipme_account_page_id') );
	shipme_insert_pages('shipme_awaiting_payments_page_id', 					'My Awaiting Payments', 					'[shipme_theme_my_account_awaiting_payments_new]', get_option('shipme_account_page_id') );
	shipme_insert_pages('shipme_completed_jobs_page_id', 					'My Completed Jobs', 					'[shipme_theme_my_account_compl_jobs_new]' , get_option('shipme_account_page_id'));
	shipme_insert_pages('shipme_active_jobs_page_id', 					'Active Jobs', 					'[shipme_theme_my_account_active_jobs_new]' , get_option('shipme_account_page_id'));
	
	shipme_insert_pages('shipme_received_offers_page_id', 					'Received Offers', 					'[shipme_theme_my_account_received_offers_new]' , get_option('shipme_account_page_id'));
	shipme_insert_pages('shipme_pending_delivery_page_id', 					'Jobs Pending Delivery', 					'[shipme_theme_my_account_pending_delivery_new]' , get_option('shipme_account_page_id'));
	shipme_insert_pages('shipme_delivered_jobs_page_id', 					'Delivered Items', 					'[shipme_theme_my_account_delivered_jobs_new]' , get_option('shipme_account_page_id'));
	
	shipme_insert_pages('shipme_completed_payments_page_id', 					'Completed Payments', 					'[shipme_theme_my_account_completed_payments_new]' , get_option('shipme_account_page_id'));
	shipme_insert_pages('shipme_outstanding_payments_page_id', 					'Outstanding Payments', 					'[shipme_theme_my_account_outstanding_payments_new]' , get_option('shipme_account_page_id'));
	
	
	
	//----------------------
	
	//main menu creation
	
	$menu_name = 'Main Header Menu';
	$menu_exists = wp_get_nav_menu_object( $menu_name );
	
	// If it doesn't exist, let's create it.
	if( !$menu_exists){
		$menu_id = wp_create_nav_menu($menu_name);
	
		// Set up default menu items
		wp_update_nav_menu_item($menu_id, 0, array(
			'menu-item-title' =>  __('Home'),
			'menu-item-classes' => 'home',
			'menu-item-url' => home_url( '/' ), 
			'menu-item-status' => 'publish'));
	
		wp_update_nav_menu_item($menu_id, 0, array(
			'menu-item-title' =>  __('All Jobs'),
			'menu-item-url' => home_url( '?post_type=job_ship' ), 
			'menu-item-status' => 'publish'));
			
			
				wp_update_nav_menu_item($menu_id, 0, array(
			'menu-item-title' =>  __('Transporters'),
			'menu-item-url' => get_permalink(get_option('shipme_transporters_page_id')), 
			'menu-item-status' => 'publish'));
 
		
		$locations = get_theme_mod('nav_menu_locations');
		$locations['primary-shipme-header'] = $menu_id;  
		set_theme_mod('nav_menu_locations', $locations);
		
	}
	
	
	
	
	//----------------------
	
		$ss = " CREATE TABLE `".$wpdb->prefix."ship_custom_fields` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`name` VARCHAR( 255 ) NOT NULL ,
					`tp` VARCHAR( 48 ) NOT NULL ,
					`ordr` INT NOT NULL ,
					`cate` VARCHAR( 255 ) NOT NULL ,
					`pause` INT NOT NULL DEFAULT '1'
					) ENGINE = MYISAM ";
			 $wpdb->query($ss);
			 
			 
			 $ss = "ALTER TABLE `".$wpdb->prefix."ship_custom_fields` ADD  `step_me` VARCHAR( 255 ) NOT NULL;";
		$wpdb->query($ss);	
		
		$ss = "ALTER TABLE `".$wpdb->prefix."ship_custom_fields` ADD  `content_box6` TEXT NOT NULL ;";
		$wpdb->query($ss);
		
		$ss = "ALTER TABLE `".$wpdb->prefix."ship_custom_fields` ADD  `is_mandatory` TINYINT NOT NULL DEFAULT '0';";
			$wpdb->query($ss);	
	
	
		$ss = " CREATE TABLE `".$wpdb->prefix."ship_custom_relations` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`custid` BIGINT NOT NULL ,
					`catid` BIGINT NOT NULL
					) ENGINE = MYISAM ";
			$wpdb->query($ss);
	
	//--------------------------------------------------------
	
	
			
			$ss = "CREATE TABLE `".$wpdb->prefix."ship_pm` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`owner` INT NOT NULL DEFAULT '0',
					`user` INT NOT NULL DEFAULT '0',
					`content` TEXT NOT NULL ,
					`subject` TEXT NOT NULL ,
					`rd` TINYINT NOT NULL DEFAULT '0',
					`parent` BIGINT NOT NULL DEFAULT '0',
					`pid` INT NOT NULL DEFAULT '0' ,
					`datemade` INT NOT NULL DEFAULT '0',
					`readdate` INT NOT NULL DEFAULT '0',
					`initiator` INT NOT NULL DEFAULT '0',
					`attached` INT NOT NULL DEFAULT '0'
					) ENGINE = MYISAM ;
					";
			$wpdb->query($ss);
			
			$s = "ALTER TABLE `".$wpdb->prefix."ship_pm` CHANGE `content` `content` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ,
												  CHANGE `subject` `subject` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ";
				$wpdb->query($s);	
				
				$ss = "ALTER TABLE `".$wpdb->prefix."ship_pm` ADD  `show_to_source` TINYINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);
			
			//---------------------------	
				
			$ss = "ALTER TABLE `".$wpdb->prefix."ship_pm` ADD  `show_to_destination` TINYINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);
			
			
			$wpdb->query("ALTER TABLE `".$wpdb->prefix."ship_pm` ADD `file_attached` VARCHAR( 255 ) NOT NULL ;");
			
				$ss = "ALTER TABLE `".$wpdb->prefix."ship_pm` ADD  `approved` TINYINT NOT NULL DEFAULT '1';";
			$wpdb->query($ss);	
			
			$ss = "ALTER TABLE `".$wpdb->prefix."ship_pm` ADD  `approved_on` BIGINT NOT NULL DEFAULT '0';";
			$wpdb->query($ss);
			
			//------------------------
			
				$ss = "CREATE TABLE `".$wpdb->prefix."ship_bids` (
			`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
			`date_made` BIGINT NOT NULL DEFAULT '0',
			`bid` DOUBLE NOT NULL DEFAULT '0',
			`pid` BIGINT NOT NULL DEFAULT '0',
			`uid` BIGINT NOT NULL DEFAULT '0',
			`winner` TINYINT NOT NULL DEFAULT '0',
			`paid` TINYINT NOT NULL DEFAULT '0',
			`reserved1` VARCHAR( 255 ) NOT NULL DEFAULT '0',
			`date_choosen` BIGINT NOT NULL DEFAULT '0'
			) ENGINE = MYISAM ";
			
			$wpdb->query($ss);
			 
				$sql_option_my = "ALTER TABLE  `".$wpdb->prefix."ship_bids` ADD  `description` TEXT NOT NULL ;";
				$wpdb->query($sql_option_my);
			
				$sql_option_my = "ALTER TABLE  `".$wpdb->prefix."ship_bids` ADD  `days_done` VARCHAR(255) NOT NULL ;";
				$wpdb->query($sql_option_my);
				
				$s = "ALTER TABLE `".$wpdb->prefix."ship_bids` CHANGE `description` `description` TEXT CHARACTER SET utf8 COLLATE utf8_bin NOT NULL ";
				$wpdb->query($s);
				
				
				
			$ss = "CREATE TABLE `".$wpdb->prefix."ship_email_alerts` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`uid` INT NOT NULL ,
					`catid` INT NOT NULL 
					) ENGINE = MYISAM ;
					";
			$wpdb->query($ss);
			
			
				$ss = "CREATE TABLE `".$wpdb->prefix."ship_email_alerts_locs` (
					`id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
					`uid` INT NOT NULL ,
					`catid` INT NOT NULL 
					) ENGINE = MYISAM ;
					";
			$wpdb->query($ss);
}


?>