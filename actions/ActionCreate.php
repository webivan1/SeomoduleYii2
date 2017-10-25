<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 23.10.2017
 * Time: 18:22
 */

namespace webivan\seomodule\actions;

use Yii;
use webivan\seomodule\components\BaseAction;
use webivan\seomodule\helpers\Url;

class ActionCreate extends BaseAction
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
    public function run()
    {
        if (
            Yii::$app->request->isPost &&
            $this->model->load(Yii::$app->request->post()) &&
            $this->model->validate() &&
            $this->model->save(false)
        ) {
            $this->controller->redirect(Url::to('/default/index'));
        }

        return $this->render($this->viewName, [
            'model' => $this->model
        ]);
    }
}