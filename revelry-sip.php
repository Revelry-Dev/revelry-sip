<?php
/*
Plugin Name: Revelry Stick Important Pages
Plugin URI: https://revelry.dev/plugins/sip
Plugin Author: https://revelry.dev
Description: Automatically Stick your Front Page and Blog Posts page to the top of the pages list.
Version: 1.0
Text Domain: revelry-sip
License: GPLv2
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

class Revelry_SIP {

	/**
	 * Setup the plugin on init
	 */
	static public function init() {

		add_action( 'posts_orderby', array( 'Revelry_SIP', 'setup' ), 10, 2 );
	}

	static public function setup( $orderby, $query ) {

		global $pagenow;

		if ( 'page' !== get_option( 'show_on_front' ) ) {
			return;
		}

		if ( is_admin() && 'edit.php' == $pagenow && ! isset( $_GET['orderby'] ) ) {

				$front = (int) get_option( 'page_on_front' );
				$posts = (int) get_option( 'page_for_posts' );
				$ids   = implode( ',', array_filter( array( $posts, $front ) ) );

			if ( empty( $ids ) ) {
				return $orderby;
			}

				global $wpdb;
				$orderby = 'FIELD(' . $wpdb->posts . '.ID,' . $ids . ') DESC, ' . $orderby;
				return $orderby;
		}
	}
}
Revelry_SIP::init();
