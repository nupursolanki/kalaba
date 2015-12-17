<?php 

add_action( 'add_meta_boxes', 'add_custom_box_package' );

/* Do something with the data entered */
add_action( 'save_post', 'save_postdata_package' );

/* Code For add package */
function add_custom_box_package() {
    add_meta_box(
        'dynamic_sectionid',
        __( 'Package', 'myplugin_textdomain' ),
        'inner_custom_box_package',
        'job_ship');
}

/* Prints the box content */
function inner_custom_box_package() {
    global $post;
    // Use nonce for verification
    wp_nonce_field( plugin_basename( __FILE__ ), 'dynamicMeta_noncename' );
    ?>
    <div id="meta_inner">
    <?php

    //get the saved meta as an arry
	$package_detail=array();
    $package_detail = get_post_meta($post->ID,'package_detail',true);
	

    $c = 0;
    if ( count( $package_detail ) > 0 && is_array($package_detail) ) {
        foreach( $package_detail as $track ) {
            if ( isset( $track['num_of_package'] ) || isset( $track['height'] ) || isset( $track['width'] )|| isset( $track['length'] )|| isset( $track['weight']) ) {
                printf( '<table class="package_detail"><tr><td>Number of package :</td><td> <input type="text" name="package_detail[%1$s][num_of_package]" value="%2$s" placeholder="Number Of Package" /></td> </tr><tr><td>Height :</td><td> <input type="text" name="package_detail[%1$s][height]" value="%3$s" placeholder="cm" /></td></tr> <tr><td>Width :</td><td> <input type="text" name="package_detail[%1$s][width]" value="%4$s" placeholder="cm" /></td></tr> <tr><td>Length :</td><td> <input type="text" name="package_detail[%1$s][length]" value="%5$s" placeholder="cm" /></td></tr> <tr><td>Weight :</td><td> <input type="text" name="package_detail[%1$s][weight]" value="%6$s" placeholder="kg" /></td></tr> <tr><td></td><td><span class="remove preview  button button-primary button-large">%7$s</span></td></tr></table>', $c, $track['num_of_package'], $track['height'],$track['width'],$track['length'],$track['weight'],__( 'Remove Track' ) );
                $c = $c +1;
            }
        }
    }

    ?>
<span id="here"></span>
<span class="add button"><?php _e('Add Packages'); ?></span>
<style>.package_detail input{width:100%}</style>
<script>
    var $ =jQuery.noConflict();
    $(document).ready(function() {
        var count = <?php echo $c; ?>;
        $(".add").click(function() {
            count = count + 1;

            $('#here').append('<table class="package_detail"><tr><td>Number of package :</td><td> <input type="text" name="package_detail['+count+'][num_of_package]" value="" placeholder="Number of package" /></td></tr><tr><td>Height :</td><td> <input type="text" name="package_detail['+count+'][height]" value="" placeholder="cm" /> </td></tr><tr><td>Width :</td><td> <input type="text" name="package_detail['+count+'][width]" value="" placeholder="cm" /></td> </tr><tr><td>Length :</td> <td><input type="text" name="package_detail['+count+'][length]" value="" placeholder="cm" /></td> </tr><tr><td>Weight :</td><td> <input type="text" name="package_detail['+count+'][weight]" value=""  placeholder="kg"/> </td></tr> <tr><td> </td><td><span style="" class="remove preview  button button-primary button-large">Remove Track</span></td></tr></table>' );
            return false;
        });
        $(".remove").live('click', function() {
            $(this).parent().parent().parent().remove();
        });
    });
    </script>
</div><?php

}

/* When the post is saved, saves our custom data */
function save_postdata_package( $post_id ) {
    // verify if this is an auto save routine. 
    // If it is our form has not been submitted, so we dont want to do anything
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
        return;

    // verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times
    if ( !isset( $_POST['dynamicMeta_noncename'] ) )
        return;

    if ( !wp_verify_nonce( $_POST['dynamicMeta_noncename'], plugin_basename( __FILE__ ) ) )
        return;

    // OK, we're authenticated: we need to find and save the data

    $package_detail = $_POST['package_detail'];

    update_post_meta($post_id,'package_detail',$package_detail);
}
/* End Code For add package */