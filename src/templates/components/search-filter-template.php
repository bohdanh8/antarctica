<?php if (class_exists('WPGB_Search_Filter') && !empty($args['query_args']) && !empty($args['type']) && !empty($args['facets'])) :

    $template = !empty($args['template']) ? $args['template'] : 'results-list-item';
    $grid_class = !empty($args['grid_class']) ? $args['grid_class'] : 'default-grid';
    $facets = !empty($args['facets']) ? $args['facets'] : '';
    $side_bar_enable = isset($args['side_bar_enable']) ? $args['side_bar_enable'] : false;
    $top_bar_enable = isset($args['top_bar_enable']) ? $args['top_bar_enable'] : true;
    $load_pagination_id = isset($args['load_pagination_id']) ? $args['load_pagination_id'] : '';
    $type = $args['type'];

    $search_filter = new WPGB_Search_Filter([
        'query_args' => $args['query_args'],
        'results_component' => [
            'name' => $template,
            'args' => [
                'type' => $args['type'],
                'link' => true
            ]
        ],
        'noresults_component' => [
            'name' => 'no-results'
        ]
    ]);

?>
    <div class="gap-x-2 gap-y-4 md:gap-8 grid grid-cols-12 ease-btm two-col" data-scroll>
        <?php if ($side_bar_enable): ?>
            <div class="col-span-3 filter-wrapper sidebar-filter">
                <div class="filter">
                    <?php echo prsk_filter_distribution($facets, ['side-bar', 'all-bar'], $search_filter) ?>
                </div><!-- .filter -->
            </div><!-- .filter-wrapper -->
        <?php endif; ?>


        <div class="group flex-1 filter-results-wrapper <?php echo $side_bar_enable ? 'col-span-9' : 'col-span-full' ?> ">
            <?php if ($top_bar_enable): ?>
                <div class="top-bar items-center gap-x-2 gap-y-4 md:gap-8 grid grid-cols-12 mb-9 [&_fieldset]:mb-0">
                    <?php echo prsk_filter_distribution($facets, ['top-bar', 'all-bar'], $search_filter) ?>
                </div><!-- .top-bar -->
            <?php endif; ?>


            <div class="<?php echo $grid_class; ?>">

                <?php $search_filter->render_results(); ?>
                
                <?php if ($load_pagination_id): ?>
                    <div class="flex justify-center mt-9 load-pagination">
                        <?php $search_filter->render_facet($load_pagination_id) ?>
                    </div>
                <?php endif; ?>


            </div>

        </div><!-- .filter-results-wrapper -->

    </div><!-- .two-col -->

<?php endif; ?>