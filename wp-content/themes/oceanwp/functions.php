<?php
function theme_start_session()
{
    if (!session_id())
        session_start();
}
add_action("init", "theme_start_session", 1);
add_filter( 'auto_update_plugin', '__return_false' );
add_filter( 'auto_update_theme', '__return_false' );
/**
 * Theme functions and definitions.
 *
 * Sets up the theme and provides some helper functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package OceanWP WordPress theme
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Core Constants.
define( 'OCEANWP_THEME_DIR', get_template_directory() );
define( 'OCEANWP_THEME_URI', get_template_directory_uri() );

/**
 * OceanWP theme class
 */
final class OCEANWP_Theme_Class {

	/**
	 * Main Theme Class Constructor
	 *
	 * @since   1.0.0
	 */
	public function __construct() {
		// Migrate
		$this->migration();

		// Define theme constants.
		$this->oceanwp_constants();

		// Load required files.
		$this->oceanwp_has_setup();

		// Load framework classes.
		add_action( 'after_setup_theme', array( 'OCEANWP_Theme_Class', 'classes' ), 4 );

		// Setup theme => add_theme_support, register_nav_menus, load_theme_textdomain, etc.
		add_action( 'after_setup_theme', array( 'OCEANWP_Theme_Class', 'theme_setup' ), 10 );

		// register sidebar widget areas.
		add_action( 'widgets_init', array( 'OCEANWP_Theme_Class', 'register_sidebars' ) );

		// Registers theme_mod strings into Polylang.
		if ( class_exists( 'Polylang' ) ) {
			add_action( 'after_setup_theme', array( 'OCEANWP_Theme_Class', 'polylang_register_string' ) );
		}

		/** Admin only actions */
		if ( is_admin() ) {

			// Load scripts in the WP admin.
			add_action( 'admin_enqueue_scripts', array( 'OCEANWP_Theme_Class', 'admin_scripts' ) );

			// Outputs custom CSS for the admin.
			add_action( 'admin_head', array( 'OCEANWP_Theme_Class', 'admin_inline_css' ) );

			/** Non Admin actions */
		} else {
			// Load theme js.
			add_action( 'wp_enqueue_scripts', array( 'OCEANWP_Theme_Class', 'theme_js' ) );

			// Load theme CSS.
			add_action( 'wp_enqueue_scripts', array( 'OCEANWP_Theme_Class', 'theme_css' ) );

			// Load his file in last.
			add_action( 'wp_enqueue_scripts', array( 'OCEANWP_Theme_Class', 'custom_style_css' ), 9999 );

			// Remove Customizer CSS script from Front-end.
			add_action( 'init', array( 'OCEANWP_Theme_Class', 'remove_customizer_custom_css' ) );

			// Add a pingback url auto-discovery header for singularly identifiable articles.
			add_action( 'wp_head', array( 'OCEANWP_Theme_Class', 'pingback_header' ), 1 );

			// Add meta viewport tag to header.
			add_action( 'wp_head', array( 'OCEANWP_Theme_Class', 'meta_viewport' ), 1 );

			// Add an X-UA-Compatible header.
			add_filter( 'wp_headers', array( 'OCEANWP_Theme_Class', 'x_ua_compatible_headers' ) );

			// Outputs custom CSS to the head.
			add_action( 'wp_head', array( 'OCEANWP_Theme_Class', 'custom_css' ), 9999 );

			// Minify the WP custom CSS because WordPress doesn't do it by default.
			add_filter( 'wp_get_custom_css', array( 'OCEANWP_Theme_Class', 'minify_custom_css' ) );

			// Alter the search posts per page.
			add_action( 'pre_get_posts', array( 'OCEANWP_Theme_Class', 'search_posts_per_page' ) );

			// Alter WP categories widget to display count inside a span.
			add_filter( 'wp_list_categories', array( 'OCEANWP_Theme_Class', 'wp_list_categories_args' ) );

			// Add a responsive wrapper to the WordPress oembed output.
			add_filter( 'embed_oembed_html', array( 'OCEANWP_Theme_Class', 'add_responsive_wrap_to_oembeds' ), 99, 4 );

			// Adds classes the post class.
			add_filter( 'post_class', array( 'OCEANWP_Theme_Class', 'post_class' ) );

			// Add schema markup to the authors post link.
			add_filter( 'the_author_posts_link', array( 'OCEANWP_Theme_Class', 'the_author_posts_link' ) );

			// Add support for Elementor Pro locations.
			add_action( 'elementor/theme/register_locations', array( 'OCEANWP_Theme_Class', 'register_elementor_locations' ) );

			// Remove the default lightbox script for the beaver builder plugin.
			add_filter( 'fl_builder_override_lightbox', array( 'OCEANWP_Theme_Class', 'remove_bb_lightbox' ) );

			add_filter( 'ocean_enqueue_generated_files', '__return_false' );
		}
	}

	/**
	 * Migration Functinality
	 *
	 * @since   1.0.0
	 */
	public static function migration() {
		if ( get_theme_mod( 'ocean_disable_emoji', false ) ) {
			set_theme_mod( 'ocean_performance_emoji', 'disabled' );
		}

		if ( get_theme_mod( 'ocean_disable_lightbox', false ) ) {
			set_theme_mod( 'ocean_performance_lightbox', 'disabled' );
		}
	}

	/**
	 * Define Constants
	 *
	 * @since   1.0.0
	 */
	public static function oceanwp_constants() {

		$version = self::theme_version();

		// Theme version.
		define( 'OCEANWP_THEME_VERSION', $version );

		// Javascript and CSS Paths.
		define( 'OCEANWP_JS_DIR_URI', OCEANWP_THEME_URI . '/assets/js/' );
		define( 'OCEANWP_CSS_DIR_URI', OCEANWP_THEME_URI . '/assets/css/' );

		// Include Paths.
		define( 'OCEANWP_INC_DIR', OCEANWP_THEME_DIR . '/inc/' );
		define( 'OCEANWP_INC_DIR_URI', OCEANWP_THEME_URI . '/inc/' );

		// Check if plugins are active.
		define( 'OCEAN_EXTRA_ACTIVE', class_exists( 'Ocean_Extra' ) );
		define( 'OCEANWP_ELEMENTOR_ACTIVE', class_exists( 'Elementor\Plugin' ) );
		define( 'OCEANWP_BEAVER_BUILDER_ACTIVE', class_exists( 'FLBuilder' ) );
		define( 'OCEANWP_WOOCOMMERCE_ACTIVE', class_exists( 'WooCommerce' ) );
		define( 'OCEANWP_EDD_ACTIVE', class_exists( 'Easy_Digital_Downloads' ) );
		define( 'OCEANWP_LIFTERLMS_ACTIVE', class_exists( 'LifterLMS' ) );
		define( 'OCEANWP_ALNP_ACTIVE', class_exists( 'Auto_Load_Next_Post' ) );
		define( 'OCEANWP_LEARNDASH_ACTIVE', class_exists( 'SFWD_LMS' ) );
	}

	/**
	 * Load all core theme function files
	 *
	 * @since 1.0.0oceanwp_has_setup
	 */
	public static function oceanwp_has_setup() {

		$dir = OCEANWP_INC_DIR;

		require_once $dir . 'helpers.php';
		require_once $dir . 'header-content.php';
		require_once $dir . 'oceanwp-strings.php';
		require_once $dir . 'oceanwp-svg.php';
		require_once $dir . 'oceanwp-theme-icons.php';
		require_once $dir . 'template-helpers.php';
		require_once $dir . 'customizer/controls/typography/webfonts.php';
		require_once $dir . 'walker/init.php';
		require_once $dir . 'walker/menu-walker.php';
		require_once $dir . 'third/class-gutenberg.php';
		require_once $dir . 'third/class-elementor.php';
		require_once $dir . 'third/class-beaver-themer.php';
		require_once $dir . 'third/class-bbpress.php';
		require_once $dir . 'third/class-buddypress.php';
		require_once $dir . 'third/class-lifterlms.php';
		require_once $dir . 'third/class-learndash.php';
		require_once $dir . 'third/class-sensei.php';
		require_once $dir . 'third/class-social-login.php';
		require_once $dir . 'third/class-amp.php';
		require_once $dir . 'third/class-pwa.php';

		// WooCommerce.
		if ( OCEANWP_WOOCOMMERCE_ACTIVE ) {
			require_once $dir . 'woocommerce/woocommerce-config.php';
		}

		// Easy Digital Downloads.
		if ( OCEANWP_EDD_ACTIVE ) {
			require_once $dir . 'edd/edd-config.php';
		}

	}

	/**
	 * Returns current theme version
	 *
	 * @since   1.0.0
	 */
	public static function theme_version() {

		// Get theme data.
		$theme = wp_get_theme();

		// Return theme version.
		return $theme->get( 'Version' );

	}

	/**
	 * Compare WordPress version
	 *
	 * @access public
	 * @since 1.8.3
	 * @param  string $version - A WordPress version to compare against current version.
	 * @return boolean
	 */
	public static function is_wp_version( $version = '5.4' ) {

		global $wp_version;

		// WordPress version.
		return version_compare( strtolower( $wp_version ), strtolower( $version ), '>=' );

	}


	/**
	 * Check for AMP endpoint
	 *
	 * @return bool
	 * @since 1.8.7
	 */
	public static function oceanwp_is_amp() {
		return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
	}

	/**
	 * Load theme classes
	 *
	 * @since   1.0.0
	 */
	public static function classes() {

		// Admin only classes.
		if ( is_admin() ) {

			// Recommend plugins.
			require_once OCEANWP_INC_DIR . 'activation-notice/class-oceanwp-plugin-manager.php';
			require_once OCEANWP_INC_DIR . 'activation-notice/template.php';

			// Ajax Actions
			if (defined('DOING_AJAX') && DOING_AJAX) {
				require OCEANWP_INC_DIR . 'activation-notice/api.php';
			}

			// Front-end classes.
		} else {

			// Breadcrumbs class.
			require_once OCEANWP_INC_DIR . 'breadcrumbs.php';

		}

		// Customizer class.
		require_once OCEANWP_INC_DIR . 'customizer/library/customizer-custom-controls/functions.php';
		require_once OCEANWP_INC_DIR . 'customizer/customizer.php';

	}

	/**
	 * Theme Setup
	 *
	 * @since   1.0.0
	 */
	public static function theme_setup() {

		// Load text domain.
		load_theme_textdomain( 'oceanwp', OCEANWP_THEME_DIR . '/languages' );

		// Get globals.
		global $content_width;

		// Set content width based on theme's default design.
		if ( ! isset( $content_width ) ) {
			$content_width = 1200;
		}

		// Register navigation menus.
		register_nav_menus(
			array(
				'topbar_menu' => esc_html__( 'Top Bar', 'oceanwp' ),
				'main_menu'   => esc_html__( 'Main', 'oceanwp' ),
				'footer_menu' => esc_html__( 'Footer', 'oceanwp' ),
				'mobile_menu' => esc_html__( 'Mobile (optional)', 'oceanwp' ),
			)
		);

		// Enable support for Post Formats.
		add_theme_support( 'post-formats', array( 'video', 'gallery', 'audio', 'quote', 'link' ) );

		// Enable support for <title> tag.
		add_theme_support( 'title-tag' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		/**
		 * Enable support for header image
		 */
		add_theme_support(
			'custom-header',
			apply_filters(
				'ocean_custom_header_args',
				array(
					'width'       => 2000,
					'height'      => 1200,
					'flex-height' => true,
					'video'       => true,
				)
			)
		);

		/**
		 * Enable support for site logo
		 */
		add_theme_support(
			'custom-logo',
			apply_filters(
				'ocean_custom_logo_args',
				array(
					'height'      => 45,
					'width'       => 164,
					'flex-height' => true,
					'flex-width'  => true,
				)
			)
		);

		/*
		 * Switch default core markup for search form, comment form, comments, galleries, captions and widgets
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
				'widgets',
			)
		);

		// Declare WooCommerce support.
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		// Add editor style.
		add_editor_style( 'assets/css/editor-style.min.css' );

		// Declare support for selective refreshing of widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

	}

	/**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.1.0
	 */
	public static function pingback_header() {

		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
		}

	}

	/**
	 * Adds the meta tag to the site header
	 *
	 * @since 1.0.0
	 */
	public static function meta_viewport() {

		// Meta viewport.
		$viewport = '<meta name="viewport" content="width=device-width, initial-scale=1">';

		// Apply filters for child theme tweaking.
		echo apply_filters( 'ocean_meta_viewport', $viewport ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}

	/**
	 * Load scripts in the WP admin
	 *
	 * @since 1.0.0
	 */
	public static function admin_scripts() {
		global $pagenow;
		if ( 'nav-menus.php' === $pagenow ) {
			wp_enqueue_style( 'oceanwp-menus', OCEANWP_INC_DIR_URI . 'walker/assets/menus.css', false, OCEANWP_THEME_VERSION );
		}
	}

	/**
	 * Load front-end scripts
	 *
	 * @since   1.0.0
	 */
	public static function theme_css() {

		// Define dir.
		$dir           = OCEANWP_CSS_DIR_URI;
		$theme_version = OCEANWP_THEME_VERSION;

		// Remove font awesome style from plugins.
		wp_deregister_style( 'font-awesome' );
		wp_deregister_style( 'fontawesome' );

		// Enqueue font awesome style.
		if ( get_theme_mod( 'ocean_performance_fontawesome', 'enabled' ) === 'enabled' ) {
			wp_enqueue_style( 'font-awesome', OCEANWP_THEME_URI . '/assets/fonts/fontawesome/css/all.min.css', false, '5.15.1' );
		}
    wp_enqueue_style( 'custom', OCEANWP_THEME_URI .'/assets//css/customize.css', false, '1.67868' );
		// Enqueue simple line icons style.
		if ( get_theme_mod( 'ocean_performance_simple_line_icons', 'enabled' ) === 'enabled' ) {
			wp_enqueue_style( 'simple-line-icons', $dir . 'third/simple-line-icons.min.css', false, '2.4.0' );
		}

		// Enqueue Main style.
		wp_enqueue_style( 'oceanwp-style', $dir . 'style.min.css', false, $theme_version );

		// Blog Header styles.
		if ( 'default' !== get_theme_mod( 'oceanwp_single_post_header_style', 'default' )
			&& is_single() && 'post' === get_post_type() ) {
			wp_enqueue_style( 'oceanwp-blog-headers', $dir . 'blog/blog-post-headers.css', false, $theme_version );
		}

		// Register perfect-scrollbar plugin style.
		wp_register_style( 'ow-perfect-scrollbar', $dir . 'third/perfect-scrollbar.css', false, '1.5.0' );

		// Register hamburgers buttons to easily use them.
		wp_register_style( 'oceanwp-hamburgers', $dir . 'third/hamburgers/hamburgers.min.css', false, $theme_version );
		// Register hamburgers buttons styles.
		$hamburgers = oceanwp_hamburgers_styles();
		foreach ( $hamburgers as $class => $name ) {
			wp_register_style( 'oceanwp-' . $class . '', $dir . 'third/hamburgers/types/' . $class . '.css', false, $theme_version );
		}

		// Get mobile menu icon style.
		$mobile_menu = get_theme_mod( 'ocean_mobile_menu_open_hamburger', 'default' );
		// Enqueue mobile menu icon style.
		if ( ! empty( $mobile_menu ) && 'default' !== $mobile_menu ) {
			wp_enqueue_style( 'oceanwp-hamburgers' );
			wp_enqueue_style( 'oceanwp-' . $mobile_menu . '' );
		}

		// If Vertical header style.
		if ( 'vertical' === oceanwp_header_style() ) {
			wp_enqueue_style( 'oceanwp-hamburgers' );
			wp_enqueue_style( 'oceanwp-spin' );
			wp_enqueue_style( 'ow-perfect-scrollbar' );
		}
	}

	/**
	 * Returns all js needed for the front-end
	 *
	 * @since 1.0.0
	 */
	public static function theme_js() {

		if ( self::oceanwp_is_amp() ) {
			return;
		}

		// Get js directory uri.
		$dir = OCEANWP_JS_DIR_URI;

		// Get current theme version.
		$theme_version = OCEANWP_THEME_VERSION;

		// Get localized array.
		$localize_array = self::localize_array();

		// Main script dependencies.
		$main_script_dependencies = array( 'jquery' );

		// Comment reply.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Add images loaded.
		wp_enqueue_script( 'imagesloaded' );

		/**
		 * Load Venors Scripts.
		 */

		// Isotop.
		wp_register_script( 'ow-isotop', $dir . 'vendors/isotope.pkgd.min.js', array(), '3.0.6', true );

		// Flickity.
		wp_register_script( 'ow-flickity', $dir . 'vendors/flickity.pkgd.min.js', array(), $theme_version, true );

		// Magnific Popup.
		wp_register_script( 'ow-magnific-popup', $dir . 'vendors/magnific-popup.min.js', array( 'jquery' ), $theme_version, true );

		// Sidr Mobile Menu.
		wp_register_script( 'ow-sidr', $dir . 'vendors/sidr.js', array(), $theme_version, true );

		// Perfect Scrollbar.
		wp_register_script( 'ow-perfect-scrollbar', $dir . 'vendors/perfect-scrollbar.min.js', array(), $theme_version, true );

		// Smooth Scroll.
		wp_register_script( 'ow-smoothscroll', $dir . 'vendors/smoothscroll.min.js', array(), $theme_version, false );

		/**
		 * Load Theme Scripts.
		 */

		// Theme script.
		wp_enqueue_script( 'oceanwp-main', $dir . 'theme.min.js', $main_script_dependencies, $theme_version, true );
		wp_localize_script( 'oceanwp-main', 'oceanwpLocalize', $localize_array );
		array_push( $main_script_dependencies, 'oceanwp-main' );

		// Blog Masonry script.
		if ( 'masonry' === oceanwp_blog_grid_style() ) {
			array_push( $main_script_dependencies, 'ow-isotop' );
			wp_enqueue_script( 'ow-isotop' );
			wp_enqueue_script( 'oceanwp-blog-masonry', $dir . 'blog-masonry.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Menu script.
		switch ( oceanwp_header_style() ) {
			case 'full_screen':
				wp_enqueue_script( 'oceanwp-full-screen-menu', $dir . 'full-screen-menu.min.js', $main_script_dependencies, $theme_version, true );
				break;
			case 'vertical':
				array_push( $main_script_dependencies, 'ow-perfect-scrollbar' );
				wp_enqueue_script( 'ow-perfect-scrollbar' );
				wp_enqueue_script( 'oceanwp-vertical-header', $dir . 'vertical-header.min.js', $main_script_dependencies, $theme_version, true );
				break;
		}

		// Mobile Menu script.
		switch ( oceanwp_mobile_menu_style() ) {
			case 'dropdown':
				wp_enqueue_script( 'oceanwp-drop-down-mobile-menu', $dir . 'drop-down-mobile-menu.min.js', $main_script_dependencies, $theme_version, true );
				break;
			case 'fullscreen':
				wp_enqueue_script( 'oceanwp-full-screen-mobile-menu', $dir . 'full-screen-mobile-menu.min.js', $main_script_dependencies, $theme_version, true );
				break;
			case 'sidebar':
				array_push( $main_script_dependencies, 'ow-sidr' );
				wp_enqueue_script( 'ow-sidr' );
				wp_enqueue_script( 'oceanwp-sidebar-mobile-menu', $dir . 'sidebar-mobile-menu.min.js', $main_script_dependencies, $theme_version, true );
				break;
		}

		// Search script.
		switch ( oceanwp_menu_search_style() ) {
			case 'drop_down':
				wp_enqueue_script( 'oceanwp-drop-down-search', $dir . 'drop-down-search.min.js', $main_script_dependencies, $theme_version, true );
				break;
			case 'header_replace':
				wp_enqueue_script( 'oceanwp-header-replace-search', $dir . 'header-replace-search.min.js', $main_script_dependencies, $theme_version, true );
				break;
			case 'overlay':
				wp_enqueue_script( 'oceanwp-overlay-search', $dir . 'overlay-search.min.js', $main_script_dependencies, $theme_version, true );
				break;
		}

		// Mobile Search Icon Style.
		if ( oceanwp_mobile_menu_search_style() !== 'disabled' ) {
			wp_enqueue_script( 'oceanwp-mobile-search-icon', $dir . 'mobile-search-icon.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Equal Height Elements script.
		if ( oceanwp_blog_entry_equal_heights() ) {
			wp_enqueue_script( 'oceanwp-equal-height-elements', $dir . 'equal-height-elements.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Lightbox script.
		if ( oceanwp_gallery_is_lightbox_enabled() || get_theme_mod( 'ocean_performance_lightbox', 'enabled' ) === 'enabled' ) {
			array_push( $main_script_dependencies, 'ow-magnific-popup' );
			wp_enqueue_script( 'ow-magnific-popup' );
			wp_enqueue_script( 'oceanwp-lightbox', $dir . 'ow-lightbox.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Slider script.
		array_push( $main_script_dependencies, 'ow-flickity' );
		wp_enqueue_script( 'ow-flickity' );
		wp_enqueue_script( 'oceanwp-slider', $dir . 'ow-slider.min.js', $main_script_dependencies, $theme_version, true );

		// Scroll Effect script.
		wp_enqueue_script( 'oceanwp-scroll-effect', $dir . 'scroll-effect.min.js', $main_script_dependencies, $theme_version, true );

		// Scroll to Top script.
		if ( oceanwp_display_scroll_up_button() ) {
			wp_enqueue_script( 'oceanwp-scroll-top', $dir . 'scroll-top.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Custom Select script.
		if ( get_theme_mod( 'ocean_performance_custom_select', 'enabled' ) === 'enabled' ) {
			wp_enqueue_script( 'oceanwp-select', $dir . 'select.min.js', $main_script_dependencies, $theme_version, true );
		}

		// Infinite Scroll script.
		if ( 'infinite_scroll' === get_theme_mod( 'ocean_blog_pagination_style', 'standard' ) || 'infinite_scroll' === get_theme_mod( 'ocean_woo_pagination_style', 'standard' ) ) {
			wp_enqueue_script( 'oceanwp-infinite-scroll', $dir . 'ow-infinite-scroll.min.js', $main_script_dependencies, $theme_version, true );
		}

		// WooCommerce scripts.
		if ( OCEANWP_WOOCOMMERCE_ACTIVE
		&& 'yes' !== get_theme_mod( 'ocean_woo_remove_custom_features', 'no' ) ) {
			wp_enqueue_script( 'oceanwp-woocommerce-custom-features', $dir . 'wp-plugins/woocommerce/woo-custom-features.min.js', array( 'jquery' ), $theme_version, true );
			wp_localize_script( 'oceanwp-woocommerce-custom-features', 'oceanwpLocalize', $localize_array );
		}

		// Register scripts for old addons.
		wp_register_script( 'nicescroll', $dir . 'vendors/support-old-oceanwp-addons/jquery.nicescroll.min.js', array( 'jquery' ), $theme_version, true );
	}

	/**
	 * Functions.js localize array
	 *
	 * @since 1.0.0
	 */
	public static function localize_array() {

		// Create array.
		$sidr_side   = get_theme_mod( 'ocean_mobile_menu_sidr_direction', 'left' );
		$sidr_side   = $sidr_side ? $sidr_side : 'left';
		$sidr_target = get_theme_mod( 'ocean_mobile_menu_sidr_dropdown_target', 'link' );
		$sidr_target = $sidr_target ? $sidr_target : 'link';
		$vh_target   = get_theme_mod( 'ocean_vertical_header_dropdown_target', 'link' );
		$vh_target   = $vh_target ? $vh_target : 'link';
		$array       = array(
			'nonce'                 => wp_create_nonce( 'oceanwp' ),
			'isRTL'                 => is_rtl(),
			'menuSearchStyle'       => oceanwp_menu_search_style(),
			'mobileMenuSearchStyle' => oceanwp_mobile_menu_search_style(),
			'sidrSource'            => oceanwp_sidr_menu_source(),
			'sidrDisplace'          => get_theme_mod( 'ocean_mobile_menu_sidr_displace', true ) ? true : false,
			'sidrSide'              => $sidr_side,
			'sidrDropdownTarget'    => $sidr_target,
			'verticalHeaderTarget'  => $vh_target,
			'customSelects'         => '.woocommerce-ordering .orderby, #dropdown_product_cat, .widget_categories select, .widget_archive select, .single-product .variations_form .variations select',
		);

		// WooCart.
		if ( OCEANWP_WOOCOMMERCE_ACTIVE ) {
			$array['wooCartStyle'] = oceanwp_menu_cart_style();
		}

		// Apply filters and return array.
		return apply_filters( 'ocean_localize_array', $array );
	}

	/**
	 * Add headers for IE to override IE's Compatibility View Settings
	 *
	 * @param obj $headers   header settings.
	 * @since 1.0.0
	 */
	public static function x_ua_compatible_headers( $headers ) {
		$headers['X-UA-Compatible'] = 'IE=edge';
		return $headers;
	}

	/**
	 * Registers sidebars
	 *
	 * @since   1.0.0
	 */
	public static function register_sidebars() {

		$heading = get_theme_mod( 'ocean_sidebar_widget_heading_tag', 'h4' );
		$heading = apply_filters( 'ocean_sidebar_widget_heading_tag', $heading );

		$foo_heading = get_theme_mod( 'ocean_footer_widget_heading_tag', 'h4' );
		$foo_heading = apply_filters( 'ocean_footer_widget_heading_tag', $foo_heading );

		// Default Sidebar.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Default Sidebar', 'oceanwp' ),
				'id'            => 'sidebar',
				'description'   => esc_html__( 'Widgets in this area will be displayed in the left or right sidebar area if you choose the Left or Right Sidebar layout.', 'oceanwp' ),
				'before_widget' => '<div id="%1$s" class="sidebar-box %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $heading . ' class="widget-title">',
				'after_title'   => '</' . $heading . '>',
			)
		);

		// Left Sidebar.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Left Sidebar', 'oceanwp' ),
				'id'            => 'sidebar-2',
				'description'   => esc_html__( 'Widgets in this area are used in the left sidebar region if you use the Both Sidebars layout.', 'oceanwp' ),
				'before_widget' => '<div id="%1$s" class="sidebar-box %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $heading . ' class="widget-title">',
				'after_title'   => '</' . $heading . '>',
			)
		);

		// Search Results Sidebar.
		if ( get_theme_mod( 'ocean_search_custom_sidebar', true ) ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Search Results Sidebar', 'oceanwp' ),
					'id'            => 'search_sidebar',
					'description'   => esc_html__( 'Widgets in this area are used in the search result page.', 'oceanwp' ),
					'before_widget' => '<div id="%1$s" class="sidebar-box %2$s clr">',
					'after_widget'  => '</div>',
					'before_title'  => '<' . $heading . ' class="widget-title">',
					'after_title'   => '</' . $heading . '>',
				)
			);
		}

		// Footer 1.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer 1', 'oceanwp' ),
				'id'            => 'footer-one',
				'description'   => esc_html__( 'Widgets in this area are used in the first footer region.', 'oceanwp' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $foo_heading . ' class="widget-title">',
				'after_title'   => '</' . $foo_heading . '>',
			)
		);

		// Footer 2.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer 2', 'oceanwp' ),
				'id'            => 'footer-two',
				'description'   => esc_html__( 'Widgets in this area are used in the second footer region.', 'oceanwp' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $foo_heading . ' class="widget-title">',
				'after_title'   => '</' . $foo_heading . '>',
			)
		);

		// Footer 3.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer 3', 'oceanwp' ),
				'id'            => 'footer-three',
				'description'   => esc_html__( 'Widgets in this area are used in the third footer region.', 'oceanwp' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $foo_heading . ' class="widget-title">',
				'after_title'   => '</' . $foo_heading . '>',
			)
		);

		// Footer 4.
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer 4', 'oceanwp' ),
				'id'            => 'footer-four',
				'description'   => esc_html__( 'Widgets in this area are used in the fourth footer region.', 'oceanwp' ),
				'before_widget' => '<div id="%1$s" class="footer-widget %2$s clr">',
				'after_widget'  => '</div>',
				'before_title'  => '<' . $foo_heading . ' class="widget-title">',
				'after_title'   => '</' . $foo_heading . '>',
			)
		);

	}

	/**
	 * Registers theme_mod strings into Polylang.
	 *
	 * @since 1.1.4
	 */
	public static function polylang_register_string() {

		if ( function_exists( 'pll_register_string' ) && $strings = oceanwp_register_tm_strings() ) {
			foreach ( $strings as $string => $default ) {
				pll_register_string( $string, get_theme_mod( $string, $default ), 'Theme Mod', true );
			}
		}

	}

	/**
	 * All theme functions hook into the oceanwp_head_css filter for this function.
	 *
	 * @param obj $output output value.
	 * @since 1.0.0
	 */
	public static function custom_css( $output = null ) {

		// Add filter for adding custom css via other functions.
		$output = apply_filters( 'ocean_head_css', $output );

		// If Custom File is selected.
		if ( 'file' === get_theme_mod( 'ocean_customzer_styling', 'head' ) ) {

			global $wp_customize;
			$upload_dir = wp_upload_dir();

			// Render CSS in the head.
			if ( isset( $wp_customize ) || ! file_exists( $upload_dir['basedir'] . '/oceanwp/custom-style.css' ) ) {

				// Minify and output CSS in the wp_head.
				if ( ! empty( $output ) ) {
					echo "<!-- OceanWP CSS -->\n<style type=\"text/css\">\n" . wp_strip_all_tags( oceanwp_minify_css( $output ) ) . "\n</style>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
			}
		} else {

			// Minify and output CSS in the wp_head.
			if ( ! empty( $output ) ) {
				echo "<!-- OceanWP CSS -->\n<style type=\"text/css\">\n" . wp_strip_all_tags( oceanwp_minify_css( $output ) ) . "\n</style>"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

	}

	/**
	 * Minify the WP custom CSS because WordPress doesn't do it by default.
	 *
	 * @param obj $css minify css.
	 * @since 1.1.9
	 */
	public static function minify_custom_css( $css ) {

		return oceanwp_minify_css( $css );

	}

	/**
	 * Include Custom CSS file if present.
	 *
	 * @param obj $output output value.
	 * @since 1.4.12
	 */
	public static function custom_style_css( $output = null ) {

		// If Custom File is not selected.
		if ( 'file' !== get_theme_mod( 'ocean_customzer_styling', 'head' ) ) {
			return;
		}

		global $wp_customize;
		$upload_dir = wp_upload_dir();

		// Get all the customier css.
		$output = apply_filters( 'ocean_head_css', $output );

		// Get Custom Panel CSS.
		$output_custom_css = wp_get_custom_css();

		// Minified the Custom CSS.
		$output .= oceanwp_minify_css( $output_custom_css );

		// Render CSS from the custom file.
		if ( ! isset( $wp_customize ) && file_exists( $upload_dir['basedir'] . '/oceanwp/custom-style.css' ) && ! empty( $output ) ) {
			wp_enqueue_style( 'oceanwp-custom', trailingslashit( $upload_dir['baseurl'] ) . 'oceanwp/custom-style.css', false, false );
		}
	}

	/**
	 * Remove Customizer style script from front-end
	 *
	 * @since 1.4.12
	 */
	public static function remove_customizer_custom_css() {

		// If Custom File is not selected.
		if ( 'file' !== get_theme_mod( 'ocean_customzer_styling', 'head' ) ) {
			return;
		}

		global $wp_customize;

		// Disable Custom CSS in the frontend head.
		remove_action( 'wp_head', 'wp_custom_css_cb', 11 );
		remove_action( 'wp_head', 'wp_custom_css_cb', 101 );

		// If custom CSS file exists and NOT in customizer screen.
		if ( isset( $wp_customize ) ) {
			add_action( 'wp_footer', 'wp_custom_css_cb', 9999 );
		}
	}

	/**
	 * Adds inline CSS for the admin
	 *
	 * @since 1.0.0
	 */
	public static function admin_inline_css() {
		echo '<style>div#setting-error-tgmpa{display:block;}</style>';
	}

	/**
	 * Alter the search posts per page
	 *
	 * @param obj $query query.
	 * @since 1.3.7
	 */
	public static function search_posts_per_page( $query ) {
		$posts_per_page = get_theme_mod( 'ocean_search_post_per_page', '8' );
		$posts_per_page = $posts_per_page ? $posts_per_page : '8';

		if ( $query->is_main_query() && is_search() ) {
			$query->set( 'posts_per_page', $posts_per_page );
		}
	}

	/**
	 * Alter wp list categories arguments.
	 * Adds a span around the counter for easier styling.
	 *
	 * @param obj $links link.
	 * @since 1.0.0
	 */
	public static function wp_list_categories_args( $links ) {
		$links = str_replace( '</a> (', '</a> <span class="cat-count-span">(', $links );
		$links = str_replace( ')', ')</span>', $links );
		return $links;
	}

	/**
	 * Alters the default oembed output.
	 * Adds special classes for responsive oembeds via CSS.
	 *
	 * @param obj $cache     cache.
	 * @param url $url       url.
	 * @param obj $attr      attributes.
	 * @param obj $post_ID   post id.
	 * @since 1.0.0
	 */
	public static function add_responsive_wrap_to_oembeds( $cache, $url, $attr, $post_ID ) {

		// Supported video embeds.
		$hosts = apply_filters(
			'ocean_oembed_responsive_hosts',
			array(
				'vimeo.com',
				'youtube.com',
				'youtu.be',
				'blip.tv',
				'money.cnn.com',
				'dailymotion.com',
				'flickr.com',
				'hulu.com',
				'kickstarter.com',
				'vine.co',
				'soundcloud.com',
				'#http://((m|www)\.)?youtube\.com/watch.*#i',
				'#https://((m|www)\.)?youtube\.com/watch.*#i',
				'#http://((m|www)\.)?youtube\.com/playlist.*#i',
				'#https://((m|www)\.)?youtube\.com/playlist.*#i',
				'#http://youtu\.be/.*#i',
				'#https://youtu\.be/.*#i',
				'#https?://(.+\.)?vimeo\.com/.*#i',
				'#https?://(www\.)?dailymotion\.com/.*#i',
				'#https?://dai\.ly/*#i',
				'#https?://(www\.)?hulu\.com/watch/.*#i',
				'#https?://wordpress\.tv/.*#i',
				'#https?://(www\.)?funnyordie\.com/videos/.*#i',
				'#https?://vine\.co/v/.*#i',
				'#https?://(www\.)?collegehumor\.com/video/.*#i',
				'#https?://(www\.|embed\.)?ted\.com/talks/.*#i',
			)
		);

		// Supports responsive.
		$supports_responsive = false;

		// Check if responsive wrap should be added.
		foreach ( $hosts as $host ) {
			if ( strpos( $url, $host ) !== false ) {
				$supports_responsive = true;
				break; // no need to loop further.
			}
		}

		// Output code.
		if ( $supports_responsive ) {
			return '<p class="responsive-video-wrap clr">' . $cache . '</p>';
		} else {
			return '<div class="oceanwp-oembed-wrap clr">' . $cache . '</div>';
		}

	}

	/**
	 * Adds extra classes to the post_class() output
	 *
	 * @param obj $classes   Return classes.
	 * @since 1.0.0
	 */
	public static function post_class( $classes ) {

		// Get post.
		global $post;

		// Add entry class.
		$classes[] = 'entry';

		// Add has media class.
		if ( has_post_thumbnail()
			|| get_post_meta( $post->ID, 'ocean_post_oembed', true )
			|| get_post_meta( $post->ID, 'ocean_post_self_hosted_media', true )
			|| get_post_meta( $post->ID, 'ocean_post_video_embed', true )
		) {
			$classes[] = 'has-media';
		}

		// Return classes.
		return $classes;

	}

	/**
	 * Add schema markup to the authors post link
	 *
	 * @param obj $link   Author link.
	 * @since 1.0.0
	 */
	public static function the_author_posts_link( $link ) {

		// Add schema markup.
		$schema = oceanwp_get_schema_markup( 'author_link' );
		if ( $schema ) {
			$link = str_replace( 'rel="author"', 'rel="author" ' . $schema, $link );
		}

		// Return link.
		return $link;

	}

	/**
	 * Add support for Elementor Pro locations
	 *
	 * @param obj $elementor_theme_manager    Elementor Instance.
	 * @since 1.5.6
	 */
	public static function register_elementor_locations( $elementor_theme_manager ) {
		$elementor_theme_manager->register_all_core_location();
	}

	/**
	 * Add schema markup to the authors post link
	 *
	 * @since 1.1.5
	 */
	public static function remove_bb_lightbox() {
		return true;
	}

}

/**--------------------------------------------------------------------------------
#region Freemius - This logic will only be executed when Ocean Extra is active and has the Freemius SDK
---------------------------------------------------------------------------------*/

if ( ! function_exists( 'owp_fs' ) ) {
	if ( class_exists( 'Ocean_Extra' ) &&
			defined( 'OE_FILE_PATH' ) &&
			file_exists( dirname( OE_FILE_PATH ) . '/includes/freemius/start.php' )
	) {
		/**
		 * Create a helper function for easy SDK access.
		 */
		function owp_fs() {
			global $owp_fs;

			if ( ! isset( $owp_fs ) ) {
				// Include Freemius SDK.
				require_once dirname( OE_FILE_PATH ) . '/includes/freemius/start.php';

				$owp_fs = fs_dynamic_init(
					array(
						'id'                             => '3752',
						'bundle_id'                      => '3767',
						'slug'                           => 'oceanwp',
						'type'                           => 'theme',
						'public_key'                     => 'pk_043077b34f20f5e11334af3c12493',
						'bundle_public_key'              => 'pk_c334eb1ae413deac41e30bf00b9dc',
						'is_premium'                     => false,
						'has_addons'                     => true,
						'has_paid_plans'                 => true,
						'menu'                           => array(
'slug'    => 'oceanwp',
							'account' => true,
							'contact' => false,
							'support' => false,
						),
						'bundle_license_auto_activation' => true,
						'navigation'                     => 'menu',
						'is_org_compliant'               => true,
					)
				);
			}

			return $owp_fs;
		}

		// Init Freemius.
		owp_fs();
		// Signal that SDK was initiated.
		do_action( 'owp_fs_loaded' );
	}
}

// endregion

function add_loginout_link( $items, $args ) {
  if (is_user_logged_in() && $args->theme_location == 'main_menu') {
      $items .= '<li><a href="'. wp_logout_url() .'">Log Out</a></li> <li><a href="'. site_url('login') .'#custom_html-2" class="menu-link"><span class="subscribe-link">Subscribe Now</span></a></li>';
  }
  elseif (!is_user_logged_in() && $args->theme_location == 'main_menu') {
      $items .= '<li><a href="'. site_url('login') .'">Log In</a></li> <li><a href="'. site_url('login') .'#custom_html-2" class="menu-link"><span class="subscribe-link">Subscribe Now</span></a></li>';
  }
  return $items;
}

new OCEANWP_Theme_Class();



/***************/

function testimonial_function() {

  if(isset($_POST["action"]) && $_POST["action"] == "save" && isset($_POST["post_type"]) && $_POST["post_type"] == "testimonial")
  {

    $testimonial 	= $_POST["testimonial"];
    $user_id 		= get_current_user_id();

    $current_user 	= wp_get_current_user();

    if ( is_user_logged_in() ) {
     $first_name = esc_html( ucfirst( $current_user->user_login ) );
  } else {
      $first_name = $_POST["first_name"];
      $last_name = $_POST["last_name"];
  }

      $post = array(
          'post_title'    => $first_name.' '.$last_name,
          'post_content'	=> $testimonial,
          'post_status'   => 'pending',
          'post_type'     => 'testimonial',
          'post_author'   => 1,
      );

      $post_id = wp_insert_post($post); 
      
      //$_SESSION["successtestimonialMsg"] = "Thank you for your review. We are glad that you had a great experience with us!";
     
      wp_redirect( get_permalink( 2055 ).'?success=yes' );            
      exit;                                           
  }    
}    
add_action('init', 'testimonial_function');

/****************/

add_action( 'wp_ajax_subscribe_mailchimp', 'subscribe_mailchimp');
add_action( 'wp_ajax_nopriv_subscribe_mailchimp',  'subscribe_mailchimp');
function subscribe_mailchimp(){
  /*********** Start - MailChimp **************/

  define('MAILCHIMP_LIST_ID', 'b1f3f47bdd');
define('MAILCHIMP_DC', 'us17');
define('MAILCHIMP_API_KEY', '034e69d26f94c9f0ed455feb76806ff0-us17');

  $mailChimpData = array(
      "email_address" => $_REQUEST['email'], 
      "status" => "subscribed"
  );

  $ch = curl_init('https://'.MAILCHIMP_DC.'.api.mailchimp.com/3.0/lists/'.MAILCHIMP_LIST_ID.'/members/');
  curl_setopt_array($ch, array(
      CURLOPT_POST => TRUE,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_HTTPHEADER => array(
          'Authorization: apikey '.MAILCHIMP_API_KEY,
          'Content-Type: application/json'
      ),
      CURLOPT_POSTFIELDS => json_encode($mailChimpData)
  ));
  curl_exec($ch);

  /*********** End - MailChimp **************/
}

add_filter( 'wpcf7_form_elements', 'imp_wpcf7_form_elements' );
function imp_wpcf7_form_elements( $content ) {
  $str_pos = strpos( $content, 'name="your-name"' );
  $content = substr_replace( $content, 'autocomplete="off" ', $str_pos, 0 );

  $str_pos = strpos( $content, 'name="your-email"' );
  $content = substr_replace( $content, 'autocomplete="off" ', $str_pos, 0 );

  return $content;
}

function my_pmpro_paypal_button_image( $url ) {
return 'https://slowrisepizza.temp513.kinsta.cloud/wp-content/uploads/2020/09/paypal-button@1x.png';
}
add_filter( 'pmpro_paypal_button_image', 'my_pmpro_paypal_button_image' );

//Settings Page

class MySettingsPage
{
  private $options;

  public function __construct()
  {
      add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
      add_action( 'admin_init', array( $this, 'page_init' ) );
  }

  public function add_plugin_page()
  {
      // This page will be under "Settings"
      add_options_page(
          'Settings Admin', 
          'Zoom Settings', 
          'manage_options', 
          'zoom-setting', 
          array( $this, 'create_admin_page' )
      );
  }

  public function create_admin_page()
  {
      // Set class property
      $this->options = get_option( 'my_option_name' );
      ?>
      <div class="wrap">
          <h1>Zoom Seetings</h1>
          <form method="post" action="options.php">
          <?php
              // This prints out all hidden setting fields
              settings_fields( 'my_option_group' );
              do_settings_sections( 'my-setting-admin' );
              submit_button();
          ?>
          </form>
      </div>
      <?php
  }

  public function page_init()
  {        
      register_setting(
          'my_option_group', // Option group
          'my_option_name', // Option name
          array( $this, 'sanitize' ) // Sanitize
      );

      add_settings_section(
          'setting_section_id', // ID
          'Zoom Email Settings', // Title
          array( $this, 'print_section_info' ), // Callback
          'my-setting-admin' // Page
      );  

      add_settings_field(
          'send_email', // ID
          'Send End Meeting Email:', // Title 
          array( $this, 'id_number_callback' ), // Callback
          'my-setting-admin', // Page
          'setting_section_id' // Section           
      );       
  }

  public function sanitize( $input )
  {
      $new_input = array();
      //if( isset( $input['send_email'] ) )
          $new_input['send_email'] = absint( $input['send_email'] );

      return $new_input;
  }

  public function print_section_info()
  {
      print 'Enter your settings below:';
  }

  public function id_number_callback()
  {
      ?>
      <input type="checkbox" id="send_email" name="my_option_name[send_email]" value="<?php echo $this->options['send_email']; ?>" <?php if($this->options['send_email']=='1'){echo 'checked';}?> onclick="if(this.checked){this.value='1';}else{this.value='0';}">
      <?php
  }
}

if( is_admin() )
  $my_settings_page = new MySettingsPage();

// validate username on checkout
add_action( 'wp_ajax_checkout_username_validation', 'checkout_username_validation');
add_action( 'wp_ajax_nopriv_checkout_username_validation',  'checkout_username_validation');

function checkout_username_validation(){
  global $table_prefix, $wpdb;
  $key = $_POST['key'];
  $val = $_POST['val'];

  $tblname = 'users';
  $wp_track_table = $table_prefix . "$tblname ";
  $result = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM {$wp_track_table} WHERE `$key` = '$val' "), ARRAY_A );
  if ($result){
      echo 1;
  }else{
      echo 0;
  }
  die();
}

// validate email on checkout
add_action( 'wp_ajax_checkout_email_validation', 'checkout_email_validation');
add_action( 'wp_ajax_nopriv_checkout_email_validation',  'checkout_email_validation');

function checkout_email_validation(){
  global $table_prefix, $wpdb;
  $key = $_POST['key'];
  $val = $_POST['val'];

  $tblname = 'users';
  $wp_track_table = $table_prefix . "$tblname ";
  $result = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM {$wp_track_table} WHERE `$key` = '$val' "), ARRAY_A );
  if ($result){
      echo 1;
  }else{
      echo 0;
  }
  die();
}


/*=============================================================
 Remved wordpress update options and update count End
==============================================================*/

//add_action( 'admin_init', 'hide_update_notifications_users' );
function hide_update_notifications_users() {
  global $menu, $submenu;
  $user = wp_get_current_user();

  // ENTER HERE THE ONLY ALLOWED USERNAME
  $allowed = array( 'rodolfomelogli' );

  // HIDE WP, PLUGIN, THEME NOTIFICATIONS FOR ALL OTHER USERS
  if ( $user && isset( $user->user_login ) && ! in_array( $user->user_login, $allowed ) ) {
      add_filter( 'pre_site_transient_update_core', 'disable_update_notifications' );
      add_filter( 'pre_site_transient_update_plugins', 'disable_update_notifications' );
      add_filter( 'pre_site_transient_update_themes', 'disable_update_notifications' );

      // ALSO REMOVE THE RED UPDATE COUNTERS @ SIDEBAR MENU ITEMS
      $menu[65][0] = 'Plugins up to date';
      $submenu['index.php'][10][0] = 'Updates disabled';
  }
}

function disable_update_notifications() {
  global $wp_version;
  return (object) array( 'last_checked' => time(), 'version_checked' => $wp_version, );
}
/*=============================================================
 Remved wordpress update options and update count End
==============================================================*/


//var_dump($_SESSION);

/* ******** mailchimp ecommerce integration starts ************* */


// store campaign id in session
add_action( 'wp_ajax_store_campaign_id', 'store_campaign_id');
add_action( 'wp_ajax_nopriv_store_campaign_id',  'store_campaign_id');
function store_campaign_id(){
//session_start();
$campaignID = $_POST['campaignID'];
$_SESSION['mc_cid'] = $campaignID;

if(isset($_SESSION['mc_cid'])){
  echo 1;
}else{
  echo 0;
}
die();
}



// add user to mailchimp when registered
//add_action('user_register', 'add_customer_in_mailchimp');
function add_customer_in_mailchimp( $user_id ) {
  
//if (isset($_SESSION['mc_cid'])){
  
  $user    = get_userdata( $user_id );
  $first_name = get_user_meta( $user->ID, 'first_name', true );
      $last_name = get_user_meta( $user->ID, 'last_name', true );

  $user_id = $user->ID;
  $user_name = $user->user_login;
  $user_email = $user->user_email;
  $store_name = "on_demand_classes";

  require_once(ABSPATH . 'mailchimp-marketing-php/vendor/autoload.php');

  $client = new MailchimpMarketing\ApiClient();
  $client->setConfig([
    'apiKey' => '034e69d26f94c9f0ed455feb76806ff0-us17',
    'server' => 'us17',
  ]);
  $response = $client->ecommerce->addStoreCustomer($store_name, [
    "id" => (string)$user_id,
    "email_address" => $user_email,
    "first_name" => $first_name,
    "last_name" => $last_name,
    "opt_in_status" => true,
  ]);
//    	print_r($response);
//    	die();
//	}	
}

// add customer to mailchimp store
add_action( 'wp_ajax_mailchimp_add_store_customer', 'mailchimp_add_store_customer');
add_action( 'wp_ajax_nopriv_mailchimp_add_store_customer',  'mailchimp_add_store_customer');
function mailchimp_add_store_customer(){

$user_id = $_POST['user_id'];
$user    = get_userdata( $user_id );
  
$first_name = get_user_meta( $user->ID, 'first_name', true );
$last_name = get_user_meta( $user->ID, 'last_name', true );

//$user_id = $user->ID;
$user_name = $user->user_login;
$user_email = $user->user_email;
$store_name = "on_demand_classes";

require_once(ABSPATH . 'mailchimp-marketing-php/vendor/autoload.php');

$client = new MailchimpMarketing\ApiClient();
$client->setConfig([
  'apiKey' => '034e69d26f94c9f0ed455feb76806ff0-us17',
  'server' => 'us17',
]);

$response = $client->ecommerce->setStoreCustomer($store_name, $user_id, [
  "id" => $user_id,
  "email_address" => $user_email,
  "first_name" => $first_name,
"last_name" => $last_name,	
"opt_in_status" => true,
]);

echo $response->id;
//print_r($response);
die();

}


// add order in mailchimp
add_action( 'wp_ajax_orders_mailchimp', 'orders_mailchimp');
add_action( 'wp_ajax_nopriv_orders_mailchimp',  'orders_mailchimp');
function orders_mailchimp(){

  $transection_id = $_POST['transection_id'];
  //$transection_id = "23";
  $user_id 		= $_POST['user_id'];
  $order_total 	= $_POST['order_total'];
  $product_id 	= $_POST['product_id'];
  $campaign_id 	= $_POST['campaign_id'];
  $product_price 	= $_POST['product_price'];
  $discount_code 	= $_POST['discount_code'];



  require_once (ABSPATH . 'mailchimp-marketing-php/vendor/autoload.php');

  $client = new MailchimpMarketing\ApiClient();
  $client->setConfig([
      'apiKey' => '034e69d26f94c9f0ed455feb76806ff0-us17',
      'server' => 'us17',
  ]);

  $response2 = $client->ecommerce->addStoreOrder("on_demand_classes", [
      "id" => $transection_id,
      "customer" 	=> ["id" => $user_id],        
      "currency_code" => "USD",
      "order_total" => (float)$order_total,
      "campaign_id" => $campaign_id,
      "lines" => [
          [
              "id" => "001",
              "product_id" => $product_id,
              "product_variant_id" => "01",
              "quantity" => 1,
              "price" => (float)$product_price,
          ],
      ],
  ]);

  print_r($response2);
  unset($_SESSION['mc_cid']);
die();
}

// add new store in mailchimp
add_action( 'wp_ajax_store_mailchimp', 'store_mailchimp');
add_action( 'wp_ajax_nopriv_store_mailchimp',  'store_mailchimp');
function store_mailchimp(){

  require_once(ABSPATH . 'mailchimp-marketing-php/vendor/autoload.php');

  $client = new MailchimpMarketing\ApiClient();
  $client->setConfig([
      'apiKey' => '034e69d26f94c9f0ed455feb76806ff0-us17',
      'server' => 'us17',
  ]);

  $mailChimpData = array (
      'id' => 'store_20',
      'list_id' => '68d48f4e7e',
      'name' => 'rezaid-store',
      'platform' => 'WP',
      'domain' => 'http://slowrisepizza.test/',
      'is_syncing' => false,
      'email_address' => 'muhfaisal88@hotmail.com',
      'currency_code' => 'USD',
      'money_format' => '$',
      'primary_locale' => 'en',
      'timezone' => '',
      'phone' => '013245679',
      'address' =>
          array (
              'address1' => 'test',
              'address2' => 'test2',
              'city' => 'LHR',
              'province' => 'PUN',
              'province_code' => '13',
              'postal_code' => '121',
              'country' => 'PAK',
              'country_code' => '92',
              'longitude' => 0,
              'latitude' => 0,
          ),
  );


  $response = $client->ecommerce->addStore([
      "id" => "on_demand_classes",
      "list_id" => "68d48f4e7e",
      "name" => "On Demand Classes",
      "currency_code" => "USD",
  ]);
  print_r($response);

  die();
}


// add customer to mailchimp store
// logic moved to user_register hook
/*
add_action( 'wp_ajax_mailchimp_store_customer', 'mailchimp_store_customer');
add_action( 'wp_ajax_nopriv_mailchimp_store_customer',  'mailchimp_store_customer');
function mailchimp_store_customer(){

  require_once(ABSPATH . 'mailchimp-marketing-php/vendor/autoload.php');

  $client = new MailchimpMarketing\ApiClient();
  $client->setConfig([
      'apiKey' => 'f31eec9f413c816d59ef86c38e47c67a-us2',
      'server' => 'us2',
  ]);


  $response = $client->ecommerce->addStoreCustomer("example_store5", [
      "id" => "555444",
      "email_address" => "Everett66@hotmail.com",
      "opt_in_status" => true,
  ]);
  print_r($response);

  die();
}
*/

// add product to mailchimp store
add_action( 'wp_ajax_mailchimp_store_product', 'mailchimp_store_product');
add_action( 'wp_ajax_nopriv_mailchimp_store_product',  'mailchimp_store_product');
function mailchimp_store_product(){

  $product1_url = site_url("membership-account/membership-checkout/?level=1");
  $product2_url = site_url("membership-account/membership-checkout/?level=2");
  $product3_url = site_url("membership-account/membership-checkout/?level=3");

  require_once(ABSPATH . 'mailchimp-marketing-php/vendor/autoload.php');

  $client = new MailchimpMarketing\ApiClient();
  $client->setConfig([
      'apiKey' => '034e69d26f94c9f0ed455feb76806ff0-us17',
      'server' => 'us17',
  ]);


  $response1 = $client->ecommerce->addStoreProduct("on_demand_classes", [
      "id" => "1",
      "title" => "Beginner Pizza Classes 1 & 2",
      "variants" => [["id" => "01", "title" => "Beginner Pizza Classes 1 & 2"]],
      "url" => $product1_url
  ]);

  $response2 = $client->ecommerce->addStoreProduct("on_demand_classes", [
      "id" => "2",
      "title" => "Intermediate Pizza Class 1",
      "variants" => [["id" => "01", "title" => "Intermediate Pizza Class 1"]],
      "url" => $product2_url
  ]);

  $response3 = $client->ecommerce->addStoreProduct("on_demand_classes", [
      "id" => "3",
      "title" => "Advanced Pizza Class 1",
      "variants" => [["id" => "01", "title" => "Advanced Pizza Class 1 "]],
      "url" => $product3_url
  ]);


  print_r($response3);

  die();
}



// get mailchimp store list
add_action( 'wp_ajax_get_mailchimp_stores', 'get_mailchimp_stores');
add_action( 'wp_ajax_nopriv_get_mailchimp_stores',  'get_mailchimp_stores');
function get_mailchimp_stores(){


  require_once(ABSPATH . 'mailchimp-marketing-php/vendor/autoload.php');

  $client = new MailchimpMarketing\ApiClient();
  $client->setConfig([
      'apiKey' => '034e69d26f94c9f0ed455feb76806ff0-us17',
      'server' => 'us17',
  ]);

  $response = $client->ecommerce->stores();
  print_r($response);

  die();
}

// check if mailchimp campaign ID exists in URL if so then attach this id in confirmation page
if (isset($_GET['mc_cid'])){
  add_filter( 'pmpro_confirmation_url', 'example_callback', 10, 3 );
  function example_callback( $rurl, $user_id, $pmpro_level ) {
      $rurl = $rurl . "&mc_cid=" . $_GET['mc_cid'];
      return $rurl;
  }
}


/* ******** mailchimp ecommerce integration end ************* */

/***************************/

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


function giftcard_function() {

    if((isset($_POST["action"]) && $_POST["action"] == "save") && (isset($_POST["post_name"]) && $_POST["post_name"] == "giftcard"))
    {
      $final_value	=	$_REQUEST['final_value'];
      $level			=	$_REQUEST['level'];
      $level_name		=	$_REQUEST['level_name'];

      $gift_to_name	=	$_REQUEST['gift_to_name'];
      $gift_to_email	=	$_REQUEST['gift_to_email'];
      $gift_from_name	=	$_REQUEST['gift_from_name'];
      $gift_from_email=	$_REQUEST['gift_from_email'];
      $gift_message	=	$_REQUEST['gift_message'];

      $_SESSION['gift_card_data']['gift_to_name'] 	= $gift_to_name;
      $_SESSION['gift_card_data']['gift_to_email'] 	= $gift_to_email;
      $_SESSION['gift_card_data']['gift_from_name'] 	= $gift_from_name;
      $_SESSION['gift_card_data']['gift_from_email'] 	= $gift_from_email;
      $_SESSION['gift_card_data']['gift_message'] 	= $gift_message;
      $_SESSION['gift_card_data']['final_value'] 		= $final_value;
      $_SESSION['gift_card_data']['level'] 			= $level;
      $_SESSION['gift_card_data']['level_name'] 		= $level_name;

      if($final_value == '0' || $final_amount == '0.00'){

        $_SESSION['gift_card_data']['zero_amount'] 		= "Y";
        $_SESSION['gift_card_data']['payment_id'] 		= bin2hex(random_bytes(5));
      $_SESSION['gift_card_data']['invoice_number'] 	= bin2hex(random_bytes(8));

        wp_redirect( get_permalink( 3264 ) );
          die;

      }else{

        $_SESSION['gift_card_data']['zero_amount'] 	= "N";

        require ABSPATH.'vendor/autoload.php';

      $enableSandbox = false;

      $paypalConfig = [
          'client_id' => PAYPAL_CLIENT_ID,
          'client_secret' => PAYPAL_CLIENT_SECRET,
          'return_url' => esc_url( get_permalink( get_page_by_title( 'Response' ) ) ),
          'cancel_url' => esc_url( get_permalink( get_page_by_title( 'Response' ) ) )
      ];

      function getApiContext($clientId, $clientSecret, $enableSandbox = false)
      {
          $apiContext = new ApiContext(
              new OAuthTokenCredential($clientId, $clientSecret)
          );

          $apiContext->setConfig([
              'mode' => $enableSandbox ? 'sandbox' : 'live'
          ]);

          return $apiContext;
      }

      $apiContext = getApiContext($paypalConfig['client_id'], $paypalConfig['client_secret'], $enableSandbox);

      $payer = new Payer();
      $payer->setPaymentMethod('paypal');

      $currency = 'USD';
      $amountPayable = $final_value;
      $invoiceNumber = uniqid();

      $amount = new Amount();
      $amount->setCurrency($currency)
          ->setTotal($amountPayable);

      $transaction = new Transaction();
      $transaction->setAmount($amount)
          ->setDescription('Some description about the payment being made')
          ->setInvoiceNumber($invoiceNumber);

      $redirectUrls = new RedirectUrls();
      $redirectUrls->setReturnUrl($paypalConfig['return_url'])
          ->setCancelUrl($paypalConfig['cancel_url']);

      $payment = new Payment();
      $payment->setIntent('sale')
          ->setPayer($payer)
          ->setTransactions([$transaction])
          ->setRedirectUrls($redirectUrls);

      try {
          $payment->create($apiContext);
      } catch (Exception $e) {
          //echo $e->getData();
          throw new Exception('Unable to create link for payment');
      }
      
      $_SESSION['gift_card_data']['payment_id'] 		= $payment->id;
      $_SESSION['gift_card_data']['invoice_number'] 	= $payment->transactions[0]->invoice_number;

      header('location:' . $payment->getApprovalLink());
      exit(1);
      }    
    }    
}    
add_action('init', 'giftcard_function');

////////////////

function create_posttype_gift_card() {
register_post_type( 'giftcard',
  // CPT Options
  array(
    'labels' => array(
      'name' => __( 'Gift Cards' ),
      'singular_name' => __( 'Gift Card' )
    ),
    'public' => true,
    'has_archive' => true,
    'rewrite' => array('slug' => 'gift_card'),
    'show_in_rest' => true,     )
);
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype_gift_card' );
/*
* Creating a function to create our CPT
*/
function custom_post_type_gift_card() {
// Set UI labels for Custom Post Type
$labels = array(
  'name'                => _x( 'Gift Cards', 'Post Type General Name', 'SlowRisePizza' ),
  'singular_name'       => _x( 'Gift Card', 'Post Type Singular Name', 'SlowRisePizza' ),
  'menu_name'           => __( 'Gift Cards', 'SlowRisePizza' ),
  'parent_item_colon'   => __( 'Parent Gift Card', 'SlowRisePizza' ),
  'all_items'           => __( 'All Gift Cards', 'SlowRisePizza' ),
  'view_item'           => __( 'View Gift Card', 'SlowRisePizza' ),
  'add_new_item'        => __( 'Add New Gift Card', 'SlowRisePizza' ),
  'add_new'             => __( 'Add New Gift Cards', 'SlowRisePizza' ),
  'edit_item'           => __( 'Edit Gift Cards', 'SlowRisePizza' ),
  'update_item'         => __( 'Update Gift Cards', 'SlowRisePizza' ),
  'search_items'        => __( 'Search Gift Cards', 'SlowRisePizza' ),
  'not_found'           => __( 'Not Found', 'SlowRisePizza' ),
  'not_found_in_trash'  => __( 'Not found in Trash', 'SlowRisePizza' ),
  );
   
// Set other options for Custom Post Type
   
$args = array(
  'label'               => __( 'Gift Card', 'SlowRisePizza' ),
  'description'         => __( 'Gift Cards news and reviews', 'SlowRisePizza' ),
  'labels'              => $labels,
  'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
  'taxonomies'          => array( 'genres' ),
  'hierarchical'        => false,
  'public'              => true,
  'show_ui'             => true,
  'show_in_menu'        => true,
  'show_in_nav_menus'   => true,
  'show_in_admin_bar'   => true,
  'menu_position'       => 5,
  'can_export'          => true,
  'has_archive'         => true,
  'exclude_from_search' => false,
  'publicly_queryable'  => true,
  'capability_type'     => 'post',
  'show_in_rest' => true, 
  );
   
register_post_type( 'giftcard', $args );

}

add_action( 'init', 'custom_post_type_gift_card', 0 );

/* **************** gift card email template sub page start *********** */

add_action('admin_menu', 'add_email_template_cpt_submenu_example');

//admin_menu callback function

function add_email_template_cpt_submenu_example(){

  add_submenu_page(
      'edit.php?post_type=giftcard', //$parent_slug
      'Customize Email Template',  //$page_title
      'Email Templates',        //$menu_title
      'manage_options',           //$capability
      'giftcard_email_templates',//$menu_slug
      'render_giftcard_email_templates'//$function
  );

}

//add_submenu_page callback function
function render_giftcard_email_templates() {

  require 'gift-card-email-templates.php';

      wp_enqueue_style('bootstrap-css' , get_site_url() . '/css/bootstrap.css' );
      wp_enqueue_script('bootstrap-js', get_site_url() . '/js/bootstrap.min.js' ,false, NULL, true );

}

// update email templates for gift card module
add_action( 'wp_ajax_update_gift_card_email_template', 'update_gift_card_email_template');
add_action( 'wp_ajax_nopriv_update_gift_card_email_template',  'update_gift_card_email_template');
function update_gift_card_email_template(){
  $subject = $_POST['subject'];
  $body = $_POST['body'];
  $template = $_POST['template'];

  $option = array($subject,$body);

  $res = update_option($template,$option);
  return $res;

  die();
}

// sending email(s) to test gift card templates
add_action( 'wp_ajax_send_test_gift_card_email', 'send_test_gift_card_email');
add_action( 'wp_ajax_nopriv_send_test_gift_card_email',  'send_test_gift_card_email');
function send_test_gift_card_email(){

  $to = $_POST['to'];
  $subject = $_POST['subject'];
  $body = $_POST['body'];

  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= 'From: <classes@slowrisepizza.com>' . "\r\n";

  $res = mail($to,$subject,$body,$headers);
  return $res;

  die();
}

/* **************** gift card email template sub page end *********** */


//add columns to the edit movies page

add_filter( 'manage_giftcard_posts_columns', 'set_custom_edit_giftcard_columns' );
function set_custom_edit_giftcard_columns($columns) {
  unset( $columns['author'] );
  unset( $columns['date'] );
  unset( $columns['comments'] );
  $columns['gift_to_name'] = __( 'To Name', 'SlowRisePizza' );
  $columns['gift_to_email'] = __( 'To Email', 'SlowRisePizza' );
  $columns['gift_from_name'] = __( 'From Name', 'SlowRisePizza' );
  $columns['gift_from_email'] = __( 'From Email', 'SlowRisePizza' );
  $columns['invoice_number'] = __( 'Invoice Number', 'SlowRisePizza' );

  return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_giftcard_posts_custom_column' , 'custom_giftcard_column', 10, 2 );
function custom_giftcard_column( $column, $post_id ) {
  switch ( $column ) {

      case 'discount_code' :
         echo get_post_meta( $post_id , 'discount_code' , true );
          break;

      case 'gift_to_name' :
          echo get_post_meta( $post_id , 'gift_to_name' , true ); 
          break;

      case 'gift_to_email' :
          echo get_post_meta( $post_id , 'gift_to_email' , true ); 
          break;

      case 'gift_from_name' :
          echo get_post_meta( $post_id , 'gift_from_name' , true ); 
          break;

      case 'gift_from_email' :
          echo get_post_meta( $post_id , 'gift_from_email' , true ); 
          break;

      case 'invoice_number' :
          echo get_post_meta( $post_id , 'invoice_number' , true ); 
          break;


  }
}

function wporg_add_giftcard_custom_box()
{
  $screens = ['giftcard'];
  foreach ($screens as $screen) {
      add_meta_box(
          'user_box_id',           // Unique ID
          'Gift Card',  // Box title
          'gift_discount_code',  // Content callback, must be of type callable
          $screen                   // Post type
      );
  }
}
add_action('add_meta_boxes', 'wporg_add_giftcard_custom_box');

function gift_discount_code($post)
{
  
  $discount_code      = get_post_meta($post->ID, 'discount_code', true);
  $gift_to_name       = get_post_meta($post->ID, 'gift_to_name', true);
  $gift_to_email      = get_post_meta($post->ID, 'gift_to_email', true);
  $gift_from_name     = get_post_meta($post->ID, 'gift_from_name', true);
  $gift_from_email    = get_post_meta($post->ID, 'gift_from_email', true);
  $gift_message       = get_post_meta($post->ID, 'gift_message', true);
  $final_amount       = get_post_meta($post->ID, 'final_amount', true);
  $payment_status     = get_post_meta($post->ID, 'payment_status', true);
  $level_id           = get_post_meta($post->ID, 'level_id', true);
  $payment_id         = get_post_meta($post->ID, 'payment_id', true);
  $invoice_number     = get_post_meta($post->ID, 'invoice_number', true);
  $added_date         = get_post_meta($post->ID, 'added_date', true);
  ?>
<div class="wrap">
<div style="margin-top: 20px">
    <label for="gift_to_name"><b>To Name: </b></label><br>
    <input type="text" name="gift_to_name" value="<?php echo $gift_to_name; ?>" size="50">
</div>
<div style="margin-top: 20px">
    <label for="gift_to_email"><b>To Email: </b></label><br>
    <input type="text" name="gift_to_email" value="<?php echo $gift_to_email; ?>" size="50">
</div>
<div style="margin-top: 20px">
    <label for="gift_from_name"><b>From Name: </b></label><br>
    <input type="text" name="gift_from_name" value="<?php echo $gift_from_name; ?>" size="50">
</div>
<div style="margin-top: 20px">
    <label for="gift_from_email"><b>From Email: </b></label><br>
    <input type="text" name="gift_from_email" value="<?php echo $gift_from_email; ?>" size="50">
</div>
<div style="margin-top: 20px">
    <label for="gift_message"><b>Gift Message: </b></label><br>
    <textarea name="gift_message" rows="5" cols="50"><?php echo $gift_message; ?></textarea>
</div>
<div style="margin-top: 20px">
    <label for="final_amount"><b>Final Amount: </b></label><br>
    <input type="text" name="final_amount" value="<?php echo $final_amount; ?>" size="50">
</div>
<div style="margin-top: 20px">
    <label for="payment_status"><b>Payment Status: </b></label><br>
    <input type="text" name="payment_status" value="<?php echo $payment_status; ?>" size="50">
</div>
<div style="margin-top: 20px">
    <label for="level_id"><b>Level ID: </b></label><br>
    <input type="text" name="level_id" value="<?php echo $level_id; ?>" size="50">
</div>
<div style="margin-top: 20px">
    <label for="payment_id"><b>Payment ID: </b></label><br>
    <input type="text" name="payment_id" value="<?php echo $payment_id; ?>" size="50">
</div>
<div style="margin-top: 20px">
    <label for="invoice_number"><b>Invoice Number: </b></label><br>
    <input type="text" name="invoice_number" value="<?php echo $invoice_number; ?>" size="50">
</div>
</div>  

  <?php
}

function gift_card_save_postdata($post_id)
{
  if (array_key_exists('discount_code', $_POST)) {
      update_post_meta($post_id, 'discount_code', $_POST['discount_code']);
  }

  if (array_key_exists('gift_to_name', $_POST)) {
      update_post_meta($post_id, 'gift_to_name', $_POST['gift_to_name']);
  }
  if (array_key_exists('gift_to_email', $_POST)) {
      update_post_meta($post_id, 'gift_to_email', $_POST['gift_to_email']);
  }
  if (array_key_exists('gift_from_name', $_POST)) {
      update_post_meta($post_id, 'gift_from_name', $_POST['gift_from_name']);
  }
  if (array_key_exists('gift_from_email', $_POST)) {
      update_post_meta($post_id, 'gift_from_email', $_POST['gift_from_email']);
  }
  if (array_key_exists('gift_message', $_POST)) {
      update_post_meta($post_id, 'gift_message', $_POST['gift_message']);
  }
  if (array_key_exists('final_amount', $_POST)) {
      update_post_meta($post_id, 'final_amount', $_POST['final_amount']);
  }
  if (array_key_exists('payment_status', $_POST)) {
      update_post_meta($post_id, 'payment_status', $_POST['payment_status']);
  }
  if (array_key_exists('level_id', $_POST)) {
      update_post_meta($post_id, 'level_id', $_POST['level_id']);
  }
  if (array_key_exists('payment_id', $_POST)) {
      update_post_meta($post_id, 'payment_id', $_POST['payment_id']);
  }
  if (array_key_exists('invoice_number', $_POST)) {
      update_post_meta($post_id, 'invoice_number', $_POST['invoice_number']);
  }
  if (array_key_exists('invoice_number', $_POST)) {
      update_post_meta($post_id, 'invoice_number', $_POST['invoice_number']);
  }

}
add_action('save_post', 'gift_card_save_postdata');



/*=========================================================================================
 Rewriting classes page url replacing query string "?tab=giftaclass" with "/giftaclass" 
===========================================================================================*/

add_action('init', 'my_custom_rewrite_function');
function my_custom_rewrite_function() {
  
  add_rewrite_rule('^classes/([^/]*)/?','index.php?page_id=4502&tab=$matches[1]&variety=$matches[2]','top');

  flush_rewrite_rules(); // This will make sure that the rewrite rules are added
}

/*============================================================================================
 END Rewriting classes page url replacing query string "?tab=giftaclass" with "/giftaclass" 
==============================================================================================*/


/*=============================================================
Ajax calls for category page ondemand and gift classes
==============================================================*/

add_action( 'wp_ajax_getProductsData', 'getProductsData');
add_action( 'wp_ajax_nopriv_getProductsData',  'getProductsData');

function getProductsData(){

$cat_slug = $_POST['catSlug'];

// specific category selected from dropdown
if($cat_slug){
  
  $query = new WC_Product_Query( array(
    'limit' => -1,
    'orderby' => 'date',
    'order' => 'ASC',
    'category'  => array( $cat_slug ),
          'status' => 'publish'

  ));
  
}

// all classes selected from dropdown
else{

  $query = new WC_Product_Query( array(
    'limit' => -1,
    'orderby' => 'date',
    'order' => 'ASC',
          'status' => 'publish'

  ));
}

// get products	
$products = $query->get_products();

if($products){
  $x = 0;
  foreach($products as $key => $product){
    
    $product_id 	= 	$product->get_id();
    $product_name   =   $product->get_name();
    $product_price  =   $product->get_price_html();
    $product_url    =   get_permalink( $product->get_id() );
    $categories 			= $product->get_categories();
    
    if(!$categories){
      continue;	
    }
    
    /*
    
    $current_user_id = get_current_user_id();
            
    // get current user's active subscription(s) 
    $user_subscriptions = wcs_get_subscriptions(['customer_id' => $current_user_id, 'subscription_status'    => array( 'active' )]);
    
    if($user_subscriptions){
      
      // each user may have multiple subscriptions so loop through it
      foreach($user_subscriptions as $subscription_id => $single_subscription ){
        
        
        // check is it gifted subscription or regular
        $is_gifted_subscription = is_gifted_subscription($single_subscription);
        
        // gifted, then skip itteration
        if($is_gifted_subscription){
          
          // as current user has purchased subscription as a gift for someone so access goes to recipient
          continue;
          
          //echo "Current user has a recipient user";
          
        }else{

          //echo "Current user has own subscription";
          // process further
          foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
        
            $subscribed_product_id = $product_subscription->get_product_id();
            //$subscribed_product_name = $product_subscription->get_name();
            
            if($product_id == $subscribed_product_id){
              
              // get the value from product custom field which had been created using acf
              $video_page_url = get_field('on_demand_classes', $subscribed_product_id);
              
              // reset product url as user has already subscribed to this product												
              $product_url = $video_page_url;
              
            }	
          }
        }
        
      }		
    }
    
    // may be current user is a recipient and have gifted subscription
    else{
      
      // get all subscriptions
      $all_subscriptions = wcs_get_subscriptions(['subscriptions_per_page' => -1]);
      
      if($all_subscriptions){
        foreach($all_subscriptions as $subscription_id => $single_subscription ){
          
          // check is it gifted subscription
          $is_gifted_subscription = is_gifted_subscription($single_subscription);
        
          // gifted, then get the recipient data
          if($is_gifted_subscription){
            $recipient_user = get_recipient_user( $single_subscription );
          }
          
          // check if current and recipient user are same
          if($recipient_user == $current_user_id){
            
            //echo "Current user is a recipient user";
            
            // process further
            foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
        
              $subscribed_product_id = $product_subscription->get_product_id();
              //$subscribed_product_name = $product_subscription->get_name();
              
              if($product_id == $subscribed_product_id){
                
                // get the value from product custom field which had been created using acf
                $video_page_url = get_field('on_demand_classes', $subscribed_product_id);
                
                // reset product url as user has already subscribed to this product												
                $product_url = $video_page_url;
                
              }	
            }
          }
        }
      }

    }
  
    */
  
    $productsData[$x++] = array(
      'product_id'=>$product_id,
      'product_name'=>$product_name,
      'product_price'=>$product_price,
      'product_url'=>$product_url,
    );	
  }	
}

echo json_encode($productsData);
die();

}

/*=============================================================
 End Ajax calls for category page ondemand and gift classes 
==============================================================*/


/*=============================================================
 Woocommerce custom fields for Recipient   
==============================================================*/

/*

// Adds custom field in single product page
add_action('woocommerce_before_add_to_cart_button','wdm_add_custom_fields');
function wdm_add_custom_fields(){

  global $product;
  ob_start();

  ?>
      <div class="wdm-custom-fields">
          <label>Recipient Name</label>
    <input type="text" name="recipient_name" value="">
          <label>Recipient Message</label>
    <input type="text" name="recipient_message" value="">
      </div>
      <div class="clear"></div>

  <?php

  $content = ob_get_contents();
  ob_end_flush();

  return $content;
}

// Add custom fields data to Cart
add_filter('woocommerce_add_cart_item_data','wdm_add_item_data',10,3);
function wdm_add_item_data($cart_item_data, $product_id, $variation_id){

  if(isset($_REQUEST['recipient_name']))
  {
      $cart_item_data['recipient_name'] = sanitize_text_field($_REQUEST['recipient_name']);
  }

if(isset($_REQUEST['recipient_message']))
  {
      $cart_item_data['recipient_message'] = sanitize_text_field($_REQUEST['recipient_message']);
  }

  return $cart_item_data;
}

// Display custom fields information as Meta on Cart page
add_filter('woocommerce_get_item_data','wdm_add_item_meta',10,2);
function wdm_add_item_meta($item_data, $cart_item){

  if(array_key_exists('recipient_name', $cart_item))
  {
      $recipient_name = $cart_item['recipient_name'];

      $item_data[] = array(
          'key'   => 'Recipient Name',
          'value' => $recipient_name
      );
  }

if(array_key_exists('recipient_message', $cart_item))
  {
      $recipient_message = $cart_item['recipient_message'];

      $item_data[] = array(
          'key'   => 'Recipient Message',
          'value' => $recipient_message
      );
  }

  return $item_data;
}


*/

/**
* Add a custom field (in an order) to the emails
*/

/* 
add_filter( 'woocommerce_email_order_meta_fields', 'custom_woocommerce_email_order_meta_fields', 10, 3 );

function custom_woocommerce_email_order_meta_fields( $fields, $sent_to_admin, $order ) {

foreach ( WC()->cart->cart_contents as $key => $item ) {
  
  if ( isset( $item['wcsg_gift_recipients_email'] ) ) {
    
    $recipient_email = $item['wcsg_gift_recipients_email'];
    $fields['recipient_email'] = array(
      'label' => __( 'Recipient Email' ),
      'value' => $recipient_email,
    );
  
    if(isset($item['wcsg_gift_recipients_name'])){
      $recipient_name = $item['wcsg_gift_recipients_name'];
      $fields['recipient_name'] = array(
        'label' => __( 'Recipient Name' ),
        'value' => $recipient_name,
      );
    }
    
    if(isset($item['wcsg_gift_recipients_message'])){
      $recipient_message = $item['wcsg_gift_recipients_message'];
      $fields['recipient_message'] = array(
        'label' => __( 'Recipient Message' ),
        'value' => $recipient_message,
      );
    }
  }
}

  return $fields;
}
*/


/*=============================================================
 End Woocommerce custom fields for Recipient   
==============================================================*/


// customize new order email template and adding new custom fields
add_action( 'woocommerce_email_order_meta', 'misha_add_email_order_meta', 10, 3 ); 
function misha_add_email_order_meta( $order_obj, $sent_to_admin, $plain_text ){

foreach ( WC()->cart->cart_contents as $key => $item ) {
  
  if ( isset( $item['wcsg_gift_recipients_email'] ) ) {
    
    $recipient_email = $item['wcsg_gift_recipients_email'];
    
    $recipient_name = $item['wcsg_gift_recipients_name'];	
    
    $recipient_message = $item['wcsg_gift_recipients_message'];

  }
}

// ok, we will add the separate version for plaintext emails

if ( isset( $item['wcsg_gift_recipients_email'] ) ) {
  if ( $plain_text === false ) {
 
    // you shouldn't have to worry about inline styles, WooCommerce adds them itself depending on the theme you use
    echo '<h2>Recipient Information</h2>
    <ul>
    <li><strong>Recipient Email: </strong> ' . $recipient_email . '</li>
    <li><strong>Recipient Name: </strong> ' . $recipient_name . '</li>
    <li><strong>Recipient Message: </strong> ' . $recipient_message . '</li>
    </ul>';
    
  } else {
 
    echo "GIFT INFORMATION\n
    Recipient Email: $recipient_email
    Recipient Name: $recipient_name
    Recipient Message: $recipient_message";	
  }
}
}


/*=============================================================
 Woocommerce subscription customization   
==============================================================*/

// Restrict video pages for non-login users

if(!is_user_logged_in()){			
add_action( 'template_redirect', 'restrict_video_page' );
}

function restrict_video_page(){

global $post;
$terms = wp_get_post_terms( $post->ID, 'ondemand');
if($terms){
  wp_die('Warning, You do not have sufficient permissions to access this page.', 'Error',  array( 'response' => 500, 'link_url' => site_url(), 'link_text' => 'Go back' ));	
}

}



if(is_user_logged_in() && !current_user_can('administrator')){
add_action( 'template_redirect', 'video_pages_accesss_wrt_user_subsccription' );
}

function video_pages_accesss_wrt_user_subsccription(){

global $post;

// check either current page is belong to videos pages by getting custom taxonomy term, we only have to restrict video pages
$terms = wp_get_post_terms( $post->ID, 'ondemand');

if($terms[0]->slug){
  
  $current_user_id = get_current_user_id();
  
  // Reference for subscription method used below: https://github.com/wp-premium/woocommerce-subscriptions/blob/master/wcs-functions.php#L425-L438
  // get current user's active subscription(s) 
  $user_subscriptions = wcs_get_subscriptions(['customer_id' => $current_user_id, 'subscription_status'    => array( 'active' )]);
  
  if($user_subscriptions){
  
    // each user may have multiple subscriptions so loop through it
    foreach($user_subscriptions as $subscription_id => $single_subscription ){
    
      // check is it gifted subscription or regular
      $is_gifted_subscription = is_gifted_subscription($single_subscription);
    
      // gifted, then get the recipient data
      if($is_gifted_subscription){
        
        // as current user has purchased subscription as a gift for someone so access goes to recipient
        continue;
        $recipient_user = get_recipient_user( $single_subscription );
        
        /*if($recipient_user){
          wp_die('Warning, You do not have sufficient permissions to access this page.', 'Error',  array( 'response' => 500, 'link_url' => site_url(), 'link_text' => 'Go back' ));
        }*/
        
        //echo "Current user has a recipient user";
        
        // process further to allow access to video page
        /*foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
      
          $subscribed_product_id = $product_subscription->get_product_id();
          $subscribed_product_name = $product_subscription->get_name();
          
          // get the value from product custom field which had been created using acf
          // https://staging-slowrisepizza.temp513.kinsta.cloud/video-advanced-pizza-class-1/
          $access_url = get_field('on_demand_classes', $subscribed_product_id);
          $trimmied_access_url = parse_url($access_url, PHP_URL_PATH);
          
          // video-advanced-pizza-class-1
          $access_url_segments = explode('/', $trimmied_access_url);
          
          
          // video-advanced-pizza-class-1
          $current_url_segments = trim($_SERVER['REQUEST_URI'], '/\\');
          
          if($access_url_segments[1] != $current_url_segments){
            wp_die( 'Error message', 'Error', 500 );
          }
          
        }*/
      
      }else{
        
        //echo "Current user has own subscription";
        
        // process further to allow access to video page
        foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
      
          $subscribed_product_id = $product_subscription->get_product_id();
          $subscribed_product_name = $product_subscription->get_name();
          
          // get the value from product custom field which had been created using acf
          $access_url = get_field('on_demand_classes', $subscribed_product_id);
          
          $parsed_access_url = parse_url($access_url, PHP_URL_PATH);
          
          // video-advanced-pizza-class-1
          $access_url_segments = explode('/', $parsed_access_url);
          
          // user may have multiple subscriptions so it means multiple links access
          // store urls in array to manage access in next step
          $trimmied_access_url[$item_id] = $access_url_segments[1];
          
        }
      }	
    }	
    
    // video-advanced-pizza-class-1
    $current_url_segments = trim($_SERVER['REQUEST_URI'], '/\\');
    
    // check if current url match with stored urls in array above
    /*if (!in_array($current_url_segments, $trimmied_access_url)){
      wp_die('Warning, You do not have sufficient permissions to access this page.', 'Error',  array( 'response' => 500, 'link_url' => site_url(), 'link_text' => 'Go back' ));
    }*/
    
  }

  // may be current user is a recipient and have gifted subscription
  //else{
    
    // get all subscriptions
    $all_subscriptions = wcs_get_subscriptions(['subscriptions_per_page' => -1, 'subscription_status' => array( 'active' )]);
    
    if($all_subscriptions){
      
      foreach($all_subscriptions as $subscription_id => $single_subscription ){
      
        // check is it gifted subscription
        $is_gifted_subscription = is_gifted_subscription($single_subscription);
        
        // gifted, then get the recipient data
        if($is_gifted_subscription){
          $recipient_user = get_recipient_user( $single_subscription );
        }

        // check if current and recipient user are same
        if($recipient_user == $current_user_id){
          
          //echo "Current user is a recipient user";
          
          // process further to allow access to video page
          foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
      
            $subscribed_product_id = $product_subscription->get_product_id();
            $subscribed_product_name = $product_subscription->get_name();
            
            // get the value from product custom field which had been created using acf
            $access_url = get_field('on_demand_classes', $subscribed_product_id);
            
            $parsed_access_url = parse_url($access_url, PHP_URL_PATH);
            
            //var_dump($parsed_access_url);
            
            // video-advanced-pizza-class-1
            $access_url_segments = explode('/', $parsed_access_url);
            
            // user may have multiple subscriptions so it means multiple links access
            // store urls in array to manage access in next step
            $trimmied_access_url[$item_id] = $access_url_segments[1];
            
          }
        }	
      }
      
      // video-advanced-pizza-class-1
      $current_url_segments = trim($_SERVER['REQUEST_URI'], '/\\');
      
      // check if current url match with stored urls in array above
      if (!in_array($current_url_segments, $trimmied_access_url)){
        wp_die('Warning, You do not have sufficient permissions to access this page.', 'Error',  array( 'response' => 500, 'link_url' => site_url(), 'link_text' => 'Go back' ));
      }	
    }
  //}	
}
}



/**
* Checks whether a subscription is a gifted subscription.
*/
function is_gifted_subscription( $subscription ) {
$is_gifted_subscription = false;

if ( ! $subscription instanceof WC_Subscription ) {
  $subscription = wcs_get_subscription( $subscription );
}

if ( wcs_is_subscription( $subscription ) ) {
  $recipient_user_id      = get_recipient_user( $subscription );
  $is_gifted_subscription = ! empty( $recipient_user_id ) && is_numeric( $recipient_user_id );
}

return $is_gifted_subscription;
}


/**
* Retrieve the recipient user ID from a subscription.
*/
function get_recipient_user( $subscription ) {
$recipient_user_id = '';

if ( method_exists( $subscription, 'get_meta' ) ) {
  if ( $subscription->meta_exists( '_recipient_user' ) ) {
    $recipient_user_id = $subscription->get_meta( '_recipient_user' );
  }
} else { // WC < 3.0.
  $recipient_user_id = $subscription->recipient_user;
}

return $recipient_user_id;
}


/*=============================================================
 End Woocommerce subscription customization   
==============================================================*/


/**
* Subscription checks for product detail page.
* If user already has subscription to the current product then restrict user for gift only 
*/

add_action( 'woocommerce_single_product_summary', 'produt_page_restrict_user_to_gift_only', 30 );

function produt_page_restrict_user_to_gift_only() {


if ( ! is_user_logged_in() )
  return;
  
//$current_user = wp_get_current_user();	

global $product;
$product_id = $product->get_id();

$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;

// get current user's active subscription(s) 
$user_subscriptions = wcs_get_subscriptions(['customer_id' => $current_user_id, 'subscription_status'    => array( 'active' )]);

if($user_subscriptions){
  
  // User may have multiple subscriptions so loop through it
  foreach($user_subscriptions as $subscription_id => $single_subscription ){
    
    
    // check is it gifted subscription or regular
    $is_gifted_subscription = is_gifted_subscription($single_subscription);
    
    // gifted, then skip itteration
    if($is_gifted_subscription){
      
      // as current user has purchased subscription as a gift for someone so access goes to recipient
      continue;
      
      //echo "Current user has a recipient user";
      
    }else{

      //echo "Current user has own subscription";
      // process further
      foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
    
        $subscribed_product_id = $product_subscription->get_product_id();
        //$subscribed_product_name = $product_subscription->get_name();
        
        if($product_id == $subscribed_product_id){
          $message = "";	
          // get the value from product custom field which had been created using acf
          $video_page_url = get_field('on_demand_classes', $subscribed_product_id);
          
          // reset product url as user has already subscribed to this product												
          $product_url = $video_page_url;

          ?>
          <script>
            jQuery( document ).ready(function(){
              jQuery(".single_add_to_cart_button").prop('disabled', true);
              setTimeout(function(){ 
                console.log('called-1');
                if(!jQuery('#gifting_0_option').is(":checked"))
                jQuery('#gifting_0_option').trigger('click');
            
                document.getElementById('gifting_0_option').disabled = true;
                jQuery('.recipient_email').prop('required',true);
                jQuery(".single_add_to_cart_button").prop('disabled', false);
              }, 4000);
            });
          </script>
          <?php

          /*wc_enqueue_js("
          
            jQuery('#gifting_0_option').trigger('click');
            document.getElementById('gifting_0_option').disabled = true;
            jQuery('.recipient_email').prop('required',true);
            jQuery('.wcsg_add_recipient_fields ').show();
                
          ");*/

          $message = '<div class="user-bought">Hey ' . $current_user->first_name . ', you\'ve purchased this in the past. Buy again?</div>';
           
          
        }	
      }
    }
  }	
  echo $message;	
}

// may be current user is a recipient and have gifted subscription
else{
  
  // get all subscriptions
  $all_subscriptions = wcs_get_subscriptions(['subscriptions_per_page' => -1, 'subscription_status' => array( 'active' )]);
  
  if($all_subscriptions){
    foreach($all_subscriptions as $subscription_id => $single_subscription ){
      
      // check is it gifted subscription
      $is_gifted_subscription = is_gifted_subscription($single_subscription);
    
      // gifted, then get the recipient data
      if($is_gifted_subscription){
        $recipient_user = get_recipient_user( $single_subscription );
      }
      
      // check if current and recipient user are same
      if($recipient_user == $current_user_id){
      
        //echo "Current user is a recipient user";
        
        // process further
        foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
    
          $subscribed_product_id = $product_subscription->get_product_id();
          $subscribed_product_name = $product_subscription->get_name();
          
          if($product_id == $subscribed_product_id){
            
            // get the value from product custom field which had been created using acf
            $video_page_url = get_field('on_demand_classes', $subscribed_product_id);
            
            // reset product url as user has already subscribed to this product												
            $product_url = $video_page_url;
            $message = "";
            
              ?>
              <script>
              
                jQuery( document ).ready(function() {
                  jQuery(".single_add_to_cart_button").prop('disabled', true);
                  setTimeout(function(){ 
                    console.log('called');
                    if(!jQuery('#gifting_0_option').is(":checked"))
                    jQuery('#gifting_0_option').trigger('click');
                
                    document.getElementById('gifting_0_option').disabled = true;
                    jQuery('.recipient_email').prop('required',true);
                    jQuery(".single_add_to_cart_button").prop('disabled', false);
                  }, 4000);
                });
                
              </script>
              <?php
            
              /*wc_enqueue_js("
              
                jQuery('#gifting_0_option').trigger('click');
                document.getElementById('gifting_0_option').disabled = true;
                jQuery('.recipient_email').prop('required',true);
                jQuery('.wcsg_add_recipient_fields ').show();
                
              ");*/
            

            $message = '<div class="user-bought">Hey ' . $current_user->first_name . ', you\'ve purchased this in the past. Buy again?</div>';
            
            
          }	
        }	
      }
    }
    echo $message;
  }
}
}


/**
* Subscription checks for cart and checkout page.
* If user already has subscription to the current product then restrict user for gift only 
*/

// due to changing cart items key we have used ajax method instead of wp_head hook to gain a delay in process during cart keys changing.
// Method calls from footer.
//add_action( 'wp_head', 'cart_page_restrict_user_to_gift_only' );

add_action( 'wp_ajax_cart_page_restrict_user_to_gift_only', 'cart_page_restrict_user_to_gift_only');
add_action( 'wp_ajax_nopriv_cart_page_restrict_user_to_gift_only',  'cart_page_restrict_user_to_gift_only');


function cart_page_restrict_user_to_gift_only() {
  
if ( ! is_user_logged_in() ){
  
  //return;
  die();
}

$productsData = array();
$counter = 	0;
foreach( WC()->cart->get_cart() as $nonce_key => $cart_item ) {
  
  $product_id = $cart_item['product_id'];
  
  $current_user = wp_get_current_user();
  $current_user_id = $current_user->ID;
  
  // get current user's active subscription(s) 
  $user_subscriptions = wcs_get_subscriptions(['customer_id' => $current_user_id, 'subscription_status'    => array( 'active' )]);
  if($user_subscriptions){
    
    // User may have multiple subscriptions so loop through it
    foreach($user_subscriptions as $subscription_id => $single_subscription ){
      
      
      // check is it gifted subscription or regular
      $is_gifted_subscription = is_gifted_subscription($single_subscription);
      
      // gifted, then skip itteration
      if($is_gifted_subscription){
        
        // as current user has purchased subscription as a gift for someone so access goes to recipient
        continue;
        
        //echo "Current user has a recipient user";
        
      }else{

        //echo "Current user has own subscription";
        // process further
        foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
      
          $subscribed_product_id = $product_subscription->get_product_id();
          //$subscribed_product_name = $product_subscription->get_name();
          
          if($product_id == $subscribed_product_id){
            
            // get the value from product custom field which had been created using acf
            $video_page_url = get_field('on_demand_classes', $subscribed_product_id);
            
            // reset product url as user has already subscribed to this product												
            $product_url = $video_page_url;

            $productsData[$counter] = array(
              'product_id'=>$product_id,
              'product_key'=>$nonce_key,
            );
            $counter++;
            /*wc_enqueue_js("
      
                var unique_key = '".$nonce_key."';
                //alert('testz');
                jQuery( document ).ready(function() {
                  //jQuery( '#gifting_".$nonce_key."_option' ).addClass( 'wcsg_needs_update' );
                  jQuery('.woocommerce_subscription_gifting_checkbox').prop('disabled', true);
                  setTimeout(function(){
                  jQuery('.woocommerce_subscription_gifting_checkbox').prop('disabled', false);
                  
                  if(!jQuery('#gifting_".$nonce_key."_option').is(':checked'))
                  jQuery('#gifting_".$nonce_key."_option').trigger('click');
                
                  document.getElementById('gifting_".$nonce_key."_option').disabled = true;
                  jQuery('#gifting_".$nonce_key."_option').addClass('no-active');
                  jQuery('#recipient_email\\[".$nonce_key."\\]').prop('required',true);
                  jQuery( 'body' ).trigger( 'update_checkout' );
                  }, 10000);
                  
                });
                
            ");*/

            /*
            ?>
            <script>
            
              var unique_key = '<?php echo $nonce_key ?>';
              
              jQuery( document ).ready(function() {
                jQuery(".woocommerce_subscription_gifting_checkbox").prop('disabled', true);
                setTimeout(function(){
                jQuery(".woocommerce_subscription_gifting_checkbox").prop('disabled', false);
                
                if(!jQuery('#gifting_'+unique_key+'_option').is(":checked"))
                jQuery('#gifting_'+unique_key+'_option').trigger('click');
              
                document.getElementById('gifting_'+unique_key+'_option').disabled = true;
                jQuery('#recipient_email\\['+unique_key+'\\]').prop('required',true);
                //console.log(jQuery("#recipient_email\\["+unique_key+"\\]").val());
              
                }, 4000);
              });
              
            </script>
            <?php
            */
          }	
        }
      }
    }	
  }
  
  // may be current user is a recipient and have gifted subscription
  else{
    
    // get all subscriptions
    $all_subscriptions = wcs_get_subscriptions(['subscriptions_per_page' => -1, 'subscription_status' => array( 'active' )]);
    
    if($all_subscriptions){
      foreach($all_subscriptions as $subscription_id => $single_subscription ){
        
        // check is it gifted subscription
        $is_gifted_subscription = is_gifted_subscription($single_subscription);
      
        // gifted, then get the recipient data
        if($is_gifted_subscription){
          $recipient_user = get_recipient_user( $single_subscription );
        }
        
        // check if current and recipient user are same
        if($recipient_user == $current_user_id){
          
          //echo "Current user is a recipient user";
          
          // process further
          foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
      
            $subscribed_product_id = $product_subscription->get_product_id();
            //$subscribed_product_name = $product_subscription->get_name();
            
            if($product_id == $subscribed_product_id){
              
              // get the value from product custom field which had been created using acf
              $video_page_url = get_field('on_demand_classes', $subscribed_product_id);
              
              // reset product url as user has already subscribed to this product												
              $product_url = $video_page_url;	

              $productsData[$counter] = array(
                'product_id'=>$product_id,
                'product_key'=>$nonce_key,
              );	
              $counter++;	
              
              /*wc_enqueue_js("
      
                var unique_key = '".$nonce_key."';
                //alert('testz1');
                jQuery( document ).ready(function() {
                  //jQuery( '#gifting_".$nonce_key."_option' ).addClass( 'wcsg_needs_update' );
                  jQuery('.woocommerce_subscription_gifting_checkbox').prop('disabled', true);
                  setTimeout(function(){
                  jQuery('.woocommerce_subscription_gifting_checkbox').prop('disabled', false);
                  
                  if(!jQuery('#gifting_".$nonce_key."_option').is(':checked'))
                  jQuery('#gifting_".$nonce_key."_option').trigger('click');
                
                  document.getElementById('gifting_".$nonce_key."_option').disabled = true;
                  jQuery('#gifting_".$nonce_key."_option').addClass('no-active');
                  jQuery('#recipient_email\\[".$nonce_key."\\]').prop('required',true);
                  jQuery( 'body' ).trigger( 'update_checkout' );
                  }, 4000);
                  
                });
                
              ");*/


              /*
              ?>
              <script>
              
                var unique_key = '<?php echo $nonce_key ?>';
                jQuery( document ).ready(function() {
                  jQuery('.woocommerce_subscription_gifting_checkbox').prop('disabled', true);
                  setTimeout(function(){ 
                  jQuery('.woocommerce_subscription_gifting_checkbox').prop('disabled', false);
                  
                  if(!jQuery('#gifting_'+unique_key+'_option').is(':checked'))
                  jQuery('#gifting_'+unique_key+'_option').trigger('click');
                
                  document.getElementById('gifting_'+unique_key+'_option').disabled = true;
                  jQuery('#recipient_email\\['+unique_key+'\\]').prop('required',true);
                  console.log(jQuery('#recipient_email\\['+unique_key+'\\]').val());
                
                  }, 4000);
                });
                
              </script>
              <?php								
              */
            }	
          }	
        }
      }
    }
  }
}
echo json_encode($productsData);
die();
}

add_action( 'woocommerce_update_cart_action_cart_updated', 'cart_page_restrict_after_update_cart', 20, 1 );

function cart_page_restrict_after_update_cart($cart_updated) {
?>
<script>
  
  jQuery('.woocommerce_subscription_gifting_checkbox[type="checkbox"]').prop('disabled', true);
  

  
    
    
      var data = {
        'action': 'cart_page_restrict_user_to_gift_only',
      };
      var ajaxurl = '<?php echo admin_url("admin-ajax.php"); ?>';
      jQuery.post(ajaxurl, data, function (response) {
        jQuery('.woocommerce_subscription_gifting_checkbox[type="checkbox"]').prop('disabled', false);
        if(response){
          producsData = JSON.parse(response);
          console.log(producsData);

          for (let i = 0; i < producsData.length; i++){
              
            if(!jQuery('#gifting_'+producsData[i].product_key+'_option').is(':checked'))
            jQuery('#gifting_'+producsData[i].product_key+'_option').trigger('click');
        
            document.getElementById('gifting_'+producsData[i].product_key+'_option').disabled = true;
            jQuery('#recipient_email\\['+producsData[i].product_key+'\\]').prop('required',true);
            //sconsole.log(jQuery('#recipient_email\\['+producsData[i].product_key+'\\]').val());

          }
        }
        

      });
    

  
  
  
</script>
<?php
}





// create taxonomy for pages
add_action( 'init', 'pages_tax' );
function pages_tax() {
  register_taxonomy(
      'ondemand',
      'page',
      array(
          'label' => __( 'Category' ),
          'rewrite' => array( 'slug' => 'ondemand' ),
          'hierarchical' => true,
          'show_in_rest' => true,
    'show_ui' => true,
    'query_var' => true,
      )
  );
}


// clear cart on user login
add_action('wp_login', 'clear_persistent_cart_after_login', 10, 2);
function clear_persistent_cart_after_login( $user_login, $user ) {
  
if( function_exists('WC') ){
      WC()->cart->empty_cart();
  }

$blog_id = get_current_blog_id();
  // persistent carts created in WC 3.1 and below
  if ( metadata_exists( 'user', $user->ID, '_woocommerce_persistent_cart' ) ) {
      delete_user_meta( $user->ID, '_woocommerce_persistent_cart' );
  }

  // persistent carts created in WC 3.2+
  if ( metadata_exists( 'user', $user->ID, '_woocommerce_persistent_cart_' . $blog_id ) ) {
      delete_user_meta( $user->ID, '_woocommerce_persistent_cart_' . $blog_id );
  }

}


// clear cart on user logout
add_action( 'wp_logout', 'force_clear_woocommerce_cart' );
function force_clear_woocommerce_cart() {

  if( function_exists('WC') ){
      WC()->cart->empty_cart();
  }

}

// As we have created a custom verify email in product detail page in gift case
// have to make it required when used
add_action( 'wp_head', 'manage_gift_verify_email_field' );
function manage_gift_verify_email_field(){
if(is_product()){
  
  ?>
  <script>
    jQuery( document ).ready(function() {
      //setTimeout(function(){ 
      
        // Normal user case either select product as a gift or not
        jQuery('#gifting_0_option').on( 'change', function() {

          // User marked as gift		
          if(jQuery('#gifting_0_option').is(":checked")){
            
            // Make fields required
            jQuery('.recipient_email').prop('required',true);	
            jQuery('.custom_gift_veify_email').prop('required',true);	
          }else{
            
            // Not checked or clicked uncheck remove required attribute
            jQuery('.recipient_email').prop('required',false);	
            jQuery('.custom_gift_veify_email').prop('required',false);
          }
        });
        
        // In case of user already has subscription, check is checked by default
        if(jQuery('#gifting_0_option').is(":checked")){
          
          // Make fields required
          jQuery('.recipient_email').prop('required',true);	
          jQuery('.custom_gift_veify_email').prop('required',true);	
        }else{
          
          jQuery('.recipient_email').prop('required',false);	
          jQuery('.custom_gift_veify_email').prop('required',false);
        }
        
        // validation to verify email and verify has been applied in footer file to record GTM add to cart steps
        
        
      //}, 4000);
    });
  </script>
  <?php
  
}
}

// add validation to verify email addresses
//add_filter( 'woocommerce_add_to_cart_validation', 'add_the_email_validation', 10, 5 );  
function add_the_email_validation( $passed ) { 
if(isset($_REQUEST['recipient_email'][0]) ){
  if($_REQUEST['recipient_email'][0] != $_REQUEST['recipient_verify_email']){
    wc_add_notice( __( 'Email and verify email must be same.', 'woocommerce' ), 'error' );
    $passed = false;
  }
}

return $passed;
}



//Redirect the Continue Shopping URL from the default (shop page) to a custom URL. 
add_action('template_redirect', 'test_loop', 10, 2);
function test_loop(){
foreach ( WC()->cart->cart_contents as $key => $item ) {
  
  $product_id = $item['product_id'];
  
  //var_dump($product_id);
  
  $video_page_url = get_field('on_demand_classes', $product_id);
  
  //var_dump($video_page_url);
}	
}




add_action('template_redirect', 'shop_redirect_to_custom_page', 10, 2);
function shop_redirect_to_custom_page() {
if(is_shop()){
  
  $url = get_page_link(4502);
  
  wp_redirect( $url, 301 ); exit;
}	
}

// remove /month from products 
add_filter('woocommerce_subscriptions_product_price_string_inclusions', 'remove_subscription_inclusions', 10, 2);
function remove_subscription_inclusions( $include, $product ) {
  $include['subscription_length'] = '';
  $include['subscription_period'] = '';
  return $include;
}

// add custom tab "my-classes" in woocommerce account tab

// 1. Register new endpoint (URL) for My Account page
// Note: Re-save Permalinks or it will give 404 error

function bbloomer_add_premium_support_endpoint() {
  add_rewrite_endpoint( 'my-classes', EP_ROOT | EP_PAGES );
}

add_action( 'init', 'bbloomer_add_premium_support_endpoint' );

// ------------------
// 2. Add new query var

function bbloomer_premium_support_query_vars( $vars ) {
  $vars[] = 'my-classes';
  return $vars;
}

add_filter( 'query_vars', 'bbloomer_premium_support_query_vars', 0 );

// ------------------
// 3. Insert the new endpoint into the My Account menu

function bbloomer_add_premium_support_link_my_account( $items ) {
  $items['my-classes'] = 'My Classes';

$items = array_slice( $items, 0, 2, true ) 
+ array( 'my-classes' => 'My Classes' )
+ array_slice( $items, 2, NULL, true ); 
unset($items['downloads']);

  return $items;
}

add_filter( 'woocommerce_account_menu_items', 'bbloomer_add_premium_support_link_my_account' );

// ------------------
// 4. Add content to the new tab

function bbloomer_premium_support_content() {
 echo '<h3>Video Links</h3><p>You can access your subscribed video class by clicking below mentioned link(s) </p>';
 echo do_shortcode("[wc_my_classes]");
}

add_action( 'woocommerce_account_my-classes_endpoint', 'bbloomer_premium_support_content' );
// Note: add_action must follow 'woocommerce_account_{your-endpoint-slug}_endpoint' format


// Create shortcode for user's subscribed product urls
add_shortcode( 'wc_my_classes', 'wc_account_page_classes' );
function wc_account_page_classes() {
 
$current_user = wp_get_current_user();
$current_user_id = $current_user->ID;

// get current user's active subscription(s) 
$user_subscriptions = wcs_get_subscriptions(['customer_id' => $current_user_id, 'subscription_status'    => array( 'active' )]);

if($user_subscriptions){
  
  // User's url container for custom tab my-classes
  $my_url_to_show = array();

      
  // User may have multiple subscriptions so loop through it
  foreach($user_subscriptions as $subscription_id => $single_subscription ){
    
    // check is it gifted subscription or regular
    $is_gifted_subscription = is_gifted_subscription($single_subscription);
    
    // gifted, then skip itteration
    if($is_gifted_subscription){
      
      // as current user has purchased subscription as a gift for someone so access goes to recipient
      continue;
      
      //echo "Current user has a recipient user";
      
    }else{

      //echo "Current user has own subscription";
      // process further
      foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
    
        $subscribed_product_id = $product_subscription->get_product_id();
        $subscribed_product_name = $product_subscription->get_name();
          
        // get the value from product custom field which had been created using acf
        $video_page_url = get_field('on_demand_classes', $subscribed_product_id);
        
        // store this user's url in array to display them after loop
        $my_url_to_show[] = '<a style="margin-bottom:5px;" class="button" href="'.$video_page_url.'" > '.$subscribed_product_name.' </a>';
          
      }
    }
  }

  if($my_url_to_show){
    echo "<ul>";
    foreach(array_unique($my_url_to_show) as $key => $link){
      echo '<li>'.$link.'</li>';
    }
    echo "</ul>";
  }	
}
    
// may be current user is a recipient and have gifted subscription
//else{
  
  // get all subscriptions
  $all_subscriptions = wcs_get_subscriptions(['subscriptions_per_page' => -1, 'subscription_status' => array( 'active' )]);
  
  if($all_subscriptions){
    
    // User's url container for custom tab my-classes
    $my_url_to_show = array();
  
    foreach($all_subscriptions as $subscription_id => $single_subscription ){
      
      $recipient_user = "";				
      // check is it gifted subscription
      $is_gifted_subscription = is_gifted_subscription($single_subscription);
    
    
    
      // gifted, then get the recipient data
      if($is_gifted_subscription){
        $recipient_user = get_recipient_user( $single_subscription );
      }
      
      
      // check if current and recipient user are same
      if($recipient_user == $current_user_id){
        
        //echo "Current user is a recipient user";
        
        // process further
        foreach( $single_subscription->get_items() as $item_id => $product_subscription ){
    
          $subscribed_product_id = $product_subscription->get_product_id();
          $subscribed_product_name = $product_subscription->get_name();
            
          // get the value from product custom field which had been created using acf
          $video_page_url = get_field('on_demand_classes', $subscribed_product_id);
          
          // store this user's url in array to display them after loop
          $my_url_to_show[] = '<a style="margin-bottom:5px;" class="button" href="'.$video_page_url.'" > '.$subscribed_product_name.' </a>';
          
        }	
      }
    }
    
    if($my_url_to_show){
      echo "<ul>";
      foreach(array_unique($my_url_to_show) as $key => $link){
        echo '<li>'.$link.'</li>';
      }
      echo "</ul>";
    }
  }
//}						
 
}

// Avoid add to cart for non logged user (or not registered)
//add_filter( 'woocommerce_add_to_cart_validation', 'logged_in_customers_validation', 20, 3 );
function logged_in_customers_validation( $passed, $product_id, $quantity) {
  if( ! is_user_logged_in() ) {
      $passed = false;

      // Displaying a custom message
      $message = __("Please log in or register to add to cart.", "woocommerce");
      $button_link = get_permalink( get_option('woocommerce_myaccount_page_id') );
      $button_text = __("Login or register", "woocommerce");
      $message .= ' <a href="'.$button_link.'" class="login-register button" style="float:right;">'.$button_text.'</a>';
  $_SESSION['referrer_login'] = get_permalink($product_id);
      wc_add_notice( $message, 'error' );
  }

foreach ( WC()->cart->cart_contents as $key => $item ) {
  if($item){
    
    if($item['wcsg_gift_recipients_email'] == $_POST['recipient_email'][0] && $product_id == $item['product_id']  ){
      $passed = false;
      wc_add_notice( __( 'The recipient email already exists in cart with this product.', 'your-textdomain' ), 'error' );
      
    }
  }
}


  return $passed;
}

// style for custom mini cart icon
add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
function callback_for_setting_up_scripts() {
  wp_register_style( 'cart-icon-font', get_template_directory_uri() . '/assets/css/hld-fonts.css' );
  wp_enqueue_style( 'cart-icon-font' );
}



// Migrate orders from PM-PRO plugin to WooCommerce Subscription
// access url https://staging-slowrisepizza.temp513.kinsta.cloud/?migrate=1

if(isset($_GET['migrate']) && $_GET['migrate'] == 1){
add_action( 'init', 'create_order_subscription_programmatically' );
}
function create_order_subscription_programmatically() {


require_once __DIR__.'/excel/src/SimpleXLSX.php';


echo '<h1>Migrate Orders To Woocommerce.xslx</h1><pre>';
if ( $xlsx = SimpleXLSX::parse(get_template_directory().'/migration_xlsx/orders4.xlsx') ) {
  
  foreach ( $xlsx->rows() as $key => $r ) {
    
    
    // skip first line
    if($key !=0){
      
      
      
      //prepare data
      $product_id = $r[16];
      $user_email = $r[3];
      $user_password = $r[5];
      $start_date = $r[36];
      $order_status = $r[27];
      
      $time = strtotime($start_date);
      $end_date = date("Y-m-d H:i:s", strtotime("+1 month", $time));
      //$end_date = date("yyyy/mm/dd hh:mm:ss", strtotime("+1 month", $time));
      
      $first_name = $r[6];
      $last_name = $r[7];
      $company_name = '';
      
      $phone      = $r[14];
      $address_1  = $r[9];
      $address_2  = ''; 
      $city       = $r[10];
      $state      = $r[11];
      $postcode   = $r[12];
      $country    = $r[13];
      
      
      $address = array(
        'first_name' => $first_name,
        'last_name'  => $last_name,
        'company'    => $company_name,
        'email'      => $user_email,
        'phone'      => $phone,
        'address_1'  => $address_1,
        'address_2'  => $address_2, 
        'city'       => $city,
        'state'      => $state,
        'postcode'   => $postcode,
        'country'    => $country
      );
      
      
      $default_password = $user_password;
      $user = get_user_by('email', $user_email);
      if($user){
        $user_id = $user->ID;
      }else{
        continue;
        //$user_id = wp_create_user( $user_email, $default_password, $user_email );
      }
      
      
      
      $product = wc_get_product($product_id);

      $quantity = 1;
      
      // As far as I can see, you need to create the order first, then the sub
      
       $order_data = array(
         'status' => apply_filters('woocommerce_default_order_status', 'processing'),
         'customer_id' => $user_id
      );
      $order = wc_create_order($order_data);

      //$order = wc_create_order(array('customer_id' => $user_id));
      
      // var_dump($order);die();
      
      $order->add_product( $product, $quantity);
      $order->set_address( $address, 'billing' );
      $order->set_address( $address, 'shipping' );
      $order->set_date_created( $start_date );
      
      
      $order->calculate_totals();

      $order->update_status($order_status, 'Imported order', TRUE);

      // Order created, now create sub attached to it -- optional if you're not creating a subscription, obvs

      // Each variation has a different subscription period

      $period = WC_Subscriptions_Product::get_period( $product );
      $interval = WC_Subscriptions_Product::get_interval( $product );

      $sub = wcs_create_subscription(array('order_id' => $order->get_id(), 'billing_period' => $period, 'billing_interval' => $interval, 'start_date' => $start_date));
      
      //if($end_date <  $start_date){
        $dates_to_update = array();
        $dates_to_update['end'] = $end_date;
        // $dates_to_update['next_payment'] = $end_date;
        // $dates_to_update['trial_end'] = $end_date;
        $sub->update_dates($dates_to_update);
        
      //}

      

      $sub->add_product( $product, $quantity);
      $sub->set_address( $address, 'billing' );
      $sub->set_address( $address, 'shipping' );
      $sub->calculate_totals();

      WC_Subscriptions_Manager::activate_subscriptions_for_order($order);

      echo $key;
      echo "<br/>";
      //print "<a href='/wp-admin/post.php?post=" . $sub->id . "&action=edit'>Sub created! Click here to edit</a>";
      
    }
  }	
}    
}


// Add coupons programmatically, migrate coupons from PM-PRO to Woocommerce
// https://staging-slowrisepizza.temp513.kinsta.cloud/?migrate_coupon=1

if(isset($_GET['migrate_coupon']) && $_GET['migrate_coupon'] == 1){
add_action( 'init', 'create_coupons_programmatically' );
}
function create_coupons_programmatically(){

require_once __DIR__.'/excel/src/SimpleXLSX.php';


echo '<h1>Migrate Coupons To Woocommerce.xslx</h1><pre>';
if ( $xlsx = SimpleXLSX::parse(get_template_directory().'/migration_xlsx/coupons_fianl.xlsx') ) {
  
  foreach ( $xlsx->rows() as $key => $r ) {
    
    // skip first line
    if($key !=0){
      
      // prepare data
      $coupon_code = $r[0];
      $discount_type = $r[1];
      $amount = $r[2];
      $product_ids = $r[3];
      $usage_limit = $r[4];
      $usage_limit_per_user = $r[5];
      $expiry_date = $r[6];
      $usage_count = $r[7];	
      
      // Insert basic info initially
      $coupon = array(
        'post_title' => $coupon_code,
        'post_content' => '',
        'post_status' => 'publish',
        'post_author' => 1,
        'post_type'     => 'shop_coupon'
      );
      $new_coupon_id = wp_insert_post( $coupon );
      
      // Add meta
      update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
      update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
      update_post_meta( $new_coupon_id, 'individual_use', 'yes' );
      update_post_meta( $new_coupon_id, 'product_ids', $product_ids );
      update_post_meta( $new_coupon_id, 'exclude_product_ids', '' );
      update_post_meta( $new_coupon_id, 'usage_limit', $usage_limit );
      update_post_meta( $new_coupon_id, 'usage_limit_per_user', $usage_limit_per_user );
      update_post_meta( $new_coupon_id, 'expiry_date', $expiry_date );
      update_post_meta( $new_coupon_id, 'usage_count', $usage_count );
      update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
      update_post_meta( $new_coupon_id, 'free_shipping', 'no' );	
    }	
  }
} 
}

//var_dump($_SESSION['referrer_login']);

/**
* Redirect users to custom URL based on their role after login
*
* @param string $redirect
* @param object $user
* @return string
*/
function wc_custom_user_redirect( $redirect, $user ) {
// Get the first of all the roles assigned to the user
$role = $user->roles[0];

$dashboard = admin_url();
$myaccount = get_permalink( wc_get_page_id( 'myaccount' ) );

if( $role == 'administrator' ) {
  
  //$redirect = $dashboard;
  $redirect = $_SESSION['referrer_login'] ? $_SESSION['referrer_login'] : $myaccount;
}else {
  
  //Redirect any other role to the previous visited page or, if not available, to the home
  $redirect = $_SESSION['referrer_login'] ? $_SESSION['referrer_login'] : $myaccount;
  unset($_SESSION['referrer_login']);
}
//var_dump($redirect);die();
return $redirect;
}
add_filter( 'woocommerce_login_redirect', 'wc_custom_user_redirect', 10, 2 );


//add_filter('woocommerce_order_button_html', 'disable_place_order_button_html' );
function disable_place_order_button_html( $button ) {
  
?>
<script>

var customChekbox = jQuery('.woocommerce_subscription_gifting_checkbox').is(":checked");

if(customChekbox){
  var id = jQuery(this).attr('id');
  
  // Id is like gifting_f1e5284674fd1e360873c29337ebe2d7_option 
  var newId = id.slice(8,-7);
  
  var giftEmail = jQuery('#recipient_email\\['+newId+'\\]').val();
  alert(giftEmail);
}else{
  alert('not selected');
}

jQuery(document).on('click','.woocommerce_subscription_gifting_checkbox', function(){
  
  if(jQuery(this).is(":checked")){

    var id = jQuery(this).attr('id');
  
    // Id is like gifting_f1e5284674fd1e360873c29337ebe2d7_option 
    var newId = id.slice(8,-7);
    
    var giftEmail = jQuery('#recipient_email\\['+newId+'\\]').val();
    alert(giftEmail);	
  }else{
    alert('not checked');
  }
  
});
</script>
<?php


//$is_fee = WC()->cart->get_fees();
  // Get the chosen shipping method (if it exist)
  
  
// If the targeted shipping method is selected, we disable the button
//if( !$is_fee ) {
  $style = 'style="background:Silver !important; color:white !important; cursor: not-allowed !important; text-align:center;"';
  $button_text = apply_filters( 'woocommerce_order_button_text', __( 'Place order', 'woocommerce' ) );
  $button = '<a id="disable_order" class="button" '.$style.'>' . $button_text . '</a>';
//}
      
  
  return $button;
}


/**
* Auto Complete all WooCommerce orders.
*/
add_action( 'woocommerce_thankyou', 'custom_woocommerce_auto_complete_order' );
function custom_woocommerce_auto_complete_order($order_id)
{
if (!$order_id) {
  return;
}
// require_once ABSPATH.'zoom/data_files/access_token.txt';



add_post_meta($order_id,'email_plus_status_expiry','off',true);
add_post_meta($order_id,'email_plus_status_review_reminder','off',true); 


$order = wc_get_order($order_id);
$order->update_status('completed');
$tags = array();

//var_dump($order->get_billing_first_name());
//var_dump($order->get_billing_last_name());
//var_dump($order->get_billing_email());

$user_first_name = $order->get_billing_first_name();
$user_last_name  = $order->get_billing_last_name();
$user_email     = $order->get_billing_email();
$on_site_tag = "";
$on_demand_tag = "";
foreach ($order->get_items() as $item_id => $item) {
  // Get an instance of corresponding the WC_Product object
  $product = $item->get_product();
  $product_id = $product->get_id();
  $terms = get_the_terms($product->get_id(), 'product_cat');
  //var_dump($product_id ."-".$terms."<br/>");

  if ($terms) {
    $on_demand_tag = "VoD";
  } else {
    $on_site_tag = "On-site";
  }
  // This Code is to check if a user buys a class or event and then sent to mailchimp
  if (get_post_meta($item->get_product_id(), '_tribe_wooticket_for_event', true)) {
    $tags[] = array('name' => 'Event', 'status' => 'active');
  } else {
    $tags[] = array('name' => 'Class', 'status' => 'active');
  }

  /*$items_data[$item_id] = array(
          'name'       => $product->get_name(),
          'sku'        => $product->get_sku(),
          'quantity'   => $item->get_quantity(),
          'item_total' => number_format( $item->get_total(), 2 )
      );*/
}

/*********** Adding user in master list as well VOD **************/

$merge_fields2 = array(
  "FNAME" => $user_first_name,
  "LNAME" => $user_last_name,
);
$email = $user_email;
$list_id = '6cb2b1bee3';
$api_key = 'c05ccfc26d11717097e0e23fa0e78787-us2';

$data_center = substr($api_key, strpos($api_key, '-') + 1);

$url = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members';

$json = json_encode([
  'email_address' => $email,
  'status'        => 'subscribed', //pass 'subscribed' or 'pending'
  'merge_fields'  => $merge_fields2,
]);

$ch2 = curl_init($url);
curl_setopt($ch2, CURLOPT_USERPWD, 'user:' . $api_key);
curl_setopt($ch2, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
curl_setopt($ch2, CURLOPT_POST, 1);
curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch2, CURLOPT_POSTFIELDS, $json);
$result = curl_exec($ch2);
$status_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
curl_close($ch2);

/*********** Adding tags in user's profile **************/

require_once(ABSPATH . 'mailchimp-marketing-php/vendor/autoload.php');

$mailchimp = new MailchimpMarketing\ApiClient();
$mailchimp->setConfig([
  'apiKey' => 'c05ccfc26d11717097e0e23fa0e78787-us2',
  'server' => 'us2',
]);

$list_id = '6cb2b1bee3';
$subscriber_hash = md5($email);

if ($on_site_tag != "") {
  $tags[] = array("name" => "On-site", "status" => "active");
  $mailchimp->lists->updateListMemberTags($list_id, $subscriber_hash, [
    "tags" => $tags
  ]);
}

if ($on_demand_tag != "") {
  $tags[] = array("name" => "VoD", "status" => "active");

  $mailchimp->lists->updateListMemberTags($list_id, $subscriber_hash, [
    "tags" => $tags
  ]);
}
if(!empty($tags))
{
  $mailchimp->lists->updateListMemberTags($list_id, $subscriber_hash, [
    "tags" => $tags
  ]);
}

/*********** End adding tags in user's profile **************/

/*********** End adding user in master list as well VOD **************/



if ($on_site_tag != "") {

  /*********** Adding user in ZOOM AOI list **************/

  $merge_fields2 = array(
    "FNAME" => $user_first_name,
    "LNAME" => $user_last_name,
  );
  $email = $user_email;
  $zoom_api_list_id = '6cb2b1bee3';
  $api_key = 'c05ccfc26d11717097e0e23fa0e78787-us2';

  $data_center = substr($api_key, strpos($api_key, '-') + 1);

  $url = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $zoom_api_list_id . '/members';

  $json = json_encode([
    'email_address' => $email,
    'status'        => 'subscribed', //pass 'subscribed' or 'pending'
    'merge_fields'  => $merge_fields2,
  ]);

  $ch2 = curl_init($url);
  curl_setopt($ch2, CURLOPT_USERPWD, 'user:' . $api_key);
  curl_setopt($ch2, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
  curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch2, CURLOPT_TIMEOUT, 10);
  curl_setopt($ch2, CURLOPT_POST, 1);
  curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch2, CURLOPT_POSTFIELDS, $json);
  $result = curl_exec($ch2);
  $status_code = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
  curl_close($ch2);

  $tags[] = array("name" => "On-site ", "status" => "active");

  $mailchimp->lists->updateListMemberTags($zoom_api_list_id, $subscriber_hash, [
    "tags" => $tags
  ]);

  /*********** End Adding user in ZOOM AOI list **************/
}
}

//* Do NOT include the opening php tag
 
add_action( 'tribe_tickets_ticket_email_ticket_bottom', 'add_export_buttons_to_email' );
 
function add_export_buttons_to_email( array $ticket ) {
  if ( ! class_exists( 'Tribe__Events__Main' ) ) {
    return;
  }
 
  global $post;
  $post = get_post( $ticket['event_id'] );
 
  if ( empty( $post ) ) {
    return;
  }
 
  $ical_link = add_query_arg( 'ical', '1', get_the_permalink( $post->ID ) );
   
  // Use the following line if you want to have `webcal://` links, that are wiped by Gmail and others.
  // $ical_link = str_replace( [ 'http://', 'https://' ], 'webcal://', $ical_link );
 
  $calendar_links = '<div class="tribe-events-cal-links">';
  $calendar_links .= '<a class="tribe-events-gcal tribe-events-button" href="' . Tribe__Events__Main::instance()->esc_gcal_url( tribe_get_gcal_link() ) . '" target="_blank" rel="noopener noreferrer" title="' . esc_attr__( 'Add to Google Calendar', 'the-events-calendar' ) . '">+ ' . esc_html__( 'Google Calendar', 'the-events-calendar' ) . '</a>';
  $calendar_links .= '   ';
  $calendar_links .= '<a class="tribe-events-ical tribe-events-button" href="' . esc_url( $ical_link ) . '" title="' . esc_attr__( 'Download .ics file', 'the-events-calendar' ) . '" >+ ' . esc_html__( 'Add to iCalendar', 'the-events-calendar' ) . '</a>';
  $calendar_links .= '</div><!-- .tribe-events-cal-links -->';
 
  echo $calendar_links;
}