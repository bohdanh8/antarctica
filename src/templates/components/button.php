<?php
/**
 * @var array{
 *     button:array,
 *     class: string,
 *     sub_field: bool,
 * } $args Template args
 */
$class = !empty($args['class']) ? $args['class'] : 'button';

$button = $args['button'];
$link_type = $button['link_type'];
$link_source = $button['link_source'];
$link_id = $button['link_' . $link_source] ?? null;

$link = false;
if ($link_type == 'int' && $link_source == 'media') {
    $link = $link_id;
} elseif ($link_type == 'int' && $link_id) {
    $link = $link_source == 'cat' ? get_term_link($link_id, 'product_cat') : get_the_permalink($link_id);
    $link_text = $button['link_text'] ?? '';
} elseif ($link_type == 'ext') {
    $ext_link = $button['ext_link'];
    $link = $ext_link;
}

if (in_array($link_type, ['int', 'modal']) && $link):
    $link_text = $button['link_text'];
    if (!$link_text) {
        if ($link_source == 'cat') {
            $term = get_term($link_id);
            $link_text = $term && !is_wp_error($term) ? $term->name : __('Read more', 'prosekwptheme');
        } else {
            $link_text = get_the_title($link_id);
        }
    }
    $target = $link_source == 'media' ? 'target="_blank"' : '';
    ?>
    <a href="<?php echo esc_url($link); ?>" class="<?php echo esc_attr($class); ?>" <?php echo esc_attr($target); ?>
       aria-label="<?php echo strip_tags($link_text); ?>"><?php echo wp_kses_post($link_text); ?></a>
<?php elseif ($link_type == 'ext' && $link): ?>
    <a href="<?php echo esc_url($link['url']); ?>" aria-label="<?php echo strip_tags($link['title']); ?>"
       class="<?php echo $class; ?>" <?php echo $link['target'] ? 'target="_blank"' : ''; ?>>
        <?php echo wp_kses_post($link['title']); ?>
    </a>
<?php endif; ?>
