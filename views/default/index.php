<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel ciniran\dic\models\SystemDicQuery */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('dic', 'System Dics');
$this->params['breadcrumbs'][] = $this->title;
$this->registerJs("
        $('.modal').on('hidden.bs.modal', function() { 
        $(this).removeData('bs.modal'); 
        });

    // 对象绑定点击事件
    $('#main-grid >table >tbody >tr >td:not(\".action-column\")').on('click',function (event) {
       var key = $(this).parent().attr('data-key');
           //  刷新请求,第一参数，将要刷新的dom节点,data:{}json对象传参数
           $('.modal').modal({
           'show':true,
           'remote':'sub?id='+key,
           });
        //    $.pjax.reload({container:\"#countries\",data:{'key':key}});
        });"
    , 3);
?>
<div class="system-dic-index">
    <p>
        <?php echo Html::a(Yii::t('dic', 'Create System Dic'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <!--左边键值列表-->

    <?php echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'main-grid',
        'tableOptions' => ['class' => 'table table-hover'],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'value',
            'name',
            [
                'attribute' => 'status',
                'filter'=>$searchModel->getStatusType(),
                'value' => function ($model) {
                    return \ciniran\dic\components\DicTools::getTextByKey('do_status', $model->status);
                }
            ],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}{add-sub}{delete}', 'headerOptions' => ['width' => '60'],
                'contentOptions' => ['class' => 'action-column'],
                'buttons' => [
                    'add-sub' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-plus"></span>', $url, ['title' => '增加键值']);
                    }
                ],
            ],
        ],
    ]); ?>


</div>
<!-- 弹出模态框 -->

<div class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
        </div>
    </div>
</div>