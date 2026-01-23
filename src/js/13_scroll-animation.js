import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

gsap.registerPlugin(ScrollTrigger);

const animatedElements = document.querySelectorAll('[data-scroll]');

if (animatedElements.length) {
    animatedElements.forEach(element => {
        const triggerPosition = element.classList.contains('ease-btm') ? '-25 bottom' : '100 bottom';
        ScrollTrigger.create({
            trigger: element,
            start: triggerPosition,
            onEnter: () => {
                element.setAttribute('data-scroll', 'in');
            }
        });
    });
}
