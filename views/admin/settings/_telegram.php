<?php
/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \shopium\mod\admin\models\SettingsForm
 */

?>
<?= $form->field($model, 'availability_hide')->checkbox() ?>
<?= $form->field($model, 'empty_cart_text')->textInput() ?>
<?= $form->field($model, 'empty_history_text')->textInput() ?>
<?= $form->field($model, 'pagenum_telegram')->dropDownList($model::dropdownPagenum()); ?>
<?= $form->field($model, 'enable_brands')->checkbox() ?>
<?= $form->field($model, 'enable_new')->checkbox() ?>
<?= $form->field($model, 'enable_discounts')->checkbox() ?>

<?= $form->field($model, 'button_text_catalog')->textInput() ?>
<?= $form->field($model, 'button_text_start')->textInput() ?>
<?= $form->field($model, 'button_text_search')->textInput() ?>
<?= $form->field($model, 'button_text_history')->textInput() ?>
<?= $form->field($model, 'button_text_cart')->textInput() ?>
<?php // $form->field($model, 'tpl_product')->textarea(['rows'=>10])->hint('Чтобы сбросить шаблон просто очистите поле и сохраните.') ?>




<?= $form->field($model, 'label_expire_new')->dropDownList($model::labelExpireNew(),['prompt'=>Yii::t('app/default','OFF')]); ?>
