<?php
/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \shopium\mod\admin\models\SettingsForm
 */
?>
<?= $form->field($model, 'watermark_enable')->checkbox() ?>
<?= $form->field($model, 'attachment_wm_path')->fileInput(['accept' => 'image/*'])->hint($model->renderWatermarkImage()) ?>
<?= $form->field($model, 'attachment_wm_corner')->dropDownList($model->getWatermarkCorner()) ?>
<?= $form->field($model, 'attachment_wm_offsety')->textInput() ?>
<?= $form->field($model, 'attachment_wm_offsetx')->textInput() ?>

