</div>

<div id="footer">

<div id="colophon">	
	
	<?php
			get_sidebar( 'footer' );
	?>
</div>

<div id="site-info">
	<div id="site-info-inner">
				<div id="site-info-left">
					
					<h3><?php echo stripslashes(get_option('shipme_left_side_footer')); ?></h3>
					
				</div>
				<div id="site-info-right">
					<?php echo stripslashes(get_option('shipme_right_side_footer')); ?>
				</div>
			</div>
	</div>
</div>


<?php

	$shipme_enable_google_analytics = get_option('shipme_enable_google_analytics');
	if($shipme_enable_google_analytics == "yes"):		
		echo stripslashes(get_option('shipme_analytics_code'));	
	endif;
	
	//----------------
	
	$shipme_enable_other_tracking = get_option('shipme_enable_other_tracking');
	if($shipme_enable_other_tracking == "yes"):		
		echo stripslashes(get_option('shipme_other_tracking_code'));	
	endif;


?>

<?php

wp_footer();


?>

 


</body>

</html>