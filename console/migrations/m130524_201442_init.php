<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'role' => $this->string()->defaultValue("customer"),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%ticket}}', [
            'id' => $this->primaryKey(),
            'subject' => $this->string()->notNull(),
            'message' => $this->text()->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'admin_id' => $this->integer(),
            'created_at' => $this->integer(),
            'is_answered' => $this->integer()->notNull()->defaultValue(0),
            'is_closed' => $this->integer()->notNull()->defaultValue(0),
            'product_id' => $this->integer()->notNull(),
            'file' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%conversation}}', [
            'id' => $this->primaryKey(),
            'message' => $this->text()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'ticket_id' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'file' => $this->text(),
        ], $tableOptions);

        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ], $tableOptions);

        // Relations are here

        $this->addForeignKey(
            'fk-ticket-customer_id',
            'ticket',
            'customer_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-ticket-admin_id',
            'ticket',
            'admin_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-conversation-user_id',
            'conversation',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-conversation-ticket_id',
            'conversation',
            'ticket_id',
            'ticket',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-ticket-product_id',
            'ticket',
            'product_id',
            'product',
            'id',
            'CASCADE'
        );

        //

        $this->insert('user', [
            'role' => 'admin',
            'username' => 'admin',
            'auth_key' => 'admin',
            'password_hash' => '$2y$13$bivTkmQGTdjDUVKq4n48ke4iS5aMqr96qaziS7yKutuoJkaEQaF1u',
            'password_reset_token' => null,
            'email' => 'matari.ehsan@yahoo.com',
            'status' => '10',
            'created_at' => '1564287127',
            'updated_at' => '1564287127',


        ]);

    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
