<?php

use \yii\db\Migration;

class m190124_110200_add_verification_token_column_to_user_table extends Migration
{
    private const string TABLE = '{{%user}}';

    /**
     * @return void
     */
    public function up(): void
    {
        $this->addColumn(self::TABLE, 'verification_token', $this->string()->defaultValue(null));
    }

    /**
     * @return void
     */
    public function down(): void
    {
        $this->dropColumn(self::TABLE, 'verification_token');
    }
}
