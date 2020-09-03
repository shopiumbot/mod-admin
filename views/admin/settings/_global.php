<?php

use panix\engine\helpers\TimeZoneHelper;
use panix\engine\Html;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \shopium\mod\admin\models\SettingsForm
 */

?>

<?= $form->field($model, 'email'); ?>
<?= $form->field($model, 'timezone')->dropDownList(TimeZoneHelper::getTimeZoneData(), []); ?>
<?= $form->field($model, 'pagenum'); ?>
<?= $form->field($model, 'tpl_product')->widget(\panix\ext\codemirror\CodeMirrorTextArea::class, [
    'mode' => 'twig',
    //'clientOptions'=>[
    //    'mode'=>['name'=>'twig','base'=>'text/html']
    //]
]) ?>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tpl-docs-product">
    Документация
</button>


<?php

$tpl_product = [
    [
        'name' => 'Товар',
        'items' => [
            [
                'code' => 'product.id',
                'text' => 'ID товара',
                'type' => 'int'
            ],
            [
                'code' => 'product.sku',
                'text' => 'Артикул товара',
                'type' => 'string'
            ],
            [
                'code' => 'product.name',
                'text' => 'Название товара',
                'type' => 'string'
            ],
            [
                'code' => 'product.price',
                'text' => 'Цена товара',
                'type' => 'string'
            ],
            [
                'code' => 'product.description',
                'text' => 'Описание товара',
                'type' => 'string|false'
            ],
            [
                'code' => 'product.brand',
                'text' => 'Бренд товара',
                'type' => 'string|false'
            ],
            [
                'code' => 'product.category',
                'text' => 'Категория товара',
                'type' => 'string|false'
            ],
            [
                'code' => 'product.availability',
                'text' => 'Наличие товара',
                'type' => 'int'
            ],
            [
                'code' => 'currency.symbol',
                'text' => 'Символ валюты',
                'type' => 'string'
            ],
            [
                'code' => 'currency.name',
                'text' => 'Название валюты',
                'type' => 'string'
            ],
        ]
    ],
    [
        'name' => 'Скидка товара',
        'items' => [
            [
                'code' => 'product.discount.exist',
                'text' => 'Наличие скидки у товара',
                'type' => 'boolean'
            ],
            [
                'code' => 'product.discount.sum',
                'text' => 'Сумма скидки',
                'type' => 'string'
            ],
            [
                'code' => 'product.discount.end_date',
                'text' => 'Дата окончание скидки',
                'type' => 'string'
            ],
        ]
    ],
    [
        'name' => 'Атрибуты товара',
        'items' => [
            [
                'code' => 'product.attributes',
                'text' => 'Атрибуты товара',
                'type' => 'array',
                'for' => ['name', 'value']
            ],
        ]
    ],
    [
        'name' => 'Общие',
        'items' => [
            [
                'code' => 'is_admin',
                'text' => 'Являеться ли получатель сообщения администратором',
                'type' => 'boolean'
            ],
        ]
    ],


]
?>
<!-- Modal -->
<div class="modal fade" id="tpl-docs-product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width: 1200px">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Документация</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered1 table-striped">


                    <?php foreach ($tpl_product as $group) { ?>
                        <tr>
                            <th colspan="2" class="text-center"><?= $group['name'] ?></th>
                        </tr>
                        <tr>
                            <th>Код</th>
                            <th>Описание</th>
                        </tr>
                        <?php foreach ($group['items'] as $tpl) { ?>
                            <tr>
                                <td><code>{{<?= $tpl['code'] ?>}}</code><br/>
                                    <small><?= $tpl['type'] ?></small>
                                </td>
                                <td>
                                    <?= $tpl['text'] ?>
                                    <?php if (isset($tpl['for'])) { ?>
                                        <pre>
{% for <?= implode(', ', $tpl['for']); ?> in <?= $tpl['code'] ?> %}
{{ name }}: {{ value }}
{% endfor %}
                                </pre>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </table>
                <div>
                    Если <?= Html::a('if', 'https://twig.symfony.com/doc/3.x/tags/if.html', ['target' => '_blank']); ?></div>
                <div>
                    Массив <?= Html::a('for', 'https://twig.symfony.com/doc/3.x/tags/for.html', ['target' => '_blank']); ?></div>
            </div>
        </div>
    </div>
</div>