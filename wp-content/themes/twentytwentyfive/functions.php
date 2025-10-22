<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( 'assets/css/editor-style.css' );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
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
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
		function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

// Enables SVG uploads with sanitization and admin previews.
if ( ! function_exists( 'twentytwentyfive_register_svg_support' ) ) :
	/**
	 * Adds filters that allow uploading sanitized SVG files and styles their previews in the media library.
	 *
	 * @since Twenty Twenty-Five 1.1
	 *
	 * @return void
	 */
	function twentytwentyfive_register_svg_support() {
		add_filter( 'upload_mimes', 'twentytwentyfive_allow_svg_uploads' );
		add_filter( 'wp_check_filetype_and_ext', 'twentytwentyfive_check_svg_mime_type', 10, 5 );
		add_filter( 'wp_handle_upload', 'twentytwentyfive_sanitize_svg_upload' );
		add_action( 'admin_head', 'twentytwentyfive_svg_admin_styles' );
	}
endif;
add_action( 'init', 'twentytwentyfive_register_svg_support' );

if ( ! function_exists( 'twentytwentyfive_allow_svg_uploads' ) ) :
	/**
	 * Adds SVG to the list of allowed mime types.
	 *
	 * @since Twenty Twenty-Five 1.1
	 *
	 * @param array<string, string> $mimes Allowed mime types keyed by extension.
	 *
	 * @return array<string, string>
	 */
	function twentytwentyfive_allow_svg_uploads( $mimes ) {
		$mimes['svg']  = 'image/svg+xml';
		$mimes['svgz'] = 'image/svg+xml';

		return $mimes;
	}
endif;

if ( ! function_exists( 'twentytwentyfive_check_svg_mime_type' ) ) :
	/**
	 * Ensures WordPress recognises SVG mime types correctly during upload validation.
	 *
	 * @since Twenty Twenty-Five 1.1
	 *
	 * @param array<string, string|null> $data      File data supplied by WordPress.
	 * @param string                    $file      Full path to the uploaded file.
	 * @param string                    $filename  Name of the uploaded file.
	 * @param array<string, string>     $mimes     Allowed mime types keyed by extension.
	 * @param string                    $real_mime Detected real mime type when available.
	 *
	 * @return array<string, string|null>
	 */
	function twentytwentyfive_check_svg_mime_type( $data, $file, $filename, $mimes, $real_mime = '' ) {
		$extension = strtolower( pathinfo( $filename, PATHINFO_EXTENSION ) );

		if ( 'svg' !== $extension && 'svgz' !== $extension ) {
			return $data;
		}

		if ( class_exists( 'finfo' ) && defined( 'FILEINFO_MIME_TYPE' ) && empty( $real_mime ) ) {
			$finfo     = new finfo( FILEINFO_MIME_TYPE );
			$real_mime = $finfo->file( $file );
		}

		if ( 'image/svg+xml' === $real_mime || empty( $real_mime ) ) {
			$data['ext']  = $extension;
			$data['type'] = 'image/svg+xml';
		}

		return $data;
	}
endif;

if ( ! function_exists( 'twentytwentyfive_sanitize_svg_upload' ) ) :
	/**
	 * Sanitizes SVG markup to a safe subset before the file is finalised in the uploads directory.
	 *
	 * @since Twenty Twenty-Five 1.1
	 *
	 * @param array<string, string> $fileinfo Information about the uploaded file.
	 *
	 * @return array<string, string>
	 */
	function twentytwentyfive_sanitize_svg_upload( $fileinfo ) {
		if ( empty( $fileinfo['type'] ) || 'image/svg+xml' !== $fileinfo['type'] || empty( $fileinfo['file'] ) ) {
			return $fileinfo;
		}

		$svg_contents = file_get_contents( $fileinfo['file'] );

		if ( false === $svg_contents ) {
			return $fileinfo;
		}

		$allowed_tags = array(
			'svg'      => array(
				'class'               => true,
				'xmlns'               => true,
				'xmlns:xlink'         => true,
				'width'               => true,
				'height'              => true,
				'viewBox'             => true,
				'preserveAspectRatio' => true,
				'aria-hidden'         => true,
				'role'                => true,
				'focusable'           => true,
			),
			'g'        => array(
				'class'       => true,
				'clip-path'   => true,
				'fill'        => true,
				'fill-rule'   => true,
				'mask'        => true,
				'opacity'     => true,
				'stroke'      => true,
				'stroke-linecap' => true,
				'stroke-linejoin' => true,
				'stroke-width' => true,
				'transform'   => true,
			),
			'path'     => array(
				'class'         => true,
				'd'             => true,
				'fill'          => true,
				'fill-rule'     => true,
				'clip-rule'     => true,
				'mask'          => true,
				'opacity'       => true,
				'stroke'        => true,
				'stroke-linecap' => true,
				'stroke-linejoin' => true,
				'stroke-width' => true,
				'transform'     => true,
			),
			'circle'   => array(
				'class'   => true,
				'cx'      => true,
				'cy'      => true,
				'r'       => true,
				'fill'    => true,
				'opacity' => true,
				'stroke'  => true,
				'stroke-width' => true,
			),
			'ellipse'  => array(
				'cx'      => true,
				'cy'      => true,
				'rx'      => true,
				'ry'      => true,
				'fill'    => true,
				'opacity' => true,
				'stroke'  => true,
				'stroke-width' => true,
			),
			'line'     => array(
				'x1'      => true,
				'y1'      => true,
				'x2'      => true,
				'y2'      => true,
				'fill'    => true,
				'opacity' => true,
				'stroke'  => true,
				'stroke-width' => true,
			),
			'polyline' => array(
				'points'  => true,
				'fill'    => true,
				'opacity' => true,
				'stroke'  => true,
				'stroke-width' => true,
			),
			'polygon'  => array(
				'points'  => true,
				'fill'    => true,
				'opacity' => true,
				'stroke'  => true,
				'stroke-width' => true,
			),
			'rect'     => array(
				'class'   => true,
				'x'       => true,
				'y'       => true,
				'width'   => true,
				'height'  => true,
				'rx'      => true,
				'ry'      => true,
				'fill'    => true,
				'opacity' => true,
				'stroke'  => true,
				'stroke-width' => true,
			),
			'title'    => array(),
			'desc'     => array(),
			'use'      => array(
				'href'            => true,
				'xlink:href'      => true,
				'width'           => true,
				'height'          => true,
				'x'               => true,
				'y'               => true,
			),
			'defs'     => array(),
			'clipPath' => array(
				'id' => true,
			),
			'mask'     => array(
				'id'     => true,
				'maskUnits' => true,
			),
			'linearGradient' => array(
				'id'            => true,
				'x1'            => true,
				'x2'            => true,
				'y1'            => true,
				'y2'            => true,
				'gradientUnits' => true,
			),
			'stop'     => array(
				'offset' => true,
				'stop-color' => true,
				'stop-opacity' => true,
			),
		);

		$sanitized_svg = wp_kses( $svg_contents, $allowed_tags );

		if ( ! empty( $sanitized_svg ) ) {
			file_put_contents( $fileinfo['file'], $sanitized_svg );
		}

		return $fileinfo;
	}
endif;

if ( ! function_exists( 'twentytwentyfive_svg_admin_styles' ) ) :
	/**
	 * Adds CSS rules to ensure SVG thumbnails display nicely in the WordPress media library.
	 *
	 * @since Twenty Twenty-Five 1.1
	 *
	 * @return void
	 */
	function twentytwentyfive_svg_admin_styles() {
		echo '<style>
		.attachment .thumbnail img[src$=".svg"],
		.media-modal .attachment-preview img[src$=".svg"],
		.media-frame-content .attachment-preview svg {
			width: 100%;
			height: auto;
		}
		</style>';
	}
endif;
