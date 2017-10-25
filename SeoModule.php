<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 22.10.2017
 * Time: 18:56
 */

namespace webivan\seomodule;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Exception;
use yii\base\Module;
use yii\web\Application;
use yii\web\GroupUrlRule;

class SeoModule extends Module implements BootstrapInterface
{
    /**
     * @property \Closure
     */
    public $accessDoctype;

    /**
     * @property array<\Closure>
     */
    public $accessRulesAction;

    /**
     * @property string
     */
    public $pathConnects;

    /**
     * Class name ActionIndex
     *
     * @property string
     */
    public $actionIndex = 'webivan\seomodule\actions\ActionIndex';

    /**
     * Class name ActionCreate
     *
     * @property string
     */
    public $actionCreate = 'webivan\seomodule\actions\ActionCreate';

    /**
     * Class name ActionUpdate
     *
     * @property string
     */
    public $actionUpdate = 'webivan\seomodule\actions\ActionUpdate';

    /**
     * Class name ActionDelete
     *
     * @property string
     */
    public $actionDelete = 'webivan\seomodule\actions\ActionDelete';

    /**
     * Class name ConfigMetaData
     *
     * @property string
     */
    public $modelConfig = 'webivan\seomodule\models\ConfigMetaData';

    /**
     * Class name Seotexts
     *
     * @property string
     */
    public $modelSeotext = 'webivan\seomodule\models\Seotexts';

    /**
     * @property array
     */
    public $filterTemplater = [
        'default' => 'default',
        'twig' => 'twig'
    ];

    /**
     * @property array
     */
    public $classMapTemplater = [
        'default' => 'webivan\seomodule\templaters\def\DefaultTemplater',
        'twig' => 'webivan\seomodule\templaters\twig\TwigTemplater'
    ];

    /**
     * @property array
     */
    private static $_connects;

    /**
     * @inheritdoc
     */
    public function bootstrap($app)
    {
        if ($app instanceof Application) {
            $app->getUrlManager()->addRules([
                new GroupUrlRule([
                    'prefix' => 'seomodule',
                    'rules' => [
                        '' => 'default',
                        '<controller:\w+>' => '<controller>/index',
                        '<controller:\w+>/<action:[A-z0-9\-_]+>' => '<controller>/<action>'
                    ],
                ])
            ]);
        }

        $app->setAliases([
            '@seomodule' => __DIR__
        ]);

        $app->params['webivan@seomodule'] = [
            'filterTemplater' => $this->filterTemplater
        ];
    }

    /**
     * Connect exists
     *
     * @param string $connectName
     * @return bool
     */
    public function hasConnect($connectName)
    {
        if (!self::$_connects) {
            $this->getConnects();
        }

        return array_key_exists($connectName, self::$_connects);
    }

    /**
     * Get all connects
     *
     * @return array
     */
    public function getConnects()
    {
        if (!self::$_connects) {
            $pathConnect = Yii::getAlias($this->pathConnects);

            if (!is_dir($pathConnect)) {
                throw new Exception("Undefined path " . $pathConnect);
            }

            $connects = glob($pathConnect . DIRECTORY_SEPARATOR . '*.php');

            foreach ($connects as $connect) {
                self::$_connects[str_replace('.php', '', basename($connect))] = $connect;
            }

            ksort(self::$_connects);
        }

        return self::$_connects;
    }
}