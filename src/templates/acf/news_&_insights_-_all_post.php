<div class="container">
    <?php $heading = get_sub_field("heading"); ?>
    <?php $text = get_sub_field("text"); ?>
    <?php if ($heading || $text): ?>
        <div class="mb-10">
            <?php if ($heading = get_sub_field("heading")): ?>
                <h2 class="ease-left" data-scroll><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>

            <?php if ($text = get_sub_field("text")): ?>
                <h6 class="ease-left" data-scroll><?php echo wp_kses_post($text); ?></h6>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php get_component('search-filter-template', [
        'query_args' => [
            'post_type' => 'post',
            'posts_per_page' => 6,
            'orderby' => 'date',
            'order' => 'DESC',
        ],
        'type' => 'blog',
        'facets' => [
            'custom-dropdown' => [
                'location' => 'top-bar',
                'id' => 3,
                'class' => 'col-span-12 md:col-span-6 lg:col-span-3 col-start-1',
            ],
            'search' => [
                'location' => 'top-bar',
                'id' => 1,
                'class' => 'col-span-12 md:col-span-6 md:col-start-7 lg:col-span-3 lg:col-start-10',
            ],
            'members-radio-buttons' => false,
        ],
        'template' => 'loop-news',
        'grid_class' => '',
        'load_pagination_id' => 2,
        'side_bar_enable' => false,
        'top-bar' => true,
    ]);
    ?>
</div><!-- .container -->