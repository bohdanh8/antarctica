<?php
$news_section = get_sub_field("news_section");
$heading      = !empty($news_section["heading"]) ? $news_section["heading"] : '';
$text         = !empty($news_section["text"]) ? $news_section["text"] : '';
$button_text  = !empty($news_section["button_text"]) ? $news_section["button_text"] : __('View All News', 'prosekwptheme');
$layout       = !empty($news_section["layout"]) ? $news_section["layout"] : '';
?>

<?php if ($heading || $text): ?>
    <div class="container pt-36 pb-12">
        <?php if ($heading): ?>
            <h2 class="ease-left mt-0 mb-6 font-light text-navy-blue max-w-[30.8rem]" data-scroll><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>

        <?php if ($text): ?>
            <p class="ease-left my-0 font-light text-navy-blue" data-scroll><?php echo wp_kses_post($text); ?></p>
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

<div class="pb-36 pt-12 ease-left container flex items-center justify-between" data-scroll>
    <a href="<?php echo esc_url(get_the_permalink(get_option('page_for_posts'))); ?>"
       class="button button-alt"><?php echo esc_html($button_text); ?>
    </a>
    <?php if ($layout === "slider"): ?>
        <div class="flex gap-x-8 swiper-nav">
            <?php get_component('swiper-nav', ['prefix' => 'news']); ?>
        </div>
    <?php endif; ?>
</div>