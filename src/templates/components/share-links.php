<?php
/**
 * @var array{title:string, link:string} $args
 */

$title = !empty($args['title']) ? $args['title'] : '';
$link  = !empty($args['link']) ? $args['link'] : get_permalink();

$copied_class = 'js-copy-button relative
  after:content-[""] after:absolute after:-top-5 after:right-1 after:w-2.5 after:h-2.5 after:bg-black after:rotate-45 after:pointer-events-none after:hidden
  before:content-["Copied"] before:text-white before:absolute before:-top-12 before:-right-full before:bg-black before:px-2.5 before:py-2 before:rounded-xl before:text-sm before:pointer-events-none before:hidden
  [&.active]:before:block [&.active]:after:block';
?>

<ul class="flex gap-4 items-center mt-10">
    <?php
    $share_icons    = get_social_icons();
    $share_target   = [
        'linkedin',
        'twitter',
        'facebook',
        'share',
        'copy'
    ];

    foreach ($share_target as $network):
        $href = esc_url(get_share_link_url($title, $link, $network));
        $title_attr = esc_attr($title);
        $is_button  = in_array($network, ['share', 'copy']);
        $tag        = $is_button ? 'button' : 'a';
        $js_class   = $is_button ? "js-{$network}-button" : 'js-share-link';

        $class = 'block w-5 h-5 [&_svg]:h-full [&_svg]:w-full [&_svg]:object-contain hover:text-prosek-orange ' . $js_class;
        $class .= $network === 'copy' ? ' ' . $copied_class : '';

        $attributes = 'class="' . esc_attr($class) . '" data-url="' . esc_attr($link) . '"';
        if (!$is_button) {
            $attributes .= ' href="' . $href . '" data-title="' . $title_attr . '" target="_blank"';
        }
        ?>
        <li>
            <?php echo "<{$tag} {$attributes}>"; ?>
            <?php echo $share_icons[$network] ?? $network; ?>
            <?php echo "</{$tag}>"; ?>
        </li>
    <?php endforeach; ?>
</ul>


