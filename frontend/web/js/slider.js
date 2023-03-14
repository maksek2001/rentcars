function calculateSliderWidth($slider) {
    let sliderWidth = 0;

    $slider.find('.slider-item').each(function () {
        sliderWidth += $(this).outerWidth(true);
    });

    return sliderWidth;
}

$(document).ready(function () {
    let totalOffsets = new Map();
    let slidersWidth = new Map();

    $('.slider').each(function () {
        let $slider = $(this);

        totalOffsets.set($slider.attr('id'), 0);
        slidersWidth.set($slider.attr('id'), calculateSliderWidth($slider));

        let $sliderControl = $slider.find('.slider-control');
        let $sliderButtons = $sliderControl.find('.slider-btn');
        let sliderHeight = $slider.find('.slider-block').outerHeight(true);
        let btnHeight = $sliderButtons.outerHeight(true);

        $slider.css({ 'height': sliderHeight });
        $sliderControl.css({ 'top': -(sliderHeight / 2 + btnHeight / 2) });
        $sliderButtons.fadeIn(500);
    });

    $('#slider-next').on('click', function () {
        let $slider = $(this).closest('.slider');
        let totalOffset = totalOffsets.get($slider.attr('id'));

        let $sliderBlock = $slider.find('.slider-block');

        let move = $sliderBlock.find('.slider-item').outerWidth(true);
        let sliderWidth = slidersWidth.get($slider.attr('id')) - $sliderBlock.outerWidth(true);

        if ((totalOffset - move) >= -sliderWidth) {
            totalOffset -= move;
            totalOffsets.set($slider.attr('id'), totalOffset);

            $sliderBlock.animate(
                { 'margin-left': '-=' + move },
                600
            );
        } else {
            let remainder = Math.abs(totalOffset + sliderWidth);
            if (remainder > 0 && remainder < move) {
                totalOffset -= remainder;
                totalOffsets.set($slider.attr('id'), totalOffset);

                $sliderBlock.animate(
                    { 'margin-left': '-=' + remainder },
                    600
                );
            }
        }
    });

    $('#slider-prev').on('click', function () {
        let $slider = $(this).closest('.slider');
        let totalOffset = totalOffsets.get($slider.attr('id'));

        let $sliderBlock = $slider.find('.slider-block');
        let $item = $sliderBlock.find('.slider-item');
        let move = $item.outerWidth(true);
        let positionX = $sliderBlock.offset().left;

        if (positionX <= 0) {
            totalOffset += move;
            totalOffsets.set($slider.attr('id'), totalOffset);

            $sliderBlock.animate(
                { 'margin-left': '+=' + move },
                600
            );
        } else {
            totalOffsets.set($slider.attr('id'), 0);

            $sliderBlock.animate(
                { 'margin-left': '0px' },
                600
            );
        }
    });
});