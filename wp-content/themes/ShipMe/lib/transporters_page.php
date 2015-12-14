<?php

function shipme_transporters_page()
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

<div class="container_ship_no_bk">
	<ul class="virtual_sidebar">
			
			<li class="widget-container widget_text"> 
                <div class="my-only-widget-content">
 			
            </div>
            </li></ul>
</div>


<?php

	
	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
 


}


?>