<?php
/**
 * Class extension for moderator tab
 *
 * @package bp-extended-moderator
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH') ) {
	exit;
}

/**
 * Class BuddyDev_Extended_Moderator_Extension
 */
class BuddyDev_Extended_Moderator_Extension extends BP_Group_Extension {
	/**
	 * The constructor.
	 */
	public function __construct() {
		$args = array(
			'slug'       => 'moderate',
			'name'       => __( 'Moderate', 'bp-extended-moderator' ),
			'visibility' => 'private',
			'access'     => 'mod',
			'show_tab'   => 'mod',
		);

		parent::init( $args );
	}

	/**
	 * Display tab content
	 *
	 * @param int|null $group_id
	 */
	public function display( $group_id = null ) {
		$this->apply_filters();

		if ( function_exists( 'bp_nouveau' ) ) {
			require_once bp_extended_moderator()->get_path() . 'templates/bp-nouveau/groups/single/moderate/manage-members.php';
		} else {
			require_once bp_extended_moderator()->get_path() . 'templates/bp-legacy/groups/single/moderate/manage-members.php';
		}

		$this->remove_filters();
	}

	/**
	 * Apply filters
	 */
	public function apply_filters() {
		add_filter( 'bp_get_group_request_accept_link', array( $this, 'modify_request_accept_link' ) );
		add_filter( 'bp_get_group_request_reject_link', array( $this, 'modify_request_reject_link' ) );
		add_filter( 'bp_get_group_member_ban_link', array( $this, 'modify_member_ban_link' ) );
		add_filter( 'bp_get_group_member_unban_link', array( $this, 'modify_member_unban_link' ) );
	}

	/**
	 * Remove filters
	 */
	public function remove_filters() {
		remove_filter( 'bp_get_group_request_accept_link', array( $this, 'modify_request_accept_link' ) );
		remove_filter( 'bp_get_group_request_reject_link', array( $this, 'modify_request_reject_link' ) );
		remove_filter( 'bp_get_group_member_ban_link', array( $this, 'modify_member_ban_link' ) );
		remove_filter( 'bp_get_group_member_unban_link', array( $this, 'modify_member_unban_link' ) );
	}

	/**
	 * Modify request accept link
	 *
	 * @param string $link Link;
	 *
	 * @return string
	 */
	public function modify_request_accept_link( $link ) {

		if ( false !== strpos( $link, 'admin/membership-requests/accept' ) ) {
			$link = str_replace( 'admin/membership-requests/accept', $this->slug . '/accept', $link );
		}

		return $link;
	}

	/**
	 * Modify request reject link
	 *
	 * @param string $link Link.
	 *
	 * @return string
	 */
	public function modify_request_reject_link( $link ) {

		if ( false !== strpos( $link, 'admin/membership-requests/reject' ) ) {
			$link = str_replace( 'admin/membership-requests/reject', $this->slug . '/reject', $link );
		}

		return $link;
	}

	/**
	 * Get member ban link
	 *
	 * @param string $link Member ban Link.
	 *
	 * @return string
	 */
	public function modify_member_ban_link( $link ) {
		if ( false !== strpos( $link, 'admin/manage-members/ban' ) ) {
			$link = str_replace( 'admin/manage-members/ban', $this->slug . '/ban', $link );
		}

		return $link;
	}

	public function modify_member_unban_link( $link ) {

		if ( false !== strpos( $link, 'admin/manage-members/unban' ) ) {
			$link = str_replace( 'admin/manage-members/unban', $this->slug . '/unban', $link );
		}

		return $link;
	}
}
