<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 22.10.2017
 * Time: 20:00
 */

namespace webivan\seomodule\components;

use Yii;
use yii\web\Controller as Base;
use yii\web\NotAcceptableHttpException;

class Controller extends Base
{
    /**
     * Layout path
     *
     * @property string
     */
    public $layout = '@seomodule/views/layouts/main';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (is_callable($this->module->accessDoctype)) {
            if (!call_user_func($this->module->accessDoctype)) {
                throw new NotAcceptableHttpException();
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        //
        if (!empty($this->module->accessRulesAction[$action->id]) && is_callable($this->module->accessRulesAction[$action->id])) {
            if (!call_user_func($this->module->accessRulesAction[$action->id])) {
                throw new NotAcceptableHttpException();
            }
        }

        return parent::beforeAction($action);
    }
}