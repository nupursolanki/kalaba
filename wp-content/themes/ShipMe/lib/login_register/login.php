<?php
//******************************************
//
//	Shipme theme- theme started on aug 2015
//	www.sitemile.com
//
//******************************************

if(!function_exists('shipme_do_login_scr'))
{
function shipme_do_login_scr()
		{
		  
		  	/*do_action( 'login_enqueue_scripts' );
			do_action( 'login_head' );
		  	do_action('login_footer');
		  */
		  
		  global $wpdb, $error, $wp_query ;
		
		  if (!is_array($wp_query->query_vars))
			$wp_query->query_vars = array();
		  
		  $action = $_REQUEST['action'];
		  $error = '';
		  
		  nocache_headers();
		  
		  header('Content-Type: '.get_bloginfo('html_type').'; charset='.get_bloginfo('charset'));
		  
		  if ( defined('RELOCATE') ) 
		  { // Move flag is set
			if ( isset( $_SERVER['PATH_INFO'] ) && ($_SERVER['PATH_INFO'] != $_SERVER['PHP_SELF']) )
				$_SERVER['PHP_SELF'] = str_replace( $_SERVER['PATH_INFO'], '', $_SERVER['PHP_SELF'] );
		  
			$schema = ( isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ) ? 'https://' : 'http://';
			if ( dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) != get_settings('siteurl') )
				update_option('siteurl', dirname($schema . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']) );
		  }
		
		do_action( 'login_init' );
			do_action( 'login_form_' . $action );
		
		
		  switch($_REQUEST["action"])
		  {
			//logout
			case "logout":
				wp_clearcookie();
			  if(get_option("jk_logout_redirect_to"))
				$redirect_to = get_option("jk_logout_redirect_to");
			  else
				$redirect_to = "wp-login.php";
				do_action('wp_logout');
				nocache_headers();
			
				if ( isset($_REQUEST['redirect_to']) )
					$redirect_to = $_REQUEST['redirect_to'];
				
			  wp_redirect(get_bloginfo('siteurl'));
				exit();
			break;
		
			//lost lost password
			case 'lostpassword':
			case 'retrievepassword':
			
			$http_post = ('POST' == $_SERVER['REQUEST_METHOD']);
			
		 
			
			if ( $http_post ) {  
				$errors = my_retrieve_password();
				if ( !is_wp_error($errors) ) {
					$redirect_to = !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : 'wp-login.php?checkemail=confirm';
					wp_safe_redirect( $redirect_to );
					exit();
				}
			}

			if ( isset($_GET['error']) && 'invalidkey' == $_GET['error'] ) $errors->add('invalidkey', __('Sorry, that key does not appear to be valid.', 'shipme'));
			$redirect_to = apply_filters( 'lostpassword_redirect', !empty( $_REQUEST['redirect_to'] ) ? $_REQUEST['redirect_to'] : '' );
		
			do_action('lost_password');
			$user_login = isset($_POST['user_login']) ? stripslashes($_POST['user_login']) : '';
			
			
			global $real_ttl;
			$real_ttl = __("Retrieve Password", 'shipme');			
			add_filter( 'wp_title', 'shipme_sitemile_filter_ttl', 10, 3 );	
			
			get_header();
				
		  
				
		?>
        
          <div class="container_ship_no_bk margin_top_40">
        
        	<ul class="virtual_sidebar">
			
			<li class="widget-container widget_text"><h3 class="widget-title"><?php _e("Retrieve Password",'shipme'); ?> - <?php echo  get_bloginfo('name'); ?></h3>
			<div class="my-only-widget-content ">
            
            
        
 
                
						<?php if ( isset($errors) && isset($_POST['action']) ) : ?>
						  <div class="bam_bam"> <div class="error">
							<ul>
							<?php 
							 
							$me = $errors->get_error_messages();
					 
						 	foreach($me as $mm)
							 echo "<li>".($mm)."</li>";
							
							
							 
							?>
							</ul>
						  </div> </div>
						  <?php endif; ?>
                          
                          
                <div class="login-submit-form"> 
				<form name="lostpass" action="<?php echo esc_url( site_url( 'wp-login.php?action=lostpassword', 'login_post' ) ); ?>" method="post" id="lostpass">
					
               
					<p><?php _e('Please enter your information here. We will send you a new password.','shipme'); ?></p>
					<?php if ($error) {echo "<div id='login_error'>$error</div>";} ?>
					<input type="hidden" name="action" value="retrievepassword" />
					  
					  
					<p>
					<label><?php _e('Mobile Number or Email:','shipme') ?></label>
                    <input type="text" class="do_input" name="user_login" id="user_login" value="" size="30" tabindex="1" />
                    </p>
                 
                  
                  	<?php do_action('lostpassword_form'); ?>
                  
					<p><label>&nbsp;</label>
					<a href="" class="submit_bottom2"  onClick="document.getElementById('lostpass').submit(); return false;"><i class="fa fa-check-circle"></i> <?php _e('Retrieve Password','shipme'); ?></a>
                    </p>
                   
				</form>
                    
                </div>
                    
                    
					<ul id="logins">
					<li><a class="green_btn" href="<?php echo esc_url( home_url() ); ?>/" title="<?php _e('Are you lost?','shipme') ?>">&laquo; <?php _e('Home','shipme') ?></a></li>
					<?php if (get_settings('users_can_register')) : ?>
					<li><a class="green_btn" href="<?php echo esc_url( site_url() ); ?>/wp-login.php?action=register"><?php _e('Register','shipme') ?></a></li>
					<?php endif; ?>
					<li><a class="green_btn" href="<?php echo esc_url( site_url() ); ?>/wp-login.php"><?php _e('Login','shipme') ?></a></li>
					</ul>
				
                
         
              
            </div>
            </li>
            </ul>
            
            </div>
                
		<?php
				
		
				
				get_footer();		
				die();
				
			break;
			
			case 'retrievepassword2': 
			
				global $real_ttl;
				$real_ttl = __("Retrieve Error", 'shipme');			
				add_filter( 'wp_title', 'shipme_sitemile_filter_ttl', 10, 3 );	
			
				
				get_header();
					
			
				$user_data = get_userdatabylogin($_POST['user_login']);
				// redefining user_login ensures we return the right case in the email
				$user_login = $user_data->user_login;
				$user_email = $user_data->user_email;
			
				if (!$user_email || $user_email != $_POST['email'])

				{
					
					
					
					?>
                    
                <div class="my_box3 breadcrumb-wrap">
            
            	<div class="box_title"><?php _e("Retrieve Error",'shipme'); ?> - <?php echo  get_bloginfo('name'); ?></div>
                <div class="box_content">
                    
                    <br/><br/>
                    <?php
					echo sprintf(__('Sorry, that user does not seem to exist in our database. Perhaps you have the wrong Mobile Number or e-mail address? <a href="%s">Try again</a>.','shipme'), 'wp-login.php?action=lostpassword');
					
					?>
					
					<br/><br/>
					&nbsp;
					
					</div></div>
					<?php
					
					get_footer();
					die();
				}
			
			  do_action('retreive_password', $user_login);  // Misspelled and deprecated.
			  do_action('retrieve_password', $user_login);
			
				// Generate something random for a password... md5'ing current time with a rand salt
				$key = substr( md5( uniqid( current_time('timestamp',0) ) ), 0, 50);
				// now insert the new pass md5'd into the db
				$wpdb->query("UPDATE $wpdb->users SET user_activation_key = '$key' WHERE user_login = '$user_login'");
				$message = __('Someone has asked to reset the password for the following site and username.','shipme') . "\r\n\r\n";
				$message .= get_option('siteurl') . "\r\n\r\n";
				$message .= sprintf(__('Mobile Number: %s','shipme'), $user_login) . "\r\n\r\n";
				$message .= __('To reset your password visit the following address, otherwise just ignore this email and nothing will happen.'
				,'shipme') . "\r\n\r\n";
				$message .= get_settings('siteurl') . "/wp-login.php?action=resetpass&key=$key\r\n";
			
				$m = wp_mail($user_email, sprintf(__('[%s] Password Reset','shipme'), get_settings('blogname')), $message);
			
				echo get_option("jk_login_after_head_html");
			  echo "          <div id=\"login\">\n";
				if ($m == false) 
			  {
				echo "<h1>".__("There Was a Problem",'shipme')."</h1>";
				  echo '<p>' . __('The e-mail could not be sent.','shipme') . "<br />\n";
				echo  __('Possible reason: your host may have disabled the mail() function...','shipme') . "</p>";
				} 
			  else 
			  {
				echo "<h1>Success!</h1>";
					echo '<p>' .  sprintf(__("The e-mail was sent successfully to %s's e-mail address.",'shipme'), $user_login) . '<br />';
					echo  "<a href='wp-login.php' title='" . __('Check your e-mail first, of course','shipme') . "'>" . 
					__('Click here to login!','shipme') . '</a></p>';
				}
			  echo "          </div>\n";


				echo '</div></div></div>';
				get_footer();
		
				die();
			break;
			
			//reset password
			case 'rp' :
				
				global $real_ttl;
				$real_ttl = __("Key Not Valid", 'shipme');			
				add_filter( 'wp_title', 'shipme_sitemile_filter_ttl', 10, 3 );	
			
				get_header();
				//_get_whole_menu();
				
				echo '<div class="my_box3 breadcrumb-wrap">
            	<div class="padd10">';
				
		
			  echo "          <div id=\"login\">\n";
				// Generate something random for a password... md5'ing current time with a rand salt
				$key = preg_replace('/a-z0-9/i', '', $_GET['key']);
				if ( empty($key) )
			  {
				_e('<h1>Problem</h1>','shipme');
					_e('Sorry, that key does not appear to be valid.','shipme');
				echo "          </div>\n";
		
		
				echo '</div></td></tr></table></div></div>';
				get_footer();
		
				die();
			  }
				$user = $wpdb->get_row("SELECT * FROM $wpdb->users WHERE user_activation_key = '$key'");
				if ( !$user )
			  {
				_e('<h1>Problem</h1>','shipme');
					_e('Sorry, that key does not appear to be valid.','shipme');
				echo "          </div>\n";


				echo '</div></div>';
				get_footer();
		
				die();
			  }
			
				do_action('password_reset');
			
				$new_pass = substr( md5( uniqid( current_time('timestamp',0) ) ), 0, 7);
				$wpdb->query("UPDATE $wpdb->users SET user_pass = MD5('$new_pass'), user_activation_key = '' WHERE user_login = '$user->user_login'");
				wp_cache_delete($user->ID, 'users');
				wp_cache_delete($user->user_login, 'userlogins');	
				$message  = sprintf(__('Mobile Number: %s','shipme'), $user->user_login) . "\r\n";
				$message .= sprintf(__('Password: %s','shipme'), $new_pass) . "\r\n";
				$message .= get_settings('siteurl') . "/wp-login.php\r\n";
			
				$m = wp_mail($user->user_email, sprintf(__('[%s] Your new password','shipme'), get_settings('blogname')), $message);
			
				if ($m == false) 
			  {
				echo __('<h1>Problem</h1>','shipme');
					echo '<p>' . __('The e-mail could not be sent.','shipme') . "<br />\n";
					echo  __('Possible reason: your host may have disabled the mail() function...','shipme') . '</p>';
				} 
			  else 
			  {
				echo __('<h1>Success!</h1>','shipme');
					echo '<p>' .  sprintf(__('Your new password is in the mail.','shipme'), $user_login) . '<br />';
				echo  "<a href='wp-login.php' title='" . __('Check your e-mail first, of course','shipme') . "'>" . 
				__('Click here to login!','shipme') . '</a></p>';
					// send a copy of password change notification to the admin
					$message = sprintf(__('Password Lost and Changed for user: %s','shipme'), $user->user_login) . "\r\n";
					wp_mail(get_settings('admin_email'), sprintf(__('[%s] Password Lost/Change','shipme'), get_settings('blogname')), $message);
				}
			  echo "          </div>\n";
			
			
			echo '</div></div></div>';
				get_footer();
				
		
				die();
			break;
			
			//login and default action
			case 'login' : 
			default:
			
			 //check credentials - 99% of this is identical to the normal wordpress login sequence as of 2.0.4
			  //Any differences will be noted with end of line comments. 
				$user_login = '';
				$user_pass = '';
				$using_cookie = false;
				/**
				 * this is what the code was
				 * if ( !isset( $_REQUEST['redirect_to'] ) )
				 * 	$redirect_to = 'wp-admin/';
				 * else
				 * 	$redirect_to = $_REQUEST['redirect_to'];
				 */
				 if ( empty( $_REQUEST['redirect_to'] ) ) {
					$redirect_to = get_permalink(get_option('shipme_account_page_id'));
				 } else {
					$redirect_to = $_REQUEST['redirect_to'];
				 }
				 
				 if(empty($redirect_to)) $redirect_to = get_permalink(get_option('shipme_account_page_id'));
				 
				 //print_r($_REQUEST); // $redirect_to;
				 //exit;
				 
				 if(isset($_SESSION['redirect_me_back'])) $redirect_to = $_SESSION['redirect_me_back'];
		
				if( $_POST ) {
					$user_login = $_POST['log'];
					$user_login = sanitize_user( $user_login );
					$user_pass  = $_POST['pwd'];
					$rememberme = $_POST['rememberme'];
				} else {
					if (function_exists('wp_get_cookie_login'))		//This check was added in version 1.0 to make the plugin compatible with WP2.0.1
					{
						$cookie_login = wp_get_cookie_login();
						if ( ! empty($cookie_login) ) {
							$using_cookie = true;
							$user_login = $cookie_login['login'];
							$user_pass = $cookie_login['password'];
						}
					}
					elseif ( !empty($_COOKIE) ) //This was added in version 1.0 to make the plugin compatible with WP2.0.1
					{
						if ( !empty($_COOKIE[USER_COOKIE]) )
							$user_login = $_COOKIE[USER_COOKIE];
						if ( !empty($_COOKIE[PASS_COOKIE]) ) {
							$user_pass = $_COOKIE[PASS_COOKIE];
							$using_cookie = true;
						}
					}
				}
			
				do_action('wp_authenticate',  $user_login, $user_pass);
				if ( $user_login && $user_pass ) {
					$user = new WP_User(0, $user_login);
				
					// If the user can't edit posts, send them to their profile.
					//if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' ) )
					//	$redirect_to = get_settings('siteurl') . '/' . 'my-account';
				
					if ( wp_login($user_login, $user_pass, $using_cookie) ) {
						if ( !$using_cookie )
							wp_setcookie($user_login, $user_pass, false, '', '', $rememberme);
						do_action('wp_login', $user_login);
						wp_redirect($redirect_to);
						exit;
					} else {
						if ( $using_cookie )			
							$error = __('Your session has expired.','shipme');
					}
				} else if ( $user_login || $user_pass ) {
					$error = __('<strong>Error</strong>: The password field is empty.','shipme');
		
				}
		
				global $real_ttl;
				$real_ttl = __("Login", 'shipme');			
				add_filter( 'wp_title', 'shipme_sitemile_filter_ttl', 10, 3 );	
		
	 
		
				get_header();
				
				
				
		?>
        
        <div class="container_ship_no_bk margin_top_40">
        
        	<ul class="virtual_sidebar">
			
			<li class="widget-container widget_text"><h3 class="widget-title"><?php _e("Login",'shipme'); ?> - <?php echo  get_bloginfo('name'); ?></h3>
			<div class="my-only-widget-content ">
        
					
         
                
           		<?php
				if(isset($_GET['checkemail']) && $_GET['checkemail'] == "confirm"):
				?>
					
                    <div class="check-email-div"><div class="padd10">
                    <?php _e('We have sent a confirmation message to your email address.<br/>
					Please follow the instructions in the email and get back to this page.','shipme'); ?>                    
                    </div></div>
                
				
				<?php	
				endif;
				
				
				?>
						  
				  <?php if (! empty($error) ) : ?>
						  <div class="bam_bam"><div class="error"><ul>
							<?php echo "<li>$error</li>"; ?>
							</ul>
						  </div></div>
						  <?php endif; ?>
                 
                <div class="login-submit-form"> 
                          
				<form name="loginform" id="loginform" action="<?php echo esc_url( site_url( 'wp-login.php', 'login_post' ) ); ?>" method="post">
				<p><label><?php _e('Mobile Number:','shipme') ?></label>
				<input class="do_input" type="text" name="log" id="log" value="<?php echo esc_html(stripslashes($user_login), 1); ?>" size="30"  />
                </p>
							
                            
				<p><label><?php _e('Password:','shipme'); ?></label>
				<input class="do_input" type="password" name="pwd" id="login_password" value="" size="30"  />
				</p>
							
				<p><label>&nbsp;</label>
				<input class="do_input" name="rememberme" type="checkbox" id="rememberme" value="true" tabindex="3" /> 
				<?php _e('Keep me logged in','shipme'); ?>
                </p>
							
							 
                <?php do_action('login_form'); ?>
                             
                <input type="hidden" name="testcookie" value="1" />             
				<p><label>&nbsp;</label>
				<a href="#" class="submit_bottom2" onClick="document.getElementById('loginform').submit();"  ><i class="fa fa-check-circle"></i> <?php _e('Sign in','shipme'); ?></a>
				<input type="hidden" name="redirect_to" value="<?php echo $_GET['redirect_to']; ?>" />
				</p>
							
                </form>
				
                <ul id="logins">
							<li><a class="green_btn" href="<?php echo esc_url( home_url() ); ?>/" 
                            title="<?php _e('Are you lost?','shipme') ?>">&laquo; <?php _e('Home','shipme') ?></a></li>
						  <?php if (get_settings('users_can_register')) : ?>
							<li><a class="green_btn" href="<?php echo esc_url( site_url() ); ?>/wp-login.php?action=register"><?php _e('Register','shipme') ?></a></li>
						  <?php endif; ?>
<!--							<li><a class="green_btn" href="<?php //echo esc_url( site_url() ); ?>/wp-login.php?action=lostpassword" 
                            title="<?php //_e('Password Lost and Found','shipme') ?>"><?php _e('Lost your password?','shipme') ?></a></li>-->
              	</ul>
						
		
				</div>

            </div>
            </li>
            </ul>
            
            </div>
		
		
		<?php

				get_footer();
		
				die();
			break;
		  }
		}
}



?>