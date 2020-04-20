<?php
use panix\engine\bootstrap\ActiveForm;
use panix\engine\Html;

/**
 * @var \shopium\mod\admin\models\DesktopWidgets $model
 */
?>

<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName ?></h5>
    </div>
    <?php $form = ActiveForm::begin(); ?>
    <div class="card-body">
        <?php //echo $form->field($model, 'desktop_id'); ?>
        <?= $form->field($model, 'widget')->dropDownList([
            'shopium\mod\admin\blocks\hosting\Hosting' => 'Hosting',
            'shopium\mod\admin\blocks\chat\ChatWidget' => 'Чат',
            'shopium\mod\admin\blocks\sysinfo\SysInfoWidget' => 'Информация о системе',
            'panix\mod\shop\blocks\popular\PopularBlock' => 'Популярные товары',
        ]) ?>
        <?= $form->field($model, 'col')->dropDownList($model->getColumnsRange()) ?>
    </div>
    <div class="card-footer text-center">
        <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>

