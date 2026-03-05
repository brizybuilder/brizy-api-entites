<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Constants;

class RedirectConst
{
    public const STATUS_PERMANENT = 301;
    public const STATUS_TEMPORARY = 302;

    public const STATUSES = [
        self::STATUS_PERMANENT,
        self::STATUS_TEMPORARY,
    ];

    public const DEFAULT_STATUS = self::STATUS_PERMANENT;

    // GraphQL enum labels (GraphQL enums can't be numeric)
    public const STATUS_LABELS = [
        self::STATUS_PERMANENT => 'permanent',
        self::STATUS_TEMPORARY => 'temporary',
    ];
}
