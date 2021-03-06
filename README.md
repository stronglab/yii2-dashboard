[![Latest Stable Version](https://poser.pugx.org/stronglab/yii2-dashboard/v/stable)](https://packagist.org/packages/stronglab/yii2-dashboard) [![Total Downloads](https://poser.pugx.org/stronglab/yii2-dashboard/downloads)](https://packagist.org/packages/stronglab/yii2-dashboard) [![Latest Unstable Version](https://poser.pugx.org/stronglab/yii2-dashboard/v/unstable)](https://packagist.org/packages/stronglab/yii2-dashboard) [![License](https://poser.pugx.org/stronglab/yii2-dashboard/license)](https://packagist.org/packages/stronglab/yii2-dashboard)

# Yii2 Dashboard
Создание простой панели управления для Yii2

## Установка

```
$ composer require --prefer-dist stronglab/yii2-dashboard "*"
```
Или добавить в composer.json
```
{
    "require": {
        "stronglab/yii2-dashboard": "*"
    }
}
```
### Файл конфига проекта config/web.php
```php
'modules' => [
    'dashboard' => [
                'class' => 'stronglab\dashboard\Module',
                'roles' => ['@'], // необязатьельный параметр, по-умолчанию доступ всем гостям
                'column' => 2, // необязательный параметр, количество столбцов в панели (возможные значения: 1-3)
                'modules' => [
                    // список модулей, в которых будет производиться поиск файла dashboard.json
                    'moduleID',
                    'moduleID',
                    ...
                    'moduleID' => [
                        'jsonPath' => 'config/dashboard/myconf.json', // отдельный путь к файлу настроек панели, прописывается от директории приложения
                    ],
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
* _**icon**_ - необязательный параметр, иконка в панели. Используются иконки [Glyphicons](http://getbootstrap.com/components/#glyphicons). В параметре _**icon**_ необходимо вписать только название иконки (например, вместо "*glyphicon-pencil*"  используем "*pencil*")

### Пример файла dashboard.json для стандартного CRUD
```json
{
    "name": "Example",
    "title": "Example Header",
    "routes": [
        {
            "route": "default/index",
            "title": "Список"
        },
        {
            "route": "default/create",
            "title": "Добавить"
        },
        {
            "route": "default/view",
            "title": false
        },
        {
            "route": "default/update",
            "title": false
        },
        {
            "route": "default/delete",
            "title": false
        }
    ]
}
```

### Особенности
Вы можете использовать панель для отображения маршрутов вне модулей. Для этого необходимо создать файл dashboard.json в корневой директории приложения.

[Created by strong aka Aleksand Demchenko](http://22info.ru)
