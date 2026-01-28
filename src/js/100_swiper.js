// Swiper Import from npm package

// core version + navigation, pagination modules:
import Swiper from 'swiper';
import {Autoplay, EffectFade, Navigation} from 'swiper/modules';
// import Swiper and modules styles
import 'swiper/css';
import 'swiper/css/autoplay';
import 'swiper/css/effect-fade';


const swiperHero = document.querySelector( '.hero-section .swiper' );
if ( swiperHero ) {
	new Swiper( '.hero-section .swiper', {
		modules: [Autoplay, EffectFade],
		loop: false,
		effect: 'fade',
		slidesPerView: 1,
		fadeEffect: {
			crossFade: true,
		},
		speed: 2000,
		autoplay: true,
		allowTouchMove: false,
	} );
}

/**
 * Team Section Slider
 */

const swiperTeam = document.querySelectorAll( '.about-team.swiper' );
if ( swiperTeam ) {
	new Swiper( '.about-team', {
		modules: [Navigation],
		loop: false,
		grabCursor: true,
		slidesPerView: 3.25,
		spaceBetween: 50,
		navigation: {
			nextEl: '.swiper-btn-next-team',
			prevEl: '.swiper-btn-prev-team',
		},
		breakpoints: {
			100: {
				spaceBetween: 20,
				slidesPerView: 1.25,
			},
			1024: {
				spaceBetween: 20,
				slidesPerView: 2.25,
			},
			1440: {
				spaceBetween: 50,
				slidesPerView: 3.25,
			},
		},
	} );
}

/**
 * News Section Slider
 */

const swiperNews = document.querySelectorAll( '.news.swiper' );
if ( swiperNews ) {
	new Swiper( '.news', {
		modules: [Navigation],
		loop: false,
		grabCursor: true,
		slidesPerView: 2,
		spaceBetween: 24,
		navigation: {
			nextEl: '.swiper-btn-next-news',
			prevEl: '.swiper-btn-prev-news',
		},
		breakpoints: {
			100: {
				spaceBetween: 20,
				slidesPerView: 1.25,
			},
			1024: {
				spaceBetween: 20,
				slidesPerView: 2,
			},
			1440: {
				spaceBetween: 24,
				slidesPerView: 2,
			},
		},
	} );
}
