<?php

/**
 * Helper class for the WP Grid Builder Plugin.
 * 
 * *** DO NOT EDIT ***
 * 
 * Usage:
 * 
 * <?php
 * 
 *  $podcast_filter = new WPGB_Search_Filter([
 *       'query_args' => [
 *           'post_type' => 'podcast',
 *           'posts_per_page' => 5,
 *           'tax_query' => [
 *               [
 *                   'taxonomy' => 'podcast-topic',
 *                   'field' => 'id',
 *                   'terms' => [get_sub_field('podcast_topic')]
 *               ]
 *           ],
 *           'orderby' => 'date',
 *           'order' => 'DESC',
 *       ],
 *       'results_component' => [
 *           'name' => 'podcast-card',
 *           'args' => ['link' => true]
 *       ],
 *       'noresults_component' => [
 *           'name' => 'no-results-message'
 *       ]
 *   ]);
 *
 *   ?>
 *   <div class="two-col flex gap-x-[20px]">
 *       <div class="filter w-[250px] flex-shrink-0">
 *           <div class="podcast-search">
 * 
 *               <?php $podcast_filter->render_facet(6) ?>
 * 
 *           </div>
 *           <div class="podcast-topic">
 * 
 *               <?php $podcast_filter->render_facet(2) ?>
 * 
 *           </div>
 *           <div class="podcast-allocator-type">
 * 
 *               <?php $podcast_filter->render_facet(3) ?>
 * 
 *           </div>
 *           <div class="podcast-show">
 * 
 *               <?php $podcast_filter->render_facet(4) ?>
 * 
 *           </div>
 *       </div><!-- .filter -->
 *       <div class="podcast-content">
 * 
 *           <?php $podcast_filter->render_results(); ?>
 * 
 *           <div class="pagination">
 * 
 *               <?php $podcast_filter->render_facet(5) ?>
 * 
 *           </div>
 *       </div>
 *   </div><!-- .two-col -->
 *
 * Additional Notes:
 * -----------------
 * 
 * Use the element id 'wpgb-search-filter-start' to scroll to a specific section after a filter is selected. 
 * Ex: <a id='wpgb-search-filter-start'></a>
 * 
 * @author Kaveen Goonawardane
 *  
 * @since 1.2.0 Initial release
 * 
 * @var $id Unique ID when the class is instantiated.
 * @var $template_name Unique template name.
 * @var $query_args WP_Query args.
 * @var $results_component Component name and args that will be used to display the results within the loop.
 * @var $noresults_component Component name and args that will render for when the search criteria doesn't yield any results.
 */
class WPGB_Search_Filter
{
    protected $id;
    protected $template_name;
    protected $query_args;
    protected $results_component;
    protected $noresults_component;

    public function __construct($args)
    {
        $this->id = spl_object_id($this);
        $this->template_name = $this->id . '_wpgb_template';

        if (!empty($args['query_args'])) {
            $this->query_args = $args['query_args'];
        }
        if (!empty($args['results_component'])) {
            $this->results_component = $args['results_component'];
        }
        if (!empty($args['noresults_component'])) {
            $this->noresults_component = $args['noresults_component'];
        }

        if (!empty($args['query_args']) && !empty($args['results_component'])) {

            $templates_transient = get_transient('wp_search_filter_templates');

            if (!empty($templates_transient) && is_array($templates_transient)) {

                if (!in_array($this->template_name, $templates_transient)) {
                    set_transient('wp_search_filter_templates', array_merge($templates_transient, [
                        $this->template_name => [
                            'class'              => 'wpgb-grid-' . $this->id,
                            'source_type'        => 'post_type',
                            'is_main_query'      => false,
                            'query_args'         => $this->query_args,
                            'render_callback'    => [$this, 'results_callback'],
                            'noresults_callback' => [$this, 'noresults_callback'],
                        ]
                    ]), DAY_IN_SECONDS);
                }
            } else {

                set_transient('wp_search_filter_templates', [
                    $this->template_name => [
                        'class'              => 'wpgb-grid-' . $this->id,
                        'source_type'        => 'post_type',
                        'is_main_query'      => false,
                        'query_args'         => $this->query_args,
                        'render_callback'    => [$this, 'results_callback'],
                        'noresults_callback' => [$this, 'noresults_callback'],
                    ]
                ], DAY_IN_SECONDS);
            }
        }
    }

    /**
     * Display the Search/Filter results using the selected component.
     *
     * @author Kaveen Goonawardane
     *  
     * @since 1.2.0 Initial release
     *
     */
    public function render_results()
    {
        ob_start();
?>
        <div class="wpgb-search-filter-results relative ">
            <?php wpgb_render_template($this->template_name); ?>
            <div class="wpgb-loader">
                <div class="wpgb-loader-12">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
<?php
        echo ob_get_clean();
    }

    /**
     * Display the Facet that was created in the Grid Builder.
     *
     * @author Kaveen Goonawardane
     *  
     * @since 1.2.0 Initial release
     *
     * @param int $facet_id
     *
     */
    public function render_facet($facet_id = 0)
    {
        if (!empty($facet_id)) {

            wpgb_render_facet(
                [
                    'id'   => $facet_id,
                    'grid' => $this->template_name,

                ]
            );
        } else {
            echo __('Missing Facet ID');
        }
    }

    /**
     * Display the results section.
     *
     * @author Kaveen Goonawardane
     *  
     * @since 1.2.0 Initial release
     *
     */
    public function results_callback()
    {
        if (!empty($this->results_component['args'])) {

            get_component($this->results_component['name'], $this->results_component['args']);
        } else {

            get_component($this->results_component['name']);
        }
    }

    /**
     * Display the noresults section.
     *
     * @author Kaveen Goonawardane
     *  
     * @since 1.2.0 Initial release
     *
     */
    public function noresults_callback()
    {
        if (!empty($this->noresults_component)) {
            if (!empty($this->noresults_component['args'])) {

                get_component($this->noresults_component['name'], $this->noresults_component['args']);
            } else {

                get_component($this->noresults_component['name']);
            }
        } else {
            echo "No results found";
        }
    }
}
