<?php

use yii\db\Migration;

/**
 * Class m220116_211402_create_table_tasks
 */
class m220116_211402_create_table_tasks extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220116_211402_create_table_tasks cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220116_211402_create_table_tasks cannot be reverted.\n";

        return false;
    }
    */
}
