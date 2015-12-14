<?php

	$opt = get_option('shipme_new_emails_135');
	if(empty($opt)):
		
		update_option('shipme_new_emails_135', 'DonE');
		
		update_option('shipme_new_user_email_subject', 'Welcome to ##your_site_name##');
		update_option('shipme_new_user_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																'Welcome to our website.'.PHP_EOL.
																'Your username: ##username##'.PHP_EOL.
																'Your password: ##user_password##'.PHP_EOL.PHP_EOL.
																'Login here: ##site_login_url##'.PHP_EOL.PHP_EOL.
																'Thank you,'.PHP_EOL.
																'##your_site_name## Team');
	
		//-----------------------------------------------------------------------------------------------------------
		
		update_option('shipme_new_user_email_admin_subject', 'New user registration on your site');
		update_option('shipme_new_user_email_admin_message', 'Hello admin,'.PHP_EOL.PHP_EOL.
																	'A new user has been registered on your website.'.PHP_EOL.
																	'See the details below:'.PHP_EOL.PHP_EOL.
																	'Username: ##username##'.PHP_EOL.
																	'Email: ##user_email##');
																	
		//------------------------------------------------------------------------------------------------------------
		
		update_option('shipme_new_job_email_approve_admin_subject', 'New job posted: ##job_name##');
		update_option('shipme_new_job_email_approve_admin_message', 'Hello admin,'.PHP_EOL.PHP_EOL.
																				'The user ##username## has posted a new job on your website.'.PHP_EOL.
																				'The job name: [##job_name##]'.PHP_EOL.
																				'The job was automatically approve on your website.'.PHP_EOL.PHP_EOL.																				
																				'View the job here: ##job_link##'.PHP_EOL.PHP_EOL.																				
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
		
		//------------------------------------------------------------------------------------------------------------
		
		update_option('shipme_new_job_email_not_approve_admin_subject', 'New job posted. Must approve ##job_name##');
		update_option('shipme_new_job_email_not_approve_admin_message', 'Hello admin,'.PHP_EOL.PHP_EOL.
																			'The user ##username## has posted a new job on your website.'.PHP_EOL.
																			'The job name: <b>##job_name##</b> '.PHP_EOL.
																			'The job is not automatically approved so you have to manually approve the job before it appears on your website.'.PHP_EOL.PHP_EOL.																			
																			'You can approve the job by going to your admin dashboard in your website'.PHP_EOL.
																			'Go here: ##your_site_url##/wp-admin');
		
		//------------------------------------------------------------------------------------------------------------
		
		update_option('shipme_new_job_email_not_approved_subject', 'Your new job posted, but not yet approved: ##job_name##');
		update_option('shipme_new_job_email_not_approved_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.																			
																			'Your job <b>##job_name##</b> has been posted on the website. However it is not live yet.'.PHP_EOL.
																			'The job needs to be approved by the admin before it goes live. '.PHP_EOL.
																			'You will be notified by email when the job is active and published.'.PHP_EOL.PHP_EOL.																			
																			'After is approved the job will appear here: ##job_link##'.PHP_EOL.PHP_EOL.																			
																			'Thank you,'.PHP_EOL.
																			'##your_site_name## Team');
																			
		//--------------------------------------------------------------------------------------------------------------
		
		update_option('shipme_new_job_email_approved_subject', 'Your new job posted, and approved: ##job_name##');
		update_option('shipme_new_job_email_approved_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'Your job <b>##job_name##</b> has been posted on the website.'.PHP_EOL.
																				'The job is live and you can see it here: ##job_link##'.PHP_EOL.
																				'Also you can check your job offers here: ##my_account_url##'.PHP_EOL.PHP_EOL.																				
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
																				
		//--------------------------------------------------------------------------------------------------------------
		
		update_option('shipme_bid_job_owner_email_subject', 'Your have received a new bid to your job: ##job_name##');
		update_option('shipme_bid_job_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You have received a new bid to your job <a href="##job_link##"><b>##job_name##</b></a>.'.PHP_EOL.
																				'See your bid details below:'.PHP_EOL.PHP_EOL.
																				'Bidder Username: ##bidder_username##'.PHP_EOL.
																				'Bid Value: ##bid_value##'.PHP_EOL.PHP_EOL.																				
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
		
		//--------------------------------------------------------------------------------------------------------------
		
		
		update_option('shipme_bid_job_bidder_email_subject', 'Your has been posted to the job: ##job_name##');
		update_option('shipme_bid_job_bidder_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You posted a new bid to the job <a href="##job_link##"><b>##job_name##</b></a>.'.PHP_EOL.
																				'See your bid details below:'.PHP_EOL.PHP_EOL.
																				'job Link: ##job_link##'.PHP_EOL.
																				'Bid Value: ##bid_value##'.PHP_EOL.PHP_EOL.																				
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
		
		//--------------------------------------------------------------------------------------------------------------
		
		update_option('shipme_won_job_loser_email_subject', 'The job: ##job_name## has ended. You did not win.');
		update_option('shipme_won_job_loser_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The job: <a href="##job_link##"><b>##job_name##</b></a> has ended.'.PHP_EOL.
																				'Sorry, you did not win. See won job details below:'.PHP_EOL.PHP_EOL.
																				'job Link: ##job_link##'.PHP_EOL.
																				'Winner Bid Value: ##winner_bid_value##'.PHP_EOL.
																				'Winner Username: ##winner_bid_username##'.PHP_EOL.
																				'Your bid on this job: ##user_bid_value##'.PHP_EOL.PHP_EOL.																				
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
		
		//--------------------------------------------------------------------------------------------------------------
		
		update_option('shipme_won_job_winner_email_subject', 'The job: ##job_name## has ended. You are the winner!');
		update_option('shipme_won_job_winner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The job: <a href="##job_link##"><b>##job_name##</b></a> has ended.'.PHP_EOL.
																				'You just wont it. See won job details below:'.PHP_EOL.PHP_EOL.
																				'job Link: ##job_link##'.PHP_EOL.
																				'Winner Bid Value: ##winner_bid_value##'.PHP_EOL.PHP_EOL.
																																						
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
		
		//--------------------------------------------------------------------------------------------------------------

		
		update_option('shipme_won_job_owner_email_subject', 'Your have selected a winner for your job: ##job_name##.');
		update_option('shipme_won_job_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'Your job: <a href="##job_link##"><b>##job_name##</b></a> 
																				has ended.'.PHP_EOL.
																				'You just selected a winner for it. 
																				See won job details below:'.PHP_EOL.PHP_EOL.
																				'job Link: ##job_link##'.PHP_EOL.
																				'Winner Bidder Username: ##winner_bid_username##'.PHP_EOL.
																				'Winner Bid Value: ##winner_bid_value##'.PHP_EOL.PHP_EOL.
																																						
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
		
		//--------------------------------------------------------------------------------------------------------------																	
		
		update_option('shipme_rated_user_email_subject', 'Your were just rated for the job: ##job_name##.');
		update_option('shipme_rated_user_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You have received a rating for the job: 
																				<a href="##job_link##"><b>##job_name##</b></a>.'.PHP_EOL.
																				'See rating details below:'.PHP_EOL.PHP_EOL.
																				'job Link: ##job_link##'.PHP_EOL.
																				'Rating: ##rating##'.PHP_EOL.
																				'Comment: ##comment##'.PHP_EOL.PHP_EOL.
																																						
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
																				
		//--------------------------------------------------------------------------------------------------------------																	
		
		update_option('shipme_priv_mess_received_email_subject', 'Your have received a private message from user: ##sender_username##.');
		update_option('shipme_priv_mess_received_email_message', 'Hello ##receiver_username##,'.PHP_EOL.PHP_EOL.
																				'You have received a private message from <b>##sender_username##</b>'.PHP_EOL.
																				'To read it, just login to your account: ##my_account_url##'.PHP_EOL.PHP_EOL.
																					
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
		
		//--------------------------------------------------------------------------------------------------------------																	
		
		update_option('shipme_completed_job_owner_email_subject', 'job marked as completed by provider: ##job_name##.');
		update_option('shipme_completed_job_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The provider/winner of this job has marked it as completed <b>##job_name##</b> ( ##job_link## )'.PHP_EOL.
																				'To check the job out and accept it go to your account area: ##my_account_url##'.PHP_EOL.PHP_EOL.
																					
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
																				
		//--------------------------------------------------------------------------------------------------------------																	
		
		update_option('shipme_completed_job_bidder_email_subject', 'You completed the job: ##job_name##.');
		update_option('shipme_completed_job_bidder_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You have just marked the following job as completed: <b>##job_name##</b> ( ##job_link## )'.PHP_EOL.
																				'You will be notified when the job owner will accept your job.'.PHP_EOL.PHP_EOL.
																					
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
																				
		//--------------------------------------------------------------------------------------------------------------																	
		
		update_option('shipme_delivered_job_bidder_email_subject', 'job marked delivered and accepted by the owner: ##job_name##.');
		update_option('shipme_delivered_job_bidder_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The owner of the job: <b>##job_name##</b> ( ##job_link## ) has accepted and marked it as delivered.'.PHP_EOL.
																				'You will be notified when the owner pays the job fee.'.PHP_EOL.PHP_EOL.
																					
																				'Thank you,'.PHP_EOL.
		
																				'##your_site_name## Team');
																				
		//--------------------------------------------------------------------------------------------------------------																	
		
		update_option('shipme_delivered_job_owner_email_subject', 'Your job accepted as delivered: ##job_name##.');
		update_option('shipme_delivered_job_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You have just accepted as delivered your job: <b>##job_name##</b> ( ##job_link## ).'.PHP_EOL.
																				'You need to login into your account area and pay the job fee.'.PHP_EOL.
																				'Login here: ##my_account_url##'.PHP_EOL.PHP_EOL.
																					
																				'Thank you,'.PHP_EOL.
		
																				'##your_site_name## Team');																		
		
	endif;
	
	
	
	$opt = get_option('shipme_new_emails_138');
	if(empty($opt)):
		
	update_option('shipme_new_emails_138', 'DonE');
	
	update_option('shipme_subscription_email_subject', 'job matching your criteria: ##job_name##.');
		update_option('shipme_subscription_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'A new job that matches your criteria has been posted: <b>##job_name##</b> ( ##job_link## ).'.PHP_EOL.PHP_EOL.																				
																				'Thank you,'.PHP_EOL.
		
																				'##your_site_name## Team');	
																				
	//----------------------------------------------------
	
	update_option('shipme_message_board_owner_email_subject', 'New message on job message board: ##job_name##.');
	update_option('shipme_message_board_owner_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The user ##message_owner_username## has posted a new message on the job message board.'.PHP_EOL.
																				'You can check the message here: <b>##job_name##</b> ( ##job_link## )'.	PHP_EOL.PHP_EOL.																			
																				'Thank you,'.PHP_EOL.		
																				'##your_site_name## Team');	
																				
	//----------------------------------------------------
	
	update_option('shipme_message_board_bidder_email_subject', 'New message on job message board: ##job_name##.');
	update_option('shipme_message_board_bidder_email_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'The job owner (##job_username##) has posted a reply on the job message board.'.PHP_EOL.																				
																				'You can check the answer out here: <b>##job_name##</b> ( ##job_link## )'.PHP_EOL.PHP_EOL.
																				'Thank you,'.PHP_EOL.		
																				'##your_site_name## Team');																																								
																				
	endif;
	
	$opt = get_option('shipme_new_emails_139');
	if(empty($opt)):
	
	update_option('shipme_new_emails_139', 'DonE');
	
		update_option('shipme_payment_on_completed_job_subject', 'Your paid for the job: ##job_name##');
		update_option('shipme_payment_on_completed_job_message', 'Hello ##username##,'.PHP_EOL.PHP_EOL.
																				'You have paid the winning bid for your job <a href="##job_link##"><b>##job_name##</b></a>.'.PHP_EOL.
																				'See your payment details below:'.PHP_EOL.PHP_EOL.
																				'Bidder Username: ##bidder_username##'.PHP_EOL.
																				'Bid Value: ##bid_value##'.PHP_EOL.PHP_EOL.																				
																				'Thank you,'.PHP_EOL.
																				'##your_site_name## Team');
		
		
	endif;
	
?>