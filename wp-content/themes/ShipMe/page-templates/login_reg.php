<?php

require_once('../../../../wp-load.php');
if (isset($_POST['type'])) {
    if ($_POST['type'] == 'login') {
        //   $MYerror['login']='';
        //  echo $_POST['username'].$_POST['password'];

        $user_login = $_POST['username'];
        $user_login = sanitize_user($user_login);
        $user_pass = $_POST['password'];
        $rememberme = 1;
        do_action('wp_authenticate', $user_login, $user_pass);
        //echo $user_login.$user_pass;exit;
        if ($user_login && $user_pass) {
            // echo 11;exit;
            $user = new WP_User(0, $user_login);

            // If the user can't edit posts, send them to their profile.
            //if ( !$user->has_cap('edit_posts') && ( empty( $redirect_to ) || $redirect_to == 'wp-admin/' ) )
            //	$redirect_to = get_settings('siteurl') . '/' . 'my-account';

            if (wp_login($user_login, $user_pass, $using_cookie)) {
                if (!$using_cookie) {
                    $user = get_user_by('login', $user_login);
                    wp_set_current_user($user->ID);
                    wp_set_auth_cookie($user->ID);
                    // $MYerror['login']='1';
                }
//                    if (!$using_cookie)
//                        wp_setcookie($user_login, $user_pass, false, '', '', $rememberme);
//                    do_action('wp_login', $user_login);
                //   wp_redirect($redirect_to);
                // exit;
            } else {
                $projectOK = 0;
                $MYerror['login'] = __('Incorrect Usernam Or Password Please Re-enter.', 'shipme');
                if ($using_cookie) {
                    $projectOK = 0;
                    $MYerror['login'] = __('Incorrect Usernam Or Password Please Re-enter.', 'shipme');
                }
            }
        } else if ($user_login || $user_pass) {
            $projectOK = 0;
            $MYerror['login'] = __('<strong>Error</strong>: The password field is empty.', 'shipme');
        } else {
            $projectOK = 0;
            $MYerror['login'] = __('<strong>Error</strong>: The Mobile Number/password field is empty.', 'shipme');
        }
        if ($projectOK == 0) {
            echo $MYerror['login'];
        }
    }
    if ($_POST['type'] == 'reg') {
        // print_r($_POST);
//        echo $_POST['reg_name'];
//        echo $_POST['reg_number'];
//        echo $_POST['reg_email'];
//        echo $_POST['reg_pwd'];
//        echo $_POST['reg_repwd'];
        
        

            $regex = "/^(\d[\s-]?)?[\(\[\s-]{0,2}?\d{3}[\)\]\s-]{0,2}?\d{3}[\s-]?\d{4}$/i";
            $user_login = $_POST['reg_number'];
            $user_email = trim($_POST['reg_email']);
            $name = $_POST['reg_name'];
            $user_pwd = $_POST['reg_pwd'];
            $user_con_pwd = $_POST['reg_repwd'];
            $sanitized_user_login = sanitize_user($user_login);

            //  echo $user_login.$user_email.$user_pwd.$user_con_pwd.$name;exit;
            if ($user_login == '' || !preg_match($regex, $user_login)) {
                $projectOK = 0;
                $MYerror['login'] = __(' <strong>Error</strong>: Mobile Number is Invalid. Please Enter Mobile Number', 'shipme');
            } else {
                if ($name == '') {
                    $projectOK = 0;
                    $MYerror['login'] = __(' <strong>Error</strong>: Name is Invalid. Please Enter Name', 'shipme');
                } else {
                    if ($user_email == '' || filter_var($user_email, FILTER_VALIDATE_EMAIL) === false) {
                        $projectOK = 0;
                        $MYerror['login'] = __(' <strong>Error</strong>: Email is Invalid. Please Email Name', 'shipme');
                    } else {
                        if ($user_pwd == '' || $user_con_pwd == '' || $user_pwd != $user_con_pwd) {
                            $projectOK = 0;
                            $MYerror['login'] = __(' <strong>Error</strong>: Password is Invalid. Please Password Name', 'shipme');
                        } else {
//                            echo $_POST['reg_number'];exit;
                            if (username_exists($user_login)) {
                                $projectOK = 0;
                                $MYerror['login'] = __(' <strong>Error</strong>: Mobile Number Already Exists....Please Try with another Number.', 'shipme');
                            } else {
                                $user_id = wp_create_user($sanitized_user_login, $user_pwd, $user_email);
                               // echo $user_id;exit;
                                if (!$user_id || $user_id==1) {
                                    $projectOK = 0;
                                    $MYerror['login'] = __('<strong>ERROR</strong>: Couldn&#8217;t register you... please contact the <a href="mailto:%s">webmaster</a> !', 'shipme');
                                } else {
                                    wp_update_user(array('ID' => $user_id, 'role' => 'contractor'));
                                    update_user_meta($user_id, 'first_name', $name);

                                    wp_set_current_user($user_id);
                                    wp_set_auth_cookie($user_id);
                                }
                            }
                        }
                    }
                }
            }
            if ($projectOK == 0) {
            echo $MYerror['login'];
        }
        
    }
}
?>

