<?php
/*
Plugin Name: Dashboard Widgets Order
Plugin URI: http://premium.wpmudev.org/project/dashboard-widget-order
Description: Easily customize the order of widgets on all of your users dashboards... giving more prominence to the widgets *you* want them to see and use
Author: S H Mohanjith (Incsub), Andrew Billits (Incsub)
Version: 2.0.5
Author URI: http://premium.wpmudev.org
WDP ID: 16
Network: true
Text Domain: dashboard_widgets_order
*/

/*
Copyright 2007-2009 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//
//  change the order of the widgets here
$dashboard_widgets_order_left_column[] = 'dashboard_right_now';
$dashboard_widgets_order_left_column[] = 'dashboard_recent_comments';
$dashboard_widgets_order_left_column[] = 'dashboard_incoming_links';
$dashboard_widgets_order_left_column[] = 'dashboard_plugins';

$dashboard_widgets_order_right_column[] = 'dashboard_quick_press';
$dashboard_widgets_order_right_column[] = 'dashboard_recent_drafts';
$dashboard_widgets_order_right_column[] = 'dashboard_primary';
$dashboard_widgets_order_right_column[] = 'dashboard_secondary';

//  Change this if you update the widget order and want all users to have
//  the new order instead of just new users.
//  Note that this will overwrite the custom widget order users have
//  configured.
$dashboard_widgets_order_hash = 'n9c0u203b7u0338u10zxnm1n';

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('init', 'dashboard_widgets_order');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function dashboard_widgets_order() {
	global $wpdb, $user_ID, $dashboard_widgets_order_left_column, $dashboard_widgets_order_right_column, $dashboard_widgets_order_hash, $wp_meta_boxes;

	if ( !is_multisite() )
		exit( 'The Dashboard Widget Order plugin is only compatible with WordPress Multisite.' );

	load_plugin_textdomain('dashboard_widgets_order', false, dirname(plugin_basename(__FILE__)).'/languages');

	if ( !empty( $user_ID ) ) {
		$dashboard_widget_order_updated = get_user_option('meta-box-order_dashboard_updated', $user_ID);

		if ( $dashboard_widget_order_updated != $dashboard_widgets_order_hash ) {

			$left_column = '';
			foreach ( $dashboard_widgets_order_left_column as $dashboard_widgets_order_left_column_widget ) {
				$left_column .= $dashboard_widgets_order_left_column_widget . ',';
			}
			$left_column = rtrim($left_column, ',');

			$right_column = '';
			foreach ( $dashboard_widgets_order_right_column as $dashboard_widgets_order_right_column_widget ) {
				$right_column .= $dashboard_widgets_order_right_column_widget . ',';
			}
			$right_column = rtrim($right_column, ',');

			$dashboard_widget_order = array();

			$dashboard_widget_order['side'] = $right_column;
			$dashboard_widget_order['normal'] = $left_column;

			update_user_option($user_ID, 'meta-box-order_dashboard', $dashboard_widget_order, true);
			update_user_option($user_ID, 'meta-box-order_dashboard_updated', $dashboard_widgets_order_hash, true);
		}
	}
}