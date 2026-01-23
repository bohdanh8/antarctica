<?php
/**
 * @var array{is_header: bool} $args
 */
$is_compact   = $args['is_compact'] ?? false;
$form_class   = $is_compact ? 'js-search-box' : '';
$button_class = $is_compact ? 'js-search-toggle relative my-[1px]' : 'absolute right-0 top-1/2 -translate-y-1/2';
$block_class  = $is_compact ? 'search-form lg:w-0 lg:[&.is-active]:w-60 overflow-hidden transition-[width] duration-700 lg:absolute lg:right-0 lg:top-1/2 lg:-translate-y-1/2 h-full' : 'w-full';
?>
<form class="search-box relative overflow-visible flex <?php echo $form_class; ?>"
    method="get" action="<?php echo esc_url(home_url('/')); ?>">
    <div class="<?php echo $block_class; ?>">
        <label for='search' class='sr-only'><?php _e('Search', 'prosekwptheme'); ?></label>
        <input name="s" id='search' value='<?php echo get_search_query(); ?>'
            class="flex-1 w-full h-full p-2.5 border-b border-b-current outline-none text-ellipsis sm:pr-10 sm:pl-2 xl:pl-4"
            data-type='search' type="text" placeholder="<?php _e('Search', 'prosekwptheme'); ?>">
    </div>

    <button type="submit" name="submit" class="p-2 z-10 bg-white <?php echo $button_class; ?>">
        <svg viewBox="0 0 40 40" class="fill-current w-5 h-5 sm:w-6 sm:h-6">
            <path
                d="M16.44 3.5a12.94 12.94 0 1 0 0 25.88 12.94 12.94 0 0 0 0-25.88ZM.5 16.44A15.94 15.94 0 1 1 28.72 26.6L39.12 37 37 39.12l-10.4-10.4A15.94 15.94 0 0 1 .5 16.44Z" />
        </svg>
    </button>
</form>
