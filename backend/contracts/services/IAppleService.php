<?php

namespace backend\contracts\services;

use backend\models\Apple;
use backend\models\entities\AppleEntity;
use Random\RandomException;
use Throwable;
use yii\web\NotFoundHttpException;

interface IAppleService
{
    /**
     * @param int $id
     *
     * @return Apple
     *
     * @throws NotFoundHttpException
     */
    public function getById(int $id): Apple;

    /**
     * @return AppleEntity[]
     *
     * @throws RandomException
     */
    public function generateRandom(): array;

    /**
     * @return AppleEntity[]
     */
    public function getAllEntities(): array;

    /**
     * @param int $id
     *
     * @return void
     *
     * @throws Throwable
     */
    public function fallToGround(int $id): void;

    /**
     * @param int $id
     * @param int $percent
     *
     * @return void
     *
     * @throws Throwable
     */
    public function eat(int $id, int $percent): void;

    /**
     * @param int $id
     *
     * @return void
     *
     * @throws Throwable
     */
    public function delete(int $id): void;
}
