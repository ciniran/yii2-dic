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

    <div class="system-dic-form">

        <?php $form = ActiveForm::begin(); ?>

        <?php echo $form->errorSummary($model); ?>



        <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

        <?php echo $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
        <?php echo $form->field($model, 'status')->dropDownList(DicTools::getKeyByName('do_status')) ?>


        <div class="form-group">
            <?php echo Html::submitButton($model->isNewRecord ? Yii::t('dic', 'Create') : Yii::t('dic', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <a class="btn btn-default" href="/dic/default/index"><?=Yii::t('dic','Back')?></a>

        </div>

        <?php ActiveForm::end(); ?>

    </div>


</div>
