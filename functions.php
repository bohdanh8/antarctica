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
function get_start_logo($height = 'w-24 lg:w-40'): string
{
    $logo_image = '  <svg class="block" fill="none" viewBox="0 0 163 42">
  <path fill="#394149" d="M30.21 17.72c3.14 0 3.84 1.36 3.84 3.06 0 1.8-.85 3.1-3.83 3.1-2.95 0-3.81-1.22-3.81-3.1 0-1.85.93-3.06 3.8-3.06Zm32.79 0c3.14 0 3.85 1.36 3.85 3.06 0 1.8-.86 3.1-3.83 3.1-2.96 0-3.82-1.22-3.82-3.1 0-1.85.94-3.06 3.8-3.06Z" class="ccustom"/>
  <path fill="#394149" fill-rule="evenodd" d="M2.43 38.5V3.05H161V38.5H2.44Zm75.57-2h81V5.05H78V36.5Zm-47.77-9.6c5.57 0 7.9-2.41 7.9-6.16 0-3.82-2.63-6.08-7.9-6.08-5.2 0-7.93 2.46-7.93 6.08 0 4.08 2.86 6.15 7.93 6.15ZM10.86 14.92V26.7H22.1v-3.14h-7.18v-8.64h-4.06ZM50.72 26.7l-.1-1.14a7.2 7.2 0 0 1-4.69 1.32c-2.5 0-4.6-.75-5.76-2.26a6.2 6.2 0 0 1-1.12-3.79 5.86 5.86 0 0 1 1.15-3.68c1.18-1.47 3.33-2.44 6.53-2.44 3.68 0 5.84 1.12 6.77 3.01.2.45.32.93.35 1.41h-3.9a1.6 1.6 0 0 0-.52-.75 4.14 4.14 0 0 0-2.63-.67 3.87 3.87 0 0 0-3.03.95 3.26 3.26 0 0 0-.62 2.2c-.05.75.15 1.5.58 2.12a3.94 3.94 0 0 0 3.1 1.04 4.35 4.35 0 0 0 3.1-.97c.18-.23.31-.5.37-.8h-4.19v-2.53h7.84v6.98h-3.23Zm12.3.18c5.57 0 7.91-2.4 7.91-6.15 0-3.82-2.64-6.08-7.91-6.08-5.2 0-7.93 2.46-7.93 6.08 0 4.08 2.87 6.15 7.93 6.15Z" class="ccustom" clip-rule="evenodd"/>
  <path fill="#394149" d="M84.86 26.67V14.88h2.9v11.79h-2.9Zm17.79-4.93c-.74.96-2 1.4-3.78 1.41l-5.37-.01v3.53h-2.83V14.88h8.2a4.7 4.7 0 0 1 3.64 1.19c.65.84.97 1.9.9 2.95.06.97-.2 1.93-.76 2.72Zm-2.33-3.84c-.3-.45-.94-.7-2.04-.7h-4.79v3.59h4.76c1.17 0 1.79-.24 2.07-.7a2 2 0 0 0 .21-1.07c.03-.39-.05-.77-.2-1.12Zm11.44 8.95c-5.34 0-6.98-2-6.98-3.98h3.03c0 .97 1.34 1.71 4.09 1.71 2.73 0 3.45-.48 3.45-1.26 0-.87-.54-1.14-3.08-1.43-.5-.04-1.86-.2-2.37-.28-3.6-.4-4.98-1.47-4.98-3.38 0-2.01 2.02-3.53 6.42-3.53 4.78 0 6.61 1.88 6.61 3.83h-3c0-1-1.13-1.56-3.78-1.56-2.74 0-3.32.37-3.32 1.1 0 .77.6 1.02 3.5 1.36.66.1 2.13.26 2.54.3 3.06.32 4.44 1.43 4.44 3.4 0 2.34-2.1 3.72-6.57 3.72Zm15.11-.02c-3.92 0-6.47-1.54-6.47-4.8v-7.15h2.87v7.2c0 1.48 1.21 2.47 3.72 2.47 2.27 0 3.62-.93 3.62-2.48v-7.19h2.84v7.42c0 2.96-2.38 4.53-6.58 4.53Zm22.12-.16V18.8l-3.68 7.87h-2.8l-3.57-7.87v7.87h-2.7V14.88h3.66l4.05 8.98 4.15-8.98h3.6v11.79h-2.71Z" class="ccustom"/>
</svg>';

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
