Static Page Editor Extension
============================
Extension for editing static pages like "About" etc.

Поддержка подкатегорий сделана исключительно для создания красивых URL аля http://site.ru/category/subcategory/page

Installation
------------

Добавить в composer.json строки. Иначе будут проблемы с установкой виджета CKEditor правильной версии

```json
"minimum-stability": "dev",
"prefer-stable": true,
```

## Backend

Добавить в конфигурацию бекенда:
```php
'modules' => [
    'pages' => [
        'class' => 'heggi\yii2pages\Module',
        'controllerNamespace' => 'heggi\yii2pages\controllers\backend',
        //Разрешить создавать новые страницы
        'allowCreate' => true,
        //Разрешить удаление страниц
        'allowDelete' => false,
        //Разрешить изменять slug у уже созданных страниц
        'allowUpdateSlug' => false,
        //Разрешить изменять категорию у уже созданных страниц
        'allowChangeCategory' => false,
        //Включить интеграцию с виджетом ckeditor. True или массив с опциями
        'ckeditor' => [
            'preset' => 'full',
        ],
        //Включить интеграцию ckeditor с elfinder. True или массив с опциями настройки elfinder
        'elfinder' => true,
    ],
],
```

Если нужен elfinder, то в конфигурацию нужно добавить
```php
'controllerMap' => [
    'elfinder' => [
        'class' => 'mihaildev\elfinder\PathController',
        'access' => ['@'],
        'root' => [
            'baseUrl' => '',
            'basePath' => '@webroot/..',
            'path' => 'uploads',
            'name' => 'Загрузки'
        ],
    ],
],
```

## Frontend

В конфигурации фронтэнда:
```php
'modules' => [
    'pages' => [
        'class' => 'heggi\yii2pages\Module',
        'controllerNamespace' => 'heggi\yii2pages\controllers\frontend',
    ],
],
```

Пример правил для PrettyUrl:
```php
'rules' => [
    //Только страницы about, contact корневой категории
    '<page:(about|contact)>' => 'pages/render/index',
    //Страница about категории tuman
    '<cat1:(tuman)>/<page:(about)>' => 'pages/render/index',
    //Страница index любой подкатегории категории tuman
    '<cat1:(tuman)>/<cat2>' => 'pages/render/index',
    //Любая страница любой подкатегории категории tuman
    '<cat1:(tuman)>/<cat2>/<page>' => 'pages/render/index',
    //Вложенность подкатегорий до 3
    '<cat1:(tuman)>/<cat2>/<cat3>/<page>' => 'pages/render/index',
],
```

## Common

В общей конфигурации настраиваются категории (Этот участок конфигурации должен быть доступен как в бекенде, так и во фронтэнде)
```php
'modules' => [
    'pages' => [
        'categories' => [
            //Корневая категория должна всегда называться index
            'index' => [
                //Человеческое название категории. Обязательно
                'label' => 'Корневая категория',
                //View, которая будет использоваться для рендеринга. В данном случае frontend/views/page/index.php
                'view' => '//page/index',
                //Можно переопределить layout для категории. В данном случае будет frontend/views/layouts/someone.php
                'layout' => 'someone',
            ],
            //Категория
            'category1' => [
                'label' => 'Категория',
                //View не задан, будет использоваться стандартный шаблон модуля @vendor/heggi/yii2-pages/views/render/index.php
                //Layout не задан, будет использоваться стандартный layout фронтэнда main.php
            ],
            //Подкатегория
            'category1-subcat1' => [
                'label' => 'Подкатегория 1',
            ],
        ],
    ]
]
```
