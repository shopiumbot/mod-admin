<?php

use panix\engine\Html;
use panix\engine\bootstrap\ActiveForm;

?>

<?php $form = ActiveForm::begin([
    'options' => ['enctype' => 'multipart/form-data']
]); ?>
<div class="card">
    <div class="card-header">
        <h5><?= $this->context->pageName ?></h5>
    </div>
    <div class="card-body">

        <?php
        echo panix\engine\bootstrap\Tabs::widget([
            'options' => [
                'class' => 'nav-pills2 flex-column flex-sm-row nav-tabs-static'
            ],
            'items' => [
                [
                    'label' => 'Общие',
                    'content' => $this->render('_global', ['form' => $form, 'model' => $model]),
                    'active' => true,
                ],
                [
                    'label' => 'Telegram',
                    'content' => $this->render('_telegram', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                ],
                [
                    'label' => 'Водяной знак',
                    'content' => $this->render('_images', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                ],
                [
                    'label' => 'Платежные системы',
                    'content' => $this->render('_payments', ['form' => $form, 'model' => $model]),
                    'headerOptions' => [],
                ]
            ],
        ]);
        ?>


    </div>
    <div class="card-footer text-center">
        <?= Html::submitButton(Yii::t('app/default', 'SAVE'), ['class' => 'btn btn-success']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
