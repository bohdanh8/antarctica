<?php

/**
 * This is the main ACF Loop code.
 * 
 * *** DO NOT EDIT ***
 * 
 * @author Kaveen Goonawardane
 * 
 * @since 1.0.0
 * 
 */
if (!empty($args)) :

    // Run a custom query if the Post ID is passed into the_loop() function
    $post_id = $args;

    $post_type = get_post_type($post_id);

    $post_query = new WP_Query(
        [
            'post_type'      => $post_type,
            'post_status'    => 'publish',
            'p'              => $post_id,
            'posts_per_page' => -1
        ]
    );
endif;


?>
<?php if ((!empty($post_query)) ? $post_query->have_posts() : have_posts()) : ?>

    <?php while ((!empty($post_query)) ? $post_query->have_posts() : have_posts()) : ?>

        <?php
        (!empty($post_query)) ? $post_query->the_post() : the_post();

        $file_located = false;

        // Get all the active field groups that are assigned to the current page.
        $active_field_groups = acf_get_field_groups([
            'post_id' => get_the_ID()
        ]);

        $acf_fields = [];

        // Add all the ACF field array data into a single array.
        foreach ($active_field_groups as $active_field_group) {

            $active_fields = acf_get_fields($active_field_group);
            $acf_fields[] = $active_fields;
            $acf_fields = array_merge($acf_fields, $active_fields);
        }

        foreach ($acf_fields as $key => $acf_section) :

            if (!empty($acf_section['name'])) :

                $acf_section_name = $acf_section['name'];

                $file_location = STYLESHEETPATH . "/assets/templates/acf/{$acf_section_name}.php";



                if (file_exists($file_location)) :

                    $file_located = true;

                    // Set a default ID if one is not specified for the group.
                    if (!empty($acf_section['wrapper']['id'])) :
                        $acf_section_id = $acf_section['wrapper']['id'];

                    else :
                        $acf_section_id = preg_replace('/-+/', '-', str_replace('_', '-', $acf_section_name));

                    endif;

                    // Set a class list if defined.
                    if (!empty($acf_section['wrapper']['class'])) :
                        $acf_section_classes = 'group/' . $acf_section_id . ' ' . $acf_section['wrapper']['class'];

                    else :
                        $acf_section_classes = 'group/' . $acf_section_id;

                    endif;


                    // Looping through the ACF Group fields.
                    if (have_rows($acf_section_name)) :

                        while (have_rows($acf_section_name)) : the_row();

                            if (get_sub_field('enable') || !get_sub_field_object('enable')) :
        ?>
                                <!-- SECTION : <?php echo $acf_section['label'] ?> -->
                                <section id="<?php echo $acf_section_id ?>" class="<?php echo $acf_section_classes ?>">

                                    <?php
                                    // Load the template file if the section is enabled.
                                    // NOTE: Within each ACF template file, always use either get_sub_field or the_sub_field when accessing the ACF fields inside the Section (ACF Group) and the repeaters inside a section can be called with the typical have_rows() loop.
                                    load_template($file_location);

                                    ?>

                                </section>
                        <?php
                            endif;

                        endwhile;

                    else :

                        //This will load the template file even if the section only contains message fields and nothing else.
                        ?>
                        <!-- SECTION : <?php echo $acf_section['label'] ?> -->
                        <section id="<?php echo $acf_section_id ?>" class="<?php echo $acf_section_classes ?>">

                            <?php
                            load_template($file_location);
                            ?>

                        </section>
        <?php
                    endif;

                endif;
            endif;

        endforeach;

        if (!$file_located) :

            $file_location = STYLESHEETPATH . "/inc/templates/no-acf-templates-found.php";

            if (file_exists($file_location)) :

                load_template($file_location);
            else :

                show_404_page();
            endif;

        endif;
        ?>
    <?php endwhile; ?>
    <?php (!empty($post_query)) ? wp_reset_postdata() : ''; ?>
<?php endif; ?>