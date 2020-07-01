<?php
/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \shopium\mod\admin\models\SettingsForm
 */
?>
<?= $form->field($model, 'liqpay_provider')->textInput() ?>
<?= $form->field($model, 'liqpay_percent')->checkbox() ?>
<?= $form->field($model, 'yandexKassa_provider')->textInput() ?>
<?= $form->field($model, 'tranzzo_provider')->textInput() ?>

