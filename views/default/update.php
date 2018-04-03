<?php

/* @var $this yii\web\View */

use ciniran\dic\components\DicTools;
use yii\bootstrap\ActiveForm;
use yii\bootstrap\Html;

/* @var $model ciniran\dic\models\SystemDic */

$this->title = Yii::t('dic', 'Update {modelClass}: ', [
    'modelClass' => Yii::t('dic', 'System Dics'),
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('dic', 'System Dics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('dic', 'Update');
?>
<div class="system-dic-update">

    <?php echo $this->render('_form', ['model' => $model])?>


</div>
