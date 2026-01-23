<div class="container">
    <div class="mb-6 sm:mb-10 ease-left" data-scroll>
        <h1> <?php echo esc_html(get_the_title()); ?> </h1>
        <?php if ($position = get_sub_field("position")): ?>
            <h4><?php echo esc_html($position); ?></h4>
        <?php endif; ?>
    </div>
    <div class="flex flex-col gap-8 md:flex-row lg:gap-16 ease-btm" data-scroll>
        <div class="w-full aspect-video">
            <?php $image = ['image' => get_post_thumbnail_id()]; ?>
            <?php echo get_attachment_fallback($image); ?>
        </div>
        <div>
            <?php if ($bio = get_sub_field("bio")): ?>
                <?php echo wp_kses_post($bio); ?>
            <?php endif; ?>
            <?php $linkedin = get_sub_field("linkedin");
            $email          = get_sub_field("email"); ?>
            <?php if ($linkedin || $email): ?>
                <ul class="flex flex-wrap gap-3.5 list-none sm:gap-6 [&_svg]:w-[1em] [&_svg]:h-[1em] ">
                    <?php if ($linkedin): ?>
                        <li>
                            <a href="<?php echo esc_url($linkedin); ?>" target="_blank"
                                rel="noopener"><?php echo get_social_icons('linkedin') ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if ($email): ?>
                        <li>
                            <a href="mailto:<?php echo esc_attr(sanitize_email($email)); ?>"><?php echo get_social_icons('email') ?></a>
                        </li>
                    <?php endif; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</div>