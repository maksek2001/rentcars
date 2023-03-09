<?php

use yii\helpers\Html;

$helpLink = Yii::$app->urlManager->createAbsoluteUrl(['help/index']);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
    <?php $this->beginBody() ?>
    <table style="width: 100%; max-width: 600px; border-collapse: collapse; table-layout: fixed; margin: 0 auto;" border="0" align="center" cellspacing="0" cellpadding="0">
        <tr>
            <td style="width: 100%; color: #003e9b; padding-bottom: 10px; text-align: center; text-transform: uppercase; margin: 10px 0; font-size: 30px; font-weight: 1000; border-bottom: 1px solid #ccc;">
                <?= Yii::$app->name ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100%; font-size: 15px; line-height: 22px; text-decoration: none; letter-spacing: 0.4px; color: #001A34; font-weight: 300; padding: 10px 20px;">
                <?= $content ?>
            </td>
        </tr>
        <tr>
            <td style="width: 100%; border-top: 1px solid #ccc; color: #a7a7a7; padding-top: 10px; font-size: 13.5px; text-align: center; margin-top: 30px;">
                Данное сообщение было автоматически отправлено системой <?= Yii::$app->name ?>.
                <br>
                <a style="color: #b5b5b5;" href="<?=$helpLink?>">Помощь</a>
            </td>
        </tr>
    </table>
    <?php $this->endBody() ?>
</body>


</html>
<?php $this->endPage();
