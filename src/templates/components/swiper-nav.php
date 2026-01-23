<?php
/**
 * @var array{prefix:string} $args
 */
$prefix = isset( $args['prefix'] ) ? $args['prefix'] : 'default';

?>
<button class="swiper-btn-prev-<?php echo $prefix; ?> w-8 h-8 flex items-center justify-center hover:bg-gray-300 rounded">
	<svg xmlns="http://www.w3.org/2000/svg" class="h-5 block fill-current" viewBox="0 0 20 20">
		<path d="M13.891 17.418a.697.697 0 0 1 0 .979a.68.68 0 0 1-.969 0l-7.83-7.908a.697.697 0 0 1 0-.979l7.83-7.908a.68.68 0 0 1 .969 0a.697.697 0 0 1 0 .979L6.75 10z"/>
	</svg>
</button>
<button class="swiper-btn-next-<?php echo $prefix; ?> w-8 h-8 flex items-center justify-center hover:bg-gray-300 rounded">
	<svg xmlns="http://www.w3.org/2000/svg" class="h-5 block fill-current" viewBox="0 0 20 20">
		<path d="M13.25 10L6.109 2.58a.697.697 0 0 1 0-.979a.68.68 0 0 1 .969 0l7.83 7.908a.697.697 0 0 1 0 .979l-7.83 7.908a.68.68 0 0 1-.969 0a.697.697 0 0 1 0-.979z"/>
	</svg>
</button>