<?php
/**
 * Plugin settings screen.
 *
 * @package   Series
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009 - 2018, Justin Tadlock
 * @link      https://themehybrid.com/plugins/series
 * @license   http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

namespace Series;

/**
 * Sets up and handles the plugin settings screen.
 *
 * @since  2.0.0
 * @access public
 */
final class Settings_Page {

	/**
	 * Settings page name.
	 *
	 * @since  2.0.0
	 * @access public
	 * @var    string
	 */
	public $settings_page = '';

	/**
	 * Sets up the needed actions for adding and saving the meta boxes.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	private function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
	}

	/**
	 * Sets up custom admin menus.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function admin_menu() {

		// Create the settings page.
		$this->settings_page = add_options_page(
			esc_html__( 'Series Settings', 'series' ),
			esc_html__( 'Series', 'series' ),
			apply_filters( 'series/settings_capability', 'manage_options' ),
			'series-settings',
			array( $this, 'settings_page' )
		);

		if ( $this->settings_page ) {

			// Register settings.
			add_action( 'admin_init', array( $this, 'register_settings' ) );
		}
	}

	/**
	 * Registers the plugin settings.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	function register_settings() {

		// Register the setting.
		register_setting( 'series_settings', 'series_settings', array( $this, 'validate_settings' ) );

		/* === Settings Sections === */

		add_settings_section( 'reading',     esc_html__( 'Reading',    'series' ), array( $this, 'section_reading'    ), $this->settings_page );
		add_settings_section( 'permalinks',  esc_html__( 'Permalinks', 'series' ), array( $this, 'section_permalinks' ), $this->settings_page );

		/* === Settings Fields === */

		// Reading section fields.
		add_settings_field( 'posts_per_page', esc_html__( 'Posts Per Page',  'series' ), array( $this, 'field_posts_per_page' ), $this->settings_page, 'reading' );
		add_settings_field( 'posts_orderby',  esc_html__( 'Sort By',         'series' ), array( $this, 'field_posts_orderby'  ), $this->settings_page, 'reading' );
		add_settings_field( 'posts_order',    esc_html__( 'Order',           'series' ), array( $this, 'field_posts_order'    ), $this->settings_page, 'reading' );

		// Permalinks section fields.
		add_settings_field( 'series_rewrite_base',  esc_html__( 'Series Slug', 'series' ), array( $this, 'field_series_rewrite_base' ), $this->settings_page, 'permalinks' );
	}

	/**
	 * Validates the plugin settings.
	 *
	 * @since  2.0.0
	 * @access public
	 * @param  array  $input
	 * @return array
	 */
	function validate_settings( $settings ) {

		// Text boxes.
		$settings['series_rewrite_base'] = $settings['series_rewrite_base'] ? trim( strip_tags( $settings['series_rewrite_base'] ), '/' ) : '';

		// Numbers.
		$posts_per_page = intval( $settings['posts_per_page'] );
		$settings['posts_per_page'] = -2 < $posts_per_page ? $posts_per_page : 10;

		// Select boxes.
		$settings['posts_orderby'] = isset( $settings['posts_orderby'] ) ? strip_tags( $settings['posts_orderby'] ) : 'date';
		$settings['posts_order']   = isset( $settings['posts_order'] )   ? strip_tags( $settings['posts_order']   ) : 'DESC';

		/* === Handle Permalink Conflicts ===*/

		// Return the validated/sanitized settings.
		return $settings;
	}

	/**
	 * Reading section callback.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function section_reading() { ?>

		<p class="description">
			<?php esc_html_e( 'Reading settings for the front end of your site.', 'series' ); ?>
		</p>
	<?php }

	/**
	 * Themes per page field callback.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function field_posts_per_page() { ?>

		<label>
			<input type="number" class="small-text" min="-1" name="series_settings[posts_per_page]" value="<?php echo esc_attr( get_posts_per_page() ); ?>" />
		</label>
	<?php }

	/**
	 * Themes orderby field callback.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function field_posts_orderby() {

		$orderby = array(
			'author'   => __( 'Author',           'series' ),
			'date'     => __( 'Date (Published)', 'series' ),
			'modified' => __( 'Date (Modified)',  'series' ),
			'ID'       => __( 'ID',               'series' ),
			'rand'     => __( 'Random',           'series' ),
			'name'     => __( 'Slug',             'series' ),
			'title'    => __( 'Title',            'series' )
		); ?>

		<label>
			<select name="series_settings[posts_orderby]">

			<?php foreach ( $orderby as $option => $label ) : ?>
				<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $option, get_posts_orderby() ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>

			</select>
		<label>
	<?php }

	/**
	 * Themes order field callback.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function field_posts_order() {

		$order = array(
			'ASC'  => __( 'Ascending',  'series' ),
			'DESC' => __( 'Descending', 'series' )
		); ?>

		<label>
			<select name="series_settings[posts_order]">

			<?php foreach ( $order as $option => $label ) : ?>
				<option value="<?php echo esc_attr( $option ); ?>" <?php selected( $option, get_posts_order() ); ?>><?php echo esc_html( $label ); ?></option>
			<?php endforeach; ?>

			</select>
		<label>
	<?php }

	/**
	 * Permalinks section callback.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function section_permalinks() { ?>

		<p class="description">
			<?php esc_html_e( 'Set up custom permalinks for the series on your site.', 'series' ); ?>
		</p>
	<?php }

	/**
	 * Series ewrite base field callback.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function field_series_rewrite_base() { ?>

		<label>
			<code><?php echo esc_url( home_url( '/' ) ); ?></code>
			<input type="text" class="regular-text code" name="series_settings[series_rewrite_base]" value="<?php echo esc_attr( get_series_rewrite_base() ); ?>" />
		</label>
	<?php }

	/**
	 * Renders the settings page.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return void
	 */
	public function settings_page() {

		// Flush the rewrite rules if the settings were updated.
		if ( isset( $_GET['settings-updated'] ) )
			flush_rewrite_rules(); ?>

		<div class="wrap">
			<h1><?php esc_html_e( 'Series Settings', 'series' ); ?></h1>

			<form method="post" action="options.php">
				<?php settings_fields( 'series_settings' ); ?>
				<?php do_settings_sections( $this->settings_page ); ?>
				<?php submit_button( esc_attr__( 'Update Settings', 'series' ), 'primary' ); ?>
			</form>

		</div><!-- wrap -->
	<?php }

	/**
	 * Returns the instance.
	 *
	 * @since  2.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) )
			$instance = new self;

		return $instance;
	}
}

Settings_Page::get_instance();
