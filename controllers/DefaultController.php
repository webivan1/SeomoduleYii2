<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 22.10.2017
 * Time: 20:00
 */

namespace webivan\seomodule\controllers;

use Yii;
use webivan\seomodule\models\ConfigMetaData;
use webivan\seomodule\components\GeneratorMetatags;
use webivan\seomodule\components\Controller;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class DefaultController extends Controller
{
    /**
     * @property string
     */
    public $defaultAction = 'welcome';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'index' => [
                'class' => $this->module->actionIndex,
                'viewName' => 'index',
                'scenario' => 'search'
            ],
            'create' => [
                'class' => $this->module->actionCreate,
                'viewName' => 'form',
                'scenario' => 'create'
            ],
            'update' => [
                'class' => $this->module->actionUpdate,
                'viewName' => 'form',
                'scenario' => 'update'
            ],
            'delete' => [
                'class' => $this->module->actionDelete
            ]
        ];
    }

    /**
     * Action /
     */
    public function actionWelcome()
    {
        return $this->render('welcome');
    }

    /**
     * Action /get-connect?alias={alias}
     */
    public function actionGetConnect($alias)
    {
        if (!Yii::$app->request->isAjax) {
            throw new NotFoundHttpException();
        }

        $model = new GeneratorMetatags();

        $model->dev = true;

        $datas = $model->getDatasConnect(
            $model->getConnect($this->module->pathConnects, $alias)
        );

        $result = $datas instanceof \Generator
            ? $datas->current()
            : $datas[0];

        Yii::$app->getResponse()->format = Response::FORMAT_RAW;

        ob_start();
        VarDumper::dump($result, 5, true);
        $content = ob_get_contents();
        ob_get_clean();

        return $content;
    }

    /**
     * Action /run?id={id}
     */
    public function actionRun($id)
    {
        if (!Yii::$app->request->isAjax || is_null($model = ConfigMetaData::findOne(intval($id)))) {
            throw new NotFoundHttpException();
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $generator = new GeneratorMetatags();
        $generator->run($model);

        return ['state' => 'ok'];
    }
}