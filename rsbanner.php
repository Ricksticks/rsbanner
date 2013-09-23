<?php
/*
Plugin Name: Ricksticks Banner
Plugin URI: 
Description: Adds a banner admin page. Use RSBanner::get_banners() in the header of your theme to grab an array of banner objects.
Author: The Ricksticks team
Author URI: http://ricksticks.com
Version: 20130923a
*/

/*  Copyright 2012  Ricksticks  (email : admin@ricksticks.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

class RSBanner
{
	static $advanced_chooser = true;
	
	function __construct()
	{
		add_action('admin_menu', array(&$this, 'admin_menu'));
		add_action('admin_init', array(&$this, 'admin_init'));
	}
	
	static function get_banners()
	{
		$banners = array();
		
		$rsb_total = get_option('rsb_total');
		
		foreach (range(1, $rsb_total) as $n)
		{
			$image = get_option('rsb_image_'.$n);
			$link  = get_option('rsb_link_'.$n);
			
			if (empty($image))
			{
				continue;
			}
			
			$banner = new stdClass();
			$banner->image = wp_get_attachment_url($image);
			
			$banner->link = '';
			if ( ! empty($link))
			{
				$banner->link = get_page_link($link);
			}
			
			$banners[] = $banner;
		}
		
		return $banners;
	}
	
/* Admin pages */
	
	function admin_menu()
	{
		add_submenu_page('options-general.php', 'Banner Settings', 'Banner', 'manage_options', 'rsb', array(&$this, 'admin_page')); 
	}
	
	function admin_init()
	{
		if (self::$advanced_chooser)
		{
			wp_enqueue_media();
			wp_enqueue_script('rsbanner', plugin_dir_url(__FILE__).'rsbanner.js', 'jquery', '1.0');
		}
		
		add_filter('plugin_action_links_'.plugin_basename(__FILE__), array(&$this, 'plugin_action_links'));
	}
	
	function plugin_action_links($actions)
	{
		$rsb_action = array('settings' => sprintf('<a href="%s">%s</a>', self::admin_url(), __('Settings', 'rsb')));
		return array_merge($rsb_action, $actions);
	}
	
	function admin_url($args = null)
	{
		$url = menu_page_url('rsb', false);
		if (is_array($args))
		{
			$url = add_query_arg($args, $url);
		}
		return $url;
	}
	
	function admin_page()
	{
		$message = $this->admin_page_post_handler();
		
		// For basic chooser
		$images = get_posts(array('post_type' => 'attachment'));
		
		$rsb_total = get_option('rsb_total');
		
		foreach (range(1, $rsb_total) as $n)
		{
			$rsb_image[$n] = get_option('rsb_image_'.$n);
			$rsb_link[$n]  = get_option('rsb_link_'.$n);
		}
		
		include 'admin_page.php';
	}
	
	function admin_page_post_handler()
	{
		$rsb_total = get_option('rsb_total');
		
		if ($_POST['submit'])
		{
			$total = trim(htmlentities($_REQUEST['rsb_total']));
			update_option('rsb_total', $total);
			
			foreach (range(1, $rsb_total) as $n)
			{
				$image = trim(htmlentities($_REQUEST['rsb_image_'.$n]));
				$link  = trim(htmlentities($_REQUEST['rsb_link_'.$n]));
				update_option('rsb_image_'.$n, $image);
				update_option('rsb_link_'.$n,  $link);
			}
			
			return 'Banner settings saved.';
		}
	}
}

$RSBanner_var = new RSBanner();
