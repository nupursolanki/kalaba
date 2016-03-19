<?php
/*
  Template Name: Contact US
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
    <div class="job-content-area col-xs-12 col-sm-9 col-lg-9">
        <ul class="virtual_sidebar" id="six-years">
            <li class="widget-container widget_text">
                <div class="my-only-widget-content termpageliststyle">
                    <?php if (have_posts()) while (have_posts()) : the_post(); ?>
                            <?php the_content(); ?>						
                        <?php endwhile; // end of the loop. ?>
                </div>
            </li>
        </ul>
    </div>
    <div class="job-content-area col-xs-12 col-sm-3 col-lg-3">
        <h3>Contact Us</h3>
        
        <?php echo do_shortcode( '[contact-form-7 id="65" title="Contact form" html_id="contact-form-new" html_class="form contact-form-new"]' ); ?>
    </div>
</div>
<?php get_footer() ?>