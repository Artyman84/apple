<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    private const string TABLE = '{{%user}}';

    /**
     * @return void
     */
    public function up(): void
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB');
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->dropTable(self::TABLE);
    }
}
