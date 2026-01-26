<?php
$text_image_block = get_sub_field("text_and_media");
$heading_1        = ! empty($text_image_block["heading_1"]) ? $text_image_block["heading_1"] : '';
$heading_2        = ! empty($text_image_block["heading_2"]) ? $text_image_block["heading_2"] : '';
$text             = ! empty($text_image_block["text"]) ? $text_image_block["text"] : '';
//$button           = ! empty($text_image_block["button"]) ? $text_image_block["button"] : '';
$media_element    = ! empty($text_image_block["media_element"]) ? $text_image_block["media_element"] : '';
$media_element 	  = get_media_element(['media_element' => $media_element, 'autoplay' => true]);
$image_position   = ($media_element && $text_image_block["image_position"] === 'right') ? 'flex-row-reverse' : '';

?>

<?php if ($heading_1 || $heading_2 || $text || $media_element): ?>
	<div class="container flex flex-col gap-36 pt-[4.5rem] pb-36">
        <div class="flex flex-col gap-12 pt-3 border-t border-divider-light-blue">
            <?php if ($heading_1): ?>
                <p class="text-off-black text-[14px] font-bold uppercase"><?php echo esc_html($heading_1); ?></p>
            <?php endif; ?>
            <?php if ($heading_2): ?>
                <h1 class="my-0 font-light text-navy-blue"><?php echo esc_html($heading_2); ?></h1>
            <?php endif; ?>
        </div>
		<div class="flex gap-8 md: flex-row items-end <?php echo $image_position; ?>">
            <?php if ($media_element): ?>
                <div class="w-full h-full aspect-square lg:aspect-video <?php echo !empty($image_position) ? 'ease-right' : 'ease-left'; ?>" data-scroll>
                    <?php echo $media_element; ?>
                </div>
            <?php endif; ?>
			<?php if ($heading_1 || $heading_2 || $text): ?>
				<div class="w-full <?php echo !empty($image_position) ? 'ease-left lg:pr-[8.5rem]' : 'ease-right lg:pl-[8.5rem]'; ?>" data-scroll>
					<?php if ($text): ?>
						<p class="mb-0 pt-4 border-t border-divider-light-blue font-light text-navy-blue"><?php echo wp_kses_post($text); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>