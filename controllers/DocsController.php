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

    /**
     * Action /docs/config
     */
    public function actionRunConfig()
    {
        return $this->render('run_config');
    }

    /**
     * Action /docs/metatags
     */
    public function actionMetatags()
    {
        return $this->render('metatags');
    }

    /**
     * Action /docs/templaters
     */
    public function actionTemplaters()
    {
        return $this->render('templaters');
    }
}