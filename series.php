<?php
/**
 * Plugin Name: Series
 * Plugin URI: http://themehybrid.com/plugins/series
 * Description: Creates a new taxonomy called "Series" that allows you to tie posts together in a series.
 * Version: 0.2.0
 * Author: Justin Tadlock
 * Author URI: http://justintadlock.com
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package   Series
 * @version   0.2.0
 * @since     0.1.0
 * @author    Justin Tadlock <justin@justintadlock.com>
 * @copyright Copyright (c) 2009 - 2015, Justin Tadlock
 * @link      http://themehybrid.com/plugins/series
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

final class Series_Plugin {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var    object
	 */
	private static $instance;

	/**
	 * Stores the directory path for this plugin.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var    string
	 */
	private $directory_path;

	/**
	 * Stores the directory URI for this plugin.
	 *
	 * @since  0.2.0
	 * @access private
	 * @var    string
	 */
	private $directory_uri;

	/**
	 * Plugin setup.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function __construct() {

		/* Set the properties needed by the plugin. */
		add_action( 'plugins_loaded', array( $this, 'setup' ), 1 );

		/* Internationalize the text strings used. */
		add_action( 'plugins_loaded', array( $this, 'i18n' ), 2 );

		/* Load the functions files. */
		add_action( 'plugins_loaded', array( $this, 'includes' ), 3 );

		/* Register widgets. */
		add_action( 'widgets_init', array( $this, 'register_widgets' ) );

		/* Register activation hook. */
		register_activation_hook( __FILE__, array( $this, 'activation' ) );
	}

	/**
	 * Defines the directory path and URI for the plugin.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function setup() {
		$this->directory_path = trailingslashit( plugin_dir_path( __FILE__ ) );
		$this->directory_uri  = trailingslashit( plugin_dir_url(  __FILE__ ) );
	}

	/**
	 * Loads the initial files needed by the plugin.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function includes() {

		require_once( "{$this->directory_path}inc/taxonomies.php"                );
		require_once( "{$this->directory_path}inc/template.php"                  );
		require_once( "{$this->directory_path}inc/shortcodes.php"                );
		require_once( "{$this->directory_path}inc/class-widget-list-posts.php"   );
		require_once( "{$this->directory_path}inc/class-widget-list-related.php" );
	}

	/**
	 * Loads the translation files.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function i18n() {

		/* Load the translation of the plugin. */
		load_plugin_textdomain( 'series', false, 'series/languages' );
	}

	/**
	 * Loads the admin functions and files.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function register_widgets() {
		register_widget( 'Series_Widget_List_Posts'   );
		register_widget( 'Series_Widget_List_Related' );
	}

	/**
	 * Method that runs only when the plugin is activated.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return void
	 */
	public function activation() {

		/* Get the administrator role. */
		$role = get_role( 'administrator' );

		/* If the administrator role exists, add required capabilities for the plugin. */
		if ( !empty( $role ) )
			$role->add_cap( 'manage_series' );
	}

	/**
	 * Returns the instance.
	 *
	 * @since  0.2.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		if ( !self::$instance )
			self::$instance = new self;

		return self::$instance;
	}
}

Series_Plugin::get_instance();
