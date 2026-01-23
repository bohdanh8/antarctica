<?php

/**
 * Adds the Content Restriction section to the General Settings page and add all the required fields.
 * 
 * *** DO NOT EDIT ***
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.1.0 Initial release
 *
 */
function general_settings_content_restriction_options()
{

    // Add Content Restriction Section.
    add_settings_section(
        'content_restriction_options', // Section ID
        '', // Section title
        'content_restriction_options_section_callback', // Callback function to render the section
        'general' // Settings page (General)
    );

    // Add Content field setting.
    add_settings_field(
        'content_restriction_posts', // Field ID
        'Content to Restrict', // Field label
        'content_restriction_posts_callback', // Callback function to render the field
        'general', // Settings page (General)
        'content_restriction_options' // Section ID
    );
    register_setting(
        'general', // Settings page (General)
        'content_restriction_posts' // Option name
    );

    // Add Redirect Page setting.
    add_settings_field(
        'content_restriction_redirect_page', // Field ID
        'Redirect Page', // Field label
        'content_restriction_redirect_page_callback', // Callback function to render the field
        'general', // Settings page (General)
        'content_restriction_options' // Section ID
    );
    register_setting(
        'general', // Settings page (General)
        'content_restriction_redirect_page' // Option name
    );
}
add_action('admin_init', 'general_settings_content_restriction_options');


/**
 * This renders the Title and the description for the Content Restriction section
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.1.0 Initial release
 *
 */
function content_restriction_options_section_callback()
{
    echo '<hr /><h2>Content Restriction Options</h2><p>This section allows you to control certain functions of the Content Restriction feature.</p>';
}

/**
 * This renders the selectbox with the list of pages to be selected as the redirect page when the user is not logged in.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.1.0 Initial release
 *
 */
function content_restriction_redirect_page_callback()
{
    $pages_query = new WP_Query([
        'post_type' => 'page',
        'posts_per_page' => -1
    ]);

    $value = (int)sanitize_text_field(get_option('content_restriction_redirect_page'));
    ob_start();
?>
    <select name="content_restriction_redirect_page" id="content_restriction_redirect_page">
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

    </select><!-- #content_restriction_redirect_page -->
    <br />
    <label for="content_restriction_redirect_page">Select the page that the user should be redirected to, when not logged in</label>
<?php
    echo ob_get_clean();
}

/**
 * This renders the multi selectbox with the content list that needs to be restricted.
 *
 * @author Kaveen Goonawardane
 *  
 * @since 1.1.0 Initial release
 *
 */
function content_restriction_posts_callback()
{
    $value_array = get_option('content_restriction_posts') ?: [];

?>


    <select name="content_restriction_posts[]" id="content_restriction_posts" multiple="multiple" size="10" style="min-width:fit-content">
        <?php if (!empty(CONTENT_RESTRICTION['post_types'])) : ?>

            <?php $restricted_post_types = CONTENT_RESTRICTION['post_types']; ?>

            <?php foreach ($restricted_post_types as $restricted_post_type) :
                $post_type_object = get_post_type_object($restricted_post_type);

            ?>
                <optgroup label="<?php echo $post_type_object->label ?>">

                    <?php
                    $pages_query = new WP_Query([
                        'post_type' => $restricted_post_type,
                        'posts_per_page' => -1
                    ]);

                    ob_start();
                    ?>

                    <?php if ($pages_query->have_posts()) : ?>
                        <?php while ($pages_query->have_posts()) : $pages_query->the_post(); ?>
                            <?php
                            if (in_array(get_the_ID(), $value_array)) :
                                $selected = ' selected="selected"';
                            else :
                                $selected = '';
                            endif;
                            ?>
                            <option <?php echo $selected ?> value="<?php echo get_the_ID() ?>"><?php the_title() ?></option>
                        <?php endwhile; ?>
                    <?php endif; ?>

                    <?php wp_reset_postdata() ?>

                </optgroup>

            <?php endforeach; ?>

        <?php endif; ?>
    </select><!-- #content_restriction_posts -->


    <br />
    <label for="content_restriction_posts">Select content that needs to be restricted to logged in users. <br />(Press and hold the <kbd>Shift/Cmd/Ctrl</kbd> key to select multiple fields)</label>
<?php
    echo ob_get_clean();
}
