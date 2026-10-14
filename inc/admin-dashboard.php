<?php
/**
 * CI360 Custom WordPress Admin Dashboard.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* Remove default dashboard widgets */
function ci360_remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_site_health', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
}
add_action( 'wp_dashboard_setup', 'ci360_remove_dashboard_widgets', 999 );

/* Create CI360 Dashboard Widget */
function ci360_custom_dashboard_widget() {
	wp_add_dashboard_widget(
		'ci360_dashboard',
		'CI360 Degrees',
		'ci360_dashboard_content'
	);
}
add_action( 'wp_dashboard_setup', 'ci360_custom_dashboard_widget' );

function ci360_dashboard_content() {
	$projects = wp_count_posts( 'ci_project' );
	$services = wp_count_posts( 'ci_service' );
	$insights = wp_count_posts( 'ci_insight' );

	$project_count = isset( $projects->publish ) ? $projects->publish : 0;
	$service_count = isset( $services->publish ) ? $services->publish : 0;
	$insight_count = isset( $insights->publish ) ? $insights->publish : 0;
	?>

	<div class="ci360-dashboard">
		<div class="ci360-header">
			<div>
				<span class="ci360-small-title">
					CI360 / WEBSITE MANAGEMENT
				</span>
				<h1>Welcome to CI360 Degrees</h1>
				<p>
					Manage your website content, projects, insights and digital presence.
				</p>
			</div>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" class="ci360-view-site">
				View Website &nearr;
			</a>
		</div>

		<!-- STATS -->
		<div class="ci360-stats">
			<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=ci_project' ) ); ?>" class="ci360-stat">
				<span>PROJECTS</span>
				<strong><?php echo esc_html( $project_count ); ?></strong>
				<small>Published projects</small>
			</a>

			<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=ci_insight' ) ); ?>" class="ci360-stat">
				<span>INSIGHTS</span>
				<strong><?php echo esc_html( $insight_count ); ?></strong>
				<small>Published insights</small>
			</a>

			<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=ci_service' ) ); ?>" class="ci360-stat">
				<span>SERVICES</span>
				<strong><?php echo esc_html( $service_count ); ?></strong>
				<small>Active services</small>
			</a>

			<a href="<?php echo esc_url( admin_url( 'admin.php?page=ci360-settings' ) ); ?>" class="ci360-stat">
				<span>SETTINGS</span>
				<strong>View</strong>
				<small>CI360 Site Settings</small>
			</a>
		</div>

		<!-- QUICK ACTIONS -->
		<div class="ci360-section">
			<div class="ci360-section-heading">
				<div>
					<span>QUICK ACTIONS</span>
					<h2>Manage Content</h2>
				</div>
			</div>

			<div class="ci360-actions">
				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=ci_project' ) ); ?>">
					<strong>&#xFF0B;</strong>
					<span>Add Project</span>
				</a>

				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=ci_insight' ) ); ?>">
					<strong>&#xFF0B;</strong>
					<span>Add Insight</span>
				</a>

				<a href="<?php echo esc_url( admin_url( 'post-new.php?post_type=ci_service' ) ); ?>">
					<strong>&#xFF0B;</strong>
					<span>Add Service</span>
				</a>

				<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>">
					<strong>&#x25A4;</strong>
					<span>Manage Pages</span>
				</a>

				<a href="<?php echo esc_url( admin_url( 'upload.php' ) ); ?>">
					<strong>&#x25A7;</strong>
					<span>Media Library</span>
				</a>

				<a href="<?php echo esc_url( admin_url( 'admin.php?page=ci360-settings' ) ); ?>">
					<strong>&rarr;</strong>
					<span>Site Settings</span>
				</a>
			</div>
		</div>

		<!-- WEBSITE MANAGEMENT -->
		<div class="ci360-section">
			<span class="ci360-small-title">WEBSITE</span>
			<h2>Website Management</h2>
			<div class="ci360-management">
				<a href="<?php echo esc_url( admin_url( 'edit.php?post_type=page' ) ); ?>">
					Pages <span>&rarr;</span>
				</a>
				<a href="<?php echo esc_url( admin_url( 'upload.php' ) ); ?>">
					Media Library <span>&rarr;</span>
				</a>
				<a href="<?php echo esc_url( admin_url( 'nav-menus.php' ) ); ?>">
					Navigation Menu <span>&rarr;</span>
				</a>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=elementor' ) ); ?>">
					Elementor <span>&rarr;</span>
				</a>
			</div>
		</div>
	</div>
	<?php
}

/* ========================================
   DASHBOARD CSS
======================================== */
function ci360_dashboard_admin_styles() {
	$screen = get_current_screen();
	if ( ! $screen || 'dashboard' !== $screen->id ) {
		return;
	}
	?>
	<style>
	#wpbody-content .wrap > h1 {
		display: none;
	}

	#dashboard-widgets-wrap {
		margin-top: 20px;
	}

	#dashboard-widgets .postbox-container {
		width: 100% !important;
	}

	#dashboard-widgets .postbox {
		border: none;
		box-shadow: none;
		background: transparent;
	}

	#ci360_dashboard .postbox-header {
		display: none;
	}

	#ci360_dashboard .inside {
		padding: 0;
		margin: 0;
	}

	.ci360-dashboard {
		font-family: "Poppins", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
		max-width: 1400px;
		padding: 10px 10px 50px;
	}

	/* HEADER */
	.ci360-header {
		background: #061b43;
		padding: 42px;
		border-radius: 20px;
		color: #fff;
		display: flex;
		justify-content: space-between;
		align-items: center;
		margin-bottom: 24px;
	}

	.ci360-header h1 {
		margin: 8px 0 6px;
		color: #fff;
		font-size: 32px;
		line-height: 1.2;
		font-weight: 600;
	}

	.ci360-header p {
		margin: 0;
		color: #b9c5db;
		font-size: 14px;
	}

	.ci360-small-title {
		font-size: 11px;
		letter-spacing: 2px;
		font-weight: 600;
		color: #29f2ec;
	}

	.ci360-view-site {
		background: #fff;
		color: #061b43 !important;
		padding: 13px 20px;
		border-radius: 8px;
		text-decoration: none;
		font-weight: 600;
		white-space: nowrap;
	}

	/* STATS */
	.ci360-stats {
		display: grid;
		grid-template-columns: repeat(4, 1fr);
		gap: 16px;
		margin-bottom: 25px;
	}

	.ci360-stat {
		background: #fff;
		padding: 25px;
		border-radius: 14px;
		border: 1px solid #e8e8e8;
		text-decoration: none !important;
		transition: transform .25s ease, box-shadow .25s ease;
	}

	.ci360-stat:hover {
		transform: translateY(-3px);
		box-shadow: 0 12px 30px rgba(0,0,0,.08);
	}

	.ci360-stat span {
		display: block;
		font-size: 11px;
		letter-spacing: 1.5px;
		color: #747474;
	}

	.ci360-stat strong {
		display: block;
		font-size: 35px;
		margin: 7px 0;
		color: #061b43;
	}

	.ci360-stat small {
		color: #999;
	}

	/* SECTIONS */
	.ci360-section {
		background: #fff;
		border: 1px solid #e8e8e8;
		border-radius: 16px;
		padding: 28px;
		margin-bottom: 20px;
	}

	.ci360-section h2 {
		margin: 5px 0 22px;
		font-size: 22px;
		color: #061b43;
	}

	/* ACTIONS */
	.ci360-actions {
		display: grid;
		grid-template-columns: repeat(3, 1fr);
		gap: 14px;
	}

	.ci360-actions a {
		padding: 20px;
		border: 1px solid #e4e7eb;
		border-radius: 12px;
		text-decoration: none;
		color: #061b43;
		display: flex;
		gap: 14px;
		align-items: center;
		font-weight: 500;
		transition: all .2s ease;
	}

	.ci360-actions a:hover {
		background: #061b43;
		border-color: #061b43;
		color: #fff;
	}

	.ci360-actions strong {
		font-size: 22px;
	}

	/* MANAGEMENT */
	.ci360-management {
		display: grid;
		grid-template-columns: repeat(2, 1fr);
		gap: 12px;
	}

	.ci360-management a {
		border-bottom: 1px solid #eee;
		padding: 16px 5px;
		text-decoration: none;
		color: #333;
		display: flex;
		justify-content: space-between;
		font-weight: 500;
	}

	.ci360-management a:hover {
		color: #0357e6;
	}

	/* RESPONSIVE */
	@media(max-width:1100px) {
		.ci360-stats {
			grid-template-columns: repeat(2, 1fr);
		}
		.ci360-actions {
			grid-template-columns: repeat(2, 1fr);
		}
	}

	@media(max-width:782px) {
		.ci360-header {
			padding: 25px;
			display: block;
		}
		.ci360-view-site {
			display: inline-block;
			margin-top: 20px;
		}
		.ci360-stats,
		.ci360-actions,
		.ci360-management {
			grid-template-columns: 1fr;
		}
	}
	</style>
	<?php
}
add_action( 'admin_head', 'ci360_dashboard_admin_styles' );
