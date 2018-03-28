<?php

use yii\db\Migration;

/**
 * Class m000001_000001_add_table_seomodule
 *
 * yii migrate --migrationPath="@vendor/yii2-webivan1/yii2-seomodule/migrations"
 */
class m000001_000001_add_table_seomodule extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable('{{%config_meta_data}}', [
            'id' => $this->primaryKey(),
            'source' => $this->string(150)->notNull()->unique(),
            'connect' => $this->string(150)->null(),
            'state' => $this->integer(1)->defaultValue(2),
            'meta_template' => $this->text()->null(),
            'run_date' => $this->timestamp()->null(),
            'templater' => $this->string(100)->defaultValue('default')
        ]);

        $this->createIndex('connect', '{{%config_meta_data}}', 'connect');

        $this->createTable('{{%seotexts}}', [
            'id' => $this->primaryKey(),
            'source' => $this->string(150)->notNull(),
            'value' => $this->string(150)->notNull(),
            'state' => $this->integer(1)->defaultValue(2),
            'title' => $this->string(255)->null(),
            'description' => $this->text()->null(),
            'heading_1' => $this->string(255)->null(),
            'heading_2' => $this->string(255)->null(),
            'heading_3' => $this->string(255)->null(),
            'seotext' => $this->text()->null(),
            'other_text' => $this->text()->null(),
            'object_text' => $this->text()->null(),
            'create_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP')
        ]);

        $this->createIndex('source_value', '{{%seotexts}}', ['source', 'value'], true);
        $this->createIndex('source', '{{%seotexts}}', 'source');
        $this->createIndex('value', '{{%seotexts}}', 'value');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable('{{%config_meta_data}}');
        $this->dropTable('{{%seotexts}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m171025_124049_add_table_seomodule cannot be reverted.\n";

        return false;
    }
    */
}
