<?php

/**
 * WP Grid Builder Code Stub
 */

/**
 * Render template
 *
 * @since 1.0.0
 *
 * @param array  $args     Template paramters.
 * @param string $abstract Abstract class method to call.
 */
function wpgb_render_template($args, $abstract = 'render')
{
}

/**
 * Refresh template asynchronously
 *
 * @since 1.0.0
 *
 * @param array $args Template paramters.
 * @return string
 */
function wpgb_refresh_template($args)
{
}

/**
 * Render facet
 *
 * @since 1.0.0
 *
 * @param array $args Facet paramters.
 * @return string
 */
function wpgb_render_facet($args)
{
}

/**
 * Refresh facets asynchronously
 *
 * @since 1.0.0
 *
 * @param array   $args   Facet parameters.
 * @param boolean $render Whether to render facet HTML.
 * @return string|null
 */
function wpgb_refresh_facets($args = [], $render = true)
{
}

/**
 * Search facet choices asynchronously
 *
 * @since 1.4.1
 *
 * @param array $args Facet parameters.
 * @return string|null
 */
function wpgb_search_facet_choices($args = [])
{
}

/**
 * Get facets instance
 *
 * @since 1.0.0
 *
 * @return object.
 */
function wpgb_get_facets_instance()
{
}

/**
 * Get Filter instance
 *
 * @since 1.0.0
 *
 * @return object.
 */
function wpgb_get_filter_instance()
{
}

/**
 * Get selected facet values
 *
 * @since 1.0.0
 *
 * @param  string $slug Facet slug.
 * @return array Selected facet values.
 */
function wpgb_get_selected_facet_values($slug = '')
{
}

/**
 * Check if there are at least one facet selected for the current query
 *
 * @since 1.0.0
 *
 * @return boolean
 */
function wpgb_has_selected_facets()
{
}

/**
 * Get query strings
 *
 * @since 1.0.0
 *
 * @return array
 */
function wpgb_get_query_string()
{
}

/**
 * Get filtered query variables
 *
 * @since 1.0.0
 *
 * @return array
 */
function wpgb_get_filtered_query_vars()
{
}

/**
 * Get unfiltered query variables
 *
 * @since 1.0.0
 *
 * @return array
 */
function wpgb_get_unfiltered_query_vars()
{
}

/**
 * Get current object type (query type)
 *
 * @since 1.0.0
 *
 * @return string
 */
function wpgb_get_queried_object_type()
{
}

/**
 * Get total number of objects from filtered query
 *
 * @since 1.1.5 Change function name
 * @since 1.0.0
 *
 * @return integer
 */
function wpgb_get_found_objects()
{
}

/**
 * Get queried object ids in grid/template
 *
 * @since 1.1.5
 *
 * @return array Holds all object ids
 */
function wpgb_get_queried_object_ids()
{
}

/**
 * Build facet orderby clause
 *
 * @since 1.1.6
 *
 * @param  array $facet Holds facet settings.
 * @return string SQL ORDER BY clause.
 */
function wpgb_get_orderby_clause($facet = [])
{
}

/**
 * Build where clause
 *
 * @since 1.0.0
 *
 * @param array $facet Holds facet settings.
 * @return string SQL filtered where clause.
 */
function wpgb_get_where_clause($facet = [])
{
}

/**
 * Build filtered where clause
 *
 * @since 1.0.0
 *
 * @param array  $facet Holds facet settings.
 * @param string $logic Facet logic operator.
 * @return string SQL filtered where clause.
 */
function wpgb_get_filtered_where_clause($facet = [], $logic = 'AND')
{
}

/**
 * Get unfiltered where clause
 *
 * @since 1.0.0
 *
 * @return string Sql Unfiltered where clause.
 */
function wpgb_get_unfiltered_where_clause()
{
}

/**
 * Get filtered object ids
 *
 * @since 1.0.0
 *
 * @return array Filtered object ids.
 */
function wpgb_get_filtered_object_ids()
{
}

/**
 * Get unfiltered object ids
 *
 * @since 1.0.0
 *
 * @return array Unfiltered object ids.
 */
function wpgb_get_unfiltered_object_ids()
{
}

/**
 * Get facet ids from slugs
 *
 * @since 1.5.0
 *
 * @param array $slugs Holds facet slugs.
 * @return array Holds Facet ids.
 */
function wpgb_get_facet_ids($slugs = [])
{
}

/**
 * Get facet id from slug
 *
 * @since 1.5.0
 *
 * @param string $slug Facet slug.
 * @return integer Facet id.
 */
function wpgb_get_facet_id($slug = '')
{
}

/**
 * Get facet instances
 *
 * @since 1.0.0
 *
 * @param array $ids Holds facet ids to query.
 * @return array Facets.
 */
function wpgb_get_facet_instances($ids = [])
{
}

/**
 * Normalize facet settings
 *
 * @since 1.0.0
 *
 * @param  array $results Holds queried facets.
 * @param  array $facets  Holds facets.
 * @return array Facets.
 */
function wpgb_normalize_facets($results, $facets)
{
}

/**
 * Get permalink for pagination
 *
 * @since 1.0.0
 *
 * @return string
 */
function wpgb_get_pagenum_link()
{
}

/**
 * Get indexable postmeta keys from facets.
 *
 * @since 1.4.0
 *
 * @return array
 */
function wpgb_get_indexable_postmeta_keys()
{
}

/**
 * Check if a meta key is indexable
 *
 * @since 1.4.0
 *
 * @param string $key Post meta key name.
 * @return boolean
 */
function wpgb_is_indexable_meta_key($key = '')
{
}

/**
 * Get URL search params
 *
 * @since 1.5.0
 *
 * @return array
 */
function wpgb_get_url_search_params()
{
}
