<?php
$heading = get_sub_field('heading_with_text_area') ?? '';
$sub_heading = get_sub_field('basic_text_input') ?? '';
$text = get_sub_field('text_with_rich_editor') ?? '';
$image = get_sub_field('image') ?? [];

?>

<div class="container">
    <?php if ($heading || $sub_heading): ?>
        <div class="flex lg:flex-row flex-col justify-between lg:gap-8 mb-8">
            <?php if ($heading): ?>
                <h2 class="xl:w-1/2 ease-left" data-scroll><?php echo $heading; ?></h2>
            <?php endif; ?>
            <?php if ($sub_heading): ?>
                <h6 class="ease-right lg:mt-5 xl:w-2/6" data-scroll><?php echo $sub_heading; ?></h6>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <?php if ($text): ?>
        <div class="lg:w-4/6 ease-btm" data-scroll>
            <?php echo $text; ?>
        </div>
    <?php endif; ?>
    <?php if ($image): ?>
        <div class="mt-8 lg:mt-16 w-full h-full aspect-[3/1] ease-btm" data-scroll>
            <?php echo render_image($image); ?>
        </div>
    <?php endif; ?>
</div><!-- .container -->