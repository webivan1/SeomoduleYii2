<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 15:23
 */

namespace webivan\seomodule\actions;

use Yii;
use webivan\seomodule\components\BaseAction;
use yii\web\NotFoundHttpException;

class ActionUpdate extends BaseAction
{
    /**
     * @property string
     */
    public $scenario;

    /**
     * @property string
     */
    public $viewName;

    /**
     * @inheritdoc
     */
    public function beforeRun()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function run($id)
    {
        $className = $this->controller->module->modelConfig;

        if (is_null($this->model = $className::findOne(['id' => intval($id)]))) {
            throw new NotFoundHttpException();
        }

        $this->model->setScenario($this->scenario);

        if (
            Yii::$app->request->isPost &&
            $this->model->load(Yii::$app->request->post()) &&
            $this->model->validate() &&
            $this->model->save(false)
        ) {
            $this->controller->refresh();
        }

        return $this->render($this->viewName, [
            'model' => $this->model
        ]);
    }
}