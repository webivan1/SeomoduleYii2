❗Deprecated
------

Extension seomodule Yii 2
=================================

Установка
---------

``` 
php composer require yii2-webivan1/yii2-seomodule
```

или

``` 
"require": {
    "yii2-webivan1/yii2-seomodule": "dev-master"
}
```

Запускаем миграции:

``` 
php yii migrate --migrationPath="@vendor/yii2-webivan1/yii2-seomodule/migrations"
```

Настройка
---------

```php 
<?php 

return [
    // ...
    
    'modules' => [
        // ...
        
        // Seomodule
        'seomodule' => [
            'class' => 'webivan\seomodule\SeoModule',

            // Путь до коннектов, после установки модуля 
            // можно будет ознакомиться с документацией 
            // на странице /seomodule/docs
            'pathConnects' => '@app/modules/seoConnects',

            // Общий доступ к модулю
            'accessDoctype' => function () {
                // return bool
                return !Yii::$app->user->isGuest && Yii::$app->user->can('manager');
            },
            
            'accessRulesAction' => [
                // Action index, function rule doctype
                'index' => function () {
                    // return bool
                    return true;
                },
                
                // ...
            ],
            
            // Actions
            'actionIndex' => 'webivan\seomodule\actions\ActionIndex',
            'actionCreate' => 'webivan\seomodule\actions\ActionCreate',
            'actionUpdate' => 'webivan\seomodule\actions\ActionUpdate',
            'actionDelete' => 'webivan\seomodule\actions\ActionDelete',
            
            // Models
            'modelConfig' => 'webivan\seomodule\models\ConfigMetaData',
            'modelSeotext' => 'webivan\seomodule\models\Seotexts',
            
            // Templaters
            'filterTemplater' => [
                'default' => 'default',
                'twig' => 'twig'
            ],
            'classMapTemplater' => [
                'default' => 'webivan\seomodule\templaters\def\DefaultTemplater',
                'twig' => 'webivan\seomodule\templaters\twig\TwigTemplater'
            ],
        ]
    ]
];

```

Открываем ссылку `/seomodule`
