<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 27.10.2017
 * Time: 10:52
 */

?>

<?= $this->render('header/menu') ?>

<h1>Шаблонизаторы</h1>

<p>В качестве примера возьмем наш тестовый массив с коннекта:</p>

<div class="panel">
<pre class="unstyled"><!--
--><div class="code-vis" code="php">
return [
    [
        // Этот ID (не обязательно int)
        // будет записываться в колонку `value` таблицы {{%seotexts}}
        // Если не указать ID то в `value` запишется значение 0
        'id' => 'product-3543',

        // Дальше идут любые параметры, которые
        // можно использовать в ваших текстах
        'name' => 'Test',
        'description' => 'Test text',
        'count_likes' => 56,
        'count_dislikes' => ''
    ],
    [
        // ...
    ],

    // ...
];
</div><!--
--></pre>
</div>

<ol>
    <li>
        <code><b>default</b></code> - Легковесный шаблонизатор для очень простых вещей,
        поставить значание, массив склонений или выводить другой текст если значение пустое.
        <p>Примеры:</p>
        <ul>
            <li>
                <code>{{ name }}</code> - Получим <code>Test</code>
            </li>
            <li>
                <code>{{ count_likes dec=[лайк,лайка,лайков] }}</code> - Получим <code>56 лайков</code>
            </li>
            <li>
                <code>{{ count_dislikes dec=[дизлайк,дизлайка,дизлайокв] else=[Нет дизлайков] }}</code> - Получим <code>Нет дизлайков</code>
            </li>
            <li>
                <code>{{ count_likes else=[Нет лайков] mask=[{{ count_likes dec=[лайк,лайка,лайков]}} поставили пользователи] }}</code> -
                Получим <code>56 лайков поставили пользователи</code>
            </li>
        </ul>
    </li>
    <li>
        <code><b>twig</b></code> - Очень мощный шаблонизатор, позволяет практически все.
        <a href="https://twig.symfony.com/doc/2.x/" target="_blank">Документация по шаблонизатору Twig</a>
    </li>
</ol>


