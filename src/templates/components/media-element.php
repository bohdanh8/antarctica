<?php

/**
 * @var array{
 *    media_element: array{
 *       media_element_type: string,
 *       image: array,
 *       video_type: string,
 *       video_local: string,
 *       video_embed: string,
 *       video_overlay: bool,
 *       video_scale: numeric,
 *       vertical_position: numeric,
 *       horizontal_position: numeric,
 *    },
 *    ratio: string,
 *    background_block: string,
 *    autoplay: bool,
 *    autoplay_scroll: bool
 * } $args
 */

$ratio           = $args['ratio'] ?? '16:9';
$media_element   = $args["media_element"] ?? [];
$autoplay        = $args["autoplay"] ?? false;
$autoplay_scroll = $args["autoplay_scroll"] ?? false;
$autosize        = $args["autosize"] ?? false;
$media           = '';
$video_type      = $media_element["video_type"] ?? "local";

// Media element overlay
$overlay_class = '';
if (!empty($media_element["video_overlay"])) {
    $overlay_class = ' after:absolute after:inset-0 after:bg-black/35 after:z-20';
}

$media_type = $media_element["media_element_type"] ?? "image";

// Media element placement
$scale       = $media_element["scale"] ?? 1;
$y_position  = $media_element['v_pos'] ?? 50;
$x_position  = $media_element['h_pos'] ?? 50;
$translate_y = $y_position * -1 . '%';
$translate_x = $x_position * -1 . '%';

ob_start();
if ($media_type === "image") {
    $image_element = [
        'image' => $media_element['image'] ?? [],
        'h_pos' => $y_position,
        'v_pos' => $x_position,
        'scale' => $scale * 100,
    ];

    echo render_image($image_element, '50vw', '800px', true);
} elseif (!empty($media_element["video_{$video_type}"])) {
    $video = $media_element["video_{$video_type}"];
    if ($video_type === "local") {
        if ($autoplay || $autoplay_scroll) {
            $autoplay_attr = $autoplay ? ' autoplay playsinline' : '';
            echo "<video {$autoplay_attr} preload='none' muted='muted' loop='loop'>";
        } else {
            echo "<video controls>";
        }

        echo "<source src='" . esc_url($video) . "' type='video/mp4'>";
        echo "</video>";
    } else {
        echo wp_oembed_get($video, ['bg' => $autoplay || $autoplay_scroll ? 1 : 0, 'autoplay' => $autoplay ? 1 : 0]);
    }
}
$media = ob_get_clean();

if ($media):
    $ratio_parts = explode(':', $ratio);
    // Get media element dimensions for a proper aspect ratio
    $width           = preg_match('/width="([0-9]+)"/', $media, $matches) ? $matches[1] : $ratio_parts[0];
    $height          = preg_match('/height="([0-9]+)"/', $media, $matches) ? $matches[1] : $ratio_parts[1];
    $aspect          = "{$width}/{$height}";
    $video_box_class = 'video-holder overflow-hidden relative top-0 left-0 w-full h-full ';
    $video_box_class .= $autosize ? ' aspect-[--prks-media-aspect] [&_iframe]:w-full [&_iframe]:h-full' : '';
    $video_box_class .= $autoplay_scroll ? ' autoplay-video' : '';
    $video_box_class .= $overlay_class;
?>
    <div class="<?php echo esc_attr($video_box_class); ?>" style=" --prks-media-aspect:<?php echo esc_attr($aspect); ?>">
        <div class="absolute top-[--prks-video-y-pos] left-[--prks-video-x-pos]  aspect-[--prks-media-aspect] [&_iframe]:aspect-[--prks-media-aspect] origin-[--prks-video-transform-origin] transform responsive-embed video-holder__media"
            style="--tw-scale-x:<?php echo esc_attr($scale); ?>!important; --tw-scale-y:<?php echo esc_attr($scale); ?>!important; --tw-translate-y:<?php echo esc_attr($translate_y); ?>!important; --tw-translate-x:<?php echo esc_attr($translate_x); ?>!important; --prks-video-x-pos: <?php echo (int)$x_position . '%' ?>; --prks-video-y-pos: <?php echo (int)$y_position . '%' ?>; --prks-video-transform-origin: <?php echo (int)$x_position . '% ' . (int)$y_position . '%'; ?>;"
            data-ratio="<?php echo esc_attr($aspect); ?>">
            <?php echo $media; ?>
        </div>
    </div>
<?php endif; ?>