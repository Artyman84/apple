<?php

namespace backend\mappers;

use backend\contracts\mappers\IAppleMapper;
use backend\enums\EAppleColor;
use backend\enums\EAppleStatus;
use backend\models\Apple;
use backend\models\entities\AppleEntity;

class AppleMapper implements IAppleMapper
{
    /**
     * {@inheritdoc}
     */
    public function toEntity(Apple $activeRecord): AppleEntity
    {
        return AppleEntity::restore(
            $activeRecord->id,
            EAppleColor::from($activeRecord->color),
            EAppleStatus::from($activeRecord->status),
            (int) round($activeRecord->size * 100),
            $activeRecord->appeared_at,
            $activeRecord->fell_at
        );
    }

    /**
     * {@inheritdoc}
     */
    public function toActiveRecord(AppleEntity $entity): Apple
    {
        $activeRecord = new Apple();
        return $this->fillActiveRecord($entity, $activeRecord);
    }

    /**
     * {@inheritdoc}
     */
    public function fillActiveRecord(AppleEntity $entity, Apple $activeRecord): Apple
    {
        $activeRecord->color = $entity->color()->value;
        $activeRecord->status = $entity->status()->value;
        $activeRecord->size = round($entity->sizePercent() / 100, 2);
        $activeRecord->appeared_at = $entity->appearedAt();
        $activeRecord->fell_at = $entity->fellAt();

        return $activeRecord;
    }
}
