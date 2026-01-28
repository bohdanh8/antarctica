<?php
$external_link = get_field( 'news_-_content_external_link', get_the_ID() );
?>

<article <?php post_class(); ?>>
    <div class="overflow-hidden mb-2 aspect-video mb-6">
        <?php $image = [ 'image' => get_post_thumbnail_id() ]; ?>
        <?php echo get_attachment_fallback( $image ); ?>
    </div>
    <div>
        <div class="mb-6 line-clamp-3">
            <h4 class="inline text-navy-blue font-light"><?php echo esc_html( get_the_title() ); ?></h4>
        </div>
        <div class="flex flex-col items-start md:flex-row md:items-center justify-between gap-4">
            <div>
                <a href="<?php echo esc_url( get_permalink() ); ?>" <?php echo $external_link ? 'target="_blank"' : ''; ?> class="multi-underline-1 text-[1.125rem] font-light text-navy-blue leading-none"><?php echo __('Read Article'); ?></a>
            </div>
            <div class="text-[1.125rem] font-light text-navy-blue leading-none">
                <time datetime="<?php echo get_the_time( 'c' ); ?>"><?php echo get_the_date('m.d.y'); ?></time>
                <?php $categories = get_the_category();
                if ( ! empty( $categories ) ) :
                    $category_names = wp_list_pluck( $categories, 'name' ); ?>
                    <?php echo __(' | '); ?>
                    <span><?php echo esc_html( implode( ', ', $category_names ) ); ?></span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>