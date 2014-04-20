<?php
/*
Plugin Name: Dashboard Widgets Order
Plugin URI: http://premium.wpmudev.org/project/dashboard-widget-order
Description: Easily customize the order of widgets on all of your users dashboards... giving more prominence to the widgets *you* want them to see and use
Author: S H Mohanjith (Incsub), Andrew Billits (Incsub)
Version: 2.0.4.2
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


$dashboard_widgets_order = array();
$dashboard_widgets_order['normal'] = array('high' => array(), 'core' => array(), 'default' => array(), 'low' => array());
$dashboard_widgets_order['side'] = array('high' => array(), 'core' => array(), 'default' => array(), 'low' => array());
$dashboard_widgets_order['column3'] = array('high' => array(), 'core' => array(), 'default' => array(), 'low' => array());
$dashboard_widgets_order['column4'] = array('high' => array(), 'core' => array(), 'default' => array(), 'low' => array());

//------------------------------------------------------------------------//
//---Config---------------------------------------------------------------//
//------------------------------------------------------------------------//
//  change the order of the widgets here
$dashboard_widgets_order['normal']['core'][] = 'dashboard_right_now';
$dashboard_widgets_order['normal']['core'][] = 'dashboard_activity';
$dashboard_widgets_order['normal']['default'][] = 'dashboard_incoming_links';

$dashboard_widgets_order['side']['core'][] = 'dashboard_quick_press';
$dashboard_widgets_order['side']['default'][] = 'dashboard_primary';

$dashboard_widgets_order['column3']['high'][] = 'dashboard_secondary';

$dashboard_widgets_order['column4']['high'][] = 'dashboard_plugins';
//  Change this if you update the widget order and want all users to have
//  the new order instead of just new users.
//  Note that this will overwrite the custom widget order users have
//  configured.
$dashboard_widgets_order_hash = 'm9c0u203b9u0338u10zxnm1lm';

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//
add_action('init', 'dashboard_widgets_order');
//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function dashboard_widgets_order() {
	global $wpdb, $user_ID, $dashboard_widgets_order, $dashboard_widgets_order, $dashboard_widgets_order_hash, $wp_meta_boxes;

	if ( !is_multisite() )
		exit( 'The Dashboard Widget Order plugin is only compatible with WordPress Multisite.' );

	load_plugin_textdomain('dashboard_widgets_order', false, dirname(plugin_basename(__FILE__)).'/languages');

	if ( !empty( $user_ID ) ) {
		$dashboard_widget_order_updated = get_user_option('meta-box-order_dashboard_updated', $user_ID);

		if ( $dashboard_widget_order_updated != $dashboard_widgets_order_hash ) {

			$dashboard_widget_order = array();

			foreach ( $dashboard_widgets_order as $location => $sidebar ) {

				if (!isset($dashboard_widget_order[$location])) {
					$dashboard_widget_order[$location] = array();
				}

				foreach (array('high', 'core', 'default', 'low') as $priority) {
					if (count($sidebar[$priority]) > 0) {
						$dashboard_widget_order[$location][] = join(',', $sidebar[$priority]);
					}
				}
				$dashboard_widget_order[$location] = join(',', $dashboard_widget_order[$location]);
			}

			update_user_option($user_ID, 'meta-box-order_dashboard', $dashboard_widget_order, true);
			update_user_option($user_ID, 'meta-box-order_dashboard_updated', $dashboard_widgets_order_hash, true);
		}
	}
}
