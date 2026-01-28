<?php
$get_in_touch = get_sub_field('get_in_touch');
$eyebrow = ! empty($get_in_touch['eyebrow']) ? $get_in_touch['eyebrow'] : '';
$heading = ! empty($get_in_touch['heading']) ? $get_in_touch['heading'] : '';
$text_area = ! empty($get_in_touch['text_area']) ? $get_in_touch['text_area'] : '';
$button = ! empty($get_in_touch['button']) ? $get_in_touch['button'] : '';
$button_html = get_button($button, 'button button-alt');
?>

<?php if ($eyebrow || $heading || $text_area): ?>
    <div class="container max-w-full w-full m-0 p-0 bg-[image:var(--gradient-45)]">
        <div class="container pt-36 pb-36 ease-left" data-scroll>
            <?php if ($eyebrow): ?>
                <p class="text-white text-[14px] font-bold uppercase mt-0 mb-[3.125rem] pt-4 border-t border-white"><?php echo esc_html($eyebrow); ?></p>
            <?php endif; ?>
            <?php if ($heading): ?>
                <h1 class="text-white font-light mt-0 mb-8"><?php echo esc_html($heading); ?></h1>
            <?php endif; ?>
            <div class="flex flex-col items-start gap-6 md:flex-row md:gap-6 md:items-end md:justify-between">
                <?php if ($text_area): ?>
                    <h4 class="text-white font-light my-0"><?php echo wp_kses_post($text_area); ?></h4>
                <?php endif; ?>
                <?php if ($button) : ?>
                    <?php echo $button_html; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php endif; ?>