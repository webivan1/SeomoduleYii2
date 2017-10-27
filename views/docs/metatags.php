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

<p><b>Как простой пример реализации:</b></p>

<pre class="unstyled"><!--
--><div class="code-vis" code="php">
// Ваш контроллер
class AboutController extends Controller
{
    /**
     * @param string $source
     * @param string|int $value
     * @return Seotexts
     */
    private function registerMeta($source, $value = 0)
    {
        if (is_null($metatags = Seotexts::findOne([
            'source' => $source,
            'value' => $value // Передаем value которое сгенерировал сео модуль
        ]))) {
            // Exception 404
            throw new HttpException(404);
        }

        $this->getView()->title = $metatags->title;
        $this->getView()->registerMetaTag([
            'name' => 'description',
            'content' => $metatags->description
        ]);

        return $metatags;
    }

    public function actionIndex()
    {
        $metatags = $this->registerMeta('page/about');

        return $this->render('about', [
            'metatags' => $metatags
        ]);
    }

    public function actionInfo($id)
    {
        if (is_null($info = Info::findOne(['id' => intval($id)]))) {
            throw new HttpException(404);
        }

        $metatags = $this->registerMeta('page/info', $info->id);

        return $this->render('info', [
            'metatags' => $metatags,
            'info' => $info
        ]);
    }
}
</div><!--
--></pre>

