<?php
/**
 * WPEC_Quick_View_Ultimate Class
 *
 * Table Of Contents
 *
 * WPEC_Quick_View_Ultimate()
 * init()
 * fix_responsi_theme()
 * fix_style_js_responsi_theme()
 * add_quick_view_ultimate_under_image_each_products()
 * add_quick_view_ultimate_hover_each_products()
 * quick_view_ultimate_wp_enqueue_script()
 * quick_view_ultimate_wp_enqueue_style()
 * quick_view_ultimate_popup()
 * quick_view_ultimate_clicked()
 * quick_view_ultimate_reload_cart()
 * a3_wp_admin()
 * plugin_extra_links()
 */
class WPEC_Quick_View_Ultimate
{
	
	public function __construct() {
		$this->init();
	}
	
	public function init () {
		// Include google fonts into header
		add_action( 'wp_head', array( $this, 'add_google_fonts'), 11 );
		
		// Add script check if checkout then close popup and redirect to checkout page
		add_action( 'wp_head', array( $this, 'redirect_to_checkout_page_from_popup') );
		
		add_action( 'wp_footer', array( $this,'wpec_add_quick_view_button_default_template' ) );
		add_action( 'wp_footer', array( $this,'wpec_quick_view_ultimate_wp_enqueue_script' ),11 );
		add_action( 'wp_footer', array( $this,'wpec_quick_view_ultimate_wp_enqueue_style' ),11 );
		add_action( 'wp_footer', array( $this, 'wpec_quick_view_ultimate_popup' ),11 );
		
		add_action('wp_ajax_wpec_quick_view_ultimate_clicked', array( $this, 'wpec_quick_view_ultimate_clicked') );
		add_action('wp_ajax_nopriv_wpec_quick_view_ultimate_clicked', array( $this, 'wpec_quick_view_ultimate_clicked') );
		add_action('wp_ajax_wpec_quick_view_ultimate_reload_cart', array( $this, 'wpec_quick_view_ultimate_reload_cart') );
		add_action('wp_ajax_nopriv_wpec_quick_view_ultimate_reload_cart', array( $this, 'wpec_quick_view_ultimate_reload_cart') );
	}
	
	public function add_google_fonts() {
		global $wpec_qv_fonts_face;
		$wpec_quick_view_ultimate_on_hover_bt_font = get_option( 'wpec_quick_view_ultimate_on_hover_bt_font' );
		$wpec_quick_view_ultimate_under_image_link_font = get_option( 'wpec_quick_view_ultimate_under_image_link_font' );
		$wpec_quick_view_ultimate_under_image_bt_font = get_option( 'wpec_quick_view_ultimate_under_image_bt_font' );
		
		$google_fonts = array( $wpec_quick_view_ultimate_on_hover_bt_font['face'], $wpec_quick_view_ultimate_under_image_link_font['face'], $wpec_quick_view_ultimate_under_image_bt_font['face'] );
		
		global $wpec_quick_view_template_gallery_style_settings;
		global $wpec_quick_view_template_product_title_settings;
		global $wpec_quick_view_template_product_description_settings;
		global $wpec_quick_view_template_product_meta_settings;
		global $wpec_quick_view_template_product_price_settings;
		global $wpec_quick_view_template_addtocart_settings;
		
		$google_fonts[] = $wpec_quick_view_template_gallery_style_settings['caption_font']['face'];
		$google_fonts[] = $wpec_quick_view_template_gallery_style_settings['navbar_font']['face'];
		$google_fonts[] = $wpec_quick_view_template_product_title_settings['title_font']['face'];
		$google_fonts[] = $wpec_quick_view_template_product_description_settings['description_font']['face'];
		$google_fonts[] = $wpec_quick_view_template_product_meta_settings['meta_name_font']['face'];
		$google_fonts[] = $wpec_quick_view_template_product_meta_settings['meta_value_font']['face'];
		$google_fonts[] = $wpec_quick_view_template_product_price_settings['price_font']['face'];
		$google_fonts[] = $wpec_quick_view_template_product_price_settings['old_price_font']['face'];
		$google_fonts[] = $wpec_quick_view_template_addtocart_settings['addtocart_link_font']['face'];
		$google_fonts[] = $wpec_quick_view_template_addtocart_settings['addtocart_button_font']['face'];
		
		$wpec_qv_fonts_face->generate_google_webfonts( $google_fonts );
	}
	
	public function redirect_to_checkout_page_from_popup() {
		if ( get_option( 'checkout_url' ) == get_permalink() ) {
	?>
    	<script type="text/javascript">
		if ( window.self !== window.top ) {
			self.parent.location.href = '<?php echo get_option( 'checkout_url' ); ?>';
		}
		</script>
    <?php
		}
	}
	
	public function wpec_quick_view_ultimate_wp_enqueue_script(){
		$wpec_quick_view_ultimate_enable = get_option('wpec_quick_view_ultimate_enable');
		$wpec_quick_view_ultimate_type = get_option('wpec_quick_view_ultimate_type');
		$do_this = false;
		if( $wpec_quick_view_ultimate_enable == '1' ) $do_this = true;
		if( !$do_this ) return;
		if( $wpec_quick_view_ultimate_type != 'hover' ) return;
		wp_enqueue_script('jquery');
		wp_register_script( 'wpec-quick-view-script', WPEC_QV_ULTIMATE_JS_URL.'/quick_view_ultimate.js');
		wp_enqueue_script( 'wpec-quick-view-script' );
	}
	
	public function wpec_quick_view_ultimate_wp_enqueue_style(){
		$wpec_quick_view_ultimate_enable = get_option('wpec_quick_view_ultimate_enable');
		$do_this = false;
		if( $wpec_quick_view_ultimate_enable == '1' ) $do_this = true;
		if( !$do_this ) return;

		$_upload_dir = wp_upload_dir();
		wp_enqueue_style( 'wpec-quick-view-css', WPEC_QV_ULTIMATE_CSS_URL.'/style.css');
		wp_enqueue_style( 'wpec-quick-view-button-css', str_replace(array('http:','https:'), '', $_upload_dir['baseurl'] ) . '/sass/wpec_quick_view_button.min.css');
	}
	
	public function wpec_add_quick_view_button_default_template(){
		global $wpsc_gc_view_mode;
		$wpec_quick_view_ultimate_enable = get_option('wpec_quick_view_ultimate_enable');
		$wpec_quick_view_ultimate_type = get_option('wpec_quick_view_ultimate_type');
		$do_this = false;
		
		if( $wpec_quick_view_ultimate_enable == '1' ) $do_this = true;
		
		if( !$do_this ) return;

		if ( $wpec_quick_view_ultimate_type == 'hover' ){
		?>
		<script type="text/javascript">
		var bt_position = '<?php echo get_option('wpec_quick_view_ultimate_on_hover_bt_alink');?>';
		var bt_text = '<?php esc_attr_e( stripslashes( get_option('wpec_quick_view_ultimate_on_hover_bt_text', __( 'QUICKVIEW', 'wp-e-commerce-products-quick-view' ) ) ) );?>';
		var popup_tool = '<?php echo get_option('wpec_quick_view_ultimate_popup_tool');?>';
        jQuery(window).load(function(){
			jQuery( document ).find ( 'form.product_form' ).each(function(){
				product_id = jQuery('input[name="product_id"]',this).val();
				image_element_id = 'product_image_'+product_id;
				jQuery( "#"+image_element_id).data("product_id", product_id );
				parent_container = jQuery(this).parents('div.product_view_'+product_id);
				parent_container.addClass('product_view_item');
				jQuery( "#"+image_element_id).parent('a').parent('div').addClass('wpec_image');
				var bt_html = '<div class="wpec_quick_view_ultimate_container" position="'+bt_position+'"><div class="wpec_quick_view_ultimate_content"><span id="'+product_id+'" data-link="'+jQuery(this).attr('action')+'" class="'+popup_tool+' wpec_quick_view_ultimate_button wpec_quick_view_ultimate_click">'+bt_text+'</span></div></div>';
				<?php
				if($wpsc_gc_view_mode == 'grid'){
				?>
				parent_container.find('.wpec_image').append(bt_html);
				<?php
				}elseif($wpsc_gc_view_mode == 'list'){
					$wpec_quick_view_ultimate_popup_tool = get_option( 'wpec_quick_view_ultimate_popup_tool' );
					$wpec_quick_view_ultimate_under_image_bt_type = get_option( 'wpec_quick_view_ultimate_under_image_bt_type' );
					$wpec_quick_view_ultimate_under_image_link_text = esc_attr( stripslashes( get_option('wpec_quick_view_ultimate_under_image_link_text', __( 'Quick View', 'wp-e-commerce-products-quick-view' ) ) ) );
					$wpec_quick_view_ultimate_under_image_bt_text = esc_attr( stripslashes( get_option('wpec_quick_view_ultimate_under_image_bt_text', __( 'Quick View', 'wp-e-commerce-products-quick-view' ) ) ) );
					$wpec_quick_view_ultimate_under_image_bt_class = get_option( 'wpec_quick_view_ultimate_under_image_bt_class' );
					$link_text = $wpec_quick_view_ultimate_under_image_link_text;
					$class = $wpec_quick_view_ultimate_popup_tool.' wpec_quick_view_ultimate_under_link wpec_quick_view_ultimate_click';
					if( $wpec_quick_view_ultimate_under_image_bt_type == 'button' ){
						$link_text = $wpec_quick_view_ultimate_under_image_bt_text;
						$class = $wpec_quick_view_ultimate_popup_tool.' wpec_quick_view_ultimate_under_button wpec_quick_view_ultimate_click';
						if( trim($wpec_quick_view_ultimate_under_image_bt_class) != '' ){$class .= ' '.trim($wpec_quick_view_ultimate_under_image_bt_class);}
					}
				?>
				var bt_text = '<?php echo $link_text; ?>';
				jQuery('tr.product_view_'+product_id).append('<td class="bt_quick_view"><div style="clear:both;"></div><div class="wpec_quick_view_ultimate_container_under"><div class="wpec_quick_view_ultimate_content_under"><a class="<?php echo $class;?>" id="'+product_id+'" href="'+jQuery(this).attr('action')+'" data-link="'+jQuery(this).attr('action')+'">'+bt_text+'</a></div></div><div style="clear:both;"></div></td>');
				<?php
				}else{
				?>
				parent_container.find('.wpec_image').append(bt_html);
				<?php
				}
				?>
			});
		});
        </script>
		<?php
		}else{
		$wpec_quick_view_ultimate_popup_tool = get_option( 'wpec_quick_view_ultimate_popup_tool' );
		$wpec_quick_view_ultimate_under_image_bt_type = get_option( 'wpec_quick_view_ultimate_under_image_bt_type' );
		$wpec_quick_view_ultimate_under_image_link_text = esc_attr( stripslashes( get_option('wpec_quick_view_ultimate_under_image_link_text', __( 'Quick View', 'wp-e-commerce-products-quick-view' ) ) ) );
		$wpec_quick_view_ultimate_under_image_bt_text = esc_attr( stripslashes( get_option('wpec_quick_view_ultimate_under_image_bt_text', __( 'Quick View', 'wp-e-commerce-products-quick-view' ) ) ) );
		$wpec_quick_view_ultimate_under_image_bt_class = esc_attr( stripslashes( get_option( 'wpec_quick_view_ultimate_under_image_bt_class' ) ) );
		$link_text = $wpec_quick_view_ultimate_under_image_link_text;
		$class = $wpec_quick_view_ultimate_popup_tool.' wpec_quick_view_ultimate_under_link wpec_quick_view_ultimate_click';
		if( $wpec_quick_view_ultimate_under_image_bt_type == 'button' ){
			$link_text = $wpec_quick_view_ultimate_under_image_bt_text;
			$class = $wpec_quick_view_ultimate_popup_tool.' wpec_quick_view_ultimate_under_button wpec_quick_view_ultimate_click';
			if( trim($wpec_quick_view_ultimate_under_image_bt_class) != '' ){$class .= ' '.trim($wpec_quick_view_ultimate_under_image_bt_class);}
		}
		?>
		<script type="text/javascript">
		var bt_text = '<?php echo $link_text; ?>';
		var popup_tool = '<?php echo get_option('wpec_quick_view_ultimate_popup_tool');?>';
        jQuery(window).load(function(){
			jQuery( document ).find ( 'form.product_form' ).each(function(){
				product_id = jQuery('input[name="product_id"]',this).val();
				image_element_id = 'product_image_'+product_id;
				jQuery( "#"+image_element_id).data("product_id", product_id );
				parent_container = jQuery(this).parents('div.product_view_'+product_id);
				parent_container.addClass('product_view_item');
				jQuery( "#"+image_element_id).parent('a').parent('div').addClass('wpec_image');
				var bt_html = '<div style="clear:both;"></div><div class="wpec_quick_view_ultimate_container_under"><div class="wpec_quick_view_ultimate_content_under"><a class="<?php echo $class;?>" id="'+product_id+'" href="'+jQuery(this).attr('action')+'" data-link="'+jQuery(this).attr('action')+'">'+bt_text+'</a></div></div><div style="clear:both;"></div>';
				<?php
				if($wpsc_gc_view_mode == 'grid'){
				?>
				parent_container.find('.wpec_image').append(bt_html);
				<?php
				}elseif($wpsc_gc_view_mode == 'list'){
				?>
				jQuery('tr.product_view_'+product_id).append('<td class="bt_quick_view">'+bt_html+'</td>');
				<?php
				}else{
				?>
				parent_container.find('.wpec_image').append(bt_html);
				<?php
				}
				?>
			});
		});
        </script>
		<?php
		}
	}
	
	public function wpec_quick_view_ultimate_popup(){
		$suffix 				= defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$wpec_quick_view_ultimate_enable = get_option('wpec_quick_view_ultimate_enable');
		$do_this = false;
		if( $wpec_quick_view_ultimate_enable == '1' ) $do_this = true;
		if( !$do_this ) return;
		$wpec_quick_view_ultimate_popup_tool = get_option('wpec_quick_view_ultimate_popup_tool');
		
		if ($wpec_quick_view_ultimate_popup_tool == 'colorbox') {
			wp_enqueue_style( 'a3_colorbox_style', WPEC_QV_ULTIMATE_JS_URL . '/colorbox/colorbox.css' );
			wp_enqueue_script( 'colorbox_script', WPEC_QV_ULTIMATE_JS_URL . '/colorbox/jquery.colorbox'.$suffix.'.js', array(), false, true );
		} elseif ($wpec_quick_view_ultimate_popup_tool == 'fancybox') {
			wp_enqueue_style( 'woocommerce_fancybox_styles', WPEC_QV_ULTIMATE_JS_URL . '/fancybox/fancybox.css' );
			wp_enqueue_script( 'fancybox', WPEC_QV_ULTIMATE_JS_URL . '/fancybox/fancybox'.$suffix.'.js', array(), false, true );
			?>
			<!--<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>-->
            <?php
		}
		wp_enqueue_style( 'wpec-quick-view-css', WPEC_QV_ULTIMATE_CSS_URL.'/style.css');
		
		$wpec_quick_view_ultimate_popup_content = get_option('wpec_quick_view_ultimate_popup_content', 'custom_template' );
		
		$wpec_quick_view_ultimate_fancybox_center_on_scroll = get_option('wpec_quick_view_ultimate_fancybox_center_on_scroll');
		if ( $wpec_quick_view_ultimate_fancybox_center_on_scroll == '' ) $wpec_quick_view_ultimate_fancybox_center_on_scroll = 'false';
		
		$wpec_quick_view_ultimate_fancybox_transition_in = get_option('wpec_quick_view_ultimate_fancybox_transition_in');
		$wpec_quick_view_ultimate_fancybox_transition_out = get_option('wpec_quick_view_ultimate_fancybox_transition_out');
		$wpec_quick_view_ultimate_fancybox_speed_in = get_option('wpec_quick_view_ultimate_fancybox_speed_in');
		$wpec_quick_view_ultimate_fancybox_speed_out = get_option('wpec_quick_view_ultimate_fancybox_speed_out');
		$wpec_quick_view_ultimate_fancybox_overlay_color = get_option('wpec_quick_view_ultimate_fancybox_overlay_color');
		
		$wpec_quick_view_ultimate_colorbox_center_on_scroll = get_option('wpec_quick_view_ultimate_colorbox_center_on_scroll');
		if ( $wpec_quick_view_ultimate_colorbox_center_on_scroll == '' ) $wpec_quick_view_ultimate_colorbox_center_on_scroll = 'false';
		
		$wpec_quick_view_ultimate_colorbox_transition = get_option('wpec_quick_view_ultimate_colorbox_transition');
		$wpec_quick_view_ultimate_colorbox_speed = get_option('wpec_quick_view_ultimate_colorbox_speed');
		$wpec_quick_view_ultimate_colorbox_overlay_color = get_option('wpec_quick_view_ultimate_colorbox_overlay_color');
		
		?>
		<script type="text/javascript">
			function wpec_qv_getWidth() {
				xWidth = null;
				if(window.screen != null)
				  xWidth = window.screen.availWidth;
			
				if(window.innerWidth != null)
				  xWidth = window.innerWidth;
			
				if(document.body != null)
				  xWidth = document.body.clientWidth;
			
				return xWidth;
			}
			<?php
			if ( $wpec_quick_view_ultimate_popup_tool == 'fancybox' ) {
				
			?>
			jQuery(document).on("click", ".wpec_quick_view_ultimate_click.fancybox", function(){
			
				var product_id = jQuery(this).attr('id');
				var product_url = jQuery(this).attr('data-link');
				
				var obj = jQuery(this);
				var auto_Dimensions = true;
				
				<?php if ( $wpec_quick_view_ultimate_popup_content != 'custom_template' ) { ?>
				// detect iOS to fix scroll for iframe on fancybox
				var iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );
				if ( iOS ) {
					jQuery('#fancybox-content').attr( "style", "overflow-y: auto !important; -webkit-overflow-scrolling: touch !important;" );
				}
				<?php } ?>
				
				<?php if ( $wpec_quick_view_ultimate_popup_content == 'full_page' ) { ?>
				var url = product_url;
				<?php } elseif ( $wpec_quick_view_ultimate_popup_content == 'custom_template' ) { ?>
				var is_shop = '<?php echo ( is_archive() && wpsc_is_viewable_taxonomy() ? 'no': 'yes' ); ?>';
				<?php if ( is_archive() && wpsc_is_viewable_taxonomy() ) { 
				$term = get_queried_object();
				?>
				var is_category = '<?php echo $term->term_id; ?>';
				<?php } else { ?>
				var is_category = 'no';
				<?php } ?>
				var url = '<?php echo admin_url('admin-ajax.php', 'relative');?>'+'?action=quick_view_custom_template_load&product_id='+product_id+'&is_shop='+is_shop+'&is_category='+is_category+'&security=<?php echo wp_create_nonce("quick_view_custom_template_load");?>';
				auto_Dimensions = false;
				<?php } else { ?>
                var url = '<?php echo admin_url('admin-ajax.php', 'relative');?>'+'?action=wpec_quick_view_ultimate_clicked&product_id='+product_id+'&product_url='+product_url+'&security=<?php echo wp_create_nonce("quick-view-clicked");?>';
				<?php } ?>
				
				var popup_wide = <?php echo (int) get_option('wpec_quick_view_ultimate_fancybox_popup_width', 600 ); ?>;
				var popup_tall = <?php echo (int) get_option('wpec_quick_view_ultimate_fancybox_popup_height', 460 ); ?>;
				if ( wpec_qv_getWidth()  <= 600 ) { 
					popup_wide = '90%';
					popup_tall = '90%';
				}
				
				jQuery.fancybox({
					<?php if ( $wpec_quick_view_ultimate_popup_content == 'custom_template' ) { ?>
					content: url,
					type: "ajax",
					<?php } else { ?>
					href: url,
					type: "iframe",
					<?php } ?>
					centerOnScroll : <?php echo $wpec_quick_view_ultimate_fancybox_center_on_scroll;?>,
					transitionIn : '<?php echo $wpec_quick_view_ultimate_fancybox_transition_in;?>', 
					transitionOut: '<?php echo $wpec_quick_view_ultimate_fancybox_transition_out;?>',
					easingIn: 'swing',
					easingOut: 'swing',
					speedIn : <?php echo $wpec_quick_view_ultimate_fancybox_speed_in;?>,
					speedOut : <?php echo $wpec_quick_view_ultimate_fancybox_speed_out;?>,
					width: popup_wide,
					autoScale: true,
					height: popup_tall,
					margin: 0,
					padding: 10,
					maxWidth: "90%",
					maxHeight: "90%",
					autoDimensions: auto_Dimensions,
					overlayColor: '<?php echo $wpec_quick_view_ultimate_fancybox_overlay_color;?>',
					showCloseButton : true,
					openEffect	: "none",
					closeEffect	: "none",
					onClosed: function() {
						jQuery.post( '<?php echo admin_url('admin-ajax.php', 'relative');?>?action=wpec_quick_view_ultimate_reload_cart&security=<?php echo wp_create_nonce("reload-cart");?>', '', function(rsHTML){
							jQuery('.shopping-cart-wrapper').html(rsHTML);
							
						});
					}
                });
				
				return false;
			});
			<?php		
			}elseif( $wpec_quick_view_ultimate_popup_tool == 'colorbox' ){
			?>
			jQuery(document).bind('cbox_cleanup', function(){
				jQuery.post( '<?php echo admin_url('admin-ajax.php', 'relative');?>?action=wpec_quick_view_ultimate_reload_cart&security=<?php echo wp_create_nonce("reload-cart");?>', '', function(rsHTML){
					jQuery('.shopping-cart-wrapper').html(rsHTML);
					
				});
			});
			jQuery(document).on("click", ".wpec_quick_view_ultimate_click.colorbox", function(){
				
				var product_id = jQuery(this).attr('id');
				var product_url = jQuery(this).attr('data-link');
				<?php if ( $wpec_quick_view_ultimate_popup_content == 'full_page' ) { ?>
				var url = product_url;
				<?php } elseif ( $wpec_quick_view_ultimate_popup_content == 'custom_template' ) { ?>
				var is_shop = '<?php echo ( is_archive() && wpsc_is_viewable_taxonomy() ? 'no': 'yes' ); ?>';
				<?php if ( is_archive() && wpsc_is_viewable_taxonomy() ) { 
				$term = get_queried_object();
				?>
				var is_category = '<?php echo $term->term_id; ?>';
				<?php } else { ?>
				var is_category = 'no';
				<?php } ?>
				var url = '<?php echo admin_url('admin-ajax.php', 'relative');?>'+'?action=quick_view_custom_template_load&product_id='+product_id+'&is_shop='+is_shop+'&is_category='+is_category+'&security=<?php echo wp_create_nonce("quick_view_custom_template_load");?>';
				auto_Dimensions = false;
				<?php } else { ?>
                var url = '<?php echo admin_url('admin-ajax.php', 'relative');?>'+'?action=wpec_quick_view_ultimate_clicked&product_id='+product_id+'&product_url='+product_url+'&security=<?php echo wp_create_nonce("quick-view-clicked");?>';
				<?php } ?>
				
				var popup_wide = <?php echo (int) get_option('wpec_quick_view_ultimate_colorbox_popup_width', 600 ); ?>;
				var popup_tall = <?php echo (int) get_option('wpec_quick_view_ultimate_colorbox_popup_height', 460 ); ?>;
				if ( wpec_qv_getWidth()  <= 600 ) {
					popup_wide = '100%';
					popup_tall = '90%';
				}
				
				jQuery.colorbox({
					href		: url,
					<?php if ( $wpec_quick_view_ultimate_popup_content != 'custom_template' ) { ?>
					iframe		: true,
					<?php } ?>
					opacity		: 0.85,
					scrolling	: true,
					initialWidth: 100,
					initialHeight: 100,
					innerWidth	: popup_wide,
					innerHeight	: popup_tall,
					maxWidth  	: '100%',
					maxHeight  	: '90%',
					returnFocus : true,
					transition  : '<?php echo $wpec_quick_view_ultimate_colorbox_transition;?>',
					speed		: <?php echo $wpec_quick_view_ultimate_colorbox_speed;?>,
					fixed		: <?php echo $wpec_quick_view_ultimate_colorbox_center_on_scroll;?>
				});
				return false;
			});
			<?php	
			}
			?>
			
		</script>
        <style type="text/css">
		#cboxOverlay{background:<?php echo $wpec_quick_view_ultimate_colorbox_overlay_color;?> !important;}
        </style>
		<?php
	}
	public function wpec_quick_view_ultimate_clicked(){
		global $wpdb, $post, $wp_query, $wpsc_query, $_wpsc_is_in_custom_loop;
		remove_filter( "the_content", "wpsc_single_template", 12 );
		$single_theme_path = wpsc_get_template_file_path( 'wpsc-single_product.php' );
		$wpsc_temp_query = new WP_Query( array( 'p' => $_REQUEST['product_id'] , 'post_type' => 'wpsc-product','posts_per_page'=>1, 'preview' => false ) );
		
		//echo '<link rel="stylesheet" type="text/css" href="'.get_bloginfo('stylesheet_url').'" media="all" />';
		wpsc_enqueue_user_script_and_css();
		
		require_once( ABSPATH.'wp-admin/includes/plugin.php' );
		$wpec_version = get_plugin_data( WP_PLUGIN_DIR.'/wp-e-commerce/wp-shopping-cart.php' );
		if ( version_compare( $wpec_version ['Version'], '3.8.14', '>=' ) && function_exists('wpsc_javascript_localizations') ) { 
			wp_localize_script( 'wp-e-commerce', 'wpsc_vars', wpsc_javascript_localizations() );
		}
		//wp_head();
		if ( version_compare( phpversion(), '5.0.0', '<' ) ) {
			wp_head();
		} else {
			include( WPEC_QV_ULTIMATE_DIR. '/lib/simple_html_dom.php' );
			ob_start();
			get_header();
			$header_html = ob_get_clean();
			$header_html = str_get_html( $header_html );
			foreach ( $header_html->find('link[type=text/css]') as $element ) {
				echo $element->outertext;
			}
			foreach ( $header_html->find('style') as $element ) {
				echo $element->outertext;
			}
			foreach ( $header_html->find('script') as $element ) {
				echo $element->outertext;
			}
		}
		?>
        <style type="text/css">
        #single_product_page_container{width:100% !important;}
		</style>
		<?php
		echo '<div id="main" class="single-product" style="padding:10px;">';
		list( $wp_query, $wpsc_temp_query ) = array( $wpsc_temp_query, $wp_query ); // swap the wpsc_query object
		$_wpsc_is_in_custom_loop = true;
	
		include( $single_theme_path );
	
		list( $wp_query, $wpsc_temp_query ) = array( $wpsc_temp_query, $wp_query ); // swap the wpsc_query objects back
		$_wpsc_is_in_custom_loop = false;
		
		echo '</div>';
		//wp_footer();
		if ( version_compare( phpversion(), '5.0.0', '<' ) ) {
			wp_footer();
		} else {
			ob_start();
			get_footer();
			$footer_html = ob_get_clean();
			$footer_html = str_get_html( $footer_html );
			foreach ( $footer_html->find('link[type=text/css]') as $element ) {
				echo $element->outertext;
			}
			foreach ( $footer_html->find('style') as $element ) {
				echo $element->outertext;
			}
			foreach ( $footer_html->find('script') as $element ) {
				echo $element->outertext;
			}
		}
		
		die();
	}
	
	public function strip_shortcodes ($content='') {
		$content = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $content);
		
		return $content;
	}
	
	public function limit_words($str='',$len=100,$more=true) {
		if (trim($len) == '' || $len < 0) $len = 100;
	   if ( $str=="" || $str==NULL ) return $str;
	   if ( is_array($str) ) return $str;
	   $str = trim($str);
	   $str = strip_tags($str);
	   if ( strlen($str) <= $len ) return $str;
	   $str = substr($str,0,$len);
	   if ( $str != "" ) {
			if ( !substr_count($str," ") ) {
					  if ( $more ) $str .= " ...";
					return $str;
			}
			while( strlen($str) && ($str[strlen($str)-1] != " ") ) {
					$str = substr($str,0,-1);
			}
			$str = substr($str,0,-1);
			if ( $more ) $str .= " ...";
			}
			return $str;
	}
	
	public function wpec_quick_view_ultimate_reload_cart() {
		global $wpsc_cart;
		include_once( wpsc_get_template_file_path( 'wpsc-cart_widget.php' ) );
		die();
	}
	
	public function a3_wp_admin() {
		wp_enqueue_style( 'a3rev-wp-admin-style', WPEC_QV_ULTIMATE_CSS_URL . '/a3_wp_admin.css' );
	}
	
	public function admin_sidebar_menu_css() {
		wp_enqueue_style( 'a3rev-wpec-qv-admin-sidebar-menu-style', WPEC_QV_ULTIMATE_CSS_URL . '/admin_sidebar_menu.css' );
	}
	
	public function plugin_extra_links($links, $plugin_name) {
		if ( $plugin_name != WPEC_QV_ULTIMATE_NAME) {
			return $links;
		}
		$links[] = '<a href="http://docs.a3rev.com/user-guides/plugins-extensions/wp-e-commerce/wpec-quick-view/" target="_blank">'.__('Documentation', 'wp-e-commerce-products-quick-view' ).'</a>';
		$links[] = '<a href="http://wordpress.org/support/plugin/wp-e-commerce-products-quick-view/" target="_blank">'.__('Support', 'wp-e-commerce-products-quick-view').'</a>';
		return $links;
	}

	public function settings_plugin_links($actions) {
		$actions = array_merge( array( 'settings' => '<a href="admin.php?page=wpec-quick-view">' . __( 'Settings', 'wp-e-commerce-products-quick-view' ) . '</a>' ), $actions );

		return $actions;
	}
}

$GLOBALS['wpec_quick_view_ultimate'] = new WPEC_Quick_View_Ultimate();

?>