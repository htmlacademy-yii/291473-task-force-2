<?php

use yii\db\Migration;

/**
 * Class m220325_134835_add_private_profiles
 */
class m220325_134835_add_private_profiles extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{profiles}}', 'private', $this->boolean()->notNull()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%profiles}}');
    }
}
