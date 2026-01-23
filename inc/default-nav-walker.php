<?php
class Default_Nav_Walker extends Walker_Nav_Menu
{

    /**
     * Starts the list before the elements are added.
     * 
     * *** DO NOT EDIT ***
     *
     * @see Walker::start_lvl()
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function start_lvl(&$output, $depth = 0, $args = null)
    {
        ob_start();
?>
        <ul class="level-<?php echo $depth ?> sub-menu group/sub-menu">
        <?php
        $output .= ob_get_clean();
    }

    /**
     * Ends the list of after the elements are added.
     *
     * @see Walker::end_lvl()
     *
     * @param string   $output Used to append additional content (passed by reference).
     * @param int      $depth  Depth of menu item. Used for padding.
     * @param stdClass $args   An object of wp_nav_menu() arguments.
     */
    public function end_lvl(&$output, $depth = 0, $args = null)
    {
        ob_start();
        ?>
        </ul>
    <?php
        $output .= ob_get_clean();
    }

    /**
     * Starts the element output.
     *
     * @see Walker::start_el()
     *
     * @param string   $output            Used to append additional content (passed by reference).
     * @param WP_Post  $data_object       Menu item data object.
     * @param int      $depth             Depth of menu item. Used for padding.
     * @param stdClass $args              An object of wp_nav_menu() arguments.
     * @param int      $current_object_id Optional. ID of the current menu item. Default 0.
     */
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $current_object_id = 0)
    {
        /**
         * <li> Attributes
         */
        $menu_item = $data_object;

        $classes   = empty($menu_item->classes) ? array() : (array) $menu_item->classes;
        $classes[] = 'menu-item-' . $menu_item->ID;

        $class_names = implode(' ', array_filter($classes));
        $class_names = $class_names ? esc_attr($class_names) : '';

        /**
         * <a> Attributes
         */
        $atts           = array();
        $atts['title']  = !empty($menu_item->attr_title) ? $menu_item->attr_title : '';
        $atts['target'] = !empty($menu_item->target) ? $menu_item->target : '';

        if ('_blank' === $menu_item->target && empty($menu_item->xfn)) {

            $atts['rel'] = 'noopener';
        } else {

            $atts['rel'] = $menu_item->xfn;
        }

        if (!empty($menu_item->url)) {

            if (get_privacy_policy_url() === $menu_item->url) {

                $atts['rel'] = empty($atts['rel']) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
            }

            $atts['href'] = $menu_item->url;
        } else {

            $atts['href'] = '';
        }

        $atts['aria-current'] = $menu_item->current ? 'page' : '';

        $attributes = '';

        foreach ($atts as $attr => $value) {

            if (is_scalar($value) && '' !== $value && false !== $value) {

                $value       = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = !empty($menu_item->title) ? $menu_item->title : '';
        $target = !empty($menu_item->target) ? 'target="' . $menu_item->target . '"' : '';

        if ('_blank' === $menu_item->target && empty($menu_item->xfn)) {

            $rel_value = "noopener";
        } else {

            $rel_value = $menu_item->xfn;
        }

        if (!empty($menu_item->url)) {

            if (get_privacy_policy_url() === $menu_item->url) {

                $rel_value = empty($rel_value) ? 'privacy-policy' : $rel_value . ' privacy-policy';
            }

            $url = $menu_item->url;
        } else {

            $url = '';
        }

        $rel = $rel_value ? 'rel="' . $rel_value . '"' : '';

        $aria_current = $menu_item->current ? 'aria-current="page"' : '';

        ob_start();
        /**
         * <a> and <li> HTML
         */
    ?>
        <li id="menu-item-<?php echo $menu_item->ID ?>" class="level-<?php echo $depth ?> <?php echo $class_names ?>">
            <a href="<?php echo $url ?>" <?php echo $target . ' ' . $rel . '' . $aria_current ?> data-title="<?php echo $title ?>" class="level-<?php echo $depth ?>">
                <?php echo $title ?></a>
    <?php
        $output .= ob_get_clean();
    }

    /**
     * Ends the element output, if needed.
     *
     * @see Walker::end_el()
     *
     * @param string   $output      Used to append additional content (passed by reference).
     * @param WP_Post  $data_object Menu item data object. Not used.
     * @param int      $depth       Depth of page. Not Used.
     * @param stdClass $args        An object of wp_nav_menu() arguments.
     */
    public function end_el(&$output, $data_object, $depth = 0, $args = null)
    {
        $output .= "</li>";
    }
}
