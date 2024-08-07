<?php
/**
 * Load assets for our blocks.
 *
 * @package   CarkeekBlocks
 * @author    Patty O'Hara
 * @link      https://carkeekstudios.com
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load general assets for our blocks.
 *
 * @since 1.0.0
 */
class CarkeekACFRandom_Register {

	/**
	 * This plugin's instance.
	 *
	 * @var CarkeekACFRandom_Register
	 */
	private static $instance;

	/**
	 * Registers the plugin.
	 */
	public static function register() {
		if ( null === self::$instance ) {
			self::$instance = new CarkeekACFRandom_Register();
		}
	}

	/**
	 * The Plugin slug.
	 *
	 * @var string $slug
	 */
	private $slug;

	/**
	 * The Constructor.
	 */
	private function __construct() {
		$this->pslug = 'carkeek-acf-random';
		add_action( 'admin_init', array( $this, 'acf_blocks_has_parent_plugin' ) );
		add_action( 'acf/init', array( $this, 'acf_register_blocks' ) );
		add_filter( 'acf/settings/save_json/key=group_66b29cf9b80a6', array( $this, 'acf_blocks_acf_json_save_point' ) );
		add_filter( 'acf/settings/load_json', array( $this, 'acf_blocks_acf_json_load_point' ) );
	}

	/**
	 * Check to see if ACF Pro is active.
	 */
	public function acf_blocks_has_parent_plugin() {
		if ( is_admin() && current_user_can( 'activate_plugins' ) && ( ! is_plugin_active( 'advanced-custom-fields-pro/acf.php' ) ) ) {

			// If we try to activate this plugin while the parent plugin isn't active.
			if ( isset( $_GET['activate'] ) && ! wp_verify_nonce( $_GET['activate'] ) ) {
				add_action( 'admin_notices', array( $this, 'acf_blocks_parent_plugin_notice' ) );
				unset( $_GET['activate'] );
				// If we deactivate the parent plugin while this plugin is still active.
			} elseif ( ! isset( $_GET['activate'] ) ) {
				add_action( 'admin_notices', array( $this, 'acf_blocks_parent_plugin_notice' ) );
				unset( $_GET['activate'] );
			}

			deactivate_plugins( plugin_basename( __FILE__ ) );

		}
	}

	/**
	 * Provide a notice message if the parent plugin has been deactivated.
	 *
	 * @since 1.0
	 */
	public function acf_blocks_parent_plugin_notice() {
		?>
		<div class="error">
			<p><?php esc_html_e( 'Random Image ACF Block has been deactivated because Advanced Custom Fields Pro 6.0+ has been deactivated. Advanced Custom Fields Pro 6.0+ must be active in order for you to use WDS ACF Blocks.', 'abs' ); ?></p>
		</div>
		<?php
	}
	/**
	 * Specify the location for saving ACF JSON files.
	 *
	 * @param string $path The path we're saving the files.
	 * @return string $path
	 * @author Corey Collins
	 * @since 1.0
	 */
	public function acf_blocks_acf_json_save_point( $path ) {
		error_log( 'acf_blocks_acf_json_save_point' );
		error_log( $path );
		// Update the path.
		$path = plugin_dir_path( __DIR__ ) . '/acf-json';

		return $path;
	}

	/**
	 * Specify the location for loading ACF JSON files.
	 *
	 * @param string $paths The paths from which we're loading the files.
	 * @return string $paths
	 * @author Corey Collins
	 * @since 1.0
	 */
	public function acf_blocks_acf_json_load_point( $paths ) {

		// Append the new path.
		$paths[] = plugin_dir_path( __DIR__ ) . '/acf-json';

		return $paths;
	}

	/**
	 * Register Blocks
	 *
	 * @return void
	 * @author Jenna Hines
	 * @since  2.0.0
	 */
	public function acf_register_blocks() {
		$acf_blocks = glob( plugin_dir_path( __DIR__ ) . 'blocks/*' );
    
		foreach ( $acf_blocks as $block ) {
			register_block_type( $block );
		}
	}
}

CarkeekACFRandom_Register::register();
