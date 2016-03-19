<?php
require_once('../../../../wp-load.php');
if(isset($_POST['sort_by_post'])){
  //  echo $_POST['sort_by_post'];exit;
}
$closed = array(
    'key' => 'closed',
    'value' => "0",
    //'type' => 'numeric',
    'compare' => '='
);

$closed = array(
    'key' => 'paid',
    'value' => "1",
    //'type' => 'numeric',
    'compare' => '='
);
$pickup_location=array();
$delivery_location=array();
$price_1=array();
$price_2=array();
if(isset($_POST['pickup_location'])){
   $pickup_location = array(
    'key' => 'pickup_location',
    'value' => $_POST['pickup_location'],
    //'type' => 'numeric',
    'compare' => 'LIKE'
); 
}
if(isset($_POST['delivery_location'])){
 $delivery_location = array(
    'key' => 'delivery_location',
    'value' => $_POST['delivery_location'],
    //'type' => 'numeric',
    'compare' => 'LIKE'
);    
}

if(isset($_POST['price-1'])){
 $price_1 = array(
    'key' => 'price',
    'value' => $_POST['price-1'],
    'type' => 'numeric',
    'compare' => '>='
);    
}

if(isset($_POST['price-2'])){
 $price_2 = array(
    'key' => 'price',
    'value' => $_POST['price-2'],
    'type' => 'numeric',
    'compare' => '<='
);    
}

$prs_string_qu = wp_parse_args($query_string);
$prs_string_qu['post_type'] = 'job_ship';
$prs_string_qu['posts_per_page'] = 10;
$prs_string_qu['offset'] = $_POST['offset'];
$prs_string_qu['meta_query'] = array($closed, $paid,$pickup_location,$delivery_location,$price_1,$price_2);
$prs_string_qu['meta_key'] = 'featured';
//$prs_string_qu['posts_per_page'] = -1;
if($_POST['sort_by_post']=='recently-added'){
 $prs_string_qu['orderby'] = 'date';
$prs_string_qu['order'] = 'DESC';   
}
elseif ($_POST['sort_by_post']=='price-heigh-low'){
    $prs_string_qu['meta_key'] = 'price';
 $prs_string_qu['orderby'] = 'meta_value_num';
$prs_string_qu['order'] = 'DESC';   
}
elseif ($_POST['sort_by_post']=='price-low-heigh'){
    $prs_string_qu['meta_key'] = 'price';
 $prs_string_qu['orderby'] = 'meta_value_num';
$prs_string_qu['order'] = 'ASC';   
}
elseif ($_POST['sort_by_post']=='pickup-a-z'){
    $prs_string_qu['meta_key'] = 'pickup_location';
 $prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'ASC';   
}
elseif ($_POST['sort_by_post']=='pickup-z-a'){
    $prs_string_qu['meta_key'] = 'pickup_location';
 $prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'DESC';   
}
elseif ($_POST['sort_by_post']=='delivery-a-z'){
    $prs_string_qu['meta_key'] = 'delivery_location';
 $prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'ASC';   
}
elseif ($_POST['sort_by_post']=='delivery-z-a'){
    $prs_string_qu['meta_key'] = 'delivery_location';
 $prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'DESC';   
}
elseif ($_POST['sort_by_post']=='title-a-z'){
   $prs_string_qu['orderby'] = 'title';
$prs_string_qu['order'] = 'ASC';
}
elseif ($_POST['sort_by_post']=='title-z-a'){
  $prs_string_qu['orderby'] = 'title';
$prs_string_qu['order'] = 'DESC';  
}
elseif ($_POST['sort_by_post']=='pickup-date-a-z'){
  $prs_string_qu['meta_key'] = 'pickup_date';
 $prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'DESC';  
}
elseif ($_POST['sort_by_post']=='pickup-date-z-a'){
  $prs_string_qu['meta_key'] = 'pickup_date';
 $prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'ASC';  
}
elseif ($_POST['sort_by_post']=='delivery-date-a-z'){
  $prs_string_qu['meta_key'] = 'delivery_date';
 $prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'DESC';  
}
elseif ($_POST['sort_by_post']=='delivery-date-z-a'){
  $prs_string_qu['meta_key'] = 'delivery_date';
 $prs_string_qu['orderby'] = 'meta_value';
$prs_string_qu['order'] = 'ASC';
}
else{
$prs_string_qu['orderby'] = 'date';
$prs_string_qu['order'] = 'DESC';
}

$thePosts = query_posts($prs_string_qu);

?>
<ul class="virtual_sidebar" id="six-years">

<?php
$i = 0;
if (have_posts()):

    echo '<li class="widget-container widget_text  "> ';
    ?>

                <div class="head_columns">
                    <div class="heds-area col-xs-12 col-sm-2 col-lg-2">   </div>


                    <div class="heds-area  col-xs-12 col-sm-3 col-lg-3"><?php _e('Pickup', 'shipme') ?> </div>


                    <div class="heds-area  col-xs-12 col-sm-3 col-lg-3"><?php _e('Delivery', 'shipme') ?></div>



                    <div class="heds-area  col-xs-12 col-sm-2 col-lg-2"><?php _e('Budget', 'shipme') ?></div>


                    <!--<div class="heds-area  col-xs-12 col-sm-2 col-lg-2"><?php // _e('Time Due', 'shipme') ?> </div>-->



                </div>

    <?php while (have_posts()) : the_post(); ?>

                    <?php shipme_get_regular_job_post('zubs' . ($i % 2));
                    $i++;
                    ?>

                    <?php
                endwhile;

                


//                if (function_exists('wp_pagenavi')):
//                    echo '<li class="widget-container widget_text  "> <div class="my-only-widget-content " >';
//                    wp_pagenavi();
//                    echo '</div></li>';
//                endif;
//
//            else:
//
//                echo '<li class="widget-container widget_text  "> <div class="my-only-widget-content " >';
//                echo __('No jobs posted and active on the site yet.', "shipme");
//                echo '</div></li>';

            endif;
            // Reset Post Data
            wp_reset_postdata();
            global $wp_query; 
         if($_POST['offset']+5 >=$wp_query->found_posts){
             echo '<li class="widget-container widget_text  "> <div class="my-only-widget-content " >';
             echo "NO More Jobs";
             echo '</div></li>';
         }
         else{
//             echo $wp_query->found_posts;
             echo '<li class="widget-container widget_text load_more_button_area">';
             echo"<a href='javascript:void(0)' class='submit_bottom3 load_more_job'>Load More Jobs</a>";
             echo '</li>';
         }
           echo '</li>'; 
            ?>


        </ul>
