<?php
/**
 * Plugin Name: BuddyPress Extended Moderator
 * Description: This plugin is an addon for BuddyPress which enhance moderator capability. Moderator can invite, block users and accept membership request for private or hidden groups.
 * Version: 1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH') ) {
	exit;
}

/**
 * Class BP_Extended_Moderator
 */
class BP_Extended_Moderator {

	/**
	 * Class instance
	 *
	 * @var BP_Extended_Moderator
	 */
	private static $instance = null;

	/**
	 * Plugin directory path
	 *
	 * @var string
	 */
	private $path;

	/**
	 * BP_Extended_Moderator constructor.
	 */
	private function __construct() {
		$this->path = plugin_dir_path( __FILE__ );

		$this->setup();
	}

	/**
	 * Get class instance
	 *
	 * @return BP_Extended_Moderator
	 */
	public static function get_instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Action callback
	 */
	private function setup() {
		add_action( 'bp_loaded', array( $this, 'load' ) );
	}

	/**
	 * Load plugin functionality.
	 */
	public function load() {

		if ( ! bp_is_active( 'groups' ) ) {
			return;
		}

		$files = array(
			'core/class-buddydev-extended-moderator-extension.php',
			'core/class-buddydev-extended-moderator-action-handler.php',
		);

		foreach ( $files as $file ) {
			require_once $this->path . $file;
		}

		BuddyDev_Extended_Moderator_Action_Handler::boot();

		bp_register_group_extension( 'BuddyDev_Extended_Moderator_Extension' );
	}

	/**
	 * Plugin directory absolute path
	 *
	 * @return string
	 */
	public function get_path() {
		return $this->path;
	}
}

function bp_extended_moderator() {
	return BP_Extended_Moderator::get_instance();
}

bp_extended_moderator();

