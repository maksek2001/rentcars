<?php

namespace frontend\controllers;

use Yii;
use frontend\models\forms\authentication\LoginForm;
use frontend\models\forms\authentication\SignupForm;
use frontend\models\forms\authentication\PasswordResetRequestForm;
use frontend\models\forms\authentication\ResendVerificationEmailForm;
use frontend\models\forms\authentication\ResetPasswordForm;
use frontend\models\forms\authentication\VerifyEmailForm;
use InvalidArgumentException;
use yii\web\BadRequestHttpException;

class AuthenticationController extends SiteController
{
    public $layout = 'authentication';

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest)
            return $this->redirect(['office/index']);

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                return $this->redirect(['office/index']);
            } else {
                Yii::$app->session->setFlash('error', 'Введён неверный логин или пароль!');
            }
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSignup()
    {
        if (!Yii::$app->user->isGuest)
            return $this->goHome();

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->signup()) {
                Yii::$app->session->setFlash('success', 'Благодарим вас за регистрацию. Пожалуйста, проверьте свой почтовый ящик на наличие подтверждающего электронного письма.');
                return $this->redirect('login');
            } else {
                Yii::$app->session->setFlash('error', 'Не удалось зарегистрироваться!');
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');

                return $this->redirect('login');
            }

            Yii::$app->session->setFlash('error', 'Извините, мы не можем сбросить пароль для указанного адреса электронной почты.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword(string $token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Пароль успешно изменён');

            return $this->redirect('login');
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionVerifyEmail(string $token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Ваш email подтверждён!');
            
            return $this->redirect('login');
        }

        Yii::$app->session->setFlash('error', 'Извините, мы не можем подтвердить вашу учетную запись с помощью предоставленного токена.');
        
        return $this->redirect('login');
    }

    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Проверьте свою электронную почту для получения дальнейших инструкций.');
                return $this->redirect('login');
            }
            Yii::$app->session->setFlash('error', 'Извините, мы не можем повторно отправить электронное письмо с подтверждением на указанный адрес электронной почты.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
