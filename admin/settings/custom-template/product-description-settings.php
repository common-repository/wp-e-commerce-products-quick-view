<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Quick View Custom Template Product Short Description Settings

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

class WPEC_QV_Custom_Template_Product_Description_Settings extends WPEC_QV_Admin_UI
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
	public $option_name = 'wpec_quick_view_template_product_description_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_quick_view_template_product_description_settings';
	
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
				'success_message'	=> __( 'Product Description Settings successfully saved.', 'wp-e-commerce-products-quick-view' ),
				'error_message'		=> __( 'Error: Product Description Settings can not save.', 'wp-e-commerce-products-quick-view' ),
				'reset_message'		=> __( 'Product Description Settings successfully reseted.', 'wp-e-commerce-products-quick-view' ),
			);
			
		add_action( $this->plugin_name . '-' . $this->form_key . '_settings_end', array( $this, 'include_script' ) );
									
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
			'name'				=> 'product-description',
			'label'				=> __( 'Product Description', 'wp-e-commerce-products-quick-view' ),
			'callback_function'	=> 'wpec_qv_custom_template_product_description_settings_form',
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
				'name'		=> __( 'Product Description Setup', 'wp-e-commerce-products-quick-view' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Product Description', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'show_description',
				'class'		=> 'show_description',
				'type' 		=> 'onoff_checkbox',
				'default'	=> 1,
				'checked_value'		=> 1,
				'unchecked_value' 	=> 0,
				'checked_label'		=> __( 'ON', 'wp-e-commerce-products-quick-view' ),
				'unchecked_label' 	=> __( 'OFF', 'wp-e-commerce-products-quick-view' ),
			),
			
			array(
            	'name' 		=> __( 'Pull Product Description From', 'wp-e-commerce-products-quick-view' ),
                'type' 		=> 'heading',
				'class'		=> 'show_description_container',
           	),
			array(  
				'name' 		=> __( "Product Short Description", 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'pull_description_from',
				'class'		=> 'pull_description_from',
				'type' 		=> 'onoff_radio',
				'default'	=> 'short_description',
				'onoff_options' => array(
					array(
						'val' 				=> 'short_description',
						'checked_label'		=> 'ON',
						'unchecked_label' 	=> 'OFF',
					),
				),
			),
			array(  
				'name' 		=> __( 'Product Description', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'pull_description_from',
				'class'		=> 'pull_description_from',
				'type' 		=> 'onoff_radio',
				'default'	=> 'description',
				'onoff_options' => array(
					array(
						'val' 				=> 'description',
						'checked_label'		=> 'ON',
						'unchecked_label' 	=> 'OFF',
					),
				),
			),
			
			array(
                'type' 		=> 'heading',
				'class'		=> 'description_characters_container',
           	),
			array(  
				'name' 		=> __( 'Number of Characters', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'description_characters',
				'type' 		=> 'text',
				'css'		=> 'width:40px;',
				'default'	=> 300
			),
			
			array(
				'name'		=> __( 'Product Description Style', 'wp-e-commerce-products-quick-view' ),
                'type' 		=> 'heading',
				'class'		=> 'show_description_container'
           	),
			array(  
				'name' 		=> __( 'Description Font', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'description_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '12px', 'face' => 'Arial, sans-serif', 'style' => 'normal', 'color' => '#000000' )
			),
			array(  
				'name' 		=> __( 'Description Alignment', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'description_alignment',
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
				'name' 		=> __( 'Description Margin', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'description_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'description_margin_top',
	 										'name' 		=> __( 'Top', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
	 
	 								array(  'id' 		=> 'description_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
											
									array( 
											'id' 		=> 'description_margin_left',
	 										'name' 		=> __( 'Left', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'description_margin_right',
	 										'name' 		=> __( 'Right', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 							)
			),
			
        ));
	}
	
	public function include_script() {
	?>
<script>
(function($) {
$(document).ready(function() {
	if ( $("input.pull_description_from:checked").val() == 'short_description' ) {
		$(".description_characters_container").hide();
	}
	
	if ( $("input.show_description:checked").val() == '1') {
		$(".show_description_container").css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
	} else {
		$(".show_description_container").css( {'visibility': 'hidden', 'height' : '0px', 'overflow' : 'hidden'} );
		$(".description_characters_container").hide();
	}
	
	$(document).on( "a3rev-ui-onoff_checkbox-switch", '.show_description', function( event, value, status ) {
		$(".show_description_container").hide().css( {'visibility': 'visible', 'height' : 'auto', 'overflow' : 'inherit'} );
		if ( status == 'true' ) {
			$(".show_description_container").slideDown();
			if ( $("input.pull_description_from:checked").val() == 'description' ) {
				$(".description_characters_container").slideDown();
			}
		} else {
			$(".show_description_container").slideUp();
			$(".description_characters_container").slideUp();
		}
	});
	
	$(document).on( "a3rev-ui-onoff_radio-switch", '.pull_description_from', function( event, value, status ) {
		if ( value == 'description' && status == 'true' ) {
			$('.description_characters_container').slideDown();
		} else {
			$('.description_characters_container').slideUp();
		}
	});
	
});
})(jQuery);
</script>
    <?php	
	}
	
}

global $wpec_qv_custom_template_product_description_settings;
$wpec_qv_custom_template_product_description_settings = new WPEC_QV_Custom_Template_Product_Description_Settings();

/** 
 * wpec_qv_custom_template_product_description_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_qv_custom_template_product_description_settings_form() {
	global $wpec_qv_custom_template_product_description_settings;
	$wpec_qv_custom_template_product_description_settings->settings_form();
}

?>