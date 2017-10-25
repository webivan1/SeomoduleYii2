<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 17:31
 */

namespace webivan\seomodule\templaters;

use Yii;
use yii\helpers\Json;

abstract class Templater
{
    /**
     * @property array
     */
    protected static $instance = [];

    /**
     * Один item с данными
     *
     * @property array
     */
    public $data;

    /**
     * Тексты для шаблонизатора
     *
     * @property array
     */
    public $parseData;

    /**
     * Init
     */
    protected function __construct($params, array $data)
    {
        $this->parseData = is_string($params) ? Json::decode($params, true) : $params;
        $this->data = $data;
    }

    private function __wakeup()
    {
    }

    private function __clone()
    {
    }

    /**
     * Multi singleton
     *
     * @return static
     */
    public static function getInstance($params, array $data)
    {
        $className = get_called_class();

        if (!array_key_exists($className, self::$instance)) {
            self::$instance[$className] = new static($params, $data);
        }

        return self::$instance[$className];
    }

    /**
     * Init
     *
     * @return array
     */
    public function run()
    {
        $results = [];

        if (empty($this->parseData)) {
            return false;
        }

        foreach ($this->parseData as $key => $text) {
            if (empty($text)) {
                $results[$key] = '';
                continue;
            }

            if (is_array($text)) {
                $model = new static(
                    json_encode($text, JSON_UNESCAPED_UNICODE),
                    $this->data
                );

                $textArray = $model->run();
                $results[$key] = json_encode($textArray, JSON_UNESCAPED_UNICODE);
            } else if (method_exists($this, 'parseText')) {
                $results[$key] = $this->parseText($text, $key);
            }
        }

        return $results;
    }
}