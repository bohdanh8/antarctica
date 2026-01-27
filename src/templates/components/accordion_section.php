<?php
$accordion_section = get_sub_field("accordion_section");
$accordion         = ! empty($accordion_section["accordion"]) ? $accordion_section["accordion"] : [];
$eyebrow_text = ! empty($accordion_section['eyebrow_text']) ? $accordion_section['eyebrow_text'] : '';
$section_heading = ! empty($accordion_section['section_heading']) ? $accordion_section['section_heading'] : '';
$text_area_first = ! empty($accordion_section['text_area_first']) ? $accordion_section['text_area_first'] : '';
$section_subheading = ! empty($accordion_section['section_subheading']) ? $accordion_section['section_subheading'] : '';
$text_area_second = ! empty($accordion_section['text_area_second']) ? $accordion_section['text_area_second'] : '';
$accordion_title = ! empty($accordion_section['accordion_title']) ? $accordion_section['accordion_title'] : '';
$accordion_svg_code = ! empty($accordion_section['accordion_svg_code']) ? $accordion_section['accordion_svg_code'] : '';

if ($accordion) : ?>
	<div class="container max-w-full w-full m-0 p-0 bg-light-blue">
        <div class="container pt-36 pb-36">
            <div>
                <?php if (!empty($eyebrow_text)): ?>
                    <p class="font-bold text-3.5 mt-0 mb-12 leading-none uppercase pt-4 border-t border-[#96C5D9] ease-left" data-scroll>
                        <?php echo esc_html($eyebrow_text); ?>
                    </p>
                <?php endif; ?>
                <?php if (!empty($section_heading)): ?>
                    <h1 class="font-light my-0 max-w-[850px] w-full text-navy-blue mb-[4.5rem] ease-left" data-scroll>
                        <?php echo esc_html($section_heading); ?>
                    </h1>
                <?php endif; ?>
                <?php if (!empty($text_area_first)): ?>
                    <h4 class="font-light max-w-[1080px] text-navy-blue mb-[4.5rem] ease-left" data-scroll>
                        <?php echo wp_kses_post($text_area_first); ?>
                    </h4>
                <?php endif; ?>
            </div>
            <div class="pt-[4.5rem] border-t border-[#96C5D9]">
                <?php if (!empty($section_subheading)): ?>
                    <h3 class="font-medium text-navy-blue mb-12 ease-left" data-scroll>
                        <?php echo wp_kses_post($section_subheading); ?>
                    </h3>
                <?php endif; ?>
                <?php if (!empty($text_area_second)): ?>
                    <h4 class="font-light max-w-[1080px] text-navy-blue mb-[4.5rem] ease-left" data-scroll>
                        <?php echo wp_kses_post($text_area_second); ?>
                    </h4>
                <?php endif; ?>
            </div>
            <div class="pt-12 border-t border-[#96C5D9] grid grid-cols-2">
                <div class="accordion accordion-container accordions-list">
                    <?php if (!empty($accordion_title)): ?>
                        <h3 class="font-medium text-navy-blue mb-12 ease-left" data-scroll>
                            <?php echo wp_kses_post($accordion_title); ?>
                        </h3>
                    <?php endif; ?>
                    <?php foreach ($accordion as $accordion_item) : ?>
                        <div class="group/accordion-item mb-7 sm:mb-8 last:mb-0 ease-btm accordion-item accordion-button max-w-[42rem]" data-scroll>
                            <div class="group/accordion-header accordion-header">
                                <h3 class="border-current border-b">
                                    <button class="h3 font-light text-navy-blue opacity-50 flex justify-between items-center pb-4 gap-2.5 pr-4 sm:pr-2.5 outline-none w-full text-left accordion-trigger duration-500 group-[.is-active]/accordion-item:text-bright-blue group-[.is-active]/accordion-item:opacity-100">
                                        <?php echo esc_html($accordion_item['heading']) ?? ''; ?>
                                    </button>
                                </h3>
                            </div>
                            <div class="accordion-body">
                                <div class="w-full">
                                    <div class="pt-8">
                                        <p class="font-light text-navy-blue text-[1rem] leading-[1.3]"><?php echo esc_html($accordion_item['text']); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="accordion-svg flex justify-end ease-right" data-scroll>
                    <?php echo $accordion_svg_code; ?>
                </div>
            </div>
        </div>
	</div>
<?php endif; ?>