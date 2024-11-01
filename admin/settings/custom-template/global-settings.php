<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Quick View Custom Template Global Settings

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

class WPEC_QV_Custom_Template_Global_Settings extends WPEC_QV_Admin_UI
{
	
	/**
	 * @var string
	 */
	private $parent_tab = 'settings';
	
	/**
	 * @var array
	 */
	private $subtab_data;
	
	/**
	 * @var string
	 * You must change to correct option name that you are working
	 */
	public $option_name = 'wpec_quick_view_template_global_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_quick_view_template_global_settings';
	
	/**
	 * @var string
	 * You can change the order show of this sub tab in list sub tabs
	 */
	private $position = 1;
	
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
				'success_message'	=> __( 'Global Settings successfully saved.', 'wp-e-commerce-products-quick-view' ),
				'error_message'		=> __( 'Error: Global Settings can not save.', 'wp-e-commerce-products-quick-view' ),
				'reset_message'		=> __( 'Global Settings successfully reseted.', 'wp-e-commerce-products-quick-view' ),
			);
			
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
			'name'				=> 'settings',
			'label'				=> __( 'Container Style', 'wp-e-commerce-products-quick-view' ),
			'callback_function'	=> 'wpec_qv_custom_template_global_settings_form',
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
				'type'		=> 'heading'
			),
			array(  
				'name' 		=> __( 'Gallery Container Wide', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'gallery_container_wide',
				'desc'		=> '%',
				'type' 		=> 'slider',
				'default'	=> 50,
				'min'		=> 30,
				'max'		=> 70,
				'increment'	=> 1
			),
			array(  
				'name' 		=> __( 'Gallery Position', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'gallery_position',
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
						'val' 				=> 'right',
						'text' 				=> __( 'Right', 'wp-e-commerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'wp-e-commerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'wp-e-commerce-products-quick-view' ) ,
					),
				),
			),
			array(  
				'name' 		=> __( 'Pop-up Container Background Colour', 'wp-e-commerce-products-quick-view' ),
				'desc' 		=> __('Default', 'wp-e-commerce-products-quick-view' ). ' [default_value]',
				'id' 		=> 'container_bg_color',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
        ));
	}
}

global $wpec_qv_custom_template_global_settings;
$wpec_qv_custom_template_global_settings = new WPEC_QV_Custom_Template_Global_Settings();

/** 
 * wpec_qv_custom_template_global_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_qv_custom_template_global_settings_form() {
	global $wpec_qv_custom_template_global_settings;
	$wpec_qv_custom_template_global_settings->settings_form();
}

?>