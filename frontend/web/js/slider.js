function calculateWidth() {
    let totalWidth = 0;
    $('.slider-item').each(function () {
        totalWidth += parseInt($(this).outerWidth(true), 10);
    });
    return totalWidth;
}

let totalWidth = calculateWidth();
let totalOffset = 0;

$(window).resize(function () {
    totalWidth = calculateWidth();
});

$('#slider-next').on('click', function () {
    let $slider = $(this).closest('.slider');
    let $sliderWin = $slider.find('.slider-win');
    let $item = $sliderWin.find('.slider-item');
    let move = $item.outerWidth(true);

    if (totalOffset > -totalWidth + $slider.width()) {
        totalOffset -= move;
        $sliderWin.animate(
            { 'margin-left': '-=' + move },
            1000
        );
    }
});

$('#slider-prev').on('click', function () {
    let $slider = $(this).closest('.slider');
    let $sliderWin = $slider.find('.slider-win');
    let $item = $sliderWin.find('.slider-item');
    let move = $item.outerWidth(true);
    let posX = $sliderWin.offset().left;

    if (posX <= 0) {
        totalOffset += move;
        $sliderWin.animate(
            { 'margin-left': '+=' + move },
            1000
        );
    } else {
        totalOffset = 0;
        $sliderWin.animate(
            { 'margin-left': '0px' },
            1000
        );
    }
});