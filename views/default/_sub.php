<?php
/**
 * Created by XieBo 4816589@qq.com
 * Date: 2017/10/17
 */

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
    <div class="activity-goods-create" style="padding: 20px">
        <div class="text-center" >
        <h3 ><?=$name?> <small><?=Yii::t('dic','Key details')?></small></h3><br/>
        </div>
     <?php echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'layout'=>'{items}{pager}',
                        'columns' => [
                            'name',
                            'value',
                            ['class' => 'yii\grid\ActionColumn','template' => '{update}{delete}'],
                        ],
                    ]); ?>

    </div>
<div class="modal-footer">
    <?php echo Html::a(Yii::t('dic','Create'),['add-sub','id'=>Yii::$app->request->getQueryParam('id')],['class'=>'btn btn-success']);?>
    <button type="button" class="btn btn-default" data-dismiss="modal"><?=Yii::t('dic','Close')?></button>
</div>
