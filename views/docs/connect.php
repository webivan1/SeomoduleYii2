<?php
/**
 * Created by PhpStorm.
 * User: maltsev
 * Date: 26.10.2017
 * Time: 15:42
 */

use yii\helpers\VarDumper;

?>

<?= $this->render('header/menu') ?>

<h1>
    Что такое коннект?
</h1>

<p>
    Это многомерный массив данных взятый с базы или откуда-то ещё
</p>

<ol>
    <li>
        Задайте путь к вашим коннектам: <br />

        <?= VarDumper::dumpAsString([
            'modules' => [

                // ...

                // Seomodule
                'seomodule' => [
                    // ...

                    'pathConnects' => '@app/modules/seoConnects',
                ]
            ]
        ], 10, true) ?>
    </li>
    <li>
        В вашей папке <code>@app/modules/seoConnects</code>
        вы создаете файлы с расширением <code>.php</code>
    </li>
    <li>
        Ваш файл коннект должен возвращать следующие типы данных на выбор: <br>

        <!--ul>
            <li><code>yii\db\Command</code></li>
            <li><code>yii\db\ActiveQuery</code></li>
            <li><code>IConnects</code></li>
            <li><code>\Closure</code><br />
                <ul>
                    <li><code>Array</code></li>
                    <li><code>\Generator</code></li>
                </ul>
            </li>
        </ul-->

        <div class="panel-group" id="accordion">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                            <code>yii\db\Command</code>
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in">
                    <div class="panel-body">
<pre class="unstyled"><!--
--><div class="code-vis" code="php">
return Yii::$app->getDb()->createCommand('
    SELECT * FROM pages WHERE status = "active"
');
</div><!--
--></pre>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <code>yii\db\ActiveQuery</code>
                        </a>
                    </h4>
                </div>
                <div id="collapseTwo" class="panel-collapse collapse">
                    <div class="panel-body">
<pre class="unstyled"><!--
--><div class="code-vis" code="php">
return \app\models\Pages::find()
    ->where(['status' => 'active']);
</div><!--
--></pre>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            <code>webivan\seomodule\connects\IConnects</code>
                        </a>
                    </h4>
                </div>
                <div id="collapseThree" class="panel-collapse collapse">
                    <div class="panel-body">
<pre class="unstyled"><!--
--><div class="code-vis" code="php">
use webivan\seomodule\connects\IConnects;

class TestConnect implements IConnects
{
    /**
     * @property \yii\db\Connection
     */
    private $db;

    /**
     * init
     */
    public function __construct()
    {
        $this->db = Yii::$app->getDb();
    }

    /**
     * @inheritdoc
     */
    public function run($dev = false)
    {
        $pages = \app\models\Pages::find()
            ->where(['status' => 'active'])
            ->limit($dev ? 1 : null)
            ->createCommand()
            ->query();

        while ($row = $pages->read()) {
            // row ...

            yield $row;
        }
    }
}

return new TestConnect();
</div><!--
--></pre>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                            <code>\Closure</code>
                        </a>
                    </h4>
                </div>
                <div id="collapseFour" class="panel-collapse collapse">
                    <div class="panel-body">
                        <p>1 пример <code>Array</code></p>
<pre class="unstyled"><!--
--><div class="code-vis" code="php">
return function ($dev = false) {
    // ...

    return \app\models\Pages::find()
        ->where(['status' => 'active'])
        ->limit($dev ? 1 : null)
        ->asArray()
        ->all();
}
</div><!--
--></pre>
                        <hr />
                        <p>2 пример <code>\Generator</code></p>
                        <pre class="unstyled"><!--
--><div class="code-vis" code="php">
return function ($dev = false) {
    // ...

    $pages = \app\models\Pages::find()
        ->where(['status' => 'active'])
        ->limit($dev ? 1 : null)
        ->createCommand()
        ->query();

    while ($row = $pages->read()) {
        // row ...

        yield $row;
    }
}
</div><!--
--></pre>
                    </div>
                </div>
            </div>

        </div>
    </li>
    <li>
        После того как вы создали коннект переходите к
        <a href="<?= \webivan\seomodule\helpers\Url::to('docs/config') ?>">созданию сео конфига</a>
    </li>
</ol>
