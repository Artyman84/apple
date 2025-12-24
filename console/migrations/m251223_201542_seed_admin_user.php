<?php

use yii\db\Migration;

class m251223_201542_seed_admin_user extends Migration
{
    private const string TABLE = '{{%user}}';
    private const string USERNAME = 'admin';
    private const string PASSWORD = 'admin';
    private const string EMAIL = 'admin@admin.com';
    private const int ACTIVE_STATUS = 10;

    /**
     * {@inheritdoc}
     *
     * @throws \yii\base\Exception
     */
    public function safeUp(): void
    {
        $now = time();

        $this->insert(self::TABLE, [
            'username' => self::USERNAME,
            'auth_key' => Yii::$app->security->generateRandomString(32),
            'password_hash' => Yii::$app->security->generatePasswordHash(self::PASSWORD),
            'password_reset_token' => null,
            'email' => self::EMAIL,
            'status' => self::ACTIVE_STATUS,
            'created_at' => $now,
            'updated_at' => $now,
            'verification_token' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->delete(self::TABLE, ['username' => self::USERNAME]);
    }
}
