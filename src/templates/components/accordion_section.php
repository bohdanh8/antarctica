<?php
$accordion_section = get_sub_field("accordion_section");
$accordion         = ! empty($accordion_section["accordion"]) ? $accordion_section["accordion"] : [];

if ($accordion) : ?>
	<div class="container">
		<div class="accordion accordion-container accordions-list">
			<?php foreach ($accordion as $accordion_item) : ?>
				<div class="group/accordion-item mb-7 sm:mb-8 last:mb-0 ease-btm accordion-item accordion-button" data-scroll>
					<div class="group/accordion-header accordion-header">
						<h2 class="border-current border-b">
							<button class="flex justify-between items-center gap-2.5 pr-4 sm:pr-2.5 outline-none w-full text-left accordion-trigger">
								<?php echo esc_html($accordion_item['heading']) ?? ''; ?>
								<span class="ml-auto w-5 sm:w-7 h-5 sm:h-7 accordion-icon-1"></span>
							</button>
						</h2>
					</div>
					<div class="accordion-body">
						<div class="w-full">
							<div class="py-4 sm:py-8">
								<?php echo wp_kses_post($accordion_item['text']) ?? ''; ?>
								<?php echo get_button($accordion_item["button"], "button button-alt"); ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
<?php endif; ?>