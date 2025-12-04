<?php
/**
 * Urbana Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Urbana Theme 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'urbana_theme_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Urbana Theme 1.0
	 *
	 * @return void
	 */
	function urbana_theme_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'urbana_theme_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'urbana_theme_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Urbana Theme 1.0
	 *
	 * @return void
	 */
	function urbana_theme_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'urbana_theme_editor_style' );

// Enqueues the theme stylesheet on the front.
if ( ! function_exists( 'urbana_theme_enqueue_styles' ) ) :
	/**
	 * Enqueues the theme stylesheet on the front.
	 *
	 * @since Urbana Theme 1.0
	 *
	 * @return void
	 */
	function urbana_theme_enqueue_styles() {
		$suffix = SCRIPT_DEBUG ? '' : '.min';
		$src    = 'style' . $suffix . '.css';

		wp_enqueue_style(
			'urbana-theme-style',
			get_parent_theme_file_uri( $src ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
		wp_style_add_data(
			'urbana-theme-style',
			'path',
			get_parent_theme_file_path( $src )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'urbana_theme_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'urbana_theme_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Urbana Theme 1.0
	 *
	 * @return void
	 */
	function urbana_theme_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'urbana-theme' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'urbana_theme_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'urbana_theme_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Urbana Theme 1.0
	 *
	 * @return void
	 */
	function urbana_theme_pattern_categories() {

		register_block_pattern_category(
			'urbana_theme_page',
			array(
				'label'       => __( 'Pages', 'urbana-theme' ),
				'description' => __( 'A collection of full page layouts.', 'urbana-theme' ),
			)
		);

		register_block_pattern_category(
			'urbana_theme_post-format',
			array(
				'label'       => __( 'Post formats', 'urbana-theme' ),
				'description' => __( 'A collection of post format patterns.', 'urbana-theme' ),
			)
		);
	}
endif;
add_action( 'init', 'urbana_theme_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'urbana_theme_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Urbana Theme 1.0
	 *
	 * @return void
	 */
	function urbana_theme_register_block_bindings() {
		register_block_bindings_source(
			'urbana-theme/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'urbana-theme' ),
				'get_value_callback' => 'urbana_theme_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'urbana_theme_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'urbana_theme_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Urbana Theme 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function urbana_theme_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;
