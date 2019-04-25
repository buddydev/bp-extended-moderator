<?php
/**
 * BuddyPress - Groups Admin - Manage Members
 *
 * @package bp-extended-moderator
 */

?>
<p></p>
<p></p>
<?php do_action( 'bp_before_group_manage_members_admin' ); ?>

<div aria-live="polite" aria-relevant="all" aria-atomic="true">

    <div class="bp-widget group-membership-request-list">
        <h3 class="section-header"><?php _e( 'Manage Membership Requests', 'bp-extended-moderator' ); ?></h3>

        <?php do_action( 'bp_before_group_membership_requests_admin' ); ?>

        <div class="requests">

        <?php if ( bp_group_has_membership_requests( bp_ajax_querystring( 'membership_requests' ) ) ) : ?>

            <div id="pag-top" class="pagination">

                <div class="pag-count" id="group-mem-requests-count-top">

                    <?php bp_group_requests_pagination_count(); ?>

                </div>

                <div class="pagination-links" id="group-mem-requests-pag-top">

                    <?php bp_group_requests_pagination_links(); ?>

                </div>

            </div>

            <ul id="request-list" class="item-list">
                <?php while ( bp_group_membership_requests() ) : bp_group_the_membership_request(); ?>

                    <li class="item-list group-request-list">

                        <div class="item-avatar"><?php bp_group_request_user_avatar_thumb(); ?></div>

                        <div class="item">

                            <div class="item-title"><?php bp_group_request_user_link(); ?> </div>

                            <span class="activity"><?php bp_group_request_time_since_requested(); ?></span>

                            <p class="comments"><?php bp_group_request_comment(); ?></p>

                            <?php do_action( 'bp_group_membership_requests_admin_item' ); ?>

                        </div>

                        <div class="action">
                            <?php bp_button( array( 'id' => 'group_membership_accept', 'component' => 'groups', 'wrapper_class' => 'accept', 'link_href' => bp_get_group_request_accept_link(), 'link_text' => __( 'Accept', 'bp-extended-moderator' ) ) ); ?>
                            <?php bp_button( array( 'id' => 'group_membership_reject', 'component' => 'groups', 'wrapper_class' => 'reject', 'link_href' => bp_get_group_request_reject_link(), 'link_text' => __( 'Reject', 'bp-extended-moderator' ) ) ); ?>

                            <?php do_action( 'bp_group_membership_requests_admin_item_action' ); ?>

                        </div>
                    </li>

                <?php endwhile; ?>
            </ul>

            <div id="pag-bottom" class="pagination">

                <div class="pag-count" id="group-mem-requests-count-bottom">

                    <?php bp_group_requests_pagination_count(); ?>

                </div>

                <div class="pagination-links" id="group-mem-requests-pag-bottom">

                    <?php bp_group_requests_pagination_links(); ?>

                </div>

            </div>

        <?php else: ?>

             <div id="message" class="info">
                    <p><?php _e( 'There are no pending membership requests.', 'bp-extended-moderator' ); ?></p>
             </div>

        <?php endif; ?>

        </div>

        <?php do_action( 'bp_after_group_membership_requests_admin' ); ?>
    </div>

	<div class="bp-widget group-members-list">
		<h3 class="section-header"><?php _e( "Members", 'bp-extended-moderator' ); ?></h3>

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

			<ul id="members-list" class="item-list" aria-live="assertive" aria-relevant="all">
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
									_e( '(banned)', 'bp-extended-moderator' );
									echo '</span>';
								} ?>
							</div>
							<p class="joined item-meta">
								<?php bp_group_member_joined_since(); ?>
							</p>
							<?php do_action( 'bp_group_manage_members_admin_item', 'admins-list' ); ?>
						</div>

						<div class="action">
							<?php if ( bp_get_group_member_is_banned() ) : ?>

								<a href="<?php bp_group_member_unban_link(); ?>" class="button confirm member-unban"><?php _e( 'Remove Ban', 'bp-extended-moderator' ); ?></a>

							<?php else : ?>

								<a href="<?php bp_group_member_ban_link(); ?>" class="button confirm member-ban"><?php _e( 'Kick &amp; Ban', 'bp-extended-moderator' ); ?></a>
								<!--<a href="<?php /*bp_group_member_promote_mod_link(); */?>" class="button confirm member-promote-to-mod"><?php /*_e( 'Promote to Mod', 'bp-extended-moderator' ); */?></a>
								<a href="<?php /*bp_group_member_promote_admin_link(); */?>" class="button confirm member-promote-to-admin"><?php /*_e( 'Promote to Admin', 'bp-extended-moderator' ); */?></a>-->

							<?php endif; ?>

							<!--<a href="<?php /*bp_group_member_remove_link(); */?>" class="button confirm"><?php /*_e( 'Remove from group', 'bp-extended-moderator' ); */?></a>-->

							<?php do_action( 'bp_group_manage_members_admin_actions', 'members-list' ); ?>
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
				<p><?php _e( 'No group members were found.', 'bp-extended-moderator' ); ?></p>
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
