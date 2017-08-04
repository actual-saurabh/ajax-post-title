<?php

/**
 * Contains class with core plugin functionality
 * 
 * @author Saurabh Shukla <saurabh@yapapaya.com>
 * 
 */
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'YA_APT' ) ) {

	/**
	 * Loads plugin's main functionality
	 *
	 * @author Saurabh Shukla <saurabh@yapapaya.com>
	 */
	class YA_APT {

		/**
		 * Initiliases hooks
		 */
		public function init() {

			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );

			add_action( 'wp_ajax_ya-apt-ajax', array( $this, 'ajax_response' ) );
		}

		/**
		 * Enqueues & localises JS functionality
		 * 
		 * @global type $post;
		 */
		public function enqueue() {

			// script handle
			$handle = YA_APT_KEY_PREFIX . 'js';

			// script source
			$src = YA_APT_URL . 'js/ya-apt.js';

			// enqueue the plugin's js
			wp_enqueue_script( $handle, $src, array( 'jquery' ), YA_APT_VER, true );


			// get current post ID
			global $post;
			
			$post_id = $post->ID;

			// create the object for localisation
			$var_object = array(
				'ajax_url'			=> admin_url( 'admin-ajax.php' ), // the url to send requests to
				'nonce'				=> wp_create_nonce( YA_APT_KEY_PREFIX . 'nonce' ), // nonce for security
				'post_id'			=> $post_id, // the post ID
				'prefix'			=> YA_APT_KEY_PREFIX, // prefix
				'msg_prefix'		=> __( 'Ajax Post Title: ', 'ya-apt' ),
				'msg_ajax_fail'		=> __( 'Request failed.', 'ya-apt' ),
				'msg_title_fail'	=> __( 'Title not found.', 'ya-apt' ),
			);

			// localise the object
			wp_localize_script( $handle, 'yaAPT', $var_object );
		}

		/**
		 * Returns post data on ajax request
		 */
		function ajax_response() {

			// set up filtering
			$args = array(
				'action' => FILTER_DEFAULT,
				'post_id' => FILTER_VALIDATE_INT,
				'nonce' => FILTER_DEFAULT,
			);

			// filter $_GET for values
			$inputs = filter_input_array( INPUT_GET, $args );

			// not our action for some reason, die
			if ( $inputs[ 'action' ] != YA_APT_KEY_PREFIX . 'ajax' ) {
				wp_die( 0 );
			}

			// nonce failed, die with no special error
			// why should the hacker know they failed a security check?
			if ( ! wp_verify_nonce( $inputs[ 'nonce' ], YA_APT_KEY_PREFIX . 'nonce' ) ) {
				wp_die( 0 );
			}
			
			// get and encode the post data as json
			$post_data = json_encode( get_post( $inputs[ 'post_id' ] ) );

			// output
			wp_die( $post_data );
		}

	}

}
