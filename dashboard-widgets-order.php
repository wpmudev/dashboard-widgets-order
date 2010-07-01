<?php
/*
Plugin Name: Dashboard Widgets Order
Plugin URI: 
Description:
Author: Andrew Billits
Version: 2.0.2
Author URI:
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
$dashboard_widgets_order_hash = 'm9c0u2030zxnm0q';

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('init', 'dashboard_widgets_order');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function dashboard_widgets_order(){
	global $wpdb, $user_ID, $dashboard_widgets_order_left_column, $dashboard_widgets_order_right_column, $dashboard_widgets_order_hash;
	if ( !empty( $user_ID ) ) {
		$dashboard_widget_order_updated = get_usermeta($user_ID, $wpdb->base_prefix . $wpdb->blog . '_' . $dashboard_widgets_order_hash . '_dashboard_widget_order_updated');
		
		if ( $dashboard_widget_order_updated != 'yes' ) {

			foreach ( $dashboard_widgets_order_left_column as $dashboard_widgets_order_left_column_widget ) {
				$left_column = $left_column . $dashboard_widgets_order_left_column_widget . ',';
			}
			$left_column = rtrim($left_column, ',');
			
			foreach ( $dashboard_widgets_order_right_column as $dashboard_widgets_order_right_column_widget ) {
				$right_column = $right_column . $dashboard_widgets_order_right_column_widget . ',';
			}
			$right_column = rtrim($right_column, ',');
			
			$dashboard_widget_order = array();

			$dashboard_widget_order['side'] = $right_column;
			$dashboard_widget_order['normal'] = $left_column;

			update_usermeta($user_ID, $wpdb->base_prefix . $wpdb->blogid . '_metaboxorder_dashboard', $dashboard_widget_order);
			update_usermeta($user_ID, $wpdb->base_prefix . $wpdb->blog . '_' . $dashboard_widgets_order_hash . '_dashboard_widget_order_updated', 'yes');
		}
	}
}
//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

//------------------------------------------------------------------------//
//---Support Functions----------------------------------------------------//
//------------------------------------------------------------------------//

?>