<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 23.10.2017
 * Time: 18:23
 */

namespace webivan\seomodule\components;

use Yii;
use yii\base\Action;

class BaseAction extends Action
{
    /**
     * @property ConfigMetaData
     */
    protected $model;

    /**
     * @inheritdoc
     */
    public function beforeRun()
    {
        $className = $this->controller->module->modelConfig;

        $this->model = new $className;
        $this->model->setScenario($this->scenario);

        return parent::beforeRun();
    }

    /**
     * Render view template
     *
     * @param string $viewName
     * @param array $params
     * @return string
     */
    public function render($viewName, array $params = [])
    {
        $module = Yii::$app->controller->module;

        $defaultParams = [
            'params' => Yii::$app->params['webivan@seomodule'],
            'connects' => $module->getConnects(),
            'dropDownConnect' => array_combine(array_keys($module->getConnects()), array_keys($module->getConnects()))
        ];

        return Yii::$app->controller->render($viewName, array_merge($defaultParams, $params));
    }
}