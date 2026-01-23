<?php
$two_column_text = get_sub_field("two_column_text");
$left_column     = ! empty($two_column_text["left_column"]) ? $two_column_text["left_column"] : '';
$right_column    = ! empty($two_column_text["right_column"]) ? $two_column_text["right_column"] : '';
?>

<?php if (! empty($left_column["heading"]) || ! empty($left_column["text"]) || ! empty($right_column["heading"]) || ! empty($right_column["text"])): ?>
	<div class="container">
		<div class="flex gap-8 max-md:flex-col lg:gap-16">
			<?php if ($left_column): ?>
				<div class="w-full ease-left" data-scroll>
					<?php if (! empty($left_column["heading"])): ?>
						<h2><?php echo esc_html($left_column["heading"]); ?></h2>
					<?php endif; ?>
					<?php if (! empty($left_column["text"])): ?>
						<p><?php echo wp_kses_post($left_column["text"]); ?></p>
					<?php endif; ?>
					<?php if (! empty($left_column["button"])): ?>
						<?php echo get_button($left_column["button"], "button button-alt"); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php if ($right_column): ?>
				<div class="ease-right w-full" data-scroll>
					<?php if (! empty($right_column["heading"])): ?>
						<h2><?php echo esc_html($right_column["heading"]); ?></h2>
					<?php endif; ?>
					<?php if (! empty($right_column["text"])): ?>
						<p><?php echo wp_kses_post($right_column["text"]); ?></p>
					<?php endif; ?>
					<?php if (! empty($right_column["button"])): ?>
						<?php echo get_button($right_column["button"], "button button-alt"); ?>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endif; ?>