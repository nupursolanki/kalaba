<?php

add_action("widgets_init","shipme_home_latest_posted_jobs_fnc");
function shipme_home_latest_posted_jobs_fnc()
{
    register_widget("shipme_home_latest_posted_jb_widget");
}

class shipme_home_latest_posted_jb_widget extends WP_Widget
{
    function  widget($args,$instance)
    {       
		 extract($args,EXTR_SKIP);
     
     $nr =   $instance['nr'] ; 
	 $title =   $instance['title'] ; 
 
 
    
     echo $before_widget;
		?>
		<div class="widget-home-latest"  >
            <div class="widget-full-inner-latest">
          	
            <?php if ($instance['title']) echo $before_title . apply_filters('widget_title', $instance['title']) . $after_title; ?>
            
            
          <?php 
           	if(empty($nr) || !is_numeric($nr)) $nr = 5;

				 global $wpdb;	
				 $querystr = "
					SELECT distinct wposts.* 
					FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta
					WHERE wposts.ID = wpostmeta.post_id
					AND wpostmeta.meta_key = 'closed' 
					AND wpostmeta.meta_value = '0' AND 
					wposts.post_status = 'publish' 
					AND wposts.post_type = 'job_ship' 
					ORDER BY wposts.post_date DESC LIMIT ".$nr;
				
				 $pageposts = $wpdb->get_results($querystr, OBJECT);
				 
				 ?>
					
					 <?php $i = 0; if ($pageposts): ?>
					 <?php global $post; ?>
                     <?php foreach ($pageposts as $post): ?>
                     <?php setup_postdata($post); ?>
                     
                     
                     <?php  shipme_get_regular_job_post('zubs1' ); ?>
                     
                     
                     <?php endforeach; ?>
                     <?php else : ?> <?php $no_p = 1; ?>
                       <div class="padd100"><p class="center"><?php _e("Sorry, there are no posted jobs yet.",'shipme'); ?></p></div>
                        
                     <?php endif; ?>
                     
           
           
            </div>
		</div>
		<?php
		echo $after_widget;
    }

   function shipme_home_latest_posted_jb_widget()
   {
		 $widget_options = array(
			  'classname'=>'widget-latest-big-jobs',
			  'description'=>__('This shows you a widget with your latest posted jobs. Big Posts and Pics. Usually for the homepage.')
		   );
		   $control_options = array(
			  'height'=>300,
			  'width' =>300
		   );
		   $this->WP_Widget('pic_home_widget','Latest Posted Jobs(big) - ShipMe',$widget_options,$control_options);
   }

   function  update($newinstance,$oldinstance)
   {
 
		
		 $instance =  $oldinstance;
    //update the username 
    $instance['height']=  $newinstance['height'];
    $instance['image_picture']=  $newinstance['image_picture']; 
    return $instance;
		
		
		 
		return $instance;
   }

   function form($instance)
   {
   
   $rand1 = rand(1,99999); 
   
		?>  <p>
    <label for="<?php echo $this->get_field_id("title");  ?>">
    <p>Title: <input type="text"  style="width:100%"  value="<?php echo $instance['title']; ?>" name="<?php  echo $this->get_field_name("title"); ?>" id="<?php  echo $this->get_field_id("title") ?>"></p>
    </label>
</p>
 
 
 
  <p>
    <label for="<?php echo $this->get_field_id("nr");  ?>">
    <p>Number of Jobs: <input type="text"  style="width:100%"  value="<?php echo $instance['nr']; ?>" name="<?php  echo $this->get_field_name("nr"); ?>" id="<?php  echo $this->get_field_id("nr") ?>"></p>
    </label>
</p>
 
 
  	 
        
        
		<?php        
   }
}


?>