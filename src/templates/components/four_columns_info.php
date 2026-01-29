<?php
$four_columns_info = get_sub_field('four_columns_info');
$columns = ! empty($four_columns_info['columns']) ? $four_columns_info['columns'] : [];
$text_area_under_columns = ! empty($four_columns_info['text_area_under_columns']) ? $four_columns_info['text_area_under_columns'] : '';
?>

<?php if ($columns || $text_area_under_columns): ?>
    <div class="container pt-[9.5rem] pb-28 relative">
        <div class="container py-0 absolute top-0 left-0 [&_svg]:w-full ease-top" data-scroll>
            <?php echo $four_columns_info['svg_image_columns']; ?>
        </div>
        <?php if(! empty($columns)): ?>
            <div class="four-columns grid grid-cols-4 gap-8 mb-12 ease-top" data-scroll>
                <?php foreach ( $columns as $column ) : ?>
                    <div class="column bg-[image:var(--gradient-45)] min-h-[27rem] p-10 flex flex-col justify-end">
                        <?php if (!empty($column['heading_first'])): ?>
                            <p class="font-light my-0 text-white pt-6 pb-4 border-t border-white">
                                <?php echo esc_html($column['heading_first']); ?>
                            </p>
                        <?php endif; ?>
                        <?php if (!empty($column['heading_second'])): ?>
                            <h1 class="[&_p]:font-light [&_p]:my-0 [&_p]:text-white [&_p]:leading-[1.1] [&_p]:h1 [&_p]:relative [&_sub]:bottom-0 [&_sub]:leading-none [&_sub]:text-[56px] [&_sup]:top-[-1.5em] [&_sup]:right-0 [&_sup]:text-[36px]">
                                <?php echo wp_kses_post($column['heading_second']); ?>
                            </h1>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-under-columns ease-left [&_p]:font-light [&_p]:my-0 [&_p]:text-medium-gray [&_p]:max-w-[48rem]" data-scroll>
                <?php if (!empty($text_area_under_columns)): ?>
                    <?php echo wp_kses_post($text_area_under_columns); ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>