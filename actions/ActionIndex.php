<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 23.10.2017
 * Time: 15:48
 */

namespace webivan\seomodule\actions;

use Yii;
use webivan\seomodule\components\BaseAction;

/**
 * View grid datas
 */
class ActionIndex extends BaseAction
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
        $this->model->load(Yii::$app->request->get()) && $this->model->validate();

        return $this->render($this->viewName, [
            'model' => $this->model,
            'dataProvider' => $this->model->search()
        ]);
    }
}