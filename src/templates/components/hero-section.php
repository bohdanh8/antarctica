<?php
$slide = $args; // Get slide array data that was passed on.
?>
<div class="relative h-full px-6 lg:px-8 py-4 lg:py-32  ease-btm" data-scroll>

    <div class="absolute top-0 right-0 bottom-0 left-0 z-0 backdrop">
        <?php echo get_attachment_fallback($slide['image']); ?>
    </div><!-- .backdrop -->

    <div class="absolute top-0 right-0 bottom-0 left-0 z-10 bg-gray-900/60"></div>

    <div class="z-50 relative text-center container">
        <?php if (!empty($slide['heading'])): ?>
            <h2 class="font-bold text-white text-4xl tracking-tight sm:text-6xl">
                <?php echo esc_html($slide['heading']); ?>
            </h2>
        <?php endif; ?>

        <?php if (!empty($slide['text'])): ?>
            <p class="mt-6 text-gray-300 text-lg leading-8">
                <?php echo wp_kses_post($slide['text']); ?>
            </p>
        <?php endif; ?>

        <?php if (!empty($slide["button"])): ?>
            <?php echo get_button($slide["button"], "button") ?>
        <?php endif; ?>
    </div>
</div>