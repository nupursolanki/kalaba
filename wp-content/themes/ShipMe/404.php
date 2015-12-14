<?php
/********************************************************
*	
*	ShipMe v1.0 - sitemile.com
*	coder: andreisaioc@gmail.com
*	http://sitemile.com/p/shipme
*
********************************************************/

	get_header();
 

?>

 <div class="container_ship_ttl_wrap">	
    <div class="container_ship_ttl">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
            <?php _e('Oups. This page cannot be found.','shipme') ?>
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



<div class="container_ship_no_bk">
<div class=" col-xs-12 col-sm-12 col-lg-12">

	<ul class="virtual_sidebar">
			
			<li class="widget-container widget_text">
            	 
                <div class="my-only-widget-content">
                	<?php _e('There was an error, seems this page doesnt exist or you got the path wrong.','shipme') ?>
                </div>
           </li>
           
      </ul>


</div>
</div>


<?php get_footer(); ?>