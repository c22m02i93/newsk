<?php
/**
 * Church Native Theme functions and definitions
 */

define( 'CHURCH_NATIVE_THEME_VERSION', '0.1.0' );

/**
 * Enable support for SVG uploads and handling.
 */
function church_native_theme_enable_svg_uploads( $mimes ) {
    $mimes['svg']  = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';

    return $mimes;
}
add_filter( 'upload_mimes', 'church_native_theme_enable_svg_uploads' );

/**
 * Ensure SVG files are properly recognized by WordPress.
 */
function church_native_theme_fix_svg_filetype( $data, $file, $filename, $mimes, $real_mime = '' ) {
    $is_svg = false;

    if ( ! empty( $real_mime ) ) {
        $is_svg = in_array( $real_mime, array( 'image/svg', 'image/svg+xml' ), true );
    } else {
        $filetype = wp_check_filetype( $filename, $mimes );
        $is_svg   = ( 'svg' === $filetype['ext'] );
    }

    if ( $is_svg ) {
        $data['ext']  = 'svg';
        $data['type'] = 'image/svg+xml';
    }

    return $data;
}
add_filter( 'wp_check_filetype_and_ext', 'church_native_theme_fix_svg_filetype', 10, 5 );

/**
 * Return allowed SVG tags and attributes for sanitization.
 */
function church_native_theme_allowed_svg_elements() {
    $global_attributes = array(
        'id',
        'class',
        'style',
        'fill',
        'fill-opacity',
        'stroke',
        'stroke-width',
        'stroke-linecap',
        'stroke-linejoin',
        'stroke-miterlimit',
        'stroke-dasharray',
        'stroke-dashoffset',
        'stroke-opacity',
        'transform',
        'opacity',
        'clip-path',
        'mask',
        'data-name',
    );

    $elements = array(
        'svg'  => array_merge(
            $global_attributes,
            array(
                'xmlns',
                'xmlns:xlink',
                'version',
                'width',
                'height',
                'viewbox',
                'preserveaspectratio',
                'aria-labelledby',
                'aria-hidden',
                'role',
            )
        ),
        'g'    => $global_attributes,
        'path' => array_merge( $global_attributes, array( 'd' ) ),
        'rect' => array_merge( $global_attributes, array( 'x', 'y', 'width', 'height', 'rx', 'ry' ) ),
        'circle' => array_merge( $global_attributes, array( 'cx', 'cy', 'r' ) ),
        'ellipse' => array_merge( $global_attributes, array( 'cx', 'cy', 'rx', 'ry' ) ),
        'line' => array_merge( $global_attributes, array( 'x1', 'y1', 'x2', 'y2' ) ),
        'polyline' => array_merge( $global_attributes, array( 'points' ) ),
        'polygon' => array_merge( $global_attributes, array( 'points' ) ),
        'text' => array_merge( $global_attributes, array( 'x', 'y', 'dx', 'dy', 'text-anchor', 'font-family', 'font-size', 'letter-spacing' ) ),
        'tspan' => array_merge( $global_attributes, array( 'x', 'y', 'dx', 'dy', 'text-anchor', 'font-family', 'font-size', 'letter-spacing' ) ),
        'defs' => $global_attributes,
        'clippath' => $global_attributes,
        'title' => $global_attributes,
        'desc' => $global_attributes,
        'lineargradient' => array_merge( $global_attributes, array( 'id', 'x1', 'x2', 'y1', 'y2', 'gradientunits', 'gradienttransform' ) ),
        'radialgradient' => array_merge( $global_attributes, array( 'id', 'cx', 'cy', 'r', 'fx', 'fy', 'gradientunits', 'gradienttransform' ) ),
        'stop' => array_merge( $global_attributes, array( 'offset', 'stop-color', 'stop-opacity' ) ),
        'use' => array_merge( $global_attributes, array( 'href', 'xlink:href', 'x', 'y', 'width', 'height' ) ),
        'symbol' => array_merge( $global_attributes, array( 'id', 'viewbox', 'preserveaspectratio' ) ),
        'view' => array_merge( $global_attributes, array( 'id', 'viewbox', 'preserveaspectratio' ) ),
        'mask' => array_merge( $global_attributes, array( 'maskunits', 'maskcontentunits', 'x', 'y', 'width', 'height' ) ),
        'metadata' => $global_attributes,
    );

    $allowed = array();

    foreach ( $elements as $element => $attributes ) {
        $allowed[ $element ] = array_fill_keys( $attributes, true );
    }

    return $allowed;
}

/**
 * Sanitize SVG uploads by removing potentially unsafe tags.
 */
function church_native_theme_sanitize_svg( $file ) {
    $file_extension = pathinfo( $file['name'], PATHINFO_EXTENSION );

    if ( empty( $file_extension ) || 'svg' !== strtolower( $file_extension ) ) {
        return $file;
    }

    $svg = file_get_contents( $file['tmp_name'] );

    if ( false === $svg ) {
        return $file;
    }

    $allowed_html = church_native_theme_allowed_svg_elements();

    $sanitized_svg = wp_kses( $svg, $allowed_html );

    if ( empty( $sanitized_svg ) ) {
        $file['error'] = __( 'SVG file could not be sanitized.', 'church-native-theme' );

        return $file;
    }

    file_put_contents( $file['tmp_name'], $sanitized_svg );
    $file['type'] = 'image/svg+xml';

    return $file;
}
add_filter( 'wp_handle_upload_prefilter', 'church_native_theme_sanitize_svg' );

/**
 * Display SVG thumbnails in the media library.
 */
function church_native_theme_svg_admin_styles() {
    echo '<style>.attachment svg { width: 100%; height: auto; }</style>';
}
add_action( 'admin_head', 'church_native_theme_svg_admin_styles' );
