<?php
/**
 * @var array{member_id:int} $args
 */

$member_id = isset( $args['member_id'] ) ? (int) $args['member_id'] : 0;
$member    = get_field( "team_member_-_info", $member_id );
?>
<article <?php post_class( $member_id ); ?>>
	<a class="link-with-zoom-img" href="<?php echo get_permalink( $member_id ); ?>">
		<div class="aspect-square mb-2">
			<?php $image = [ 'image' => get_post_thumbnail_id( $member_id ) ]; ?>
			<?php echo get_attachment_fallback( $image, "26vw", "500px", false, "avatar" ); ?>
		</div>
		<h5> <?php echo esc_html( get_the_title( $member_id ) ); ?> </h5>
		<?php if ( ! empty( $member['position'] ) ): ?>
			<p><?php echo esc_html( $member['position'] ); ?></p>
		<?php endif; ?>
	</a>
</article>