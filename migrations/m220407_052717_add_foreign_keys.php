<?php

use yii\db\Migration;

/**
 * Class m220407_052717_add_foreign_keys
 */
class m220407_052717_add_foreign_keys extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('{{%users}}', 'city_id');
        $this->dropColumn('{{%auth}}', 'user_id');
        $this->dropColumn('{{%tasks}}', 'category_id');
        $this->dropColumn('{{%tasks}}', 'customer_id');
        $this->dropColumn('{{%tasks}}', 'executor_id');
        $this->dropColumn('{{%tasks}}', 'city_id');
        // $this->dropColumn('{{%specializations}}', 'user_id');
        // $this->dropColumn('{{%specializations}}', 'specialization_id');
        // $this->dropColumn('{{%replies}}', 'executor_id');
        // $this->dropColumn('{{%replies}}', 'task_id');
        // $this->dropColumn('{{%opinions}}', 'customer_id');
        // $this->dropColumn('{{%opinions}}', 'executor_id');
        // $this->dropColumn('{{%opinions}}', 'task_id');

        $this->addColumn('{{%users}}', 'city_id', $this->integer()->null());
        $this->addColumn('{{%auth}}', 'auth_user_id', $this->integer()->notNull());
        $this->addColumn('{{%tasks}}', 'category_id', $this->integer()->notNull());
        $this->addColumn('{{%tasks}}', 'customer_id', $this->integer()->notNull());
        $this->addColumn('{{%tasks}}', 'executor_id', $this->integer()->null());
        $this->addColumn('{{%tasks}}', 'task_city_id', $this->integer()->null());
        // $this->addColumn('{{%specializations}}', 'specialization_user_id', $this->integer()->notNull());
        // $this->addColumn('{{%specializations}}', 'specialization_id', $this->integer()->notNull());
        // $this->addColumn('{{%replies}}', 'reply_executor_id', $this->integer()->notNull());
        // $this->addColumn('{{%replies}}', 'reply_task_id', $this->integer()->notNull());
        // $this->addColumn('{{%opinions}}', 'opinion_customer_id', $this->integer()->notNull());
        // $this->addColumn('{{%opinions}}', 'opinion_executor_id', $this->integer()->notNull());
        // $this->addColumn('{{%opinions}}', 'opinion_task_id', $this->integer()->notNull());

        $this->addForeignKey(
            'city_id',
            'users',
            'city_id',
            'cities',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'auth_user_id',
            'auth',
            'auth_user_id',
            'users',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'category_id',
            'tasks',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'customer_id',
            'tasks',
            'customer_id',
            'users',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'executor_id',
            'tasks',
            'executor_id',
            'users',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'task_city_id',
            'tasks',
            'task_city_id',
            'cities',
            'id',
            'CASCADE'
        );
        // $this->addForeignKey(
        //     'specialization_user_id',
        //     'specializations',
        //     'specialization_user_id',
        //     'users',
        //     'id',
        //     'CASCADE'
        // );
        // $this->addForeignKey(
        //     'specialization_id',
        //     'specializations',
        //     'specialization_id',
        //     'categories',
        //     'id',
        //     'CASCADE'
        // );
        // $this->addForeignKey(
        //     'reply_executor_id',
        //     'replies',
        //     'reply_executor_id',
        //     'users',
        //     'id',
        //     'CASCADE'
        // );
        // $this->addForeignKey(
        //     'reply_task_id',
        //     'replies',
        //     'reply_task_id',
        //     'tasks',
        //     'id',
        //     'CASCADE'
        // );
        // $this->addForeignKey(
        //     'opinion_customer_id',
        //     'opinions',
        //     'opinion_customer_id',
        //     'users',
        //     'id',
        //     'CASCADE'
        // );
        // $this->addForeignKey(
        //     'opinion_executor_id',
        //     'opinions',
        //     'opinion_executor_id',
        //     'users',
        //     'id',
        //     'CASCADE'
        // );
        // $this->addForeignKey(
        //     'opinion_task_id',
        //     'opinions',
        //     'opinion_task_id',
        //     'tasks',
        //     'id',
        //     'CASCADE'
        // );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%users}}');
        $this->dropTable('{{%auth}}');
        $this->dropTable('{{%tasks}}');
        // $this->dropTable('{{%specializations}}');
        // $this->dropTable('{{%replies}}');
        // $this->dropTable('{{%opinions}}');
    }
}
