<?php

/**
 * Render the restricted content if the user is authorised.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.1.0 Initial release
 *
 */

function render_restricted_content_if_authorised()
{
    $redirect_page = get_option('content_restriction_redirect_page');
    $restricted_content = get_option('content_restriction_posts');

    if (!empty($restricted_content) && is_array($restricted_content) && in_array(get_the_ID(), $restricted_content)) {

        /**
         * The 'grant_restricted_content_access' filter hook can be used to override the default behavior of allowing any logged in user to access the restricted content. Returning "true" will grant access to the restricted content.
         * 
         * Usage
         * -----
         * 
         * function is_authorised_user()
         * {
         *     return is_user_premium();
         * }
         * add_filter('grant_restricted_content_access', 'is_authorised_user');
         * 
         * 
         * 
         */
        if (!apply_filters('grant_restricted_content_access', is_user_logged_in())) {

            wp_redirect(get_permalink((int)$redirect_page));
            die;
        }
    }
}
add_action('template_redirect', 'render_restricted_content_if_authorised');
