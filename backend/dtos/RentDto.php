<?php

namespace backend\dtos;

use backend\dtos\ClientDto;

class RentDto
{
    /** @var int */
    public $id;

    /** @var string */
    public $startDatetime;

    /** @var string */
    public $endDatetime;

    /** @var float */
    public $totalPrice;

    /** @var int */
    public $childSafetySeatCount;

    /** @var string */
    public $status;

    /** @var int */
    public $carId;

    /** @var string */
    public $carName;

    /** @var string */
    public $carImage;

    /** @var ClientDto */
    public $client;

    public function __construct(array $array)
    {
        $this->id = $array['id'];
        $this->startDatetime = $array['start_datetime'];
        $this->endDatetime = $array['end_datetime'];
        $this->totalPrice = $array['total_price'];
        $this->childSafetySeatCount = $array['child_safety_seat_count'];
        $this->status = $array['status'];
        $this->carId = $array['car_id'];
        $this->carName = $array['car_name'];
        $this->carImage = $array['car_image'];
        $this->client = new ClientDto($array);
    }
}
