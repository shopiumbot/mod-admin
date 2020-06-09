<?php

use panix\engine\Html;
use yii\helpers\Url;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use shopium\mod\telegram\models\Chat;

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
                <div class="float-right">
                    <?php

                    if ($webhook_info->isOk()) {
                        $result = $webhook_info->getResult();

                        if (!empty($result->url)) {
                            if ($result->url === Yii::$app->user->webhookUrl) {
                                echo Html::a('☹️ Оптисать бота', ['/telegram/message/unset'], ['class' => 'btn btn-sm btn-danger']);
                            }
                        } else {
                            echo Html::a(Html::icon('check') . ' Подписать бота', ['/telegram/message/set'], ['class' => 'btn btn-sm btn-success']);
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="card-body">

                <?php
                if ($me->isOk()) {
                    $result = $me->getResult();
                    $profile = Request::getUserProfilePhotos(['user_id' => $result->id]); //812367093 me

                    if ($profile->getResult()->photos && isset($profile->getResult()->photos[0])) {
                        $photo = $profile->getResult()->photos[0][2];
                        $file = Request::getFile(['file_id' => $photo['file_id']]);
                        if (!file_exists(Yii::getAlias('@app/web/telegram/downloads') . DIRECTORY_SEPARATOR . $file->getResult()->file_path)) {
                            $download = Request::downloadFile($file->getResult());

                        } else {
                            echo Html::img('/telegram/downloads/' . $file->getResult()->file_path, ['class' => 'mb-4', 'width' => 100]);
                        }
                    }
                    ?>
                <?php } ?>

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
                                <div class="col-lg-6 text-lg-right"><?= Html::a('Оплатить', '', ['class' => 'btn btn-success']); ?></div>
                            </div>

                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>

    </div>
</div>
