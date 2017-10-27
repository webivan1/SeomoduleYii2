<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 26.10.2017
 * Time: 22:11
 */

?>

<?= $this->render('header/menu') ?>

<h1>
    Как достать мета теги и использовать в проекте?
</h1>

<p>
    Тут есть масса вариантов, самое главное
    передать <code>source</code> и <code>value</code>
    в модель <code>webivan\seomodule\models\Seotexts</code>
</p>

<ol>
    <li>
<pre class="unstyled"><!--
--><div class="code-vis" code="php">
// Ваш контроллер
class AboutController extends Controller
{
    public function actionIndex()
    {
        $seo = Seotexts::findOne([
            'source' => 'page/about',
            'value' => 0 // Передаем value которое сгенерировал сео модуль
        ]);
    }
}
</div><!--
--></pre>
    </li>
</ol>

