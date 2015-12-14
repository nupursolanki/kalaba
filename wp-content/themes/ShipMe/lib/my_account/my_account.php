<?php
//******************************************
//
//	Shipme theme- theme started on aug 2015
//	www.sitemile.com
//
//******************************************

function shipme_theme_my_account_home_new()
{

	ob_start();
	
	global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;
	
	
	
?>
<div class="container_ship_ttl_wrap">	
    <div class="container_ship_ttl">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
            <?php the_title() ?>
        </div>
    
        <?php 
    
            if(function_exists('bcn_display'))
            {
                echo '<div class="my_box3 no_padding  breadcrumb-wrap col-xs-12 col-sm-12 col-lg-12"><div class="padd10a">';	
                bcn_display();
                echo '</div></div>';
            }
        ?>	
    
    </div>
</div>

<?php
	
	if ( current_user_can( 'manage_options' ) ) {
		echo '<div class="total-content-area note-note ">'.__('You are logged in as administrator, and you should be both menus (transporter and contractor). Regular users see one or the other depending on their role.','shipme').'</div>'	;
	}


?>

<div class="container_ship_no_bk">

<?php 		echo shipme_get_users_links(); ?>

<div class="account-content-area col-xs-12 col-sm-8 col-lg-9">

		<ul class="virtual_sidebar">
			
			<li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('My Latest Active Jobs','shipme') ?></h3>
                <div class="my-only-widget-content">
             			 <?php
							
			 
				global $wp_query;
				$query_vars = $wp_query->query_vars;
				$post_per_page = 5;				
				$i = 2;
					
				$closed = array(
						'key' => 'closed',
						'value' => "0",
						'compare' => '='
					);	
					
				$paid = array(
						'key' => 'paid',
						'value' => "1",
						'compare' => '='
					);		
				
				$args = array('post_type' => 'job_ship', 'author' => $uid, 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $post_per_page,
				'paged' => 1, 'meta_query' => array($paid, $closed), 'post_status' =>array('draft','publish') );
				
				query_posts($args);

				if(have_posts()) :
				shipme_table_head_thing();
				while ( have_posts() ) : the_post(); $i++;
					shipme_get_regular_job_post_account('zubs' . ($i%2));
				endwhile;
				
				//if(function_exists('wp_pagenavi')):
				//wp_pagenavi(); endif;
				
				 else:
				
				echo '<div class="my_box3"> <div class="box_content"> ';
				_e("There are no jobs yet.",'shipme');
				echo '</div></div>';
				
				endif;
				
				wp_reset_query();

				
				?>

          
                </div>
			</li>
            
            
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Latest Received Proposals','shipme') ?></h3>
                <div class="my-only-widget-content">
             			There are no proposals yet.
                </div>
			</li>
            
            
            
                 
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Latest Posted Proposals','shipme') ?></h3>
                <div class="my-only-widget-content">
             			There are no proposals yet.
                </div>
			</li>
            
            
            
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Latest Unpublished Jobs','shipme') ?></h3>
                <div class="my-only-widget-content">
             			            			 <?php
							
			 
				global $wp_query;
				$query_vars = $wp_query->query_vars;
				$post_per_page = 5;				
				$i = 2;
					
				$closed = array(
						'key' => 'closed',
						'value' => "0",
						'compare' => '='
					);	
					
				$paid = array(
						'key' => 'paid',
						'value' => "0",
						'compare' => '='
					);		
				
				$args = array('post_type' => 'job_ship', 'author' => $uid, 'order' => 'DESC', 'orderby' => 'date', 'posts_per_page' => $post_per_page,
				'paged' => 1, 'meta_query' => array($paid, $closed), 'post_status' =>array('draft','publish') );
				
				query_posts($args);

				if(have_posts()) :
				shipme_table_head_thing();
				while ( have_posts() ) : the_post(); $i++;
					shipme_get_regular_job_post_account('zubs' . ($i%2));
				endwhile;
				
				//if(function_exists('wp_pagenavi')):
				//wp_pagenavi(); endif;
				
				 else:
				
				echo '<div class="my_box3"> <div class="box_content"> ';
				_e("There are no unpublished jobs yet.",'shipme');
				echo '</div></div>';
				
				endif;
				
				wp_reset_query();

				
				?>
                </div>
			</li>
            
            
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Latest Closed Jobs','shipme') ?></h3>
                <div class="my-only-widget-content">
             			<?php

							query_posts( "meta_key=closed&meta_value=1&post_type=job_ship&order=DESC&orderby=id&author=".$uid."&posts_per_page=3" );
							$i = 2;
			
							if(have_posts()) :
							while ( have_posts() ) : the_post();
								shipme_table_head_thing();
								shipme_get_regular_job_post_account('zubs' . ($i%2));
							endwhile; else:
							
							echo '<div class="my_box3"><div class="box_content">';
							_e("There are no closed jobs yet.",'ProjectTheme');
							echo '</div></div>';
							
							endif;
							wp_reset_query();
							
				?>
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