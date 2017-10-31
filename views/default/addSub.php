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

                <div class="system-dic-form ">

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
        </div>
    </div>
</div>