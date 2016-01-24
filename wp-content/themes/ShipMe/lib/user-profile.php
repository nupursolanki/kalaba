<?php
global $wpdb, $wp_rewrite, $wp_query;
$username = urldecode($wp_query->query_vars['post_author']);
$uid = $username;
$paged = $wp_query->query_vars['paged'];



$user = get_userdata($uid);
if ($user == false) {
    $user = get_user_by('login', $username);
    $uid = $user->ID;
}

$username = $user->user_login;

function sitemile_filter_ttl($title) {
    return __("User Profile", 'shipme') . " - ";
}

add_filter('wp_title', 'sitemile_filter_ttl', 10, 3);

get_header();
?>



<div class="page_heading_me">
    <div class="page_heading_me_inner">
        <div class="mm_inn"><?php printf(__("User Profile - %s", 'shipme'), $username); ?>   </div>


    </div>

</div> 
<!-- ########## -->

<div id="main_wrapper">
    <div id="main" class="wrapper"> 




        <div id="content">

            <div class="my_box3">
                <div class="padd10">


                    <div class="box_content">	



                        <div class="user-profile-description">
                            <?php
                            $info = get_user_meta($uid, 'user_description', true);
                            if (empty($info))
                                _e("No personal info defined.", 'shipme');
                            else
                                echo $info;
                            ?>                        

                            <p>
                            <ul class="other-dets_m">
                                <?php
                                $arrms = shipme_get_user_fields_values($uid);

                                if (count($arrms) > 0)
                                    for ($i = 0; $i < count($arrms); $i++) {
                                        ?>
                                        <li>
                                            <h3><?php echo $arrms[$i]['field_name']; ?>:</h3>
                                            <p><?php echo $arrms[$i]['field_value']; ?></p>
                                        </li>
                                    <?php } ?>


                            </ul>
                            </p>

                        </div>

                        <div class="user-profile-avatar"><img class="imgImg" width="100" height="100" src="<?php echo shipme_get_avatar($uid, 100, 100); ?>" />

                            <?php
                            if (shipme_is_user_provider($uid)):
                                ?>

                                <div class="price-per-hr"><?php
                                    $pr = get_user_meta($uid, 'per_hour', true);
                                    if (empty($pr))
                                        $pr = __('not defined', 'shipme');
                                    else
                                        $pr = shipme_get_show_price($pr);

                                    echo sprintf(__('Hourly Rate: %s', 'shipme'), $pr);
                                    ?>
                                </div>

                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            if (shipme_is_user_business($uid)):
                ?>  
                <div class="clear10"></div>
                <div class="box_title"><?php _e("User Latest Posted Jobs", 'shipme'); ?></div>

                <?php
                $closed = array(
                    'key' => 'closed',
                    'value' => '0',
                    'compare' => '='
                );


                $nrpostsPage = 8;
                $args = array('author' => $uid, 'meta_query' => array($closed), 'posts_per_page' => $nrpostsPage, 'paged' => $paged, 'post_type' => 'job_ship', 'order' => "DESC", 'orderby' => "date");
                $the_query = new WP_Query($args);

                // The Loop

                if ($the_query->have_posts()):
                    while ($the_query->have_posts()) : $the_query->the_post();

                        shipme_get_post();
                    endwhile;

                    if (function_exists('wp_pagenavi'))
                        wp_pagenavi(array('query' => $the_query));
                    ?>

                    <?php
                else: echo __('No Jobs posted.', 'shipme');

                endif;
                // Reset Post Data
                wp_reset_postdata();
                ?>

                <?php
            endif;

            if (shipme_is_user_provider($uid)):
                ?>
                <div class="clear10"></div>
                <div class="box_title"><?php
                    _e("Portfolio Pictures", 'shipme');

                    echo '<link media="screen" rel="stylesheet" href="' . get_bloginfo('template_url') . '/css/colorbox.css" />';
                    /* echo '<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>'; */
                    echo '<script src="' . get_bloginfo('template_url') . '/js/jquery.colorbox.js"></script>';
                    ?></div>

                <div class="my_box3">
                    <div class="box_content">	
                        <script>
                            var $ = jQuery;
                            $(document).ready(function () {
                                $("a[rel='image_gal1']").colorbox();
                            });
                        </script>

                        <?php
                        $args = array(
                            'order' => 'ASC',
                            'orderby' => 'post_date',
                            'post_type' => 'attachment',
                            'author' => $uid,
                            'meta_key' => 'is_portfolio',
                            'meta_value' => '1',
                            'post_mime_type' => 'image',
                            'numberposts' => -1,
                        );
                        $i = 0;

                        $attachments = get_posts($args);



                        if ($attachments) {
                            foreach ($attachments as $attachment) {
                                $url = ($attachment->ID);

                                echo '<div class="div_div"  id="image_ss' . $attachment->ID . '"> <a href="' . shipme_generate_thumb($url, 900, 600) . '" rel="image_gal1"><img width="70" class="image_class" height="70" src="' .
                                shipme_generate_thumb($url, 70, 70) . '" /></a>
			 
			</div>';
                            }
                        }
                        ?>

                    </div>
                </div>


                <?php
            endif;


            if (shipme_is_user_provider($uid)):
                if (shipme_2_user_types()):
                    ?>

                    <div class="my_box3">
                        <div class="padd10">

                            <div class="box_title"><?php _e("User Latest Feedback", 'shipme'); ?> 
                                <span class="sml_ltrs"> [<a href="<?php bloginfo('siteurl'); ?>?p_action=user_feedback&post_author=<?php echo $uid; ?>"><?php _e('See All Feedback', 'shipme'); ?></a>]</span>
                            </div>
                            <div class="box_content">	
                                <!-- ####### -->


                                <?php
                                global $wpdb;
                                $query = "select * from " . $wpdb->prefix . "shipme_ratings where touser='$uid' AND awarded='1' order by id desc limit 5";
                                $r = $wpdb->get_results($query);

                                if (count($r) > 0) {
                                    echo '<table width="100%">';
                                    echo '<tr>';
                                    echo '<th>&nbsp;</th>';
                                    echo '<th><b>' . __('Job Title', 'shipme') . '</b></th>';
                                    echo '<th><b>' . __('From User', 'shipme') . '</b></th>';
                                    echo '<th><b>' . __('Aquired on', 'shipme') . '</b></th>';
                                    echo '<th><b>' . __('Price', 'shipme') . '</b></th>';
                                    echo '<th><b>' . __('Rating', 'shipme') . '</b></th>';


                                    echo '</tr>';


                                    foreach ($r as $row) {
                                        $post = $row->pid;
                                        $post = get_post($post);
                                        $bid = shipme_get_winner_bid($row->pid);
                                        $user = get_userdata($row->fromuser);
                                        echo '<tr>';

                                        echo '<th><img class="img_class" src="' . shipme_get_first_post_image($row->pid, 42, 42) . '" 
                                alt="' . $post->post_title . '" width="42" /></th>';
                                        echo '<th><a href="' . get_permalink($row->pid) . '">' . $post->post_title . '</a></th>';
                                        echo '<th><a href="' . shipme_get_user_profile_link($user->user_login) . '">' . $user->user_login . '</a></th>';
                                        echo '<th>' . date('d-M-Y H:i:s', get_post_meta($row->pid, 'closed_date', true)) . '</th>';
                                        echo '<th>' . shipme_get_show_price($bid->bid) . '</th>';
                                        echo '<th>' . shipme_get_job_stars(floor($row->grade / 2)) . ' (' . floor($row->grade / 2) . '/5)</th>';


                                        echo '</tr>';
                                        echo '<tr>';
                                        echo '<th></th>';
                                        echo '<th colspan="5"><b>' . __('Comment', 'shipme') . ':</b> ' . $row->comment . '</th>';
                                        echo '</tr>';

                                        echo '<tr><th colspan="6"><hr color="#eee" /></th></tr>';
                                    }

                                    echo '</table>';
                                } else {
                                    _e("There are no reviews yet.", "shipme");
                                }
                                ?>


                                <!-- ####### -->
                            </div>

                        </div>
                    </div>


    <?php endif; ?>

                <div class="clear10"></div>





                <div class="box_title"><?php _e("User Latest Won Jobs", 'shipme'); ?></div>



                <?php
                $nrpostsPage = 8;
                $args = array('meta_key' => 'winner', 'meta_value' => $uid, 'posts_per_page' => $nrpostsPage, 'paged' => $paged, 'post_type' => 'job_ship', 'order' => "DESC", 'orderby' => "date");
                $the_query = new WP_Query($args);

                // The Loop

                if ($the_query->have_posts()):
                    while ($the_query->have_posts()) : $the_query->the_post();

                        shipme_get_post();


                    endwhile;

                    if (function_exists('wp_pagenavi'))
                        wp_pagenavi(array('query' => $the_query));
                    ?>

                    <?php
                else:
                    echo '<div class="my_box3"><div class="box_content">	';
                    echo __('No Jobs posted.', 'shipme');
                    echo '</div>
</div>';
                endif;
                // Reset Post Data
                wp_reset_postdata();
                ?>





                <div class="clear10"></div>
                <?php
            endif;

            if (shipme_is_user_business($uid)):
                ?>


                <div class="my_box3">
                    <div class="padd10">

                        <div class="box_title"><?php _e("User Latest Feedback", 'shipme'); ?> 
                            <span class="sml_ltrs"> [<a href="<?php bloginfo('siteurl'); ?>?p_action=user_feedback&post_author=<?php echo $uid; ?>"><?php _e('See All Feedback', 'shipme'); ?></a>]</span>
                        </div>
                        <div class="box_content">	
                            <!-- ####### -->


                            <?php
                            global $wpdb;
                            $query = "select * from " . $wpdb->prefix . "shipme_ratings where touser='$uid' AND awarded='1' order by id desc limit 5";
                            $r = $wpdb->get_results($query);

                            if (count($r) > 0) {
                                echo '<table width="100%">';
                                echo '<tr>';
                                echo '<th>&nbsp;</th>';
                                echo '<th><b>' . __('Job Title', 'shipme') . '</b></th>';
                                echo '<th><b>' . __('From User', 'shipme') . '</b></th>';
                                echo '<th><b>' . __('Aquired on', 'shipme') . '</b></th>';
                                echo '<th><b>' . __('Price', 'shipme') . '</b></th>';
                                echo '<th><b>' . __('Rating', 'shipme') . '</b></th>';


                                echo '</tr>';


                                foreach ($r as $row) {
                                    $post = $row->pid;
                                    $post = get_post($post);
                                    $bid = shipme_get_winner_bid($row->pid);
                                    $user = get_userdata($row->fromuser);
                                    echo '<tr>';

                                    echo '<th><img class="img_class" src="' . shipme_get_first_post_image($row->pid, 42, 42) . '" 
                                alt="' . $post->post_title . '" width="42" /></th>';
                                    echo '<th><a href="' . get_permalink($row->pid) . '">' . $post->post_title . '</a></th>';
                                    echo '<th><a href="' . shipme_get_user_profile_link($user->user_login) . '">' . $user->user_login . '</a></th>';
                                    echo '<th>' . date('d-M-Y H:i:s', get_post_meta($row->pid, 'closed_date', true)) . '</th>';
                                    echo '<th>' . shipme_get_show_price($bid->bid) . '</th>';
                                    echo '<th>' . shipme_get_job_stars(floor($row->grade / 2)) . ' (' . floor($row->grade / 2) . '/5)</th>';


                                    echo '</tr>';
                                    echo '<tr>';
                                    echo '<th></th>';
                                    echo '<th colspan="5"><b>' . __('Comment', 'shipme') . ':</b> ' . $row->comment . '</th>';
                                    echo '</tr>';

                                    echo '<tr><th colspan="6"><hr color="#eee" /></th></tr>';
                                }

                                echo '</table>';
                            } else {
                                _e("There are no reviews yet.", "shipme");
                            }
                            ?>


                            <!-- ####### -->
                        </div>

                    </div>
                </div>

<?php endif; ?>
        </div>


        <div id="right-sidebar">

<?php dynamic_sidebar('other-page-area'); ?>

        </div>



    </div></div> 


<?php
get_footer();
?>
