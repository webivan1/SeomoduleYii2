<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 11:07
 */

namespace webivan\seomodule\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ItemsObjectText extends Model
{
    /**
     * @property string
     */
    public $key;

    /**
     * @property string
     */
    public $value;

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            ['key', 'filter', 'filter' => 'trim'],
            ['value', 'filter', 'filter' => function ($value) {
                return trim(preg_replace(["@\\r@", "@\\n@", "@\s{2,}@"], ' ', $value));
            }],
            ['key', 'match', 'pattern' => '/^[A-z0-9]+$/'],
            ['key', 'string', 'max' => 50],
            ['value', 'string'],
        ];
    }

    /**
     * Собираем удобный массив
     *
     * @param $data
     * @return array
     */
    public static function compactArrayObjectText(array $data)
    {
        $newData = [];

        foreach ($data as $key => $value) {
            for ($i = 0; $i < count($value); $i++) {
                if (!empty($value[$i])) {
                    $newData[$i][$key] = is_string($value[$i]) ? trim($value[$i]) : $value[$i];
                }
            }
        }

        return !empty($newData)
            ? ArrayHelper::map(array_values($newData), 'key', 'value')
            : [];
    }
}