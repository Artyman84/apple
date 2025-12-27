<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%apple}}`.
 */
class m251224_210929_create_apple_table extends Migration
{
    private const string TABLE = '{{%apple}}';
    private const float SIZE = 1.00;
    private const int ON_TREE_STATUS = 1;

    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable(self::TABLE, [
            'id' => $this->primaryKey(),
            'color' => $this->tinyInteger()->notNull(),
            'status' => $this->tinyInteger()->notNull()->defaultValue(self::ON_TREE_STATUS),
            'size' => $this->decimal(3, 2)->notNull()->defaultValue(self::SIZE),
            'appeared_at' => $this->integer()->notNull(),
            'fell_at' => $this->integer()->null(),
        ]);

        $this->execute('ALTER TABLE ' . self::TABLE . ' ADD CONSTRAINT `chk_apple_size_range` CHECK (`size` >= 0 AND `size` <= 1)');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropTable(self::TABLE);
    }
}
