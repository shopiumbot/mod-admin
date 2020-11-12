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
            'attribute' => 'name',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left d-flex align-items-center'],
            'value' => function ($model) use ($emoji) {
                return $emoji->emoji_unified_to_html($model->icon).' <span class="ml-2">'.$model->name . ' (' . $model->code . ')</span>';
            },
        ],

        [
            'class' => 'panix\engine\grid\columns\BooleanColumn',
            'attribute' => 'is_default',
            'format' => 'html'
        ],
        ['class' => 'panix\engine\grid\columns\ActionColumn']
    ]
]);
Pjax::end();

