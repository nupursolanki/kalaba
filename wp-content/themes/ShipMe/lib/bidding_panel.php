<?php
if (!is_user_logged_in()) {
    echo '<div class="padd10 col-md-8 col-xs-12"><div class="padd10">';
//    echo sprintf(__('You are not logged in. In order to bid please <a href="%s">login</a> or <a href="%s">register</a> an account', 'shipme'), get_bloginfo('siteurl') . '/wp-login.php', get_bloginfo('siteurl') . '/wp-login.php?action=register');
    ?> 
    <div class="error_display col-md-12"></div>
    <ul class="post-new3 loginform col-md-8">

        <li style="border: 0px">
            <div class="col-md-2"> <?php _e('Username', 'shipme'); ?></div>
            <div class="col-md-6"><input type="text" name="uname" id="uname" class="do_input"  size="20" /> </div>



        </li>
        <li style="border: 0px">
            <div class="col-md-2"> <?php _e('Password', 'shipme'); ?></div>
            <div class="col-md-6"><input type="password" name="upwd" id="upwd" class="do_input"  size="20" /> </div>
        </li>
        <li style="border: 0px">
            <div class="col-md-4">  <a class="user_login ye_buut" href="javascript:void(0)">
                    <i class="fa fa-check-circle "></i>
                    Login
                </a></div>
        </li>
        <li style="border: 0px">
            <div class="col-md-6">
                For New User <a class="register_new" href="javascript:void(0)">Register</a> here
            </div>
        </li>
    </ul>

    <ul class="post-new3 registerform col-md-8" style="width:100%;display: none;">
        <li style="border: 0px">
            <div class="col-md-2"> <?php _e('Name', 'shipme'); ?></div>
            <div class="col-md-6"><input type="text" name="reg_name" id="reg_name" class="do_input"  size="20" /> </div>



        </li>
        <li style="border: 0px">
            <div class="col-md-2"> <?php _e('Mobile Number', 'shipme'); ?></div>
            <div class="col-md-6"><input type="text" name="reg_number" id="reg_number" class="do_input"  size="20" /> </div>
        </li>
        <li style="border: 0px">
            <div class="col-md-2"> <?php _e('Email', 'shipme'); ?></div>
            <div class="col-md-6"><input type="text" name="reg_email" id="reg_email" class="do_input"  size="20" /> </div>
        </li>
        <li style="border: 0px">
            <div class="col-md-2"> <?php _e('Password', 'shipme'); ?></div>
            <div class="col-md-6"><input type="password" name="reg_pwd" id="reg_pwd" class="do_input"  size="20" /> </div>
        </li>
        <li style="border: 0px">
            <div class="col-md-2"> <?php _e('Re-enter Password', 'shipme'); ?></div>
            <div class="col-md-6"><input type="password" name="reg_repwd" id="reg_repwd" class="do_input"  size="20" /> </div>
        </li>
        <li style="border: 0px">
            <div class="col-md-4">  <a class="register ye_buut" href="javascript:void(0)">
                    <i class="fa fa-check-circle"></i>
                    Register
                </a></div>
        </li>

    </ul>

    <script>

        jQuery(document).ready(function () {


            var cboxOptions = {
                width: '95%',
                height: '95%',
                maxWidth: '960px',
                maxHeight: '960px',
            }
            jQuery.colorbox.resize({
                    width: window.innerWidth > parseInt(cboxOptions.maxWidth) ? cboxOptions.maxWidth : cboxOptions.width,
                    height: window.innerHeight > parseInt(cboxOptions.maxHeight) ? cboxOptions.maxHeight : cboxOptions.height
                });

            jQuery(window).resize(function () {
                jQuery.colorbox.resize({
                    width: window.innerWidth > parseInt(cboxOptions.maxWidth) ? cboxOptions.maxWidth : cboxOptions.width,
                    height: window.innerHeight > parseInt(cboxOptions.maxHeight) ? cboxOptions.maxHeight : cboxOptions.height
                });
            });
            
            

            jQuery('.register_new').click(function () {

                jQuery('.loginform').fadeOut();
                jQuery('.registerform').fadeIn();

            });
            $('.register').click(function () {

                // alert(11);
                $.ajax({url: "<?php echo get_template_directory_uri(); ?>/page-templates/login_reg.php", type: "POST", data: {type: "reg", reg_name: $('#reg_name').val(), reg_number: $('#reg_number').val(), reg_email: $('#reg_email').val(), reg_pwd: $('#reg_pwd').val(), reg_repwd: $('#reg_repwd').val()}, success: function (result) {
                        //  alert(result.length);
                        if ($.trim(result) == '') {
                            $(".error_display").html('<p style="color:#22bb66;">Registration Successfully</p>');
                            jQuery('.loginform').fadeOut(1000);
                            jQuery('.registerform').fadeOut(1000);
                            setTimeout('', 1000);
                            jQuery.colorbox.close();
                            return false;


                        } else {
                            $(".error_display").html('<p style="color:#D2691E;">' + result + '</p>');
                        }
                    }});

            });
            $('.user_login').click(function () {
    //                 alert(111);
                $.ajax({url: "<?php echo get_template_directory_uri(); ?>/page-templates/login_reg.php", type: "POST", data: {type: "login", username: $('#uname').val(), password: $('#upwd').val()}, success: function (result) {
                        //alert(result.length);            
                        if ($.trim(result) == '') {
                            $(".error_display").html('<p style="color:#22bb66;">Login Successfully</p>');
                            jQuery('.loginform').fadeOut(1000);
                            jQuery('.registerform').fadeOut(1000);
                            setTimeout('', 1000);
                            jQuery.colorbox.close();
                            return false;

                        } else {
                            $(".error_display").html('<p style="color:#D2691E;">' + result + '</p>');
                        }
                    }});
            });

        });</script>
    <?php
    echo '</div></div>';
    exit;
}

global $wpdb, $wp_rewrite, $wp_query;
//$pid = $_GET['pid'];
$pid = $_GET['postid'];

global $current_user;
get_currentuserinfo();
$cid = $current_user->ID;
$cwd = str_replace('wp-admin', '', getcwd());
$post = get_post($pid);

//---------

if ($post->post_author == $cid) {
    echo '<div class="padd10"><div class="padd10">';
    echo sprintf(__('You cannot submit proposals to your own jobs.', 'shipme'));
    echo '</div></div>';
    exit;
}

$closed = get_post_meta($pid, 'closed', true);
if ($closed == '1') {
    echo '<div class="padd10"><div class="padd10">';
    echo sprintf(__('This job has expired or is closed. You cannot submit anymore proposals.', 'shipme'));
    echo '</div></div>';
    exit;
}

//----------------------


$query = "select * from " . $wpdb->prefix . "project_bids where uid='$cid' AND pid='$pid'";
$r = $wpdb->get_results($query);
$bd_plc = 0;

if (count($r) > 0) {
    $row = $r[0];
    $bid = $row->bid;
    $description = $row->description;
    $days_done = $row->days_done;
    $bd_plc = 1;
}

do_action('shipme_display_bidding_panel', $pid);

//====================================================================


$is_it_allowed = true;
$is_it_allowed = apply_filters('shipme_is_it_allowed_place_bids', $is_it_allowed);

if ($is_it_allowed != true):
    do_action('shipme_is_it_not_allowed_place_bids_action');
    ?>
<?php else: ?>	
    <script type="text/javascript">

        function check_submits()
        {
            if (jQuery("#bid").val().length == 0)
            {
                alert("<?php _e('Please type in a bid value.', 'shipme'); ?>");
                return false;
            }
            if (!jQuery('#submits_crt_check').is(':checked'))
            {
                alert("<?php _e('Please accept you can do the work.', 'shipme'); ?>");
                return false;
            }


    //            jQuery.ajax({
    //                url: '<?php echo admin_url('admin-ajax.php'); ?>',
    //                data: {
    //                    'action': 'myAjaxFunc',
    //                    'uid': '<?php echo $cid; ?>',
    //                    'pid': '<?php echo $pid; ?>'
    //                },
    //                success: function (data) {
    //                    alert('Your home page has ' + $(data).find('div').length + ' div elements.');
    //                    return false;
    //                }
    //            });

            return true;
        }
    </script>
    <div class="super_bid_panel">
        <div class="bid_panel_box_title"><?php echo sprintf(__("Submit Your Proposal", 'shipme')); ?></div>
        <div class="bid_panel" >
            <?php
            $do_not_show = 0;
            $uid = $cid;

            $shipme_enable_custom_bidding = get_option('shipme_enable_custom_bidding');
            if ($shipme_enable_custom_bidding == "yes") {
                $shipme_get_project_primary_cat = shipme_get_project_primary_cat($pid);
                $shipme_theme_bidding_cat_ = get_option('shipme_theme_bidding_cat_' . $shipme_get_project_primary_cat);

                if ($shipme_theme_bidding_cat_ > 0) {
                    $shipme_get_credits = shipme_get_credits($uid);

                    if ($shipme_get_credits < $shipme_theme_bidding_cat_) {
                        $do_not_show = 1;
                        $prc = shipme_get_show_price($shipme_theme_bidding_cat_);
                    }
                }
            }

            if ($do_not_show == 1 and $bd_plc != 1) {
                echo '<div class="padd10">';
                echo sprintf(__('You need to have at least %s in your account to bid. <a href="%s">Click here</a> to deposit money.', 'shipme'), $prc, get_permalink(get_option('shipme_my_account_payments_id')));
                echo '</div>';
            } else {
                ?>

                <div class="padd10">
                    <form onsubmit="return check_submits();" method="post" action="<?php echo get_permalink($pid); ?>"> 
                        <input type="hidden" name="control_id" value="<?php echo base64_encode($pid); ?>" /> 
                        <ul class="post-new3" style="width:100%">
                            <li>
                                <h2><?php _e('Your Bid', 'shipme'); ?></h2>
                                <p><input type="text" name="bid" id="bid" class="do_input" value="<?php echo $bid; ?>" size="10" /> 
                                    <?php
                                    $currency = shipme_currency();
                                    $currency = apply_filters('shipme_currency_in_bidding_panel', $currency);
                                    echo $currency;
                                    ?>
                                </p>
                            </li>
                            <li>
                                <h2><?php _e('Your Message', 'shipme'); ?></h2>
                                <p>
                                    <textarea name="description2" cols="28" class="do_input" rows="3"><?php echo $description; ?></textarea><br/>
                                    <input type="hidden" name="control_id" value="<?php echo base64_encode($pid); ?>" />
                                </p>
                            </li>
                            <li>
                                <h2> </h2>
                                <p>
                                    <input type="checkbox" name="accept_trms" id="submits_crt_check" value="1" /><?php _e("I can perform work where/when described in post.", 'shipme'); ?> </p>
                            </li>
                            <li>
                                <h2> </h2>
                                <p>
                                    <input class="my-buttons" id="submits_crt" type="submit" name="bid_now_reverse" value="<?php _e("Place Bid", 'shipme'); ?>" /></p>
                            </li>

                        </ul>
                    </form>
                </div> <?php } ?>
        </div> </div> <?php endif; ?>