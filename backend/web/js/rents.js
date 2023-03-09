/**
 * Загрузка аренд
 * 
 * @param {string} url 
 * @param {Object} filterData 
 * @param pageElement
 */
function loadRating(url, filterData, pageElement) {
    pageElement.html('');
    pageElement.addClass('load');
    $.ajax({
        url: url,
        type: 'GET',
        data: filterData,
        dataType: 'html',
        success: function (result) {
            pageElement.removeClass('load');
            pageElement.html(result);
        },
        error: function () {
            pageElement.removeClass('load');
            Toast.fire({
                icon: 'error',
                text: 'Произошла непредвиденная ошибка'
            });
        }
    });
}

$(document).ready(function () {
    $('body').on('click', ".summary", function () {
        let $this = $(this);
        if ($this.hasClass("active")) {
            $this.next(".details").slideToggle(700, function () {
                $this.toggleClass("active");
            });
        } else {
            $this.next(".details").slideToggle(700);
            $this.toggleClass("active");
        }
    });

    let $filter = $('#filter');
    let url = $filter.attr('data-url');
    let $rents = $('#rents');

    $filter.on('click', function () {
        let statusSelect = $('#status-select').val();
        let startDatetime = $('#start-datetime').val();
        let endDatetime = $('#end-datetime').val();
        let minPrice = $('#min-price').val();
        let maxPrice = $('#max-price').val();

        if (minPrice < 0 || maxPrice < 0) {
            Toast.fire({
                icon: 'error',
                text: 'Стоимость не может быть отрицательной'
            });

            return;
        }

        if (minPrice != '' && maxPrice == '' || minPrice == '' && maxPrice != '') {
            Toast.fire({
                icon: 'error',
                text: 'Для выбора по стоимости нужно заполнить минимум и максимум'
            });

            return;
        }

        if (startDatetime != '' && endDatetime == '' || startDatetime == '' && endDatetime != '') {
            Toast.fire({
                icon: 'error',
                text: 'Для выбора по дате нужно заполнить начало и конец периода'
            });

            return;
        }

        if (statusSelect == '' && startDatetime == '' && endDatetime == '') {
            BootstrapSwal.fire({
                text: 'Возможна выгрузка большого объёма данных, желаете продолжить?',
                confirmButtonText: 'Да',
                denyButtonText: 'Нет',
                icon: 'question',
                showDenyButton: true,
                showCloseButton: true
            }).then((result) => {
                if (result.isConfirmed) {
                    let filterData = {
                        'status': statusSelect,
                        'startDatetime': startDatetime,
                        'endDatetime': endDatetime,
                        'minPrice': minPrice,
                        'maxPrice': maxPrice
                    };

                    loadRating(url, filterData, $rents);
                }
            });
        } else {
            let filterData = {
                'status': statusSelect,
                'startDatetime': startDatetime,
                'endDatetime': endDatetime,
                'minPrice': minPrice,
                'maxPrice': maxPrice
            };

            loadRating(url, filterData, $rents);
        }
    });
});
