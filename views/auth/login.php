<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

?>

<?php
$form = ActiveForm::begin([
    'id' => 'form-signin',
    'options' => ['class' => 'form-signin'],
    'fieldConfig' => [
        'template' => "<div class=\"col\"><div class=\"input-group\"><div class=\"input-group-prepend\">
                    <span class=\"input-group-text\"><i class=\"icon-{icon}\"></i></span>
                </div>{label}{input}{hint}{error}</div></div>",
        'horizontalCssClasses' => [
            'label' => '',
            'offset' => '',
            'wrapper' => '',
            'error' => '',
            'hint' => ''
        ],
        // 'options'=>['class'=>''],
        // 'labelOptions' => ['class' => 'sr-only'],
    ],
]);
?>



<?= $form->field($model, 'username', [
    'parts' => ['{icon}' => 'user-outline'],
])->textInput([
    'class' => 'form-control',
    'placeholder' => $model->getAttributeLabel('username')
])->label(false);
?>



<?= $form->field($model, 'password', [
    'parts' => [
        '{icon}' => 'key',
        '{switch}' => '<a href="#" data-target="#loginform-password" class="input-group-text bg-transparent border-0" onclick="common.switchInputPass(this,\'loginform-password\');"><i class="icon-eye"></i></a>'
    ],
    'template' => '<div class="col"><div class="input-group"><div class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-{icon}"></i></span>
                </div>{label}{input}<div class="input-group-append" style="position: absolute;right: 1px;background: #fff;top: 1px;bottom: 1px;z-index:100">{switch}</div>{hint}{error}</div></div>'
])
    ->passwordInput(['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('password')])
    ->label(false);
?>


    <div class="form-group row mb-0 pb-0">
        <div class="col-sm-7">
            <?= $form->field($model, 'rememberMe', ['options' => ['class' => 'mt-2']])->checkbox() ?>
        </div>
        <div class="col-sm-5 controls text-right">
            <?= Html::submitButton(Yii::t('user/default', 'LOGIN'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>