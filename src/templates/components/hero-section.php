<?php
$slide = $args; // Get slide array data that was passed on.
?>
<div class="px-0 pt-12 pb-6 lg:pb-[4.5rem] ease-btm" data-scroll>

    <div class="text-left container pt-0 pb-12 lg:pb-[4.75rem]">
        <?php if (!empty($slide['heading'])): ?>
            <h1 class="font-light my-0 text-navy-blue">
                <?php echo esc_html($slide['heading']); ?>
            </h1>
        <?php endif; ?>

        <?php if (!empty($slide['text'])): ?>
            <h4 class="font-light mt-12 mb-0 text-navy-blue max-w-[67.688rem]">
                <?php echo wp_kses_post($slide['text']); ?>
            </h4>
        <?php endif; ?>
    </div>

    <div class="h-[755px]">
        <?php echo get_attachment_fallback($slide['image']); ?>
    </div>

</div>