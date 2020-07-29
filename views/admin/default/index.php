<?php

use panix\engine\Html;
use yii\helpers\Url;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use shopium\mod\telegram\models\Chat;
use shopium\mod\telegram\components\LiqPay;

$api = Yii::$app->telegram;
$user = Yii::$app->user->identity;

$me = Request::getMe();
$webhook_info = Request::getWebhookInfo();
$chats = Chat::find()->asArray()->all();
if ($chats) {
    foreach ($chats as $chat) {
        /*$send = Request::sendMessage([
            'chat_id'=>$chat['id'],
            'text'=>'test'
        ]);*/
    }
    /*$venue = Request::sendVenue([
        'chat_id' => $chat['id'],
        'latitude' => 46.3974947,
        'longitude' => 30.7125803,
        'title' => 'Pixelion',
        'address' => 'Pixelion address',
    ]);*/

    $keyboards[] = [
        new InlineKeyboardButton([
            'text' => 'Pay 1.00UAH',
            'callback_data' => "cartDelete"
        ]),
        new InlineKeyboardButton([
            'text' => '—',
            'callback_data' => "spinner/down/cart"
        ]),

    ];
    /*$invoice = Request::sendInvoice([
        'chat_id' => $chat['id'],
        'title' => 'title',
        'description' => 'description',
        'payload' => 'order-id',
        'provider_token' => '632593626:TEST:i56982357197',
        'start_parameter' => 'start_parameter',
        'currency' => 'UAH',
        'prices' => [
            new \Longman\TelegramBot\Entities\Payments\LabeledPrice([
                'label' => 'test',
                'amount' => 100
            ]),
        ],

        'disable_notification' => false,
        'reply_markup' => new \Longman\TelegramBot\Entities\InlineKeyboard([
            'inline_keyboard' => $keyboards
        ])

    ]);*/

    //\panix\engine\CMS::dump($invoice);

}
//$time = strtotime("+1 month",strtotime('08-06-2020'));
//echo $time.'<br>';
//echo date('Y-m-d H:i:s',$time);


?>
<?php if (Yii::$app->session->hasFlash('success-webhook')) { ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success-webhook'); ?>
    </div>
<?php } ?>
<?php if (Yii::$app->session->hasFlash('success-payment')) { ?>
    <div class="alert alert-success">
        <?= Yii::$app->session->getFlash('success-payment'); ?>
    </div>
<?php } ?>

<?php if (Yii::$app->session->hasFlash('error-payment')) { ?>
    <div class="alert alert-danger">
        <?= Yii::$app->session->getFlash('error-payment'); ?>
    </div>
<?php } ?>


<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="card border-left border-orange">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <span class="text-orange display-6"><i class="icon-user-outline"></i></span>
                    </div>
                    <div class="ml-auto">
                        <?php
                        $usersCount = \shopium\mod\telegram\models\User::find()->where(['is_bot' => 0])->count();
                        ?>
                        <h2><?= $usersCount; ?></h2>
                        <h6 class="text-orange">Пользователей</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="card border-left border-info">
            <div class="card-body">
                <div class="d-flex no-block align-items-center">
                    <div>
                        <span class="text-info display-6"><i class="icon-comments"></i></span>
                    </div>
                    <div class="ml-auto">
                        <?php
                        $messagesCount = \shopium\mod\telegram\models\Message::find()
                            ->between(date('Y-m-d') . ' 00:00:00', date('Y-m-d') . ' 23:59:59', 'date')
                            ->count();
                        ?>
                        <h2><?= $messagesCount; ?></h2>
                        <h6 class="text-info">Сообщений <span class="text-muted">за сегодня</span></h6>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <?php
                                $a = \core\modules\shop\models\Product::find()->count();
                                $b = Yii::$app->params['plan'][Yii::$app->user->planId]['product_limit'];
                                $diff = $b - $a;
                                $percent = $a / $b * 100;
                                ?>
                                <h3><?= $percent; ?>%</h3>
                                <h6 class="card-subtitle">Всего продукции <strong><?= $a; ?></strong> из
                                    <strong><?= $b; ?></strong></h6>
                            </div>
                            <div class="ml-auto">
                                <span class="text-success display-6"><i class="ti-layout-slider-alt"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?= $percent; ?>%;"
                                 aria-valuenow="<?= $percent; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <?php





                    if ($me->isOk()) { ?>
                        Подключен бот: <?= Html::a($me->getResult()->first_name, 'tg://resolve?domain=' . $me->getResult()->username); ?>
                    <?php } else { ?>
                        Бот не подключен!
                    <?php } ?>
                    <?php

                ?>
                <div class="float-right">
                    <?php


                        if ($webhook_info->isOk()) {
                            $result = $webhook_info->getResult();

                            if (!empty($result->url)) {
                                if ($result->url === Yii::$app->user->webhookUrl) {
                                    echo Html::a('☹️ Отписать бота', ['/telegram/message/unset'], ['class' => 'btn btn-sm btn-danger']);
                                } else {
                                    echo Html::a(Html::icon('check') . ' Подписать бота', ['/telegram/message/set'], ['class' => 'btn btn-sm btn-success']);
                                }
                            } else {
                                echo Html::a(Html::icon('check') . ' Подписать бота', ['/telegram/message/set'], ['class' => 'btn btn-sm btn-success']);
                            }
                        } else {
                            echo '2';
                        }

                    ?>
                </div>
            </div>
            <div class="card-body">

                <?php
                try {
                    if ($me->isOk()) {
                        $result = $me->getResult();
                        /* $profile = Request::getUserProfilePhotos(['user_id' => $result->id]); //812367093 me

                         if ($profile->getResult()->photos && isset($profile->getResult()->photos[0])) {
                             $photo = $profile->getResult()->photos[0][2];
                             $file = Request::getFile(['file_id' => $photo['file_id']]);
                             if (!file_exists(Yii::getAlias('@app/web/telegram/downloads') . DIRECTORY_SEPARATOR . $file->getResult()->file_path)) {
                                 $download = Request::downloadFile($file->getResult());

                             } else {
                                 echo Html::img('/telegram/downloads/' . $file->getResult()->file_path, ['class' => 'mb-4', 'width' => 100]);
                             }
                         }*/
                        echo Html::img($api->getPhoto(), ['class' => 'mb-4', 'width' => 100]);

                        ?>
                    <?php }

                } catch (Exception $e) {
                    echo '34';
                }
                ?>


                <div class="form-group row">
                    <div class="col-sm-5 col-lg-5"><label>Ваш ID</label></div>
                    <div class="col-sm-7 col-lg-7"><?= $user->id; ?></div>
                </div>

                <?php if ($user->expire) { ?>
                    <div class="form-group row">
                        <div class="col-sm-5 col-lg-5"><label>Продлен до</label></div>
                        <div class="col-sm-7 col-lg-7">
                            <?= \panix\engine\CMS::date($user->expire); ?>
                        </div>
                    </div>
                <?php } ?>
                <?php if ($user->plan_id) { ?>
                    <div class="form-group row">
                        <div class="col-sm-5 col-lg-5"><label>Текущий тариф</label></div>
                        <div class="col-sm-7 col-lg-7">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?= Yii::$app->params['plan'][$user->plan_id]['name']; ?>
                                    <?php if ($user->trial) {
                                        echo Html::tag('span', 'TRIAL', ['class' => 'badge badge-danger']);
                                    }
                                    ?>
                                </div>


                                <div class="col-lg-6 text-lg-right">
                                    <button type="button" class="btn btn-success" data-toggle="modal"
                                            data-target="#paymentModal">
                                        Продлить
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>

    </div>
    <div class="card d-none">
        <div class="card-header">
            Источники входа
        </div>
        <div class="card-body">
            asd
        </div>
    </div>
</div>

<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Оплатить тариф: <span
                            class="badge badge-success"><?= Yii::$app->params['plan'][$user->plan_id]['name']; ?></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <h3>LiqPay</h3>
                <div class="alert alert-warning">
                    К общей стоимости будет добавлена комиссии сервиса <strong>2.75%</strong>
                </div>
                <?php
                $liqPayConfig = Yii::$app->params['payment']['liqpay'];
                $liqpay = new LiqPay($liqPayConfig['public_key'], $liqPayConfig['private_key']);

                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <?php

                        $price1 = Yii::$app->params['plan'][Yii::$app->user->planId]['prices'][1];

                        $params = [];
                        $params['action'] = 'pay';
                        $params['amount'] = $price1 + ($price1 / 100 * 2.75);
                        $params['currency'] = 'UAH';
                        // $params['paytypes'] = 'card';

                        $params['description'] = 'Оплата тарифного плана "' . Yii::$app->params['plan'][Yii::$app->user->planId]['name'] . '" на 1 месяц + (комиссия 2.75%)';
                        $params['order_id'] = \panix\engine\CMS::gen(5) . '-' . Yii::$app->user->id . '-1';
                        $params['version'] = '3';
                        $params['result_url'] = Url::to('/user/payment-result', true);
                        $params['server_url'] = Url::to('/user/payment-success', true);
                        $params['public_key'] = $liqPayConfig['public_key'];
                        if ($params['currency'] == LiqPay::CURRENCY_RUR) {
                            $params['currency'] = LiqPay::CURRENCY_RUB;
                        }

                        $signature = $liqpay->cnb_signature($params);

                        echo Html::beginForm('https://www.liqpay.ua/api/3/checkout', 'POST', ['accept-charset' => 'utf-8']);
                        echo Html::hiddenInput('data', base64_encode(json_encode($params)));
                        echo Html::hiddenInput('signature', $signature);
                        echo Html::submitButton("Продлить на 1 мес. - {$price1} грн", ['class' => 'btn btn-success']);
                        echo Html::endForm();
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php

                        $price12 = Yii::$app->params['plan'][Yii::$app->user->planId]['prices'][12] * 12;
                        $params = [];
                        $params['action'] = 'pay';
                        $params['amount'] = $price12 + ($price12 / 100 * 2.75);
                        $params['currency'] = 'UAH';
                        $params['description'] = 'Оплата тарифного плана "' . Yii::$app->params['plan'][Yii::$app->user->planId]['name'] . '" на 1 год + (комиссия 2.75%)';
                        $params['order_id'] = \panix\engine\CMS::gen(5) . '-' . Yii::$app->user->id . '-12';
                        $params['version'] = '3';
                        $params['result_url'] = Url::to('/user/payment-result', true);
                        $params['server_url'] = Url::to('/user/payment-success', true);
                        $params['public_key'] = $liqPayConfig['public_key'];
                        if ($params['currency'] == LiqPay::CURRENCY_RUR) {
                            $params['currency'] = LiqPay::CURRENCY_RUB;
                        }

                        $signature = $liqpay->cnb_signature($params);
                        echo Html::beginForm('https://www.liqpay.ua/api/3/checkout', 'POST', ['accept-charset' => 'utf-8']);
                        echo Html::hiddenInput('data', base64_encode(json_encode($params)));
                        echo Html::hiddenInput('signature', $signature);
                        echo Html::submitButton("Продлить на 1 год - {$price12} грн", ['class' => 'btn btn-success']);
                        echo '👍 Экономия: ' . (($price1 * 12) - $price12) . ' грн.';
                        echo Html::endForm();
                        ?>
                    </div>
                </div>
                <h3 class="mt-4">Продлить с баланса</h3>
                <div class="row">
                    <div class="col-sm-6">
                        <?php
                        echo Html::beginForm(['/user/payment-balance'], 'GET', ['onsubmit' => "return confirm('Вы уверены что хотите продлить тариф, с личного баланса?');"]);
                        echo Html::hiddenInput('month', 1);
                        echo Html::submitButton("Продлить на 1 мес. - {$price1} грн", ['class' => 'btn btn-success']);
                        echo Html::endForm();
                        ?>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo Html::beginForm(['/user/payment-balance'], 'GET');
                        echo Html::hiddenInput('month', 12);
                        echo Html::submitButton("Продлить на 1 год - {$price12} грн", ['class' => 'btn btn-success']);
                        echo '👍 Экономия: ' . (($price1 * 12) - $price12) . ' грн.';
                        echo Html::endForm();
                        ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer d-none">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Заказыть</button>
                <button type="button" class="btn btn-primary">Оплатить</button>
            </div>
        </div>
    </div>
</div>