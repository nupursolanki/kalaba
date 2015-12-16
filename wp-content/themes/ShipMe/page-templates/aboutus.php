<?php
/*
  Template Name: About Us
 */

get_header();
?>
<div class="container_ship_ttl_wrap">	
    <div class="container_ship_ttl">
        <div class="my-page-title col-xs-12 col-sm-12 col-lg-12">
            <?php the_title(); ?>
        </div>
    </div>
</div>
<div class="container_ship_no_bk mrg_topo">
    <div class="job-content-area col-xs-12 col-sm-12 col-lg-12">
        <ul class="virtual_sidebar" id="six-years">
            <li class="widget-container widget_text">
                <div class="my-only-widget-content parafontsize">

                    <?php if (have_posts()) while (have_posts()) : the_post(); ?>
                            <?php the_content(); ?>						
                        <?php endwhile; // end of the loop. ?>

                </div>
            </li>
        </ul>
    </div>
</div>
<?php get_footer() ?>