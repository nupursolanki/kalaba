<?php
/*
  Template Name: User Profile Show
 */

get_header();
?>
<?php
$user_id = $_GET['user_id'];
$user_data = get_userdata($user_id);
//print_r($user_data);
?>	
<div class="container_ship_ttl_wrap">	
    <div class="container_ship_ttl">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
            <?php echo ucfirst(get_user_meta($user_id, 'first_name', 'true') . ' ' . get_user_meta($user_id, 'last_name', 'true')); ?>
        </div>
    </div>
</div>
<div class="container_ship_no_bk">
    <div class="account-right-sidebar col-xs-12 col-sm-4 col-lg-3  " id="right-sidebar">
        <ul class="virtual_sidebar">

            <li class="widget-container widget_text"><h3 class="widget-title">Transporter Menu</h3>
                <div class="my-only-widget-content">

                    <ul id="my-account-admin-menu">
                        <li><a href="">Transporter Profile</a></li> 
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div class="account-content-area col-xs-12 col-sm-8 col-lg-9">
        <ul class="virtual_sidebar">

            <li class="widget-container widget_text">            	 
                <div class="my-only-widget-content">

                    <ul class="post-new3">


                        <li>
                            <h2>Transporter Full Name:</h2>
                            <p><?php echo ucfirst(get_user_meta($user_id, 'first_name', 'true') . ' ' . get_user_meta($user_id, 'last_name', 'true')); ?></p>
                        </li>



                        <li>
                            <h2>Mobile Number:</h2>
                            <p><?php echo $user_data->user_login; ?></p>
                        </li>


                        <li>
                            <h2>Email ID:</h2>
                            <p><?php echo $user_data->user_email; ?></p>
                        </li>



                        <li>
                            <h2>Preffered Address:</h2>
                            <p><?php
                                $tra_preffered_address = get_user_meta($user_id, 'tra_preffered_address', 'true');
                                $i = 1;
                                if (is_array($tra_preffered_address) && !empty($tra_preffered_address)) {
                                    foreach ($tra_preffered_address as $single_tra_preffered_address) {
                                        echo $i . '.' . $single_tra_preffered_address . '<br>';
                                        $i++;
                                    }
                                }
                                ?></p>
                        </li>



                        <li>
                            <h2>Offices:</h2>
                            <p><?php
                                $office_address = get_user_meta($user_id, 'tra_office_address', 'true');
                                $i = 1;
                                if (is_array($office_address) && !empty($office_address)) {
                                    foreach ($office_address as $single_office_address) {
                                        echo $i . '.' . $single_office_address . '<br>';
                                        $i++;
                                    }
                                }
                                ?></p>
                        </li>

                    </ul>
                </div>
            </li>



        </ul>



    </div>



</div>
<?php get_footer() ?>