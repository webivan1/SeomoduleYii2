<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 26.10.2017
 * Time: 15:35
 */

namespace webivan\seomodule\controllers;

use Yii;
use webivan\seomodule\components\Controller;

class DocsController extends Controller
{
    /**
     * Action /docs
     */
    public function actionIndex()
    {
        return $this->render('connect');
    }

    /**
     * Action /docs/config
     */
    public function actionConfig()
    {
        return $this->render('seo_config');
    }
}