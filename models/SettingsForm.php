<?php

namespace shopium\mod\admin\models;

use panix\engine\CMS;
use panix\engine\Html;
use panix\engine\SettingsModel;
use yii\web\UploadedFile;
use Yii;

class SettingsForm extends SettingsModel
{
    protected $module = 'admin';
    public static $category = 'app';
   // public $pagenum;
    public $email;
    public $watermark_enable;
    public $attachment_wm_path;
    public $attachment_wm_corner;
    public $attachment_wm_offsetx;
    public $attachment_wm_offsety;
    public $pagenum_telegram;
    public $enable_brands;
    public $enable_new;
    public $enable_discounts;

    public $timezone;
    public $label_expire_new;

    public $liqpay_percent;

    public $liqpay_provider;
    public $yandexKassa_provider;
    public $tranzzo_provider;

   // public $language;
    public $availability_hide;

    public $tpl_product;
    private $tpl_product_file;

    public function rules()
    {

        return [
            [['label_expire_new'], 'integer'],
            [['email'], 'trim'],
            [['watermark_enable', 'enable_brands', 'enable_new', 'enable_discounts', 'liqpay_percent', 'availability_hide'], 'boolean'],
            [['pagenum_telegram', 'attachment_wm_corner', 'attachment_wm_offsety', 'attachment_wm_offsetx'], 'integer'],
            [[
                'timezone',
              //  'language',
                'email',
               // 'pagenum',
                'pagenum_telegram',
                'attachment_wm_offsetx', 'attachment_wm_offsety', 'attachment_wm_corner',
            ], "required"],
            ['email', 'email'],

            [[
                'liqpay_provider',
                'yandexKassa_provider',
                'tranzzo_provider',
                'tpl_product'
            ], 'string', 'min' => 3],


            ['attachment_wm_path', 'validateWatermarkFile'],
            ['pagenum_telegram', 'in', 'range' => array_keys(self::dropdownPagenum())],
            [['attachment_wm_path'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg']],
        ];
    }

    public function init()
    {
        $this->tpl_product_file = Yii::getAlias('@app/web') . DIRECTORY_SEPARATOR . 'product.twig';


        if (file_exists($this->tpl_product_file)) {
            $this->tpl_product = file_get_contents($this->tpl_product_file);
        } else {
            $this->tpl_product = file_get_contents(Yii::getAlias('@telegram/views/templates') . DIRECTORY_SEPARATOR . 'product.twig');
        }

        parent::init();
    }


    public function save()
    {
        if (!empty($this->tpl_product)) {

            file_put_contents($this->tpl_product_file, $this->tpl_product);

        } else {

            //Если содержание пустое, то удаляем файл.
            unlink($this->tpl_product_file);
        }
        parent::save();
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
            'label_expire_new' => 7,
            'availability_hide' => false,

        ];
    }

    public function renderWatermarkImage()
    {
        $config = Yii::$app->settings->get('app');
        if (isset($config->attachment_wm_path) && file_exists(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . $config->attachment_wm_path))
            return Html::img(Yii::$app->request->baseUrl."/uploads/{$config->attachment_wm_path}?" . time(), ['class' => 'img-fluid img-thumbnail mt-3']);
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
