<?php
/**
 * WPEC Quick View Template Gallery Class
 *
 * Class Function into woocommerce plugin
 *
 * Table Of Contents
 *
 * dynamic_gallery_display()
 * html2rgb()
 */
class WPEC_Quick_View_Template_Gallery_Class
{
	public static function dynamic_gallery_display( $product_id=0, $next_previous_loaded = 'no' ) {
		global $wpec_qv_fonts_face;
		global $wpec_quick_view_template_gallery_style_settings;
		global $wpec_quick_view_template_gallery_thumbnails_settings;
		
		/**
		 * Single Product Image
		 */
		
		$global_stop_scroll_1image = $wpec_quick_view_template_gallery_style_settings['stop_scroll_1image'];
		$enable_scroll = 'true';
				
		$ogrinal_product_id = $product_id;
		// Get all attached images to this product
						
		$featured_img_id = (int)get_post_meta($product_id, '_thumbnail_id', true);
		$product_image_gallery = '';
		if ( function_exists( 'wpsc_get_product_gallery' ) ) {
			$product_image_gallery = get_post_meta( $product_id, '_wpsc_product_gallery', true );
		}
		
		if ( empty( $product_image_gallery ) || !is_array( $product_image_gallery ) || count( $product_image_gallery ) < 1 ) {			
			$attached_images = (array)get_posts( array(
				'post_type'   => 'attachment',
				'post_mime_type' => 'image',
				'numberposts' => -1,
				'post_status' => null,
				'post_parent' => $product_id ,
				'orderby'     => 'menu_order',
				'order'       => 'ASC',
				'exclude'	  => array($featured_img_id),
			) );
		} else {
			$attached_images = array();
			foreach ( $product_image_gallery as $attachment_id ) {
				if ( $attachment_id == $featured_img_id ) continue;
				$attachment = get_post( $attachment_id );
				if ( $attachment ) {
					$attached_images[] = $attachment;
				}
			}
		}
		
		$product_id .= '_'.rand(100,10000);
		$have_image = false;
		
		$max_height = 0;
		$width_of_max_height = 0;
		
		$gallery_images = array();
		if ($featured_img_id > 0) {
			$feature_image_data = get_post( $featured_img_id );
			if ( $feature_image_data ) {
				$image_attribute = wp_get_attachment_image_src( $feature_image_data->ID, 'full');
				$image_lager_default_url = $image_attribute[0];
				$height_current = $image_attribute[2];
				if ( $height_current > $max_height ) {
					$max_height = $height_current;
					$width_of_max_height = $image_attribute[1];
				}
				
				$feature_image_data->image_lager_default_url = $image_lager_default_url;
				$gallery_images[] = $feature_image_data;
				$have_image = true;
			}
		}
		
		if(is_array($attached_images) && count($attached_images) > 0) {
			foreach($attached_images as $item_thumb){
				$image_attribute = wp_get_attachment_image_src( $item_thumb->ID, 'full');
				$image_lager_default_url = $image_attribute[0];
				$height_current = $image_attribute[2];
				if ( $height_current > $max_height ) {
					$max_height = $height_current;
					$width_of_max_height = $image_attribute[1];
				}
				
				$item_thumb->image_lager_default_url = $image_lager_default_url;
				$gallery_images[] = $item_thumb;
				$have_image = true;
			}
		}
		
		?>
		<div class="product_gallery">
            <?php
			$g_width = '100%';
			$g_height = $wpec_quick_view_template_gallery_style_settings['product_gallery_height'];	
			
            $g_thumb_width = $wpec_quick_view_template_gallery_thumbnails_settings['thumb_width'];
			if ($g_thumb_width <= 0) $g_thumb_width = 105;
            $g_thumb_height = $wpec_quick_view_template_gallery_thumbnails_settings['thumb_height'];
			if ($g_thumb_height <= 0) $g_thumb_height = 75;
            $g_thumb_spacing = $wpec_quick_view_template_gallery_thumbnails_settings['thumb_spacing'];
                
            $g_auto = $wpec_quick_view_template_gallery_style_settings['product_gallery_auto_start'];
            $g_speed = $wpec_quick_view_template_gallery_style_settings['product_gallery_speed'];
            $g_effect = $wpec_quick_view_template_gallery_style_settings['product_gallery_effect'];
            $g_animation_speed = $wpec_quick_view_template_gallery_style_settings['product_gallery_animation_speed'];
			
			$bg_nav_color = $wpec_quick_view_template_gallery_style_settings['bg_nav_color'];
			
			$bg_image_wrapper = $wpec_quick_view_template_gallery_style_settings['bg_image_wrapper'];
			$border_image_wrapper_color = $wpec_quick_view_template_gallery_style_settings['border_image_wrapper_color'];
			
			$product_gallery_bg_des = $wpec_quick_view_template_gallery_style_settings['product_gallery_bg_des'];
			
			$enable_gallery_thumb = $wpec_quick_view_template_gallery_thumbnails_settings['enable_gallery_thumb'];
			
			
			$product_gallery_nav = $wpec_quick_view_template_gallery_style_settings['product_gallery_nav'];
			
			$transition_scroll_bar = $wpec_quick_view_template_gallery_style_settings['transition_scroll_bar'];
			
			$lazy_load_scroll = $wpec_quick_view_template_gallery_style_settings['lazy_load_scroll'];
			
			$caption_font = $wpec_quick_view_template_gallery_style_settings['caption_font'];
			
			$navbar_font = $wpec_quick_view_template_gallery_style_settings['navbar_font'];
			$navbar_height = $wpec_quick_view_template_gallery_style_settings['navbar_height'];
			
			if($product_gallery_nav == 'yes'){
				$display_ctrl = 'display:block !important;';
				$mg = $navbar_height;
				$ldm = $navbar_height;
				
			}else{
				$display_ctrl = 'display:none !important;';
				$mg = '0';
				$ldm = '0';
			}
			
			$hide_thumb_1image = $wpec_quick_view_template_gallery_thumbnails_settings['hide_thumb_1image'];
			
			$start_label = __('START SLIDESHOW', 'wp-e-commerce-products-quick-view' );
			$stop_label = __('STOP SLIDESHOW', 'wp-e-commerce-products-quick-view' );
			if($global_stop_scroll_1image == 'yes' && count($gallery_images) <= 1) {
				$enable_scroll = 'false';
				$start_label = '';
				$stop_label = '';
			}
			
			$zoom_label = '';
			$lightbox_class = '';
			
			if ($lightbox_class == '' && $enable_scroll == 'false') {
				$display_ctrl = 'display:none !important;';
				$mg = '0';
				$ldm = '0';
			}
		
			$bg_des = WPEC_Quick_View_Template_Gallery_Class::html2rgb($product_gallery_bg_des,true);
			$des_background =str_replace('#','',$product_gallery_bg_des);
			                
            echo '<style>
                .ad-gallery {
                        width: '.$g_width.';
						position:relative;
                }
                .ad-gallery .ad-image-wrapper {
					background:#'.$bg_image_wrapper.';
                    width: 99.3%;'
					. ( ( $g_height != false ) ? 'height: '.($g_height-2).'px;' : '' ) . 
                    'margin: 0px;
                    position: relative;
                    overflow: hidden !important;
                    padding:0;
                    border:1px solid #'.$border_image_wrapper_color.';
					z-index:8 !important;
                }
				@media only screen and (min-width : 768px)  and (max-width : 769px)  {
					.ad-gallery .ad-image-wrapper {
						 width: 98.3%;
					}
				}
				@media only screen and (max-width : 321px) {
					.ad-gallery .ad-image-wrapper {
						 width: 98.3%;
					}
				}
				
				
				.ad-gallery .ad-image-wrapper .ad-image{width:100% !important;text-align:center;}
                .ad-image img{
                    
                }
                .ad-gallery .ad-thumbs li{
                    padding-right: '.$g_thumb_spacing.'px !important;
                }
                .ad-gallery .ad-thumbs li.last_item{
                    padding-right: '.($g_thumb_spacing+13).'px !important;
                }
                .ad-gallery .ad-thumbs li div{
                    height: '.$g_thumb_height.'px !important;
                    width: '.$g_thumb_width.'px !important;
                }
                .ad-gallery .ad-thumbs li a {
                    width: '.$g_thumb_width.'px !important;
                    height: '.$g_thumb_height.'px !important;	
                }
                * html .ad-gallery .ad-forward, .ad-gallery .ad-back{
                    height:	'.($g_thumb_height).'px !important;
                }
				
				/*Gallery*/
				.ad-image-wrapper{
					overflow:inherit !important;
				}
				
				.ad-gallery .ad-controls {
					background: #'.$bg_nav_color.' !important;
					border:1px solid #'.$bg_nav_color.';
					color: #FFFFFF;
					font-size: 12px;
					height: 22px;
					margin-top: 20px !important;
					padding: 8px 2% !important;
					position: relative;
					width: 95.8%;
					-khtml-border-radius:5px;
					-webkit-border-radius: 5px;
					-moz-border-radius: 5px;
					border-radius: 5px;display:none;
				}
				
				.ad-gallery .ad-info {
					float: right;
					font-size: 14px;
					position: relative;
					right: 8px;
					text-shadow: 1px 1px 1px #000000 !important;
					top: 1px !important;
				}
				.ad-gallery .ad-nav .ad-thumbs{
					margin:7px 4% 0 !important;
				}
				.ad-gallery .ad-thumbs .ad-thumb-list {
					margin-top: 0px !important;
				}
				.ad-thumb-list{
				}
				.ad-thumb-list li{
					background:none !important;
					padding-bottom:0 !important;
					padding-left:0 !important;
					padding-top:0 !important;
				}
				#gallery_'.$product_id.' .ad-image-wrapper .ad-image-description {
					background: rgba('.$bg_des.',0.5);
					filter:progid:DXImageTransform.Microsoft.Gradient(GradientType=1, StartColorStr="#88'.$des_background.'", EndColorStr="#88'.$des_background.'");

					margin: 0 0 '.$mg.'px !important;';
					echo $wpec_qv_fonts_face->generate_font_css( $caption_font );
					
					echo '
					left: 0;
					line-height: 1.4em;
					padding:2% 2% 2% !important;
					position: absolute;
					text-align: left;
					width: 96.1% !important;
					z-index: 10;
					font-weight:normal;
				}
				.product_gallery #gallery_'.$product_id.' .ad-image-wrapper {
					background: none repeat scroll 0 0 '.$bg_image_wrapper.';
					border: 1px solid '.$border_image_wrapper_color.' !important;
					padding-bottom:'.$mg.'px;
				}
				.product_gallery #gallery_'.$product_id.' .slide-ctrl, .product_gallery #gallery_'.$product_id.' .icon_zoom {
					'.$display_ctrl.';
					height: '.($navbar_height-16).'px !important;
					line-height: '.($navbar_height-16).'px !important;';
					echo $wpec_qv_fonts_face->generate_font_css( $navbar_font );
				echo '
				}';
				if($lazy_load_scroll == 'yes'){
					echo '#gallery_'.$product_id.' .lazy-load{
						background:'.$transition_scroll_bar.' !important;'
						 . ( ( $g_height != false ) ? 'top:'.($g_height + 9).'px !important;' : '' ) . 
						'opacity:1 !important;
						margin-top:'.$ldm.'px !important;
					}';
				}else{
					echo '.ad-gallery .lazy-load{display:none!important;}';
				}
				echo'
				.product_gallery .icon_zoom {
					background: '.$bg_nav_color.';
					border-right: 1px solid '.$bg_nav_color.';
					border-top: 1px solid '.$border_image_wrapper_color.';
				}
				.product_gallery .slide-ctrl {
					background:'.$bg_nav_color.';
					border-left: 1px solid '.$border_image_wrapper_color.';
					border-top: 1px solid '.$border_image_wrapper_color.';
				}
				.product_gallery .slide-ctrl .ad-slideshow-stop-slide,.product_gallery .slide-ctrl .ad-slideshow-start-slide,.product_gallery .icon_zoom{
					line-height: '.($navbar_height-16).'px !important;';
					echo $wpec_qv_fonts_face->generate_font_css( $navbar_font );
				echo '	
				}
				.product_gallery .ad-gallery .ad-thumbs li a {
					border:1px solid '.$border_image_wrapper_color.' !important;
				}
				.ad-gallery .ad-thumbs li a.ad-active {
					border: 1px solid '.$bg_nav_color.' !important;
				}';
			if($enable_gallery_thumb == 'no'){
				echo '.ad-nav{display:none; height:1px;}.woocommerce .images { margin-bottom: 15px;}';
			}	
			if($hide_thumb_1image == 'yes' && count($gallery_images) <= 1){
				echo '#gallery_'.$product_id.' .ad-nav{display:none;} #gallery_'.$product_id.' .images { margin-bottom: 15px;}';
			}
			
			if($product_gallery_nav == 'no'){
				echo '
				.ad-image-wrapper:hover .slide-ctrl{display: block !important;}
				.product_gallery .slide-ctrl {
					background: none repeat scroll 0 0 transparent;
					border: medium none;
					height: 50px !important;
					left: 41.5% !important;
					top: 38% !important;
					width: 50px !important;
				}';
				echo '.product_gallery .slide-ctrl .ad-slideshow-start-slide {background: url('.WPEC_QV_ULTIMATE_JS_URL.'/mygallery/play.png) !important;height: 50px !important;text-indent: -999em !important; width: 50px !important;}';
				echo '.product_gallery .slide-ctrl .ad-slideshow-stop-slide {background: url('.WPEC_QV_ULTIMATE_JS_URL.'/mygallery/pause.png) !important;height: 50px !important;text-indent: -999em !important; width: 50px !important;}';
			}
			
			echo '#gallery_'.$product_id.' .ad-image-wrapper .ad-image img{cursor: default;} #gallery_'.$product_id.' .icon_zoom{cursor: default;}';
			
			if ($global_stop_scroll_1image == 'yes' && count($gallery_images) <= 1) echo '#gallery_'.$product_id.' .slide-ctrl{cursor: default;}';
			
			echo '
			</style>';
			
			echo '<script type="text/javascript">
                jQuery(function() {
                    var settings_defaults_'.$product_id.' = { loader_image: "'.WPEC_QV_ULTIMATE_JS_URL.'/mygallery/loader.gif",
                        start_at_index: 0,
                        gallery_ID: "'.$product_id.'",
						lightbox_class: "'.$lightbox_class.'",
                        description_wrapper: false,
                        thumb_opacity: 0.5,
                        animate_first_image: false,
                        animation_speed: '.$g_animation_speed.'000,
                        width: false,
                        height: false,
                        display_next_and_prev: '.$enable_scroll.',
                        display_back_and_forward: '.$enable_scroll.',
                        scroll_jump: 0,
                        slideshow: {
                            enable: '.$enable_scroll.',
                            autostart: '.$g_auto.',
                            speed: '.$g_speed.'000,
                            start_label: "'.$start_label.'",
                            stop_label: "'.$stop_label.'",
							zoom_label: "'.$zoom_label.'",
                            stop_on_scroll: true,
                            countdown_prefix: "(",
                            countdown_sufix: ")",
                            onStart: false,
                            onStop: false
                        },
                        effect: "'.$g_effect.'", 
                        enable_keyboard_move: true,
                        cycle: true,
                        callbacks: {
                        init: false,
                        afterImageVisible: false,
                        beforeImageVisible: false
                    }
                };';
			if ( $next_previous_loaded == 'yes' ) {
				echo '
				jQuery("#gallery_'.$product_id.'").adGallery(settings_defaults_'.$product_id.');';
			} else {
				echo '
				setTimeout( function() {
					jQuery("#gallery_'.$product_id.'").adGallery(settings_defaults_'.$product_id.');
				}, 1 );';
			}
			
			echo '
            });
			
            </script>';
						
            echo '<div id="gallery_'.$product_id.'" class="ad-gallery" style="width: '.$g_width.';">
                <div class="ad-image-wrapper" style="width: 99.3%; ' . ( ( $g_height != false ) ? 'height: '.($g_height-2).'px;' : '' ) . '"></div>
                <div class="ad-controls"> </div>
                  <div class="ad-nav">
                    <div class="ad-thumbs">
                      <ul class="ad-thumb-list">';
						
						global $product ;
                        
                        if ( !empty( $gallery_images ) ){	
                            $i = 0;
                            $display = '';
							
							
			
                            if(is_array($gallery_images) && count($gallery_images)>0){
								
								$idx = 0;
								
                                foreach($gallery_images as $item_thumb){
                                    $li_class = '';
                                    if($i == 0){ $li_class = 'first_item';}elseif($i == count($gallery_images)-1){$li_class = 'last_item';}
                                    $image_lager_default_url = $item_thumb->image_lager_default_url;
									
									$image_thumb_attribute = wp_get_attachment_image_src( $item_thumb->ID, 'wpec-qv-dynamic-gallery-thumb');
                                    $image_thumb_default_url = $image_thumb_attribute[0];
									
                                    $thumb_height = $g_thumb_height;
                                    $thumb_width = $g_thumb_width;
                                    $width_old = $image_thumb_attribute[1];
                                    $height_old = $image_thumb_attribute[2];
                                     if($width_old > $g_thumb_width || $height_old > $g_thumb_height){
                                        if($height_old > $g_thumb_height && $g_thumb_height > 0 ) {
                                            $factor = ($height_old / $g_thumb_height);
                                            $thumb_height = $g_thumb_height;
                                            $thumb_width = $width_old / $factor;
                                        }
                                        if($thumb_width > $g_thumb_width && $g_thumb_width > 0 ){
                                            $factor = ($width_old / $g_thumb_width);
                                            $thumb_height = $height_old / $factor;
                                            $thumb_width = $g_thumb_width;
                                        }elseif($thumb_width == $g_thumb_width && $width_old > $g_thumb_width && $g_thumb_width > 0 ){
                                            $factor = ($width_old / $g_thumb_width);
                                            $thumb_height = $height_old / $factor;
                                            $thumb_width = $g_thumb_width;
                                        }						
                                    }else{
										$thumb_height = $height_old;
                                        $thumb_width = $width_old;
                                    }
                                    
                                    
                                        
                                   $alt = get_post_meta($item_thumb->ID, '_wp_attachment_image_alt', true);
								   $img_description = $item_thumb->post_excerpt;
                                            
                                    echo '<li class="'.$li_class.'"><a alt="'.$alt.'" class="gallery_product_'.$product_id.' gallery_product_'.$product_id.'_'.$idx.'" title="'. esc_attr( $img_description ).'" rel="gallery_product_'.$product_id.'" href="'.$image_lager_default_url.'"><div><img idx="'.$idx.'" style="width:'.$thumb_width.'px !important;height:'.$thumb_height.'px !important" src="'.$image_thumb_default_url.'" alt="'. esc_attr( $img_description ).'" class="image'.$i.'" width="'.$thumb_width.'" height="'.$thumb_height.'"></div></a></li>';
                                    $img_description = esc_js( $img_description );
                                    
                                    $i++;
									$idx++;
								}
								
								if (!$have_image) {
									echo '<li style="width:'.$g_thumb_width.'px;height:'.$g_thumb_height.'px;"> <a style="width:'.$g_thumb_width.'px;height:'.$g_thumb_height.'px;" class="" rel="gallery_product_'.$product_id.'" href="'.WPEC_QV_ULTIMATE_JS_URL . '/mygallery/no-image.png"> <div><img style="width:'.$g_thumb_width.'px;height:'.$g_thumb_height.'px;" src="'.WPEC_QV_ULTIMATE_JS_URL . '/mygallery/no-image.png" class="image" alt=""> </div></a> </li>';
								}
                            }
                        }else{
                            echo '<li style="width:'.$g_thumb_width.'px;height:'.$g_thumb_height.'px;"> <a style="width:'.$g_thumb_width.'px;height:'.$g_thumb_height.'px;" class="" rel="gallery_product_'.$product_id.'" href="'.WPEC_QV_ULTIMATE_JS_URL . '/mygallery/no-image.png"> <div><img style="width:'.$g_thumb_width.'px;height:'.$g_thumb_height.'px;" src="'.WPEC_QV_ULTIMATE_JS_URL . '/mygallery/no-image.png" class="image" alt=""> </div></a> </li>';	
								
                        }
						
                        echo '</ul>
						
                        </div>
                      </div>
                    </div>';
                  ?>
          </div>
	<?php
	}
	
	public static function html2rgb($color,$text = false){
		if ($color[0] == '#')
			$color = substr($color, 1);
	
		if (strlen($color) == 6)
			list($r, $g, $b) = array($color[0].$color[1],
									 $color[2].$color[3],
									 $color[4].$color[5]);
		elseif (strlen($color) == 3)
			list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		else
			return false;
	
		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);
		if($text){
			return $r.','.$g.','.$b;
		}else{
			return array($r, $g, $b);
		}
	}
}
?>