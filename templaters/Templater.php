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
    public function __construct($params, array $data)
    {
        $this->parseData = is_string($params) ? Json::decode($params, true) : $params;
        $this->data = $data;
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
            echo $key . PHP_EOL;

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