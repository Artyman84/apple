<?php

namespace backend\models;

use backend\queries\AppleQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%apple}}".
 *
 * @property int $id
 * @property int $color
 * @property int $status
 * @property float $size
 * @property int $appeared_at
 * @property int|null $fell_at
 */
class Apple extends ActiveRecord
{
    private const float DEFAULT_SIZE = 1.00;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%apple}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['fell_at'], 'default', 'value' => null],
            [['size'], 'default', 'value' => self::DEFAULT_SIZE],
            [['color', 'status', 'appeared_at'], 'required'],
            [['color', 'status', 'appeared_at', 'fell_at'], 'integer'],
            [['size'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @return AppleQuery the active query used by this AR class.
     */
    public static function find(): AppleQuery
    {
        return new AppleQuery(static::class);
    }
}
