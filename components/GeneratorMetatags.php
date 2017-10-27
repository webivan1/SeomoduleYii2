<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 16:45
 */

namespace webivan\seomodule\components;

use Yii;
use yii\base\Component;
use webivan\seomodule\connects\IConnects;
use webivan\seomodule\models\Seotexts;
use webivan\seomodule\SeoModule;
use webivan\seomodule\templaters\ITemplater;
use webivan\seomodule\models\ConfigMetaData;
use yii\base\Exception;
use yii\db\ActiveQuery;
use yii\db\Command;
use yii\helpers\ArrayHelper;

class GeneratorMetatags extends Component
{
    /**
     * Dev
     *
     * @property bool
     */
    public $dev = false;

    /**
     * Html encode
     *
     * @property bool
     */
    public $encode = true;

    /**
     * @property ConfigMetaData
     */
    private $model;

    /**
     * @property SeoModule
     */
    private $module;

    /**
     * limit insert datas
     *
     * @property int
     */
    private $limitInsert = 500;

    /**
     * @property array
     */
    public $metaDatas = [];

    /**
     * Start
     *
     * @param ConfigMetaData $model
     * @throws Exception
     */
    public function run(ConfigMetaData $model)
    {
        $this->model = $model;

        $this->module = Yii::$app->getModule('seomodule');

        if (!$this->module || !$this->module instanceof SeoModule) {
            throw new Exception("Undefined module seomodule");
        }

        $this->runConnect(
            $this->getConnect($this->module->pathConnects, $model->connect)
        );

        // Update run date
        $this->model->run_date = date('Y-m-d H:i:s');
        $this->model->save();
    }

    /**
     * Delete all old datas
     *
     * @return void
     */
    private function deleteAllBySource()
    {
        Seotexts::deleteAll([
            'source' => $this->model->source
        ]);
    }

    /**
     * Get connect file
     *
     * @param string $pathToConencts
     * @param string $connectName
     * @return any
     */
    public function getConnect($pathToConencts, $connectName)
    {
        if (strpos($pathToConencts, '@') === 0) {
            $pathToConencts = Yii::getAlias($pathToConencts);
        }

        $fullPath = $pathToConencts . DIRECTORY_SEPARATOR . $connectName . '.php';

        if (!is_file($fullPath)) {
            throw new Exception("Undefined path to " . $fullPath);
        }

        return require $fullPath;
    }

    /**
     * Handler data
     *
     * @param any $queryConnect
     */
    public function runConnect($queryConnect)
    {
        $results = $this->getDatasConnect($queryConnect);

        // delete old seotexts
        $this->deleteAllBySource();

        if (empty($results)) {
            throw new Exception("Not datas - " . $this->model->id);
        }

        foreach ($results as $item) {

            if (!isset($this->module->classMapTemplater[$this->model->templater])) {
                throw new Exception("Undefined templater {$this->model->templater}, config_id: {$this->model->id}");
            }

            $templaterClass = $this->module->classMapTemplater[$this->model->templater];

            $objectTemplater = new $templaterClass($this->model->meta_template, $item);

            if (!$objectTemplater instanceof ITemplater) {
                throw new Exception("Error! Templater class is not ITemplater interface");
            }

            $rows = $objectTemplater->run();

            if ($this->encode) {
                $rows = ArrayHelper::htmlEncode($rows);
            }

            $metaTags = array_merge([
                'value' => $item['id'] ?? 0,
                'source' => $this->model->source
            ], $rows);

            $this->createMeta($metaTags);
        }

        if (!empty($this->metaDatas)) {
            $this->save();
        }
    }

    /**
     * Handler data
     *
     * @param any $queryConnect
     */
    private function createMeta(array $metaTag)
    {
        $this->metaDatas[] = $metaTag;

        if (sizeof($this->metaDatas) >= $this->limitInsert) {
            $this->save();
        }
    }

    /**
     * Сохраняем в базу мета теги
     *
     * @return void
     */
    private function save()
    {
        $db = Seotexts::getDb();

        $transaction = $db->beginTransaction();

        try {

            $this->metaDatas = array_values($this->metaDatas);
            $columns = array_keys($this->metaDatas[0]);

            $db->createCommand()->batchInsert(Seotexts::tableName(), $columns, $this->metaDatas)
                ->execute();

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollBack();

            throw new Exception($e->getMessage());
        }

        $this->metaDatas = [];
    }

    /**
     * Определяем тип данных и возвращаем результат
     *
     * @param any $queryConnect
     * @return array|\Generator
     */
    public function getDatasConnect($queryConnect)
    {
        $result = null;

        if ($queryConnect instanceof Command) {
            if ($this->dev) {
                return [$queryConnect->queryOne()];
            }

            return $queryConnect->queryAll();
        }

        if ($queryConnect instanceof ActiveQuery) {
            if ($this->dev) {
                $queryConnect
                    ->orderBy('RAND()')
                    ->limit(1);
            }

            return $queryConnect->asArray()->all();
        }

        if ($queryConnect instanceof IConnects) {
            $result = $queryConnect->run($this->dev);
        }

        if (is_callable($queryConnect)) {
            $result = call_user_func($queryConnect, $this->dev);
        }

        if ($result instanceof \Generator) {
            $result->rewind();
        }

        return $result;
    }
}