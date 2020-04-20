<?php

namespace shopium\mod\admin\blocks\chat;

use Yii;
use yii\web\AssetBundle;

/**
 * Class ChatAsset
 * @package shopium\mod\admin\blocks\chat
 */
class ChatAsset extends AssetBundle {

    public $sourcePath = __DIR__.'/assets';
    public $js = [
        'js/chat.js',
    ];
    public $css = [
        'css/chat.css',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'panix\engine\emoji\EmojiAsset',
    ];

}
