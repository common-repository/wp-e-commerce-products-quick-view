<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Quick View Custom Template Add To Cart Button Settings

TABLE OF CONTENTS

- var parent_tab
- var subtab_data
- var option_name
- var form_key
- var position
- var form_fields
- var form_messages

- __construct()
- subtab_init()
- set_default_settings()
- get_settings()
- subtab_data()
- add_subtab()
- settings_form()
- init_form_fields()

-----------------------------------------------------------------------------------*/

class WPEC_QV_Custom_Template_AddToCart_Button_Settings extends WPEC_QV_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'product-data';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wpec_quick_view_template_addtocart_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_quick_view_template_addtocart_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 5;
	
	/**
	 * @var array
	 */
	public $form_fields = array();
	
	/**
	 * @var array
	 */
	public $form_messages = array();
	
	/*-----------------------------------------------------------------------------------*/
	/* __construct() */
	/* Settings Constructor */
	/*-----------------------------------------------------------------------------------*/
	public function __construct() {
		$this->init_form_fields();
		$this->subtab_init();
		
		$this->form_messages = array(
				'success_message'	=> __( 'Add to Cart Settings successfully saved.', 'wp-e-commerce-products-quick-view' ),
				'error_message'		=> __( 'Error: Add to Cart Settings can not save.', 'wp-e-commerce-products-quick-view' ),
				'reset_message'		=> __( 'Add to Cart Settings successfully reseted.', 'wp-e-commerce-products-quick-view' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->parent_tab . '_tab_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		
		add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* subtab_init() */
	/* Sub Tab Init */
	/*-----------------------------------------------------------------------------------*/
	public function subtab_init() {
		
		add_filter( $this->plugin_name . '-' . $this->parent_tab . '_settings_subtabs_array', array( $this, 'add_subtab' ), $this->position );
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* set_default_settings()
	/* Set default settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function set_default_settings() {
		global $wpec_qv_admin_interface;
		
		$wpec_qv_admin_interface->reset_settings( $this->form_fields, $this->option_name, false );
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* get_settings()
	/* Get settings with function called from Admin Interface */
	/*-----------------------------------------------------------------------------------*/
	public function get_settings() {
		global $wpec_qv_admin_interface;
		
		$wpec_qv_admin_interface->get_settings( $this->form_fields, $this->option_name );
	}
	
	/**
	 * subtab_data()
	 * Get SubTab Data
	 * =============================================
	 * array ( 
	 *		'name'				=> 'my_subtab_name'				: (required) Enter your subtab name that you want to set for this subtab
	 *		'label'				=> 'My SubTab Name'				: (required) Enter the subtab label
	 * 		'callback_function'	=> 'my_callback_function'		: (required) The callback function is called to show content of this subtab
	 * )
	 *
	 */
	public function subtab_data() {
		
		$subtab_data = array( 
			'name'				=> 'add-to-cart',
			'label'				=> __( 'Add to Cart', 'wp-e-commerce-products-quick-view' ),
			'callback_function'	=> 'wpec_qv_custom_template_addtocart_button_settings_form',
		);
		
		if ( $this->subtab_data ) return $this->subtab_data;
		return $this->subtab_data = $subtab_data;
		
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* add_subtab() */
	/* Add Subtab to Admin Init
	/*-----------------------------------------------------------------------------------*/
	public function add_subtab( $subtabs_array ) {
	
		if ( ! is_array( $subtabs_array ) ) $subtabs_array = array();
		$subtabs_array[] = $this->subtab_data();
		
		return $subtabs_array;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* settings_form() */
	/* Call the form from Admin Interface
	/*-----------------------------------------------------------------------------------*/
	public function settings_form() {
		global $wpec_qv_admin_interface;
		
		$output = '';
		$output .= $wpec_qv_admin_interface->admin_forms( $this->form_fields, $this->form_key, $this->option_name, $this->form_messages );
		
		return $output;
	}
	
	/*-----------------------------------------------------------------------------------*/
	/* init_form_fields() */
	/* Init all fields of this form */
	/*-----------------------------------------------------------------------------------*/
	public function init_form_fields() {
		
  		// Define settings			
     	$this->form_fields = apply_filters( $this->option_name . '_settings_fields', array(
			
			array(
            	'name' => __( 'Add To Cart Setup', 'wp-e-commerce-products-quick-view' ),
                'type' => 'heading',
           	),
			array(  
				'name' 		=> __( 'Add To Cart', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'show_addtocart',
				'class'		=> 'show_addtocart',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wp-e-commerce-products-quick-view' ),
				'unchecked_label' 	=> __( 'OFF', 'wp-e-commerce-products-quick-view' ),
			),
			
			array(
				'name'		=> __( 'Add To Cart Button / Hyperlink', 'wp-e-commerce-products-quick-view' ),
                'type' 		=> 'heading',
				'class'		=> 'show_addtocart_container'
           	),
			array(  
				'name' 		=> __( 'Button or Hyperlink Type', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_button_type',
				'class' 	=> 'addtocart_button_type',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'button',
				'checked_value'		=> 'button',
				'unchecked_value'	=> 'link',
				'checked_label'		=> __( 'Button', 'wp-e-commerce-products-quick-view' ),
				'unchecked_label' 	=> __( 'Hyperlink', 'wp-e-commerce-products-quick-view' ),
			),
			array(  
				'name' 		=> __( 'Added To Cart Alignment', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_alignment',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'left',
				'onoff_options' => array(
					array(
						'val' 				=> 'left',
						'text' 				=> __( 'Left', 'wp-e-commerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'wp-e-commerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'wp-e-commerce-products-quick-view' ) ,
					),
					array(
						'val' 				=> 'center',
						'text' 				=> __( 'Center', 'wp-e-commerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'wp-e-commerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'wp-e-commerce-products-quick-view' ) ,
					),
					array(
						'val' 				=> 'right',
						'text' 				=> __( 'Right', 'wp-e-commerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'wp-e-commerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'wp-e-commerce-products-quick-view' ) ,
					),
				),
			),
			array(  
				'name' 		=> __( 'Added To Cart Success Icon', 'wp-e-commerce-products-quick-view' ),
				'desc_tip'	=> __( 'Upload a 16px x 16px image, support .jpg, .pgn, .jpeg, .gif formats.', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_success_icon',
				'type' 		=> 'upload',
				'default'	=> WPEC_QV_ULTIMATE_IMAGES_URL.'/addtocart_success.png',
			),
			
			array(
            	'name' 		=> __( 'Add To Cart Hyperlink Styling', 'wp-e-commerce-products-quick-view' ),
                'type' 		=> 'heading',
          		'class'		=> 'addtocart_hyperlink_styling_container'
           	),
			array(  
				'name' 		=> __( 'Hyperlink Text', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_link_text',
				'type' 		=> 'text',
				'default'	=> __('Add to cart', 'wp-e-commerce-products-quick-view' )
			),
			array(  
				'name' 		=> __( 'Hyperlink Font', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_link_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#21759B' )
			),
			array(  
				'name' 		=> __( 'Hyperlink Hover Colour', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_link_font_hover_colour',
				'type' 		=> 'color',
				'default'	=> '#D54E21'
			),
			
			array(
            	'name' 		=> __( 'Add To Cart Button Styling', 'wp-e-commerce-products-quick-view' ),
                'type' 		=> 'heading',
          		'class' 	=> 'addtocart_button_styling_container'
           	),
			array(  
				'name' 		=> __( 'Button Text', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_button_text',
				'type' 		=> 'text',
				'default'	=> __('Add to cart', 'wp-e-commerce-products-quick-view' )
			),
			array(  
				'name' 		=> __( 'Background Colour', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Default', 'wp-e-commerce-products-quick-view' ) . ' [default_value]',
				'id' 		=> 'addtocart_button_bg_colour',
				'type' 		=> 'color',
				'default'	=> '#476381'
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient From', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Default', 'wp-e-commerce-products-quick-view' ) . ' [default_value]',
				'id' 		=> 'addtocart_button_bg_colour_from',
				'type' 		=> 'color',
				'default'	=> '#538bbc'
			),
			
			array(  
				'name' 		=> __( 'Background Colour Gradient To', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Default', 'wp-e-commerce-products-quick-view' ) . ' [default_value]',
				'id' 		=> 'addtocart_button_bg_colour_to',
				'type' 		=> 'color',
				'default'	=> '#476381'
			),
			array(  
				'name' 		=> __( 'Button Font', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_button_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#FFFFFF' )
			),
			array(  
				'name' 		=> __( 'Button Border', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_button_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#476381', 'corner' => 'rounded' , 'top_left_corner' => 3 , 'top_right_corner' => 3 , 'bottom_left_corner' => 3 , 'bottom_right_corner' => 3 ),
			),
			array(  
				'name' => __( 'Button Shadow', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_button_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 0, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#999999', 'inset' => '' )
			),
			array(  
				'name' 		=> __( 'Border Margin (Outside)', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_button_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'addtocart_button_margin_top',
	 										'name' 		=> __( 'Top', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '5' ),
									array(  'id' 		=> 'addtocart_button_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '10' ),
	 								array(  'id' 		=> 'addtocart_button_margin_left',
	 										'name' 		=> __( 'Left', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '0' ),
									array(  'id' 		=> 'addtocart_button_margin_right',
	 										'name' 		=> __( 'Right', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '0' ),
	 							)
			),
			array(  
				'name' 		=> __( 'Border Padding (Inside)', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Padding from Button text to Button border', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'addtocart_button_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'addtocart_button_padding_top',
	 										'name' 		=> __( 'Top', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '7' ),
									array(  'id' 		=> 'addtocart_button_padding_bottom',
	 										'name' 		=> __( 'Bottom', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '7' ),
	 								array(  'id' 		=> 'addtocart_button_padding_left',
	 										'name' 		=> __( 'Left', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '8' ),
									array(  'id' 		=> 'addtocart_button_padding_right',
	 										'name' 		=> __( 'Right', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> '8' ),
	 							)
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.addtocart_button_type:checked").val() == 'button') {
		$(".addtocart_button_styling_container").slideDown();
		$(".addtocart_hyperlink_styling_container").slideUp();
		//$(".addtocart_button_styling_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		//$(".addtocart_hyperlink_styling_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	} else {
		$(".addtocart_button_styling_container").slideUp();
		$(".addtocart_hyperlink_styling_container").slideDown();
		//$(".addtocart_button_styling_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		//$(".addtocart_hyperlink_styling_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	}
	
	if ( $("input.show_addtocart:checked").val() == '1') {
		$(".show_addtocart_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".show_addtocart_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		$(".addtocart_button_styling_container").slideUp();
		$(".addtocart_hyperlink_styling_container").slideUp();
	}
		
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.addtocart_button_type', function( event, value, status ) {
		//$(".addtocart_button_styling_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		//$(".addtocart_hyperlink_styling_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true') {
			$(".addtocart_button_styling_container").slideDown();
			$(".addtocart_hyperlink_styling_container").slideUp();
		} else {
			$(".addtocart_button_styling_container").slideUp();
			$(".addtocart_hyperlink_styling_container").slideDown();
		}
	});
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_addtocart', function( event, value, status ) {
		$(".show_addtocart_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".show_addtocart_container").slideDown();
			if ( $("input.addtocart_button_type:checked").val() == 'button') {
				$(".addtocart_button_styling_container").slideDown();
			} else {
				$(".addtocart_hyperlink_styling_container").slideDown();
			}
		} else {
			$(".show_addtocart_container").slideUp();
			$(".addtocart_button_styling_container").slideUp();
			$(".addtocart_hyperlink_styling_container").slideUp()
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
}

global $wpec_qv_custom_template_addtocart_button_settings;
$wpec_qv_custom_template_addtocart_button_settings = new WPEC_QV_Custom_Template_AddToCart_Button_Settings();

/** 
 * wpec_qv_custom_template_addtocart_button_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_qv_custom_template_addtocart_button_settings_form() {
	global $wpec_qv_custom_template_addtocart_button_settings;
	$wpec_qv_custom_template_addtocart_button_settings->settings_form();
}

?>