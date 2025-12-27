<?php

namespace backend\models\entities;

use backend\enums\EAppleColor;
use backend\enums\EAppleStatus;
use DomainException;
use InvalidArgumentException;
use LogicException;

class AppleEntity
{
    private const int MAX_SIZE = 100;
    private const int ROTTEN_AFTER_SECONDS = 5 * 3600;

    /**
     * @param int|null $id
     * @param EAppleColor $color
     * @param EAppleStatus $status
     * @param int $size
     * @param int $appearedAt
     * @param int|null $fellAt
     */
    private function __construct(
        private readonly int|null $id,
        private readonly EAppleColor $color,
        private EAppleStatus         $status,
        private int                  $size,
        private readonly int         $appearedAt,
        private int|null             $fellAt = null
    ) {
        if ($id !== null && $id <= 0) {
            throw new InvalidArgumentException('ID яблока должен быть положительным.');
        }

        if ($status === EAppleStatus::ON_TREE && $fellAt !== null) {
            throw new LogicException('Яблоко находится на дереве, поэтому дата падения не должна быть установлена.');
        }

        if ($status === EAppleStatus::FELL && $fellAt === null) {
            throw new LogicException('Яблоко помечено как упавшее, но дата падения не установлена.');
        }

        if ($size < 0 || $size > self::MAX_SIZE) {
            throw new InvalidArgumentException('Размер яблока должен быть в диапазоне от 0 до ' . self::MAX_SIZE . ' процентов.');
        }

        if ($appearedAt <= 0) {
            throw new InvalidArgumentException('Дата появления яблока должна быть положительным Unix-timestamp.');
        }

        if ($fellAt !== null && $fellAt < $appearedAt) {
            throw new LogicException('Дата падения не может быть раньше даты появления яблока.');
        }
    }

    /**
     * @param EAppleColor $color
     * @param int $appearedAt
     *
     * @return static
     */
    public static function create(EAppleColor $color, int $appearedAt): self
    {
        return new static(null, $color, EAppleStatus::ON_TREE, self::MAX_SIZE, $appearedAt, null);
    }

    /**
     * @param int $id
     * @param EAppleColor $color
     * @param EAppleStatus $status
     * @param int $size
     * @param int $appearedAt
     * @param int|null $fellAt
     *
     * @return static
     */
    public static function restore(int $id, EAppleColor $color, EAppleStatus $status, int $size, int $appearedAt, int|null $fellAt): self
    {
        return new static($id, $color, $status, $size, $appearedAt, $fellAt);
    }

    /**
     * @param int|null $fellAt
     *
     * @return void
     */
    public function fallToGround(int|null $fellAt = null): void
    {
        if ($this->status === EAppleStatus::FELL) {
            throw new DomainException('Яблоко уже упало.');
        }

        $fellAt ??= time();
        if ($fellAt < $this->appearedAt) {
            throw new DomainException('Яблоко не может упасть раньше, чем оно появилось.');
        }

        $this->status = EAppleStatus::FELL;
        $this->fellAt = $fellAt;
    }

    /**
     * @param int $percent
     * @param int|null $time
     *
     * @return void
     */
    public function eat(int $percent, int|null $time = null): void
    {
        $time ??= time();

        if ($this->status === EAppleStatus::ON_TREE) {
            throw new DomainException('Съесть нельзя: яблоко висит на дереве.');
        }

        if ($percent <= 0) {
            throw new InvalidArgumentException('Процент должен быть больше 0.');
        }

        if ($percent > self::MAX_SIZE) {
            throw new InvalidArgumentException('Процент не может быть больше ' . self::MAX_SIZE . '.');
        }

        if ($this->size <= 0) {
            throw new DomainException('Нечего есть: яблоко уже съедено полностью.');
        }

        if ($percent > $this->size) {
            throw new DomainException("Нельзя съесть {$percent}%. Можно максимум {$this->size}%.");
        }

        if ($this->isRotten($time)) {
            throw new DomainException('Съесть нельзя: яблоко испортилось.');
        }

        $this->size -= $percent;
    }

    /**
     * @param int|null $time
     *
     * @return bool
     */
    public function isRotten(int|null $time = null): bool
    {
        $time ??= time();
        if ($this->status !== EAppleStatus::FELL || is_null($this->fellAt) || $time < $this->fellAt) {
            return false;
        }

        return ($time - $this->fellAt) >= self::ROTTEN_AFTER_SECONDS;
    }

    /**
     * @return bool
     */
    public function isEaten(): bool
    {
        return $this->size <= 0;
    }

    /**
     * @return EAppleColor
     */
    public function color(): EAppleColor
    {
        return $this->color;
    }

    /**
     * @return int|null
     */
    public function id(): int|null
    {
        return $this->id;
    }

    /**
     * @return EAppleStatus
     */
    public function status(): EAppleStatus
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function sizePercent(): int
    {
        return $this->size;
    }

    /**
     * @return int
     */
    public function appearedAt(): int
    {
        return $this->appearedAt;
    }

    /**
     * @return int|null
     */
    public function fellAt(): int|null
    {
        return $this->fellAt;
    }
}
