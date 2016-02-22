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
            "title": "Admin",
            "icon": "pencil"
        }
    ]
}
```

Описание формата:
* _**name**_ - обязательный параметр, описание модуля
* _**title**_ - необязательный параметр, в случае отсутствия используется параметр name
* _**routes**_ - обязательный параметр, содержит список маршрутов, которые перехватываются модулем и выводятся в панели

Описание блока routes:
* _**route**_ - обязательный параметр, необходимо вписывать маршруты без указания ID модуля
* _**title**_ - обязательный параметр, необходим для отображения анкора ссылки в панели (если установлено _**false**_, то маршрут не выводится в панели)
* _**icon**_ - необязательный параметр, иконка в панели. Используются иконки [Glyphicons]([http://getbootstrap.com/components/#glyphicons). В параметре _**icon**_ необходимо вписать только название иконки (например, вместо "*glyphicon-pencil*"  используем "*pencil*")

### Особенности
Вы можете использовать панель для отображения маршрутов вне модулей. Для этого необходимо создать файл dashboard.json в корневой директории приложения.

[Created by strong aka Aleksand Demchenko](22info.ru)