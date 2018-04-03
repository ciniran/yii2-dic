<?php

use ciniran\dic\components\DicTools;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model ciniran\dic\models\SystemDic */

$this->title = Yii::t('dic', 'Create {modelClass}', [
    'modelClass' => Yii::t('dic','System Dic'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('dic', 'System Dics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="system-dic-create">

    <?php echo $this->render('_form', ['model' => $model])?>

</div>
