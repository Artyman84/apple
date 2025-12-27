<?php

namespace backend\queries;

use backend\models\Apple;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\backend\models\Apple]].
 *
 * @see \backend\models\Apple
 */
class AppleQuery extends ActiveQuery
{
    /**
     * {@inheritdoc}
     *
     * @return Apple[]|array
     */
    public function all($db = null): array
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     *
     * @return Apple|array|null
     */
    public function one($db = null): Apple|array|null
    {
        return parent::one($db);
    }
}
