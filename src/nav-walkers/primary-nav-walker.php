<?php

class Primary_Nav_Walker extends Walker_Nav_Menu {
	private $parent_description = '';
	private $parent_args = [];
	private $parent_item = null;

	/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 */

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		ob_start();

		if ( $depth == 0 ): ?>
			<div class="primary-submenu bg-white max-lg:duration-300 max-lg:transition-transform py-4 px-side-offset xl:py-12 overflow-auto lg:flex lg:gap-8 justify-between left-0 lg:fixed w-full text-black z-20 max-lg:top-0 max-lg:absolute max-lg:h-full">
			<div class="lg:w-2/3">

            <button class="js-drilldown-back drilldown-back flex items-center pb-4 mb-3 lg:hidden font-normal text-black">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 9 17" class="w-2.5 mr-5">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                          d="M8.3 1 1 8.3l7.3 7.29"/>
                </svg>
                <span class="opacity-50"><?php echo $this->parent_item->title; ?></span>
            </button>
		<?php endif; ?>
        
		<?php if ( $depth == 0 && ! empty( $this->parent_description ) ): ?>
			<a <?php echo implode( ' ', $this->parent_args ); ?>
				class="h4 multi-underline-1"><?php echo $this->parent_description; ?>
			</a>
			<?php
			unset( $this->parent_description );
			unset( $this->parent_args );
		endif;

		$sub_menu_classes = 'sub-menu group/sub-menu w-auto';
		$sub_menu_classes .= " level-$depth";
		$sub_menu_classes .= $depth == 0 ? ' mt-5' : '';
		?>
		<ul class="<?php echo $sub_menu_classes; ?>">
		<?php
		$output .= ob_get_clean();
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		if ( $depth == 0 ) {
			ob_start();
			?>
			</ul>
			</div> <!-- end of .w-2/3 -->
			<div class="max-lg:hidden w-1/3">
				<?php if ( $this->parent_item ): ?>
					<?php $featured_news = get_field( 'featured_news', $this->parent_item->ID );
					$image_menu          = get_field( 'image', $this->parent_item->ID ); ?>
					<?php if ( $featured_news ): ?>
						<?php get_component( 'nav-news', [ 'news' => $featured_news ] ); ?>
					<?php elseif ( $image_menu ): ?>
						<div class="aspect-video">
							<?php $image = [ 'image' => $image_menu ]; ?>
							<?php echo get_attachment_fallback( $image ); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>
			</div> <!-- end of .menu-news -->
			<?php
			$output .= ob_get_clean();
		} else {
			$output .= '</ul>';
		}
	}


	/**
	 * Starts the element output.
	 *
	 * @see Walker::start_el()
	 *
	 * @param WP_Post $data_object Menu item data object.
	 * @param int $depth Depth of menu item. Used for padding.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 * @param int $current_object_id Optional. ID of the current menu item. Default 0.
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		/**
		 * <li> Attributes
		 */
		$menu_item = $data_object;

		if ( $depth == 1 ) {
			$this->menu_item = $menu_item;
		}

		$classes   = empty( $menu_item->classes ) ? array() : (array) $menu_item->classes;
		$classes[] = 'menu-item-' . $menu_item->ID;

		$class_names = implode( ' ', array_filter( $classes ) );
		$class_names = $class_names ? esc_attr( $class_names ) : '';

		/**
		 * Check if the current menu item has children
		 */
		$has_children = in_array( 'menu-item-has-children', $classes, true );

		/**
		 * <a> Attributes
		 */
		$atts           = array();
		$atts['title']  = ! empty( $menu_item->attr_title ) ? $menu_item->attr_title : '';
		$atts['target'] = ! empty( $menu_item->target ) ? $menu_item->target : '';
		if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
			$atts['rel'] = 'noopener';
		} else {
			$atts['rel'] = $menu_item->xfn;
		}

		if ( ! empty( $menu_item->url ) ) {
			if ( get_privacy_policy_url() === $menu_item->url ) {
				$atts['rel'] = empty( $atts['rel'] ) ? 'privacy-policy' : $atts['rel'] . ' privacy-policy';
			}

			$atts['href'] = $menu_item->url;
		} else {
			$atts['href'] = '';
		}

		$atts['aria-current'] = $menu_item->current ? 'page' : '';

		$attributes = '';
		foreach ( $atts as $attr => $value ) {
			if ( is_scalar( $value ) && '' !== $value && false !== $value ) {
				$value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
				$attributes .= ' ' . $attr . '="' . $value . '"';
			}
		}

		$title  = ! empty( $menu_item->title ) ? $menu_item->title : '';
		$target = ! empty( $menu_item->target ) ? 'target="' . $menu_item->target . '"' : '';
		if ( '_blank' === $menu_item->target && empty( $menu_item->xfn ) ) {
			$rel_value = "noopener";
		} else {
			$rel_value = $menu_item->xfn;
		}

		if ( ! empty( $menu_item->url ) ) {
			if ( get_privacy_policy_url() === $menu_item->url ) {
				$rel_value = empty( $rel_value ) ? 'privacy-policy' : $rel_value . ' privacy-policy';
			}

			$url = $menu_item->url;
		} else {
			$url = '';
		}

		$rel = $rel_value ? 'rel="' . $rel_value . '"' : '';

		$aria_current = $menu_item->current ? 'aria-current="page"' : '';

		ob_start();

        if ($depth == 0) {
            $this->parent_item = $menu_item;

            $this->parent_args = [
                'url'    => "href='{$url}'",
                'target' => $target,
                'rel'    => $rel,
                'aria'   => $aria_current,
            ];

            if ($menu_item->description) {
                $this->parent_description = $menu_item->description;
            }
        }

		/**
		 * <a> and <li> HTML
		 */

		$menu_item_classes = $class_names;
		$menu_item_classes .= ' break-inside-avoid';
		$menu_item_classes .= " level-$depth";

		?>
	<li id="menu-item-<?php echo $menu_item->ID ?>" class="<?php echo $menu_item_classes; ?>">
		<?php
		$link_classes = "level-$depth ";
		$link_classes .= $class_names;
		$link_classes .= $depth == 0 ? ' lg:h6 h5 max-lg:mb-3' : ' ';
		$link_classes .= $depth == 1 ? ' text-black h6 mb-3' : '';
		$link_classes .= $depth == 2 ? ' mb-3 ml-3' : '';
		$link_classes .= $depth == 1 && $has_children ? ' h5 mb-5' : ' font-medium';
		$link_classes .= ' block items-center transition-none hover:text-prosek-orange';
		$link_classes .= ( $url === '#' || empty( $url ) ) ? ' cursor-default pointer-events-none' : '';
		$link_classes .= ( $has_children && $depth == 0 ) ? ' js-open-drilldown' : '';
		?>
		<a id="menu-item-<?php echo $menu_item->ID ?>"
		   href="<?php echo $url ?>" <?php echo $target . ' ' . $rel . '' . $aria_current ?>
		   data-title="<?php echo esc_attr( $title ) ?>" <?php echo $url === '#' || empty( $url ) ? 'tabindex="-1"' : ''; ?>
		   class="relative <?php echo $link_classes ?>">
			<?php echo $title; ?>
			<?php if ( $has_children && $depth == 0 ): ?>
				<button class="js-open-drilldown absolute right-0 top-0 h-full flex items-center justify-end p-2 w-12 lg:hidden">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-2.5 h-auto stroke-current"
					     viewBox="0 0 9 17">
						<path stroke-linecap="round" stroke-linejoin="round" d="m.65 16 7.3-7.3-7.3-7.29"/>
					</svg>
				</button>
			<?php endif; ?>
		</a>
		<?php
		$output .= ob_get_clean();
	}

	/**
	 * Ends the element output, if needed.
	 *
	 * @see Walker::end_el()
	 *
	 * @param WP_Post $data_object Menu item data object. Not used.
	 * @param int $depth Depth of page. Not Used.
	 * @param stdClass $args An object of wp_nav_menu() arguments.
	 *
	 * @param string $output Used to append additional content (passed by reference).
	 */
	public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
		$output .= "</li>";
	}
}
