<footer id="site-footer" class="bg-white ease-btm" data-scroll>
	<?php get_component('footer-banner'); ?>

	<?php $footer_section = get_field('footer_section_edit', 'option'); ?>

	<div class="overflow-hidden container py-[72px]">
		<div class="flex items-start justify-between gap-8">
            <div class="max-w-[193px]">
                <a href="<?php echo home_url(); ?>">
                    <?php echo get_start_logo(); ?>
                </a>
            </div>
            <div class="max-w-[35%] w-full">
                <nav class="flex flex-col items-start gap-8 [&_div]:pb-0 [&_a]:text-navy-blue [&_a]:text-[32px] [&_a]:font-light pb-8 border-b-2 border-[#C7E0EB] mb-8 [&_a]:multi-underline-1" aria-label="Footer">

                    <?php
                    wp_nav_menu([
                        'theme_location' => 'footer',
                        'depth'          => 1,
                    ]);
                    ?>

                    <!--			--><?php //get_component("modal"); ?>
                </nav>
                <?php $contact_emails = $footer_section['contact_emails']; ?>
                <?php if ($contact_emails): ?>
                    <div class="font-light text-navy-blue mb-6 text-[18px] leading-[1.3] [&_p]:mb-6 [&_a]:no-underline [&_a]:multi-underline-1">
                        <?php echo wp_kses_post($contact_emails); ?>
                    </div>
                <?php endif; ?>
                <div class="flex gap-2">
                    <?php $social_links = [
                        'linkedin'  => 'LinkedIn',
                        'facebook'  => 'Facebook',
                        'instagram' => 'Instagram',
                        'twitter'   => 'Twitter',
                        'github'    => 'GitHub',
                        'youtube'   => 'YouTube',
                    ]; ?>
                    <?php foreach ($social_links as $key => $label): ?>
                        <?php if (! empty($footer_section["{$key}_link"])): ?>
                            <a href="<?php echo esc_url($footer_section["{$key}_link"]); ?>" target="_blank"
                               rel="noopener" aria-label="<?php echo esc_attr($label) ?>" class="w-[35px] h-[35px] rounded-[50%] border border-navy-blue p-[10px] text-navy-blue [&_svg]:w-full [&_svg]:h-full hover:text-bright-blue hover:border-bright-blue">
                                <span class="sr-only"><?php echo esc_html($label); ?></span>
                                <?php echo get_social_icons($key); ?>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="max-w-[35%] w-full">
                <?php $locations_title = $footer_section['locations_title']; ?>
                <?php $locations = $footer_section['locations']; ?>
                <?php if ($locations_title): ?>
                    <h4 class="font-light text-navy-blue mb-8 mt-0">
                        <?php echo $locations_title; ?>
                    </h4>
                <?php endif;?>
                <?php if ($locations): ?>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 flex-wrap">
                        <?php foreach ($locations as $location): ?>
                            <?php $location_country = $location['country']; ?>
                            <?php $location_address = $location['address']; ?>
                            <?php $location_phone = $location['phone']; ?>
                            <?php $sanitized_number = preg_replace('/[^0-9]/', '', $location_phone); ?>
                            <div class="pt-4 border-t-2 border-[#C7E0EB]">
                                <h4 class="font-light text-navy-blue mb-2 mt-0">
                                    <?php echo $location_country; ?>
                                </h4>
                                <p class="my-0 font-light text-navy-blue text-[16px] leading-[1.3]"><?php echo wp_kses_post($location_address);?></p>
                                <a class="my-0 font-light text-navy-blue text-[16px] leading-[1.3] multi-underline-1" href="tel:<?php echo $sanitized_number; ?>"><?php echo $location_phone; ?></a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif;?>
            </div>
        </div>

		<div class="flex justify-center items-center gap-5 mt-[72px]">
            <p class="my-0 text-navy-blue text-[16px] leading-none font-normal">
                &copy; <?php echo date('Y') ?> <?php echo $footer_section['copyright_text'] ?>
            </p>
            <?php $additional_links = $footer_section['additional_links']; ?>
            <?php if ($additional_links): ?>
                <div class="flex gap-5 items-center">
                    <?php foreach ($additional_links as $additional_link): ?>
                        <?php $additional_link = $additional_link['link']; ?>
                        <?php if( $additional_link ):
                            $link_url = $additional_link['url'];
                            $link_title = $additional_link['title'];
                            $link_target = $additional_link['target'] ? $additional_link['target'] : '_self';
                            ?>
                            <a class="text-navy-blue text-[16px] leading-none font-normal multi-underline-1" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
	</div>


</footer><!-- #site-footer -->