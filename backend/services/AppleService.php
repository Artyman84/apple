<?php

namespace backend\services;

use backend\contracts\mappers\IAppleMapper;
use backend\contracts\services\IAppleService;
use backend\enums\EAppleColor;
use backend\models\Apple;
use backend\models\entities\AppleEntity;
use DomainException;
use Throwable;
use Yii;
use yii\web\NotFoundHttpException;

readonly class AppleService implements IAppleService
{
    private const int MIN_APPLE_COUNT = 5;
    private const int MAX_APPLE_COUNT = 10;

    public function __construct(private IAppleMapper $mapper)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getById(int $id): Apple
    {
        $apple = Apple::findOne($id);
        if (is_null($apple)) {
            throw new NotFoundHttpException('Яблоко не найдено');
        }

        return $apple;
    }

    /**
     * {@inheritdoc}
     */
    public function generateRandom(): array
    {
        $count = random_int(self::MIN_APPLE_COUNT, self::MAX_APPLE_COUNT);
        $now = time();
        $from = $now - 24 * 3600;
        $colors = EAppleColor::cases();
        $entities = [];

        $transaction = Yii::$app->db->beginTransaction();
        try {
            Apple::deleteAll();
            for ($i = 0; $i < $count; $i++) {
                $color = $colors[array_rand($colors)];
                $appearedAt = random_int($from, $now);

                $entity = AppleEntity::create($color, $appearedAt);
                $activeRecord = $this->mapper->toActiveRecord($entity);

                if (!$activeRecord->save()) {
                    $errors = $activeRecord->getFirstErrors();
                    throw new DomainException('Не удалось сохранить яблоко: ' . array_shift($errors));
                }

                $entities[] = $this->mapper->toEntity($activeRecord);
            }
            $transaction->commit();
        } catch (Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $entities;
    }

    /**
     * {@inheritdoc}
     */
    public function getAllEntities(): array
    {
        $apples = Apple::find()->orderBy(['id' => SORT_ASC])->all();
        $entities = [];
        foreach ($apples as $apple) {
            $entities[] = $this->mapper->toEntity($apple);
        }
        return $entities;
    }

    /**
     * {@inheritdoc}
     */
    public function fallToGround(int $id): void
    {
        $apple = $this->getById($id);
        $appleEntity = $this->mapper->toEntity($apple);
        $appleEntity->fallToGround();

        $apple = $this->mapper->fillActiveRecord($appleEntity, $apple);
        $apple->save();
    }

    /**
     * {@inheritdoc}
     */
    public function eat(int $id, int $percent): void
    {
        $apple = $this->getById($id);
        $appleEntity = $this->mapper->toEntity($apple);
        $appleEntity->eat($percent);

        $apple = $this->mapper->fillActiveRecord($appleEntity, $apple);
        $apple->save();
    }

    /**
     * {@inheritdoc}
     */
    public function delete(int $id): void
    {
        $apple = $this->getById($id);
        $appleEntity = $this->mapper->toEntity($apple);
        if (!$appleEntity->isEaten()) {
            throw new DomainException('Нельзя удалить яблоко: оно не съедено полностью.');
        }

        $apple->delete();
    }
}
