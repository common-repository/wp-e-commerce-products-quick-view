<?php
/**
 * WPEC Quick View Template Class
 *
 * Table Of Contents
 *
 * custom_template_display()
 */
class WPEC_Quick_View_Custom_Template
{
	public static function quick_view_custom_template_load() {
		
		$product_id = $_REQUEST['product_id'];
		$is_shop = $_REQUEST['is_shop'];
		$is_category = $_REQUEST['is_category'];
		echo WPEC_Quick_View_Custom_Template::custom_template_display( $product_id, $is_shop, $is_category );
		
		die();
	}
	
	public static function quick_view_load_previous_product() {
		
		$product_id = $_REQUEST['product_id'];
		$is_shop = $_REQUEST['is_shop'];
		$is_category = $_REQUEST['is_category'];
		
		echo WPEC_Quick_View_Custom_Template::custom_template_popup( $product_id, $is_shop, $is_category, 'yes' );
		
		die();
	}
	
	public static function quick_view_load_next_product() {
		
		$product_id = $_REQUEST['product_id'];
		$is_shop = $_REQUEST['is_shop'];
		$is_category = $_REQUEST['is_category'];
		
		echo WPEC_Quick_View_Custom_Template::custom_template_popup( $product_id, $is_shop, $is_category, 'yes' );
		
		die();
	}
	
	public static function custom_template_display( $product_id, $is_shop = 'no', $is_category = 'no' ) {
		$output_html = '';
		ob_start();

		$_upload_dir = wp_upload_dir();
		if ( file_exists( $_upload_dir['basedir'] . '/sass/wpec_quick_view_ultimate.min.css' ) )
			echo '<link media="screen" type="text/css" href="' . str_replace(array('http:','https:'), '', $_upload_dir['baseurl'] ) . '/sass/wpec_quick_view_ultimate.min.css" rel="stylesheet" />' . "\n";
		else
			include( WPEC_QV_ULTIMATE_DIR. '/templates/customized_popup_style.php' );
			
		$output_html .= ob_get_clean();
        $output_html .= '<link type="text/css" rel="stylesheet" href="'.WPEC_QV_ULTIMATE_JS_URL . '/mygallery/jquery.ad-gallery.css" />';
        $output_html .= '<script type="text/javascript" src="'.WPEC_QV_ULTIMATE_JS_URL . '/mygallery/jquery.ad-gallery.js"></script>';
		$output_html .= '<div class="quick_view_popup_container">';
		$output_html .= WPEC_Quick_View_Custom_Template::custom_template_popup( $product_id, $is_shop, $is_category );
		$output_html .= '</div>';
		ob_start();
	?>
    	<script type="text/javascript">
		jQuery(document).ready(function($) {
		
			$(document).on( 'click', '.quick_view_previous_control', function() {
				var product_id = $(this).attr('new-product-id');
				var qv_data = {
					action: "quick_view_load_previous_product",
					product_id : product_id,
					is_shop: '<?php echo $is_shop; ?>',
					is_category: '<?php echo $is_category; ?>',
					security: "<?php echo wp_create_nonce("quick_view_load_previous_product");?>"
				};
				$.post( '<?php echo admin_url('admin-ajax.php', 'relative');?>', qv_data, function(responsve){
					$('.quick_view_popup_container').html(responsve);
				});
			});
			$(document).on( 'click', '.quick_view_next_control', function() {
				var product_id = $(this).attr('new-product-id');
				var qv_data = {
					action: "quick_view_load_next_product",
					product_id : product_id,
					is_shop: '<?php echo $is_shop; ?>',
					is_category: '<?php echo $is_category; ?>',
					security: "<?php echo wp_create_nonce("quick_view_load_next_product");?>"
				};
				$.post( '<?php echo admin_url('admin-ajax.php', 'relative');?>', qv_data, function(responsve){
					$('.quick_view_popup_container').html(responsve);
				});
			});
		});
		</script>
    <?php
		$output_html .= ob_get_clean();
		
		return $output_html;
	}
	
	public static function custom_template_popup( $product_id, $is_shop = 'no', $is_category = 'no', $next_previous_loaded = 'no' ) {
		global $wpec_quick_view_ultimate;
		global $wpec_quick_view_template_control_settings;
		global $wpec_quick_view_template_product_rating_settings;
		global $wpec_quick_view_template_product_description_settings;
		global $wpec_quick_view_template_product_meta_settings;
		global $wpec_quick_view_template_product_price_settings;
		global $wpec_quick_view_template_addtocart_settings;
		
		$my_post = get_post( $product_id );
		$the_query = new WP_Query( array( 'post_type' => 'wpsc-product', 'post__in' => array( $product_id ) ) );
		
		while ( $the_query->have_posts() ) : $the_query->the_post();
		
		$product_name = get_the_title( $product_id );
		$product_url = get_permalink( $product_id );
		$product_description = strip_tags( $wpec_quick_view_ultimate->strip_shortcodes( strip_shortcodes( $my_post->post_excerpt ) ) );
		if ( $wpec_quick_view_template_product_description_settings['pull_description_from'] == 'description' || trim( $product_description ) == '' ) {
			$product_description = $wpec_quick_view_ultimate->limit_words( strip_tags( $wpec_quick_view_ultimate->strip_shortcodes( strip_shortcodes( $my_post->post_content ) ) ), $wpec_quick_view_template_product_description_settings['description_characters'] );
		}
		
		
		/**
		 * Add code check show or hide price and add to cart button support for Woo Catalog Visibility Options plugin
		 */
		$show_add_to_cart = true;
		$show_price = true;
		if ( class_exists( 'WPEC_PCF_Functions' ) ) {
			if ( method_exists( 'WPEC_PCF_Functions', 'check_hide_add_cart_button' ) && WPEC_PCF_Functions::check_hide_add_cart_button( $product_id ) ) {
				$show_add_to_cart = false;
			}
			
			if ( method_exists( 'WPEC_PCF_Functions', 'check_hide_price' ) && WPEC_PCF_Functions::check_hide_price( $product_id ) ) {
				$show_price = false;
			}
			if ( get_option( 'hide_addtocart_button' ) == 1 ) {
				$show_add_to_cart = false;
			}
		}
		
		ob_start();
	?>
    	
        <!-- Popup Control -->
    	<?php if ( $wpec_quick_view_template_control_settings['enable_control'] == 1 && ( $is_shop == 'yes' || $is_category != 'no' ) ) { ?>
    	<div class="quick_view_control_container">
        <?php
			$next_previous_product = WPEC_Quick_View_Custom_Template::get_next_previous_product( $product_id, $is_shop, $is_category );
			$previous_product_id = $next_previous_product['previous_product_id'];
			$next_product_id = $next_previous_product['next_product_id'];
		?>
        	<?php if ( $previous_product_id ) { ?>
        	<span class="quick_view_previous_control" new-product-id="<?php echo $previous_product_id; ?>"><img class="quick_view_previous_icon" src="<?php echo $wpec_quick_view_template_control_settings['control_previous_icon']; ?>" /></span>
            <?php } ?>
            
            <?php if ( $next_product_id ) { ?>
            <span class="quick_view_next_control" new-product-id="<?php echo $next_product_id; ?>"><img class="quick_view_next_icon" src="<?php echo $wpec_quick_view_template_control_settings['control_next_icon']; ?>" /></span>
            <?php } ?>
        </div>
        <?php } ?>
        
    	<div class="quick_view_popup_container_inner">
        	<!-- Product Gallery -->
        	<div class="quick_view_product_gallery_container">
            <?php
			require_once('class-quick-view-dynamic-gallery.php');
			WPEC_Quick_View_Template_Gallery_Class::dynamic_gallery_display( $product_id, $next_previous_loaded );
			?>
            </div>
            <div class="quick_view_product_data_container">
            	
                <!-- Product Title -->
            	<div class="quick_view_product_title_container">
                	<a class="quick_view_product_title" href="<?php echo $product_url; ?>"><?php echo $product_name; ?></a>
                </div>
                
                <!-- Product Rating -->
                <?php if ( get_option( 'product_ratings' ) == 1 && $wpec_quick_view_template_product_rating_settings['show_rating'] == 1 ) { ?>
                <div class="quick_view_product_rating_container">
                    <div class="star-rating">
                        <?php _e( 'Avg. Customer Rating', 'wp-e-commerce-products-quick-view' ); ?><br />
                        <?php if ( function_exists( 'wpsc_product_existing_rating' ) ) echo wpsc_product_existing_rating( $product_id ); ?>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <?php } ?>
                
                <!-- Product Description -->
                <?php if ( $wpec_quick_view_template_product_description_settings['show_description'] == 1 ) { ?>
                <div class="quick_view_product_description_container">
                <?php echo $product_description; ?>
                </div>
                <?php } ?>
                
                <!-- Product Meta -->
                <?php if ( $wpec_quick_view_template_product_meta_settings['show_product_meta'] == 1 ) { ?>
                <?php
					$cat_count = sizeof( get_the_terms( $product_id, 'wpsc_product_category' ) );
					$tag_count = sizeof( get_the_terms( $product_id, 'product_tag' ) );
				?>
                <div class="quick_view_product_meta_container">
                	<?php $sku = get_post_meta( $product_id, '_wpsc_sku', true ); ?>
                	<?php if ( trim( $sku ) != '' ) : ?>

                        <div class="quick_view_product_meta"><span class="quick_view_product_meta_name"><?php _e( 'SKU:', 'wp-e-commerce-products-quick-view' ); ?></span> <span class="quick_view_product_meta_value"><?php echo $sku; ?></span>.</div>
                
                    <?php endif; ?>
                	
                    <?php echo get_the_term_list( $product_id, 'wpsc_product_category', '<div class="quick_view_product_meta"><span class="quick_view_product_meta_name">' . _n( 'Category:', 'Categories:', $cat_count, 'wp-e-commerce-products-quick-view' ) . '</span> ', ', ', '.</div>' ); ?>
                    
					<?php echo get_the_term_list( $product_id, 'product_tag', '<div class="quick_view_product_meta"><span class="quick_view_product_meta_name">' . _n( 'Tag:', 'Tags:', $tag_count, 'wp-e-commerce-products-quick-view' ) . '</span> ', ', ', '.</div>' ); ?>
                     
					<?php $wpsc_custom_meta = new wpsc_custom_meta( $product_id ); ?>
                    <?php if ( $wpsc_custom_meta && isset( $wpsc_custom_meta->custom_meta ) && is_array( $wpsc_custom_meta->custom_meta ) ) { ?>
                    	<?php foreach( $wpsc_custom_meta->custom_meta as $custom_meta ) { ?>
							<?php if ( stripos( $custom_meta['meta_key'], 'g:' ) !== FALSE ) continue; ?>
							<div class="quick_view_product_meta"><span class="quick_view_product_meta_name"><?php echo trim( $custom_meta['meta_key'] ); ?>:</span> <span class="quick_view_product_meta_value"><?php echo trim( $custom_meta['meta_value'] ); ?></span></div>
						<?php } ?>
                    <?php } ?>
                                    
                </div>
                <?php } ?>
                
                <!-- Product Price -->
                <?php if ( $show_price && $wpec_quick_view_template_product_price_settings['show_product_price'] == 1 ) { ?>
                <div class="quick_view_product_price_container">
                	<?php 
						if ( function_exists( 'wpsc_the_product_price_display' ) ) 
							wpsc_the_product_price_display( array( 
											'id'				=> $product_id,
											'old_price_text'   	=> __( '%s - ', 'wpsc' ),
											'price_text'       	=> __( '%s', 'wpsc' ),
											'old_price_before' 	=> '<span %s>',
											'old_price_after'  	=> '</span>',
											'price_before' 		=> '<span %s>',
											'price_after' 		=> '</span>',
											'output_you_save' 	=> false 
											) ); 
					?>
                </div>
                <?php } ?>
                <div style="clear:both;"></div>
                <!-- Product Add To Cart -->
                <?php if ( $show_add_to_cart && $wpec_quick_view_template_addtocart_settings['show_addtocart'] == 1 ) { ?>
                <div class="quick_view_product_addtocart_container">
					<?php 
					WPEC_Quick_View_Custom_Template::add_to_cart( $product_id );
					?>
                </div>
                <div style="clear:both;"></div>
                <?php } ?>
                
            </div>
            <div style="clear:both"></div>
        </div>
        <div style="clear:both"></div>
        <script src="http://localhost/ecommerce36/wp-content/plugins/wp-e-commerce/wpsc-core/js/wp-e-commerce.js?ver=3.8.14.1.6720b163bc" type="text/javascript"></script>
    <?php
		endwhile;
		
		$output_html = ob_get_clean();
		
		return $output_html;
	}
	
	public static function add_to_cart( $product_id = 0 ) {
		global $wpec_quick_view_template_addtocart_settings;
		
		if ( $product_id < 1 ) $product_id = wpsc_the_product_id();
		
		$add_to_cart_bt_class = 'quick_view_add_to_cart_button';
		$add_to_cart_text = trim( $wpec_quick_view_template_addtocart_settings['addtocart_button_text'] );
		if ( $wpec_quick_view_template_addtocart_settings['addtocart_button_type'] == 'link' ) {
			$add_to_cart_bt_class = 'quick_view_add_to_cart_link';
			$add_to_cart_text = trim( $wpec_quick_view_template_addtocart_settings['addtocart_link_text'] );
		}
	?>
		<form class="wpec_qv_form wpec_qv_form_<?php echo wpsc_the_product_id(); ?>" enctype="multipart/form-data" action="<?php echo get_permalink( wpsc_the_product_id() ); ?>" method="post" name="product_<?php echo wpsc_the_product_id(); ?>" id="product_<?php echo wpsc_the_product_id(); ?>" >
			<input type="hidden" value="<?php echo wpsc_the_product_id(); ?>" name="product_id"/>

				<?php /** the variation group HTML and loop */ ?>
                <?php 
					global $wpsc_variations; 
					$wpsc_variations = new wpsc_variations( $product_id ); 
				?>
				<?php if ( $wpsc_variations->have_variation_groups() ) : ?>
						<div class="wpsc_variation_forms">
                        	<table>
							<?php while ( $wpsc_variations->have_variation_groups() ) : $wpsc_variations->the_variation_group(); ?>
                            	<?php $form_id = "variation_select_{$product_id}_{$wpsc_variations->variation_group->term_id}"; ?>
								<tr><td class="col1"><label for="<?php echo $form_id; ?>"><?php echo apply_filters( 'wpsc_vargrp_name', $wpsc_variations->variation_group->name, $wpsc_variations->variation_group ); ?>:</label></td>
								<?php /** the variation HTML and loop */?>
								<td class="col2"><select class="wpsc_select_variation" name="variation[<?php echo $wpsc_variations->variation_group->term_id; ?>]" id="<?php echo $form_id; ?>">
								<?php while ( $wpsc_variations->have_variations() ) : $wpsc_variations->the_variation(); ?>
									<option value="<?php echo $wpsc_variations->variation->term_id; ?>" <?php echo wpsc_the_variation_out_of_stock(); ?>><?php echo wpsc_the_variation_name(); ?></option>
								<?php endwhile; ?>
								</select></td></tr>
							<?php endwhile; ?>
                            </table>
						</div><!--close wpsc_variation_forms-->
						<?php /** the variation group HTML and loop ends here */?>
			<?php endif ?>
			<?php if( get_option('addtocart_or_buynow') !='1' ) :?>
                <?php if(wpsc_product_has_stock()) : ?>
                    <?php if(wpsc_has_multi_adding()): ?>
                    <div class="quantity_container">
                        <label class="wpsc_quantity_update" for="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>"><?php _e('Quantity:', 'wpsc'); ?></label>
                        <input type="text" id="wpsc_quantity_update_<?php echo wpsc_the_product_id(); ?>" name="wpsc_quantity_update" size="2" value="1" />
                        <input type="hidden" name="key" value="<?php echo wpsc_the_cart_item_key(); ?>"/>
                        <input type="hidden" name="wpsc_update_quantity" value="true" />
                        <input type='hidden' name='wpsc_ajax_action' value='wpsc_update_quantity' />
                    </div><!--close quantity_container-->
                    <?php endif ;?>
                    <div class="quick_view_product_addtocart_button_container">
                    	<a href="<?php echo get_permalink( wpsc_the_product_id() ); ?>" id="product_<?php echo wpsc_the_product_id(); ?>_submit_button" product-id="<?php echo wpsc_the_product_id(); ?>" rel="nofollow" class="wpec_qv_add_to_cart_button <?php echo $add_to_cart_bt_class; ?>"><?php echo $add_to_cart_text; ?></a>
                    </div>
                <?php else : ?>
                    <p class="soldout"><?php _e('Sorry, sold out!', 'wpsc'); ?></p>
                <?php endif ; ?>
            <?php endif; ?>
		<input type="hidden" value="add_to_cart" name="wpsc_ajax_action"/>
    </form>
    <script type="text/javascript">
	jQuery(document).ready(function($) {
		
		// Submit the product form using AJAX
		$( 'form.wpec_qv_form' ).on( 'submit', function() {
			// we cannot submit a file through AJAX, so this needs to return true to submit the form normally if a file formfield is present
			file_upload_elements = $.makeArray( $( 'input[type="file"]', $( this ) ) );
			if(file_upload_elements.length > 0) {
				return true;
			} else {
	
				var action_buttons = $( 'input[name="wpsc_ajax_action"]', $( this ) );
	
				var action;
				if ( action_buttons.length > 0 ) {
					action = action_buttons.val();
				} else {
					action = 'add_to_cart';
				}
	
				form_values = $(this).serialize() + '&action=' + action;
	
				// Sometimes jQuery returns an object instead of null, using length tells us how many elements are in the object, which is more reliable than comparing the object to null
				if ( $( '#fancy_notification' ).length === 0 ) {
					$( 'div.wpsc_loading_animation', this ).css( 'visibility', 'visible' );
				}
	
				var success = function( response ) {
					if ( ( response ) ) {
						if ( response.hasOwnProperty('fancy_notification') && response.fancy_notification ) {
							if ( $( '#fancy_notification_content' ) ) {
								$( '#fancy_notification_content' ).html( response.fancy_notification );
								$( '#loading_animation').css( 'display', 'none' );
								$( '#fancy_notification_content' ).css( 'display', 'block' );
							}
						}
						$('div.shopping-cart-wrapper').html( response.widget_output );
						$('div.wpsc_loading_animation').css('visibility', 'hidden');
	
						$( '.cart_message' ).delay( 3000 ).slideUp( 500 );
	
						//Until we get to an acceptable level of education on the new custom event - this is probably necessary for plugins.
						if ( response.wpsc_alternate_cart_html ) {
							eval( response.wpsc_alternate_cart_html );
						}
	
						$( document ).trigger( { type : 'wpsc_fancy_notification', response : response } );
					}
	
					if ( $( '#fancy_notification' ).length > 0 ) {
						$( '#loading_animation' ).css( "display", 'none' );
					}
				};
	
				$.post( wpsc_ajax.ajaxurl, form_values, success, 'json' );
	
				wpsc_fancy_notification(this);
				return false;
			}
		});
		
		// Ajax submit form when click on add to cart button
		$('.wpec_qv_add_to_cart_button').click( function(){
			
			//Javascript for variations: bounce the variation box when nothing is selected and return false for add to cart button.
			var dropdowns = $(this).closest('form').find('.wpsc_select_variation');
			var not_selected = false;
			dropdowns.each(function(){
				var t = jQuery(this);
				if(t.val() <= 0){
					not_selected = true;
					t.css('position','relative');
					t.animate({'left': '-=5px'}, 50, function(){
						t.animate({'left': '+=10px'}, 100, function(){
							t.animate({'left': '-=10px'}, 100, function(){
								t.animate({'left': '+=10px'}, 100, function(){
									t.animate({'left': '-=5px'}, 50);
								});
							});
						});
					});
				}
			});
			if (not_selected)
				return false;
		
			var addtocart_object = $(this);
			var product_id = $(this).attr('product-id');
			
			$(this).removeClass('added');
			$(this).addClass('loading');
			
			$('form.wpec_qv_form_' + product_id ).submit();
			
			setTimeout( function() {
				addtocart_object.removeClass('loading');
				addtocart_object.addClass('added');
			}, 1000 );
			
			return false;
		});
	});
	</script>
    <?php if( get_option('addtocart_or_buynow') == '1' ) :?>
        <?php echo wpsc_buy_now_button(wpsc_the_product_id()); ?>
    <?php endif ; ?>
    
	<?php
    }
	
	public static function get_next_previous_product( $current_product_id, $is_shop = 'yes', $is_category = 'no' ) {
		$product_next_previous = array(
			'previous_product_id'	=> false,
			'next_product_id'		=> false
		);
		global $wpdb;
		
		$orderby = get_option( 'wpsc_sort_by', 'name' );
		$order = get_option( 'wpsc_product_order', 'ASC' );
		
		$sql = 'SELECT p.ID FROM '.$wpdb->prefix.'posts AS p';
		$inner = '';
		$where_clause = "WHERE p.post_status = 'publish' AND post_type = 'wpsc-product' ";
		$groupby_clause = '';
		$order_clause = '';
		$limit_clause = '';
		if ( $orderby == 'dragndrop' ) {
			$order_clause .= 'ORDER BY p.menu_order '.$order;
		} elseif ( $orderby == 'name' ) {
			$order_clause .= 'ORDER BY p.post_title '.$order;
		} elseif ( $orderby == 'price' ) {
			$inner .= " INNER JOIN ".$wpdb->prefix."postmeta AS pm ON ( p.ID = pm.post_id ) ";
			$where_clause .= " AND pm.meta_key = '_wpsc_price' ";
			$order_clause .= 'ORDER BY pm.meta_value+0 '.$order;
		} elseif ( $orderby == 'id' ) {
			$order_clause .= 'ORDER BY p.ID '.$order;
		} else {
			$order_clause .= 'ORDER BY p.menu_order '.$order.', p.post_title '.$order;
		}
		
		if ( $is_category != 'no' ) {
			$term_id = $is_category;

			$inner .= " INNER JOIN ".$wpdb->prefix."term_relationships AS tr ON ( p.ID = tr.object_id ) ";
			$inner .= " INNER JOIN ".$wpdb->prefix."term_taxonomy AS tt ON ( tr.term_taxonomy_id = tt.term_taxonomy_id ) ";
			$where_clause .= " AND tt.term_id = ".$term_id." AND tt.taxonomy = 'wpsc_product_category' ";
			
		}
		
		if ( $is_shop == 'yes' || $is_category != 'no' ) {
			$sql .= ' ' . $inner . ' ' . $where_clause . ' '. $groupby_clause . ' ' . $order_clause . ' ' . $limit_clause;
			
			$all_products = $wpdb->get_results( $sql, OBJECT_K );
			if ( $all_products && count( $all_products ) > 1 ) {
				$keys = array_keys( $all_products );
    			$found_index = array_search( $current_product_id, $keys );
				if ( $found_index === false || $found_index === 0 )
        			$product_next_previous['previous_product_id'] = false;
				else
					$product_next_previous['previous_product_id'] = $keys[$found_index-1];
				
				if ( $found_index === false || $found_index === ( count( $keys ) - 1 )  )
        			$product_next_previous['next_product_id'] = false;
				else
					$product_next_previous['next_product_id'] = $keys[$found_index+1];
				
			}
			
		}
		
		return $product_next_previous;
	}
	
}
?>
