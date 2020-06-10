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
    public $sitename;
    public $pagenum;
    public $email;

    public $watermark_enable;
    public $attachment_wm_path;
    public $attachment_wm_corner;
    public $attachment_wm_offsetx;
    public $attachment_wm_offsety;

    public static function defaultSettings()
    {
        return [
            'email' => 'info@shopiumbot.com',
            'pagenum' => 20,
            'sitename' => 'ShopiumBot',
            'watermark_enable' => true,
            'attachment_wm_path' => 'watermark.png',
            'attachment_wm_offsety' => 10,
            'attachment_wm_offsetx' => 10,
            'attachment_wm_corner' => 5,

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

    public function rules()
    {

        return [
            [['email'], 'trim'],
            [['watermark_enable'], 'boolean'],
            [['attachment_wm_corner', 'attachment_wm_offsety', 'attachment_wm_offsetx'], 'integer'],
            [['email', 'sitename', 'pagenum', 'attachment_wm_offsetx', 'attachment_wm_offsety', 'attachment_wm_corner'], "required"],
            ['email', 'email'],
            ['attachment_wm_path', 'validateWatermarkFile'],

            [['attachment_wm_path'], 'file', 'skipOnEmpty' => true, 'extensions' => ['png', 'jpg']],
        ];
    }


}
