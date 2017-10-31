# 系统数据字典生成模块

## 配置方法：
####1.下载模块源码解压缩到 `backend/modules/`

####2.在 `config/main.php` 添加如下配置
````
    'modules' => [
        'dic' => [
            'class' => 'ciniran\dic\Module',
        ],
    ],
    'aliases' => [
        '@ciniran/dic' => '@vendor/ciniran/yii2-dic'
    ],
````
####3.程序会自动检测并创建一个 system_dic 的数据表。


####4.本程序支持多语言配置,
    多语言配置文件位@vendor/ciniran/yii2-dic/message/ 目录之下 
    
## 使用方法：
    
#### 1. 在你的后台访问 http://yourdomain/dic,可以进行数据库的字典配置

#### 2. 数据字典获取代码示例：
````
     默认从缓存文件中获取未被禁用的项，
          
     $res = DicTools::getKeyByName('type')
 
 
 
     不从缓存文件中获取，
          
     $dic = new \dic\components\DicTools(['cache'=>false]);
     $res = $dic->getKeyByName('type')
 
 
 
     获取结果中包含已禁用的项，
     
     $dic = new \dic\components\DicTools();
     $res = $dic->getKeyByName('type',true)
     
````
#### 3. 视图文件中使用示例：
````

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
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
                 ]
  ?>
````

#### 作者：谢波  日期 2017/09/07