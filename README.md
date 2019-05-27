# authorization.user
1C-Bitrix component for authorization

## Код вызова компонента:
$APPLICATION->IncludeComponent(
    "flxmd:authorization.user",
    "authorization",
    array(
        "COMPONENT_TEMPLATE" => "authorization",
    ),
    false
);
