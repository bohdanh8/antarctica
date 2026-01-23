<?php
$blog_page = get_option('page_for_posts');
$page_id   = $blog_page && is_home() ? $blog_page : get_the_ID();

$banner          = get_field('cta_banner', 'options');
$footer_settings = is_search() || is_archive() ? $banner : get_field('footer_section', $page_id);

$heading = !empty($footer_settings['heading']) ? $footer_settings['heading'] : ($banner['heading'] ?? '');

$text = !empty($footer_settings['text']) || !empty($footer_settings['heading']) ? $footer_settings['text'] : ($banner['text'] ?? '');

$page_button = $footer_settings['button']['button'] ?? [];
$button      = !empty($page_button['link_text']) ? $page_button : (!empty($banner['button']['link_text']) ? $banner['button'] : null);

$banner_hide = is_search() ? true : !empty($footer_settings['enable']);

if ($banner_hide): ?>
    <?php if ($heading || $text || $button): ?>
        <div class="bg-prosek-dull-gold ease-btm" data-scroll>
            <div class="container">
                <?php if ($heading): ?>
                    <h4 class="max-lg:[&_br]:hidden"><?php echo wp_kses_post($heading); ?></h4>
                <?php endif; ?>

                <?php if ($text): ?>
                    <p class="max-lg:[&_br]:hidden"><?php echo wp_kses_post($text); ?></p>
                <?php endif; ?>

                <?php if ($button): ?>
                    <div>
                        <?php echo get_button($button, "button button-alt"); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>