<?php
 
//******************************************
//
//	Shipme theme- theme started on aug 2015
//	www.sitemile.com
//
//******************************************

function shipme_theme_my_account_finances_new()
{

	ob_start();
	
	global $current_user;
	get_currentuserinfo();
	$uid = $current_user->ID;
	
	
	
?>
<div class="container_ship_ttl_wrap">	
    <div class="container_ship_ttl">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
            <?php _e('Finances','shipme') ?>
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

<?php 		echo shipme_get_users_links(); ?>

<div class="account-content-area col-xs-12 col-sm-8 col-lg-9">

		<ul class="virtual_sidebar">
        
        <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Navigate','shipme') ?></h3>
                <div class="my-only-widget-content">
             			<ul class="cms_cms">
                
                <li> <a href="<?php echo shipme_get_payments_page_url('home'); ?>" class="green_btn old_mm_k"><?php _e('Account Home','shipme'); ?></a>  </li>
               <li> <a href="<?php echo shipme_get_payments_page_url('deposit'); ?>" class="green_btn old_mm_k"><?php _e('Deposit Money','shipme'); ?></a>  </li>
              <li>  <a href="<?php echo shipme_get_payments_page_url('makepayment'); ?>" class="green_btn old_mm_k"><?php _e('Make Payment','shipme'); ?></a> </li>
                
                <?php if(shipme_is_user_business($uid)): ?>
               <li> <a href="<?php echo shipme_get_payments_page_url('escrow'); ?>" class="green_btn old_mm_k"><?php _e('Deposit Escrow','shipme'); ?></a> </li> 
                <?php endif; ?>
                
               <li> <a href="<?php echo shipme_get_payments_page_url('withdraw'); ?>" class="green_btn old_mm_k"><?php _e('Withdraw Money','shipme'); ?></a> </li> 
               <li> <a href="<?php echo shipme_get_payments_page_url('transactions'); ?>" class="green_btn old_mm_k"><?php _e('Transactions','shipme'); ?></a></li>
               <li> <a href="<?php echo shipme_get_payments_page_url('bktransfer'); ?>" class="green_btn old_mm_k"><?php _e('Bank Transfer Details','shipme'); ?></a>   </li> 
    
                  <?php do_action('shipme_financial_buttons_main') ?>
              
              	</ul>
                </div>
			</li>
        
        
		<?php
		
			$pg = $_GET['pg'];
			if(!isset($pg)) $pg = 'home';

			global $wpdb;
		
		 //****************************************************************
		 //
		 //		Home
		 //
		 //****************************************************************
		
		
		if($pg == 'home'):
		
		?>	
			<li class="widget-container widget_text balance_bg">
            	 
                <div class="my-only-widget-content">
             			<?php
							$bal = shipme_get_credits($uid);
							echo '<span class="balance">'.__("Your Current Balance is", "shipme").": ".shipme_get_show_price($bal,2)."</span>"; 
							
							
							?> 
                </div>
			</li>
     
            
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Pending Withdrawals','shipme') ?></h3>
                <div class="my-only-widget-content">
             			<?php
				
					global $wpdb;
					
					//----------------
				
					$s = "select * from ".$wpdb->prefix."project_withdraw where done='0' and rejected!='1' AND uid='$uid' order by id desc";
					$r = $wpdb->get_results($s);
					
					if(count($r) == 0) echo __('No withdrawals pending yet.','shipme');
					else
					{
						echo '<table width="100%">';
						foreach($r as $row) // = mysql_fetch_object($r))
						{

							
							echo '<tr>';
							echo '<td>'.date_i18n('d-M-Y H:i:s', $row->datemade).'</td>';
							echo '<td>'.shipme_get_show_price($row->amount).'</td>';
							echo '<td>'.$row->methods .'</td>';
							echo '<td>'.$row->payeremail .'</td>';
							echo '<td><a href="'.shipme_get_payments_page_url('closewithdrawal', $row->id).'"
							class="green_btn">'.__('Close Request','shipme'). '</a></td>';
							echo '</tr>';
							
							
						}
						echo '</table>';
						
					}
				
				?>
                </div>
			</li>
            
            
            <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Rejected Withdrawals','shipme') ?></h3>
                <div class="my-only-widget-content">
             			<?php
				
					global $wpdb;
					
					//----------------
				
					$s = "select * from ".$wpdb->prefix."project_withdraw where done='0' and rejected='1' AND uid='$uid' order by id desc";
					$r = $wpdb->get_results($s);
					
					if(count($r) == 0) echo __('No withdrawals pending yet.','shipme');
					else
					{
						echo '<table width="100%">';
						foreach($r as $row) // = mysql_fetch_object($r))
						{

							
							echo '<tr>';
							echo '<td>'.date_i18n('d-M-Y H:i:s', $row->datemade).'</td>';
							echo '<td>'.shipme_get_show_price($row->amount).'</td>';
							echo '<td>'.$row->methods .'</td>';
							echo '<td>'.$row->payeremail .'</td>';
							echo '<td> </td>';
							echo '</tr>';
							
							
						}
						echo '</table>';
						
					}
				
				?>
                </div>
			</li>
            
            
            
            
            
             <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Pending Incoming Payments','shipme') ?></h3>
                <div class="my-only-widget-content">
             			 
   				<?php
				
					$s = "select * from ".$wpdb->prefix."project_escrow where released='0' AND toid='$uid' order by id desc";
					$r = $wpdb->get_results($s);
					
					if(count($r) == 0) echo __('No payments pending yet.','shipme');
					else
					{
						echo '<table width="100%">';
						foreach($r as $row) // = mysql_fetch_object($r))
						{
							$post = get_post($row->pid);
							$from = get_userdata($row->fromid);
							
							echo '<tr>';
							echo '<td>'.$from->user_login.'</td>';
							echo '<td>'.$post->post_title.'</td>';
							echo '<td>'.date_i18n('d-M-Y H:i:s', $row->datemade).'</td>';
							echo '<td>'.shipme_get_show_price($row->amount).'</td>';
							
							echo '</tr>';
							
							
						}
						echo '</table>';
						
					}
				
				?>
                  
                </div>
			</li>
            
            
            
            
            
             <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Pending Outgoing Payments','shipme') ?></h3>
                <div class="my-only-widget-content">
             			  
   				<?php
				
					$s = "select * from ".$wpdb->prefix."project_escrow where released='0' AND toid='$uid' order by id desc";
					$r = $wpdb->get_results($s);
					
					if(count($r) == 0) echo __('No payments pending yet.','shipme');
					else
					{
						echo '<table width="100%">';
						foreach($r as $row) // = mysql_fetch_object($r))
						{
							$post = get_post($row->pid);
							$from = get_userdata($row->fromid);
							
							echo '<tr>';
							echo '<td>'.$from->user_login.'</td>';
							echo '<td>'.$post->post_title.'</td>';
							echo '<td>'.date_i18n('d-M-Y H:i:s', $row->datemade).'</td>';
							echo '<td>'.shipme_get_show_price($row->amount).'</td>';
							
							echo '</tr>';
							
							
						}
						echo '</table>';
						
					}
				
				?>
                  
                </div>
			</li>
        <?php 
		
		 //****************************************************************
		 //
		 //		Withdrawals
		 //
		 //****************************************************************
		   
            elseif($pg == 'transactions'):	
			
		?>	
        
          <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Transactions','shipme') ?></h3>
                <div class="my-only-widget-content">
             			<?php
				
					$s = "select * from ".$wpdb->prefix."project_payment_transactions where uid='$uid' order by id desc";
					$r = $wpdb->get_results($s);
					
					if(count($r) == 0) echo __('No activity yet.','shipme');
					else
					{
						$i = 0;
						echo '<table width="100%" cellpadding="5">';
						foreach($r as $row) // = mysql_fetch_object($r))
						{
							if($row->tp == 0){ $class="redred"; $sign = "-"; }
							else { $class="greengreen"; $sign = "+"; }
							
							echo '<tr style="background:'.($i%2 ? "#f2f2f2" : "#f9f9f9").'" >';
							echo '<td>'.$row->reason.'</td>';
							echo '<td width="25%">'.date_i18n('d-M-Y H:i:s',$row->datemade).'</td>';
							echo '<td width="20%" class="'.$class.'"><b>'.$sign.shipme_get_show_price($row->amount).'</b></td>';
							
							echo '</tr>';
							$i++;
						}
						
						echo '</table>';
						
						
					}
				
				?>
                </div>
			</li>
         
            
         <?php 
		 
		 //****************************************************************
		 //
		 //		deposit
		 //
		 //****************************************************************
		    
            elseif($pg == 'deposit'):	
			
		?>    
        
        
         <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Deposit Money','shipme') ?></h3>
                <div class="my-only-widget-content">
          <?php
				
				$shipme_bank_details_enable = get_option('shipme_bank_details_enable');
				if($shipme_bank_details_enable == "yes"):
				
				?>
                
                <strong><?php _e('Deposit money by Bank Transfer','shipme'); ?></strong><br/><br/>
                
                <?php echo get_option('shipme_bank_details_txt'); ?>
    			<br/><br/>
                <?php endif; ?>
                
                
            	<?php
				
				$shipme_paypal_enable = get_option('shipme_paypal_enable');
				if($shipme_paypal_enable == "yes"):
				
				?>
                
                <strong><?php _e('Deposit money by PayPal','shipme'); ?></strong><br/><br/>
                
                <form method="post" action="<?php bloginfo('siteurl'); ?>/?p_action=paypal_deposit_pay">
                <?php _e("Amount to deposit:","shipme"); ?> <input type="text" size="10" name="amount" /> <?php echo shipme_currency(); ?>
                &nbsp; &nbsp; <input type="submit" name="deposit" value="<?php _e('Deposit','shipme'); ?>" /></form>
    			<br/><br/>
                <?php endif; ?>
                <!-- ################## -->
                
                <?php
				
				$shipme_alertpay_enable = get_option('shipme_alertpay_enable');
				if($shipme_alertpay_enable == "yes"):
				
				?>
                
                <strong><?php _e('Deposit money by Payza','shipme'); ?></strong><br/><br/>
                
                <form method="post" action="<?php bloginfo('siteurl'); ?>/?p_action=payza_deposit_pay">
                <?php _e("Amount to deposit:","shipme"); ?> <input type="text" size="10" name="amount" /> <?php echo shipme_currency(); ?>
                &nbsp; &nbsp; <input type="submit" name="deposit" value="<?php _e('Deposit','shipme'); ?>" /></form>
    			<br/><br/>
                <?php endif; ?>
                
                
                
                <?php
				
				$shipme_moneybookers_enable = get_option('shipme_moneybookers_enable');
				if($shipme_moneybookers_enable == "yes"):
				
				?>
                
                
                <strong><?php _e('Deposit money by Skrill','shipme'); ?></strong><br/><br/>
                
                <form method="post" action="<?php bloginfo('siteurl'); ?>/?p_action=mb_deposit_pay">
                <?php _e("Amount to deposit:","shipme"); ?>  <input type="text" size="10" name="amount" /> <?php echo shipme_currency(); ?>
                &nbsp; &nbsp; <input type="submit" name="deposit" value="<?php _e('Deposit','shipme'); ?>" /></form>
    			<br/><br/>
                <?php endif; ?>
                
    			<?php do_action('shipme_deposit_methods', $uid); ?>
        
        		</div></li>
                
             <?php 
		 
		 //****************************************************************
		 //
		 //		Withdrawals
		 //
		 //****************************************************************
		    
            elseif($pg == 'withdraw'):	
			
		?>    
        
        
        
         <li class="widget-container widget_text">
            	<h3 class="widget-title"><?php _e('Request Withdrawal','shipme') ?></h3>
                <div class="my-only-widget-content">
             			
                <?php
				        
                global $current_user;
				get_currentuserinfo();
				$uid = $current_user->ID;
				
					$opt = get_option('shipme_paypal_enable');
					if($opt == "yes"):
					
				?>
    				 
                    <table>
                    <form method="post" enctype="application/x-www-form-urlencoded">
                    <input type="hidden" name="meth" value="PayPal" />
                    <input type="hidden" name="tm" value="<?php echo current_time('timestamp',0) ?>" />
                    <tr>
                    <td><?php echo __("Withdraw amount","shipme"); ?>:</td>
                    <td> <input value="<?php echo $_POST['amount']; ?>" type="text" 
                    size="10" name="amount" /> <?php echo shipme_currency(); ?></td>
                    </tr>
                    <tr>
                    <td><?php echo __("PayPal Email","shipme"); ?>:</td>
                    <td><input value="<?php echo get_user_meta($uid, 'paypal_email',true); ?>" type="text" size="30" name="paypal" /></td>
                    </tr>
                    
                    <tr>
                    <td></td>
                    <td>
                    <input type="submit" name="withdraw" value="<?php echo __("Withdraw","shipme"); ?>" /></td></tr></form></table>
                    
                    <?php
					endif;
					
					$opt = get_option('shipme_moneybookers_enable');
					if($opt == "yes"):
					
					?>
                        <br /><br />
                        <table>
                        <form method="post" enctype="application/x-www-form-urlencoded">
                        <input type="hidden" name="meth2" value="Moneybookers" />
                        <input type="hidden" name="tm" value="<?php echo current_time('timestamp',0) ?>" />
                        <tr>
                        <td><?php echo __("Withdraw amount","shipme"); ?>:</td>
                        <td> <input value="<?php echo $_POST['amount2']; ?>" type="text" 
                        size="10" name="amount2" /> <?php echo shipme_currency(); ?></td>
                        </tr>
                        <tr>
                        <td><?php echo __("Skrill Email","shipme"); ?>:</td>
                        <td><input value="<?php echo get_user_meta($uid, 'moneybookers_email',true); ?>" type="text" size="30" name="paypal2" /></td>
                        </tr>
                        
                        <tr>
                        <td></td>
                        <td>
                        <input type="submit" name="withdraw2" value="<?php echo __("Withdraw","shipme"); ?>" /></td></tr></form></table>
    				
					<?php endif; 
					
					
					$opt = get_option('shipme_alertpay_enable');
					if($opt == "yes"):
					
					?>
                        <br /><br />
                        <table>
                        <form method="post" enctype="application/x-www-form-urlencoded">
                        <input type="hidden" name="meth3" value="Payza" />
                        <tr>
                        <td><?php echo __("Withdraw amount","shipme"); ?>:</td>
                        <td> <input value="<?php echo $_POST['amount3']; ?>" type="text" 
                        size="10" name="amount3" /> <?php echo shipme_currency(); ?></td>
                        </tr>
                        <tr>
                        <td><?php echo __("Payza Email","shipme"); ?>:</td>
                        <td><input value="<?php echo get_user_meta($uid, 'payza_email',true); ?>" type="text" size="30" name="paypal3" /></td>
                        </tr>
                        
                        <tr>
                        <td></td>
                        <td>
                        <input type="submit" name="withdraw3" value="<?php echo __("Withdraw","shipme"); ?>" /></td></tr></form></table>
    				
					<?php endif; ?>
					
					
               <?php do_action('shipme_add_new_withdraw_methods'); ?>	
                        
                        
                </div>
			</li> 
            
            
       	<?php endif; ?>   
            
			</ul>
        
        

</div>



</div>

    
<?php

	
	
	$output = ob_get_contents();
	ob_end_clean();
	return $output;
	
}

 

?>