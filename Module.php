<?php

namespace shopium\mod\admin;

use Yii;
//use yii\base\BootstrapInterface; // implements BootstrapInterface
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

/**
 * Class Module
 * @package shopium\mod\admin
 */
class Module extends WebModule { // implements BootstrapInterface

    public function bootstrap2($app)
    {
        $app->urlManager->addRules(
            [
                'admin' => 'admin/admin/default/index',
                'admin/auth' => 'admin/auth/index',
            ],
            true
        );

    }

    public function getInfo() {
        return [
            'label' => Yii::t('admin/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => 'icon-tools',
            'description' => Yii::t('admin/default', 'MODULE_DESC'),
            'url' => ['/admin/app'],
        ];
    }

    public function getAdminMenu() {
        return [
            'system' => [
                'items' => [
                    [
                        'label' => Yii::t('app/default', 'SETTINGS'),
                        'url' => ['/admin/app/settings'],
                        'icon' => 'settings',
                        'visible' => true
                    ],
                ]
            ]
        ];
    }

    public function getAdminSidebar()
    {
        return (new \shopium\mod\admin\widgets\sidebar\BackendNav)->findMenu('system')['items'];
    }

}
