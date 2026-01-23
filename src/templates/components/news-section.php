<?php
$news_section = get_sub_field("news_section");
$heading      = !empty($news_section["heading"]) ? $news_section["heading"] : '';
$text         = !empty($news_section["text"]) ? $news_section["text"] : '';
$button_text  = !empty($news_section["button_text"]) ? $news_section["button_text"] : __('View All News', 'prosekwptheme');
$layout       = !empty($news_section["layout"]) ? $news_section["layout"] : '';
?>

<?php if ($heading || $text): ?>
    <div class="container">
        <?php if ($heading): ?>
            <h2 class="ease-left" data-scroll><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($text): ?>
            <h6 class="ease-left" data-scroll><?php echo wp_kses_post($text); ?></h6>
        <?php endif; ?>
    </div>
<?php endif; ?>


<?php $news_args = array(
        'post_type'      => 'post',
        'orderby'        => 'date',
        'order'          => 'desc',
        'posts_per_page' => '10',
        'post_status'    => 'publish',
);
$news            = new WP_Query($news_args); ?>
<?php if ($news->have_posts()): ?>
    <div class="px-side-offset ease-btm <?php echo $layout === "grid" ? "" : "swiper news"; ?>" data-scroll>
        <div class="<?php echo $layout === "grid" ? "grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-6" : "swiper-wrapper"; ?>">
            <?php while ($news->have_posts()): $news->the_post(); ?>
                <div class="<?php echo $layout === "grid" ? "" : "swiper-slide"; ?>">
                    <?php get_component('loop-news', ["time" => true]); ?>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif;
wp_reset_query(); ?>

<div class="py-8 ease-left container" data-scroll>
    <?php if ($layout === "slider"): ?>
        <div class="flex gap-x-8 mb-8 swiper-nav">
            <?php get_component('swiper-nav', ['prefix' => 'news']); ?>
        </div>
    <?php endif; ?>

    <a href="<?php echo esc_url(get_the_permalink(get_option('page_for_posts'))); ?>"
       class="button button-alt"><?php echo esc_html($button_text); ?></a>
</div>