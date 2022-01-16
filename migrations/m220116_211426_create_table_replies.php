<?php

use yii\db\Migration;

/**
 * Class m220116_211426_create_table_replies
 */
class m220116_211426_create_table_replies extends Migration
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
        echo "m220116_211426_create_table_replies cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220116_211426_create_table_replies cannot be reverted.\n";

        return false;
    }
    */
}
