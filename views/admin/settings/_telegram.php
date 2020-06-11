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
<?= $form->field($model, 'button_text_home')->textInput() ?>
<?= $form->field($model, 'button_text_search')->textInput() ?>
<?= $form->field($model, 'button_text_history')->textInput() ?>
<?= $form->field($model, 'button_text_cart')->textInput() ?>
