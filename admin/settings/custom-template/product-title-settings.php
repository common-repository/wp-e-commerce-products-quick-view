<?php
/* "Copyright 2012 A3 Revolution Web Design" This software is distributed under the terms of GNU GENERAL PUBLIC LICENSE Version 3, 29 June 2007 */
// File Security Check
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<?php
/*-----------------------------------------------------------------------------------
WPEC Quick View Custom Template Product Title Settings

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

class WPEC_QV_Custom_Template_Product_Title_Settings extends WPEC_QV_Admin_UI
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
	public $option_name = 'wpec_quick_view_template_product_title_settings';
	
	/**
	 * @var string
	 * You must change to correct form key that you are working
	 */
	public $form_key = 'wpec_quick_view_template_product_title_settings';
	
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
				'success_message'	=> __( 'Product Title Settings successfully saved.', 'wp-e-commerce-products-quick-view' ),
				'error_message'		=> __( 'Error: Product Title Settings can not save.', 'wp-e-commerce-products-quick-view' ),
				'reset_message'		=> __( 'Product Title Settings successfully reseted.', 'wp-e-commerce-products-quick-view' ),
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
			'name'				=> 'product-title',
			'label'				=> __( 'Product Title', 'wp-e-commerce-products-quick-view' ),
			'callback_function'	=> 'wpec_qv_custom_template_product_title_settings_form',
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
				'name'		=> __( 'Product Title Style', 'wp-e-commerce-products-quick-view' ),
                'type' 		=> 'heading',
           	),
			array(  
				'name' 		=> __( 'Title Transformation', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'title_transformation',
				'type' 		=> 'onoff_radio',
				'default' 	=> 'none',
				'onoff_options' => array(
					array(
						'val' 				=> 'none',
						'text' 				=> __( 'None', 'wp-e-commerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'wp-e-commerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'wp-e-commerce-products-quick-view' ) ,
					),
					array(
						'val' 				=> 'uppercase',
						'text' 				=> __( 'Uppercase', 'wp-e-commerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'wp-e-commerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'wp-e-commerce-products-quick-view' ) ,
					),
					array(
						'val' 				=> 'lowercase',
						'text' 				=> __( 'Lowercase', 'wp-e-commerce-products-quick-view' ),
						'checked_label'		=> __( 'ON', 'wp-e-commerce-products-quick-view' ) ,
						'unchecked_label' 	=> __( 'OFF', 'wp-e-commerce-products-quick-view' ) ,
					),
				),
			),
			array(  
				'name' 		=> __( 'Title Alignment', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'title_alignment',
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
				'name' 		=> __( 'Title Font', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'title_font',
				'type' 		=> 'typography',
				'default'	=> array( 'size' => '18px', 'face' => 'Arial, sans-serif', 'style' => 'bold', 'color' => '#000000' )
			),
			array(  
				'name' 		=> __( 'Title Hover Colour', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'title_font_hover_color',
				'type' 		=> 'color',
				'default'	=> '#999999'
			),
			array(  
				'name' 		=> __( 'Title Container Background Colour', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'title_bg_color',
				'type' 		=> 'color',
				'default'	=> '#FFFFFF'
			),
			array(  
				'name' 		=> __( 'Title Container Border', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'title_border',
				'type' 		=> 'border',
				'default'	=> array( 'width' => '0px', 'style' => 'solid', 'color' => '#FFFFFF', 'corner' => 'square' , 'rounded_value' => 0 ),
			),
			array(  
				'name' => __( 'Title Container Shadow', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'title_shadow',
				'type' 		=> 'box_shadow',
				'default'	=> array( 'enable' => 0, 'h_shadow' => '5px' , 'v_shadow' => '5px', 'blur' => '2px' , 'spread' => '2px', 'color' => '#999999', 'inset' => '' )
			),
			array(  
				'name' 		=> __( 'Border Margin (Outside)', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'title_margin',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'title_margin_top',
	 										'name' 		=> __( 'Top', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
	 
	 								array(  'id' 		=> 'title_margin_bottom',
	 										'name' 		=> __( 'Bottom', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 5 ),
											
									array( 
											'id' 		=> 'title_margin_left',
	 										'name' 		=> __( 'Left', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'title_margin_right',
	 										'name' 		=> __( 'Right', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 							)
			),
			array(  
				'name' 		=> __( 'Border Padding (Inside)', 'wp-e-commerce-products-quick-view' ),
				'id' 		=> 'title_padding',
				'type' 		=> 'array_textfields',
				'ids'		=> array( 
	 								array( 
											'id' 		=> 'title_padding_top',
	 										'name' 		=> __( 'Top', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 
	 								array(  'id' 		=> 'title_padding_bottom',
	 										'name' 		=> __( 'Bottom', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'title_padding_left',
	 										'name' 		=> __( 'Left', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
											
									array( 
											'id' 		=> 'title_padding_right',
	 										'name' 		=> __( 'Right', 'wp-e-commerce-products-quick-view' ),
	 										'css'		=> 'width:40px;',
	 										'default'	=> 0 ),
	 							)
			),
			
        ));
	}
	
}

global $wpec_qv_custom_template_product_title_settings;
$wpec_qv_custom_template_product_title_settings = new WPEC_QV_Custom_Template_Product_Title_Settings();

/** 
 * wpec_qv_custom_template_product_title_settings_form()
 * Define the callback function to show subtab content
 */
function wpec_qv_custom_template_product_title_settings_form() {
	global $wpec_qv_custom_template_product_title_settings;
	$wpec_qv_custom_template_product_title_settings->settings_form();
}

?>