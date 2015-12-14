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

global $query_string;
	
	function shipme_posts_join4($join) {
		global $wp_query, $wpdb;
 
		$join .= " LEFT JOIN (
				SELECT post_id, meta_value as featured_due
				FROM $wpdb->postmeta
				WHERE meta_key =  'featured' ) AS DD
				ON $wpdb->posts.ID = DD.post_id ";

 
		return $join;
	}

//------------------------------------------------------

	function shipme_posts_orderby4( $orderby )
	{
		global $wpdb;
		$orderby = " featured_due+0 desc, $wpdb->posts.post_date desc ";
		return $orderby;
	}


	add_filter('posts_join', 	'shipme_posts_join4');
	add_filter('posts_orderby', 'shipme_posts_orderby4' );	
	
$closed = array(
		'key' => 'closed',
		'value' => "0",
		//'type' => 'numeric',
		'compare' => '='
);

$closed = array(
		'key' => 'paid',
		'value' => "1",
		//'type' => 'numeric',
		'compare' => '='
);
	
$prs_string_qu = wp_parse_args($query_string);
$prs_string_qu['meta_query'] = array($closed, $paid);
$prs_string_qu['meta_key'] = 'featured';
$prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'DESC';
		
query_posts($prs_string_qu);

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
$term_title = $term->name;
			
//======================================================

	get_header();
?>

<div class="container_ship_ttl_wrap">	
    <div class="container_ship_ttl">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
           <?php
						if(empty($term_title)) echo __("All Posted Jobs",'shipme');
						else echo sprintf( __("Latest Posted Jobs in %s",'shipme'), $term_title);
					?>
        </div>
    
        <?php 
    
            if(function_exists('bcn_display'))
            {
                echo '<div class="my_box3 no_padding  breadcrumb-wrap col-xs-12 col-sm-12 col-lg-12"> ';	
                bcn_display();
                echo '</div> ';
            }
        ?>	
    
    </div>
</div>

 



<?php
	
	$shipme_adv_code_cat_page_above_content = stripslashes(get_option('shipme_adv_code_cat_page_above_content'));
		if(!empty($shipme_adv_code_cat_page_above_content)):
		
			echo '<div class="full_width_a_div">';
			echo $shipme_adv_code_cat_page_above_content;
			echo '</div>';
		
		endif;
	
 
?>

 

<div class="container_ship_no_bk mrg_topo">
    
    
    <div class="job-content-area col-xs-12 col-sm-8 col-lg-9">
    	<ul class="virtual_sidebar" id="six-years">

<?php $i= 0; if ( have_posts() ): 
	
	echo '<li class="widget-container widget_text  "> ';
	?>
    
    <div class="head_columns">
    	 <div class="heds-area col-xs-12 col-sm-2 col-lg-2">   </div>
        
            
            <div class="heds-area  col-xs-12 col-sm-2 col-lg-2"><?php _e('Pickup','shipme') ?> </div>
             
             
             <div class="heds-area  col-xs-12 col-sm-2 col-lg-2"><?php _e('Delivery','shipme') ?></div>
            
            
            
             <div class="heds-area  col-xs-12 col-sm-2 col-lg-2"><?php _e('Budget','shipme') ?></div>
             
             
             <div class="heds-area  col-xs-12 col-sm-2 col-lg-2"><?php _e('Time Due','shipme') ?> </div>
             
             
                  
    </div>
    
    <?php
	while ( have_posts() ) : the_post(); ?>

	<?php shipme_get_regular_job_post('zubs' . ($i%2)); 
			$i++; ?>

	<?php  
 		endwhile; 
		
		echo '</li>';
		
		
		if(function_exists('wp_pagenavi')):
			echo '<li class="widget-container widget_text  "> <div class="my-only-widget-content " >';
			wp_pagenavi(); 
			echo '</div></li>';
		endif;
		                             
     	else:
		
		echo '<li class="widget-container widget_text  "> <div class="my-only-widget-content " >';
		echo __('No jobs posted and active on the site yet.',"shipme");
		echo '</div></li>';
		
		endif;
		// Reset Post Data
		wp_reset_postdata();
		 
		?>


</ul>
</div>



    <div id="left-sidebar" class="account-right-sidebar col-xs-12 col-sm-4 col-lg-3  ">
    <ul class="virtual_sidebar" id="six-years2">
        <?php dynamic_sidebar( 'other-page-area' ); ?>
    </ul>
	</div>




</div> 

<?php

	get_footer();

?>