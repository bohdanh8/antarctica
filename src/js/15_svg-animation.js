import gsap from 'gsap';
import { MotionPathPlugin } from 'gsap/MotionPathPlugin';
import { DrawSVGPlugin } from 'gsap/DrawSVGPlugin';

gsap.registerPlugin(MotionPathPlugin, DrawSVGPlugin);

let heroPaths = splitPaths("#hero-path");

let duration = 3,
    distance = 0,
    tl = gsap.timeline();
heroPaths.forEach(segment => distance += segment.getTotalLength());
heroPaths.forEach(segment => {
    tl.from(segment, {
        drawSVG: 0,
        ease: "none",
        duration: 2
    },"<");
});

function splitPaths(paths) {
    let toSplit = gsap.utils.toArray(paths),
        newPaths = [];
    if (toSplit.length > 1) {
        toSplit.forEach(path => newPaths.push(...splitPaths(path)));
    } else {
        let path = toSplit[0],
            rawPath = MotionPathPlugin.getRawPath(path),
            parent = path.parentNode,
            attributes = [].slice.call(path.attributes);
        newPaths = rawPath.map(segment => {
            let newPath = document.createElementNS("http://www.w3.org/2000/svg", "path"),
                i = attributes.length;
            while (i--) {
                newPath.setAttributeNS(null, attributes[i].nodeName, attributes[i].nodeValue);
            }
            newPath.setAttributeNS(null, "d", "M" + segment[0] + "," + segment[1] + "C" + segment.slice(2).join(",") + (segment.closed ? "z" : ""));
            parent.insertBefore(newPath, path);
            return newPath;
        });
        parent.removeChild(path);
    }
    return newPaths;
}

let accordionPaths = splitPaths('#accordion-path');
let accordionItems = document.querySelectorAll('.accordion-item');

accordionItems.forEach((item) => {
    item.addEventListener('click', () => {
            const anyActive = Array.from(accordionItems).some(i => i.classList.contains('is-active'));

            accordionPaths.forEach((path) => {
                path.classList.toggle('active', anyActive);
            });
    });
});