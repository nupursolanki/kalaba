<?php

add_action("widgets_init","shipme_home_page_text_widget_fnc");
function shipme_home_page_text_widget_fnc()
{
    register_widget("shipme_home_page_text_widget");
}

class shipme_home_page_text_widget extends WP_Widget
{
    function  widget($args,$instance)
    {       
		 extract($args,EXTR_SKIP);
    
     $title =   $instance['title'] ;
     $content =   $instance['content'] ;
     $image_picture =   $instance['image_picture'] ;
     $disp_pic =   $instance['disp_pic'] ;
 
    
     echo $before_widget;
		?>
		<div class="widget-home-text">
            <div class="widget-full-inner">
            
            <?php if($disp_pic == "left") { ?>
            	
                <div class=" col-xs-12 col-sm-6 col-lg-6"> 
                    <div class="home-widget-image"><img src="<?php echo $image_picture; ?>" /></div> 
                </div> 
                
                
                 <div class="t_align_left col-xs-12 col-sm-6 col-lg-6">        
                        <?php echo $before_title; ?>
                        <h3><?php echo $title; ?></h3>
                        <?php echo $after_title; ?>
                         
                         
                        <div class="home-widget-content"><?php echo $content; ?></div>       
                
                </div>
                
                
                
            
            <?php } else { ?>
            
                <div class="t_align_left col-xs-12 col-sm-6 col-lg-6">        
                        <?php echo $before_title; ?>
                        <h3><?php echo $title; ?></h3>
                        <?php echo $after_title; ?>
                         
                         
                        <div class="home-widget-content"><?php echo $content; ?></div>       
                
                </div>
                
                <div class=" col-xs-12 col-sm-6 col-lg-6"> 
                    <div class="home-widget-image"><img src="<?php echo $image_picture; ?>" /></div> 
                </div> 
                 
             <?php } ?>
            </div>
		</div>
		<?php
		echo $after_widget;
    }

   function shipme_home_page_text_widget()
   {
		 $widget_options = array(
			  'classname'=>'widget-home-text',
			  'description'=>__('This widget shows a text title, text content, and picture. Usually for homepage design.')
		   );
		   $control_options = array(
			  'height'=>300,
			  'width' =>300
		   );
		   $this->WP_Widget('text_home_widget','Home Page Text Widget - ShipMe',$widget_options,$control_options);
   }

   function  update($newinstance,$oldinstance)
   {
 
		
		 $instance =  $oldinstance;
    //update the username
    $instance['title']=  $newinstance['title'];
    $instance['content']=  $newinstance['content'];
    $instance['disp_pic']=  $newinstance['disp_pic'];
    $instance['image_picture']=  $newinstance['image_picture']; 
    return $instance;
		
		
		 
		return $instance;
   }

   function form($instance)
   {
   
   $rand1 = rand(1,99999); 
   
		?>
    <label for="<?php echo $this->get_field_id("title");  ?>">
    <p>Widget Text Title: <input type="text"  style="width:100%"  value="<?php echo $instance['title']; ?>" name="<?php  echo $this->get_field_name("title"); ?>" id="<?php  echo $this->get_field_id("title") ?>"></p>
    </label>

    <label for="<?php echo $this->get_field_id("content");  ?>">
    <p>Widget Text Content: <textarea rows="5" style="width:100%" name="<?php echo  $this->get_field_name("content"); ?>" id="<?php  echo $this->get_field_id("content") ?>"><?php echo $instance['content'];  ?></textarea> </p>
    </label>
    
    <?php $coo = $config['disp_pic']; if(empty($coo)) $coo = 'left'; ?>
    
     <label for="<?php echo $this->get_field_id("Display");  ?>">
    <p>Align Picture: <input type="radio" name="<?php echo  $this->get_field_name("disp_pic"); ?>" <?php echo $coo == "left" ? "checked='checked'" : ""; ?> value="left" /> Left &nbsp; 
    <input type="radio" <?php echo $coo == "left" ? "checked='checked'" : ""; ?>  name="<?php echo  $this->get_field_name("disp_pic"); ?>" value="right" /> Right &nbsp;  </p>
    </label>

  	
    <p>
<label for="<?php echo $this->get_field_id( 'helmet_left' ); ?>"><?php _e( 'Image/Picture:','shipme' ); ?></label> 
<input class="widefat" size="20" id="<?php echo $this->get_field_id( 'image_picture' ); ?>" name="<?php echo $this->get_field_name( 'image_picture' ); ?>" type="text" value="<?php echo esc_attr( $instance[ 'image_picture' ] ); ?>" /> 
<a href="#" id="sel_logo1<?php echo $rand1 ?>" class="button"><?php _e('Upload/Select File','shipme') ?></a>
</p>
		
        
                   		 <script>
			
			jQuery(function(jQuery) {
				jQuery(document).ready(function(){
						jQuery('#sel_logo1<?php echo $rand1 ?>').click(open_media_window1<?php echo $rand1 ?>);
					});
			 
				function open_media_window1<?php echo $rand1 ?>() { 
				
					tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true' );
					return false;
				}
				
				window.send_to_editor = function(html) {
				 imgurl = jQuery('img',html).attr('src'); 
				 jQuery('#<?php echo $this->get_field_id( 'image_picture' ); ?>').val(imgurl) ; 
				 tb_remove();
			 
				}
				
				
			});
			
			
			</script>
        
        
		<?php        
   }
}


?>