<?php

namespace frontend\controllers;

use common\models\Client;
use common\models\shop\Car;
use common\models\client_info\PassportInfo;
use common\models\client_info\DrivingLicenseInfo;
use yii\web\NotFoundHttpException;
use common\models\shop\Rent;
use frontend\models\forms\office\ClientInfoForm;
use frontend\models\forms\office\PassportForm;
use frontend\models\forms\office\ContactInfoForm;
use frontend\models\forms\office\DrivingLicenseInfoForm;
use yii\data\Pagination;
use Yii;

class OfficeController extends SiteController
{
    public $layout = 'office';

    private $_pageSize = 6;

    public function actionIndex()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $client = Client::findOne(Yii::$app->user->id);

        if ($client->status == Client::STATUS_INACTIVE)
            Yii::$app->session->setFlash('info', 'Для управления текущими арендами и для аренды новых автомобилей вам нужно подтвердить ваш адрес электронной почты');

        $clientInfoForm = new ClientInfoForm();

        $clientInfoForm->fullname = $client->fullname ? $client->fullname : '';
        $clientInfoForm->birthDate = $client->birth_date ? $client->birth_date : '';

        $contactInfoForm = new ContactInfoForm();

        $contactInfoForm->email = $client->email;
        $contactInfoForm->phone = $client->phone ? $client->phone : '';

        $passportInfo = PassportInfo::findOne(Yii::$app->user->id);
        $passportInfoForm = new PassportForm();

        if ($passportInfo) {
            $passportInfoForm->serie = $passportInfo->serie;
            $passportInfoForm->number = $passportInfo->number;
            $passportInfoForm->issueDate = $passportInfo->issue_date;
            $passportInfoForm->issueOrganization = $passportInfo->issue_organization;
            $passportInfoForm->organizationCode = $passportInfo->organization_code;
        }

        $licenseInfo = DrivingLicenseInfo::findOne(Yii::$app->user->id);
        $licenseInfoForm = new DrivingLicenseInfoForm();

        if ($licenseInfo) {
            $licenseInfoForm->serie = $licenseInfo->serie;
            $licenseInfoForm->number = $licenseInfo->number;
            $licenseInfoForm->issueDate = $licenseInfo->issue_date;
            $licenseInfoForm->expirationDate = $licenseInfo->expiration_date;
        }

        return $this->render('index', [
            'client' => Client::findOne(Yii::$app->user->id),
            'clientInfoForm' => $clientInfoForm,
            'contactInfoForm' => $contactInfoForm,
            'passportInfoForm' => $passportInfoForm,
            'licenseInfoForm' => $licenseInfoForm,
            'passportInfo' => PassportInfo::findOne(Yii::$app->user->id),
            'licenseInfo' => DrivingLicenseInfo::findOne(Yii::$app->user->id),
        ]);
    }

    public function actionRents()
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $client = Client::findOne(Yii::$app->user->id);

        if ($client->status == Client::STATUS_INACTIVE)
            return $this->redirect(['office/index']);

        $rents = Rent::find()
            ->where(['client_id' => Yii::$app->user->id])
            ->orderBy(['start_datetime' => SORT_DESC]);

        $pagination = new Pagination(['totalCount' => $rents->count(), 'pageSize' => $this->_pageSize]);

        $rents = $rents->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $rentedCars = [];
        foreach ($rents as $rent) {
            $rentedCars[$rent->id] = Car::findOne($rent->car_id);
        }

        return $this->render('rents', [
            'rents' => $rents,
            'rentedCars' => $rentedCars,
            'pagination' => $pagination
        ]);
    }

    public function actionCancelRent($id)
    {
        if (Yii::$app->user->isGuest)
            return $this->goHome();

        $rent = Rent::findOne($id);

        if (!$rent)
            throw new NotFoundHttpException();

        if ($rent->client_id != Yii::$app->user->id)
            throw new NotFoundHttpException();

        $rent->status = Rent::STATUS_CANCELED;

        $rent->save();

        $this->sendEmail($rent);

        return $this->redirect('rents');
    }

    private function sendEmail(Rent $rent): bool
    {
        $client = Client::findOne($rent->client_id);
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'canceledRent-html', 'text' => 'canceledRent-html'],
                ['client' => $client]
            )
            ->setFrom([Yii::$app->params['senderEmail'] => Yii::$app->name])
            ->setTo($client->email)
            ->setSubject("Аренда автомобиля $rent->id " . Yii::$app->name)
            ->send();
    }
}
