<?php
/**
* Plugin Name: covergrid
* Plugin URI: https://csilverman.com
* Description: oh, you know how it is ! lol
* Version: 1.0.0
* Author: chris
* Author URI: https://csilverman.com
* Text Domain: covergrid
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) exit;

function cg_style() {
   wp_enqueue_style( 'cg-style', plugin_dir_url( __FILE__ ) . '/style.css', array(), _S_VERSION );
}
add_action( 'wp_enqueue_scripts', 'cg_style' );


add_shortcode( 'post-grid', 'csi_postgrid_f' );

function csi_postgrid_f( $atts=false ) {
	$list_start = '<ul id="slider-id" class="slider-class">';
	$post_list = '';

	$recent_posts = wp_get_recent_posts(array(
		'numberposts' => $atts['items'] ?? 9, // Number of recent posts thumbnails to display
		'post_status' => 'publish' // Show only the published posts
	));
	foreach( $recent_posts as $post_item ) {
		$the_post_link = get_permalink($post_item['ID']);
		$the_post_image = get_the_post_thumbnail($post_item['ID'], 'full');
		$the_post_title = $post_item['post_title'];


$TMP = <<<TEXT
		<li>
			<a class="cg-link" href="$the_post_link">
				$the_post_image
				<p class="cg-hide-accessibly">$the_post_title</p>
			</a>
		</li>
		TEXT;

		$post_list .= $TMP;
	}
	return '<ul class="cover-grid">' . $post_list . '</ul>';
}