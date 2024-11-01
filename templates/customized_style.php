<style>
<?php
global $wpec_qv_admin_interface, $wpec_qv_fonts_face;

$wpec_quick_view_ultimate_on_hover_bt_alink = get_option( 'wpec_quick_view_ultimate_on_hover_bt_alink' );
$wpec_quick_view_ultimate_on_hover_bt_padding_tb = get_option( 'wpec_quick_view_ultimate_on_hover_bt_padding_tb' );
$wpec_quick_view_ultimate_on_hover_bt_padding_lr = get_option( 'wpec_quick_view_ultimate_on_hover_bt_padding_lr' );
$wpec_quick_view_ultimate_on_hover_bt_bg = get_option( 'wpec_quick_view_ultimate_on_hover_bt_bg' );
$wpec_quick_view_ultimate_on_hover_bt_bg_from = get_option( 'wpec_quick_view_ultimate_on_hover_bt_bg_from' );
$wpec_quick_view_ultimate_on_hover_bt_bg_to = get_option( 'wpec_quick_view_ultimate_on_hover_bt_bg_to' );
$wpec_quick_view_ultimate_on_hover_bt_border = get_option( 'wpec_quick_view_ultimate_on_hover_bt_border' );
$wpec_quick_view_ultimate_on_hover_bt_font = get_option( 'wpec_quick_view_ultimate_on_hover_bt_font' );
$wpec_quick_view_ultimate_on_hover_bt_shadow = get_option( 'wpec_quick_view_ultimate_on_hover_bt_shadow' );
$wpec_quick_view_ultimate_on_hover_bt_transparent = get_option( 'wpec_quick_view_ultimate_on_hover_bt_transparent' );

$wpec_quick_view_ultimate_enable = get_option('wpec_quick_view_ultimate_enable');
$wpec_quick_view_ultimate_type = get_option('wpec_quick_view_ultimate_type');

if( $wpec_quick_view_ultimate_enable == '1' ) {
?>
.wpec_quick_view_ultimate_container{text-align:<?php echo $wpec_quick_view_ultimate_on_hover_bt_alink;?>;clear:both;width:100%;}
.wpec_quick_view_ultimate_container span{
	<?php echo $wpec_qv_fonts_face->generate_font_css( $wpec_quick_view_ultimate_on_hover_bt_font ); ?>
	text-align:<?php echo $wpec_quick_view_ultimate_on_hover_bt_alink;?> !important;
	padding: <?php echo $wpec_quick_view_ultimate_on_hover_bt_padding_tb; ?>px <?php echo $wpec_quick_view_ultimate_on_hover_bt_padding_lr; ?>px !important;
}

.product_hover .wpec_quick_view_ultimate_container span.wpec_quick_view_ultimate_button{
	color:<?php echo $wpec_quick_view_ultimate_on_hover_bt_font['color'];?>;
	<?php echo $wpec_qv_admin_interface->generate_border_css( $wpec_quick_view_ultimate_on_hover_bt_border ); ?>
	background: <?php echo $wpec_quick_view_ultimate_on_hover_bt_bg;?>;
	background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $wpec_quick_view_ultimate_on_hover_bt_bg_from;?>), to(<?php echo $wpec_quick_view_ultimate_on_hover_bt_bg_to;?>));
	background: -webkit-linear-gradient(<?php echo $wpec_quick_view_ultimate_on_hover_bt_bg_from;?>, <?php echo $wpec_quick_view_ultimate_on_hover_bt_bg_to;?>);
	background: -moz-linear-gradient(center top, <?php echo $wpec_quick_view_ultimate_on_hover_bt_bg_from;?> 0%, <?php echo $wpec_quick_view_ultimate_on_hover_bt_bg_to;?> 100%);
	background: -moz-gradient(center top, <?php echo $wpec_quick_view_ultimate_on_hover_bt_bg_from;?> 0%, <?php echo $wpec_quick_view_ultimate_on_hover_bt_bg_to;?> 100%);
	<?php echo $wpec_qv_admin_interface->generate_shadow_css( $wpec_quick_view_ultimate_on_hover_bt_shadow ); ?>
	<?php
	if($wpec_quick_view_ultimate_on_hover_bt_transparent == 100) {
		?>
		opacity:1;
		<?php
	}else{
	?>
	opacity:0.<?php echo round( $wpec_quick_view_ultimate_on_hover_bt_transparent / 10 );?>;
	<?php
	}
	?>
	filter:alpha(opacity=<?php echo $wpec_quick_view_ultimate_on_hover_bt_transparent;?>);
}
<?php } ?>
<?php
$wpec_quick_view_ultimate_under_image_bt_type = get_option( 'wpec_quick_view_ultimate_under_image_bt_type' );
$wpec_quick_view_ultimate_under_image_bt_alink = get_option( 'wpec_quick_view_ultimate_under_image_bt_alink' );

$wpec_quick_view_ultimate_under_image_link_font = get_option( 'wpec_quick_view_ultimate_under_image_link_font' );
$wpec_quick_view_ultimate_under_image_link_font_hover_color = get_option( 'wpec_quick_view_ultimate_under_image_link_font_hover_color' );

$wpec_quick_view_ultimate_under_image_bt_padding_tb = get_option( 'wpec_quick_view_ultimate_under_image_bt_padding_tb' );
$wpec_quick_view_ultimate_under_image_bt_padding_lr = get_option( 'wpec_quick_view_ultimate_under_image_bt_padding_lr' );
$wpec_quick_view_ultimate_under_image_bt_bg = get_option( 'wpec_quick_view_ultimate_under_image_bt_bg' );
$wpec_quick_view_ultimate_under_image_bt_bg_from = get_option( 'wpec_quick_view_ultimate_under_image_bt_bg_from' );
$wpec_quick_view_ultimate_under_image_bt_bg_to = get_option( 'wpec_quick_view_ultimate_under_image_bt_bg_to' );
$wpec_quick_view_ultimate_under_image_bt_border = get_option( 'wpec_quick_view_ultimate_under_image_bt_border' );
$wpec_quick_view_ultimate_under_image_bt_font = get_option( 'wpec_quick_view_ultimate_under_image_bt_font' );
$wpec_quick_view_ultimate_under_image_bt_margin = get_option( 'wpec_quick_view_ultimate_under_image_bt_margin' );
$wpec_quick_view_ultimate_under_image_bt_class = get_option( 'wpec_quick_view_ultimate_under_image_bt_class' );

if( $wpec_quick_view_ultimate_enable == '1' ) {
?>
.wpec_quick_view_ultimate_content_under{text-align:<?php echo $wpec_quick_view_ultimate_under_image_bt_alink;?>;clear:both;display:block;width:100%;padding:<?php echo $wpec_quick_view_ultimate_under_image_bt_margin;?>px 0px;}
.wpec_quick_view_ultimate_content_under a.wpec_quick_view_ultimate_under_link{
	<?php echo $wpec_qv_fonts_face->generate_font_css( $wpec_quick_view_ultimate_under_image_link_font ); ?>
	text-align:<?php echo $wpec_quick_view_ultimate_under_image_bt_alink;?> !important;
}

.wpec_quick_view_ultimate_content_under a.wpec_quick_view_ultimate_under_link:hover{
	color:<?php echo $wpec_quick_view_ultimate_under_image_link_font_hover_color;?> !important;
}
.wpec_quick_view_ultimate_content_under a.wpec_quick_view_ultimate_under_button{
	<?php echo $wpec_qv_fonts_face->generate_font_css( $wpec_quick_view_ultimate_under_image_bt_font ); ?>
	<?php echo $wpec_qv_admin_interface->generate_border_css( $wpec_quick_view_ultimate_under_image_bt_border ); ?>
	text-align:center !important;
	padding: <?php echo $wpec_quick_view_ultimate_under_image_bt_padding_tb; ?>px <?php echo $wpec_quick_view_ultimate_under_image_bt_padding_lr; ?>px !important;
	background: <?php echo $wpec_quick_view_ultimate_under_image_bt_bg;?> !important;
	background: -webkit-gradient(linear, left top, left bottom, from(<?php echo $wpec_quick_view_ultimate_under_image_bt_bg_from;?>), to(<?php echo $wpec_quick_view_ultimate_under_image_bt_bg_to;?>)) !important;
	background: -webkit-linear-gradient(<?php echo $wpec_quick_view_ultimate_under_image_bt_bg_from;?>, <?php echo $wpec_quick_view_ultimate_under_image_bt_bg_to;?>) !important;
	background: -moz-linear-gradient(center top, <?php echo $wpec_quick_view_ultimate_under_image_bt_bg_from;?> 0%, <?php echo $wpec_quick_view_ultimate_under_image_bt_bg_to;?> 100%) !important;
	background: -moz-gradient(center top, <?php echo $wpec_quick_view_ultimate_under_image_bt_bg_from;?> 0%, <?php echo $wpec_quick_view_ultimate_under_image_bt_bg_to;?> 100%) !important;
}
<?php } ?>
</style>
