<?php
/**
 * Plugin Name: Embed Privacy Helper
 * Description: Add shortcode for applying Embed Privacy.
 * Plugin URI:  https://torstenlandsiedel.de
 * Version:     1.0
 * Author:      Torsten Landsiedel
 * Author URI:  https://torstenlandsiedel.de
 * Licence:     GPL 2
 * License URI: http://opensource.org/licenses/GPL-2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Replace specific content with the Embed Privacy overlay of type 'google-maps'.
 *
 * @param   string $content The content to replace.
 * @return  string The updated content.
 */
function tl_replace_content_with_overlay( $content ) {
	// Check for Embed Privacy.
	if ( ! class_exists( 'epiphyt\Embed_Privacy\Embed_Privacy' ) ) {
		return $content;
	}

	// Get Embed Privacy instance.
	$embed_privacy = epiphyt\Embed_Privacy\Embed_Privacy::get_instance();

	// Check if provider is always active; if so, just return the content.
	if ( ! $embed_privacy->is_always_active_provider( 'google-maps' ) ) {
		// Replace the content with the overlay.
		$content = $embed_privacy->get_output_template( 'Google Maps', 'google-maps', $content );
		// Enqueue assets.
		$embed_privacy->print_assets();
	}

	return $content;
}

/**
 * Add shortcode for applying Embed Privacy
 *
 * @param  Array  $atts     Parameter (unused).
 * @param  String $content Content between Shortcode like here: [embed_privacy]Content[/embed_privacy].
 * @return String          Content with applied Embed Privacy.
 */
function apply_embed_privacy_shortcode( $atts, $content = '' ) {
	return tl_replace_content_with_overlay( $content );
}
add_shortcode( 'embed_privacy', 'apply_embed_privacy_shortcode' );
