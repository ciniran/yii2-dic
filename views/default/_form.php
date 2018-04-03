<?php
/**
 * Created by PhpStorm.
 * User: boxie
 * Date: 2018/4/1
 * Time: 下午3:05
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
<div class="system-dic-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php echo $form->errorSummary($model); ?>



    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'value')->textInput(['maxlength' => true]) ?>
    <?php echo $form->field($model, 'status')->dropDownList(Yii::$app->dic->getKey('do_status')) ?>
    <?php echo $form->field($model, 'sort')->textInput(['type' => 'number']) ?>


    <div class="form-group">
        <?php echo Html::submitButton($model->isNewRecord ? Yii::t('dic', 'Create') : Yii::t('dic', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <a class="btn btn-default" href="/dic/default/index"><?=Yii::t('dic','Back')?></a>

    </div>

    <?php ActiveForm::end(); ?>

</div>

