<?php

namespace shopium\mod\admin\controllers\admin;


use core\modules\user\models\User;
use panix\engine\grid\GridColumns;
use shopium\mod\admin\models\DesktopWidgets;
use shopium\mod\cart\models\Order;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use core\components\controllers\AdminController;
use shopium\mod\admin\models\Notification;
use panix\engine\Html;
use panix\engine\FileSystem;
use yii\web\UnauthorizedHttpException;

class DefaultController extends AdminController
{

    public $icon = 'icon-app';

    public function actionIndex()
    {

        $this->pageName = Yii::t('admin/default', 'CMS');
        $this->view->params['breadcrumbs'][] = $this->pageName;
        $this->clearCache();
        $this->clearAssets();

        return $this->render('index');
    }
    public function actionExtensions()
    {
        return $this->render('extensions');
    }
    public function actionAjaxCounters()
    {

        $notificationsAll = Notification::find()->read([Notification::STATUS_NO_READ, Notification::STATUS_NOTIFY])->all();
        $notificationsLimit = Notification::find()->limit(5)->all();
       // $notificationsCount = Notifications::find()->read([Notifications::STATUS_NO_READ, Notifications::STATUS_NOTIFY])->count();
        $result = [];
        foreach (Yii::$app->counters as $key=>$count){
            $result['count'][$key] = $count;
        }
        $result['count']['notifications'] = count($notificationsAll);

        $result['notify'] = [];
        foreach ($notificationsAll as $notify) {
            /** @var $notify Notification */
            $result['notify'][$notify->id] = [
                'text' => $notify->text,
                'status' => $notify->status,
                'type' => $notify->type,
                'url' => $notify->url,
                'sound' => $notify->sound
            ];
        }
        $result['content'] = $this->render('@admin/views/admin/notification/_notifications', ['notifications' => $notificationsLimit]);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $result;
    }

    public function actionAjaxNotificationStatus($id, $status)
    {
        $notifications = Notification::findOne($id);
        $notifications->status = $status;
        $notifications->save(false);

        Yii::$app->response->format = Response::FORMAT_JSON;
        return ['success' => true];
    }


    public function actionEditColumns()
    {
        if (Yii::$app->request->isAjax) {
            $modelClass = str_replace('/', '\\', Yii::$app->request->post('model'));

            $grid_id = Yii::$app->request->post('grid_id');
            $getGrid = Yii::$app->request->post('GridColumns');
            $pageSize = Yii::$app->request->post('pageSize');


            $model = GridColumns::findOne(['grid_id' => $grid_id]);

            if (!$model)
                $model = new GridColumns();

            if ($getGrid) {
                $model->grid_id = $grid_id;
                $model->modelClass = $modelClass;
                $model->column_data = Json::encode($getGrid);
                $model->pageSize = $pageSize;
                $model->save(false);
            }

            $data = [];

            /** @var \panix\engine\db\ActiveRecord $mClass */
            $mClass = new $modelClass();
            $columnsArray = $mClass->getGridColumns();

            unset($columnsArray['DEFAULT_COLUMNS'], $columnsArray['DEFAULT_CONTROL']);
            if (isset($columnsArray)) {
                foreach ($columnsArray as $key => $column) {
                    $isChecked = false;

                    if (isset($column['header'])) {
                        $name = $column['header'];
                    } else {
                        $name = $mClass->getAttributeLabel((isset($column['attribute'])) ? $column['attribute'] : $key);
                    }
                    if (isset($model->column_data[$key]['checked'])) {
                        $isChecked = true;
                    }
                    $order = (isset($model->column_data[$key]) && isset($model->column_data[$key]['ordern'])) ? $model->column_data[$key]['ordern'] : '';
                    $data[] = [
                        'checkbox' => Html::checkbox('GridColumns[' . $key . '][checked]', $isChecked, ['checked' => $isChecked]),
                        'name' => $name,
                        'sort' => Html::textInput('GridColumns[' . $key . '][ordern]', $order, ['class' => 'form-control text-center'])
                    ];
                }
            }

            $provider = new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => false
            ]);
            return $this->renderPartial('grid', [
                'modelClass' => $modelClass,
                'provider' => $provider,
                'grid_id' => $grid_id,
                'pageSize' => $model->pageSize,
            ]);
        } else {
            throw new UnauthorizedHttpException(401);
        }
    }

    public function clearCache()
    {
        $cacheId = Yii::$app->request->post('cache_id');
        if ($cacheId) {
            if ($cacheId == 'All') {
                Yii::$app->cache->flush();
            } else {
                Yii::$app->cache->delete(Yii::$app->request->post('cache_id'));
            }
            Yii::$app->session->setFlash('success', Yii::t('app/admin', 'SUCCESS_CLR_CACHE', ['id' => Yii::$app->request->post('cache_id')]));
        }
    }





    public function clearAssets()
    {
        if (Yii::$app->request->post('clear_assets')) {
            $s = (new FileSystem('assets', Yii::getAlias('@webroot')))->cleardir();
            Yii::$app->session->setFlash('success', Yii::t('app/admin', 'SUCCESS_CLR_ASSETS'));
        }
    }


    public function getAddonsMenu()
    {
        return [
            [
                'label' => Yii::t('admin/default', 'DESKTOP'),
                'visible' => true,
                'dropDownOptions'=>['class'=>'dropdown-menu-right'],
                'items' => [
                    [
                        'label' => Yii::t('admin/default', 'DESKTOP_CREATE'),
                        'url' => ['/admin/app/desktop/desktop-create'],
                        'visible' => true
                    ],
                    [
                        'label' => Yii::t('admin/default', 'DESKTOP_CREATE_WIDGET'),
                        'url' => ['/admin/app/desktop/widget-create','id'=>1],
                        'visible' => true,

                    ],
                ]
            ],
        ];
    }
}
