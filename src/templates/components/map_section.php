<?php
$map_section = get_sub_field("map_section");
$eyebrow = ! empty($map_section['eyebrow']) ? $map_section['eyebrow'] : '';
$heading = ! empty($map_section['heading']) ? $map_section['heading'] : '';
$map_image = ! empty($map_section['map_image']) ? $map_section['map_image'] : '';
$mappings = ! empty($map_section['mapping']) ? $map_section['mapping'] : [];

if ($eyebrow || $heading || $map_image) : ?>
    <div class="container pt-[72px] pb-[72px]">
        <?php if (!empty($eyebrow)): ?>
            <p class="text-navy-blue text-[14px] leading-none font-bold m-0 mb-12 pt-4 border-t border-divider-light-line uppercase ease-left" data-scroll>
                <?php echo esc_html($eyebrow); ?>
            </p>
        <?php endif; ?>
        <?php if (!empty($heading)): ?>
            <h2 class="text-navy-blue font-light mb-12 ease-left" data-scroll>
                <?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>
        <?php if( !empty( $map_image ) ): ?>
            <div id="map-block" class="map-block relative ease-btm" data-scroll>
                <img class="h-full w-full" src="<?php echo esc_url($map_image['url']); ?>" alt="<?php echo esc_attr($map_image['alt']); ?>" />
                <?php foreach ($mappings as $mapping) :
                    $coords_string = $mapping['position_on_the_map'];
                    $coords_array = explode(',', $coords_string);
                    $left = isset($coords_array[0]) ? trim($coords_array[0]) : '0%';
                    $top = isset($coords_array[1]) ? trim($coords_array[1]) : '0%';
                    $title = $mapping['title'];
                    $description = $mapping['description'];
                    ?>
                    <div class="map-block_item absolute p-6 pr-[37px] bg-white sm:max-w-80 rounded-br-[32px] hidden z-[3] shadow-[0px_3px_4px_var(--bright-blue)] [&.is-active]:block"
                         style="left: <?php echo esc_attr($left); ?>; top: <?php echo esc_attr($top); ?>; transform: translate(46px,30px)">
                        <h5 class="text-bright-blue font-medium mt-0 mb-3"><?php echo esc_html($title); ?></h5>
                        <p class="font-light text-[16px] leading-[1.3] text-navy-blue"><?php echo wp_kses_post($description); ?></p>
                    </div>
                    <span class="map-block_dot rounded-[50%] block absolute w-[16px] h-[16px] duration-500 bg-bright-blue [&.is-active]:scale-[2]" style="left: <?php echo esc_attr($left); ?>; top: <?php echo esc_attr($top); ?>;"></span>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>