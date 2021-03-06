<?php

namespace shopium\mod\admin\controllers\admin;

use Yii;
use core\components\controllers\AdminController;
use shopium\mod\admin\models\SettingsForm;
use yii\web\UploadedFile;

class SettingsController extends AdminController
{

    public $icon = 'settings';

    public function actionIndex()
    {
        $this->pageName = Yii::t('app/default', 'SETTINGS');
        $this->view->params['breadcrumbs'][] = $this->pageName;

        $model = new SettingsForm();
        $oldWatermark = $model->attachment_wm_path;


        //Yii::$app->request->post()
        if ($model->load(Yii::$app->request->post())) {


            if ($model->validate()) {

                $attachment_wm_path = UploadedFile::getInstance($model, 'attachment_wm_path');
                if ($attachment_wm_path) {
                    $attachment_wm_path->saveAs(Yii::getAlias('@uploads') . DIRECTORY_SEPARATOR . 'watermark.' . $attachment_wm_path->extension);
                    $model->attachment_wm_path = 'watermark.' . $attachment_wm_path->extension;
                } else {
                    $model->attachment_wm_path = $oldWatermark;
                }

                $model->save();
                Yii::$app->session->setFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
            }
            return $this->refresh();
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }

}
