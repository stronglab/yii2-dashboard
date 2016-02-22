# Yii2 Dashboard
Создание простой панели управления для Yii2

## Установка

Прописать в composer.json Вашего проекта:
### Секциия require-dev
```
"stronglab/yii2-dashboard": "*"
```
### Секция repositories
```
{
    "type": "git",
    "url": "https://github.com/stronglab/yii2-dashboard"
}
```
### Файл конфига проекта config/web.php
```php
'components' => [
    'urlManager' => [
        'enablePrettyUrl' => true,
        'showScriptName' => false,
        'rules' => [
            [
                'class' => 'stronglab\yii2\dashboard\components\UrlRule',
            ],
        ],
    ],
],
'modules' => [
'dashboard' => [
        'class' => 'stronglab\yii2\dashboard\Module',
        'modules' => [
            // список модулей, в которых будет производиться поиск файла dashboard.json
        ],
    ],
],
```
Далее обновляем composer и можно приступать к настройке модулей

## Настройка
В корневой директории каждого модуля необходимо создать файл dashboard.json, который должен иметь следующий формат:
```json
{
    "name": "Dasboard simple config",
    "title": "My module",
    "routes": [
        {
            "route": "default/index",
            "title": "List"
        },
        {
            "route": "default/captcha",
            "title": false
        },
        {
            "route": "default/admin",
            "title": "Admin"
        }
    ]
}
```

Описание формата:
* **name** - обязательный параметр, описание модуля
* **title** - необязательный параметр, в случае отсутствия используется параметр name
* **routes** - обязательный параметр, содержит список маршрутов, которые перехватываются модулем и выводятся в панели

Описание блока routes:
* **route** - обязательный параметр, необходимо вписывать маршруты без указания ID модуля
* **title** - обязательный параметр, необходим для отображения анкора ссылки в панели (если установлено **false**, то маршрут не выводится в панели)

### Особенности
Вы можете использовать панель для отображения маршрутов вне модулей. Для этого необходимо создать файл dashboard.json в корневой директории приложения.

[Created by strong aka Aleksand Demchenko](22info.ru)