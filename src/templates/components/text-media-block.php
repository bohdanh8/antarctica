<?php
$text_image_block = get_sub_field("text_and_media");
$heading_1        = ! empty($text_image_block["heading_1"]) ? $text_image_block["heading_1"] : '';
$heading_2        = ! empty($text_image_block["heading_2"]) ? $text_image_block["heading_2"] : '';
$text             = ! empty($text_image_block["text"]) ? $text_image_block["text"] : '';
$button           = ! empty($text_image_block["button"]) ? $text_image_block["button"] : '';
$media_element    = ! empty($text_image_block["media_element"]) ? $text_image_block["media_element"] : '';
$media_element 	  = get_media_element(['media_element' => $media_element, 'autoplay' => true]);
$image_position   = ($media_element && $text_image_block["image_position"] === 'right') ? 'flex-row-reverse' : '';

?>

<?php if ($heading_1 || $heading_2 || $text || $media_element): ?>
	<div class="container">
		<div class="flex flex-col gap-8 md:flex-row lg:gap-16 <?php echo $image_position; ?>">
			<?php if ($media_element): ?>
				<div class="w-full h-full aspect-square lg:aspect-video <?php echo !empty($image_position) ? 'ease-right' : 'ease-left'; ?>" data-scroll>
					<?php echo $media_element; ?>
				</div>
			<?php endif; ?>
			<?php if ($heading_1 || $heading_2 || $text || $button): ?>
				<div class="w-full <?php echo !empty($image_position) ? 'ease-left' : 'ease-right'; ?>" data-scroll>
					<?php if ($heading_1): ?>
						<p><?php echo esc_html($heading_1); ?></p>
					<?php endif; ?>
					<?php if ($heading_2): ?>
						<h2><?php echo esc_html($heading_2); ?></h2>
					<?php endif; ?>
					<?php if ($text): ?>
						<p><?php echo wp_kses_post($text); ?></p>
					<?php endif; ?>
					<?php if ($button): ?>
						<?php echo get_button($button, "button button-alt"); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>