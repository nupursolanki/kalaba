<?php
//******************************************
//
//	Shipme theme- theme started on aug 2015
//	www.sitemile.com
//
//******************************************

function shipme_theme_my_account_pending_jobs_fnc()
{

	ob_start();
	
	global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;
	
	
	
?>
<div class="container_ship_ttl_wrap">	
    <div class="container_ship_ttl">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
            <?php the_title(); ?>
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
                <div class="my-only-widget-content">
             			 
			 
			 
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