<?php

namespace backend\contracts\mappers;

use backend\models\Apple;
use backend\models\entities\AppleEntity;

interface IAppleMapper
{
    /**
     * @param Apple $activeRecord
     *
     * @return AppleEntity
     */
    public function toEntity(Apple $activeRecord): AppleEntity;

    /**
     * @param AppleEntity $entity
     *
     * @return Apple
     */
    public function toActiveRecord(AppleEntity $entity): Apple;

    /**
     * @param AppleEntity $entity
     * @param Apple $activeRecord
     *
     * @return Apple
     */
    public function fillActiveRecord(AppleEntity $entity, Apple $activeRecord): Apple;
}
