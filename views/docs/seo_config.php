<?php

use webivan\seomodule\helpers\Url;

?>

<?= $this->render('header/menu') ?>

<h1>
    Что такое сео конфиг
</h1>

<p>Это сео маска с динамическими данными, при запуске которого вы получите сео тексты для разных типов страниц</p>

<p>
    Перейдите на <a target="_blank" href="<?= Url::to('/default/create') ?>">страницу</a> и
    заполните все поля.
</p>
