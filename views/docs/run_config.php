<?php
/**
 * Created by PhpStorm.
 * User: Ivan
 * Date: 26.10.2017
 * Time: 21:52
 */

?>

<?= $this->render('header/menu') ?>

<h1>
    Как запустить сео конфиг?
</h1>

<ol>
    <li>
        Есть ручной запуск, после создания конфига на странице <code>/seomodule/default/index</code>
        Кнопка Run #...
    </li>
    <li>
        Поставить запуск на крон<br />
<pre class="unstyled"><!--
--><div class="code-vis" code="php">

namespace app\commands;

use Yii;
use yii\base\Exception;
use yii\console\Controller;
use webivan\seomodule\components\GeneratorMetatags;
use webivan\seomodule\models\ConfigMetaData;

/**
 * Run command
 *
 * All - php yii seogenerate
 * One - php yii seogenerate 22
 *
 * 22 - Id model ConfigMetaData
 */
class SeogenerateController extends Controller
{
    public function actionIndex($id = null)
    {
        $configsSeo = ConfigMetaData::findAll(array_merge(
            ['state' => 2],
            is_null($id) ? [] : ['id' => intval($id)]
        ));

        if (empty($configsSeo)) {
            return false;
        }

        foreach ($configsSeo as $config) {
            $model = new GeneratorMetatags();

            try {
                $model->run($config);
                echo "OK, " . $config->source . PHP_EOL;
            } catch (Exception $e) {
                echo $e->getMessage() . PHP_EOL;
            }
        }
    }
}

</div><!--
--></pre>
    </li>
</ol>
