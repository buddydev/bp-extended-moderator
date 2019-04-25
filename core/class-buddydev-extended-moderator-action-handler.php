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
 * Class BuddyDev_Extended_Moderator_Action_Handler
 */
class BuddyDev_Extended_Moderator_Action_Handler{
	/**
	 * Boot
	 */
	public static function boot() {
		$self = new self();
		$self->setup();
	}

	/**
	 * Setup action callbacks
	 */
	private function setup() {
		add_action( 'bp_actions', array( $this, 'process_request' ) );
	}

	/**
	 * Process request
	 */
	public function process_request() {
		$action  = bp_action_variable( 0 );
		$item_id = absint( bp_action_variable( 1 ) );

		if ( ! bp_is_group() || ! bp_is_current_action( 'moderate' ) || empty( $action ) || empty( $item_id ) || ! isset( $_GET['_wpnonce'] ) ) {
			return;
		}

		$group         = groups_get_group( bp_get_current_group_id() );
		$moderator_ids = bp_group_mod_ids( $group, 'array' );
		$admin_ids     = bp_group_admin_ids( $group, 'array' );

		// If current user is not group moderator skip.
		if ( ! is_user_logged_in() || ! in_array( get_current_user_id(), $moderator_ids ) ) {
			return;
		}

		// If try to ban user which are moderator or admins will be skip.
		if ( in_array( $item_id, $moderator_ids ) || in_array( $item_id, $admin_ids ) ) {
			return;
		}

		add_filter( 'bp_is_item_admin', array( $this, 'is_item_admin' ) );

		if ( 'ban' == $action ) {
			if ( ! ( wp_verify_nonce( $_GET['_wpnonce'], 'groups_ban_member' ) && groups_ban_member( $item_id, $group->id ) ) ) {
				bp_core_add_message( __( 'There was an error when banning that user. Please try again.' ), 'error' );
			} else {
				bp_core_add_message( __( 'User banned successfully' ), 'success' );
			}
		} elseif ( 'unban' == $action ) {
			if ( ! ( wp_verify_nonce( $_GET['_wpnonce'], 'groups_unban_member' ) && groups_unban_member( $item_id, $group->id ) ) ) {
				bp_core_add_message( __( 'There was an error when unbanning that user. Please try again.' ), 'error' );
			} else {
				bp_core_add_message( __( 'User unbanned successfully' ), 'success' );
			}
		} elseif ( 'accept' == $action ) {
			if ( ! ( wp_verify_nonce( $_GET['_wpnonce'], 'groups_accept_membership_request' ) && groups_accept_membership_request( $item_id, false, $group->id ) ) ) {
				bp_core_add_message( __( 'There was an error accepting the membership request. Please try again.' ), 'error' );
			} else {
				bp_core_add_message( __( 'Group membership request accepted' ), 'success' );
			}
		} elseif ( 'reject' == $action ) {
			if ( ! ( wp_verify_nonce( $_GET['_wpnonce'], 'groups_reject_membership_request' ) && groups_reject_membership_request( $item_id, false, $group->id ) ) ) {
				bp_core_add_message( __( 'There was an error rejecting the membership request. Please try again.' ), 'error' );
			} else {
				bp_core_add_message( __( 'Group membership request rejected' ), 'success' );
			}
		}

		remove_filter( 'bp_is_item_admin', array( $this, 'is_item_admin' ) );

		bp_core_redirect( bp_get_group_permalink( $group ) . 'moderate' );
	}

	/**
	 * If item admin or not
	 *
	 * @return bool
	 */
	public function is_item_admin() {
		return true;
	}
}
