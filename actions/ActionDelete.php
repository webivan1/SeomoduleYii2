<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 16:31
 */

namespace webivan\seomodule\actions;

use webivan\seomodule\helpers\Url;
use Yii;
use webivan\seomodule\components\BaseAction;
use yii\web\NotFoundHttpException;

class ActionDelete extends BaseAction
{
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

        $this->model->delete();

        $this->controller->goBack(Url::to('/default/index'));
    }
}