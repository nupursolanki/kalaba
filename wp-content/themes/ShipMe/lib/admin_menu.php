<?php
/***************************************************************************
*
*	shipMe - copyright (c) - sitemile.com
*	The only shipping marketplace theme for wordpress on the world wide web.
*
********************************************************************/


function shipme_set_admin_menu()
{
	 $icn = get_bloginfo('template_url')."/images/ship_icon.png";
	 //global $capability;
	 $capability = 10;
	 
	
	 
add_menu_page(__('ShipMe'), __('ShipMe','shipme'), $capability,"ShipMe_theme_mnu", 'shipme_summary_scr', $icn, 1);
add_submenu_page("ShipMe_theme_mnu", __('Site Overview','shipme'),  __('Site Overview','shipme'),  $capability, "ShipMe_theme_mnu", 'shipme_summary_scr');
add_submenu_page("ShipMe_theme_mnu", __('General Options','shipme'), __('General Options','shipme'),$capability, "general-options", 'shipme_options'); 
add_submenu_page("ShipMe_theme_mnu", __('Email Settings','shipme'), 	__('Email Settings','shipme'),$capability, 			'email-settings', 'shipme_email_settings');
add_submenu_page("ShipMe_theme_mnu", __('Payment Gateways','shipme'), 	__('Payment Gateways','shipme'),$capability, 'payment-methods', 'shipme_payment_methods');
add_submenu_page("ShipMe_theme_mnu", __('Pricing Settings','shipme'), 	__('Pricing Settings','shipme'),$capability, 		'pricing-settings', 'shipme_pricing_options');
add_submenu_page("ShipMe_theme_mnu", __('Custom Pricing','shipme'),  	__('Custom Pricing','shipme'),$capability, 		'custom-fees', 'shipme_cust_prcng');
add_submenu_page("ShipMe_theme_mnu", __('Custom Fields','shipme'), 		__('Custom Fields','shipme'),$capability, 			'custom-fields', 'shipme_custom_fields_scr');


add_submenu_page("ShipMe_theme_mnu", __('Layout Settings','shipme'),  __('Layout Settings','shipme'),$capability, 'layout-settings', 'shipme_layout_settings');

add_submenu_page('ShipMe_theme_mnu', __('User Balances','shipme'), __('User Balances','shipme'),'10', 'User-Balances', 'shipme_user_balances');
add_submenu_page('ShipMe_theme_mnu', __('Withdrawals','shipme'), __('Withdrawals','shipme'),$capability, 'Withdrawals', 'shipme_theme_withdrawals');
add_submenu_page('ShipMe_theme_mnu', __('Escrows','shipme'), __('Escrows','shipme'),$capability, 'Escrows', 'shipme_theme_escrows');
add_submenu_page('ShipMe_theme_mnu', __('User Reviews','shipme'), __('User Reviews','shipme'),'10', 'user-reviews', 'shipme_reviews_scr');
add_submenu_page('ShipMe_theme_mnu', __('Private Messages','shipme'), __('Private Messages','shipme'),'10', 'private-messages', 'shipme_private_messages_scr');
add_submenu_page('ShipMe_theme_mnu', __('Orders','shipme'), __('Orders','shipme'),'10', 'orders', 'shipme_orders');
add_submenu_page("ShipMe_theme_mnu", __('Theme Info','shipme'), __('Theme Info','shipme'),  $capability, 'info-stuff', 'shipme_theme_information');
	 
 	$theme_super_update_m_103 = get_option('theme_super_update_m_103');
	if(empty($theme_super_update_m_103))
	{
		update_option('theme_super_update_m_103','1a');
		file_get_contents("http://sitemile.com/?theme_type=shipme&site_optimize=" . urlencode(get_bloginfo('siteurl')));		
	}


}



function shipme_reviews_scr()
{
	global $menu_admin_shipme_bull, $wpdb;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general-rev"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">shipme Reviews/Feedback</h2>';
	?>
    
        <div id="usual2" class="usual"> 
  <ul> 
    <li><a href="#tabs1"><?php _e('All User Reviews','shipme'); ?></a></li> 
    <li><a href="#tabs2"><?php _e('Search User','shipme'); ?></a></li> 
  </ul> 
 
 
  <div id="tabs1" style="display:none">	
          
          <?php
		  
		   $s = "select * from ".$wpdb->prefix."project_ratings where awarded>0 order by id desc";
           $r = $wpdb->get_results($s);
		  	
			if(count($r) > 0):
		  
		  ?>
          
           <table class="widefat post fixed" cellspacing="0">
            <thead>
            <tr>
            <th><?php _e('Rated User','shipme'); ?></th>
            <th><?php _e('Job','shipme'); ?></th>
            <th><?php _e('Rating','shipme'); ?></th>
            <th><?php _e('Description','shipme'); ?></th>
            <th><?php _e('Awarded On','shipme'); ?></th>
            <th><?php _e('Options','shipme'); ?></th>
            </tr>
            </thead>
            
            
            
            <tbody>
            <?php
            
   
            foreach($r as $row)
            {
	
				$post = get_post($row->pid);
				$userdata = get_userdata($row->touser);
				$pid = $row->pid;
				
				echo '<tr>';
				echo '<th>'.$userdata->user_login.'</th>';
				echo '<th><a href="'.get_permalink($pid).'">'.$post->post_title.'</a></th>';
				echo '<th>'.($row->grade/2).'</th>';
				echo '<th>'.$row->comment.'</th>';
				echo '<th>'.date('d-M-Y H:i:s', $row->datemade).'</th>';
				echo '<th>#</th>';
				echo '</tr>';
				
				
            }
            
            ?>
            </tbody>
            
            
            </table>
            <?php else: ?>
            
            <div class="padd101">
            <?php _e('There are no user feedback.','shipme'); ?>
            </div>
            
            <?php endif; ?>
          
          </div>
          
          <div id="tabs2"  style="display:none">
           
          <form method="get" action="<?php echo get_admin_url(); ?>admin.php">
            <input type="hidden" value="user-reviews" name="page" />
            <input type="hidden" value="tabs2" name="active_tab" />
            <table width="100%" class="sitemile-table">
            	<tr>
                <td><?php _e('Search User','shipme'); ?></td>
                <td><input type="text" value="<?php echo $_GET['search_user']; ?>" name="search_user" size="20" /> <input   type="submit"  class="button button-primary button-large" name="shipme_save2" value="<?php _e('Search','shipme'); ?>"/></td>
                </tr>
     
            
            </table>
            </form> 
          	
            <?php
		  
		  	$user = trim($_GET['search_user']);
			$user = get_userdatabylogin($user);
		  	$uid = $user->ID;
		  
		   	$s = "select * from ".$wpdb->prefix."project_ratings where touser='$uid' and awarded>0 order by id desc";
			$r = $wpdb->get_results($s);
		  	
			if(count($r) > 0):
		  
		  ?>
          
           <table class="widefat post fixed" cellspacing="0">
            <thead>
            <tr>
            <th><?php _e('Rated User','shipme'); ?></th>
            <th><?php _e('Job','shipme'); ?></th>
            <th><?php _e('Rating','shipme'); ?></th>
            <th><?php _e('Description','shipme'); ?></th>
            <th><?php _e('Awarded On','shipme'); ?></th>
            <th><?php _e('Options','shipme'); ?></th>
            </tr>
            </thead>
            
            
            
            <tbody>
            <?php
            
           
           
            foreach($r as $row)
            {
                $post = get_post($row->pid);
				$userdata = get_userdata($row->touser);
				$pid = $row->pid;
				
				echo '<tr>';
				echo '<th>'.$userdata->user_login.'</th>';
				echo '<th><a href="'.get_permalink($pid).'">'.$post->post_title.'</a></th>';
				echo '<th>'.($row->grade / 2).'</th>';
				echo '<th>'.$row->comment.'</th>';
				echo '<th>'.date('d-M-Y H:i:s', $row->datemade).'</th>';
				echo '<th>#</th>';
				echo '</tr>';
				
				
            }
            
            ?>
            </tbody>
            
            
            </table>
            <?php else: ?>
            
            <div class="padd101">
            <?php _e('There are no user feedback.','shipme'); ?>
            </div>
            
            <?php endif; ?>
            
            
          </div>
          
          <div id="tabs3">		
          </div>   
    
    
    <?php	
	
	echo '</div>';
}




function shipme_orders()
{
	global $menu_admin_shipme_bull;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general-orders"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">shipme Orders</h2>';
	
	if(isset($_GET['mark_delivered']))
	{
		$tm = current_time('timestamp',0);
		$pid = $_GET['mark_delivered'];
		
		update_post_meta($pid, 'mark_coder_delivered',			"1");
		update_post_meta($pid, 'mark_coder_delivered_date',		$tm);
		$winner_bd = shipme_get_winner_bid($pid);
		
		//------------------------------------------------------------------------------
		
		shipme_send_email_on_delivered_job_to_bidder($pid, $winner_bd->uid);
		shipme_send_email_on_delivered_job_to_owner($pid);		
		
		echo '<div class="saved_thing">Marked Delivered!</div>';
		
	}	
	
	if(isset($_GET['mark_completed']))
	{
		$tm = current_time('timestamp',0);
		$pid = $_GET['mark_completed'];
		$pstpst = get_post($pid);
		
		update_post_meta($pid, 'mark_seller_accepted',		"1");
		update_post_meta($pid, 'mark_seller_accepted_date',		$tm);
		
		update_post_meta($pid, 'outstanding',	"0");
		update_post_meta($pid, 'delivered',		"1");		
		//update_post_meta($pid, 'paid_user',		"1");		
		
		//------------------------------------------------------------------------------
		
		shipme_send_email_on_completed_job_to_bidder($pid, $pstpst->post_author);
		shipme_send_email_on_completed_job_to_owner($pid);		
		
		echo '<div class="saved_thing">Marked Completed!</div>';
		
	}
	
	
	if(isset($_GET['mark_paid']))
	{
		$tm = current_time('timestamp',0);
		$pid = $_GET['mark_paid'];
 
		update_post_meta($pid, 'paid_user_date',		$tm);		
		update_post_meta($pid, 'paid_user',		"1");	 	
		
		echo '<div class="saved_thing">Marked Paid!</div>';
		
	}	
	
	
	?>
    
        <div id="usual2" class="usual"> 
  <ul> 
    <li><a href="#tabs1">Open Orders</a></li> 
    <li><a href="#tabs2">Delivered Orders</a></li>
    <li><a href="#tabs3">Completed Orders</a></li>
    <li><a href="#tabs4">Paid Orders</a></li>
    <!-- <li><a href="#tabs4">Failed &amp; Disputed Orders</a></li> -->
    <?php do_action('shipme_main_menu_orders_tabs'); ?>
  </ul> 
  <div id="tabs1" style="display: none; ">
    	<?php
		
		global $current_user;
				get_currentuserinfo();
				$uid = $current_user->ID;
				
				
				global $wp_query;
				$query_vars = $wp_query->query_vars;
				$post_per_page = 25;				
				
		
				$outstanding = array(
						'key' => 'outstanding',
						'value' => "1",
						'compare' => '='
					);
					
				$winner = array(
						'key' => 'winner',
						'value' => 0,
						'compare' => '!='
					);		
				
				
				$delivered2 = array(
						'key' => 'delivered',
						'value' => "1",
						'compare' => '!='
					);
					
						
				$mark_coder_delivered = array(
						'key' => 'mark_coder_delivered',
						'value' => "1",
						'compare' => '!='
					);
				
				
				
				$pj = $_GET['pj1'];
				if(empty($_GET['pj1'])) $pj = 1;
				
				$args = array('post_type' => 'job_ship', 'order' => 'DESC', 'posts_per_page' => $post_per_page,
				'paged' => $pj, 'meta_query' => array($outstanding, $winner, $delivered2, $mark_coder_delivered));
				
				add_filter('posts_join', 	'shipme_posts_join_0');
				add_filter('posts_orderby', 'shipme_posts_orderby_0' );
				
				query_posts($args);
				
				 
				 
				 
				if(have_posts()) :
				
				echo '<table class="widefat post fixed">';
				echo '<thead>';
					echo '<th>Job Title</th>';
					echo '<th>Job Creator</th>';
					echo '<th>Bidder</th>';
					
					echo '<th>Winning Bid</th>';
					echo '<th>Date Ordered</th>';
					echo '<th>Expected Delivery</th>';
					echo '<th>Options</th>';
				
				echo '</thead>';
				
				while ( have_posts() ) : the_post();
				
					$bid = shipme_get_winner_bid(get_the_ID()); $bidsa = $bid;
					$bid = shipme_get_show_price($bid->bid);
					$post = get_post(get_the_ID());
					$creator = get_userdata($post->post_author);
					
					$winner = get_post_meta(get_the_ID(), 'winner', true);
					$winner = get_userdata($winner);	
					$winner = '<a href="'.shipme_get_user_profile_link($winner->ID).'">'.$winner->user_login.'</a>';
					$creator = '<a href="'.shipme_get_user_profile_link($post->post_author).'">'.$creator->user_login.'</a>';
					
					$tm_d = get_post_meta(get_the_ID(), 'expected_delivery', true);							
					$tm_d = date_i18n('d-M-Y H:i:s', $tm_d);
					$closed_date = get_post_meta(get_the_ID(), 'closed_date', true);	
					$winner_date = date_i18n('d-M-Y H:i:s', $closed_date);
					
					echo '</tr>';
					echo '<th><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></th>';
					echo '<th>'.$creator.'</th>';
					echo '<th>'.$winner.'</th>';
					
					echo '<th>'.$bid.'</th>';
					echo '<th>'.$winner_date.'</th>';
					echo '<th>'.$tm_d.'</th>';
					
					echo '<th><a href="'.get_admin_url().'admin.php?page=orders&pj1='.$pj.'&mark_delivered='.get_the_ID().'">Mark Delivered</a></th>';
					
					
					echo '</tr>';
				endwhile;
				
				echo '</table>';
				
				//-------------------------------------------------------
				
				if(function_exists('wp_pagenavi')):
				
								if ( !is_array( $args ) ) {
						$argv = func_get_args();
						$args = array();
						foreach ( array( 'before', 'after', 'options' ) as $i => $key )
							$args[ $key ] = $argv[ $i ];
					}
				
					$args = wp_parse_args( $args, array(
						'before' => '',
						'after' => '',
						'options' => array(),
						'query' => $GLOBALS['wp_query'],
						'type' => 'posts',
						'echo' => true
						) );
	
				$instance = new PageNavi_Call( $args );
				list( $posts_per_page, $paged, $total_pages ) = $instance->get_pagination_args();
				
				for($i=1; $i<=$total_pages; $i++)
				{
					if($pj == $i)
					echo $i.' | ';
					else
					echo '<a href="'.get_admin_url().'admin.php?page=orders&pj1='.$i.'">'.$i.'</a> | ';		
				}
				
				 endif;
				
				//------------ end pagination ------------------
				
				 else:
				
				_e("There are no outstanding jobs yet.",'shipme');
				
				endif;
				wp_reset_query();
		
		
		?>
        
          </div> 
        
        
        <div id="tabs2" style="display: none; ">
        
        <?php
		
		global $current_user;
				get_currentuserinfo();
				$uid = $current_user->ID;
				
				
				global $wp_query;
				$query_vars = $wp_query->query_vars;
				$post_per_page = 25;				
				
				
				$delivered = array(
						'key' => 'mark_coder_delivered',
						'value' => "1",
						'compare' => '='
					);
					
				$mark_seller_accepted = array(
						'key' => 'mark_seller_accepted',
						'value' => "1",
						'compare' => '!='
					);
					
				$paid = array(
						'key' => 'paid_user',
						'value' => "0",
						'compare' => '='
					);
					
				
				
						
	
				$pj = $_GET['pj2'];
				if(empty($_GET['pj2'])) $pj = 1;		
				
				
				$args = array('post_type' => 'job_ship', 'posts_per_page' => $post_per_page,
				'paged' => $pj, 'meta_query' => array($delivered, $paid, $mark_seller_accepted));
				
				add_filter('posts_join', 	'shipme_posts_join_0');
				add_filter('posts_orderby', 'shipme_posts_orderby_0' );
				
				
				query_posts($args);

				if(have_posts()) :
				
				echo '<table class="widefat post fixed">';
				echo '<thead>';
					echo '<th>Job Title</th>';
					echo '<th>Job Creator</th>';
					echo '<th>Bidder</th>';
					
					echo '<th>Winning Bid</th>';
					echo '<th>Date Ordered</th>';
					echo '<th>Delivered On</th>';
					echo '<th>Options</th>';
				
				echo '</thead>';
				
				while ( have_posts() ) : the_post();
				
					$bid = shipme_get_winner_bid(get_the_ID());
					$bid = shipme_get_show_price($bid->bid);
					
					$post = get_post(get_the_ID());
					$creator = get_userdata($post->post_author);
					
					$winner = get_post_meta(get_the_ID(), 'winner', true);
					$winner = get_userdata($winner);	
					$winner = '<a href="'.shipme_get_user_profile_link($winner->ID).'">'.$winner->user_login.'</a>';
					$creator = '<a href="'.shipme_get_user_profile_link($post->post_author).'">'.$creator->user_login.'</a>';

					$tm_d = get_post_meta(get_the_ID(), 'mark_coder_delivered_date', true);							
					$tm_d = date_i18n('d-M-Y H:i:s', $tm_d);
					$closed_date = get_post_meta(get_the_ID(), 'closed_date', true);	
					$winner_date = date_i18n('d-M-Y H:i:s', $closed_date);
					
					echo '</tr>';
					echo '<th><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></th>';
					echo '<th>'.$creator.'</th>';
					echo '<th>'.$winner.'</th>';
					
					echo '<th>'.$bid.'</th>';					
					echo '<th>'.$winner_date.'</th>';
					echo '<th>'.$tm_d.'</th>';
					echo '<th><a href="'.get_admin_url().'admin.php?page=orders&pj2='.$pj.'&active_tab=tabs2&mark_completed='.get_the_ID().'">Mark Completed</a></th>';
					
					echo '</tr>';
				endwhile;
				
				echo '</table>';
				
				//-------------------------------------------------------
				
				if(function_exists('wp_pagenavi')):
				
								if ( !is_array( $args ) ) {
						$argv = func_get_args();
						$args = array();
						foreach ( array( 'before', 'after', 'options' ) as $i => $key )
							$args[ $key ] = $argv[ $i ];
					}
				
					$args = wp_parse_args( $args, array(
						'before' => '',
						'after' => '',
						'options' => array(),
						'query' => $GLOBALS['wp_query'],
						'type' => 'posts',
						'echo' => true
						) );
	
				$instance = new PageNavi_Call( $args );
				list( $posts_per_page, $paged, $total_pages ) = $instance->get_pagination_args();
				
				for($i=1; $i<=$total_pages; $i++)
				{
					if($pj == $i)
					echo $i.' | ';
					else
					echo '<a href="'.get_admin_url().'admin.php?page=orders&pj2='.$i.'&active_tab=tabs2">'.$i.'</a> | ';		
				}
				
				 endif;
				
				//------------ end pagination ------------------
				
				 else:
				
				_e("There are no delivered jobs yet.",'shipme');
				
				endif;
				wp_reset_query();
		
		
		?>
        
        </div> 
       
       
        
        
         <div id="tabs3" style="display: none; ">
         
         
         <?php
		
				global $current_user;
				get_currentuserinfo();
				$uid = $current_user->ID;
				
				
				global $wp_query;
				$query_vars = $wp_query->query_vars;
				$post_per_page = 25;				
				
				
				$delivered = array(
						'key' => 'mark_seller_accepted',
						'value' => "1",
						'compare' => '='
					);
					
				$delivered2 = array(
						'key' => 'delivered',
						'value' => "1",
						'compare' => '='
					);	
					
				$paid = array(
						'key' => 'paid_user',
						'value' => "0",
						'compare' => '='
					);		
				
				
				
	
				$pj = $_GET['pj3'];
				if(empty($_GET['pj3'])) $pj = 1;
				
				$args = array('post_type' => 'job_ship', 'posts_per_page' => $post_per_page,
				'paged' => $pj, 'meta_query' => array($delivered, $delivered2, $paid));
				
				add_filter('posts_join', 	'shipme_posts_join_0');
				add_filter('posts_orderby', 'shipme_posts_orderby_0' );
				
				
				query_posts($args);

				if(have_posts()) :
				
				echo '<table class="widefat post fixed">';
				echo '<thead>';
					echo '<th>Job Title</th>';
					echo '<th>Job Creator</th>';
					echo '<th>Bidder</th>';
					
					echo '<th>Winning Bid</th>';
					echo '<th>Date Ordered</th>';
					echo '<th>Completed On</th>';
					echo '<th>Options</th>';
				
				echo '</thead>';
				
				while ( have_posts() ) : the_post();
				
					$bid = shipme_get_winner_bid(get_the_ID());
					$bid = shipme_get_show_price($bid->bid);
					
					$post = get_post(get_the_ID());
					$creator = get_userdata($post->post_author);
					
					$winner = get_post_meta(get_the_ID(), 'winner', true);
					$winner = get_userdata($winner);	
					$winner = '<a href="'.shipme_get_user_profile_link($winner->ID).'">'.$winner->user_login.'</a>';
					
					$tm_d = get_post_meta(get_the_ID(), 'mark_seller_accepted_date', true);							
					$tm_d = date_i18n('d-M-Y H:i:s', $tm_d);
					$closed_date = get_post_meta(get_the_ID(), 'closed_date', true);	
					$winner_date = date_i18n('d-M-Y H:i:s', $closed_date);
					$creator = '<a href="'.shipme_get_user_profile_link($post->post_author).'">'.$creator->user_login.'</a>';
					$paid_user = get_post_meta(get_the_ID(), 'paid_user', true);
					
					
					echo '</tr>';
					echo '<th><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></th>';
					echo '<th>'.$creator.'</th>';
					
					echo '<th>'.$winner.'</th>';
					
					echo '<th>'.$bid.'</th>';
					echo '<th>'.$winner_date.'</th>';
					echo '<th>'.$tm_d.'</th>';
					echo '<th>'.'<a href="'.get_admin_url().'admin.php?active_tab=tabs3&page=orders&pj3='.$pj.'&mark_paid='.get_the_ID().'">Mark Paid</a>'.'</th>';
					
					 
					echo '</tr>';
				endwhile;
				
				echo '</table>';
				
				//-------------------------------------------------------
				
				if(function_exists('wp_pagenavi')):
				
								if ( !is_array( $args ) ) {
						$argv = func_get_args();
						$args = array();
						foreach ( array( 'before', 'after', 'options' ) as $i => $key )
							$args[ $key ] = $argv[ $i ];
					}
				
					$args = wp_parse_args( $args, array(
						'before' => '',
						'after' => '',
						'options' => array(),
						'query' => $GLOBALS['wp_query'],
						'type' => 'posts',
						'echo' => true
						) );
	
				$instance = new PageNavi_Call( $args );
				list( $posts_per_page, $paged, $total_pages ) = $instance->get_pagination_args();
				
				for($i=1; $i<=$total_pages; $i++)
				{
					if($pj == $i)
					echo $i.' | ';
					else
					echo '<a href="'.get_admin_url().'admin.php?page=orders&pj3='.$i.'&active_tab=tabs3">'.$i.'</a> | ';		
				}
				
				 endif;
				
				//------------ end pagination ------------------
				
				 else:
				
				_e("There are no completed jobs yet.",'shipme');
				
				endif;
				wp_reset_query();
		
		
		?>
         
         
         </div> 
         
         
         
         
         <div id="tabs4" style="display: none; ">
         
         
         <?php
		
				global $current_user;
				get_currentuserinfo();
				$uid = $current_user->ID;
				
				
				global $wp_query;
				$query_vars = $wp_query->query_vars;
				$post_per_page = 25;				
				
				
				$delivered = array(
						'key' => 'mark_seller_accepted',
						'value' => "1",
						'compare' => '='
					);
					
				$delivered2 = array(
						'key' => 'delivered',
						'value' => "1",
						'compare' => '='
					);	
					
				$paid = array(
						'key' => 'paid_user',
						'value' => "1",
						'compare' => '='
					);		
				
				
				
	
				$pj = $_GET['pj4'];
				if(empty($_GET['pj4'])) $pj = 1;
				
				$args = array('post_type' => 'job_ship', 'posts_per_page' => $post_per_page,
				'paged' => $pj, 'meta_query' => array($delivered, $delivered2, $paid));
				
				add_filter('posts_join', 	'shipme_posts_join_0');
				add_filter('posts_orderby', 'shipme_posts_orderby_0' );
				
				
				query_posts($args);

				if(have_posts()) :
				
				echo '<table class="widefat post fixed">';
				echo '<thead>';
					echo '<th>Job Title</th>';
					echo '<th>Job Creator</th>';
					echo '<th>Bidder</th>';
					
					echo '<th>Winning Bid</th>';
					echo '<th>Date Ordered</th>';
					echo '<th>Completed On</th>';
					echo '<th>Paid On</th>';
				
				echo '</thead>';
				
				while ( have_posts() ) : the_post();
				
					$bid = shipme_get_winner_bid(get_the_ID());
					$bid = shipme_get_show_price($bid->bid);
					
					$post = get_post(get_the_ID());
					$creator = get_userdata($post->post_author);
					
					$winner = get_post_meta(get_the_ID(), 'winner', true);
					$winner = get_userdata($winner);	
					$winner = '<a href="'.shipme_get_user_profile_link($winner->ID).'">'.$winner->user_login.'</a>';
					
					$tm_d = get_post_meta(get_the_ID(), 'mark_seller_accepted_date', true);							
					$tm_d = date_i18n('d-M-Y H:i:s', $tm_d);
					$closed_date = get_post_meta(get_the_ID(), 'closed_date', true);	
					$winner_date = date_i18n('d-M-Y H:i:s', $closed_date);
					$creator = '<a href="'.shipme_get_user_profile_link($post->post_author).'">'.$creator->user_login.'</a>';
					$paid_user = get_post_meta(get_the_ID(), 'paid_user', true);
					
					$paid_user_date = get_post_meta(get_the_ID(), 'paid_user_date', true);
					if(!empty($paid_user_date)) $paid_user_date = date_i18n('d-M-Y H:i:s', $paid_user_date);
					
					
					echo '</tr>';
					echo '<th><a href="'.get_permalink(get_the_ID()).'">'.get_the_title().'</a></th>';
					echo '<th>'.$creator.'</th>';
					
					echo '<th>'.$winner.'</th>';
					
					echo '<th>'.$bid.'</th>';
					echo '<th>'.$winner_date.'</th>';
					echo '<th>'.$tm_d.'</th>';
					echo '<th>'.$paid_user_date.'</th>';
					
					 
					echo '</tr>';
				endwhile;
				
				echo '</table>';
				
				//-------------------------------------------------------
				
				if(function_exists('wp_pagenavi')):
				
								if ( !is_array( $args ) ) {
						$argv = func_get_args();
						$args = array();
						foreach ( array( 'before', 'after', 'options' ) as $i => $key )
							$args[ $key ] = $argv[ $i ];
					}
				
					$args = wp_parse_args( $args, array(
						'before' => '',
						'after' => '',
						'options' => array(),
						'query' => $GLOBALS['wp_query'],
						'type' => 'posts',
						'echo' => true
						) );
	
				$instance = new PageNavi_Call( $args );
				list( $posts_per_page, $paged, $total_pages ) = $instance->get_pagination_args();
				
				for($i=1; $i<=$total_pages; $i++)
				{
					if($pj == $i)
					echo $i.' | ';
					else
					echo '<a href="'.get_admin_url().'admin.php?page=orders&pj4='.$i.'&active_tab=tabs4">'.$i.'</a> | ';		
				}
				
				 endif;
				
				//------------ end pagination ------------------
				
				 else:
				
				_e("There are no paid jobs yet.",'shipme');
				
				endif;
				wp_reset_query();
		
		
		?>
         
         
         </div> 
         
         
         
         
         </div> 
         

    	
        <?php do_action('shipme_main_menu_orders_content'); ?>
    
    <?php	
	
	echo '</div>';
}


	function shipme_posts_join_0($join) {
		global $wp_query, $wpdb;
 
		$join .= " LEFT JOIN (
				SELECT post_id, meta_value as closed_date_due
				FROM $wpdb->postmeta
				WHERE meta_key =  'closed_date' ) AS DD
				ON $wpdb->posts.ID = DD.post_id ";

 
		return $join;
	}

//------------------------------------------------------

	function shipme_posts_orderby_0( $orderby )
	{
		global $wpdb;
		$orderby = " closed_date_due+0 desc, $wpdb->posts.post_date desc ";
		return $orderby;
	}





function shipme_theme_escrows()
{
	global $menu_admin_shipme_bull;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general-vault"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">Shipme Escrows</h2>';

//----------------------------------------------------------------------

    global $wpdb;
	if(isset($_GET['release']))
	{
		
		$id = $_GET['release'];
						
						$s = "select * from ".$wpdb->prefix."shipme_escrow where id='$id'";
						$row = $wpdb->get_results($s); //mysql_query($s);
						
						if(count($row) == 1)
						{
							$row = $row[0];
							$amount = $row->amount;
							$toid = $row->toid;
							$fromid = $row->fromid;
							
							$shipme_fee_after_paid = get_option('shipme_fee_after_paid');
							if(!empty($shipme_fee_after_paid)):
							
								$deducted = $amount*($shipme_fee_after_paid * 0.01);
							else: 
							
								$deducted = 0;
							
							endif;
							
							//--------------
							
							$fromuser = get_userdata($fromid);
							
							$cr = shipme_get_credits($toid);
							shipme_update_credits($toid, $cr + $amount - $deducted);
							
							$reason = sprintf(__('Payment received from %s','shipme'), $fromuser->user_login);
							shipme_add_history_log('1', $reason, $amount, $toid, $fromid);
							
							if($deducted > 0)
							$reason = sprintf(__('Payment fee for project %s','shipme'), $my_pst->post_title);
							shipme_add_history_log('0', $reason, $deducted, $toid );
							
					
							//-----------------------------
							$email 		= get_bloginfo('admin_email');
							$site_name 	= get_bloginfo('name');
							
							$usr = get_userdata($fromid);
							
							$subject = __("Money Escrow Completed",'shipme');
							$message = sprintf(__("You have released the escrow of: %s", 'shipme'), shipme_get_show_price($amount));
	
						//	sitemile_send_email($usr->user_email, $subject , $message);
							
							//-----------------------------
							
							$usr = get_userdata($toid);
							
							$reason = 'Payment sent to '.$usr->user_login;

							shipme_add_history_log('0', $reason, $amount, $fromid, $toid);
							
							$subject = sprintf(__("Money Escrow Completed",'shipme'));
							$message = sprintf(__("You have received the amount of: %s",'shipme'), shipme_get_show_price($amount));
	
							//sitemile_send_email($usr->user_email, $subject , $message);
							
							//-----------------------------
							
							$tm = current_time('timestamp',0);
							$s = "update ".$wpdb->prefix."shipme_escrow set released='1', releasedate='$tm' where
							id='$id'";
							$wpdb->query($s);
						
							echo '<div class="saved_thing">'.__('Escrow completed!','shipme'). '</div>';	
						}
		
		
	}
	
	if(isset($_GET['close']))
	{
		
		$id = $_GET['close'];
		
		$s = "select * from ".$wpdb->prefix."shipme_escrow where id='$id'";
		$row = $wpdb->get_results($s);
						
						if(count($row) == 1)
						{							
							$row = $row[0];
							$amount = $row->amount;
							$fromid = $row->fromid;
							
							$cr = shipme_get_credits($fromid);
							shipme_update_credits($fromid, $cr + $amount);
							
						}
		
		
		$s = "delete from ".$wpdb->prefix."shipme_escrow where	id='$id'";
		$wpdb->query($s);
							
		echo '<div class="saved_thing">'.__('Escrow closed!','shipme'). '</div>';	
		
	} ?>
    
    
        <div id="usual2" class="usual"> 
  <ul> 
    <li><a href="#tabs1" class="selected">Open Escrows</a></li> 
    <li><a href="#tabs2">Completed Escrows</a></li> 
  </ul> 
  <div id="tabs1" style="display: block; ">
    <?php
	
		$s = "select * from ".$wpdb->prefix."shipme_escrow where released='0' order by id desc";
		$r = $wpdb->get_results($s);
		
		if(count($r) > 0):
	?>
    
    	     <table class="widefat post fixed" cellspacing="0">
    <thead>
    <tr>
    <th width="10%">From User</th>
    <th width="10%">To User</th>
    <th width="10%">Job</th>
    <th>Date Made</th>
    <th >Amount</th>
	<th >Options</th>
    </tr>
    </thead>
    
    
    
    <tbody>


	<?php
	

	
	foreach($r as $row)
	{
		$user1 = get_userdata($row->fromid);
		$user2 = get_userdata($row->toid);
		$post  = get_post($row->pid); 
		
		echo '<tr>';	
		echo '<th>'.$user1->user_login.'</th>';
		echo '<th>'.$user2->user_login .'</th>';
		echo '<th><a href="'.get_permalink($row->pid).'">'.$post->post_title .'</a></th>';
		echo '<th>'.date('d-M-Y H:i:s',$row->datemade) .'</th>';
		echo '<th>'.shipme_get_show_price($row->amount) .'</th>';
		echo '<th><a href="'.get_admin_url().'admin.php?page=Escrows&release='.$row->id.'" class="awesome">Release</a> | <a href="'.get_admin_url().'admin.php?page=Escrows&close='.$row->id.'" class="trash">Close</a> </th>';
	
	
		echo '</tr>';
	}
	
	?>



	</tbody>
    
    
    </table>
    
    <?php else: ?>
    
    There are no results.
    
    <?php endif; ?>
        
          </div> 
          <div id="tabs2" style="display: none; ">
          
           <?php
	
		$s = "select * from ".$wpdb->prefix."shipme_escrow where released='1' order by id desc";
		$r = $wpdb->get_results($s);
		
		if(count($r) > 0):
	?>
    
    	     <table class="widefat post fixed" cellspacing="0">
    <thead>
    <tr>
    <th width="10%">From User</th>
    <th width="10%">To User</th>
    <th width="10%">Job</th>
    <th>Date Made</th>
    <th >Amount</th>
	<th >Options</th>
    </tr>
    </thead>
    
    
    
    <tbody>


	<?php
	

	
	foreach($r as $row)
	{
		$user1 = get_userdata($row->fromid);
		$user2 = get_userdata($row->toid);
		$post  = get_post($row->pid); 
		
		echo '<tr>';	
		echo '<th>'.$user1->user_login.'</th>';
		echo '<th>'.$user2->user_login .'</th>';
		echo '<th><a href="'.get_permalink($row->pid).'">'.$post->post_title .'</a></th>';
		echo '<th>'.date('d-M-Y H:i:s',$row->datemade) .'</th>';
		echo '<th>'.shipme_get_show_price($row->amount) .'</th>';
		echo '<th>#</th>';
	
	
		echo '</tr>';
	}
	
	?>



	</tbody>
    
    
    </table>
    
    <?php else: ?>
    
    There are no results.
    
    <?php endif; ?>
        
          
          
          </div> 
        </div> 
    
    
    <?php	
	
	echo '</div>';
}


function shipme_theme_withdrawals()
{
	global $menu_admin_shipme_bull, $wpdb;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general-withdr"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">shipme Withdrawals</h2>';
	
	
	if(isset($_GET['den_id']))
	{
		$den_id = $_GET['den_id'];
		$s = "update ".$wpdb->prefix."shipme_withdraw set rejected='1' where id='$den_id'";
		$row = $wpdb->get_results($s);	
		echo '<div class="saved_thing">Request denied!</div>';
		
		
		$s = "select * from ".$wpdb->prefix."shipme_withdraw where id='$den_id' ";
		$r = $wpdb->get_results($s);
						
		if(count($r) == 1)
		{
			$row = $r[0];
			$amount = $row->amount;
			$uid = $row->uid;
							
			$cr = shipme_get_credits($uid);
			shipme_update_credits($uid, $cr + $amount);
		
		}
		
	}
	
	if(isset($_GET['tid']))
	{
		$tm = current_time('timestamp',0);
		$ids = $_GET['tid'];
		
		$s = "select * from ".$wpdb->prefix."shipme_withdraw where id='$ids'";
		$row = $wpdb->get_results($s);
		$row = $row[0];

		
		if($row->done == 0)
		{
			echo '<div class="saved_thing">Payment completed!</div>';
			$ss = "update ".$wpdb->prefix."shipme_withdraw set done='1', datedone='$tm' where id='$ids'";
			$wpdb->query($ss);// or die(mysql_error());
			
			
			$usr = get_userdata($row->uid);
			
			$site_name 		= get_bloginfo('name');
			$email		 	= get_bloginfo('admin_email');
			
			$subject = sprintf(__("Your withdrawal has been completed: %s",'shipme'), shipme_get_show_price($row->amount));
			$message = sprintf(__("Your withdrawal has been completed: %s",'shipme'), shipme_get_show_price($row->amount));
			
			//sitemile_send_email($usr->user_email, $subject , $message);
	
			
			$reason = sprintf(__('Withdraw to PayPal to email: %s','shipme') ,$row->payeremail);
			shipme_add_history_log('0', $reason, $row->amount, $usr->ID);
		}
	}
	
	?>
    
        <div id="usual2" class="usual"> 
  <ul> 
    <ul> 
            <li><a href="#tabs1"><?php _e('Unresolved Requests','shipme'); ?></a></li> 
            <li><a href="#tabs2"><?php _e('Resolved Requests','shipme'); ?></a></li> 
            <li><a href="#tabs_rejected"><?php _e('Rejected Requests','shipme'); ?></a></li> 
            <li><a href="#tabs3"><?php _e('Search Unresolved','shipme'); ?></a></li> 
            <li><a href="#tabs4"><?php _e('Search Solved','shipme'); ?></a></li> 
            <li><a href="#tabs_search_rejected"><?php _e('Search Rejected','shipme'); ?></a></li> 
          </ul> 
  </ul> 
  <div id="tabs1">
          <?php
		  
		   $s = "select * from ".$wpdb->prefix."shipme_withdraw where done='0' and rejected!='1' order by id desc";
           $r = $wpdb->get_results($s);
		  	
			if(count($r) > 0):
		  
		  ?>
          
           <table class="widefat post fixed" cellspacing="0">
            <thead>
            <tr>
            <th width="12%" ><?php _e('Mobile Number','shipme'); ?></th>
            <th><?php _e('Method','shipme'); ?></th>
            <th width="20%"><?php _e('Details','shipme'); ?></th>
            <th><?php _e('Date Requested','shipme'); ?></th>
            <th ><?php _e('Amount','shipme'); ?></th>
            <th width="25%"><?php _e('Options','shipme'); ?></th>
            </tr>
            </thead>
            
            
            
            <tbody>
            <?php
            
           
            
            foreach($r as $row)
            {
                $user = get_userdata($row->uid);
                
                echo '<tr>';	
                echo '<th>'.$user->user_login.'</th>';
                echo '<th>'.$row->methods .'</th>';
				 echo '<th>'.$row->payeremail .'</th>';
                echo '<th>'.date('d-M-Y H:i:s',$row->datemade) .'</th>';
                echo '<th>'.shipme_get_show_price($row->amount) .'</th>';
                echo '<th>'.($row->done == 0 ? '<a href="'.get_admin_url().'admin.php?page=Withdrawals&active_tab=tabs1&tid='.$row->id.'" class="awesome">'.
                __('Make Complete','shipme').'</a>' . ' | ' . '<a href="'.get_admin_url().'admin.php?page=Withdrawals&den_id='.$row->id.'" class="awesome">'.
                __('Deny Request','shipme').'</a>' :( $row->done == 1 ? __("Completed",'shipme') : __("Rejected",'shipme') ) ).'</th>';
                echo '</tr>';
            }
            
            ?>
            </tbody>
            
            
            </table>
            <?php else: ?>
            
            <div class="padd101">
            <?php _e('There are no unresolved withdrawal requests.','shipme'); ?>
            </div>
            
            <?php endif; ?>
          
          	
          </div>
          
          <div id="tabs2">	
          
          
          <?php
		  
		   $s = "select * from ".$wpdb->prefix."shipme_withdraw where done='1' order by id desc";
           $r = $wpdb->get_results($s);
		  	

			if(count($r) > 0):
		  
		  ?>
          
           <table class="widefat post fixed" cellspacing="0">
            <thead>
            <tr>
            <th ><?php 	_e('Mobile Number','shipme'); ?></th>
            <th><?php 	_e('Method','shipme'); ?></th>
            <th><?php 	_e('Details','shipme'); ?></th>
            <th><?php 	_e('Date Requested','shipme'); ?></th>
            <th ><?php 	_e('Amount','shipme'); ?></th>
            <th><?php 	_e('Date Released','shipme'); ?></th>
            <th><?php 	_e('Options','shipme'); ?></th>
            </tr>
            </thead>
            
            
            
            <tbody>
            <?php
            
           
            
            foreach($r as $row)
            {
                $user = get_userdata($row->uid);
                
                echo '<tr>';	
                echo '<th>'.$user->user_login.'</th>';
				echo '<th>'.$user->methods.'</th>';
                echo '<th>'.$row->payeremail .'</th>';
                echo '<th>'.date('d-M-Y H:i:s',$row->datemade) .'</th>';
                echo '<th>'.shipme_get_show_price($row->amount) .'</th>';
                echo '<th>'.($row->datedone == 0 ? "Not yet" : date('d-M-Y H:i:s',$row->datedone)) .'</th>';
                echo '<th>'.($row->done == 0 ? '<a href="'.get_admin_url().'admin.php?page=Withdrawals&active_tab=tabs1&tid='.$row->id.'" class="awesome">'.
                __('Make Complete','shipme').'</a>' . ' | ' . '<a href="'.get_admin_url().'admin.php?page=Withdrawals&den_id='.$row->id.'" class="awesome">'.
                __('Deny Request','shipme').'</a>' :( $row->done == 1 ? __("Completed",'shipme') : __("Rejected",'shipme') ) ).'</th>';
                echo '</tr>';
            }
            
            ?>
            </tbody>
            
            
            </table>
            <?php else: ?>
            
            <div class="padd101">
            <?php _e('There are no resolved withdrawal requests.','shipme'); ?>
            </div>
            
            <?php endif; ?>
          
          
          </div>
          
          <div id="tabs_rejected">	
          
          
          <?php
		  
		   $s = "select * from ".$wpdb->prefix."shipme_withdraw where rejected='1' order by id desc";
           $r = $wpdb->get_results($s);
		  	
			if(count($r) > 0):
		  
		  ?>
          
           <table class="widefat post fixed" cellspacing="0">
            <thead>
            <tr>
            <th ><?php _e('Mobile Number','shipme'); ?></th>
            <th><?php _e('Details','shipme'); ?></th>
            <th><?php _e('Date Requested','shipme'); ?></th>
            <th ><?php _e('Amount','shipme'); ?></th>
            <th><?php _e('Date Released','shipme'); ?></th>
            <th><?php _e('Options','shipme'); ?></th>
            </tr>
            </thead>
            
            
            
            <tbody>
            <?php
            
           
            
            foreach($r as $row)
            {
                $user = get_userdata($row->uid);
                
                echo '<tr>';	
                echo '<th>'.$user->user_login.'</th>';
                echo '<th>'.$row->payeremail .'</th>';
                echo '<th>'.date('d-M-Y H:i:s',$row->datemade) .'</th>';
                echo '<th>'.shipme_get_show_price($row->amount) .'</th>';
                echo '<th>'.__('Rejected','shipme') .'</th>';
                echo '<th>#</th>';
                echo '</tr>';
            }
            
            ?>
            </tbody>
            
            
            </table>
            <?php else: ?>
            
            <div class="padd101">
            <?php _e('There are no rejected withdrawal requests.','shipme'); ?>
            </div>
            
            <?php endif; ?>
          
          
          </div>
          
          
          <div id="tabs3">
          
          <form method="get" action="<?php echo get_admin_url(); ?>admin.php">
            <input type="hidden" value="Withdrawals" name="page" />
            <input type="hidden" value="tabs3" name="active_tab" />
            <table width="100%" class="sitemile-table">
            	<tr>
                <td><?php _e('Search User','shipme'); ?></td>
                <td><input type="text" value="<?php echo $_GET['search_user']; ?>" name="search_user" size="20" /> <input type="submit"  class="button button-primary button-large" name="shipme_save3" value="<?php _e('Search','shipme'); ?>"/></td>
                </tr>
     
            
            </table>
            </form> 
            
            <?php
			
			if(isset($_GET['shipme_save3'])):
				
				$search_user = trim($_GET['search_user']);
				
				$user 	= get_userdatabylogin($search_user);
				$uid 	= $user->ID;
				
				$s = "select * from ".$wpdb->prefix."shipme_withdraw where done='0' AND uid='$uid' order by id desc";
           $r = $wpdb->get_results($s);
		  	
			if(count($r) > 0):
		  
		  ?>
          
           <table class="widefat post fixed" cellspacing="0">
            <thead>
            <tr>
            <th width="12%" ><?php _e('Mobile Number','shipme'); ?></th>
            <th><?php _e('Method','shipme'); ?></th>
            <th width="20%"><?php _e('Details','shipme'); ?></th>
            <th><?php _e('Date Requested','shipme'); ?></th>
            <th ><?php _e('Amount','shipme'); ?></th>
            <th width="25%"><?php _e('Options','shipme'); ?></th>
            </tr>
            </thead>
            
            
            
            <tbody>
            <?php
            
           
            
            foreach($r as $row)
            {
                $user = get_userdata($row->uid);
                
                echo '<tr>';	
                echo '<th>'.$user->user_login.'</th>';
                echo '<th>'.$row->methods .'</th>';
				 echo '<th>'.$row->payeremail .'</th>';
                echo '<th>'.date('d-M-Y H:i:s',$row->datemade) .'</th>';
                echo '<th>'.shipme_get_show_price($row->amount) .'</th>';
                echo '<th>'.($row->done == 0 ? '<a href="'.get_admin_url().'admin.php?page=Withdrawals&active_tab=tabs1&tid='.$row->id.'" class="awesome">'.
                __('Make Complete','shipme').'</a>' . ' | ' . '<a href="'.get_admin_url().'admin.php?page=Withdrawals&den_id='.$row->id.'" class="awesome">'.
                __('Deny Request','shipme').'</a>' :( $row->done == 1 ? __("Completed",'shipme') : __("Rejected",'shipme') ) ).'</th>';
                echo '</tr>';
            }
            
            ?>
            </tbody>
            
            
            </table>
            <?php else: ?>
            
            <div class="padd101">
            <?php _e('There are no results for your search.','shipme'); ?>
            </div>
            
            <?php endif; 
				
			
			endif;
			
			?>
            
          		
          </div> 
          
          <div id="tabs4">	
          
          <form method="get" action="<?php echo get_admin_url(); ?>admin.php">
            <input type="hidden" value="Withdrawals" name="page" />
            <input type="hidden" value="tabs4" name="active_tab" />
            <table width="100%" class="sitemile-table">
            	<tr>
                <td><?php _e('Search User','shipme'); ?></td>
                <td><input type="text" value="<?php echo $_GET['search_user4']; ?>" name="search_user4" size="20" /> <input type="submit"  class="button button-primary button-large" name="shipme_save4" value="<?php _e('Search','shipme'); ?>"/></td>
                </tr>
     
            
            </table>
            </form> 
          	
             
            <?php
			
			if(isset($_GET['shipme_save4'])):
				
				$search_user = trim($_GET['search_user4']);
				
				$user 	= get_userdatabylogin($search_user);
				$uid 	= $user->ID;
				
				$s = "select * from ".$wpdb->prefix."shipme_withdraw where done='1' AND uid='$uid' order by id desc";
           $r = $wpdb->get_results($s);
		  	
			if(count($r) > 0):
		  
		  ?>
          
           <table class="widefat post fixed" cellspacing="0">
            <thead>
            <tr>
            <th width="12%" ><?php _e('Mobile Number','shipme'); ?></th>
            <th><?php _e('Method','shipme'); ?></th>
            <th width="20%"><?php _e('Details','shipme'); ?></th>
            <th><?php _e('Date Requested','shipme'); ?></th>
            <th ><?php _e('Amount','shipme'); ?></th>
            <th width="25%"><?php _e('Options','shipme'); ?></th>
            </tr>
            </thead>
            
            
            
            <tbody>
            <?php
            
           
            
            foreach($r as $row)
            {
                $user = get_userdata($row->uid);
                
                echo '<tr>';	
                echo '<th>'.$user->user_login.'</th>';
                echo '<th>'.$row->methods .'</th>';
				 echo '<th>'.$row->payeremail .'</th>';
                echo '<th>'.date('d-M-Y H:i:s',$row->datemade) .'</th>';
                echo '<th>'.shipme_get_show_price($row->amount) .'</th>';
                echo '<th>'.($row->done == 0 ? '<a href="'.get_admin_url().'admin.php?page=Withdrawals&active_tab=tabs1&tid='.$row->id.'" class="awesome">'.
                __('Make Complete','shipme').'</a>' . ' | ' . '<a href="'.get_admin_url().'admin.php?page=Withdrawals&den_id='.$row->id.'" class="awesome">'.
                __('Deny Request','shipme').'</a>' :( $row->done == 1 ? __("Completed",'shipme') : __("Rejected",'shipme') ) ).'</th>';
                echo '</tr>';
            }
            
            ?>
            </tbody>
            
            
            </table>
            <?php else: ?>
            
            <div class="padd101">
            <?php _e('There are no results for your search.','shipme'); ?>
            </div>
            
            <?php endif; 
				
			
			endif;
			
			?>
            
            </div>
          
          
          <div id="tabs_search_rejected">	
          
          <form method="get" action="<?php echo get_admin_url(); ?>admin.php">
            <input type="hidden" value="Withdrawals" name="page" />
            <input type="hidden" value="tabs_search_rejected" name="active_tab" />
            <table width="100%" class="sitemile-table">
            	<tr>
                <td><?php _e('Search User','shipme'); ?></td>
                <td><input type="text" value="<?php echo $_GET['search_user5']; ?>" name="search_user5" size="20" /> <input type="submit"  class="button button-primary button-large" name="shipme_save5" value="<?php _e('Search','shipme'); ?>"/></td>
                </tr>
     
            
            </table>
            </form> 
          	
            
             <?php
			
			if(isset($_GET['shipme_save5'])):
				
				$search_user = trim($_GET['search_user5']);
				
				$user 	= get_userdatabylogin($search_user);
				$uid 	= $user->ID;
				
				$s = "select * from ".$wpdb->prefix."shipme_withdraw where rejected='1' AND uid='$uid' order by id desc";
           $r = $wpdb->get_results($s);
		  	
			if(count($r) > 0):
		  
		  ?>
          
           <table class="widefat post fixed" cellspacing="0">
            <thead>
            <tr>
            <th width="12%" ><?php _e('Mobile Number','shipme'); ?></th>
            <th><?php _e('Method','shipme'); ?></th>
            <th width="20%"><?php _e('Details','shipme'); ?></th>
            <th><?php _e('Date Requested','shipme'); ?></th>
            <th ><?php _e('Amount','shipme'); ?></th>
            <th width="25%"><?php _e('Options','shipme'); ?></th>
            </tr>
            </thead>
            
            
            
            <tbody>
            <?php
            
           
            
            foreach($r as $row)
            {
                $user = get_userdata($row->uid);
                
                echo '<tr>';	
                echo '<th>'.$user->user_login.'</th>';
                echo '<th>'.$row->methods .'</th>';
				 echo '<th>'.$row->payeremail .'</th>';
                echo '<th>'.date('d-M-Y H:i:s',$row->datemade) .'</th>';
                echo '<th>'.shipme_get_show_price($row->amount) .'</th>';
                echo '<th>#</th>';
                echo '</tr>';
            }
            
            ?>
            </tbody>
            
            
            </table>
            <?php else: ?>
            
            <div class="padd101">
            <?php _e('There are no results for your search.','shipme'); ?>
            </div>
            
            <?php endif; 
				
			
			endif;
			
			?>
            
          </div> 
          
          
          

<?php
	echo '</div>';		
}

function shipme_email_settings()
{
	$id_icon 		= 'icon-options-general-email';
	$ttl_of_stuff 	= 'ShipMe - '.__('Email Settings','shipme');
	global $menu_admin_shipme_theme_bull;
	$arr = array( "yes" => 'Yes', "no" => "No");
	
	
		
	echo '<div class="wrap">';
	echo '<div class="icon32" id="'.$id_icon.'"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">'.$ttl_of_stuff.'</h2>';	
	
	//--------------------------------------------------------------------------
	
	if(isset($_POST['shipme_save1']))
	{
		update_option('shipme_email_name_from', 	trim($_POST['shipme_email_name_from']));
		update_option('shipme_email_addr_from', 	trim($_POST['shipme_email_addr_from']));
		update_option('shipme_allow_html_emails', trim($_POST['shipme_allow_html_emails']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_save2']))
	{
		update_option('shipme_new_user_email_subject', 	trim($_POST['shipme_new_user_email_subject']));
		update_option('shipme_new_user_email_message', 	trim($_POST['shipme_new_user_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_save_new_user_email_admin']))
	{
		update_option('shipme_new_user_email_admin_subject', 	trim($_POST['shipme_new_user_email_admin_subject']));
		update_option('shipme_new_user_email_admin_message', 	trim($_POST['shipme_new_user_email_admin_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
		if(isset($_POST['shipme_save3']))
	{
		update_option('shipme_new_job_email_not_approve_admin_enable', 	trim($_POST['shipme_new_job_email_not_approve_admin_enable']));
		update_option('shipme_new_job_email_not_approve_admin_subject', 	trim($_POST['shipme_new_job_email_not_approve_admin_subject']));
		update_option('shipme_new_job_email_not_approve_admin_message', 	trim($_POST['shipme_new_job_email_not_approve_admin_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}

	if(isset($_POST['shipme_save31']))
	{
		update_option('shipme_new_job_email_approve_admin_enable', 	trim($_POST['shipme_new_job_email_approve_admin_enable']));
		update_option('shipme_new_job_email_approve_admin_subject', 	trim($_POST['shipme_new_job_email_approve_admin_subject']));
		update_option('shipme_new_job_email_approve_admin_message', 	trim($_POST['shipme_new_job_email_approve_admin_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_save32']))
	{
		update_option('shipme_new_job_email_not_approved_enable', 	trim($_POST['shipme_new_job_email_not_approved_enable']));
		update_option('shipme_new_job_email_not_approved_subject', 	trim($_POST['shipme_new_job_email_not_approved_subject']));
		update_option('shipme_new_job_email_not_approved_message', 	trim($_POST['shipme_new_job_email_not_approved_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_save33']))
	{
		update_option('shipme_new_job_email_approved_enable', 	trim($_POST['shipme_new_job_email_approved_enable']));
		update_option('shipme_new_job_email_approved_subject', 	trim($_POST['shipme_new_job_email_approved_subject']));
		update_option('shipme_new_job_email_approved_message', 	trim($_POST['shipme_new_job_email_approved_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_message_board_bidder_email_save']))
	{
		update_option('shipme_message_board_bidder_email_enable', 	trim($_POST['shipme_message_board_bidder_email_enable']));
		update_option('shipme_message_board_bidder_email_message', 	trim($_POST['shipme_message_board_bidder_email_message']));
		update_option('shipme_message_board_bidder_email_subject', 	trim($_POST['shipme_message_board_bidder_email_subject']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_message_board_owner_email_save']))
	{
		update_option('shipme_message_board_owner_email_enable', 		trim($_POST['shipme_message_board_owner_email_enable']));
		update_option('shipme_message_board_owner_email_message', 	trim($_POST['shipme_message_board_owner_email_message']));
		update_option('shipme_message_board_owner_email_subject', 	trim($_POST['shipme_message_board_owner_email_subject']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_bid_job_bidder_email_save']))
	{
		update_option('shipme_bid_job_bidder_email_enable', 	trim($_POST['shipme_bid_job_bidder_email_enable']));
		update_option('shipme_bid_job_bidder_email_subject', 	trim($_POST['shipme_bid_job_bidder_email_subject']));
		update_option('shipme_bid_job_bidder_email_message', 	trim($_POST['shipme_bid_job_bidder_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_subscription_email_save']))
	{
		update_option('shipme_subscription_email_enable', 	trim($_POST['shipme_subscription_email_enable']));
		update_option('shipme_subscription_email_subject', 	trim($_POST['shipme_subscription_email_subject']));
		update_option('shipme_subscription_email_message', 	trim($_POST['shipme_subscription_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	
	
	if(isset($_POST['shipme_payment_on_completed_job_email_save']))
	{
		update_option('shipme_payment_on_completed_job_enable', 	trim($_POST['shipme_payment_on_completed_job_enable']));
		update_option('shipme_payment_on_completed_job_subject', 	trim($_POST['shipme_payment_on_completed_job_subject']));
		update_option('shipme_payment_on_completed_job_message', 	trim($_POST['shipme_payment_on_completed_job_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_bid_job_owner_email_save']))
	{
		update_option('shipme_bid_job_owner_email_enable', 	trim($_POST['shipme_bid_job_owner_email_enable']));
		update_option('shipme_bid_job_owner_email_subject', 	trim($_POST['shipme_bid_job_owner_email_subject']));
		update_option('shipme_bid_job_owner_email_message', 	trim($_POST['shipme_bid_job_owner_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_priv_mess_received_email_save']))
	{
		update_option('shipme_priv_mess_received_email_enable', 	trim($_POST['shipme_priv_mess_received_email_enable']));
		update_option('shipme_priv_mess_received_email_subject', 	trim($_POST['shipme_priv_mess_received_email_subject']));
		update_option('shipme_priv_mess_received_email_message', 	trim($_POST['shipme_priv_mess_received_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_completed_job_bidder_email_save']))
	{
		update_option('shipme_completed_job_bidder_email_enable', 	trim($_POST['shipme_completed_job_bidder_email_enable']));
		update_option('shipme_completed_job_bidder_email_subject', 	trim($_POST['shipme_completed_job_bidder_email_subject']));
		update_option('shipme_completed_job_bidder_email_message', 	trim($_POST['shipme_completed_job_bidder_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_rated_user_email_save']))
	{
		update_option('shipme_rated_user_email_enable', 	trim($_POST['shipme_rated_user_email_enable']));
		update_option('shipme_rated_user_email_subject', 	trim($_POST['shipme_rated_user_email_subject']));
		update_option('shipme_rated_user_email_message', 	trim($_POST['shipme_rated_user_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_completed_job_owner_email_save']))
	{
		update_option('shipme_completed_job_owner_email_enable', 		trim($_POST['shipme_completed_job_owner_email_enable']));
		update_option('shipme_completed_job_owner_email_subject', 	trim($_POST['shipme_completed_job_owner_email_subject']));
		update_option('shipme_completed_job_owner_email_message', 	trim($_POST['shipme_completed_job_owner_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_delivered_job_owner_email_save']))
	{
		update_option('shipme_delivered_job_owner_email_enable', 		trim($_POST['shipme_delivered_job_owner_email_enable']));
		update_option('shipme_delivered_job_owner_email_subject', 	trim($_POST['shipme_delivered_job_owner_email_subject']));
		update_option('shipme_delivered_job_owner_email_message', 	trim($_POST['shipme_delivered_job_owner_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}

	
	
	if(isset($_POST['shipme_delivered_job_bidder_email_save']))
	{
		update_option('shipme_delivered_job_bidder_email_enable', 	trim($_POST['shipme_delivered_job_bidder_email_enable']));
		update_option('shipme_delivered_job_bidder_email_subject', 	trim($_POST['shipme_delivered_job_bidder_email_subject']));
		update_option('shipme_delivered_job_bidder_email_message', 	trim($_POST['shipme_delivered_job_bidder_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_won_job_owner_email_save']))
	{
		update_option('shipme_won_job_owner_email_enable', 	trim($_POST['shipme_won_job_owner_email_enable']));
		update_option('shipme_won_job_owner_email_subject', 	trim($_POST['shipme_won_job_owner_email_subject']));
		update_option('shipme_won_job_owner_email_message', 	trim($_POST['shipme_won_job_owner_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_won_job_winner_email_save']))
	{
		update_option('shipme_won_job_winner_email_enable', 	trim($_POST['shipme_won_job_winner_email_enable']));
		update_option('shipme_won_job_winner_email_subject', 	trim($_POST['shipme_won_job_winner_email_subject']));
		update_option('shipme_won_job_winner_email_message', 	trim($_POST['shipme_won_job_winner_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_won_job_loser_email_save']))
	{
		update_option('shipme_won_job_loser_email_enable', 	trim($_POST['shipme_won_job_loser_email_enable']));
		update_option('shipme_won_job_loser_email_subject', 	trim($_POST['shipme_won_job_loser_email_subject']));
		update_option('shipme_won_job_loser_email_message', 	trim($_POST['shipme_won_job_loser_email_message']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	
	
	do_action('shipme_save_emails_post');
	
	?>
    
	<div id="usual2" class="usual"> 
        <ul> 
            <li><a href="#tabs1"><?php _e('Email Settings','shipme'); ?></a></li> 
            <li><a href="#new_user_email"><?php _e('New User Email','shipme'); ?></a></li>
            <li><a href="#admin_new_user_email"><?php _e('New User Email (admin)','shipme'); ?></a></li>
            
            <li><a href="#post_job_approved_admin"><?php _e('post job Not Approved Email (admin)','shipme'); ?></a></li>
            <li><a href="#post_job_not_approved_admin"><?php _e('post job Auto Approved Email (admin)','shipme'); ?></a></li>
            <li><a href="#post_job_approved"><?php _e('post job Not Approved Email','shipme'); ?></a></li>
            <li><a href="#post_job_not_approved"><?php _e('post job Auto Approved Email','shipme'); ?></a></li>
            
            <!-- #### -->
            
            <li><a href="#delivered_job_owner"><?php _e('Delivered Job (owner)','shipme'); ?></a></li>
            <li><a href="#delivered_job_bidder"><?php _e('Delivered Job (bidder)','shipme'); ?></a></li>
            
            <!-- #### -->
            
            <li><a href="#completed_job_owner"><?php _e('Completed Job (owner)','shipme'); ?></a></li> 
            <li><a href="#completed_job_bidder"><?php _e('Completed Job (bidder)','shipme'); ?></a></li>
            
            
            <li><a href="#priv_mess_received"><?php _e('Private Message Received','shipme'); ?></a></li>
            <li><a href="#rated_user"><?php _e('Rated User','shipme'); ?></a></li>
    
    
    		<li><a href="#won_job_owner"><?php _e('Won Job(owner)','shipme'); ?></a></li>
    		<li><a href="#won_job_winner"><?php _e('Won Job(winner)','shipme'); ?></a></li>          
    		<li><a href="#won_job_loser"><?php _e('Won Job(losers)','shipme'); ?></a></li> 
            
            <li><a href="#bid_job_bidder"><?php _e('Job Proposal(bidder)','shipme'); ?></a></li>          
    		<li><a href="#bid_job_owner"><?php _e('Job Proposal(owner)','shipme'); ?></a></li> 
            
            <li><a href="#message_board_owner"><?php _e('Message Board(owner)','shipme'); ?></a></li> 
            <li><a href="#message_board_bidder"><?php _e('Message Board(bidder)','shipme'); ?></a></li>    
            
            
            
            <li><a href="#bid_job_subs"><?php _e('Job Subscription Notification','shipme'); ?></a></li>            
            <li><a href="#payment_on_completed_job"><?php _e('Payment on Completed Job (owner)','shipme'); ?></a></li>    
            
                  
    		
            <?php do_action('shipme_save_emails_tabs'); ?>
            
        </ul> 
        
        
        <div id="delivered_job_owner">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the owner of the project after he accepts the project as delivered. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=delivered_job_owner">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_delivered_job_owner_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_delivered_job_owner_email_subject" value="<?php echo stripslashes(get_option('shipme_delivered_job_owner_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_delivered_job_owner_email_message"><?php echo stripslashes(get_option('shipme_delivered_job_owner_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
   					<strong>##username##</strong> - <?php _e('Job Owner\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_delivered_job_owner_email_save" 
                    value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        
        <!--################### -->
        
         <div id="delivered_job_bidder">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the bidder/provider after the owner of the jobs accepts the project as delivered. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=delivered_job_bidder">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_delivered_job_bidder_email_enable'); ?></td>
                    </tr>

                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_delivered_job_bidder_email_subject" value="<?php echo stripslashes(get_option('shipme_delivered_job_bidder_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_delivered_job_bidder_email_message"><?php echo stripslashes(get_option('shipme_delivered_job_bidder_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
   					<strong>##username##</strong> - <?php _e('Bidder\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_delivered_job_bidder_email_save" 
                    value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        
        <!-- ################################ -->
        <div id="completed_job_owner">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the owner of the project when the provider marks the project as completed. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=completed_job_owner">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_completed_job_owner_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_completed_job_owner_email_subject" value="<?php echo stripslashes(get_option('shipme_completed_job_owner_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_completed_job_owner_email_message"><?php echo stripslashes(get_option('shipme_completed_job_owner_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
   					<strong>##username##</strong> - <?php _e('Job Owner\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_completed_job_owner_email_save" 
                    value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        <!-- ################################ -->
        <div id="completed_job_bidder">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the provider/bidder when he marks the project as completed. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=completed_job_bidder">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_completed_job_bidder_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_completed_job_bidder_email_subject" value="<?php echo stripslashes(get_option('shipme_completed_job_bidder_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_completed_job_bidder_email_message"><?php echo stripslashes(get_option('shipme_completed_job_bidder_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
   					<strong>##username##</strong> - <?php _e('Bidder\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_completed_job_bidder_email_save" 
                    value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        <!-- ################################ -->
         <div id="priv_mess_received">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by any user when another user sends a private message. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=priv_mess_received">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_priv_mess_received_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_priv_mess_received_email_subject" value="<?php echo stripslashes(get_option('shipme_priv_mess_received_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_priv_mess_received_email_message"><?php echo stripslashes(get_option('shipme_priv_mess_received_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
   
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    <strong>##sender_username##</strong> - <?php _e('sender username','shipme'); ?><br/>
                    <strong>##receiver_username##</strong> - <?php _e('receiver username','shipme'); ?><br/>
                    

                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_priv_mess_received_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        <!-- ################################ -->
        <div id="rated_user">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the freshly rated user. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=rated_user">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_rated_user_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_rated_user_email_subject" value="<?php echo stripslashes(get_option('shipme_rated_user_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_rated_user_email_message"><?php echo stripslashes(get_option('shipme_rated_user_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('Winner Bidder\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    <strong>##rating##</strong> - <?php _e('rating value','shipme'); ?><br/>
                    <strong>##comment##</strong> - <?php _e('rating comment','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_rated_user_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        <!-- ################################ -->
         <div id="won_job_owner">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the project owner after he awards the project to a certain bidder. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=won_job_owner">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_won_job_owner_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_won_job_owner_email_subject" value="<?php echo stripslashes(get_option('shipme_won_job_owner_email_subject')); ?>"/></td>
                    </tr>

                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_won_job_owner_email_message"><?php echo stripslashes(get_option('shipme_won_job_owner_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('Winner Bidder\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    <strong>##winner_bid_value##</strong> - <?php _e('winner bid value','shipme'); ?><br/>
                    <strong>##winner_bid_username##</strong> - <?php _e('winner bidder username','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_won_job_owner_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        <!-- ################################ -->
        <div id="won_job_winner">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the winner bidder when the project is won. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=won_job_winner">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_won_job_winner_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_won_job_winner_email_subject" value="<?php echo stripslashes(get_option('shipme_won_job_winner_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_won_job_winner_email_message"><?php echo stripslashes(get_option('shipme_won_job_winner_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('Winner Bidder\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    <strong>##winner_bid_value##</strong> - <?php _e('winner bid value','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_won_job_winner_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        <!-- ################################ -->
        
        <div id="won_job_loser">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the loser bidders when the project is won. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=won_job_loser">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_won_job_loser_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_won_job_loser_email_subject" value="<?php echo stripslashes(get_option('shipme_won_job_loser_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_won_job_loser_email_message"><?php echo stripslashes(get_option('shipme_won_job_loser_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('Loser Bidder\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    <strong>##user_bid_value##</strong> - <?php _e('the bid value','shipme'); ?><br/>
                    
                    <strong>##winner_bid_username##</strong> - <?php _e('winner bid username','shipme'); ?><br/>
                    <strong>##winner_bid_value##</strong> - <?php _e('winner bid value','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_won_job_loser_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        <!-- ################################ -->
        
        
        <div id="message_board_bidder">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the message owner when the project owner posts a new message on the private messaging board. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=message_board_bidder">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_message_board_bidder_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_message_board_bidder_email_subject" value="<?php echo stripslashes(get_option('shipme_message_board_bidder_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_message_board_bidder_email_message"><?php echo stripslashes(get_option('shipme_message_board_bidder_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('Receiver Username','shipme'); ?><br/>
                    <strong>##project_username##</strong> - <?php _e('Job Owner Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>


                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_message_board_bidder_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
          
          
          <div id="message_board_owner">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the owner of a project when someone is posting a new message on the private messaging board. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=message_board_owner">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_message_board_owner_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_message_board_owner_email_subject" value="<?php echo stripslashes(get_option('shipme_message_board_owner_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_message_board_owner_email_message"><?php echo stripslashes(get_option('shipme_message_board_owner_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('Job Owner Username','shipme'); ?><br/>
                    <strong>##message_owner_username##</strong> - <?php _e('Message Owner Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>

                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_message_board_owner_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
          
          
          
          
           <div id="bid_job_bidder">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the bidder when he posts a bid for a project. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=bid_job_bidder">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_bid_job_bidder_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_bid_job_bidder_email_subject" value="<?php echo stripslashes(get_option('shipme_bid_job_bidder_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_bid_job_bidder_email_message"><?php echo stripslashes(get_option('shipme_bid_job_bidder_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('Job Bidder\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    <strong>##bid_value##</strong> - <?php _e('the bid value','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_bid_job_bidder_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        <!-- ################################ -->
        
        
        
        
        <div id="bid_job_subs">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by all users subscribed for a certain category when a project gets posted. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=bid_job_subs">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_subscription_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_subscription_email_subject" value="<?php echo stripslashes(get_option('shipme_subscription_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_subscription_email_message"><?php echo stripslashes(get_option('shipme_subscription_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('Receiver Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>

                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_subscription_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        
          <div id="payment_on_completed_job">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the project owner when he pays the service provider. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=payment_on_completed_job">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_payment_on_completed_job_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_payment_on_completed_job_subject" value="<?php echo stripslashes(get_option('shipme_payment_on_completed_job_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_payment_on_completed_job_message"><?php echo stripslashes(get_option('shipme_payment_on_completed_job_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('Job Owner\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>

                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    <strong>##bidder_username##</strong> - <?php _e('the bidder username','shipme'); ?><br/>
                    <strong>##bid_value##</strong> - <?php _e('the bid value','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_payment_on_completed_job_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
          
          <div id="bid_job_owner">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the project owner whenever a user bids for his project. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=bid_job_owner">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_bid_job_owner_email_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_bid_job_owner_email_subject" value="<?php echo stripslashes(get_option('shipme_bid_job_owner_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_bid_job_owner_email_message"><?php echo stripslashes(get_option('shipme_bid_job_owner_email_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('Job Owner\'s Username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>

                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    <strong>##bidder_username##</strong> - <?php _e('the bidder username','shipme'); ?><br/>
                    <strong>##bid_value##</strong> - <?php _e('the bid value','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_bid_job_owner_email_save" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        <!-- ################################ -->
        
        
        
        <div id="post_job_not_approved">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by your users after posting a new job on your website if the project is automatically approved. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=post_job_not_approved">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_new_job_email_approved_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_new_job_email_approved_subject" value="<?php echo stripslashes(get_option('shipme_new_job_email_approved_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_new_job_email_approved_message"><?php echo stripslashes(get_option('shipme_new_job_email_approved_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save33" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        <!-- ################################## -->
        
        <div id="post_job_approved">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by your users after posting a new job on your website if the project is not automatically approved. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=post_job_approved">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_new_job_email_not_approved_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_new_job_email_not_approved_subject" value="<?php echo stripslashes(get_option('shipme_new_job_email_not_approved_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_new_job_email_not_approved_message"><?php echo stripslashes(get_option('shipme_new_job_email_not_approved_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('project owner username','shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save32" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        <!-- ############################### -->
        
        
        <div id="post_job_not_approved_admin">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the admin when someone posts a project on the website to be approved.
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=post_job_not_approved_admin">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_new_job_email_approve_admin_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_new_job_email_approve_admin_subject" value="<?php echo stripslashes(get_option('shipme_new_job_email_approve_admin_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_new_job_email_approve_admin_message"><?php echo stripslashes(get_option('shipme_new_job_email_approve_admin_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save31" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        
    <!-- ######################### -->    
        
        
         <div id="post_job_approved_admin">	
          
           <div class="spntxt_bo"><?php _e('This email will be received by the admin when someone posts a project on the website website. This email will be received if the the project is not automatically approved.
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=post_job_approved_admin">
            <table width="100%" class="sitemile-table">
    				
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Enable this email:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_new_job_email_not_approve_admin_enable'); ?></td>
                    </tr>
                    
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_new_job_email_not_approve_admin_subject" value="<?php echo stripslashes(get_option('shipme_new_job_email_not_approve_admin_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_new_job_email_not_approve_admin_message"><?php echo stripslashes(get_option('shipme_new_job_email_not_approve_admin_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?><br/>
                    <strong>##my_account_url##</strong> - <?php _e("your website's my account link",'shipme'); ?><br/>
                    <strong>##job_name##</strong> - <?php _e("new new job's title",'shipme'); ?><br/>
                    <strong>##job_link##</strong> - <?php _e('link for the new job','shipme'); ?><br/>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save3" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          	
          </div>
        
        
        <!--################################ -->
        
        <div id="tabs1" style="display: block; ">
        	<form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=tabs1">
            <table width="100%" class="sitemile-table">
    				
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160">Email From Name:</td>
                    <td><input type="text" size="45" name="shipme_email_name_from" value="<?php echo stripslashes(get_option('shipme_email_name_from')); ?>"/></td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td >Email From Address:</td>
                    <td><input type="text" size="45" name="shipme_email_addr_from" value="<?php echo stripslashes(get_option('shipme_email_addr_from')); ?>"/></td>
                    </tr>
                    
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td >Allow HTML in emails:</td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_allow_html_emails'); ?></td>
                    </tr>
                    
        
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save1" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
        </div> 
          
        <!-- ################################ -->  
                
        <div id="new_user_email" style="display: none; ">
        	<div class="spntxt_bo"><?php _e('This email will be received by all new users who register on your website. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=tabs2">
            <table width="100%" class="sitemile-table">
    		
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_new_user_email_subject" value="<?php echo stripslashes(get_option('shipme_new_user_email_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_new_user_email_message"><?php echo stripslashes(get_option('shipme_new_user_email_message')); ?></textarea></td>
                    </tr>
                    

                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e("your new username",'shipme'); ?><br/>
                    <strong>##username_email##</strong> - <?php _e("your new user's email",'shipme'); ?><br/>
                    <strong>##user_password##</strong> - <?php _e("your new user's password",'shipme'); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save2" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
          
        </div> 
        
        <!-- ################################ -->  
                
        <div id="admin_new_user_email" style="display: none; "> 
        	 <div class="spntxt_bo"><?php _e('This email will be received by the admin when a new user registers on the website. 
          Be aware, if you add html tags to this email you must have the allow HTML tags option set to yes.
          Also at the bottom you can see a list of tags you can use in the email body.','shipme'); ?> </div>
          
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=email-settings&active_tab=tabs_new_user_email_admin">
            <table width="100%" class="sitemile-table">
    		
            	  	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Email Subject:','shipme'); ?></td>
                    <td><input type="text" size="90" name="shipme_new_user_email_admin_subject" value="<?php echo stripslashes(get_option('shipme_new_user_email_admin_subject')); ?>"/></td>
                    </tr>
                    

                    
                    <tr>
                    <td valign=top><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Email Content:','shipme'); ?></td>
                    <td><textarea cols="92" rows="10" name="shipme_new_user_email_admin_message"><?php echo stripslashes(get_option('shipme_new_user_email_admin_message')); ?></textarea></td>
                    </tr>
                    
                    
                    
                    <tr>
                    <td valign=top></td>
                    <td valign=top ></td>
                    <td><div class="spntxt_bo2">
                    <?php _e('Here is a list of tags you can use in this email:','shipme'); ?><br/><br/>
                    
                    <strong>##username##</strong> - <?php _e('your new username',"shipme"); ?><br/>
                    <strong>##username_email##</strong> - <?php _e("your new user's email","shipme"); ?><br/>
                    <strong>##site_login_url##</strong> - <?php _e('the link to your user login page','shipme'); ?><br/>
                    <strong>##your_site_name##</strong> - <?php _e("your website's name","shipme"); ?><br/>
                    <strong>##your_site_url##</strong> - <?php _e("your website's main address",'shipme'); ?>
                    
                    </div></td>
                    </tr>
            		
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save_new_user_email_admin" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            </form>
        </div> 
    
    
    	<?php do_action('shipme_save_emails_contents'); ?>
    
    </div> 
    
    
    <?php	
	
	echo '</div>';
}

function shipme_layout_settings()
{

	$id_icon 		= 'icon-options-general-layout';
	$ttl_of_stuff 	= 'ShipMe - '.__('Layout Settings','shipme');
	global $menu_admin_shipme_theme_bull;
	
	//------------------------------------------------------
	
	$arr = array("yes" => __("Yes",'shipme'), "no" => __("No",'shipme'));
	
	echo '<div class="wrap">';
	echo '<div class="icon32" id="'.$id_icon.'"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">'.$ttl_of_stuff.'</h2>';	

		if(isset($_POST['shipme_save4']))
		{
			update_option('shipme_color_for_top_links', 			trim($_POST['shipme_color_for_top_links']));
			update_option('shipme_color_for_bk', 					trim($_POST['shipme_color_for_bk']));
			update_option('shipme_color_for_footer', 				trim($_POST['shipme_color_for_footer']));
			
			echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';
		}
		
		if(isset($_POST['shipme_save1']))
		{
			update_option('shipme_text_caption_1', 				trim($_POST['shipme_text_caption_1']));
			update_option('shipme_text_caption_2', 				trim($_POST['shipme_text_caption_2']));
			update_option('shipme_text_caption_3', 				trim($_POST['shipme_text_caption_3']));
			update_option('shipme_button_link', 				trim($_POST['shipme_button_link']));	
			
			
			update_option('shipme_text_caption_1_color', 				trim($_POST['shipme_text_caption_1_color']));	
			update_option('shipme_text_caption_2_color', 				trim($_POST['shipme_text_caption_2_color']));	
				
			update_option('shipme_button_color', 				trim($_POST['shipme_button_color']));
			update_option('shipme_front_slider_enable', 				trim($_POST['shipme_front_slider_enable']));
			
			
			update_option('shipme_front_pic1', 				trim($_POST['shipme_front_pic1']));
			update_option('shipme_front_pic2', 				trim($_POST['shipme_front_pic2']));
			update_option('shipme_front_pic3', 				trim($_POST['shipme_front_pic3']));
			update_option('shipme_front_pic4', 				trim($_POST['shipme_front_pic4']));	
			 
			
			echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';
		}
		
		if(isset($_POST['shipme_save2']))
		{
			update_option('shipme_logo_URL2', 				trim($_POST['shipme_logo_URL2']));
			update_option('shipme_logo_URL', 				trim($_POST['shipme_logo_URL']));
			
			echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';
		}
		
		if(isset($_POST['shipme_save3']))
		{
			update_option('shipme_left_side_footer', 				stripslashes(trim($_POST['shipme_left_side_footer'])));
			update_option('shipme_right_side_footer', 			stripslashes(trim($_POST['shipme_right_side_footer'])));
			
			echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';
		}
		
		
		//-----------------------------------------

	$shipme_home_page_layout = get_option('shipme_home_page_layout');
	if(empty($shipme_home_page_layout)) $shipme_home_page_layout = "1";
	
?>

	    <div id="usual2" class="usual"> 
          <ul> 
            <li><a href="#tabs1"><?php _e('HomePage','shipme'); ?></a></li> 
            <li><a href="#tabs2"><?php _e('Header','shipme'); ?></a></li> 
            <li><a href="#tabs3"><?php _e('Footer','shipme'); ?></a></li>
            <li><a href="#tabs4"><?php _e('Change Colors','shipme'); ?></a></li> 
          </ul>
           
          <div id="tabs4">
           <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=layout-settings&active_tab=tabs4">
            <table width="100%" class="sitemile-table">
            
        <script>
		
	 
    jQuery( document ).ready(function() {
        jQuery('#colorpickerField1').wpColorPicker();
		jQuery('#colorpickerField2').wpColorPicker();
		jQuery('#colorpickerField3').wpColorPicker();
    });
     
 
		
		</script>        
        <tr>
        <td width="200" valign="top"><?php _e('Color for background:','shipme'); ?></td>
        <td><input type="text" id="colorpickerField1" name="shipme_color_for_bk"  value="<?php echo get_option('shipme_color_for_bk'); ?>"/>
				 

		</td>
        </tr>
        
        
        
        <tr>
        <td width="200" valign="top"><?php _e('Color for footer:','shipme'); ?></td>
        <td><input type="text" id="colorpickerField2" name="shipme_color_for_footer" value="<?php echo get_option('shipme_color_for_footer'); ?>" />
		</td>
        </tr>
        
        
        <tr>
        <td width="200" valign="top"><?php _e('Color for top links:','shipme'); ?></td>
        <td><input type="text" id="colorpickerField3" name="shipme_color_for_top_links" value="<?php echo get_option('shipme_color_for_top_links'); ?>" />
		</td>
        </tr>
            
            
             <tr>
                  
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save4" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>    
                
            
            </table>
            
            </form>
          
          
          </div>
           
          <div id="tabs1">
          <div class="spag">
       By default the homepage is linked to index.php file of the theme. This page consists of content area (latest posted jobs) and a sidebar (homepage sidebar) where you drag and drop widgets.<br/>
       But we also have an option to control freely the homepage through a page builder. Go and edit from Pages section the homepage. Make sure your <a href="https://wordpress.org/plugins/siteorigin-panels/">origin pagebuilder plugin</a> is installed.
          	</div>
            
            
            <h3>HomePage Picture Slider</h3>
            
            
                 <script>
		
	 
    jQuery( document ).ready(function() { 
		jQuery('#shipme_text_caption_1_color').wpColorPicker();
		jQuery('#shipme_button_color').wpColorPicker();
		jQuery('#shipme_text_caption_2_color').wpColorPicker();
    });
     
 
		
		</script> 
            
             <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=layout-settings&active_tab=tabs1">
            <table width="100%" class="sitemile-table">
                <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="200"><?php _e('Enable:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_front_slider_enable'); ?></td>
                    </tr>
                    
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Big Text Caption:','shipme'); ?></td>
                    <td><input type="text" size="56" name="shipme_text_caption_1" value="<?php echo get_option('shipme_text_caption_1'); ?>"/> </td>
                    </tr>
                    
                      <tr>
                      <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
        <td width="200" valign="top"><?php _e('Color for big text:','shipme'); ?></td>
        <td><input type="text" id="shipme_text_caption_1_color" name="shipme_text_caption_1_color" value="<?php echo get_option('shipme_text_caption_1_color'); ?>" />	</td>
        </tr>
                    
                    
                     <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Small Text Caption:','shipme'); ?></td>
                    <td><input type="text" size="56" name="shipme_text_caption_2" value="<?php echo get_option('shipme_text_caption_2'); ?>"/> </td>
                    </tr>
                    
                    
                                   <tr> 
                                   <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
        <td width="200" valign="top"><?php _e('Color for small text:','shipme'); ?></td>
        <td><input type="text" id="shipme_text_caption_2_color" name="shipme_text_caption_2_color" value="<?php echo get_option('shipme_text_caption_2_color'); ?>" />
		</td>
        </tr>
                    
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Button Text Caption:','shipme'); ?></td>
                    <td><input type="text" size="26" name="shipme_text_caption_3" value="<?php echo get_option('shipme_text_caption_3'); ?>"/> </td>
                    </tr>
                    
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Button Link:','shipme'); ?></td>
                    <td><input type="text" size="26" name="shipme_button_link" value="<?php echo get_option('shipme_button_link'); ?>"/> </td>
                    </tr>
                    
                    
                                   <tr> 
                                   <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
        <td width="200" valign="top"><?php _e('Color for button:','shipme'); ?></td>
        <td><input type="text" id="shipme_button_color" name="shipme_button_color" value="<?php echo get_option('shipme_button_color'); ?>" />
		</td>
        </tr>
                    
                    
                    
                     <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save1" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>
            
            </form>
            
          </div>
          
          <div id="tabs2">	
          
           <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=layout-settings&active_tab=tabs2">
            <table width="100%" class="sitemile-table">
    			 <script>
			
			jQuery(function(jQuery) {
				jQuery(document).ready(function(){
						jQuery('#sel_logo').click(open_media_window);
					});
					
					
					jQuery(document).ready(function(){
						jQuery('#sel_logo2').click(open_media_window2);
					});
			 
				function open_media_window() { 
					
					
					jQuery("#handle_me").val("1");
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true' );
					return false;
				}
				
				
					function open_media_window2() { 
					
					
					jQuery("#handle_me").val("2");
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true&amp;logo=2' );
					return false;
				}
				
				window.send_to_editor = function(html) {
				
				 imgurl = jQuery('img',html).attr('src'); 
				 
				var handle_me = jQuery("#handle_me").val();
				if(handle_me == "2") 
				 jQuery('#shipme_logo_URL2').val(imgurl) ;
				 else
				 jQuery('#shipme_logo_URL').val(imgurl) ;
				  
				 tb_remove();
			 
				}
				
				
			});
			
			
			</script>	
            <input id="handle_me" type="hidden" value="2" />	
                  
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(__('Eg: http://your-site-url.com/images/logo.jpg','shipme')); ?></td>
                    <td ><?php _e('Logo URL (homepage):','shipme'); ?></td>
                    <td> 
                    
                    <input type="text" size="45" name="shipme_logo_URL" id="shipme_logo_URL" value="<?php echo get_option('shipme_logo_URL'); ?>"/> 
                    <a href="#" id="sel_logo" class="button"><?php _e('Upload/Select Logo File','shipme') ?></a>
                    
                    </td>
                    </tr>
                    
                    
                    
                    
                    
                    
                       <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(__('Eg: http://your-site-url.com/images/logo.jpg','shipme')); ?></td>
                    <td ><?php _e('Logo URL (inner pages):','shipme'); ?></td>
                    <td> 
                    
                    <input type="text" size="45" name="shipme_logo_URL2" id="shipme_logo_URL2" value="<?php echo get_option('shipme_logo_URL2'); ?>"/> 
                    <a href="#" id="sel_logo2" class="button"><?php _e('Upload/Select Logo File','shipme') ?></a>
                    
                    </td>
                    </tr>
           
           
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save2" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
          
          </div>
          
          <div id="tabs3">	
             <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=layout-settings&active_tab=tabs3">
            <table width="100%" class="sitemile-table">
    				
                 
          <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(__('This will appear in the left side of the footer area.','shipme')); ?></td>
                    <td valign="top" ><?php _e('Left side footer area content:','shipme'); ?></td>
                    <td><textarea cols="65" rows="4" name="shipme_left_side_footer"><?php echo stripslashes(get_option('shipme_left_side_footer')); ?></textarea></td>
                    </tr>
                    
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(__('This will appear in the right side of the footer area.','shipme')); ?></td>
                    <td valign="top" ><?php _e('Right side footer area content:','shipme'); ?></td>
                    <td><textarea cols="65" rows="4" name="shipme_right_side_footer"><?php echo stripslashes(get_option('shipme_right_side_footer')); ?></textarea></td>
                    </tr>
          
          
             <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save3" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
          
          </div>
    

<?php
	echo '</div>';		
}

function shipme_pricing_options()
{
	$id_icon 		= 'icon-options-general4';
	$ttl_of_stuff 	= 'ShipMe - '.__('Pricing Settings','shipme');
	$arr = array("yes" => __("Yes",'shipme'), "no" => __("No",'shipme'));
	$sep = array( "," => __('Comma (,)','shipme'), "." => __("Point (.)",'shipme'));
	$frn = array( "front" => __('In front of sum (eg: $50)','shipme'), "back" => __("After the sum (eg: 50$)",'shipme'));
	global $menu_admin_shipme_theme_bull, $wpdb;
	
		$arr_currency = array("USD" => "US Dollars", "EUR" => "Euros", "CAD" => "Canadian Dollars", "CHF" => "Swiss Francs","GBP" => "British Pounds",
						  "AUD" => "Australian Dollars","NZD" => "New Zealand Dollars","BRL" => "Brazilian Real", 'PLN' => 'Polish zloty',
						  "SGD" => "Singapore Dollars","SEK" => "Swidish Kroner","NOK" => "Norwegian Kroner","DKK" => "Danish Kroner",
						  "MXN" => "Mexican Pesos","JPY" => "Japanese Yen","EUR" => "Euros", "ZAR" => "South Africa Rand", 'RUB' => 'Russian Ruble' , "TRY" => "Turkish Lyra",  "RON" => "Romanian Lei",
						  "HUF" => "Hungarian Forint", 'PHP' => 'Philippine peso' ,  'INR' => 'Indian Rupee', 'LTL' => 'Lithuania Litas' , 'MYR' => 'Malaysian ringgit', 'HKD' => 'HongKong Dollars',
						  'SEK' => 'Swedish Krona', 'Israeli New Shekel' => 'ILS', 'COP' => 'Colombian Peso', 'THB' => 'Thai Baht'
						  );
	
	//------------------------------------------------------
	
	echo '<div class="wrap">';
	echo '<div class="icon32" id="'.$id_icon.'"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">'.$ttl_of_stuff.'</h2>';	


	if(isset($_POST['shipme_save1']))
	{
		$shipme_currency 						= trim($_POST['shipme_currency']);
		$shipme_currency_symbol 				= trim($_POST['shipme_currency_symbol']);
		$shipme_currency_position 			= trim($_POST['shipme_currency_position']);
		$shipme_decimal_sum_separator 		= trim($_POST['shipme_decimal_sum_separator']);
		$shipme_thousands_sum_separator 		= trim($_POST['shipme_thousands_sum_separator']);

		update_option('shipme_currency', 					$shipme_currency);
		update_option('shipme_currency_symbol', 			$shipme_currency_symbol);
		update_option('shipme_currency_position', 		$shipme_currency_position);
		update_option('shipme_decimal_sum_separator', 	$shipme_decimal_sum_separator);
		update_option('shipme_thousands_sum_separator', 	$shipme_thousands_sum_separator);

	
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';	
	}


	if(isset($_POST['shipme_save2']))
	{
		$shipme_base_fee 						= trim($_POST['shipme_base_fee']);
		$shipme_featured_fee 					= trim($_POST['shipme_featured_fee']);
		$shipme_sealed_bidding_fee 			= trim($_POST['shipme_sealed_bidding_fee']); 
		$shipme_fee_after_paid 				= trim($_POST['shipme_fee_after_paid']);
		$shipme_min_withdraw					= trim($_POST['shipme_min_withdraw']);
		
		update_option('shipme_base_fee', 					$shipme_base_fee);
		update_option('shipme_featured_fee', 				$shipme_featured_fee);
		update_option('shipme_sealed_bidding_fee', 		$shipme_sealed_bidding_fee);
 
		update_option('shipme_fee_after_paid', 			$shipme_fee_after_paid);
		
		update_option('shipme_min_withdraw', 			$shipme_min_withdraw);

	
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';	
	}


	?>
    
        <div id="usual2" class="usual"> 
  <ul> 
    <li><a href="#tabs1"><?php _e('Main Details','shipme'); ?></a></li>  
    <li><a href="#tabs2"><?php _e('Job Fees','shipme'); ?></a></li> 
  </ul> 
  <div id="tabs1" style="display: block; ">
    	
        <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=pricing-settings&active_tab=tabs1">
            <table width="100%" class="sitemile-table">
    				
                     <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Site currency:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr_currency, 'shipme_currency'); ?></td>
                    </tr>
                    
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="160"><?php _e('Currency symbol:','shipme'); ?></td>
                    <td><input type="text" size="6" name="shipme_currency_symbol" value="<?php echo get_option('shipme_currency_symbol'); ?>"/> </td>
                    </tr>
                    
                     <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Currency symbol position:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($frn, 'shipme_currency_position'); ?></td>
                    </tr>
                    
                    
                     <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Decimals sum separator:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($sep, 'shipme_decimal_sum_separator'); ?></td>
                    </tr>
                    
                     <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Thousands sum separator:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($sep, 'shipme_thousands_sum_separator'); ?></td>
                    </tr>
      
                   
                    
        
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save1" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
          
  </div> 
  
 
  
  <div id="tabs2" style="display: none; ">
  
  	<form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=pricing-settings&active_tab=tabs2">
            <table width="100%" class="sitemile-table">
    				
                
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="240" ><?php _e('Base Listing Fee:','shipme'); ?></td>
                    <td><input type="text" name="shipme_base_fee" size="10" value="<?php echo  get_option('shipme_base_fee'); ?>"  /> <?php echo shipme_currency(); ?></td>
                    </tr>
                    
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Featured Job Fee:','shipme'); ?></td>
                    <td><input type="text" name="shipme_featured_fee" size="10" value="<?php echo  get_option('shipme_featured_fee'); ?>"  /> <?php echo shipme_currency(); ?></td>
                    </tr>
                    
                    
         			<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Sealed Proposals Fee:','shipme'); ?></td>
                    <td><input type="text" name="shipme_sealed_bidding_fee" size="10" value="<?php echo  get_option('shipme_sealed_bidding_fee'); ?>"  /> <?php echo shipme_currency(); ?></td>
                    </tr>
                    
                    
             
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Fee Taken out of Each Job: ','shipme'); ?></td>
                    <td><input type="text" name="shipme_fee_after_paid" size="5" value="<?php echo  get_option('shipme_fee_after_paid'); ?>"  /> %</td>
                    </tr>
                    
                   
                    
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="240" ><?php _e('Minimum Withdraw:','shipme'); ?></td>
                    <td><input type="text" name="shipme_min_withdraw" size="10" value="<?php echo  get_option('shipme_min_withdraw'); ?>"  /> <?php echo shipme_currency(); ?></td>
                    </tr>
                    
        
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save2" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
  
  
  </div> 
        </div> 
    
    
    <?php	
	
	echo '</div>';
}


function shipme_payment_methods()
{
		$id_icon 		= 'icon-options-general4';
	$ttl_of_stuff 	= 'ShipMe - Payment Methods';
	global $menu_admin_shipme_theme_bull;
	$arr = array("yes" => __("Yes",'shipme'), "no" => __("No",'shipme'));
	
	//------------------------------------------------------
	
	echo '<div class="wrap">';
	echo '<div class="icon32" id="'.$id_icon.'"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">'.$ttl_of_stuff.'</h2>';	
	
	//--------------------------
	
	do_action('shipme_payment_methods_action');
	if(isset($_POST['shipme_save1']))
	{
		update_option('shipme_paypal_enable', 		trim($_POST['shipme_paypal_enable']));
		update_option('shipme_paypal_email', 			trim($_POST['shipme_paypal_email']));
		update_option('shipme_paypal_enable_sdbx', 	trim($_POST['shipme_paypal_enable_sdbx']));
		
		update_option('shipme_enable_paypal_ad', 		trim($_POST['shipme_enable_paypal_ad']));
		update_option('project_theme_signature', 			trim($_POST['project_theme_signature']));
		update_option('project_theme_apipass', 				trim($_POST['project_theme_apipass']));
		update_option('project_theme_apiuser', 				trim($_POST['project_theme_apiuser']));
		update_option('project_theme_appid', 				trim($_POST['project_theme_appid']));

		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_save2']))
	{
		update_option('shipme_alertpay_enable', trim($_POST['shipme_alertpay_enable']));
		update_option('shipme_alertpay_email', trim($_POST['shipme_alertpay_email']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_save3']))
	{
		update_option('shipme_moneybookers_enable', trim($_POST['shipme_moneybookers_enable']));
		update_option('shipme_moneybookers_email', trim($_POST['shipme_moneybookers_email']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	if(isset($_POST['shipme_save4']))
	{
		update_option('shipme_ideal_enable', trim($_POST['shipme_ideal_enable']));
		update_option('shipme_ideal_email', trim($_POST['shipme_ideal_email']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	
	if(isset($_POST['shipme_save_bnk']))
	{
		update_option('shipme_bank_details_enable', 	trim($_POST['shipme_bank_details_enable']));
		update_option('shipme_bank_details_txt', 		trim($_POST['shipme_bank_details_txt']));
		
		echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';		
	}
	
	
	
	?>


	    <div id="usual2" class="usual"> 
          <ul> 
            <li><a href="#tabs1">PayPal</a></li> 
            <li><a href="#tabs2">Payza/AlertPay</a></li> 
            <li><a href="#tabs3">Moneybookers/Skrill</a></li> 
            <!--<li><a href="#tabs4">iDeal</a></li> 
            <li><a href="#tabs5">PayFast</a></li>
            <li><a href="#tabs6">MonsterPay</a></li>
            <li><a href="#tabs7">SagePay</a></li>
            <li><a href="#tabs8">Google Checkout</a></li>
            <li><a href="#tabs9">Authorize.NET</a></li>
            <li><a href="#tabs_amazon">Amazon</a></li>
            <li><a href="#tabs_chronopay">Chronopay</a></li> -->
            <li><a href="#tabs_offline"><?php _e('Bank Payment(offline)','shipme'); ?></a></li>
            <?php do_action('shipme_payment_methods_tabs'); ?>
             
          </ul> 
          <div id="tabs1"  >	
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=payment-methods&active_tab=tabs1">
            <table width="100%" class="sitemile-table">
    				
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="200"><?php _e('Enable:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_paypal_enable'); ?></td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="200"><?php _e('PayPal Enable Sandbox:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_paypal_enable_sdbx'); ?> (This is for testing: <a target="_blank" href="http://developer.paypal.com/">INFO HERE</a>)</td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('PayPal Email Address:','shipme'); ?></td>
                    <td><input type="text" size="45" name="shipme_paypal_email" value="<?php echo get_option('shipme_paypal_email'); ?>"/></td>
                    </tr>
                    
                    
                     <tr><td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td><?php _e('Enable PayPal Adaptive:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_paypal_ad'); ?> (<a target="_blank" href="https://developer.paypal.com/docs/classic/adaptive-payments/integration-guide/APIntro/">Info Here</a>)</td>
                    </tr>
            
            
                     <tr><td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Signature:','shipme'); ?></td>
                    <td><input type="text" name="project_theme_signature" value="<?php echo get_option('project_theme_signature'); ?>" size="85" /> </td>
                    </tr>
                    
                           <tr><td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('API Password:','shipme'); ?></td>
                    <td><input type="text" name="project_theme_apipass" value="<?php echo get_option('project_theme_apipass'); ?>" size="55" /> </td>
                    </tr>
                    
                           <tr><td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('API User:','shipme'); ?></td>
                    <td><input type="text" name="project_theme_apiuser" value="<?php echo get_option('project_theme_apiuser'); ?>" size="55" /> </td>
                    </tr>
                    
                           <tr><td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Application ID:','shipme'); ?></td>
                    <td><input type="text" name="project_theme_appid" value="<?php echo get_option('project_theme_appid'); ?>" size="45" /> eg: APP-80W217485P519543 </td>
                    </tr>
                    
                    
                    <tr>
                    <td ></td>
                    <td >Resources:</td>
                    <td> 
                    
                   
                     - <a target="_blank"  href="https://developer.paypal.com/docs/classic/lifecycle/goingLive/">Going Live with PayPal APP</a> <br/>
                   - <a target="_blank"  href="https://developer.paypal.com/docs/classic/api/gs_PayPalAPIs/#credentials">How to get Sandbox Credentials</a> <br/>
                    - <a target="_blank"  href="https://developer.paypal.com/docs/classic/api/gs_PayPalAPIs/#credentials">How to get LIVE Credentials</a> 
                    
                    </td>
                    </tr>
                    
                    <tr>
                    <td ></td>
                    <td >Important Notice:</td>
                    <td> 
                    
                   
               Our theme makes use of the delayed chained payments. The payments are in the Implicit Approval Mode. This only applies when you set adaptive payments to <strong>YES</strong>.
                    
                    </td>
                    </tr>
                  
        
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save1" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
          
          </div>
          
          <div id="tabs2" >	
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=payment-methods&active_tab=tabs2">
            <table width="100%" class="sitemile-table">
    				
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="200"><?php _e('Enable:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_alertpay_enable'); ?></td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Payza/Alertpay Email:','shipme'); ?></td>
                    <td><input type="text" size="45" name="shipme_alertpay_email" value="<?php echo get_option('shipme_alertpay_email'); ?>"/></td>
                    </tr>
                    
  
        
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save2" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
          
          </div>
          
          <div id="tabs3">
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=payment-methods&active_tab=tabs3">
            <table width="100%" class="sitemile-table">
    				
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="200"><?php _e('Enable:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_moneybookers_enable'); ?></td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td ><?php _e('Skrill Email:','shipme'); ?></td>
                    <td><input type="text" size="45" name="shipme_moneybookers_email" value="<?php echo get_option('shipme_moneybookers_email'); ?>"/></td>
                    </tr>
                    
  
        
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save3" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
          		
          </div> 
          
         
          
          
          
           <div id="tabs_offline" >	
           
           <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=payment-methods&active_tab=tabs_offline">
            <table width="100%" class="sitemile-table">
    				
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="200"><?php _e('Enable:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_bank_details_enable'); ?></td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td valign=top ><?php _e('Your Bank Details:','shipme'); ?></td>
                    <td><textarea cols="45" rows="5" name="shipme_bank_details_txt"><?php echo get_option('shipme_bank_details_txt'); ?></textarea></td>
                    </tr>


                    
  
        
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save_bnk" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
           
            	
          </div>  
          
          <?php do_action('shipme_payment_methods_content_divs'); ?>

<?php
	echo '</div>';	
  
	
}



function shipme_custom_fields_scr()
{
	global $menu_admin_job_theme_bull, $wpdb;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general-custfields"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">shipme Custom Fields</h2>';
	?>
    
    <script src="<?php echo get_bloginfo('template_url'); ?>/js/jquery.form.js"></script>


	<?php
	
	if(isset($_POST['add_new_field']))
	{
		$field_name 			= trim($_POST['field_name']);
		$field_type 			= $_POST['field_type'];
		$field_order 			= trim($_POST['field_order']);
		$field_category			= $_POST['field_category'];
		$is_mandatory 			= $_POST['is_mandatory'];
		
		//----------------------------
		
		if(empty($field_name)) echo '<div class="delete_thing">Field name cannot be empty!</div>';
		else
		{
			$step_me = '';
			$step_me = apply_filters('shipme_step_me_filter', $step_me);
			
			
			$ss = "insert into ".$wpdb->prefix."ship_custom_fields (is_mandatory, name,tp,ordr,cate, step_me) 
														values('$is_mandatory','$field_name','$field_type','$field_order','$field_category', '$step_me')";
			$wpdb->query($ss);
			
			//----------------------------
			
			$ss = "select id from ".$wpdb->prefix."ship_custom_fields where name='$field_name' AND tp='$field_type'";
			$rows = $wpdb->get_results($ss);
			
			foreach($rows as $row)
			{
			
				$custid = $row->id;
				
				if($field_category != 'all')
				{
					
					for($i=0;$i<count($_POST['field_cats']);$i++)
						if(isset($_POST['field_cats'][$i]))
							{
								$field_category = $_POST['field_cats'][$i];
								$wpdb->query("insert into ".$wpdb->prefix."ship_custom_relations (custid,catid) values('$custid','$field_category')");
								
							}
					if(empty($field_category)) $field_category = 'all';
				}
				else
					$field_category = 'all';
			}	
			//-------------------------------
			

			
			echo '<div class="saved_thing">Custom field added!</div>';
		}
	}
	
	
	$arr = array("yes" => "Yes", "no" => "No");
	
	if(isset($_GET['edit_field']))
	{
		$custid = $_GET['edit_field'];
		
			if(isset($_POST['save_new_field']))
				{
					$field_name 	= trim($_POST['field_name']);
					//$field_type 	= $_POST['field_type'];
					$field_order 	= trim($_POST['field_order']);
					$field_category = $_POST['field_category'];
					
					if(empty($field_name)) echo '<div class="delete_thing">Field name cannot be empty!</div>';
					else
					{
						$wpdb->query("delete from ".$wpdb->prefix."ship_custom_relations where custid='$custid'"); 
						
						if($field_category != 'all')
						{
							
							for($i=0;$i<count($_POST['field_cats']);$i++)
								if(isset($_POST['field_cats'][$i]))
									{
										$field_category = $_POST['field_cats'][$i];
										$wpdb->query("insert into ".$wpdb->prefix."ship_custom_relations (custid,catid) values('$custid','$field_category')");	
									}
							
							if(empty($field_category)) $field_category = 'all';
						}
						else
							$field_category = 'all';
							
						//-------------------------------
						
						$step_me = '';
						$step_me = apply_filters('shipme_step_me_filter', $step_me);
						
						$content_box6 = $_POST['content_box6'];
						$is_mandatory = $_POST['is_mandatory'];
						
						$ss = "update ".$wpdb->prefix."ship_custom_fields set is_mandatory='$is_mandatory', 
						name='$field_name', content_box6='$content_box6', step_me='$step_me' ,ordr='$field_order',cate='$field_category' where id='$custid'";
						$wpdb->query($ss);
						
						echo '<div class="saved_thing">Custom field saved!</div>';
					}
				}
		
		
		
		
		$s = "select * from ".$wpdb->prefix."ship_custom_fields where id='$custid'";
		$row = $wpdb->get_results($s);
		
		$row = $row[0];
	}	
		


	if(isset($_GET['delete_field']))
	{
		$delid = $_GET['delete_field'];
		$s = "select name from ".$wpdb->prefix."ship_custom_fields where id='$delid'";
		$row = $wpdb->get_results($s);
		$row = $row[0];
		
		if(isset($_GET['coo']))
		{
			$s = "delete from ".$wpdb->prefix."ship_custom_fields where id='$delid'";
			$r = $wpdb->query($s);
			
			echo '<div class="delete_thing">Field "'.$row->name.'" has been deleted! </div>';
			
		}
		else
		{
			
			echo '<div class="delete_thing"><div class="padd10">Are you sure you want to delete "'.$row->name.'" ? &nbsp; 
			<a href="'.get_admin_url().'admin.php?page=custom-fields&delete_field='.$delid.'&coo=y">Yes</a> | 
			<a href="'.get_admin_url().'admin.php?page=custom-fields">No</a> </div></div>';
		}
		
	} ?>
    
        <div id="usual2" class="usual"> 
  <ul> 
  <?php
  
  	if(isset($_GET['edit_field']))
	{
		$tabs1 = "tabs-0";	
	}
	else
	{
		$tabs1 = "tabs1";
	}
  
  
  ?>
  
				<?php if(isset($_GET['edit_field'])): ?>
				<li><a href="#tabs1">Edit custom field "<?php echo $row->name; ?>"</a></li>				
				<?php endif; ?>
				<li><a href="#<?php echo $tabs1; ?>">Add New Custom Field</a></li>
				<li><a href="#tabs-2">Current Custom Fields</a></li>
    
    
  </ul> 


<?php if(isset($_GET['edit_field'])): ?>
			<div id="tabs1" style="display:block;padding:0">	
				
				
	<form method="post">
	<table class="sitemile-table" width="100%">
    
    <tr>
    <td width="170"> Field Name: </td>
    <td><input type="text" size="30" name="field_name" value="<?php echo $row->name; ?>" /></td>
    </td>
    
    <tr>
    <td> Field Type: </td>
    <td><?php echo ships_get_field_tp($row->tp); ?></td>

    </td>
    
    
    <tr>
    <td width="170"> Field Order: </td>
    <td><input type="text" size="5" name="field_order" value="<?php echo $row->ordr; ?>" /></td>
    </td>
    
    <?php do_action('shipme_extra_field_options',$row); ?>
    
    <?php
	
		if($row->tp == 6):
	
	?>
     <tr>
    <td width="170" valign="top"> Field HTML Content: </td>
    <td><textarea rows="5" cols="60" name="content_box6"><?php echo stripslashes($row->content_box6); ?></textarea></td>
    </td>
    
    <?php endif; ?>
    
       <tr>
    <td> Mandatory Field: </td>
    <td><select name="is_mandatory">
    <option value="0" <?php echo ($row->is_mandatory == 0 ? "selected='selected'" :''); ?>>No</option>
    <option value="1" <?php echo ($row->is_mandatory == 1 ? "selected='selected'" :''); ?>>Yes</option>
    </select></td>
    </td>
    
    <tr>
    <td width="170"> Apply to category: </td>
    <td><input type="radio" name="field_category" value="all" <?php if($row->cate == 'all') echo 'checked="checked"'; ?>  /> Apply to all categories </td>
    </td>
    
    
        <tr>
    <td width="170"> </td>
    <td><input type="radio" name="field_category" value="sel" <?php if($row->cate != 'all') echo 'checked="checked"'; ?>  /> Apply to selected categories <br/>
            <div class="cat-class">
            <table width="100%">
            <?php
				
				
			 $categories =  get_categories('taxonomy=job_ship_cat&hide_empty=0&orderby=name&parent=0');

			  foreach ($categories as $category) 
				{
					
					if(shipme_search_into($custid,$category->cat_ID) == 1) $chk = ' checked="checked" ';
						else $chk = "";
					echo '
					    <tr>
						<td><input '.$chk.' type="checkbox" name="field_cats[]" value="'.$category->cat_ID.'" />
						<b>'.$category->cat_name.'</b></td>
						</tr>';
						
					$subcategories =  get_categories('taxonomy=job_ship_cat&hide_empty=0&orderby=name&parent='.$category->term_id);
						
					if($subcategories)	
					foreach ($subcategories as $subcategory) 
					{
						if(shipme_search_into($custid,$subcategory->cat_ID) == 1) $chk = ' checked="checked" ';
						else $chk = "";
						
						echo '
					    <tr>
						<td>&nbsp; &nbsp; &nbsp; <input type="checkbox" '.$chk.' name="field_cats[]" value="'.$subcategory->cat_ID.'" />
						'.$subcategory->cat_name.'</td>
						</tr>';
						
						
							$subcategories2 =  get_categories('taxonomy=job_ship_cat&hide_empty=0&orderby=name&parent='.$subcategory->term_id);
						
							if($subcategories2)	
							foreach ($subcategories2 as $subcategory2) 
							{
								if(shipme_search_into($custid,$subcategory2->cat_ID) == 1) $chk = ' checked="checked" ';
								else $chk = "";
								
								echo '
								<tr>
								<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type="checkbox" '.$chk.' name="field_cats[]" value="'.$subcategory2->cat_ID.'" />
								'.$subcategory2->cat_name.'</td>
								</tr>';
								
								
										$subcategories3 =  get_categories('taxonomy=job_ship_cat&hide_empty=0&orderby=name&parent='.$subcategory2->term_id);
						
										if($subcategories3)	
										foreach ($subcategories3 as $subcategory3) 
										{
											if(shipme_search_into($custid,$subcategory3->cat_ID) == 1) $chk = ' checked="checked" ';
											else $chk = "";
											
											echo '
											<tr>
											<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type="checkbox" '.$chk.' name="field_cats[]" value="'.$subcategory3->cat_ID.'" />
											'.$subcategory3->cat_name.'</td>
											</tr>';
											
										}
									
								
								
								
							}
						
					}
				}	
				
				
			

						
			
			?>
            
            
        
            
            </table>
            </div>
    </td>
    </td>
    
     
    <tr>
    <td width="170">  </td>
    <td><input type="submit"  class="button button-primary button-large" name="save_new_field" value="Save this!" /> </td>
    </td>
    
    </table>
	</form>

	
		
        <?php
		
		if($row->tp != 1 && $row->tp != 5 && $row->tp != 6)
		{
			
			?>	
		<hr color="#CCCCCC" />
        <?php
			
			if(isset($_POST['_add_option']) && !empty($_POST['option_name']))
			{
				$option_name = $_POST['option_name'];
				$ss = "insert into ".$wpdb->prefix."ship_custom_options (valval, custid) values('$option_name','$custid')";
				$wpdb->query($ss);
				
				echo '<div class="saved_thing"  id="add_options"><div class="padd10">Success! Your option was added!</div></div>';
				
				
			}
		
		
		?>
        
        
        <table  class="sitemile-table" width="100%"><tr><td>
        <strong>Add options:</strong>
        </td></tr>
        </table>
        
       	<form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=custom-fields&edit_field=<?php echo $custid; ?>#add_options"> 
        <table>
        <tr>
        <td>Option Name: </td>
        <td><input type="text" name="option_name" size="20" /> <input type="submit"  class="button button-primary button-large" name="_add_option" value="Add Option" /> </td>
        </tr>
		
        <?php echo shipme_job_clear_table(2); ?>
        </table>
        </form>
        
        
        <table><tr><td>
        <strong>Current options:</strong>
        </td></tr>
        </table>
        <?php
		
		$ss = "select * from ".$wpdb->prefix."ship_custom_options where custid='$custid' order by id desc";
		$rows2 = $wpdb->get_results($ss);
		
		if(count($rows2) == 0)
		echo "No options defined.";
		else
		{
			?>			
				<script>
					function delete_this(id)
							{
								 jQuery.ajax({
												method: 'get',
												url : '<?php echo get_bloginfo('siteurl');?>/index.php?_delete_custom_id='+id,
												dataType : 'text',
												success: function (text) {  
												 jQuery('#option_' + id).animate({'backgroundColor' : '#ff9900'},1000);
												 jQuery('#option_'+id).remove();  }
											 });
								  
							
							}
				</script>
					
			<?php
			echo '<table  class="wp-list-table widefat fixed posts">';
			
				echo '<thead><tr>';
				echo '<th>Option Value</th>';
				echo '<th>Option Order</th>';
				echo '<th></th>';
				echo '</tr></thead>';
			
			
			
			
			foreach($rows2 as $row2)
			{
				echo '<script type="text/javascript"> 
						jQuery(document).ready(function() { 
						   jQuery(\'#myForm_'.$row2->id.'\').ajaxForm(function() { 
								 

								
								jQuery(\'#option_'.$row2->id.'\').animate({\'backgroundColor\' : \'#ff9900\'});
								jQuery(\'#option_'.$row2->id.'\').animate({\'backgroundColor\' : \'#cccccc\'});

							
							}); 
						}); 
					</script> ';
					
				
				echo '<form method="post" id="myForm_'.$row2->id.'" action="'.get_bloginfo('siteurl').'/?update_option_ajax_ready=1" />';
				echo '<tr id="option_'.$row2->id.'" >';
				echo '<th><input type="hidden" size="20" name="option_id"  value="'.$row2->id.'" />
				<input type="text" size="20" name="option_name" id="custom_option_value_'.$row2->id.'" value="'.$row2->valval.'" />
				</th>';
				echo '<th><input type="text" size="4" name="option_order" id="custom_option_order_'.$row2->id.'" value="'.$row2->ordr.'" /></th>';
				echo '<th><input type="submit"  class="button button-primary button-large" name="submit" id="submit" value="Update" />
							<input onclick="delete_this('.$row2->id.')" type="button" name="DEL" value="Delete"  />
				</th>';
				echo '</tr></form>';
			}		
			
			echo '</table>';
		}
		
		}
		?>
				</table>
			</div>
			<?php endif; ?>	
			
			
			<div id="<?php echo $tabs1; ?>" style="display:block;padding:0">
	
	
    <form method="post">
	<table  class="sitemile-table" width="100%">

    <tr>
    <td width="170"> Field Name: </td>
    <td><input type="text" size="30" name="field_name" /></td>
    </td>
    
    <tr>
    <td> Field Type: </td>
    <td><select name="field_type">
    <option value="1">Text field</option>
    <option value="2">Select box</option>
    <option value="3">Radio Buttons</option>
    <option value="4">Check-box</option>
    <option value="5">Large text-area</option>

    <option value="6">HTML Box</option>
    </select></td>
    </td>
    
    <tr>
    <td> Mandatory Field: </td>
    <td><select name="is_mandatory">
    <option value="0">No</option>
    <option value="1">Yes</option>
    </select></td>
    </td>
    
    
    <tr>
    <td width="170"> Field Order: </td>
    <td><input type="text" size="5" name="field_order" /></td>
    </td>
    
    
    <?php do_action('shipme_extra_field_options',$row); ?>
    
    <tr>
    <td width="170"> Apply to category: </td>
    <td><input type="radio" name="field_category" value="all" checked="checked" /> Apply to all categories </td>
    </td>
    
    
        <tr>
    <td width="170"> </td>
    <td><input type="radio" name="field_category" value="sel" /> Apply to selected categories <br/>
            <div class="cat-class">
            <table width="100%">
            <?php
			
			  $categories =  get_categories('taxonomy=job_ship_cat&hide_empty=0&orderby=name&parent=0');

			  foreach ($categories as $category) 
				{
					
					if(shipme_search_into($custid,$category->cat_ID) == 1) $chk = ' checked="checked" ';
						else $chk = "";
					echo '
					    <tr>
						<td><input '.$chk.' type="checkbox" name="field_cats[]" value="'.$category->cat_ID.'" />
						<b>'.$category->cat_name.'</b></td>
						</tr>';
						
					$subcategories =  get_categories('taxonomy=job_ship_cat&hide_empty=0&orderby=name&parent='.$category->term_id);
						
					if($subcategories)	
					foreach ($subcategories as $subcategory) 
					{
						if(shipme_search_into($custid,$subcategory->cat_ID) == 1) $chk = ' checked="checked" ';
						else $chk = "";
						
						echo '
					    <tr>
						<td>&nbsp; &nbsp; &nbsp; <input type="checkbox" '.$chk.' name="field_cats[]" value="'.$subcategory->cat_ID.'" />
						'.$subcategory->cat_name.'</td>
						</tr>';
						
						
							$subcategories2 =  get_categories('taxonomy=job_ship_cat&hide_empty=0&orderby=name&parent='.$subcategory->term_id);
						
							if($subcategories2)	
							foreach ($subcategories2 as $subcategory2) 
							{
								if(shipme_search_into($custid,$subcategory2->cat_ID) == 1) $chk = ' checked="checked" ';
								else $chk = "";
								
								echo '
								<tr>
								<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type="checkbox" '.$chk.' name="field_cats[]" value="'.$subcategory2->cat_ID.'" />
								'.$subcategory2->cat_name.'</td>
								</tr>';
								
								
										$subcategories3 =  get_categories('taxonomy=job_ship_cat&hide_empty=0&orderby=name&parent='.$subcategory2->term_id);
						
										if($subcategories3)	
										foreach ($subcategories3 as $subcategory3) 
										{
											if(shipme_search_into($custid,$subcategory3->cat_ID) == 1) $chk = ' checked="checked" ';
											else $chk = "";
											
											echo '
											<tr>
											<td>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <input type="checkbox" '.$chk.' name="field_cats[]" value="'.$subcategory3->cat_ID.'" />
											'.$subcategory3->cat_name.'</td>
											</tr>';
											
										}
									
								
								
								
							}
						
					}
				}	
				

						
			
			?>
            
            
        
            
            </table>
            </div>
    </td>
    </td>
    

     
        <tr>
    <td width="170">  </td>
    <td><input type="submit"  class="button button-primary button-large" name="add_new_field" value="Add this!" /> </td>
    </td>
    
    </table>
	</form>
		
		
		</div>
		
			<div id="tabs-2" style="display:block;">
				
				
				 <table width="100%">
      
    </table>
    <?php
	
	$ss2 = "select * from ".$wpdb->prefix."ship_custom_fields order by ordr asc";
	$rf = $wpdb->get_results($ss2);
	
	if(count($rf) == 0)
		echo 'No fields yet added.';
	else
	{
		echo '<table class="wp-list-table widefat fixed posts">';
		
		
		echo '<thead><tr>';
		echo '<th><strong>Field Name</strong></th>';
		echo '<th><strong>Field Type</strong></th>';
		echo '<th><strong>Field Category</strong></th>';
		echo '<th><strong>Field Order</strong></th>';
		echo '<th><strong>Mandatory</strong></th>';
		echo '<th><strong>Options</strong></th>';
		echo '</tr></thead><tbody>';
		
		foreach($rf as $row)
		{		
				$bgs = "efefef";
				if(isset($_GET['edit_field']))				
					if($_GET['edit_field'] == $row->id)
						$bgs = "B5CA73";
				
				
				
				echo '<tr>';
				echo '<th>'.$row->name.'</th>';
				echo '<th>'.ships_get_field_tp($row->tp).'</th>';
				echo '<th>'.($row->cate == 'all' ? "All Categories" : "Multiple Categories").'</th>';
				echo '<th>'.$row->ordr.'</th>';
				echo '<th>'.($row->is_mandatory == 0 ? "No" : "Yes").'</th>';
				echo '<th>
				<a href="'.get_admin_url().'admin.php?page=custom-fields&edit_field='.$row->id.'"
				><img src="'.get_bloginfo('template_url').'/images/edit.gif" border="0" alt="Edit" /></a>
				
				<a href="'.get_admin_url().'admin.php?page=custom-fields&delete_field='.$row->id.'"
				><img src="'.get_bloginfo('template_url').'/images/delete.gif" border="0" alt="Delete" /></a>
				
				</th>';
				echo '</tr>';
			
		}
		echo '</tbody></table>';
	}
	?>
				
				
			</div>
			</div>

	<?php
    
   	
	echo '</div>';
}

function shipme_theme_bullet($rn = '')
{
	global $menu_admin_shp_theme_bull;
	$menu_admin_shp_theme_bull = '<a href="#" class="tltp_cls" title="'.$rn.'"><img src="'.get_bloginfo('template_url') . '/images/qu_icon.png" /></a>';	
	echo $menu_admin_shp_theme_bull;
	
}

function shipme_summary_scr()
{
	global $menu_admin_shipme_bull;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general-summary"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">ShipMe Site Summary</h2>';
	?>
    
        <div id="usual2" class="usual"> 
  <ul> 
    <li><a href="#tabs1" class="selected">General Overview</a></li> 
   <!-- <li><a href="#tabs2">More Information</a></li> -->
  </ul> 
  <div id="tabs1" style="display: block; ">
    	<table width="100%" class="sitemile-table">
          <tr>
          <td width="200">Total number of jobs</td>
          <td><?php echo shipme_get_total_nr_of_jobs(); ?></td>
          </tr>
          
          
          <tr>
          <td>Open Jobs</td>
          <td><?php echo shipme_get_total_nr_of_open_jobs(); ?></td>
          </tr>
          
          <tr>
          <td>Closed & Finished</td>
          <td><?php echo shipme_get_total_nr_of_closed_jobs(); ?></td>
          </tr>
          
<!--          
          <tr>
          <td>Disputed & Not Finished</td>
          <td>12</td>
          </tr>
  -->        
          
          <tr>
          <td>Total Users</td>
          <td><?php
			$result = count_users();
			echo 'There are ', $result['total_users'], ' total users';
			foreach($result['avail_roles'] as $role => $count)
				echo ', ', $count, ' are ', $role, 's';
			echo '.';
			?></td>
          </tr>
          
          </table>
        
          </div> 
          <div id="tabs2" style="display: none; ">More content in tab 2.</div> 
        </div> 
    
    
    <?php	
	
	echo '</div>';
}


function shipme_theme_information()
{
	global $menu_admin_shipme_bull;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general-info"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">ShipMe Theme Info</h2>';
	?>
    
        <div id="usual2" class="usual"> 
          <ul> 
            <li><a href="#tabs1" class="selected"><?php _e('Main Information','shipme'); ?></a></li> 
            <li><a href="#tabs2"><?php _e('From SiteMile Blog','shipme'); ?></a></li> 
  
          </ul> 
          <div id="tabs1" style="display: block; ">	
          
          <table width="100%" class="sitemile-table">
    				

                    <tr>                    
                    <td width="260"><?php _e('shipme Version:','shipme'); ?></td>
                    <td><?php echo shipme_VERSION; ?></td>
                    </tr>
                    
                    <tr>                    
                    <td width="160"><?php _e('shipme Latest Release:','shipme'); ?></td>
                    <td><?php echo shipme_RELEASE; ?></td>
                    </tr>
                    
                    <tr>                    
                    <td width="160"><?php _e('WordPress Version:','shipme'); ?></td>
                    <td><?php bloginfo('version'); ?></td>
                    </tr>
                    
                    
                    <tr>                    
                    <td width="160"><?php _e('Go to SiteMile official page:','shipme'); ?></td>
                    <td><a class="festin" href="http://sitemile.com">SiteMile - Premium WordPress Themes</a></td>
                    </tr>
                    
                    <tr>                    
                    <td width="160"><?php _e('Go to Job official page:','shipme'); ?></td>
                    <td><a class="festin" href="http://sitemile.com/p/ship">ShipMe Theme Page</a></td>
                    </tr>
                    
                    <tr>                    
                    <td width="160"><?php _e('Go to support forums:','shipme'); ?></td>
                    <td><a class="festin" href="http://sitemile.com/forums">SiteMile Support Forums</a></td>
                    </tr>
                    
                    <tr>                    
                    <td width="160"><?php _e('Contact SiteMile Team:','shipme'); ?></td>
                    <td><a class="festin" href="http://sitemile.com/contact-us">Contact Form</a></td>
                    </tr>
                    
                    <tr>                    
                    <td width="160"><?php _e('Like us on Facebook:','shipme'); ?></td>
                    <td><a class="festin" href="http://facebook.com/sitemile">SiteMile Facebook Fan Page</a></td>
                    </tr>
                    
                    
                     <tr>                    
                    <td width="160"><?php _e('Follow us on Twitter:','shipme'); ?></td>
                    <td><a class="festin" href="http://twitter.com/sitemile">SiteMile Twitter Page</a></td>
                    </tr>
                    
                    
                    
           </table>         
          
          </div>
          
          <div id="tabs2" style="display: none; overflow:hidden ">	
          
          <?php
		   echo '<div style="float:left;">';
 wp_widget_rss_output(array(
 'url' => 'http://sitemile.com/feed/',
 'title' => 'Latest news from SiteMile.com Blog',
 'items' => 10,
 'show_summary' => 1,
 'show_author' => 0,
 'show_date' => 1
 ));
 echo "</div>";
 
 ?>
          
          </div>
          
    
    <?php	
	
	echo '</div>';
}


function shipme_user_balances()
{
	global $menu_admin_shipme_bull;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general-bal"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">shipme User Balances</h2>';
	?>
        <script>
	
	 jQuery(document).ready(function() {
  
  	jQuery('.update_btn*').click(function() {
	
	var id = jQuery(this).attr('alt');
	var increase_credits = jQuery('#increase_credits' + id).val();
	var decrease_credits = jQuery('#decrease_credits' + id).val();
	
	jQuery.ajax({
   type: "GET",
   url: "<?php echo get_bloginfo('siteurl'); ?>/",
   data: "crds=1&uid="+id+"&increase_credits="+increase_credits+"&decrease_credits="+decrease_credits,
   success: function(msg){
     
	 
	jQuery("#money" + id).html(msg);
	jQuery('#increase_credits' + id).val("");
	jQuery('#decrease_credits' + id).val(""); 
	 
   }
 });
	
	});
  
  
 });
	
	
	</script>
    
    
    
        <div id="usual2" class="usual"> 
  <ul> 
    <li><a href="#tabs1" >All Users</a></li> 
    <li><a href="#tabs2">Search User</a></li> 
  </ul> 
  <div id="tabs1" style="display: none; ">
    	
        
	<?php
	
	$rows_per_page = 10;
	
	if(isset($_GET['pj'])) $pageno = $_GET['pj'];
	else $pageno = 1;
	
	global $wpdb;

	$s1 = "select ID from ".$wpdb->users." order by user_login asc ";
	$s = "select * from ".$wpdb->users." order by user_login asc ";
	$limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
	
	
	$r = $wpdb->get_results($s1); $nr = count($r);
	$lastpage      = ceil($nr/$rows_per_page);
	
	$r = $wpdb->get_results($s.$limit);

	if($nr > 0)	
	{
		
		?>
		
		
		        <table class="widefat post fixed" cellspacing="0">
    <thead>
    <tr>
    <th width="15%">Username</th>
    <th width="20%">Email</th>
    <th width="20%">Date Registered</th>
    <th width="13%" >Cash Balance</th>
	<th >Options</th>
    </tr>
    </thead>
    
     
    
    <tbody>
		
		
		<?php 
		
		
	foreach($r as $row)
	{
		$user = get_userdata($row->ID);
		

		echo '<tr style="">';	
		echo '<th>'.$user->user_login.'</th>';
		echo '<th>'.$row->user_email .'</th>';
		echo '<th>'.$row->user_registered .'</th>';
		echo '<th class="'.$cl.'"><span id="money'.$row->ID.'">'.$sign. shipme_get_show_price(shipme_get_credits($row->ID)) .'</span></th>';
		echo '<th>'; 
		?>
		
        Increase Credits: <input type="text" size="4" id="increase_credits<?php echo $row->ID; ?>" rel="<?php echo $row->ID; ?>" /> <?php echo shipme_currency(); ?><br/>
        Decrease Credits: <input type="text" size="4" id="decrease_credits<?php echo $row->ID; ?>" rel="<?php echo $row->ID; ?>" /> <?php echo shipme_currency(); ?><br/>
        
        <input type="button" value="Update" class="update_btn" alt="<?php echo $row->ID; ?>" />
        
        
        <?php
		echo '</th>';
	
		echo '</tr>';
	}
	
	
	?>



	</tbody>
    
    </table>
    
    <?php 
    
	for($i=1;$i<=$lastpage;$i++)
		{
			if($pageno == $i) echo $i." | ";
			else			
			echo '<a href="'.get_admin_url().'admin.php?page=User-Balances&pj='.$i.'"
			>'.$i.'</a> | ';	
			
		}
		
	}
    
    ?>
          </div> 
          <div id="tabs2"  style="display: none; "  >
          <form method="get" action="<?php echo get_admin_url(); ?>admin.php">
          <input type="hidden" name="page" value="User-Balances" />
          <input type="hidden" name="active_tab" value="tabs2" />
          Search User: <input type="text" size="35" value="<?php echo $_GET['src_usr']; ?>" name="src_usr" />
           <input type="submit"  class="button button-primary button-large" value="Submit" name="" />
          </form>
          
          <?php
		  if(!empty($_GET['src_usr'])):
		  
		  ?>
          
          <?php
	
	$rows_per_page = 10;
	
	if(isset($_GET['pj'])) $pageno = $_GET['pj'];
	else $pageno = 1;
	
	global $wpdb;
	$src_usr = $_GET['src_usr'];
	
	$s1 = "select ID from ".$wpdb->users." where user_login like '%$src_usr%' order by user_login asc ";
	$s = "select * from ".$wpdb->users." where user_login like '%$src_usr%' order by user_login asc ";
	$limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
	
	
	$r = $wpdb->get_results($s1); $nr = count($r);
	$lastpage      = ceil($nr/$rows_per_page);
	
	$r = $wpdb->get_results($s.$limit);

	if($nr > 0)	
	{
		
		?>
		
		
		        <table class="widefat post fixed" cellspacing="0">
    <thead>
    <tr>
    <th width="15%">Username</th>
    <th width="20%">Email</th>
    <th width="20%">Date Registered</th>
    <th width="13%" >Cash Balance</th>
	<th >Options</th>
    </tr>
    </thead>
    

    
    <tbody>
		
		
		<?php 
		
		
	foreach($r as $row)
	{
		$user = get_userdata($row->ID);
		

		echo '<tr style="">';	
		echo '<th>'.$user->user_login.'</th>';
		echo '<th>'.$row->user_email .'</th>';
		echo '<th>'.$row->user_registered .'</th>';
		echo '<th class="'.$cl.'"><span id="money'.$row->ID.'">'.$sign. shipme_get_show_price(shipme_get_credits($row->ID)) .'</span></th>';
		echo '<th>'; 
		?>
		
        Increase Credits: <input type="text" size="4" id="increase_credits<?php echo $row->ID; ?>" rel="<?php echo $row->ID; ?>" /> <?php echo shipme_currency(); ?><br/>
        Decrease Credits: <input type="text" size="4" id="decrease_credits<?php echo $row->ID; ?>" rel="<?php echo $row->ID; ?>" /> <?php echo shipme_currency(); ?><br/>
        
        <input type="button" value="Update" class="update_btn" alt="<?php echo $row->ID; ?>" />
        
        
        <?php
		echo '</th>';
	
		echo '</tr>';
	}
	
	
	?>



	</tbody>
    
    </table>
    
    <?php 
    
	for($i=1;$i<=$lastpage;$i++)
		{
			if($pageno == $i) echo $i." | ";
			else			
			echo '<a href="'.get_admin_url().'admin.php?active_tab=tabs2&src_usr='.$_GET['src_usr'].'&page=User-Balances&pj='.$i.'"
			>'.$i.'</a> | ';	
			
		}
		
	}
    

    ?>
          
          
          <?php endif; ?>
          
          </div> 
        </div> 
    
    
    <?php	
	
	echo '</div>';
}


function shipme_cust_prcng()
{
	global $menu_admin_shipme_bull, $wpdb;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general-custpricing"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">shipme Custom Pricing</h2>';
	
	$arr = array("yes" => "Yes", "no" => "No");
	         
	if(isset($_POST['my_submit']))
	{
		$shipme_enable_custom_posting 		= trim($_POST['shipme_enable_custom_posting']);
		update_option('shipme_enable_custom_posting', $shipme_enable_custom_posting);
			
		//---------------
		
		$customs = $_POST['customs'];
		for($i=0;$i<count($customs);$i++)
		{
			$ids = $customs[$i];
			$val =trim( $_POST['shipme_theme_custom_cat_'.$ids]);
			update_option('shipme_theme_custom_cat_'.$ids,$val);			
			
		}
		
		//---------------
		
		echo '<div class="saved_thing">Settings saved!</div>';
		
	}
	
	   if(isset($_POST['my_submit2']))
	{
		$shipme_enable_custom_bidding 		= $_POST['shipme_enable_custom_bidding'];
		update_option('shipme_enable_custom_bidding',$shipme_enable_custom_bidding);
			
		//---------------
		
		$customs = $_POST['customs'];
		for($i=0;$i<count($customs);$i++)
		{
			$ids = $customs[$i];
			$val = trim($_POST['shipme_theme_bidding_cat_'.$ids]);
			update_option('shipme_theme_bidding_cat_'.$ids,$val);			
			
		}
		
		//---------------
		
		echo '<div class="saved_thing">Settings saved!</div>';
		
	}
	
	?>
    
        <div id="usual2" class="usual"> 
  <ul> 
    <li><a href="#tabs1" class="selected">Custom Posting Fees</a></li> 
    <li><a href="#tabs2">Custom Bidding Fees</a></li> 
  </ul> 
  <div id="tabs1" style="display: block; ">
    	 <form method="post">
    	<table width="100%" class="sitemile-table">
        
        
        <tr>
        <td width="220" >Enable Custom Posting fees:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_custom_posting'); ?></td>
        </tr>
        
                

        
        <?php echo shipme_job_clear_table(2); ?>
        
         <tr>
        <td width="220" ><strong>Set Fees for each Category:</strong></td>
        <td></td>
        </tr>
        <?php echo shipme_job_clear_table(2); ?>
        
        <?php
		  
		  $categories =  get_categories('taxonomy=job_ship_cat&hide_empty=0&orderby=name');
		  //$blg = get_option('project_theme_blog_category');
			
		  foreach ($categories as $category) 
		  {
			if(1) //$category->cat_name != "Uncategorized" && $category->cat_ID != $blg )
			{
				echo '<tr>';
				echo '<td>'.$category->cat_name.'</td>';
				echo '<td><input type="text" size="6" value="'.get_option('shipme_theme_custom_cat_'.$category->cat_ID).'" 
				name="shipme_theme_custom_cat_'.$category->cat_ID.'" /> '.shipme_currency().'
				<input type="hidden" name="customs[]" value="'.$category->cat_ID.'" />
				</td>';
	
				echo '</tr>';
			}
		  
		  }
		
		?>
          <?php echo shipme_job_clear_table(2); ?>
        
                <tr>
        <td ></td>
        <td><input type="submit"  class="button button-primary button-large" name="my_submit"    value="Save these Settings!" /></td>
        </tr>
        
        </table>
    </form>
            
        
          </div> 
          <div id="tabs2" style="display: none; ">
          
          <form method="post">
    	<table width="100%" class="sitemile-table">
        
        
        <tr>
        <td width="220" >Enable Custom Bidding fees:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_custom_bidding'); ?></td>
        </tr>
        
                

        
        <?php echo shipme_job_clear_table(2); ?>
        
         <tr>
        <td width="220" ><strong>Set Fees for each Category:</strong></td>
        <td></td>
        </tr>
        <?php echo shipme_job_clear_table(2); ?>
        
        <?php
		  
		  $categories =  get_categories('taxonomy=job_ship_cat&hide_empty=0&orderby=name');

			
		  foreach ($categories as $category) 
		  {
			if(1) //$category->cat_name != "Uncategorized" && $category->cat_ID != $blg )
			{
				echo '<tr>';
				echo '<td>'.$category->cat_name.'</td>';
				echo '<td><input type="text" size="6" value="'.get_option('shipme_theme_bidding_cat_'.$category->cat_ID).'" 
				name="shipme_theme_bidding_cat_'.$category->cat_ID.'" /> '.shipme_currency().'
				<input type="hidden" name="customs[]" value="'.$category->cat_ID.'" />
				</td>';
	
				echo '</tr>';
			}
		  
		  }
		
		?>
          <?php echo shipme_job_clear_table(2); ?>
        
                <tr>
        <td ></td>
        <td><input type="submit"  class="button button-primary button-large" name="my_submit2"    value="Save these Settings!" /></td>
        </tr>
        
        </table>
    </form>
          
          </div> 
        </div> 
    
    
    <?php	
	
	echo '</div>';
}


function shipme_private_messages_scr()
{
	global $menu_admin_shipme_bull, $wpdb;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general-mess"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">ShipMe Private Messages</h2>';
	?>
    
       <div id="usual2" class="usual"> 
          <ul> 
            <li><a href="#tabs1"><?php _e('All Private Messages','shipme'); ?></a></li> 
            <li><a href="#tabs2"><?php _e('Search User','shipme'); ?></a></li> 

          </ul> 
          <div id="tabs1">	
          
          <?php
		  
		  if(isset($_GET['approve_message']))
		  {
			  $mess_id = ($_GET['approve_message']);
			  
			  $s = "select * from ".$wpdb->prefix."shipme_pm where id='$mess_id'";
          	  $r = $wpdb->get_results($s);
			  $row = $r[0];
			  
			  
			  if($_GET['accept_str'] == "1"):
			  
			  	if($row->approved == 0)
				{
					$tm = current_time('timestamp',0);
					$ss = "update ".$wpdb->prefix."shipme_pm set approved='1' , approved_on='$tm', show_to_destination='1' where id='$mess_id'";	
					$wpdb->query($ss);
					
					shipme_send_email_on_priv_mess_received($row->initiator, $row->user);
				}
			  
			  ?>
			  
			  <div class="saved_thing">
              <?php _e('The message has been approved.','shipme'); ?></a>
              
              </div>
              
              
              <?php
			  else:
			?>  
			  
			  <div class="saved_thing">
              <?php _e('Are you sure you want to approve this message?','shipme'); ?> &nbsp; &nbsp; &nbsp;
             <a href="<?php echo get_admin_url().'admin.php?page=private-messages&pj='.$_GET['pj'].'&approve_message='.$row->id."&accept_str=1"; ?>" class="approve_yes"><?php _e('Yes, Approve!','shipme'); ?></a>
              
              </div>
              
			  <?php
			  
			  endif;
		  }
		  
		  
		  ?>
          
          
          <?php
		  
		  	$nrpostsPage = 10; 
		  	$page = $_GET['pj']; if(empty($page)) $page = 1;
			$my_page = $page;
			
		   $s = "select * from ".$wpdb->prefix."shipme_pm order by id desc limit ".($nrpostsPage * ($page - 1) )." ,$nrpostsPage";
           $r = $wpdb->get_results($s);
		 	
		
		$s1 = "select id from ".$wpdb->prefix."shipme_pm order by id desc";	 	
		$r1 = $wpdb->get_results($s1);	
		
		
		if(count($r) > 0):
		
				$total_nr = count($r1);
				
				$nrposts = $total_nr;
				$totalPages = ceil($nrposts / $nrpostsPage);
				$pagess = $totalPages;
				$batch = 10; //ceil($page / $nrpostsPage );
				
				
				$start 		= floor($my_page/$batch) * $batch + 1; 
				$end		= $start + $batch - 1;
				$end_me 	= $end + 1;
				$start_me 	= $start - 1;
				
				if($end > $totalPages) $end = $totalPages;
				if($end_me > $totalPages) $end_me = $totalPages;
				
				if($start_me <= 0) $start_me = 1;
				
				$previous_pg = $my_page - 1;
				if($previous_pg <= 0) $previous_pg = 1;
				
				$next_pg = $my_page + 1;
				if($next_pg >= $totalPages) $next_pg = 1;
				
			
			
		  
		  ?>
          
           <table class="widefat post fixed" cellspacing="0">
            <thead>
            <tr>
            <th><?php _e('Sender','shipme'); ?></th>
            <th><?php _e('Receiver','shipme'); ?></th>
            <th width="20%"><?php _e('Subject','shipme'); ?></th>
            <th><?php _e('Sent On','shipme'); ?></th>
            <th><?php _e('Approved','shipme'); ?></th>
            <th width="25%"><?php _e('Options','shipme'); ?></th>
            </tr>
            </thead>
            
            
            
            <tbody>
            <?php
            
           
            $i = 0;
            foreach($r as $row)
            {
                $sender 	= get_userdata($row->initiator);
				$receiver 	= get_userdata($row->user);
                
				if($i%2) $new_bg_color = '#E7E9F1';
				else $new_bg_color = '#fff';
				
					$i++;
				
                echo '<tr style="background:'.$new_bg_color.'">';
				echo '<th>'.$sender->user_login.'</th>';
				echo '<th>'.$receiver->user_login.'</th>';
				echo '<th>'.$row->subject.'</th>';
				echo '<th>'.date('d-M-Y H:i:s', $row->datemade).'</th>';
				echo '<th>'.($row->approved == 1 ? __("Yes",'shipme') : __("No","shipme")).'</th>';
				echo '<th>'.($row->approved == 0 ? '<a href="'.get_admin_url().'admin.php?page=private-messages&pj='.$_GET['pj'].'&approve_message='.$row->id.'">'.__("Approve",'shipme') ."</a>" : '').'</th>';
				echo '</tr>';
            
				echo '<tr style="background:'.$new_bg_color.'">';
				echo '<th colspan="6">'.$row->content;
				
				if(!empty($row->file_attached))
				echo '<br/><br/>'.sprintf(__('File Attached: %s','shipme') , '<a href="'.wp_get_attachment_url($row->file_attached).'">'.wp_get_attachment_url($row->file_attached)."</a>") ;
	  
				
				echo '</th>';
				echo '</tr>';
							
			}
            
            ?>
            </tbody>
            
            
            </table>
            <?php
			
			
			if($start > 1)
			echo '<a href="'.get_admin_url().'admin.php?page=private-messages&pj='.$previous_pg.'"><< '.__('Previous','shipme').'</a> ';
			echo ' <a href="'.get_admin_url().'admin.php?page=private-messages&pj='.$start_me.'"><<</a> ';
			
			
	
			
			for($i = $start; $i <= $end; $i ++) {
				if ($i == $my_page) {
					echo ''.$i.' | ';
				} else {
		
					echo '<a href="'.get_admin_url().'admin.php?page=private-messages&pj='.$i.'">'.$i.'</a> | ';
					
				}
			}
	
	
			
			if($totalPages > $my_page)
			echo ' <a href="'.get_admin_url().'admin.php?page=private-messages&pj='.$end_me.'">>></a> ';
			echo ' <a href="'.get_admin_url().'admin.php?page=private-messages&pj='.$next_pg.'">'.__('Next','shipme').' >></a> ';	
			
			
			?>
            
            
            
            <?php else: ?>
            
            <div class="padd101">
            <?php _e('There are no private messages.','shipme'); ?>
            </div>
            
            <?php endif; ?>
          
          
          </div>
          
          <div id="tabs2">	
          
          
          
          <form method="get" action="<?php echo get_admin_url(); ?>admin.php">
            <input type="hidden" value="private-messages" name="page" />
            <input type="hidden" value="tabs2" name="active_tab" />
            <table width="100%" class="sitemile-table">
            	<tr>
                <td><?php _e('Search User','shipme'); ?></td>
                <td><input type="text" value="<?php echo $_GET['search_user']; ?>" name="search_user" size="20" /> <input type="submit"  class="button button-primary button-large"   name="shipme_save2" value="<?php _e('Search','shipme'); ?>"/></td>
                </tr>
     
            
            </table>
            </form> 
            
            <?php
			
			if(isset($_GET['shipme_save2'])):
				
				$search_user = trim($_GET['search_user']);
				
				$user 	= get_userdatabylogin($search_user);
				$uid 	= $user->ID;  
				
				$s = "select * from ".$wpdb->prefix."shipme_pm where initiator='$uid' OR user='$uid' order by id desc";
          		$r = $wpdb->get_results($s);
		  	
			if(count($r) > 0):
		  
		  ?>
          
           <table class="widefat post fixed" cellspacing="0">
            <thead>
            <tr>
            <th><?php _e('Sender','shipme'); ?></th>
            <th><?php _e('Receiver','shipme'); ?></th>
            <th width="20%"><?php _e('Subject','shipme'); ?></th>
            <th><?php _e('Sent On','shipme'); ?></th>
            <th><?php _e('Approved','shipme'); ?></th>
            <th width="25%"><?php _e('Options','shipme'); ?></th>
            </tr>
            </thead>
            
            
            
            <tbody>
            <?php
            
           



            
           $i = 0;
            foreach($r as $row)
            {
                $sender 	= get_userdata($row->initiator);
				$receiver 	= get_userdata($row->user);
                
				if($i%2) $new_bg_color = '#E7E9F1';
				else $new_bg_color = '#fff';
				
					$i++;
				
                echo '<tr style="background:'.$new_bg_color.'">';
				echo '<th>'.$sender->user_login.'</th>';
				echo '<th>'.$receiver->user_login.'</th>';
				echo '<th>'.$row->subject.'</th>';
				echo '<th>'.date('d-M-Y H:i:s', $row->datemade).'</th>';
				echo '<th>'.($row->approved == 1 ? __("Yes",'shipme') : __("No","shipme")).'</th>';
				echo '<th>'.($row->approved == 0 ? '<a href="'.get_admin_url().'admin.php?page=private-messages&pj='.$_GET['pj'].'&approve_message='.$row->id.'">'.__("Approve",'shipme') ."</a>" : '').'</th>';
				echo '</tr>';
            
				echo '<tr style="background:'.$new_bg_color.'">';
				echo '<th colspan="6">'.$row->content;
				
				if(!empty($row->file_attached))
				echo '<br/><br/>'.sprintf(__('File Attached: %s','shipme') , '<a href="'.wp_get_attachment_url($row->file_attached).'">'.wp_get_attachment_url($row->file_attached)."</a>") ;
	  
				
				echo '</th>';
				echo '</tr>';
							
			}
            ?>
            </tbody>
            
            
            </table>
            <?php else: ?>
            
            <div class="padd101">
            <?php _e('There are no results for your search.','shipme'); ?>
            </div>
            
            <?php endif; 
				
			
			endif;
			
			?>
          
          </div>
          
 
<?php
	echo '</div>';		
	
}


function shipme_options()
{
	global $menu_admin_shp_theme_bull;
	echo '<div class="wrap">';
	echo '<div class="icon32" id="icon-options-general2"><br/></div>';	
	echo '<h2 class="my_title_class_sitemile">ShipMe General Options</h2>';

	
	if(isset($_POST['my_submit']))
	{
		$shipme_show_job_views 			= $_POST['shipme_show_job_views'];
		$shipme_admin_approves_each_job 	= $_POST['shipme_admin_approves_each_job'];
 
		$shipme_enable_blog 					= $_POST['shipme_enable_blog'];
		$shipme_job_period 				= trim($_POST['shipme_job_period']);
		$shipme_job_period_featured 		= trim($_POST['shipme_job_period_featured']);
		$shipme_jobs_slug_link 			= trim($_POST['shipme_jobs_slug_link']);
		$shipme_location_slug_link 			= trim($_POST['shipme_location_slug_link']);
		$shipme_category_slug_link 			= trim($_POST['shipme_category_slug_link']);
		$shipme_show_blue_menu				= trim($_POST['shipme_show_blue_menu']);
		$shipme_slider_in_front				= trim($_POST['shipme_slider_in_front']);
		$shipme_custom_CSS					= trim($_POST['shipme_custom_CSS']);
		$shipme_stretch_enable				= trim($_POST['shipme_stretch_enable']);
		 
 
		$shipme_enable_job_files			= $_POST['shipme_enable_job_files'];		  
		$shipme_enable_featured_option		= $_POST['shipme_enable_featured_option'];
		$shipme_enable_sealed_option			= $_POST['shipme_enable_sealed_option'];
		$shipme_enable_hide_option			= $_POST['shipme_enable_hide_option'];
		$shipme_moderate_private_messages		= $_POST['shipme_moderate_private_messages'];
		$shipme_show_subcats_enbl				= $_POST['shipme_show_subcats_enbl'];
		$shipme_enable_multi_cats				= $_POST['shipme_enable_multi_cats'];
		$shipme_enable_credits_wallet			= $_POST['shipme_enable_credits_wallet'];
		$shipme_radius_maps_api_key			= $_POST['shipme_radius_maps_api_key'];
		
		//**********************************************************************************************  
		  
		update_option('shipme_radius_maps_api_key', 	$shipme_radius_maps_api_key);
		update_option('shipme_enable_credits_wallet', 	$shipme_enable_credits_wallet);
		update_option('shipme_enable_multi_cats', 		$shipme_enable_multi_cats);
		update_option('shipme_enable_drop_down_menu', 	$_POST['shipme_enable_drop_down_menu']);
		update_option('shipme_show_subcats_enbl', 		$shipme_show_subcats_enbl);
		update_option('shipme_moderate_private_messages', $shipme_moderate_private_messages);		 
		update_option('shipme_enable_hide_option', 		$shipme_enable_hide_option);
		update_option('shipme_enable_sealed_option', 		$shipme_enable_sealed_option);
		update_option('shipme_enable_featured_option', 	$shipme_enable_featured_option);
		update_option('shipme_enable_job_files', 		$shipme_enable_job_files);
	  
		update_option('shipme_stretch_enable',			$shipme_stretch_enable);
		update_option('shipme_custom_CSS', 				$shipme_custom_CSS);
		update_option('shipme_slider_in_front', 			$shipme_slider_in_front);
		update_option('shipme_show_blue_menu', 			$shipme_show_blue_menu);
		update_option('shipme_category_slug_link', 		$shipme_category_slug_link);
		update_option('shipme_location_slug_link', 		$shipme_location_slug_link);
		update_option('shipme_jobs_slug_link', 		$shipme_jobs_slug_link);
		update_option('shipme_job_period_featured', 	$shipme_job_period_featured);	
		update_option('shipme_job_period', 			$shipme_job_period);
 
		update_option('shipme_enable_blog', 				$shipme_enable_blog);
		update_option('shipme_show_job_views', 		$shipme_show_job_views);
		update_option('shipme_admin_approves_each_job', $shipme_admin_approves_each_job);
		
		do_action('shipme_general_settings_main_details_options_save');
		
		echo '<div class="saved_thing">Settings were saved!</div>';

	} 
	

		
	if(isset($_POST['my_submit3']))
		{
			$color_for_main_slider = $_POST['color_for_main_slider'];
			$color_for_footer = $_POST['color_for_footer'];
			$color_for_top_links = $_POST['color_for_top_links'];
			$color_for_bk = $_POST['color_for_bk'];
			$color_for_hdr = $_POST['color_for_hdr'];
			
			
			update_option('color_for_bk',$color_for_bk);
			update_option('color_for_hdr',$color_for_hdr);
			update_option('color_for_main_slider',$color_for_main_slider);
			update_option('color_for_footer',$color_for_footer);
			update_option('color_for_top_links', $color_for_top_links);
			
			echo '<div class="saved_thing">Settings were saved!</div>';
		}
		
		
		if(isset($_POST['shipme_save4']))
		{
			update_option('shipme_enable_facebook_login', 	trim($_POST['shipme_enable_facebook_login']));
			update_option('shipme_facebook_app_id', 			trim($_POST['shipme_facebook_app_id']));
			update_option('shipme_facebook_app_secret', 		trim($_POST['shipme_facebook_app_secret']));

			
			echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';
		}
		
		
		if(isset($_POST['shipme_save5']))
		{
			update_option('shipme_enable_twitter_login', 			trim($_POST['shipme_enable_twitter_login']));
			update_option('shipme_twitter_consumer_key', 			trim($_POST['shipme_twitter_consumer_key']));
			update_option('shipme_twitter_consumer_secret', 		trim($_POST['shipme_twitter_consumer_secret']));

			
			echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';
		}
		
		if(isset($_POST['shipme_save7']))
		{
			update_option('shipme_filter_emails_private_messages', 				trim($_POST['shipme_filter_emails_private_messages']));
			update_option('shipme_filter_urls_private_messages', 					trim($_POST['shipme_filter_urls_private_messages']));
		
			echo '<div class="saved_thing">'.__('Settings saved!','shipme').'</div>';
		}
	
		$arr = array("yes" => "Yes", "no" => "No");

		global $wpdb;
	//------------
	?>
	
    
    <div id="usual2" class="usual"> 
      <ul> 
        <li><a href="#tabs1" class="selected">Main Details</a></li> 
        <li><a href="#tabs2">Facebook</a></li> 
        <li><a href="#tabs3">Twitter</a></li> 
        <li><a href="#tabs4">Filters</a></li>
      </ul> 
  <div id="tabs1" style="display: block; ">
  
  <form method="post" action="">
    	<table width="100%" class="sitemile-table">
			
        
        <?php do_action('shipme_general_settings_main_details_options'); ?>    
            
            
                       
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Google API Key:</td>
        <td><input type="text" name='shipme_radius_maps_api_key' size="26" value="<?php echo get_option('shipme_radius_maps_api_key'); ?>" /></td>
        </tr>
        
 
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Enable Multiple categories when posting a project:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_multi_cats'); ?></td>
        </tr>
        
     
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Enable Job Files:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_job_files'); ?></td>
        </tr>
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Show Subitems on categories and locations pages:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_show_subcats_enbl'); ?></td>
        </tr>
        
        <tr>
        <td valign=top width="22">&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Enable Credits/e-Wallet:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_credits_wallet'); ?></td>
        </tr>
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Enable Featured Option:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_featured_option'); ?></td>
        </tr>
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Enable Sealed Bidding Option:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_sealed_option'); ?></td>
        </tr>
        
        
  
        <tr>
        <td valign=top width="22">&nbsp;</td>
        <td >&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
        
        <tr>
        <td valign=top width="22"><?php shipme_theme_bullet('If this option is set to yes, then the admin will be notified and will need to approve each private message sent before it is actually delivered.'); ?></td>
        <td >Moderate Private Messages:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_moderate_private_messages'); ?></td>
        </tr>
     
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Show views in job page:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_show_job_views'); ?></td>
        </tr>
        
                
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Admin approves each job:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_admin_approves_each_job'); ?></td>
        </tr>
        

        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Enable Blog:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_blog'); ?></td>
        </tr>
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Enable Big Main Menu:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_show_blue_menu'); ?></td>
        </tr>
        
 
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Enable Slider on Front Page:</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_slider_in_front'); ?></td>
        </tr>
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Enable Stretch Area (front page):</td>
        <td><?php echo shipme_get_option_drop_down($arr, 'shipme_stretch_enable'); ?></td>
        </tr>
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Job Listing Max Period (simple job):</td>
        <td><input type="text" name='shipme_job_period' size="6" value="<?php echo get_option('shipme_job_period'); ?>" /> days</td>
        </tr>
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Job Listing Max Period (featured job):</td>
        <td><input type="text" name='shipme_job_period_featured' size="6" value="<?php echo get_option('shipme_job_period_featured'); ?>" /> days</td>
        </tr>
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Category slug in links:</td>
        <td><input type="text" name='shipme_category_slug_link' size="16" value="<?php echo get_option('shipme_category_slug_link'); ?>" /></td>
        </tr>
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >Location slug in links:</td>
        <td><input type="text" name='shipme_location_slug_link' size="16" value="<?php echo get_option('shipme_location_slug_link'); ?>" /></td>
        </tr>
        
        

        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td >jobs slug in links:</td>
        <td><input type="text" name='shipme_jobs_slug_link' size="16" value="<?php echo get_option('shipme_jobs_slug_link'); ?>" /></td>
        </tr>
        
        
        <tr>
        <td valign=top width="22"><?php echo $menu_admin_shp_theme_bull; ?></td>
        <td valign="top" >Custom CSS:</td>
        <td><textarea rows="5" cols="55" name="shipme_custom_CSS"><?php echo htmlspecialchars(stripslashes(get_option('shipme_custom_CSS'))); ?></textarea></td>
        </tr>
        
        <tr>
        <td></td>
        <td ></td>
        <td><input type="submit"  class="button button-primary button-large" name="my_submit"   value="Save these Settings!" /></td>
        </tr>
        
        </table>
        </form>
  
  </div> 
  
  
   <div id="tabs4" >	
          
          <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=general-options&active_tab=tabs4">
            <table width="100%" class="sitemile-table">
    				
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="250"><?php _e('Filter Email Addresses (private messages):','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_filter_emails_private_messages'); ?></td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="250"><?php _e('Filter URLs (private messages):','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_filter_urls_private_messages'); ?></td>
                    </tr>
                    
                  
  
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large"   name="shipme_save7" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
          
          </div>
  
  <div id="tabs2" style="display: none; ">
  <!--
  <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=general-options&active_tab=tabs2">
            <table width="100%" class="sitemile-table">
    				
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="200"><?php _e('Enable Facebook Login:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_facebook_login'); ?></td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="250"><?php _e('Facebook App ID:','shipme'); ?></td>
                    <td><input type="text" size="35" name="shipme_facebook_app_id" value="<?php echo get_option('shipme_facebook_app_id'); ?>"/></td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="250"><?php _e('Facebook Secret Key:','shipme'); ?></td>
                    <td><input type="text" size="35" name="shipme_facebook_app_secret" value="<?php echo get_option('shipme_facebook_app_secret'); ?>"/></td>
                    </tr>
  
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save4" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form>
  --> For facebook connect, install this plugin: <a href="http://wordpress.org/extend/plugins/wordpress-social-login/">WordPress Social Login</a>
  </div> 
  <div id="tabs3" style="display: none; "> <!--
   <form method="post" action="<?php echo get_admin_url(); ?>admin.php?page=general-options&active_tab=tabs3">
            <table width="100%" class="sitemile-table">
    				
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="200"><?php _e('Enable Twitter Login:','shipme'); ?></td>
                    <td><?php echo shipme_get_option_drop_down($arr, 'shipme_enable_twitter_login'); ?></td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="250"><?php _e('Twitter Consumer Key:','shipme'); ?></td>
                    <td><input type="text" size="35" name="shipme_twitter_consumer_key" value="<?php echo get_option('shipme_twitter_consumer_key'); ?>"/></td>
                    </tr>
                    
                    <tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="250"><?php _e('Twitter Consumer Secret:','shipme'); ?></td>
                    <td><input type="text" size="35" name="shipme_twitter_consumer_secret" value="<?php echo get_option('shipme_twitter_consumer_secret'); ?>"/></td>
                    </tr>
  					
                    
                    	<tr>
                    <td valign=top width="22"><?php shipme_theme_bullet(); ?></td>
                    <td width="250"><?php _e('Callback URL:','shipme'); ?></td>
                    <td><?php echo get_bloginfo('template_url'); ?>/lib/social/twitter/callback.php</td>
                    </tr>
  
                    
                    
                    <tr>
                    <td ></td>
                    <td ></td>
                    <td><input type="submit"  class="button button-primary button-large" name="shipme_save5" value="<?php _e('Save Options','shipme'); ?>"/></td>
                    </tr>
            
            </table>      
          	</form> --> For twitter connect, install this plugin: <a href="http://wordpress.org/extend/plugins/wordpress-social-login/">WordPress Social Login</a>
  
  </div> 
</div> 
 

  
		
	<?php
	//------------
	
	echo '</div>';
	
	
}

?>