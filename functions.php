<?php

/**
 * Including the default settings.
 *
 * *** DO NOT REMOVE ***
 */
require_once get_template_directory() . '/inc/functions-core.php';
define('IMAGE_ASSETS', get_stylesheet_directory_uri() . '/assets/images/');
define('IMAGE_PLACEHOLDER', IMAGE_ASSETS . 'placeholder.jpg');
define('AVATAR_PLACEHOLDER', IMAGE_ASSETS . 'contact-placeholder.png');

/**
 * -----------------------------------------------------------
 *             START ADDING YOUR CODE FROM HERE
 * -----------------------------------------------------------
 */

/**
 * Get the button HTML
 *
 * @param array  $acf_button_group ACF button group
 * @param string $css_class        CSS class
 *
 * @return string Button HTML
 */
function get_button($acf_button_group = [], $css_class = ''): string
{
    if (!$acf_button_group) {
        return '';
    }

    ob_start();
    get_component('button', [
        'button' => $acf_button_group,
        'class'  => $css_class,
    ]);

    $html = ob_get_clean();

    $no_comments = remove_html_comments($html);

    // Check if button is empty - output nothing
    return $no_comments ? $html : '';
}

function remove_html_comments($content = '')
{
    return preg_replace('/<!--(.|\s)*?-->/', '', $content);
}

/**
 * Get image markup with fallback to the placeholder image
 *
 * This function generates the HTML markup for an image. If the provided image data is invalid
 * or missing, it will fallback to a placeholder image (either a standard image or an avatar).
 *
 * @param array  $image        Image data, typically containing the image URL and other properties like fit, position, etc.
 * @param string $screen_width The portion of the viewport width that the image should occupy when the screen width is less than the $max_width value (e.g., if $max_width is set to 1000px and the image's size is specified as 50vw, the browser will load an image close to 500px when the screen width is under 1000px. On a retina display, the browser will load an image close to 1000px instead).
 * @param string $max_width    The maximum width at which the browser will render the image (2x resolution will be displayed on retina screens).
 * @param bool   $scale        Whether to enable or disable image scaling for the user.
 * @param bool   $type         Specify type of placeholder image to display. Allowed values are 'image' or 'avatar'.
 *
 * @return string                 The generated HTML string for the image, either the original image or the placeholder.
 */

function get_attachment_fallback($image = [], $screen_width = '', $max_width = '', $scale = false, $type = 'image'): string
{
    $placeholder = ($type === 'avatar') ? AVATAR_PLACEHOLDER : IMAGE_PLACEHOLDER;

    if (!$image || empty($image['image'])) {
        $wp_img = '<div class="h-full overflow-hidden image-wrapper">';
        $wp_img .= '<img src="' . $placeholder . '" width="1280" height="800" class="w-full h-full object-cover" alt=""/>';
        $wp_img .= '</div>';

        return $wp_img;
    }

    if (!isset($image['h_pos'])) {
        $image['h_pos'] = '50';
    }

    if (!isset($image['v_pos'])) {
        $image['v_pos'] = '50';
    }

    if (empty($image['fit'])) {
        $image['fit'] = 'cover';
    }

    ob_start();
    render_image($image, $screen_width, $max_width, $scale);
    $wp_img = ob_get_clean();

    return $wp_img;
}

/**
 * Redirect For Posts With External Link
 *
 */
function start_custom_redirect()
{
    if (is_single() && get_post_type() === 'post') {
        $post_id       = get_the_ID();
        $external_link = get_field('news_-_content_external_link', $post_id);

        if (!empty($external_link) && filter_var($external_link, FILTER_VALIDATE_URL)) {
            wp_redirect(esc_url($external_link), 301);
            exit();
        }
    }
}

add_action('template_redirect', 'start_custom_redirect');

/**
 * Use external link for posts
 *
 * @param string  $url  Post url
 * @param WP_Post $post Post object
 *
 * @return string
 */
function start_use_external_link_for_posts($url, $post): string
{
    if (is_a($post, 'WP_Post') && $post->post_type === 'post') {
        $external_link = get_field('news_-_content_external_link', $post);

        if (!empty($external_link)) {
            return esc_url($external_link);
        }
    }

    return $url;
}

add_filter('post_link', 'start_use_external_link_for_posts', 10, 2);
add_filter('post_type_link', 'start_use_external_link_for_posts', 10, 2);

/**
 * Display site logo
 *
 * @return string
 */
function get_start_logo($height = 'w-24 lg:w-48'): string
{
    $logo_image = '  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 1020 338"><g clip-path="url(#a)"><path fill="#2c8cff" d="M56.079 79.368 0 213.882h26.144l13.636-34.097h60.617l13.636 34.097h27.091L85.235 79.368H56.06zm-7.96 79.767 21.974-54.947 21.975 54.947zM210.091 115.93c-13.446 0-25.954 5.496-32.398 17.427v-15.153h-23.681v95.678h23.87v-51.156c0-16.29 10.045-25.957 24.06-25.957 14.772 0 21.785 9.667 21.785 23.114v53.999h24.059v-59.117c0-22.355-14.394-38.835-37.695-38.835M305.041 78.99l-23.87 12.689v26.525h-23.82v19.702h23.82v46.986c0 21.219 8.529 28.99 31.641 28.99h25.007v-20.081h-21.217c-8.529 0-11.551-3.033-11.551-11.363v-44.522h32.777v-19.702h-32.777V78.999zM696.954 184.893c0 21.218 8.528 28.989 31.64 28.989h25.007v-20.081h-21.217c-8.528 0-11.55-3.033-11.55-11.362v-44.522h32.777v-19.703h-32.777V79l-23.87 12.689v26.525h-21.825v19.703h21.825v46.986zM796.174 118.204h-23.87v95.678h23.87zM889.628 172.961c-2.085 13.836-12.688 22.166-25.765 22.166-14.962 0-27.092-11.173-27.092-28.99 0-17.816 11.94-28.989 27.092-28.989 11.182.189 20.458 6.065 23.491 16.29h25.196c-4.169-23.114-24.249-37.898-48.687-37.898-27.281 0-51.151 20.65-51.151 50.587s22.922 50.588 51.151 50.588c25.386 0 47.171-16.67 50.014-43.764h-24.249zM974.764 115.551c-24.818.189-41.296 13.268-45.655 30.316h25.575c3.033-7.013 10.614-10.983 20.459-10.983 11.74 0 19.7 6.065 20.458 16.859l-34.104 4.738c-24.438 3.412-35.809 13.827-35.809 31.454 0 15.532 13.067 28.611 37.126 28.611 14.204 0 26.713-5.118 33.535-15.533v12.879h22.921v-59.875c0-23.872-17.8-38.456-44.516-38.456zm20.837 57.41c0 14.216-11.94 24.82-28.987 24.82-10.234 0-16.099-5.496-16.099-11.741 0-7.961 5.875-12.131 16.289-13.637l28.797-4.17v4.738zM784.234 106.402c7.74 0 14.015-6.275 14.015-14.016s-6.275-14.016-14.015-14.016-14.015 6.275-14.015 14.016 6.275 14.016 14.015 14.016M727.396 309.869c-11.162-.09-19.421-7.532-19.421-20.421s8.618-20.51 19.421-20.42c7.801.089 14.244 4.08 16.329 11.073h15.611c-2.903-14.515-15.88-24.231-31.94-24.231-18.872 0-34.204 13.517-34.204 33.578s14.703 33.579 34.204 33.579c17.237 0 31.391-11.343 33.027-28.222H745.54c-1.356 9.347-8.618 15.153-18.144 15.064M789.091 274.295c-12.338 0-20.687 6.444-22.772 15.153h14.603c1.087-2.903 4.18-4.449 8.349-4.449 4.898 0 7.89 2.454 8.169 6.534l-15.79 2.354c-11.7 1.726-17.147 6.624-17.147 14.974 0 7.711 6.085 14.066 17.696 14.066 6.982 0 12.518-2.634 15.7-7.353v6.076h13.067v-28.581c0-11.891-8.618-18.784-21.865-18.784zm8.349 27.952c0 6.265-5.805 10.255-12.338 10.255-3.99 0-6.354-2.175-6.354-4.719 0-2.992 2.264-4.808 6.264-5.446l12.428-1.996zM849.698 274.204c-6.174 0-11.252 2.454-14.334 6.894v-5.537h-13.246v62.429h13.705v-20.511c3.172 3.632 7.89 5.447 13.606 5.447 11.8 0 22.144-9.896 22.144-24.321s-9.795-24.411-21.865-24.411zm-3.172 36.751c-6.264 0-11.162-4.898-11.162-11.981v-.728c0-7.073 4.808-11.981 11.162-11.981 6.713 0 11.342 4.898 11.342 12.34s-4.629 12.34-11.342 12.34zM926.376 257.056l-13.706 6.803v11.702h-11.341v11.163h11.341v19.782c0 10.614 4.08 15.153 16.149 15.153h13.067v-11.253h-10.164c-3.99 0-5.356-1.726-5.356-5.267v-18.425h15.51v-11.163h-15.51v-18.515zM972.369 274.295c-12.339 0-20.688 6.444-22.773 15.153h14.614c1.087-2.903 4.169-4.449 8.349-4.449 4.897 0 7.89 2.454 8.169 6.534l-15.79 2.354c-11.711 1.726-17.147 6.624-17.147 14.974 0 7.711 6.085 14.066 17.695 14.066 6.983 0 12.519-2.634 15.701-7.353v6.076h13.067v-28.581c0-11.891-8.618-18.784-21.865-18.784zm8.349 27.952c0 6.265-5.805 10.255-12.339 10.255-3.99 0-6.354-2.175-6.354-4.719 0-2.992 2.264-4.808 6.264-5.446l12.429-1.996zM1019.1 257.236h-13.7v64.424h13.7zM886.905 270.286a7.313 7.313 0 1 0-.001-14.625 7.313 7.313 0 0 0 .001 14.625M893.708 275.551h-13.706v46.118h13.706z"/><path fill="url(#b)" d="m404.052 172.392 28.797-4.17v4.738c0 14.216-11.94 24.82-28.987 24.82-10.234 0-16.099-5.496-16.099-11.741 0-7.961 5.875-12.121 16.289-13.637zm264.463-11.572c0 88.814-71.998 160.82-160.805 160.82-88.806 0-160.804-72.006-160.804-160.82C346.906 72.005 418.904 0 507.72 0c88.817 0 160.805 71.995 160.805 160.82zm-211.986-6.804c0-23.872-17.805-38.456-44.517-38.456-24.818.189-41.296 13.257-45.655 30.316h25.575c3.033-7.013 10.614-10.983 20.459-10.983 11.74 0 19.7 6.065 20.458 16.859l-34.104 4.738c-24.438 3.412-35.81 13.837-35.81 31.454 0 15.532 13.067 28.611 37.127 28.611 14.204 0 26.712-5.118 33.535-15.533v12.879h22.923v-59.875zm90.403-36.95h-13.606c-16.099.19-26.144 5.876-31.451 17.617v-16.48h-23.301v95.678h23.87v-48.123c.189-20.46 7.77-25.768 25.954-25.768h18.534zm108.187 55.894H630.87c-2.085 13.827-12.688 22.167-25.765 22.167-14.962 0-27.092-11.173-27.092-28.99s11.93-28.99 27.092-28.99c11.182.19 20.458 6.066 23.491 16.291h25.196c-4.169-23.114-24.249-37.898-48.687-37.898-27.281 0-51.151 20.65-51.151 50.587s22.922 50.587 51.151 50.587c25.386 0 47.171-16.669 50.014-43.764z"/></g><defs><linearGradient id="b" x1="621.424" x2="393.996" y1="47.106" y2="274.513" gradientUnits="userSpaceOnUse"><stop stop-color="#071359"/><stop offset=".12" stop-color="#0d2977"/><stop offset=".33" stop-color="#184ca7"/><stop offset=".53" stop-color="#2068cd"/><stop offset=".71" stop-color="#277be8"/><stop offset=".88" stop-color="#2a87f9"/><stop offset="1" stop-color="#2c8cff"/></linearGradient><clipPath id="a"><path fill="#fff" d="M0 0h1019.28v338H0z"/></clipPath></defs></svg> ';
    $logo = sprintf('<div class="%3$s" rel="home" title="%1$s" itemscope>%2$s</div>', get_bloginfo('name'), $logo_image, esc_attr($height));

    return $logo;
}


/**
 * Helper function to get list of social network icons
 *
 * @return string|string[]
 */
function get_social_icons($icon = '')
{
    $icons = [
        'linkedin'  => '<svg class="fill-current" viewBox="0 0 37 37"><path d="M32.14.81a4.02 4.02 0 0 1 4.02 4.02v28.13a4.02 4.02 0 0 1-4.02 4.01H4.02A4.02 4.02 0 0 1 0 32.96V4.83A4.02 4.02 0 0 1 4.02.81h28.12Zm-1 31.14V21.3a6.55 6.55 0 0 0-6.55-6.55c-1.7 0-3.7 1.05-4.66 2.62v-2.23h-5.6v16.81h5.6v-9.9a2.8 2.8 0 1 1 5.6 0v9.9h5.6ZM7.79 11.98a3.37 3.37 0 0 0 3.38-3.37 3.39 3.39 0 1 0-3.38 3.37Zm2.8 19.97V15.14H5.02v16.81h5.57Z"/></svg>',
        'facebook'  => '<svg class="fill-current" viewBox="0 0 11 20" aria-hidden="true"><path d="M3.05 11.25V20h3.74v-8.74h2.8l.53-3.63H6.8V5.3c0-1 .46-1.96 1.96-1.96h1.5V.25S8.89 0 7.58 0C4.84 0 3.04 1.74 3.04 4.87v2.76H0v3.62h3.05Z"/></svg>',
        'instagram' => '<svg class="fill-current" viewBox="0 0 17 17" aria-hidden="true"><path d="M12.03 0a4.89 4.89 0 0 1 3.6 1.4A4.92 4.92 0 0 1 17 4.97v7.06c0 1.47-.48 2.74-1.4 3.63A5.06 5.06 0 0 1 12 17H5a5 5 0 0 1-3.56-1.34A4.93 4.93 0 0 1 0 12V4.97C0 2 2 0 4.97 0h7.06Zm.03 1.58H5a3.5 3.5 0 0 0-2.5.89 3.41 3.41 0 0 0-.92 2.5V12c0 1.06.3 1.91.92 2.53.69.61 1.59.93 2.5.89h7c.91.04 1.81-.28 2.5-.89a3.35 3.35 0 0 0 .99-2.5V4.97c.02-.9-.3-1.8-.92-2.47a3.41 3.41 0 0 0-2.5-.92ZM8.5 4.08a4.39 4.39 0 1 1 0 8.78 4.39 4.39 0 0 1 0-8.78Zm0 1.57a2.83 2.83 0 0 0-2.81 2.81 2.83 2.83 0 0 0 2.81 2.82 2.83 2.83 0 0 0 2.81-2.82 2.83 2.83 0 0 0-2.81-2.8Zm4.56-2.67a1 1 0 1 1 0 1.99 1 1 0 0 1 0-1.99Z"/></svg>',
        'twitter'   => '<svg class="fill-current" viewBox="0 0 23 20" aria-hidden="true"><path d="M17.42 0h3.4L13.4 8.47 22.12 20H15.3l-5.35-6.99L3.83 20H.43l7.93-9.06L0 0h7l4.83 6.39L17.43 0Zm-1.19 17.97h1.88L5.98 1.92H3.96l12.27 16.05Z"/></svg>',
        'github'    => '<svg class="fill-current" viewBox="0 0 64 64" aria-hidden="true"><path d="M32 0C14 0 0 14 0 32c0 21 19 30 22 30c2 0 2-1 2-2v-5c-7 2-10-2-11-5c0 0 0-1-2-3c-1-1-5-3-1-3c3 0 5 4 5 4c3 4 7 3 9 2c0-2 2-4 2-4c-8-1-14-4-14-15q0-6 3-9s-2-4 0-9c0 0 5 0 9 4c3-2 13-2 16 0c4-4 9-4 9-4c2 7 0 9 0 9q3 3 3 9c0 11-7 14-14 15c1 1 2 3 2 6v8c0 1 0 2 2 2c3 0 22-9 22-30C64 14 50 0 32 0"/></svg>',
        'youtube'   => '<svg class="fill-current" aria-hidden="true" viewBox="0 0 24 17"><path d="M23.53,2.64c-.28-1.04-1.09-1.86-2.13-2.14-1.87-.51-9.39-.51-9.39-.51,0,0-7.52,0-9.39.51C1.59.78.78,1.6.5,2.64c-.5,1.89-.5,5.82-.5,5.82,0,0,0,3.93.5,5.82.28,1.04,1.09,1.83,2.13,2.1,1.87.51,9.39.51,9.39.51,0,0,7.52,0,9.39-.51,1.03-.28,1.85-1.06,2.13-2.1.5-1.89.5-5.82.5-5.82,0,0,0-3.93-.5-5.82h0ZM9.56,12.04v-7.15l6.28,3.57-6.28,3.57h0Z"/></svg>',
        'email'     => '<svg class="fill-current" viewBox="0 0 23 15" aria-hidden="true"><path d="M22.43.43H.57v1.64L11.5 9.35l10.93-7.28V.43Z"/><path d="M22.43 3.27 11.5 10.56.57 3.27V15h21.86V3.27Z"/></svg>',
        'share'     => '<svg class="stroke-current" viewBox="0 0 20 20" fill="none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7.5 6.9H6.2c-1 0-1.8.8-1.8 1.8v7.6c0 1 .8 1.8 1.8 1.8h7.5c1 0 2-.8 2-1.9V8.8c0-1-1-2-2-2h-1.2m0-2.4L10 1.9m0 0L7.5 4.4M10 1.9v10.6"/></svg>',
        'copy'      => '<svg class="stroke-current" viewBox="0 0 20 20" fill="none"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 7.2a3.7 3.7 0 0 1 1 6L8.3 17A3.8 3.8 0 0 1 3 11.7l1.4-1.4m11.2-.6L17 8.3A3.8 3.8 0 0 0 11.7 3L8 6.7a3.8 3.8 0 0 0 1 6"/></svg>',
    ];

    if ($icon) {
        return $icons[$icon];
    }

    return $icons;
}

/**
 * Get link URL for share button in social media
 *
 * @param int    $post_id Post ID that need to be shared
 * @param string $network Social network name: facebook, twitter, linkedin
 *
 * @return string
 */

function get_share_link_url($title = '', $link = '', $network = 'facebook'): string
{
    if (empty($link)) {
        return '';
    }

    $title     = urlencode($title);
    $url       = $network == 'link' ? esc_url($link) : urlencode($link);
    $share_url = '';

    switch ($network) {
        case 'facebook':
            $share_url = "https://www.facebook.com/sharer/sharer.php?u={$url}";
            break;
        case 'twitter':
            $share_url = "https://twitter.com/intent/tweet?url={$url}&text={$title}";
            break;
        case 'linkedin':
            $share_url = "https://www.linkedin.com/shareArticle/?mini=true&url={$url}&title={$title}";
            break;
    }

    return $share_url;
}

/**
 * Add custom styles to the TinyMCE visual editor.
 * Appends a custom stylesheet to the `content_css` setting of TinyMCE.
 *
 * @param array $settings TinyMCE settings array.
 */

function add_editor_style_to_tinymce($settings)
{
    $editor_style = get_template_directory_uri() . '/editor-style.css';

    if (!empty($settings['content_css'])) {
        $settings['content_css'] .= ',' . $editor_style;
    } else {
        $settings['content_css'] = $editor_style;
    }

    return $settings;
}

add_filter("tiny_mce_before_init", "add_editor_style_to_tinymce", 11);

/**
 * Create pagination
 *
 * @param WP_Query    $query
 * @param bool        $echo
 * @param null|string $base
 * @param array       $args
 *
 * @return string|void
 */
function starter_pagination($query = '', $base = null, $echo = true, $args = [])
{
    if (empty($query)) {
        global $wp_query;
        $query = $wp_query;
    }

    $big       = 999999999;
    $pagi_args = array(
        'base'      => $base ?: str_replace($big, '%#%', esc_url(explode('?', get_pagenum_link($big), 2)[0])),
        'format'    => 'page/%#%',
        'prev_next' => true,
        'prev_text' => '<span class="pagination-arrow"><svg class="w-5 h-5" viewBox="0 0 320 512"><path class="fill-current" d="M9.4 233.4a32.05 32.05 0 0 0 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L77.3 256 246.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z"/></svg></span>',
        'next_text' => '<span class="pagination-arrow"><svg class="w-5 h-5" viewBox="0 0 320 512"><path class="fill-current" d="M310.6 233.4a32.05 32.05 0 0 1 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg></span>',
        'current'   => max(1, $query->query_vars['paged']),
        'total'     => $query->max_num_pages,
        'type'      => 'array',
    );

    $args = !empty($_GET) ? array_merge($args, $_GET) : $args;
    if ($args) {
        foreach ($args as $key => $val) {
            $pagi_args['add_args'][$key] = $val;
        }
    }
    $links      = paginate_links($pagi_args);
    $pagination = '';

    if ($links) {
        // Add empty prev link
        if ($pagi_args['current'] == 1) {
            array_unshift($links, str_replace('pagination-arrow', 'pagination-arrow disabled', $pagi_args['prev_text']));
        }

        // Add empty next link
        if ($pagi_args['current'] !== 1 && $pagi_args['current'] == $pagi_args['total']) {
            $links[] = str_replace('pagination-arrow', 'pagination-arrow disabled', $pagi_args['next_text']);
        }

        $pagination = "<ul class='flex justify-center gap-4 mt-10 page-pagination'>\n\t<li>";
        $pagination .= implode("</li>\n\t<li>", $links);
        $pagination .= "</li>\n</ul>\n";
    }

    if ($echo) {
        echo $pagination;
    } else {
        return $pagination;
    }
}

/**
 * Function for media-element component
 */
function get_media_element($args): string
{
    $media_element    = $args['media_element'] ?? [];
    $ratio            = $args['ratio'] ?? '16:9';
    $autoplay         = $args['autoplay'] ?? false;
    $autoplay_scroll  = $args['autoplay_scroll'] ?? false;
    $background_block = $args['background_block'] ?? false;
    $autosize         = $args['autosize'] ?? false;

    ob_start();
    get_component('media-element', [
        'media_element'    => $media_element,
        'ratio'            => $ratio,
        'autoplay'         => $autoplay,
        'autoplay_scroll'  => $autoplay_scroll,
        'background_block' => $background_block,
        'autosize'         => $autosize,
    ]);

    $html = ob_get_clean();

    $element_without_comments = remove_html_comments($html);

    // Check if element is empty - output nothing
    return $element_without_comments ? $html : '';
}

/**
 * Loop Vimeo videos inserted via wp_oembed_get
 *
 * @param $provider
 * @param $url
 * @param $args
 *
 * @return mixed|string
 */
function loop_vimeo_videos($provider, $url, $args)
{
    if (!str_contains($provider, 'vimeo')) {
        return $provider;
    }

    $video_args = [];
    // If the video is used as a background, we need to set some specific parameters
    if (!empty($args['bg'])) {
        $video_args = [
            'loop'             => 1,
            'controls'         => 0,
            'muted'            => 1,
            'vimeo_logo'       => 0,
            'title'            => 0,
            'watch_full_video' => 0,
            'transcript'       => 0,
            'portrait'         => 0,
            'byline'           => 0,
            'quality_selector' => 0,
            'speed'            => 0,
            'pip'              => 0,
            'fullscreen'       => 0,
        ];
    }

    if (!empty($args['autoplay'])) {
        $video_args['autoplay'] = 1;
    }

    if ($video_args) {
        $provider = add_query_arg($video_args, $provider);
    }

    return $provider;
}

add_filter('oembed_fetch_url', 'loop_vimeo_videos', 10, 3);

/**
 * Add embed video Lazy Load
 */
add_filter('oembed_result', 'wp_filter_content_tags');

/**
 * Replace standard Gravity Forms submit input with button tag
 *
 * @param string $button HTML of the button
 * @param array  $form   Form object
 * @return mixed|string
 */
function prks_form_submit_button($button, $form)
{
    if ($form['button']['type'] == 'image' && !empty($form['button']['imageUrl'])) {
        return $button;
    }

    preg_match("~value=(?:\"|')(.*?)(?:\"|')~", $button, $matches);

    return str_replace(array('input', '/>', 'gform_button'), array('button', '>', 'gform_button gform-theme__disable-reset'), $button) . "{$matches[1]}</button>";
}

add_filter("gform_submit_button", "prks_form_submit_button", 10, 2);
add_filter("gform_next_button", "prks_form_submit_button", 10, 2);
add_filter("gform_previous_button", "prks_form_submit_button", 10, 2);

/**
 * Distribution of filter locations
 *
 * @param array $facets
 * @param array $location
 * @param object $search_filter
 * @return string
 */
function prsk_filter_distribution(array $facets, array $location, object $search_filter): string
{
    $html = '';

    if (empty($facets)) {
        return $html;
    }

    foreach ($facets as $name => $facet) {
        if (empty($facet)) {
            continue;
        }

        $id = !empty($facet['id']) ? $facet['id'] : '';
        $facet_class = !empty($facet['class']) ? $facet['class'] : '';
        $facet_location = !empty($facet['location']) ? $facet['location'] : 'all-bar';
        $enable = isset($facet['enable']) ? $facet['enable'] : true;
        if ($enable && $id && $facet_class && in_array($facet_location, $location)) {
            ob_start(); ?>
            <div class="<?php echo esc_attr($facet_class) ?>">
                <div class="force-active <?php echo esc_attr($name) ?>">
                    <?php $search_filter->render_facet($id); ?>
                </div>
            </div>
<?php $html .= ob_get_clean();
        }
    }

    return $html;
}
