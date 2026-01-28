const mapBlock = document.getElementById('map-block');

const mapBlockItems = mapBlock.querySelectorAll('.map-block_item');
const mapBlockDots = mapBlock.querySelectorAll('.map-block_dot');

mapBlockDots.forEach((mapBlockDot, index) => {
    mapBlockDot.addEventListener('click',() => {
       mapBlockDots.forEach(mapBlockDot => {
           mapBlockDot.classList.remove('is-active');
       });
        mapBlockItems.forEach(mapBlockItem => {
            mapBlockItem.classList.remove('is-active');
        });

        mapBlockDot.classList.add('is-active');
        mapBlockItems[index].classList.add('is-active');
    });
});


