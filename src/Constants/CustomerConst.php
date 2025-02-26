<?php

declare(strict_types=1);

namespace Brizy\Bundle\ApiEntitiesBundle\Constants;

final class CustomerConst
{
    public const ACTIVATION_TOKEN = 'token';
    public const INPUT_ARG_RESET_PASSWORD_TOKEN = 'resetPasswordToken';

    public const RESET_PASSWORD_TOKEN_EXPIRED_TIME = '+24 HOURS';

    public const STATE_ENABLED = 'enabled';
    public const STATE_DISABLED = 'disabled';

    public const METAFIELD_KEY_ALLOW_REGISTRATION = 'allow-registration';
    public const METAFIELD_VALUE_ALLOW_REGISTRATION = 1;
    public const METAFIELD_KEY_DEFAULT_CUSTOMER_EMAIL_SENDER = 'default-customer-email-sender';
    public const METAFIELD_VALUE_DEFAULT_CUSTOMER_EMAIL_SENDER = 'no-reply@ourdomain.com';

    public const STATE_STATUSES = [
        self::STATE_ENABLED,
        self::STATE_DISABLED,
    ];

    public const CUSTOMER_EVENT_NAME_CREATE_CUSTOMER_WITH_EMAIL_SEND = 'create.customer.with.email.send';
    public const CUSTOMER_EVENT_NAME_RESET_PASSWORD = 'customer.reset.password';
    public const NOTIFY_CUSTOMER_RESET_PASSWORD = 'customer.reset.password';

    //notification name pattern - event.entity.{options}
    public const CREATE_CUSTOMER_NOTIFICATION = 'create.customer';
    public const CREATE_CUSTOMER_WITH_EMAIL_NOTIFICATION = 'create.customer.with.email';
    public const RESET_CUSTOMER_PASSWORD_NOTIFICATION = 'reset.customer.password';
    public const CHANGE_CUSTOMER_PASSWORD_NOTIFICATION = 'change.customer.password';

    public const NOTIFICATIONS = [
        self::CUSTOMER_EVENT_NAME_CREATE_CUSTOMER_WITH_EMAIL_SEND,
    ];
}
