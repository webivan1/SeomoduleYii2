<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 24.10.2017
 * Time: 16:35
 */

namespace webivan\seomodule\behaviors;

use webivan\seomodule\models\Seotexts;
use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class DeleteWithSeotexts extends Behavior
{
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'deleteAll'
        ];
    }

    /**
     * Event
     *
     * @param \yii\base\Event $event
     */
    public function deleteAll($event)
    {
        Seotexts::deleteAll([
            'source' => $event->sender->source
        ]);
    }
}