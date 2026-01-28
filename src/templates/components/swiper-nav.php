<?php
/**
 * @var array{prefix:string} $args
 */
$prefix = isset( $args['prefix'] ) ? $args['prefix'] : 'default';

?>
<button class="swiper-btn-prev-<?php echo $prefix; ?> w-8 h-8 flex items-center justify-center">
    <svg width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M10.1253 18.8363L1.41418 10.1252M1.41418 10.1252L10.1253 1.41406M1.41418 10.1252L23.8142 10.1252" stroke="#071359" stroke-width="2" stroke-linecap="square"/>
    </svg>
</button>
<button class="swiper-btn-next-<?php echo $prefix; ?> w-8 h-8 flex items-center justify-center">
    <svg width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M14.6889 1.41406L23.4 10.1252M23.4 10.1252L14.6889 18.8363M23.4 10.1252L1 10.1252" stroke="#071359" stroke-width="2" stroke-linecap="square"/>
    </svg>
</button>