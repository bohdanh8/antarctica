<?php
$team_section = get_sub_field("team_section");
$heading      = ! empty($team_section["heading"]) ? $team_section["heading"] : '';
$text         = ! empty($team_section["text"]) ? $team_section["text"] : '';
$button       = ! empty($team_section["button"]["link_text"]) ? $team_section["button"] : '';
$layout       = ! empty($team_section["layout"]) ? $team_section["layout"] : '';
$team_members = ! empty($team_section["team_members"]) ? $team_section["team_members"] : '';
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

<?php if ($team_members): ?>
	<div class="px-side-offset ease-btm <?php echo $layout === "grid" ? "" : "swiper about-team"; ?>" data-scroll>
		<div class="<?php echo $layout === "grid" ? "grid grid-cols-1 sm:grid-cols-2 2xl:grid-cols-4 gap-6" : "swiper-wrapper"; ?>">
			<?php foreach ($team_members as $key => $member):
			?>
				<div class="<?php echo $layout === "grid" ? "" : "swiper-slide"; ?>">
					<?php get_component('loop-team', ['member_id' => $member["team"]]); ?>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if ($layout === "slider"): ?>
			<div class="swiper-nav flex gap-x-8 my-8 <?php echo count($team_members) <= 2 ? 'lg:hidden' : ''; ?>">
				<?php get_component('swiper-nav', ['prefix' => 'team']); ?>
			</div>
		<?php endif; ?>
	</div>
<?php endif; ?>

<?php if ($button): ?>
	<div class="py-8 ease-left container" data-scroll>
		<?php echo get_button($button, "button button-alt"); ?>
	</div>
<?php endif; ?>