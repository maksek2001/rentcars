<?php

use common\models\shop\Car;
use yii\bootstrap5\Html;
use yii\helpers\Url;

?>

<div class='car'>
    <a href="<?= Url::to("@web/images/cars/$car->image") ?>" target='_blank'>
        <?php if ($car->is_popular) : ?>
            <span class="popular">Популярный автомобиль</span>
        <?php endif; ?>
        <img class='car-image' src="/images/cars/<?= $car->image ?>" alt='изображение автомобиля'>
    </a>
    <div class="car-info-container">
        <p class='car-name'><?= Html::encode($car->name) ?></p>
        <div class="car-control">
            <p class='price'><?= Html::encode($car->rental_price) ?> ₽ / час</p>
            <p class=rent-button>
                <a class='btn btn-primary' href="<?= Url::toRoute(['rent/index', 'carId' => $car->id]) ?>">
                    Арендовать
                </a>
            </p>
        </div>
        <div class="car-info">
            <div class="left-info">
                <p>
                    <svg class="icon-large transmission-icon" fill="currentColor" width="800px" height="800px" viewBox="0 0 122.88 122.88" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="enable-background:new 0 0 122.88 122.88" xml:space="preserve">
                        <g>
                            <path d="M61.44,21.74c10.96,0,20.89,4.44,28.07,11.63c7.18,7.18,11.63,17.11,11.63,28.07c0,10.96-4.44,20.89-11.63,28.07 c-7.18,7.18-17.11,11.63-28.07,11.63c-10.96,0-20.89-4.44-28.07-11.63c-7.18-7.18-11.63-17.11-11.63-28.07 c0-10.96,4.44-20.89,11.63-28.07C40.55,26.19,50.48,21.74,61.44,21.74L61.44,21.74z M61.44,0c16.97,0,32.33,6.88,43.44,18 c11.12,11.12,18,26.48,18,43.44c0,16.97-6.88,32.33-18,43.44c-11.12,11.12-26.48,18-43.44,18c-16.97,0-32.33-6.88-43.44-18 C6.88,93.77,0,78.41,0,61.44C0,44.47,6.88,29.11,18,18C29.11,6.88,44.47,0,61.44,0L61.44,0z M93.47,29.41 c-8.2-8.2-19.52-13.27-32.03-13.27c-12.51,0-23.83,5.07-32.03,13.27c-8.2,8.2-13.27,19.52-13.27,32.03 c0,12.51,5.07,23.83,13.27,32.03c8.2,8.2,19.52,13.27,32.03,13.27c12.51,0,23.83-5.07,32.03-13.27c8.2-8.2,13.27-19.52,13.27-32.03 C106.74,48.93,101.67,37.61,93.47,29.41L93.47,29.41z M65.45,56.77c-1.02-1.02-2.43-1.65-4.01-1.65c-1.57,0-2.99,0.63-4.01,1.65 l-0.01,0.01c-1.02,1.02-1.65,2.43-1.65,4.01c0,1.57,0.63,2.99,1.65,4.01l0.01,0.01c1.02,1.02,2.43,1.65,4.01,1.65 c1.57,0,2.99-0.63,4.01-1.65l0.01-0.01c1.02-1.02,1.65-2.44,1.65-4.01C67.1,59.21,66.47,57.8,65.45,56.77L65.45,56.77L65.45,56.77z M65.06,50.79c1.47,0.54,2.8,1.39,3.89,2.48l0,0l0,0c0.37,0.37,0.72,0.77,1.03,1.2l0.1-0.03l21.02-5.63 c-1.63-3.83-3.98-7.28-6.88-10.17c-5.03-5.03-11.72-8.41-19.17-9.24v21.12C65.07,50.61,65.07,50.7,65.06,50.79L65.06,50.79z M72.04,61.63c-0.14,1.73-0.69,3.35-1.57,4.76c0.05,0.06,0.09,0.13,0.13,0.2l12.07,19.13c0.54-0.47,1.06-0.96,1.57-1.47 c5.83-5.83,9.44-13.9,9.44-22.8c0-1.87-0.16-3.7-0.47-5.49L72.04,61.63L72.04,61.63z M64.57,70.95c-0.99,0.31-2.04,0.47-3.13,0.47 c-0.98,0-1.93-0.13-2.84-0.38L46.82,90.19c4.39,2.24,9.36,3.5,14.62,3.5c5.46,0,10.6-1.36,15.11-3.75L64.57,70.95L64.57,70.95z M52.57,66.64c-0.92-1.38-1.52-2.99-1.7-4.71l-0.01,0l-21.09-6.6c-0.38,1.98-0.58,4.02-0.58,6.11c0,8.9,3.61,16.97,9.44,22.8 c0.63,0.63,1.29,1.24,1.98,1.82l11.8-19.19C52.47,66.8,52.52,66.72,52.57,66.64L52.57,66.64z M52.72,54.72 c0.36-0.51,0.76-1,1.21-1.44l0,0l0,0c1.05-1.04,2.31-1.87,3.71-2.41c-0.01-0.11-0.02-0.23-0.02-0.34v-21.1 c-7.38,0.87-14,4.23-18.98,9.22c-2.75,2.75-5.01,6-6.63,9.6L52.72,54.72L52.72,54.72z" />
                        </g>
                    </svg>
                    <strong> Привод: </strong>
                    <?= Car::DRIVE_TYPES[$car->drive] ?>
                </p>
                <p>
                    <svg class="icon-large transmission-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M8 11h3V6a1 1 0 0 1 2 0v5h3v-1a1 1 0 0 1 2 0v2a.997.997 0 0 1-1 1h-4v5a1 1 0 0 1-2 0v-5H8v5a1 1 0 0 1-2 0V6a1 1 0 1 1 2 0v5zm9-7a2 2 0 1 1 0 4 2 2 0 0 1 0-4z"></path>
                    </svg>
                    <strong> КПП: </strong>
                    <?= Car::TRANSMISSION_TYPES[$car->transmission] ?>
                </p>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon bi bi-calendar-check" viewBox="0 0 16 16">
                        <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                        <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                    </svg>
                    <strong> Год выпуска: </strong>
                    <?= Html::encode($car->year_of_release) ?>
                </p>
            </div>
            <div class="right-info">
                <p>
                    <svg class="icon-large engine-icon" width="30" height="30" viewBox="0 0 30 30" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M27.72 14.1543L26.5586 11.6786C26.4339 11.4128 26.1544 11.2413 25.8457 11.2413H23.921C23.4906 11.2413 23.1417 11.5697 23.1417 11.9749V13.1312H22.543V12.1798C22.543 11.7746 22.1941 11.4462 21.7637 11.4462H19.6889V9.4446C19.6889 9.03939 19.34 8.71105 18.9096 8.71105H15.076V8.01251H18.9096C19.34 8.01251 19.6889 7.68408 19.6889 7.27896C19.6889 6.87375 19.34 6.54541 18.9096 6.54541H9.68398C9.2536 6.54541 8.90469 6.87375 8.90469 7.27896C8.90469 7.68408 9.2536 8.01251 9.68398 8.01251H13.5176V8.71105H9.68398C9.2536 8.71105 8.90469 9.03939 8.90469 9.4446V10.0543H7.19502C6.76464 10.0543 6.41572 10.3827 6.41572 10.7879V14.7243H5.34507V10.7879C5.34507 10.3827 4.99616 10.0543 4.56578 10.0543C4.1354 10.0543 3.78648 10.3828 3.78648 10.7879V20.1281C3.78648 20.5333 4.1354 20.8616 4.56578 20.8616C4.99616 20.8616 5.34507 20.5333 5.34507 20.1281V16.1914H6.41572V20.1281C6.41572 20.5333 6.76464 20.8616 7.19502 20.8616H10.2227L13.2992 23.2835C13.4395 23.3939 13.6163 23.4544 13.7992 23.4544H21.7638C22.1942 23.4544 22.5431 23.126 22.5431 22.7208V20.7212H23.1418V21.8775C23.1418 22.2827 23.4907 22.6111 23.9211 22.6111H25.8458C26.1545 22.6111 26.434 22.4396 26.5587 22.1738L27.7201 19.6981C27.7638 19.6048 27.7865 19.5038 27.7865 19.4018V14.4506C27.7865 14.3486 27.7638 14.2476 27.72 14.1543ZM26.2279 19.2472L25.3381 21.1441H24.7004V19.9877C24.7004 19.5825 24.3515 19.2541 23.9211 19.2541H21.7638C21.3334 19.2541 20.9845 19.5825 20.9845 19.9877V21.9874H14.082L11.0056 19.5655C10.8653 19.455 10.6884 19.3946 10.5056 19.3946H7.97431V11.5214H9.68398C10.1144 11.5214 10.4633 11.1931 10.4633 10.7879V10.1782H18.1304V12.18C18.1304 12.5852 18.4793 12.9135 18.9097 12.9135H20.9845V13.865C20.9845 14.2702 21.3334 14.5985 21.7638 14.5985H23.9211C24.3515 14.5985 24.7004 14.2702 24.7004 13.865V12.7085H25.3381L26.2279 14.6054V19.2472Z"></path>
                    </svg>
                    <strong> Мощность: </strong>
                    <?= Html::encode($car->power) . ' л.с.' ?>
                </p>
                <p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon bi bi-people-fill" viewBox="0 0 16 16">
                        <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z" />
                    </svg>
                    <strong> Количество мест: </strong>
                    <?= Html::encode($car->places_count) ?>
                    <span class="explanation" data-text="Количество мест в автомобиле, включая водительское место">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="icon-small bi bi-info-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                        </svg>
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>