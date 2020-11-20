<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

/**
 * @var $this \yii\web\View
 * @var $model \shopium\mod\admin\models\Languages
 */
$form = ActiveForm::begin();
$disabled=false;
if(!$model->isNewRecord){
if($model->code == Yii::$app->language){
    $disabled=true;
}
}
?>
<div class="card">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName) ?></h5>
    </div>
    <div class="card-body">
        <?php $form->field($model, 'name')->textInput(['maxlength' => 100]) ?>
        <?php $form->field($model, 'code')->textInput(['maxlength' => 5]) ?>
        <?php $form->field($model, 'locale')->textInput(['maxlength' => 5]) ?>
        <?= $form->field($model, 'is_default')->checkbox(['disabled'=>$disabled]) ?>

    </div>
    <div class="card-footer text-center">
        <?= Html::submitButton(Yii::t('app/default', $model->isNewRecord ? 'CREATE' : 'SAVE'), ['class' => 'btn btn-success']); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
