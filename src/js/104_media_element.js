import Player from '@vimeo/player';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import gsap from 'gsap';

gsap.registerPlugin(ScrollTrigger);
/**
 * Autoplay media element videos once it enters the viewport
 * @type {NodeListOf<Element>}
 */
const autoplayVideos = document.querySelectorAll('.autoplay-video');
if (autoplayVideos.length) {
    autoplayVideos.forEach((videoContainer) => {
        let videoElement = videoContainer.querySelector('video');
        let iframeElement = videoContainer.querySelector('iframe');

        if (!videoElement && !iframeElement) {
            return;
        }

        if (iframeElement) {
            videoElement = new Player(iframeElement);
        }

        let playPromise;

        const playVideo = () => {
            if (videoElement) {
                playPromise = videoElement.play();
            }
        };

        const pauseVideo = () => {
            if (videoElement && playPromise) {
                playPromise.then(() => videoElement.pause());
            }
        };

        ScrollTrigger.create({
            trigger: videoContainer,
            start: 'top bottom',
            end: 'bottom top',
            scrub: true,
            onEnter: playVideo,
            onEnterBack: playVideo,
            onLeave: pauseVideo,
            onLeaveBack: pauseVideo,
        });
    });
}
