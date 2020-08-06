<?php

namespace shopium\mod\admin\models;

use panix\engine\Html;
use panix\engine\SettingsModel;
use yii\web\UploadedFile;
use Yii;

class SettingsForm extends SettingsModel
{
    protected $module = 'admin';
    public static $category = 'app';
    public $pagenum;
    public $email;
    public $empty_cart_text;
    public $empty_history_text;
    public $watermark_enable;
    public $attachment_wm_path;
    public $attachment_wm_corner;
    public $attachment_wm_offsetx;
    public $attachment_wm_offsety;
    public $pagenum_telegram;
    public $enable_brands;
    public $enable_new;
    public $enable_discounts;

    public $button_text_start;
    public $button_text_cart;
    public $button_text_catalog;
    public $button_text_search;
    public $button_text_history;
    public $timezone;
    public $label_expire_new;

    public $liqpay_percent;

    public $liqpay_provider;
    public $yandexKassa_provider;
    public $tranzzo_provider;


    public $availability_hide;
    public function rules()
    {

        return [
            [['label_expire_new'], 'integer'],
            [['email'], 'trim'],
            [['watermark_enable', 'enable_brands', 'enable_new', 'enable_discounts', 'liqpay_percent','availability_hide'], 'boolean'],
            [['pagenum', 'pagenum_telegram', 'attachment_wm_corner', 'attachment_wm_offsety', 'attachment_wm_offsetx'], 'integer'],
            [[
                'timezone',
                'email',
                'pagenum',
                'pagenum_telegram',
                'button_text_catalog', 'button_text_start', 'button_text_search', 'button_text_history', 'button_text_cart',
                'attachment_wm_offsetx', 'attachment_wm_offsety', 'attachment_wm_corner',
                'empty_cart_text', 'empty_history_text',
            ], "required"],
            ['email', 'email'],

            [[
                'button_text_catalog',
                'button_text_start',
                'button_text_search',
                'button_text_history',
                'button_text_cart',
                'liqpay_provider',
                'yandexKassa_provider',
                'tranzzo_provider',
            ], 'string', 'min' => 3],


            ['attachment_wm_path', 'validateWatermarkFile'],
            ['pagenum_telegram', 'in', 'range' => array_keys(self::dropdownPagenum())],
            [['attachment_wm_path'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg']],
        ];
    }

    public static function defaultSettings()
    {
        return [
            'timezone' => 'Europe/Kiev',
            'email' => 'info@shopiumbot.com',
            'pagenum' => 5,
            'watermark_enable' => true,
            'enable_brands' => true,
            'enable_new' => true,
            'enable_discounts' => false,
            'liqpay_provider' => '',
            'yandexKassa_provider' => '',
            'tranzzo_provider' => '',
            'attachment_wm_path' => 'watermark.png',
            'attachment_wm_offsety' => 10,
            'attachment_wm_offsetx' => 10,
            'attachment_wm_corner' => 5,
            'pagenum_telegram' => 5,
            'empty_cart_text' => 'Ваша корзина пустая',
            'empty_history_text' => 'Ваша история пустая Воспользуйтесь каталогом чтобы ее наполнить',
            'label_expire_new' => 7,
            'button_text_start' => '🏠 Начало',
            'button_text_cart' => '🛍 Корзина',
            'button_text_search' => '🔎 Поиск',
            'button_text_catalog' => '📂 Каталог',
            'button_text_history' => '📦 Мои покупки',

        ];
    }

    public function renderWatermarkImage()
    {
        $config = Yii::$app->settings->get('app');
        if (isset($config->attachment_wm_path) && file_exists(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . $config->attachment_wm_path))
            return Html::img("/uploads/{$config->attachment_wm_path}?" . time(), ['class' => 'img-fluid img-thumbnail mt-3']);
    }


    public function validateWatermarkFile($attr)
    {
        $file = UploadedFile::getInstance($this, 'attachment_wm_path');
        if ($file) {
            $allowedExts = ['jpg', 'gif', 'png'];
            if (!in_array($file->extension, $allowedExts))
                $this->addError($attr, self::t('ERROR_WM_NO_IMAGE'));
        }
    }

    public function getWatermarkCorner()
    {
        return [
            1 => self::t('WM_POS_LEFT_TOP'),
            2 => self::t('WM_POS_RIGHT_TOP'),
            3 => self::t('WM_POS_LEFT_BOTTOM'),
            4 => self::t('WM_POS_RIGHT_BOTTOM'),
            5 => self::t('WM_POS_CENTER'),
            6 => self::t('WM_POS_CENTER_TOP'),
            7 => self::t('WM_POS_CENTER_BOTTOM'),
            8 => self::t('WM_POS_LEFT_CENTER'),
            9 => self::t('WM_POS_RIGHT_CENTER'),
            10 => self::t('WM_POS_REPEAT'),
        ];
    }

    public static function labelExpireNew()
    {
        return [
            1 => self::t('LABEL_NEW_DAYS', ['n' => 1]),
            2 => self::t('LABEL_NEW_DAYS', ['n' => 2]),
            3 => self::t('LABEL_NEW_DAYS', ['n' => 3]),
            4 => self::t('LABEL_NEW_DAYS', ['n' => 4]),
            5 => self::t('LABEL_NEW_DAYS', ['n' => 5]),
            6 => self::t('LABEL_NEW_DAYS', ['n' => 6]),
            7 => self::t('LABEL_NEW_DAYS', ['n' => 7]),
            8 => self::t('LABEL_NEW_DAYS', ['n' => 8]),
            9 => self::t('LABEL_NEW_DAYS', ['n' => 9]),
            10 => self::t('LABEL_NEW_DAYS', ['n' => 10]),
            11 => self::t('LABEL_NEW_DAYS', ['n' => 11]),
            12 => self::t('LABEL_NEW_DAYS', ['n' => 12]),
            13 => self::t('LABEL_NEW_DAYS', ['n' => 13]),
            14 => self::t('LABEL_NEW_DAYS', ['n' => 14]),
        ];
    }


    public static function dropdownPagenum()
    {
        return [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            5 => 5,
            6 => 6,
            7 => 7,
            8 => 8
        ];
    }

}
