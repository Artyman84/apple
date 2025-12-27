<?php

namespace backend\enums;

enum EAppleStatus: int
{
    case ON_TREE = 1;
    case FELL = 2;

    public function label(): string
    {
        return match ($this) {
            self::ON_TREE => 'На дереве',
            self::FELL => 'Упало',
        };
    }
}
