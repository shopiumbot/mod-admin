<?php
/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \shopium\mod\admin\models\SettingsForm
 */
?>

<?= $form->field($model, 'empty_cart_text')->textInput() ?>
<?= $form->field($model, 'empty_history_text')->textInput() ?>

<?= $form->field($model, 'pagenum_telegram')->dropDownList($model::dropdownPagenum()); ?>


<?= $form->field($model, 'button_text_catalog')->textInput() ?>
<?= $form->field($model, 'button_text_start')->textInput() ?>
<?= $form->field($model, 'button_text_search')->textInput() ?>
<?= $form->field($model, 'button_text_history')->textInput() ?>
<?= $form->field($model, 'button_text_cart')->textInput() ?>
<?= $form->field($model, 'label_expire_new')->dropDownList($model::labelExpireNew(),['prompt'=>Yii::t('app/default','OFF')]); ?>
