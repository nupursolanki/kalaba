<?php

//******************************************
//
//	Shipme theme- theme started on aug 2015
//	www.sitemile.com
//
//******************************************

function shipme_theme_my_account_posted_offers_fnc() {

    ob_start();

    global $current_user;
    get_currentuserinfo();
    $uid = $current_user->ID;
    ?>
    <!--<div class="container_ship_ttl_wrap">	
        <div class="container_ship_ttl">
            <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
    <?php //the_title();  ?>
            </div>
        
    <?php
//    
//            if(function_exists('bcn_display'))
//            {
//                echo '<div class="my_box3 no_padding  breadcrumb-wrap col-xs-12 col-sm-12 col-lg-12"><div class="padd10a">';	
//                bcn_display();
//                echo '</div></div>';
//            }
    ?>	
        
        </div>
    </div>-->

    <?php
    if (current_user_can('manage_options')) {
        echo '<div class="total-content-area note-note ">' . __('You are logged in as administrator, and you should be both menus (transporter and contractor). Regular users see one or the other depending on their role.', 'shipme') . '</div>';
    }
    ?>

    <div class="container_ship_no_bk">
        <?php echo shipme_get_users_links(); ?>
        <div class="account-content-area col-xs-12 col-sm-8 col-lg-9">
            <ul class="virtual_sidebar">
                <li class="widget-container widget_text">
                    <div class="my-only-widget-content">
                        <?php
                        global $wpdb;
                        $bidpostids .= ' AND uid=' . $uid;
                        $biddetails = $wpdb->get_results("SELECT bid,uid,winner,pid,date_made,description FROM tf_ship_bids where winner='0'$bidpostids");
                        if (!empty($biddetails)) {
                            ?>
                            <table id="receivedbid" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>POST TITLE</th>
                                        <th>BID</th>
                                        <th>DATE</th>
                                        <th>DESCRIPTION</th>
                                    </tr>
                                </thead>       
                                <tbody>
                                    <?php
                                    foreach ($biddetails as $row) {
                                        echo ' <tr>';
                                        echo '<td><a href="' . get_permalink($row->pid) . '">' . get_the_title($row->pid) . '</td>';
                                        echo '<td>' . $row->bid . ' Rs.</td>';
                                        echo '<td>' . $row->date_made . '</td>';
                                        echo '<td>' . $row->description . '</td>';
                                        echo ' </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery.dataTables.min.js"></script>
                            <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('template_url'); ?>/css/jquery.dataTables.min.css" />
                            <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/natural.js"></script>
                            <script type="text/javascript">
                                jQuery(document).ready(function () {
                                    $('#receivedbid').DataTable({
                                        columnDefs: [
                                            {type: 'natural', targets: 2},
                                        ]
                                    });
                                });
                            </script>
                            <?php
                        }else{
                            echo "You are not applied on any job";
                        }
                        ?>
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