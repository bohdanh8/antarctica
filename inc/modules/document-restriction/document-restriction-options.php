<?php

/**
 * Adds the Document Restriction section to the General Settings page and add all the required fields.
 * 
 * *** DO NOT EDIT ***
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.22 Initial release
 *
 */
function general_settings_document_restriction_options()
{

    // Add Document Restriction Section.
    add_settings_section(
        'document_restriction_options', // Section ID
        '', // Section title
        'document_restriction_options_section_callback', // Callback function to render the section
        'general' // Settings page (General)
    );

    // Add ACF File field setting.
    add_settings_field(
        'document_restriction_acf_fields', // Field ID
        'ACF Fields', // Field label
        'document_restriction_acf_fields_callback', // Callback function to render the field
        'general', // Settings page (General)
        'document_restriction_options' // Section ID
    );
    register_setting(
        'general', // Settings page (General)
        'document_restriction_acf_fields' // Option name
    );

    // Add Redirect Page setting.
    add_settings_field(
        'document_restriction_redirect_page', // Field ID
        'Redirect Page', // Field label
        'document_restriction_redirect_page_callback', // Callback function to render the field
        'general', // Settings page (General)
        'document_restriction_options' // Section ID
    );
    register_setting(
        'general', // Settings page (General)
        'document_restriction_redirect_page' // Option name
    );
}
add_action('admin_init', 'general_settings_document_restriction_options');


/**
 * This renders the Title and the description for the Document Restriction section
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.22 Initial release
 *
 */
function document_restriction_options_section_callback()
{
    echo '<hr /><h2>Document Restriction Options</h2><p>This section allows you to control certain functions of the Document Restriction feature.</p>';
}

/**
 * This renders the selectbox with the list of pages to be selected as the redirect page when the user is not logged in.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.22 Initial release
 *
 */
function document_restriction_redirect_page_callback()
{
    $pages_query = new WP_Query([
        'post_type' => 'page',
        'posts_per_page' => -1
    ]);

    $value = (int)sanitize_text_field(get_option('document_restriction_redirect_page'));
    ob_start();
?>
    <select name="document_restriction_redirect_page" id="document_restriction_redirect_page">
        <?php if ($pages_query->have_posts()) : ?>

            <?php while ($pages_query->have_posts()) : $pages_query->the_post(); ?>

                <?php
                if ($value === get_the_ID()) :
                    $selected = ' selected="selected" ';
                else :
                    $selected = '';
                endif;
                ?>

                <option <?php echo $selected ?> value="<?php echo get_the_ID() ?>"><?php the_title() ?></option>

            <?php endwhile; ?>

        <?php endif; ?>

        <?php wp_reset_postdata(); ?>

    </select><!-- #document_restriction_redirect_page -->
    <br />
    <label for="document_restriction_redirect_page">Select the page that the user should be redirected to, when not logged in</label>
<?php
    echo ob_get_clean();
}

/**
 * This renders the multi selectbox with the list of ACF fields that needs to handle document restrictions.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.0.22 Initial release
 *
 */
function document_restriction_acf_fields_callback()
{

    $acf_field_groups = acf_get_field_groups();

    $supported_mime_types = DOCUMENT_RESTRICTION_SUPPORTED_EXTENSIONS;

    $value_array = get_option('document_restriction_acf_fields') ?: [];

    ob_start();
?>
    <select name="document_restriction_acf_fields[]" id="document_restriction_acf_fields" multiple="multiple" size="10" style="min-width:fit-content">
        <?php foreach ($acf_field_groups as $acf_field_group) : ?>
            <?php if ($acf_field_group['key'] !== 'group_6344461ecf02e' && $acf_field_group['key'] !== 'group_643441f0a117f' && $acf_field_group['key'] !== 'group_6434427b216fb') : ?>

                <?php
                $acf_fields = acf_get_fields($acf_field_group['ID']);

                ?>

                <?php foreach ($acf_fields as $acf_field) : ?>

                    <?php

                    // Level 0 Sub field loop.
                    $acf_sub_fields[0] = $acf_field['sub_fields'];
                    $file_field_exists[0] = false;
                    $sub_field_label[0] = '';

                    foreach ($acf_sub_fields[0] as $acf_sub_field[0]) :
                        if (is_mime_type_supported($acf_sub_field[0], $supported_mime_types)) :
                            $file_field_exists[0] = true;
                            $sub_field_label[0] = $acf_field['label'];

                        else :

                            // Level 1 Sub field loop.
                            if (!empty($acf_sub_field[0]['sub_fields'])) :
                                $acf_sub_fields[1] = $acf_sub_field[0]['sub_fields'];
                                $file_field_exists[1] = false;
                                $sub_field_label[1] = '';

                                foreach ($acf_sub_fields[1] as $acf_sub_field[1]) :
                                    if (is_mime_type_supported($acf_sub_field[1], $supported_mime_types)) :
                                        $file_field_exists[1] = true;
                                        $sub_field_label[1] = $acf_field['label'] . ' > ' . $acf_sub_field[0]['label'];

                                    else :

                                        // Level 2 Sub field loop.
                                        if (!empty($acf_sub_field[1]['sub_fields'])) :
                                            $acf_sub_fields[2] = $acf_sub_field[1]['sub_fields'];
                                            $file_field_exists[2] = false;
                                            $sub_field_label[2] = '';

                                            foreach ($acf_sub_fields[2] as $acf_sub_field[2]) :
                                                if (is_mime_type_supported($acf_sub_field[2], $supported_mime_types)) :
                                                    $file_field_exists[2] = true;
                                                    $sub_field_label[2] = $acf_field['label'] . ' > ' . $acf_sub_field[0]['label'] . ' > ' . $acf_sub_field[1]['label'];

                                                else :

                                                    // Level 3 Sub field loop.
                                                    if (!empty($acf_sub_field[2]['sub_fields'])) :
                                                        $acf_sub_fields[3] = $acf_sub_field[2]['sub_fields'];
                                                        $file_field_exists[3] = false;
                                                        $sub_field_label[3] = '';

                                                        foreach ($acf_sub_fields[3] as $acf_sub_field[3]) :
                                                            if (is_mime_type_supported($acf_sub_field[3], $supported_mime_types)) :
                                                                $file_field_exists[3] = true;
                                                                $sub_field_label[3] = $acf_field['label'] . ' > ' . $acf_sub_field[0]['label'] . ' > ' . $acf_sub_field[1]['label'] . ' > ' . $acf_sub_field[2]['label'];


                                                            endif;
                                                        endforeach;
                                                    endif;


                                                endif;
                                            endforeach;
                                        endif;

                                    endif;
                                endforeach;
                            endif;

                        endif;
                    endforeach;

                    ?>

                    <?php for ($i = 0; $i <= 3; $i++) : ?>

                        <?php if (!empty($file_field_exists[$i])) : ?>

                            <optgroup label="<?php echo $acf_field_group['title'] . ' : ' . $sub_field_label[$i] ?>">

                                <?php foreach ($acf_sub_fields[$i] as $acf_sub_field) : ?>

                                    <?php if ($acf_sub_field['type'] === 'file' && !empty($acf_sub_field['mime_types']) && !empty(array_intersect($supported_mime_types, explode(',', $acf_sub_field['mime_types'])))) : ?>
                                        <?php
                                        if (in_array($acf_sub_field['ID'], $value_array)) :
                                            $selected = ' selected="selected"';
                                        else :
                                            $selected = '';
                                        endif;
                                        ?>
                                        <option <?php echo $selected ?> value="<?php echo $acf_sub_field['ID'] ?>"><?php echo $acf_sub_field['label'] ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </optgroup>

                            <?php $file_field_exists[$i] = false; ?>

                        <?php endif; ?>

                    <?php endfor; ?>


                <?php endforeach; ?>

            <?php endif; ?>

        <?php endforeach; ?>
    </select><!-- #document_restriction_acf_fields -->
    <br />
    <label for="document_restriction_acf_fields">Select the ACF fields that needs to handle restricted documents. <br />This only shows "File" type ACF fields that have a mime type set to one or more of the following extensions: <strong>"<?php echo implode(', ', DOCUMENT_RESTRICTION_SUPPORTED_EXTENSIONS) ?>"</strong> <br />(Press and hold the <kbd>Shift/Cmd/Ctrl</kbd> key to select multiple fields)</label>
<?php
    echo ob_get_clean();
}

/**
 * Check if the Mime Type of an ACF file field is supported.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.3.2 Initial release
 *
 * @param  array $acf_sub_field
 * @param  array $supported_mime_types
 *
 * @return bool
 */
function is_mime_type_supported($acf_sub_field = array(), $supported_mime_types = array())
{

    if ($acf_sub_field['type'] === 'file' && !empty($acf_sub_field['mime_types']) && !empty(array_intersect($supported_mime_types, explode(',', $acf_sub_field['mime_types'])))) {
        return true;
    } else {
        return false;
    }
}
