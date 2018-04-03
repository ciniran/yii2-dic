<?php

use ciniran\dic\components\DicTools;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $model ciniran\dic\models\SystemDic */

$this->title = Yii::t('dic', 'Create System Dic');
$this->params['breadcrumbs'][] = ['label' => Yii::t('dic', 'System Dics'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-md-6 col-md-offset-1">
    <div class="box box-solid box-primary">
        <div class="box-header"><?= Yii::t('dic','Create').' {'.$pModel->name .'} '.Yii::t('dic','Entry')?></div>
        <div class="box-body">
            <div class="system-dic-create">
                <?php echo $this->render('_form', ['model' => $model])?>
            </div>
        </div>
    </div>
</div>