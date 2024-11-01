<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Quick View Under Image Style Settings

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

class WPEC_QV_Under_Image_Style_Settings extends WPEC_QV_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'button-style';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = '';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_quick_view_under_image_style';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 2;
	
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
				'success_message'	=> __( 'Under Image Style successfully saved.', 'wp-e-commerce-products-quick-view' ),
				'error_message'		=> __( 'Error: Under Image Style can not save.', 'wp-e-commerce-products-quick-view' ),
				'reset_message'		=> __( 'Under Image Style successfully reseted.', 'wp-e-commerce-products-quick-view' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->parent_tab . '_tab_end', array( $this, 'include_script' ) );
			
		add_action( $this->plugin_name . '_set_default_settings' , array( $this, 'set_default_settings' ) );
		//add_action( $this->plugin_name . '_get_all_settings' , array( $this, 'get_settings' ) );
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
			'name'				=> 'under-image-style',
			'label'				=> __( 'Under Image Style', 'wp-e-commerce-products-quick-view' ),
			'callback_function'	=> 'wpec_qv_under_image_style_settings_form',
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
            	'name' => __( 'Button/Hyperlink Show under Image', 'wp-e-commerce-products-quick-view' ),
                'type' => 'heading',
           	),
			array(  
				'name' 		=> __( 'Button or Hyperlink Type', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_type',
				'class' 	=> 'quick_view_ultimate_under_image_change',
				'type' 		=> 'switcher_checkbox',
				'default'	=> 'link',
				'checked_value'		=> 'link',
				'unchecked_value'	=> 'button',
				'checked_label'		=> __( 'Hyperlink', 'wp-e-commerce-products-quick-view' ),
				'unchecked_label' 	=> __( 'Button', 'wp-e-commerce-products-quick-view' ),
			),
			array(  
				'name' 		=> __( 'Button or Hyperlink Align', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_alink',
				'css' 		=> 'width:80px;',
				'type' 		=> 'select',
				'default'	=> 'center',
				'options'	=> array(
						'center'		=> __( 'Center', 'wp-e-commerce-products-quick-view' ) ,	
						'left'			=> __( 'Left', 'wp-e-commerce-products-quick-view' ) ,	
						'right'			=> __( 'Right', 'wp-e-commerce-products-quick-view' ) ,	
					),
			),
			array(  
				'name' 		=> __( 'Button or Hyperlink magrin', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> 'px '. __( 'Above/Below', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_margin',
				'type' 		=> 'text',
				'css' 		=> 'width:40px;',
				'default'	=> '10'
			),
			
			array(
            	'name' 		=> __( 'Hyperlink Styling', 'wp-e-commerce-products-quick-view' ),
                'type' 		=> 'heading',
          		'class'		=> 'show_under_image_hyperlink_styling'
           	),
			array(  
				'name' => __( 'Hyperlink Text', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Text for Hyperlink show under image', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_link_text',
				'type' 		=> 'text',
				'default'	=> __('Quick View', 'wp-e-commerce-products-quick-view' )
			),
			array(  
				'name' 		=> __( 'Hyperlink Font', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_link_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial', 'style' => 'bold', 'color' => '#000000' )
			),
			
			array(  
				'name' 		=> __( 'Hyperlink hover Colour', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_link_font_hover_color',
				'type' 		=> 'color',
				'default'	=> '#999999'
			),
			
			array(
            	'name' 		=> __( 'Button Styling', 'wp-e-commerce-products-quick-view' ),
                'type' 		=> 'heading',
          		'class' 	=> 'show_under_image_button_styling'
           	),
			array(  
				'name' 		=> __( 'Button Text', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Text for Button show under image', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_text',
				'type' 		=> 'text',
				'default'	=> __('Quick View', 'wp-e-commerce-products-quick-view' )
			),
			array(  
				'name' 		=> __( 'Button Padding', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Padding from Button text to Button border show under image', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array(  'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_padding_tb',
	 										'name' 		=> __( 'Top/Bottom', 'wp-e-commerce-products-quick-view' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '7' ),
	 
	 								array(  'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_padding_lr',
	 										'name' 		=> __( 'Left/Right', 'wp-e-commerce-products-quick-view' ),
	 										'class' 	=> '',
	 										'css'		=> 'width:40px;',
	 										'default'	=> '8' ),
	 							)
			),
			array(  
				'name' 		=> __( 'Background Colour', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Default', 'wp-e-commerce-products-quick-view' ) . ' [default_value]',
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_bg',
				'type' 		=> 'color',
				'default'	=> '#000000'
			),
			array(  
				'name' 		=> __( 'Background Colour Gradient From', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Default', 'wp-e-commerce-products-quick-view' ) . ' [default_value]',
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_bg_from',
				'type' 		=> 'color',
				'default'	=> '#000000'
			),
			
			array(  
				'name' 		=> __( 'Background Colour Gradient To', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Default', 'wp-e-commerce-products-quick-view' ) . ' [default_value]',
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_bg_to',
				'type' 		=> 'color',
				'default'	=> '#000000'
			),
			array(  
				'name' 		=> __( 'Button Border', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '1px', 'style' => 'solid', 'color' => '#000000', 'corner' => 'rounded' , 'rounded_value' => 3 ),
			),
			array(  
				'name' 		=> __( 'Button Font', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial', 'style' => 'bold', 'color' => '#FFFFFF' )
			),
			array(  
				'name' 		=> __( 'CSS Class', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __( 'Enter your own button CSS class', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'wpec_quick_view_ultimate_under_image_bt_class',
				'type' 		=> 'text',
				'default'	=> ''
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input[name='wpec_quick_view_ultimate_under_image_bt_type']:checked").val() == 'link') {
		$(".show_under_image_hyperlink_styling").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		$(".show_under_image_button_styling").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
	} else {
		$(".show_under_image_hyperlink_styling").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		$(".show_under_image_button_styling").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	}
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.quick_view_ultimate_under_image_change', function( event, value, status ) {
		$(".show_under_image_hyperlink_styling").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		$(".show_under_image_button_styling").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true') {
			$(".show_under_image_hyperlink_styling").slideDown();
			$(".show_under_image_button_styling").slideUp();
		} else {
			$(".show_under_image_hyperlink_styling").slideUp();
			$(".show_under_image_button_styling").slideDown();
		}
	});
});
})(jQuery);
</script>
    <?php	
	}
}

global $wpec_qv_under_image_style_settings;
$wpec_qv_under_image_style_settings = new WPEC_QV_Under_Image_Style_Settings();

/** 
 * wpec_qv_under_image_style_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_qv_under_image_style_settings_form() {
	global $wpec_qv_under_image_style_settings;
	$wpec_qv_under_image_style_settings->settings_form();
}

?>