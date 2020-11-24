<?php

namespace shopium\mod\admin\controllers;

use core\components\controllers\WebController;
use shopium\mod\telegram\models\User;
use Yii;
use shopium\mod\admin\models\LoginForm;
use core\components\controllers\AdminController;
use yii\filters\AccessControl;
use yii\web\HttpException;

/**
 * Class AuthController
 * @package shopium\mod\admin\controllers
 */
class AuthController extends WebController
{

    public $layout = '@theme/views/layouts/auth';
    public $enableStatistic = false;


    /**
     * Display admin panel login
     * @return string|\yii\web\Response
     */
    public function actionIndex()
    {

        if (!Yii::$app->user->isGuest)
            return $this->redirect(['/admin/admin/default/index']);

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login(86400*30)) {
            return $this->goBack(['/admin/admin/default/index']);
        }

        // render
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * @param $token
     * @return \yii\web\Response
     * @throws HttpException
     */
    public function actionEnter($token)
    {
        /* @var $identity User */
        $class = Yii::$app->user->identityClass;
        $identity = $class::findIdentityByAccessToken($token);
        if ($identity && Yii::$app->user->login($identity)) {
            return $this->redirect(['/admin']);
        }
        throw new HttpException(404, Yii::t('app/error', 404));
    }

}
