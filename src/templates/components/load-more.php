<?php
/**
 * @var array{label: string} $args
 */
$index = isset($args['index']) ? $args['index'] : 0;
?>

<div class="text-center mt-8 sm:mt-16 col-span-full">
    <button data-index="<?php echo $index; ?>" class="button button-alt js-load-more"><?php _e('Load more', 'prosekwptheme'); ?></button>
</div>