<?php
/**
 * Functions to load the front end display for the plugin.
 *
 * @package   SocialWarfare\Functions
 * @copyright Copyright (c) 2016, Warfare Plugins, LLC
 * @license   GPL-3.0+
 * @since     1.0.0
 */

add_filter( 'the_content','social_warfare_wrapper',200 );
add_filter( 'the_excerpt','social_warfare_wrapper' );
/**
 * A wrapper function for adding the buttons the content or excerpt.
 *
 * @since  1.0.0
 * @param  string $content The content.
 * @return String $content The modified content
 */
function social_warfare_wrapper( $content ) {
    // GX start -
    global $post, $swp_already_print;
    $post_id = $post->ID;

    //Check if already printed for this post
    if( in_array( $post_id, $swp_already_print )  )
        return $content;
    // - GX end

	$array['content'] = $content;
	$content = social_warfare_buttons( $array );
	if( false === is_admin() ):
		$content .= '<div class="swp-content-locator"></div>';
	endif;

    array_push( $swp_already_print, $post_id ); //GX

	return $content;
}

/**
 * The main social_warfare function used to create the buttons.
 *
 * @since  1.4.0
 * @param  array $array An array of options and information to pass into the buttons function.
 * @return string $content The modified content
 */
function social_warfare( $array = array() ) {
	$array['devs'] = true;
	$content = social_warfare_buttons( $array );
	if( false === is_admin() ):
		$content .= '<div class="swp-content-locator"></div>';
	endif;
	return $content;
}

/**
 * Add the side floating buttons to the footer if they are activated
 *
 * @since 1.4.0
 */
if ( in_array( $swp_user_options['floatOption'], array( 'left', 'right' ), true ) ) {
	add_action( 'wp_footer', 'socialWarfareSideFloat' );
}
