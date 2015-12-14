<?php

add_action("widgets_init","shipme_home_big_map_fnc");
function shipme_home_big_map_fnc()
{
    register_widget("shipme_big_home_map_widget");
}

class shipme_big_home_map_widget extends WP_Widget
{
    function  widget($args,$instance)
    {       
		 extract($args,EXTR_SKIP);
     
     $nr =   $instance['nr'] ; 
	 $height =   $instance['height'] ; 
 
 
    
     echo $before_widget;
		?>
		<div class="widget-home-latest"  >
           
          		<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script> 
           			<div id="map1" style="width: 100%; height: <?php echo $height ?>px;border-bottom:1px solid #ccc; margin:auto"></div>
           
         <script>
 var myLatlng = new google.maps.LatLng(1,1);
  var myOptions = {
    zoom: 19,
    center: myLatlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  }
  var map = new google.maps.Map(document.getElementById("map1"), myOptions);
	var bounds = new google.maps.LatLngBounds();
	
	map.set('styles', [{"featureType":"all","stylers":[{"saturation":0},{"hue":"#D1EDE8"}]},{"featureType":"road","stylers":[{"saturation":-70}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"visibility":"simplified"},{"saturation":-20}]}]);	
	<?php
	
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
                     
                     
                   		
  var Marker = new google.maps.Marker({
      position: new google.maps.LatLng(<?php echo get_post_meta($post->ID,'pickup_lat',true) ?>, <?php echo get_post_meta($post->ID,'pickup_lng',true) ?>),
      map: map,
      title:"<?php echo $post->post_title ?>"
  });
  
  google.maps.event.addListener(Marker, 'click', function() {
    window.location = '<?php echo get_permalink($post->ID) ?>';
  });
  
  var ll = new google.maps.LatLng(<?php echo get_post_meta($post->ID,'pickup_lat',true) ?>, 
        <?php echo get_post_meta($post->ID,'pickup_lng',true) ?>);
    bounds.extend(ll);

   
                     
                     
                     <?php endforeach; ?> 
                     <?php endif; ?>
                     	

  
		
		
map.fitBounds(bounds);
</script>
		</div>
		<?php
		echo $after_widget;
    }

   function shipme_big_home_map_widget()
   {
		 $widget_options = array(
			  'classname'=>'widget-big-map',
			  'description'=>__('This shows you a full width map with X number of jobs as pointers.')
		   );
		   $control_options = array(
			  'height'=>300,
			  'width' =>300
		   );
		   $this->WP_Widget('big_map_widget','Big Map Full Width - ShipMe',$widget_options,$control_options);
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
    <p>Height of Map(px): <input type="text"  style="width:100%"  value="<?php echo $instance['height']; ?>" name="<?php  echo $this->get_field_name("height"); ?>" id="<?php  echo $this->get_field_id("height") ?>"></p>
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