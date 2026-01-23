<?php

/**
 * Functions and definitions
 *
 * *** DO NOT EDIT ***
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @since 1.0.0 Initial release
 */

define( 'PST_FRAMEWORK_VERSION', '1.7.1' );

// Import Debug Log config file
if ( file_exists( get_template_directory() . '/config/debug-config.php' ) ) {
	require_once get_template_directory() . '/config/debug-config.php';
}

// Import config file with all the constants.
require_once get_template_directory() . '/config/theme-config.php';

// Import file to registers all theme options.
require_once get_template_directory() . '/inc/theme-options.php';

// Import config values.
require_once get_template_directory() . '/inc/functions-core-config.php';

// Import Document Rescriction script
if ( DOCUMENT_RESTRICTION === true ) {
	require_once get_template_directory() . '/inc/modules/document-restriction/functions-document-restriction.php';
	require_once get_template_directory() . '/inc/modules/document-restriction/document-restriction-options.php';
}

// Import Content Rescriction script
if ( ! empty( CONTENT_RESTRICTION['enable'] ) ) {
	require_once get_template_directory() . '/inc/modules/content-restriction/functions-content-restriction.php';
	require_once get_template_directory() . '/inc/modules/content-restriction/content-restriction-options.php';
}

// Import WPGB Search Filter script
if ( ( ! empty( WPGB_SEARCH_FILTER ) || ! empty( WPGB_SEARCH_FILTER['enable'] ) ) && class_exists( 'WP_Grid_Builder\Includes\Helpers' ) ) {
	require_once get_template_directory() . '/inc/modules/wpgb-search-filter/class-wpgb-search-filter.php';
	require_once get_template_directory() . '/inc/modules/wpgb-search-filter/wpgb-search-filter.php';
}


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function prosekwptheme_theme_support() {

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// Set post thumbnail size.
	set_post_thumbnail_size( 1200, 9999 );

	// Let WordPress manage the document title. - By adding theme support, we declare that this theme does not use a hard-coded <title> tag in the document head, and expect WordPress to provide it for us.
	add_theme_support( 'title-tag' );

	// Switch default core markup for search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script',
		'style',
		'navigation-widgets',
	) );

	// Add Image sizes (Creating multiple image sizes so that the img srcset will deliver more size options)

	foreach ( IMAGE_SIZES as $name => $size ) {

		add_image_size( $name, $size );
	}


	// Make theme available for translation.
	load_theme_textdomain( 'prosekwptheme' );
}

add_action( 'after_setup_theme', 'prosekwptheme_theme_support' );

/**
 * Register and Enqueue Styles.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function prosekwptheme_register_styles() {

	$theme_version = wp_get_theme()->get( 'Version' );

	wp_enqueue_style( 'prosekwptheme', get_template_directory_uri() . '/assets/css/main.css', [], $theme_version );
}

add_action( 'wp_enqueue_scripts', 'prosekwptheme_register_styles' );

/**
 * Register and Enqueue Scripts.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function prosekwptheme_register_scripts() {

	$theme_version = wp_get_theme()->get( 'Version' );

	$header_footer_module_script = get_template_directory() . '/assets/js/header-footer.js';

	if ( file_exists( $header_footer_module_script ) ) {
		wp_enqueue_script( 'prosekwptheme-header-footer-module', get_template_directory_uri() . '/assets/js/header-footer.js', [], $theme_version );
	}
	wp_enqueue_script( 'prosekwptheme', get_template_directory_uri() . '/assets/js/main.js', [], $theme_version, true );
	wp_script_add_data( 'prosekwptheme', 'async', true );
}

add_action( 'wp_enqueue_scripts', 'prosekwptheme_register_scripts' );

/**
 * Register Navigation Menus
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function prosekwptheme_menus() {
	foreach ( MENUS as $menu ) {

		if ( ! empty( $menu['name'] ) ) {

			register_nav_menu( $menu['name'], __( $menu['label'], 'prosekwptheme' ) );
		}
	}
}

add_action( 'after_setup_theme', 'prosekwptheme_menus' );

/**
 * Assign Nav Walkers
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 * @param array $args Menus
 *
 * @return array $args
 */
function register_nav_walkers( $args = [] ) {
	foreach ( MENUS as $menu ) {

		if ( ! empty( $menu['name'] ) ) {

			$file_location = get_template_directory() . "/assets/nav-walkers/{$menu['name']}-nav-walker.php";

			if ( file_exists( $file_location ) ) {

				$template_location = $file_location;
			} else {

				$template_location = get_template_directory() . "/inc/default-nav-walker.php";
			}

			require_once $template_location;

			if ( $menu['name'] == $args['theme_location'] ) {

				$args['container'] = ''; // Disable the container element

				if ( ! empty( $menu['menu_id'] ) ) {
					$args['menu_id'] = $menu['menu_id']; // Add an id to the wrapper ul element
				}

				if ( ! empty( $menu['menu_class'] ) ) {
					$args['menu_class'] = $menu['menu_class']; // Add classes to the wrapper ul element
				}

				$args['items_wrap'] = ! empty( $menu['items_wrap'] ) ? $menu['items_wrap'] : '<ul id="%1$s" class="%2$s">%3$s</ul>'; // Define the structure of the wrapper element

				if ( file_exists( $file_location ) ) {

					$class_name = ucfirst( $menu['name'] ) . '_Nav_Walker';
				} else {

					$class_name = 'Default_Nav_Walker';
				}

				$args['walker'] = new $class_name();
			}
		}
	}

	return $args;
}

add_filter( 'wp_nav_menu_args', 'register_nav_walkers' );

/**
 * Enqueue classic editor styles.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function prosekwptheme_classic_editor_styles() {

	$classic_editor_styles = array(

		get_template_directory_uri() . '/assets/css/main.css',
	);

	add_editor_style( $classic_editor_styles );
}

add_action( 'init', 'prosekwptheme_classic_editor_styles' );

/**
 * Change dashboard Posts to News
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function cp_change_post_object() {
	$get_post_type              = get_post_type_object( 'post' );
	$get_post_type->menu_icon   = 'dashicons-media-document';
	$labels                     = $get_post_type->labels;
	$labels->name               = 'News';
	$labels->singular_name      = 'News';
	$labels->add_new            = 'Add News';
	$labels->add_new_item       = 'Add News';
	$labels->edit_item          = 'Edit News';
	$labels->new_item           = 'News';
	$labels->view_item          = 'View News';
	$labels->search_items       = 'Search News';
	$labels->not_found          = 'No News found';
	$labels->not_found_in_trash = 'No News found in Trash';
	$labels->all_items          = 'All News';
	$labels->menu_name          = 'News';
	$labels->name_admin_bar     = 'News';
}

if ( RENAME_POSTS_LABELS_TO_NEWS ) {
	add_action( 'init', 'cp_change_post_object' );
}

/**
 * Optimizations
 *
 */

// Remove emoji support
if ( REMOVE_EMOJI ) {

	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
}

// Remove rss feed links
if ( REMOVE_RSS ) {

	remove_action( 'wp_head', 'feed_links_extra', 3 );
	remove_action( 'wp_head', 'feed_links', 2 );
}

// Remove wp-embed
if ( REMOVE_WP_EMBED ) {

	add_action( 'wp_footer', function () {
		wp_dequeue_script( 'wp-embed' );
	} );
}

/**
 * Unload unwanted scripts
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function unload_scripts() {
	// Remove block library css
	if ( REMOVE_BLOCK_LIBRARY ) {
		wp_dequeue_style( 'wp-block-library' );
	}

	// Remove comment reply JS
	if ( REMOVE_POST_COMMENTS ) {
		wp_dequeue_script( 'comment-reply' );
	}

	// Remove Classic Theme Styles
	if ( REMOVE_CLASSIC_THEME_STYLING ) {
		wp_dequeue_style( 'classic-theme-styles' );
	}
}

add_action( 'wp_enqueue_scripts', 'unload_scripts' );

/**
 * Maximum number of post revisions to keep.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function limit_post_revisions() {
	if ( MAX_WP_POST_REVISIONS ) {
		return MAX_WP_POST_REVISIONS;
	} else {
		return true;
	}
}

add_filter( 'wp_revisions_to_keep', 'limit_post_revisions' );

/**
 * Function to sort a matrix (2D array) based on a key value.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 * @param array $array
 * @param string $on
 * @param string $order
 *
 * @return void
 */
function array_sort( $array = [], $on = "", $order = SORT_ASC ) {
	$new_array      = [];
	$sortable_array = [];

	if ( count( $array ) > 0 ) {

		foreach ( $array as $k => $v ) {

			if ( is_array( $v ) ) {

				foreach ( $v as $k2 => $v2 ) {

					if ( $k2 == $on ) {
						$sortable_array[ $k ] = $v2;
					}
				}
			} else {

				$sortable_array[ $k ] = $v;
			}
		}

		switch ( $order ) {

			case SORT_ASC:
				asort( $sortable_array );
				break;

			case SORT_DESC:
				arsort( $sortable_array );
				break;
		}

		foreach ( $sortable_array as $k => $v ) {

			$new_array[ $k ] = $array[ $k ];
		}
	}

	return $new_array;
}

// Enable/Disable the Xmlrpc service for WordPress.
if ( DISABLE_XMLRPC ) {

	add_filter( 'xmlrpc_enabled', '__return_false' );
}

/**
 * Disable support for comments and trackbacks in post types
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function disable_comments_post_types_support() {
	$post_types = get_post_types();

	foreach ( $post_types as $post_type ) {

		if ( post_type_supports( $post_type, 'comments' ) ) {

			remove_post_type_support( $post_type, 'comments' );
			remove_post_type_support( $post_type, 'trackbacks' );
		}
	}
}

if ( ! empty( DISABLE_COMMENTS ) ) {

	add_action( 'admin_init', 'disable_comments_post_types_support' );
}

/**
 * Close comments on the front-end
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function disable_comments_status() {
	return false;
}

if ( ! empty( DISABLE_COMMENTS ) ) {

	add_filter( 'comments_open', 'disable_comments_status', 20, 2 );
	add_filter( 'pings_open', 'disable_comments_status', 20, 2 );
}

// Hide existing comments

/**
 * Hide existing comments
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 * @param array $comments
 *
 */
function disable_comments_hide_existing_comments( $comments = [] ) {
	$comments = [];

	return $comments;
}

if ( ! empty( DISABLE_COMMENTS ) ) {

	add_filter( 'comments_array', 'disable_comments_hide_existing_comments', 10, 2 );
}

/**
 * Remove comments page in the menu.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function disable_comments_admin_menu() {
	remove_menu_page( 'edit-comments.php' );
}

if ( ! empty( DISABLE_COMMENTS ) ) {

	add_action( 'admin_menu', 'disable_comments_admin_menu' );
}

/**
 * Redirect any user trying to access the comments page.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function disable_comments_admin_menu_redirect() {
	global $pagenow;

	if ( $pagenow === 'edit-comments.php' ) {

		wp_redirect( admin_url() );
		exit;
	}
}

if ( ! empty( DISABLE_COMMENTS ) ) {

	add_action( 'admin_init', 'disable_comments_admin_menu_redirect' );
}

/**
 * Remove the comments metabox from the dashboard.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function disable_comments_dashboard() {
	remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
}

if ( ! empty( DISABLE_COMMENTS ) ) {

	add_action( 'admin_init', 'disable_comments_dashboard' );
}


/**
 * Update post_content field with the HTML from ACF templates.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 * @param int $post_id
 *
 */
function add_content_on_save( $post_id = 0 ) {
	// Check if this is an autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	if ( ! wp_is_post_revision( $post_id ) ) {

		// Add the content to the post_content field
		ob_start();
		get_loop( $post_id );
		$content_raw = ob_get_clean();

		// Remove HTML comments and extra whitespace. 
		$content_cleaned = wp_kses_post( trim( preg_replace( '/<!--(.|\s)*?-->|\s+/', ' ', $content_raw ) ) );

		$acf_excerpt_field_names = ACF_EXCERPT_FIELD_NAMES;

		$excerpt_count = 0;

		// Add post excerpt if available
		foreach ( $acf_excerpt_field_names as $acf_excerpt_field_name ) {

			$excerpt_raw = get_field( $acf_excerpt_field_name, $post_id );

			if ( ! empty( $excerpt_raw ) ) {
				$excerpt_count ++;
				$excerpt_cleaned = sanitize_textarea_field( $excerpt_raw );
			} else {

				$excerpt_cleaned = '';
			}

			if ( $excerpt_count === 1 ) {
				// update the post, which calls save_post again
				wp_update_post( [
					'ID'           => $post_id,
					'post_content' => $content_cleaned,
					'post_excerpt' => $excerpt_cleaned,
				] );
			}
		}
	}
}

if ( ADD_HTML_TO_POST ) {

	add_action( 'acf/save_post', 'add_content_on_save' );
}


/**
 * Add image wrapper to img tags
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 * @param string $html
 *
 * @return string html
 */
function image_attachment_wrapper( $html = "" ) {
	if ( empty( strpos( $html, 'data-h-pos' ) ) ) {
		return $html;
	} else {
		ob_start();
		?>
		<div class="image-wrapper h-full overflow-hidden">
			<?php echo $html ?>
		</div><!-- .image-wrapper -->
		<?php
		return ob_get_clean();
	}
}

add_filter( 'wp_get_attachment_image', 'image_attachment_wrapper', 10, 2 );

/**
 * Make modifications to the img tag
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 * @param array $attr
 * @param object $attachment
 *
 * @return array $attr
 */
function image_attachment_attr( $attr, $attachment ) {
	if ( ! empty( $attr['data-h-pos'] ) ) {
		$bg_image = wp_get_attachment_image_url( $attachment->ID, 'image-100w' );

		if ( empty( $attr['css-override'] ) ) {
			$important = '!important';
		} else {
			$important = '';
		}

		$attr['style'] = 'background-image:url(' . $bg_image . ');';
		if ( isset( $attr['data-h-pos'] ) && isset( $attr['data-v-pos'] ) ) {

			$attr['style'] .= "object-position:{$attr['data-h-pos']}% {$attr['data-v-pos']}% {$important}; background-position:{$attr['data-h-pos']}% {$attr['data-v-pos']}% {$important};";
		}

		if ( isset( $attr['data-scale'] ) ) {

			$image_metadata = wp_get_attachment_metadata( $attachment->ID );
			if ( $image_metadata ) {
				$image_width  = $image_metadata['width'];
				$image_height = $image_metadata['height'];

				if ( $image_width > $image_height ) {
					$attr['style'] .= "height:{$attr['data-scale']}% {$important}; width:fit-content;";
				} else {
					$attr['style'] .= "height:fit-content; width:{$attr['data-scale']}% {$important};";
				}
			}
		}

		if ( isset( $attr['fit'] ) ) {
			$attr['style'] .= "object-fit:{$attr['fit']} {$important};";
		}
	}

	return $attr;
}

add_filter( 'wp_get_attachment_image_attributes', 'image_attachment_attr', 10, 2 );

/**
 * Fuzzy url redirect
 *
 */
if ( ! empty( DISABLE_CANONICAL_REDIRECT ) ) {

	add_filter( 'redirect_canonical', function ( $url ) {

		if ( is_404() ) {
			return false;
		}

		return $url;
	} );
}

/**
 * Get ACF re-usable component
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 * @param string $name Template name
 * @param array $args Arguments to be passed into the template.
 *
 */
function get_component( $name = '', $args = [] ) {
	$file_location = STYLESHEETPATH . "/assets/templates/components/{$name}.php";

	if ( file_exists( $file_location ) ) {

		echo "<!-- START COMPONENT : {$name} -->";
		load_template( $file_location, false, $args );
		echo "<!-- END COMPONENT : {$name} -->";
	} else {

		echo "ERROR: Missing component file '{$file_location}'";
	}
}

/**
 * Render the main ACF loop
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 * @param int $post_id
 *
 */
function get_loop( $post_id = 0 ) {
	if ( post_password_required() ) {
		echo get_the_password_form();
	} else {
		$file_location = STYLESHEETPATH . "/inc/templates/acf-loop.php";

		if ( file_exists( $file_location ) ) {

			echo "<!-- START ACF Loop -->";
			load_template( $file_location, false, $post_id );
			echo "<!-- END ACF Loop -->";
		} else {

			echo "ERROR: Missing file: /inc/templates/acf-loop.php";
		}
	}
}

/**
 * This function can be used to render background images that are added using the normal Image ACF field instead of using the clone field with the vertical and horizontal sliders.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.14 Initial release
 *
 * @param int $image - Image Attachment ID
 * @param int $vertical_position - Vertical position as a percentage (without the percentage sign)
 * @param int $horizontal_position - Horizontal position as a percentage (without the percentage sign)
 * @param string $screen_width - The maximum width of the image when the screen size goes beyond 1920px.
 * @param string $max_width - Whether to enable or disable image scaling for the user.
 * @param bool $css_override Setting this to true will remove !important from all CSS properties added to <img>.
 *
 * @return HTML - <img> code
 */
function render_background_image( $image = 0, $vertical_position = 50, $horizontal_position = 50, $screen_width = '', $max_width = '', $css_override = false ) {
	if ( ! empty( $image ) && ! is_array( $image ) && is_numeric( $vertical_position ) && is_numeric( $horizontal_position ) ) {
		$background_image = [
			'image' => $image,
			'v_pos' => $vertical_position,
			'h_pos' => $horizontal_position,
		];
		render_image( $background_image, $screen_width, $max_width, false, $css_override );
	}
}

/**
 * Image render
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 * @param string $image Image Object.
 * @param string $screen_width The portion of the viewport width that the image should occupy when the screen width is less than the $max_width value (e.g., if $max_width is set to 1000px and the image's size is specified as 50vw, the browser will load an image close to 500px when the screen width is under 1000px. On a retina display, the browser will load an image close to 1000px instead).
 * @param string $max_width The maximum width at which the browser will render the image (2x resolution will be displayed on retina screens).
 * @param bool $scale Whether to enable or disable image scaling for the user.
 * @param bool $css_override Setting this to true will remove !important from all CSS properties added to <img>.
 *
 * @return string html
 */
function render_image( $image = '', $screen_width = '', $max_width = '', $scale = false, $css_override = false ) {
	if ( ! empty( $image ) ) {

		$args                 = [];
		$args['css-override'] = $css_override;

		if ( ! empty( $screen_width ) && ! empty( $max_width ) ) {

			$args['sizes'] = "(max-width: {$max_width}) {$screen_width}, {$max_width}";
		}

		if ( is_array( $image ) ) {

			$args['data-h-pos'] = isset( $image['h_pos'] ) ? $image['h_pos'] : '';
			$args['data-v-pos'] = isset( $image['v_pos'] ) ? $image['v_pos'] : '';

			$args['fit'] = ! empty( $image['fit'] ) ? $image['fit'] : '';

			if ( ! empty( $image['scale'] ) ) {

				if ( $scale ) {
					$args['data-scale'] = $image['scale'];
				}
			}

			echo wp_get_attachment_image( $image['image'], 'full', false, $args );
		} else {
			$args['fit'] = 'contain';
			echo wp_get_attachment_image( $image, 'full', false, $args );
		}
	}
}

// Disable image lazy loading
if ( DISABLE_IMAGE_LAZY_LOADING ) {

	add_filter( 'wp_lazy_loading_enabled', '__return_false' );
}

/**
 * Minify HTML and remove comments
 *
 */

/**
 * This modifies the output buffer if the Minify HTML checkbox is ticked in the Theme Options section.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function minify_html() {
	if ( ( get_option( 'minify_html' ) || get_option( 'remove_html_comments' ) ) && ! is_admin() ) {

		ob_start( 'minify_html_content' );
	}
}

/**
 * Modifies the HTML output so that it is minified and comments are removed (if these options are checked)
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 * @param string $content Output buffer in HTML format
 *
 */
function minify_html_content( $content = '' ) {

	if ( get_option( 'remove_html_comments' ) ) {

		// Remove HTML comments
		$pattern = '/<!--(.*?)-->/s';
		$content = preg_replace( $pattern, '', $content );
	}

	if ( get_option( 'minify_html' ) ) {
		// Remove line breaks and whitespace between HTML tags
		$content = preg_replace( '/>\s+</', '><', $content );

		// Remove all other line breaks and whitespace
		$content = preg_replace( '/\s+/', ' ', $content );

		// Remove leading and trailing whitespace
		$content = trim( $content );
	}

	return $content;
}

add_action( 'init', 'minify_html' );

/**
 * Adds the Google Tag Manager script to the head
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function google_tag_manager() {
	$gtm_id = sanitize_text_field( get_option( 'gtm_id' ) );

	if ( ! empty( $gtm_id ) ) {


		ob_start();
		?>
		
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $gtm_id ?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];

			function gtag() {
				dataLayer.push( arguments );
			}

			gtag( 'js', new Date() );
			gtag( 'config', '<?php echo $gtm_id ?>' );
		</script>

		<?php
		$snippet = ob_get_clean();

		echo $snippet;
	}
}

add_action( 'wp_head', 'google_tag_manager' );

/**
 * Adds the CSS styling to handle custom screen clamping widths when Desktop Only mode is activated.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.0 Initial release
 *
 */
function desktop_only_css() {
	if ( DESKTOP_ONLY_MODE ) {

		ob_start(); ?>
		
		<style id="desktop-only-mode-css">
		  #body-section {
			  display: none !important;
		  }

		  @media (min-width: <?php echo MIN_SCREEN_SIZE ?>) {
			  #desktop-only {
				  display: none !important;
			  }

			  #body-section {
				  display: block !important;
			  }
		  }
		</style>

		<?php

		$snippet = ob_get_clean();

		echo $snippet;
	}
}

add_action( 'wp_head', 'desktop_only_css' );

/**
 * Adds extended ACF shortcode functionality
 *
 * Shortcode Usage
 * ---------------
 *
 * [acf-field group='content_section' field='text_1' option=1] // If the field exists in the options page
 *
 * [acf-field group='content_section' field='text_1' postID=15] // Can pass a Post ID. If nothing is specified, the current ID will be used.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.12 Initial release
 *
 * @param array $atts shortcode attributes
 *
 * @return HTML
 */
function render_acf_field_shortcode( $atts = [] ) {
	$attributes = shortcode_atts( [
		'group'  => false,
		'field'  => false,
		'postID' => false,
		'option' => false,
	], $atts );

	$error_message = '[NO DATA]';

	if ( $attributes['group'] && $attributes['field'] ) {
		if ( $attributes['option'] ) {
			$group = get_field( $attributes['group'], 'option' );
		} else {
			if ( $attributes['postID'] ) {
				$group = get_field( $attributes['group'], $attributes['postID'] );
			} else {
				$group = get_field( $attributes['group'], get_the_ID() );
			}
		}

		if ( $group && is_array( $group ) ) {
			$field = $group[ $attributes['field'] ];
			if ( $field ) {
				$content = $field;
			} else {
				$content = $error_message;
			}
		} else {
			$content = $error_message;
		}
	} else {
		$content = $error_message;
	}

	return $content;
}

add_shortcode( 'acf-field', 'render_acf_field_shortcode' );

/**
 * Enable Gravity Form Elements to process shortcodes.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.13 Initial release
 *
 * @param array $elements - Form Elements
 *
 * @return array - Modified Form Elements.
 */
function replace_shortcodes_in_gravity_forms( $elements = [] ) {
	// All Fields
	$fields = $elements['fields'];
	foreach ( $fields as $field ) {
		if ( ! empty( $field['text'] ) ) {
			$field['text'] = run_shortcode( $field['text'] );
		}
		if ( ! empty( $field['label'] ) ) {
			$field['label'] = run_shortcode( $field['label'] );
		}
		if ( ! empty( $field['placeholder'] ) ) {
			$field['placeholder'] = run_shortcode( $field['placeholder'] );
		}
		if ( ! empty( $field['description'] ) ) {
			$field['description'] = run_shortcode( $field['description'] );
		}
	}

	// Button
	$elements['button']['text'] = run_shortcode( $elements['button']['text'] );

	return $elements;
}

/**
 * Render shortcodes
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.13 Initial release
 *
 * @param string $shortcode
 *
 * @return HTML
 */
function run_shortcode( $shortcode = '' ) {
	return preg_replace_callback( '/\[(.*?)\]/', function ( $shortcode ) {
		return do_shortcode( $shortcode[0] );
	}, $shortcode );
}

if ( ENABLE_SHORTCODES_IN_GRAVITY_FORMS ) {
	add_filter( 'gform_pre_render', 'replace_shortcodes_in_gravity_forms' );
	add_filter( 'gform_pre_validation', 'replace_shortcodes_in_gravity_forms' );
	add_filter( 'gform_pre_submission_filter', 'replace_shortcodes_in_gravity_forms' );
}

if ( DISABLE_PARENTS_FOR_TERMS ) {

	/**
	 * This can be used to disable the parent dropdown menu for terms (Taxonomies)
	 *
	 * @author Kaveen Goonawardane
	 *
	 * @since 1.0.16 Initial release
	 *
	 * @param string $output - <select> HTML
	 * @param array $parsed_args - Arguments for the Select box
	 *
	 * @return HTML
	 */
	function disable_parent_dropdown( $output = '', $parsed_args = [] ) {
		$terms = DISABLE_PARENTS_FOR_TERMS;

		if ( ! in_array( $parsed_args['taxonomy'], $terms ) ) {
			return $output;
		} else {
			//return str_replace('<select', '<select disabled ', $output);
			return '';
		}
	}

	add_filter( 'wp_dropdown_cats', 'disable_parent_dropdown', 10, 2 );

	/**
	 * This is used to remove the text above the parent drop down menu in the term pages (Taxonomies)
	 *
	 * @author Kaveen Goonawardane
	 *
	 * @since 1.0.20 Initial release
	 *
	 * @return void
	 */
	function remove_parent_dropdown_text() {

		$terms = DISABLE_PARENTS_FOR_TERMS;

		$screen = get_current_screen();

		if ( in_array( $screen->taxonomy, $terms ) ) {
			ob_start();
			?>
			<style id="remove-parent-dropdown-text-css">
			 .form-field.term-parent-wrap {
				 display: none;
			 }
			</style>
			<?php
			$snippet = ob_get_clean();

			echo $snippet;
		}
	}

	add_action( 'admin_head', 'remove_parent_dropdown_text' );
}

/**
 * This will allow you to debug your code quickly by passing a variable and printing out the results in a seperate log file called 'debug.log'. This is useful when debugging Ajax calls and code within Filter Hooks.
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.22 Initial release
 *
 * @param $variable - Any type of variable.
 *
 */
function debug_log( $variable ) {
	if ( file_exists( DEBUG_LOG_PATH ) ) {
		ob_start();

		var_dump( $variable );

		$variable = ob_get_clean();

		$file_path = DEBUG_LOG_PATH;
		if ( substr( $file_path, - 1 ) !== '/' ) {
			$file_path .= '/debug.log';
		} else {
			$file_path .= 'debug.log';
		}


		$file = fopen( $file_path, "a" );

		if ( $file ) {

			fwrite( $file, '[' . date( 'Y-m-d H:i:s' ) . ']: ' . PHP_EOL . ( ! empty( $variable ) ? $variable : 'NULL' ) . PHP_EOL );
			fclose( $file );
		}
	}
}

/**
 * Render the 404 page
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.0.22 Initial release
 *
 */
function show_404_page() {
	global $wp_query;
	$wp_query->set_404();
	status_header( 404 );
	get_template_part( 404 );
	exit();
}

if ( ! empty( SEARCH_META_FIELDS['enable'] ) ) {
	/**
	 * Overrides the default search function to search through meta fields (For ACF) instead of the default post_title, post_content and post_excerpt for the specified post types.
	 *
	 * @author Kaveen Goonawardane
	 *
	 * @since 1.2.0 Initial release
	 *
	 * @param obj $query Search query object
	 *
	 * @return obj Modified search query
	 */
	function search_query_override( $query ) {
		if ( $query->is_search ) {
			if ( empty( SEARCH_META_FIELDS['enable_for_admin'] ) && is_admin() ) {
				return $query;
			}
			$search_query = $query->query_vars['s'];

			if ( ( ! empty( SEARCH_META_FIELDS['post_types'] ) && is_array( SEARCH_META_FIELDS['post_types'] ) && ( ! empty( SEARCH_META_FIELDS['meta_fields'] ) && is_array( SEARCH_META_FIELDS['meta_fields'] ) ) ) && ! empty( $search_query ) ) {

				$post_types  = SEARCH_META_FIELDS['post_types'];
				$meta_query  = [ 'relation' => 'OR' ];
				$meta_fields = SEARCH_META_FIELDS['meta_fields'];

				foreach ( $meta_fields as $meta_field ) {
					$sub_meta_query = [
						'key'     => $meta_field,
						'value'   => $search_query,
						'compare' => 'LIKE',
					];
					$meta_query[]   = $sub_meta_query;
				}

				if ( in_array( $query->query_vars['post_type'], $post_types ) ) {
					$query->set( 'meta_query', [ $meta_query ] );
				}
			}
		}

		return $query;
	}

	add_action( 'pre_get_posts', 'search_query_override' );
}

/**
 * Custom password form for protected posts/pages
 *
 * @author Kaveen Goonawardane
 *
 * @since 1.3.3 Initial release
 *
 * @param html $form
 *
 * @return html form
 */
function post_password_form( $form ) {
	ob_start();
	?>
	<div class="post-password-form-wrapper">

		<?php if ( ! ( ( ! isset( $_COOKIE[ 'wp-postpass_' . COOKIEHASH ] ) ) || ( wp_get_raw_referer() != get_permalink() ) ) ) : ?>
			
			<div class="info-box-error">
				<?php _e( 'Incorrect password', 'prosekwptheme' ); ?>
			</div><!-- .info-box-error -->

		<?php endif; ?>
		<?php echo $form; ?>
	</div><!-- .post-password-form-wrapper -->

	<?php
	return ob_get_clean();
}

add_filter( 'the_password_form', 'post_password_form' );
