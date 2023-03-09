$(document).ready(function () {
    let $startDatetime = $('.start-datetime');
    let $endDatetime = $('.end-datetime');
    let $totalPrice = $('#total-price');
    let $rentalPrice = $('#rental-price');
    let $calculatePrice = $("#calculate-price");
    let $rent = $('#rent');

    $startDatetime.on('input', function () {
        $rent.prop('disabled', true);
    });

    $endDatetime.on('input', function () {
        $rent.prop('disabled', true);
    });

    function calculatePrice() {
        let startDatetime = new Date($startDatetime.val());
        let endDatetime = new Date($endDatetime.val());
        let rentalPrice = +$rentalPrice.val();

        if (startDatetime < endDatetime) {
            let totalPrice = 0;

            if (startDatetime.getMinutes() > 0)
                startDatetime.setTime(startDatetime.getTime() - startDatetime.getMinutes() * 1000 * 60);

            if (endDatetime.getMinutes() > 0) {
                endDatetime.setTime(endDatetime.getTime() - endDatetime.getMinutes() * 1000 * 60);
                totalPrice += rentalPrice;
            }

            totalPrice += rentalPrice * Math.ceil((endDatetime.getTime() - startDatetime.getTime()) / (60 * 60 * 1000));

            $rent.prop('disabled', false);
            $totalPrice.attr('value', totalPrice);
            $totalPrice.val(totalPrice);
        } else {
            Toast.fire({
                icon: 'error',
                text: 'Даты некорректны!'
            });
        }
    }

    $calculatePrice.on("click", calculatePrice);
});