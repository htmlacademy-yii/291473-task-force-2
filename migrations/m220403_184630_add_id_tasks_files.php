<?php

use yii\db\Migration;

/**
 * Class m220403_184630_add_id_tasks_files
 */
class m220403_184630_add_id_tasks_files extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tasks_files}}', 'id', $this->primaryKey());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%tasks_files}}');
    }
}
