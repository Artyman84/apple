<?php

namespace backend\enums;

enum EAppleColor: int
{
    case GREEN = 1;
    case RED = 2;
    case YELLOW = 3;

    public function alias(): string
    {
        return match ($this) {
            self::GREEN => 'success',
            self::RED => 'danger',
            self::YELLOW => 'warning',
        };
    }
}
