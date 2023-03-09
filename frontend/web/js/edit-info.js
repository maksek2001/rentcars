$(document).ready(function () {
    $('.contact-form').on('beforeSubmit', function () {
        let $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serializeArray(),
            success: function (result) {
                if (result.success) {
                    if (result.emailChanged) {
                        Toast.fire({
                            icon: 'success',
                            text: 'Данные сохранены. На вашу электронную почту было выслано сообщение.',
                            timer: 7000,
                        });
                    } else {
                        Toast.fire({
                            icon: 'success',
                            text: 'Данные сохранены'
                        });
                    }
                } else {
                    Toast.fire({
                        icon: 'error',
                        text: 'Не удалось сохранить данные'
                    });
                }
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    text: 'Произошла непредвиденная ошибка'
                });
            }
        });

        return false;
    });

    $('.ajax-form').on('beforeSubmit', function () {
        let $form = $(this);
        $.ajax({
            type: $form.attr('method'),
            url: $form.attr('action'),
            data: $form.serializeArray(),
            success: function (result) {
                if (result.success) {
                    Toast.fire({
                        icon: 'success',
                        text: 'Данные сохранены'
                    });
                } else {
                    Toast.fire({
                        icon: 'error',
                        text: 'Не удалось сохранить данные'
                    });
                }
            },
            error: function () {
                Toast.fire({
                    icon: 'error',
                    text: 'Произошла непредвиденная ошибка'
                });
            }
        });

        return false;
    });
});