<style>
<?php
global $wpec_qv_admin_interface, $wpec_qv_fonts_face;

// Container Style
global $wpec_quick_view_template_global_settings;
extract($wpec_quick_view_template_global_settings);
?>
@charset "UTF-8";
/* CSS Document */

/* Container Style */
#fancybox-content > div, #cboxLoadedContent {
	background-color: <?php echo $container_bg_color; ?> !important;
}
.quick_view_popup_container {
	padding:10px;
	/*Background*/
	background-color: <?php echo $container_bg_color; ?> !important;
}
.quick_view_product_gallery_container {
	width: <?php echo $gallery_container_wide; ?>% !important;
	float: <?php echo $gallery_position; ?> !important;
}
.quick_view_product_data_container {
<?php if ( $gallery_position == 'right' ) { ?>
	float: left !important;
<?php } else { ?>
	float: right !important;
<?php } ?>
	width: <?php echo ( 98 - $gallery_container_wide ); ?>% !important;
}

<?php
// Controls Style
global $wpec_quick_view_template_control_settings;
extract($wpec_quick_view_template_control_settings);
?>
/* Container Style */
.quick_view_control_container {
	z-index:100;
	/*-webkit-filter: grayscale(100%);
	-webkit-transition: all 0.5s linear;
	-moz-transition: all 0.5s linear;
	-o-transition: all 0.5s linear;
	transition: all 0.5s linear;*/
<?php if ( $control_transition == 'alway' ) { ?>
	opacity:1;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=1);
	-moz-opacity: 1;
	-khtml-opacity: 1;
<?php } else { ?>
	opacity: 0;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
	filter: alpha(opacity=0);
	-moz-opacity: 0;
	-khtml-opacity: 0;
<?php } ?>
}
#cboxLoadedContent:hover .quick_view_control_container, #fancybox-content:hover .quick_view_control_container {
	opacity:1;
	-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
	filter: alpha(opacity=1);
	-moz-opacity: 1;
	-khtml-opacity: 1;
}
.quick_view_previous_control {
	cursor:pointer;
	display:inline-block;
	position:absolute;
	margin-top:-25px;
	top:50%;
	left:5px;
	z-index:100;
}
.quick_view_next_control {
	cursor:pointer;
	display:inline-block;
	position:absolute;
	margin-top:-25px;
	top:50%;
	right:5px;
	z-index:100;
}

<?php
// Product Title Style
global $wpec_quick_view_template_product_title_settings;
extract( $wpec_quick_view_template_product_title_settings );
?>
/* Product Title Style */
.quick_view_product_title_container {
	text-align: <?php echo $title_alignment; ?> !important;
	/*Margin*/
	margin: <?php echo $title_margin_top; ?>px <?php echo $title_margin_right; ?>px <?php echo $title_margin_bottom; ?>px <?php echo $title_margin_left; ?>px !important;
	/*Padding*/
	padding: <?php echo $title_padding_top; ?>px <?php echo $title_padding_right; ?>px <?php echo $title_padding_bottom; ?>px <?php echo $title_padding_left; ?>px !important;
	/*Background*/
	background-color: <?php echo $title_bg_color; ?> !important;
	/* Shadow */
	<?php echo $wpec_qv_admin_interface->generate_shadow_css( $title_shadow ); ?>
	/*Border*/
	<?php echo $wpec_qv_admin_interface->generate_border_css( $title_border ); ?> 
}
.quick_view_product_title {
	text-transform: <?php echo $title_transformation; ?> !important;
	/* Font */
	<?php echo $wpec_qv_fonts_face->generate_font_css( $title_font ); ?>	
}
.quick_view_product_title:hover {
	color: <?php echo $title_font_hover_color; ?> !important;
}

<?php
// Product Rating Style
global $wpec_quick_view_template_product_rating_settings;
extract( $wpec_quick_view_template_product_rating_settings );
?>
/* Product Title Style */
.quick_view_product_rating_container {
	/*Margin*/
	margin: <?php echo $rating_margin_top; ?>px <?php echo $rating_margin_right; ?>px <?php echo $rating_margin_bottom; ?>px <?php echo $rating_margin_left; ?>px !important;
	/*Padding*/
	padding: <?php echo $title_padding_top; ?>px <?php echo $title_padding_right; ?>px <?php echo $title_padding_bottom; ?>px <?php echo $title_padding_left; ?>px !important;
	text-align: <?php echo $rating_alignment; ?> !important;
}
.quick_view_product_rating_container .star-rating {
<?php if ( $rating_alignment == 'center' ) { ?>
	float: none !important;
	margin:auto !important;
<?php } else { ?>
	float: <?php echo $rating_alignment; ?> !important;	
<?php } ?>
}
.quick_view_product_rating_container span.votetext {
	display:inline-block;	
}

<?php
// Product Description Style
global $wpec_quick_view_template_product_description_settings;
extract( $wpec_quick_view_template_product_description_settings );
?>
/* Product Description Style */
.quick_view_product_description_container {
	text-align: <?php echo $description_alignment; ?> !important;
	/*Margin*/
	margin: <?php echo $description_margin_top; ?>px <?php echo $description_margin_right; ?>px <?php echo $description_margin_bottom; ?>px <?php echo $description_margin_left; ?>px !important;
	/* Font */
	<?php echo $wpec_qv_fonts_face->generate_font_css( $description_font ); ?>
}
.quick_view_product_description_container * {
	text-align: <?php echo $description_alignment; ?> !important;
	/* Font */
	<?php echo $wpec_qv_fonts_face->generate_font_css( $description_font ); ?>
}
.quick_view_product_data_container {
	/* Font */
	<?php echo $wpec_qv_fonts_face->generate_font_css( $description_font ); ?>
}

<?php
// Product Meta Style
global $wpec_quick_view_template_product_meta_settings;
extract( $wpec_quick_view_template_product_meta_settings );
?>
/* Product Meta Style */
.quick_view_product_meta_container {
	margin:10px 0;	
}
.quick_view_product_meta {
	text-align: <?php echo $meta_alignment; ?> !important;
	/*Margin*/
	margin: <?php echo $meta_margin_top; ?>px <?php echo $meta_margin_right; ?>px <?php echo $meta_margin_bottom; ?>px <?php echo $meta_margin_left; ?>px !important;
}
.quick_view_product_meta .quick_view_product_meta_name {
	/* Font */
	<?php echo $wpec_qv_fonts_face->generate_font_css( $meta_name_font ); ?>
}
.quick_view_product_meta .quick_view_product_meta_value, .quick_view_product_meta a {
	/* Font */
	<?php echo $wpec_qv_fonts_face->generate_font_css( $meta_value_font ); ?>
}
.quick_view_product_meta a:hover {
	color: <?php echo $meta_value_font_hover_color; ?> !important;
}

<?php
// Product Price Style
global $wpec_quick_view_template_product_price_settings;
extract( $wpec_quick_view_template_product_price_settings );
?>
/* Product Price Style */
.quick_view_product_price_container {
	text-align: <?php echo $price_alignment; ?> !important;
	/*Margin*/
	margin: <?php echo $price_margin_top; ?>px <?php echo $price_margin_right; ?>px <?php echo $price_margin_bottom; ?>px <?php echo $price_margin_left; ?>px !important;
}
.quick_view_product_price_container .pricedisplay > span {
	margin:0 3px;
}
.quick_view_product_price_container span {
	/* Font */
	<?php echo $wpec_qv_fonts_face->generate_font_css( $price_font ); ?>
}
.quick_view_product_price_container .oldprice  {
	/* Font */
	<?php echo $wpec_qv_fonts_face->generate_font_css( $old_price_font ); ?>
	text-decoration: line-through !important;
}

<?php
// Product Add To Cart Style
global $wpec_quick_view_template_addtocart_settings;
extract( $wpec_quick_view_template_addtocart_settings );
?>
/* Product Add To Cart Style */
.quick_view_product_addtocart_button_container {
	display:block;
	text-align:center !important;
<?php if ( $addtocart_alignment == 'center' ) { ?>
	float: none !important;
<?php } else { ?>
	float: <?php echo $addtocart_alignment; ?> !important;	
<?php } ?>
}
.quick_view_product_addtocart_container .wpec_qv_add_to_cart_button {
	position:relative;
	display:inline-block;
	cursor:pointer;
}
.quick_view_product_addtocart_container .wpec_qv_add_to_cart_button.loading:before, .quick_view_product_addtocart_container .wpec_qv_add_to_cart_button.added:after {
	background-repeat:no-repeat;
	content: ".";
    position: absolute;
    width: 16px;
	height:16px;
	top:8px;
	text-indent: -999em;
}
.quick_view_product_addtocart_container .quick_view_add_to_cart_link.loading:before, .quick_view_product_addtocart_container .quick_view_add_to_cart_link.added:after {
	top:0 !important;	
}
.quick_view_product_addtocart_container .wpec_qv_add_to_cart_button.loading:before {
	background-image: url("<?php echo wpsc_loading_animation_url(); ?>") !important;
<?php if ( $addtocart_alignment == 'right' ) { ?>
	left: -26px !important;
<?php } else { ?>
	right: -26px;
<?php } ?>
}
.quick_view_product_addtocart_container .wpec_qv_add_to_cart_button.added:after {
	background-image: url("<?php echo $addtocart_success_icon; ?>") !important;
<?php if ( $addtocart_alignment == 'right' ) { ?>
	left: -26px !important;
<?php } else { ?>
	right: -26px;
<?php } ?>
}
.quick_view_product_addtocart_container .quick_view_add_to_cart_button {
	/*Margin*/
	margin: <?php echo $addtocart_button_margin_top; ?>px <?php echo $addtocart_button_margin_right; ?>px <?php echo $addtocart_button_margin_bottom; ?>px <?php echo $addtocart_button_margin_left; ?>px !important;
	/*Padding*/
	padding: <?php echo $addtocart_button_padding_top; ?>px <?php echo $addtocart_button_padding_right; ?>px <?php echo $addtocart_button_padding_bottom; ?>px <?php echo $addtocart_button_padding_left; ?>px !important;
	
	/*Background*/
	background-color: <?php echo $addtocart_button_bg_colour; ?> !important;
	background: -webkit-gradient(
					linear,
					left top,
					left bottom,
					color-stop(.2, <?php echo $addtocart_button_bg_colour_from; ?>),
					color-stop(1, <?php echo $addtocart_button_bg_colour_to; ?>)
				) !important;;
	background: -moz-linear-gradient(
					center top,
					<?php echo $addtocart_button_bg_colour_from; ?> 20%,
					<?php echo $addtocart_button_bg_colour_to; ?> 100%
				) !important;;
	
		
	/*Border*/
	<?php echo $wpec_qv_admin_interface->generate_border_css( $addtocart_button_border ); ?>
	
	/* Shadow */
	<?php echo $wpec_qv_admin_interface->generate_shadow_css( $addtocart_button_shadow ); ?>
	
	/* Font */
	<?php echo $wpec_qv_fonts_face->generate_font_css( $addtocart_button_font ); ?>
	
	text-align: center !important;
	text-decoration: none !important;
}
.quick_view_product_addtocart_container .quick_view_add_to_cart_link {
	padding: 0 !important;
	margin:0 !important;
	border:none !important;
	background:none !important;
	box-shadow:none !important;
	/* Font */
	<?php echo $wpec_qv_fonts_face->generate_font_css( $addtocart_link_font ); ?>
}
.quick_view_product_addtocart_container .quick_view_add_to_cart_link:hover {
	color: <?php echo $addtocart_link_font_hover_colour; ?> !important;
}

/* Product Table Variations */
.quick_view_product_addtocart_container .wpsc_variation_forms table {
	border:none !important;
}
.quick_view_product_addtocart_container .wpsc_variation_forms table td, 
.quick_view_product_addtocart_container .wpsc_variation_forms table th {
	border:none !important;
	padding: 0 5px !important;
}
.quick_view_product_addtocart_container .wpsc_variation_forms table select {
	width:90% !important;
	margin:0 0 5px 0 !important;
}

@media only screen and (max-width: 600px) {
	.quick_view_product_gallery_container {
		width: 100% !important;
		float: none !important;
	}
	.quick_view_product_data_container {
		width: 100% !important;
		float: none !important;
	}
	.quick_view_control_container {
		-webkit-filter: none;
		-webkit-transition: none;
		-moz-transition: none;
		-o-transition: none;
		transition: none;
		opacity:1;
		-ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
		filter: alpha(opacity=1);
		-moz-opacity: 1;
		-khtml-opacity: 1;
	}
}

</style>
