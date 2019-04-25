<?php
/**
 * BuddyPress - Groups Admin - Manage Members
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 * @version 3.0.0
 */

?>

<h2 class="bp-screen-reader-text"><?php _e( 'Manage Members', 'buddypress' ); ?></h2>

<?php

/**
 * Fires before the group manage members admin display.
 *
 * @since 1.1.0
 */
do_action( 'bp_before_group_manage_members_admin' ); ?>

<div aria-live="polite" aria-relevant="all" aria-atomic="true">

    <div class="bp-widget group-membership-request-list">
        <?php do_action( 'bp_before_group_membership_requests_admin' ); ?>

        <div class="requests">


	        <?php if ( bp_group_has_membership_requests( bp_ajax_querystring( 'membership_requests' ) ) ) : ?>

                <h3 class="bp-screen-title">
			        <?php esc_html_e( 'Manage Membership Requests', 'buddypress' ); ?>
                </h3>

		        <?php bp_nouveau_pagination( 'top' ); ?>

                <ul id="request-list" class="item-list bp-list membership-requests-list">
			        <?php
			        while ( bp_group_membership_requests() ) :
				        bp_group_the_membership_request();
				        ?>

                        <li>
                            <div class="item-avatar">
						        <?php bp_group_request_user_avatar_thumb(); ?>
                            </div>

                            <div class="item">

                                <div class="item-title">
                                    <h3><?php bp_group_request_user_link(); ?></h3>
                                </div>

                                <div class="item-meta">
                                    <span class="comments"><?php bp_group_request_comment(); ?></span>
                                    <span class="activity"><?php bp_group_request_time_since_requested(); ?></span>
							        <?php bp_nouveau_group_hook( '', 'membership_requests_admin_item' ); ?>
                                </div>

                            </div>

					        <?php bp_nouveau_groups_request_buttons(); ?>
                        </li>

			        <?php endwhile; ?>
                </ul>

		        <?php bp_nouveau_pagination( 'bottom' ); ?>

	        <?php else : ?>

                <div id="message" class="info">
                    <p><?php _e( 'There are no pending membership requests.', 'bp-extended-moderator' ); ?></p>
                </div>
	        <?php endif;  ?>

        </div>

    <?php do_action( 'bp_after_group_membership_requests_admin' ); ?>
    </div>


	<div class="bp-widget group-members-list">
		<h3 class="section-header"><?php _e( "Members", 'buddypress' ); ?></h3>

		<?php if ( bp_group_has_members( array( 'per_page' => 15, 'exclude_banned' => 0 ) ) ) : ?>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

			<ul id="members-list" class="item-list members-group-list bp-list" aria-live="assertive" aria-relevant="all">
				<?php while ( bp_group_members() ) : bp_group_the_member(); ?>

					<li class="<?php bp_group_member_css_class(); ?>">
						<div class="item-avatar">
							<?php bp_group_member_avatar_thumb(); ?>
						</div>

						<div class="item">
							<div class="item-title">
								<?php bp_group_member_link(); ?>
								<?php
								if ( bp_get_group_member_is_banned() ) {
									echo ' <span class="banned">';
									_e( '(banned)', 'buddypress' );
									echo '</span>';
								} ?>
							</div>
							<p class="joined item-meta">
								<?php bp_group_member_joined_since(); ?>
							</p>
							<?php

							/**
							 * Fires inside the item section of a member admin item in group management area.
							 *
							 * @since 1.1.0
							 * @since 2.7.0 Added $section parameter.
							 *
							 * @param $section Which list contains this item.
							 */
							do_action( 'bp_group_manage_members_admin_item', 'admins-list' ); ?>
						</div>

						<div class="action">
							<?php if ( bp_get_group_member_is_banned() ) : ?>

								<a href="<?php bp_group_member_unban_link(); ?>" class="button confirm member-unban"><?php _e( 'Remove Ban', 'buddypress' ); ?></a>

							<?php else : ?>

								<a href="<?php bp_group_member_ban_link(); ?>" class="button confirm member-ban"><?php _e( 'Kick &amp; Ban', 'buddypress' ); ?></a>
								<!--<a href="<?php /*bp_group_member_promote_mod_link(); */?>" class="button confirm member-promote-to-mod"><?php /*_e( 'Promote to Mod', 'buddypress' ); */?></a>
								<a href="<?php /*bp_group_member_promote_admin_link(); */?>" class="button confirm member-promote-to-admin"><?php /*_e( 'Promote to Admin', 'buddypress' ); */?></a>-->

							<?php endif; ?>

							<!--<a href="<?php /*bp_group_member_remove_link(); */?>" class="button confirm"><?php /*_e( 'Remove from group', 'buddypress' ); */?></a>-->

							<?php

							/**
							 * Fires inside the action section of a member admin item in group management area.
							 *
							 * @since 2.7.0
							 *
							 * @param $section Which list contains this item.
							 */
							do_action( 'bp_group_manage_members_admin_actions', 'members-list' ); ?>
						</div>
					</li>

				<?php endwhile; ?>
			</ul>

			<?php if ( bp_group_member_needs_pagination() ) : ?>

				<div class="pagination no-ajax">

					<div id="member-count" class="pag-count">
						<?php bp_group_member_pagination_count(); ?>
					</div>

					<div id="member-admin-pagination" class="pagination-links">
						<?php bp_group_member_admin_pagination(); ?>
					</div>

				</div>

			<?php endif; ?>

		<?php else: ?>

			<div id="message" class="info">
				<p><?php _e( 'No group members were found.', 'buddypress' ); ?></p>
			</div>

		<?php endif; ?>
	</div>

</div>

<?php

/**
 * Fires after the group manage members admin display.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_group_manage_members_admin' );
