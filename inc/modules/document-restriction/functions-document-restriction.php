<?php

/**
 * Add the necessary re-write rules to the .htaccess file.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.22 Initial release
 *
 * @param  string $rules
 * 
 */

define('DOCUMENT_RESTRICTION_SUPPORTED_EXTENSIONS', ['pdf', 'xlsx', 'xls', 'doc', 'docx']);

function add_document_restriction_rewrite_rules($rules = '')
{
    // Send all PDF access requests through the function, render_restricted_document_if_authorised(). 
    // Always flush the permalink structure by hitting "Save" on the Settings->Permalinks page. 


    $new_rule = "\n# Document Restriction\n";
    $new_rule .= "<IfModule mod_rewrite.c>\n";
    $new_rule .= "RewriteEngine On\n";
    $new_rule .= "RewriteBase /\n";
    $new_rule .= "RewriteRule ^wp-content/uploads/(.+\.(" . implode('|', DOCUMENT_RESTRICTION_SUPPORTED_EXTENSIONS) . "))$ index.php?restricted_document=$1 [QSA,L]\n";
    $new_rule .= "</IfModule>\n\n";

    return $new_rule . $rules;
}
add_filter('mod_rewrite_rules', 'add_document_restriction_rewrite_rules');


/**
 * Render the restricted document if the user is authorised.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.22 Initial release
 *
 */
function render_restricted_document_if_authorised()
{
    if (!empty($_REQUEST['restricted_document'])) {

        // Get the Document file name.
        $restricted_document = (string)sanitize_text_field($_REQUEST['restricted_document']);

        $acf_restricted_documents = [];

        if (!empty($restricted_document)) {

            // Get the list of all the "File" ACF fields that were selected in the "Document Restriction Options" settings page.
            $acf_restricted_fields = get_option('document_restriction_acf_fields');

            $excluded_post_types = ['attachment'];

            $public_post_types = get_post_types(['public' => true]);

            $additionl_post_types = array_diff($public_post_types, $excluded_post_types);

            // Retrieve all the posts from post, page and other custom post types.
            $post_query = new WP_Query([
                'post_type' => $additionl_post_types,
                'posts_per_page' => -1
            ]);

            if ($post_query->have_posts()) {

                while ($post_query->have_posts()) {
                    $post_query->the_post();

                    foreach ($acf_restricted_fields as $acf_restricted_field) {

                        // Get the field object of all the "File" ACF fiels that were selected in the settings page.
                        $acf_restricted_field_object = acf_get_field($acf_restricted_field);

                        $meta_data = get_post_meta(get_the_ID());

                        foreach ($meta_data as $meta_key => $meta_values) {

                            foreach ($meta_values as $meta_value) {
                                if ($acf_restricted_field_object['key'] === $meta_value) {

                                    $acf_restricted_meta_field = substr($meta_key, 1);

                                    $acf_restricted_file_value = get_field($acf_restricted_meta_field);

                                    // Support all three return value types for the ACF file field (File Array, File Url & File ID)
                                    if (is_array($acf_restricted_file_value)) {
                                        $acf_restricted_file_name = basename(get_attached_file($acf_restricted_file_value['ID']));
                                    } else if (is_numeric($acf_restricted_file_value)) {
                                        $acf_restricted_file_name = basename(get_attached_file($acf_restricted_file_value));
                                    } else {
                                        $acf_restricted_file_name = basename((string)$acf_restricted_file_value);
                                    }

                                    if (!empty($acf_restricted_file_name)) {

                                        // Add each of the restricted document file names.
                                        $acf_restricted_documents[] = $acf_restricted_file_name;
                                    }
                                }
                            }
                        }
                    }
                }
            }

            wp_reset_postdata();

            // Get the document url that was requested.
            $file = trailingslashit(wp_upload_dir()['basedir']) . $restricted_document;

            if (file_exists($file)) {

                if (in_array($restricted_document, $acf_restricted_documents)) {

                    /**
                     * The 'grant_restricted_document_access' filter hook can be used to override the default behavior of allowing any logged in user to access the restricted documents. Returning "true" will grant access to the restricted document.
                     * 
                     * Usage
                     * -----
                     * 
                     * function is_authorised_user()
                     * {
                     *     return is_user_premium();
                     * }
                     * add_filter('grant_restricted_document_access', 'is_authorised_user');
                     * 
                     * 
                     * 
                     */
                    if (apply_filters('grant_restricted_document_access', is_user_logged_in())) {

                        render_document($file, false);
                    } else {
                        wp_redirect(get_permalink((int)get_option('document_restriction_redirect_page')));
                    }
                } else {
                    render_document($file);
                }

                exit;
            } else {
                show_404_page();
            }
        }
    }
}
add_action('init', 'render_restricted_document_if_authorised');



/**
 * Render Document
 *
 * @author Kaveen Goonawardane + PDA (Prevent Direct Access Plugin)
 * 
 * @param array $file
 *
 * @return Mixed
 */
function render_document($file = '', $allow_cache = true)
{

    if (!is_file($file)) {
        wp_redirect(site_url());
    }

    $mime = wp_check_filetype($file);

    if (false === $mime['type'] && function_exists('mime_content_type')) {
        $mime['type'] = mime_content_type($file);
    }
    if ($mime['type']) {
        $mimetype = $mime['type'];
    } else {
        $mimetype = 'image/' . substr($file, strrpos($file, '.') + 1);
    }

    //set header
    header('Content-Type: ' . $mimetype); // always send this
    if (false === strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS')) {
        header('Content-Length: ' . filesize($file));
    }

    $last_modified = gmdate('D, d M Y H:i:s', filemtime($file));

    // Constantly change the ETag if the file is a restricted document. This will prevent the file from getting cached.
    if ($allow_cache) {
        $etag          = '"' . md5($last_modified) . '"';
    } else {
        $etag          = '"' . md5(time()) . '"';
    }

    header("Last-Modified: $last_modified GMT");
    header('ETag: ' . $etag);
    header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 100000000) . ' GMT');
    header('X-Robots-Tag: none');
    // Support for Conditional GET
    $client_etag = isset($_SERVER['HTTP_IF_NONE_MATCH']) ? stripslashes($_SERVER['HTTP_IF_NONE_MATCH']) : false;
    if (!isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
        $_SERVER['HTTP_IF_MODIFIED_SINCE'] = false;
    }
    $client_last_modified = trim($_SERVER['HTTP_IF_MODIFIED_SINCE']);
    // If string is empty, return 0. If not, attempt to parse into a timestamp
    $client_modified_timestamp = $client_last_modified ? strtotime($client_last_modified) : 0;
    // Make a timestamp for our most recent modification...
    $modified_timestamp = strtotime($last_modified);

    if (($client_last_modified && $client_etag)
        ? (($client_modified_timestamp >= $modified_timestamp) && ($client_etag == $etag))
        : (($client_modified_timestamp >= $modified_timestamp) || ($client_etag == $etag))
    ) {
        status_header(304);
        exit;
    }

    status_header(200);
    readfile($file);
}
