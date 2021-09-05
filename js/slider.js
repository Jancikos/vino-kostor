const slider = $('#slider');
const sliderItems = $('#slider .slider-item');
const sliderRadios = $('#slider .slider-radio');

$('#slider-next').on('click', async () => {
    nextSliderItem();
});

$('#slider-previous').on('click', () => {
    const activeItem = slider.find('.slider-item.active');
    const activeIndex = sliderItems.index(activeItem);
    var previousIndex = activeIndex - 1;

    if (previousIndex < 0) {
        previousIndex = sliderItems.length - 1;
    }

    showSliderItem(activeIndex, previousIndex);
});

$('#slider #slider-navigation .slider-radio').on('click', (e) => {
    const activeRadio = slider.find('.slider-radio.active');
    showSliderItem(sliderRadios.index(activeRadio), sliderRadios.index(e.target));
});

function nextSliderItem() {
    const activeItem = slider.find('.slider-item.active');
    const activeIndex = sliderItems.index(activeItem);
    var nextIndex = activeIndex + 1;

    if (nextIndex >= sliderItems.length) {
        nextIndex = 0;
    }

    showSliderItem(activeIndex, nextIndex);
}

function showSliderItem(activeIndex, nextIndex) {
    console.log('show item ' + nextIndex);

    // slider.find('.active').fadeOut();
    sliderItems.eq(activeIndex).fadeOut(500);

    slider.find('.active').removeClass('active');
    sliderItems[nextIndex].classList.add('active');
    sliderRadios[nextIndex].classList.add('active');

    sliderItems.eq(nextIndex).fadeIn(1000);
    sliderRadios[nextIndex].checked = true;
}

setInterval((e) => {
    nextSliderItem();
}, 15000);