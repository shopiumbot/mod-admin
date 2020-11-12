<?php

use yii\helpers\Html;
use panix\engine\grid\GridView;
use panix\engine\widgets\Pjax;

Pjax::begin([
    'dataProvider' => $dataProvider,
]);
\panix\engine\emoji\EmojiAsset::register($this);
/**
 * @var $emoji \panix\engine\emoji\Emoji
 */
$emoji = new \panix\engine\emoji\Emoji;

echo GridView::widget([
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layoutOptions' => ['title' => $this->context->pageName],
    'columns' => [
        [
            'format' => 'html',
            'header' => 'Флаг',
            'contentOptions' => ['class' => 'text-center'],
            'value' => function ($model) use ($emoji) {
                return $emoji->emoji_unified_to_html($model->icon);
                //return Html::img($model->getFlagUrl(), ['alt' => $model->name, 'title' => $model->name]);
            },
        ],
        'name',
        [
            'class' => 'panix\engine\grid\columns\BooleanColumn',
            'attribute' => 'is_default',
            'format' => 'html'
        ],
        ['class' => 'panix\engine\grid\columns\ActionColumn']
    ]
]);
Pjax::end();

