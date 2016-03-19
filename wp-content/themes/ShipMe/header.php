	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes('xhtml'); ?> >
	<head>
	 <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0"> 
    
	<title>
	<?php wp_title(); ?>
    </title>
    	
        <link href='http://fonts.googleapis.com/css?family=Rubik:500,400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
         <link href='http://fonts.googleapis.com/css?family=Bitter:400,700' rel='stylesheet' type='text/css'>
     <link href='http://fonts.googleapis.com/css?family=Cabin+Condensed:400,500,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,900' rel='stylesheet' type='text/css'>
 	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
 	<link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,900,700,500' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Alegreya+Sans+SC:400,700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Cabin:400,500,600' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,300,700' rel='stylesheet' type='text/css'>
    
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
   
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head() ?>
    <script src="<?php bloginfo('template_url') ?>/js/vegas.min.js"></script>
    <link href="<?php bloginfo('template_url') ?>/css/vegas.css" rel="stylesheet">
    
	<script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/jetmenu.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/jquery.countdown.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url') ?>/js/general.js"></script>
    <link href="<?php bloginfo('template_url') ?>/css/jetmenu.css" rel="stylesheet" >

         <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/stylesheet.css" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'template_url' ); ?>/css/media-stylesheet.css" />
    
    
	<script type="text/javascript">
jQuery(document).ready(function(){  
	jQuery('.expiration_project_p').each(function(index) 
	{
		var until_now = jQuery(this).html();
		jQuery(this).countdown({until: until_now, format: 'dHMS', compact: false});
	});
				jQuery().jetmenu();			
				<?php if(is_front_page()): ?>		
				jQuery(".header_part").vegas({
					slides: [
						{ src: "<?php bloginfo('template_url') ?>/images/City3.png" },
						{ src: "<?php bloginfo('template_url') ?>/images/City.png" },
						{ src: "<?php bloginfo('template_url') ?>/images/City2.png" } ,
						{ src: "<?php bloginfo('template_url') ?>/images/City4.png" } 
					]
				});
				<?php endif; ?>		
			});
		</script>

    
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="<?php bloginfo('template_url'); ?>/js/bootstrap.min.js"></script>

    
    <?php if(!is_front_page()): ?>
    <style>
	
		.header_part
		{
			background-image:none;
			background:#fff;	
		}
		
		.jetmenu > li > a
		{
			color:#222;
			font-weight:400;
			font-size:15px;
			font-family:'Roboto Condensed'
		}
		
		a.pst_njb:link, a.pst_njb:visited
		{
			border-color: #555	
		}
	
	</style>
  		<?php endif; ?>
	</head>
	<body <?php body_class(); ?> >
    <?php error_reporting(0); ?>
    <div class="header_part" >
    	<?php
		$shipme_front_slider_enable = get_option('shipme_front_slider_enable');
		if(is_front_page() && $shipme_front_slider_enable == "no")
		{
                    echo '<style>.alright_element { display:none } .header_part { height:auto }</style>';
		}
		?>
        <div id="header_ship"  >
        	<div id="logo_ship">
            <?php if(is_front_page()):
			$shipme_logo_URL = get_option('shipme_logo_URL');
			if(empty($shipme_logo_URL)) $logo1 = get_bloginfo('template_url').'/images/logo.png';
			else $logo1 = $shipme_logo_URL;
			?>
            	<a href="<?php bloginfo('siteurl') ?>"><img id="logo_file" src="<?php echo $logo1 ?>" /></a>
                <?php else:
			$shipme_logo_URL2 = get_option('shipme_logo_URL2');
			if(empty($shipme_logo_URL2)) $logo2 = get_bloginfo('template_url').'/images/logo2.png';
			else $logo2 = $shipme_logo_URL2;
				?>
            	<a href="<?php bloginfo('siteurl') ?>"><img id="logo_file" src="<?php echo $logo2 ?>" /></a>
                <?php endif; ?>
            </div>
            <div id="menu_ship">
            	<ul id="jetmenu1" class="jetmenu blue">
                    <?php		
			$menu_name = 'primary-shipme-header';
			if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) 
			$nav_menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
			wp_nav_menu( array( 'menu' => $nav_menu, 'container' => false, 'items_wrap' => '%3$s' ) );
                     ?>
                    <?php
                      $currentuser = wp_get_current_user();
                      $currentUserNamr=$currentuser->first_name;
                      if($currentUserNamr !='' || $currentUserNamr !=null){
                    ?><li><a href=""><?php echo $currentUserNamr; ?></a>
                    <?php }
                    else{ 
                    ?>
                    <li><a href=""><?php _e('Account','shipme') ?></a>
                        <?php } 
                    ?>
                    	<ul class="dropdown">
                        <?php if(is_user_logged_in()): ?>
                                <?php if(current_user_can( 'manage_options' )) : ?><li><a href="<?php echo get_admin_url() ?>"><?php _e('Admin Dashboard','shipme') ?></a></li> <?php endif; ?>
                                <li><a href="<?php echo get_permalink(get_option('shipme_account_page_id')) ?>"><?php _e('My Account','shipme') ?></a></li>
                                <li><a href="<?php echo wp_logout_url() ?>"><?php _e('Sign Out','shipme') ?></a></li>
                        <?php else: ?>
                                <?php $encodedParam = urlencode($_SERVER['REQUEST_URI']); ?>
                                <li><a href="<?php echo wp_login_url() ?>?redirect_to=<?php echo $encodedParam ?>"><?php _e('Sign In','shipme') ?></a></li>
                                <li><a href="<?php echo wp_registration_url() ?>"><?php _e('Register','shipme') ?></a></li>
                        <?php endif; ?>
                        </ul>                    
                    </li>
                    <li><a class="pst_njb" href="<?php echo get_permalink(get_option('shipme_post_new_page_id')) ?>"><?php _e('Post New Job','shipme') ?></a></li>
                </ul>
            </div>
        </div>
        
        <?php if(is_front_page()): ?>
        <div class="alright_element">
                <div id="message_ship" style="<?php $shipme_text_caption_1_color = get_option('shipme_text_caption_1_color'); echo (empty($shipme_text_caption_1_color) ? "" : "color: " . $shipme_text_caption_1_color) ?>">
                    <?php 
					
					$shipme_text_caption_1 = get_option('shipme_text_caption_1');
					$shipme_text_caption_2 = get_option('shipme_text_caption_2');
					$shipme_text_caption_3 = get_option('shipme_text_caption_3');
					$shipme_button_link = get_option('shipme_button_link');
                                        echo $shipme_text_caption_1; ?>        
                </div>
                
                <div id="sub_message_ship" style="<?php $shipme_text_caption_2_color = get_option('shipme_text_caption_2_color'); echo (empty($shipme_text_caption_2_color) ? "" : "color: " . $shipme_text_caption_2_color) ?>">
                    <?php echo $shipme_text_caption_2; ?>         
                </div>
                  <div id="button_ship">
                    <a style="<?php $shipme_button_color = get_option('shipme_button_color'); echo (empty($shipme_button_color) ? "" : "color: " . $shipme_button_color) ?>"
                     href="<?php echo $shipme_button_link ?>" class="list_package"><?php echo $shipme_text_caption_3; ?></a>        
                </div>
      	</div>
		<?php endif; ?>
    </div>
    <div id="total_total">