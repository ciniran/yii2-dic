# 系统字典模块
## 扩展介绍 
我们在很多系统中，往往需要维护很多字典项目，一般的字典项目包含有一个大类名称、字典项目名称、字典值、等字段，这些内容往往大同小异，
如在车辆管理中，我们可能需要维护：车辆类型、车辆品牌、车辆用途、路途类别、用车评价、车辆状态等等信息，这些是很简单的数据，
用来给业务功能使用的，是一个下拉列表形的数据，如果我们为每个这样的简单类型都创建一个表的话，那么有以下坏处:
     
1)  如果业务模块很多，就会产生很多这样的表，看起来不雅，维护也不方便，增加工作量。

2)  会产生很多页面代码（你需要维护界面内容展示和录入），也是看起来不雅，不方便维护，增加工作量。

3)  代码中调用处理也不好，记不住哪个是具体的字典信息了，太多。

以上总结一句话，就是做重复工作，就算有一键生成代码的工具，也是不好的。

如果采用一个公用的字典管理模块能够解决以上问题，那么整个世界就清净了，一句话，简单。 
本扩展能为你解决以上问题。  

## 插件特点
#### 1.适合企业级开发，规范多人合作开发，方便统一定义
#### 2.通过使用缓存，提高运行效率
#### 3.调用方便、简单，容易使用
#### 4.本扩展只依赖于 YII2，无其它第三方依赖，简洁、干净
#### 5.本扩展支持多语言配置
#### 6.本扩展已完成字典管理界面，开箱即用，无需再次开发。
#### 7.可按 YII 组件调用，也可以静态调用
#### 8.组件调用为单例方式，提高效率
#### 9.新加入了条目排序功能
————————————————————————————————————————————————

## 安装方法：
#### 1.推荐通过使用[composer](http://getcomposer.org/download/).安装此扩展，一切将自动完成
####  你可以通过运行以下代码
````
    php composer.phar require ciniran/yii2-dic "*"
````

## 手动安装和配置方法：
1.下载模块源码并解压缩到你期望的目录,如：
````
    vendor/ciniran/yii2-dic
````


2.在 `config/main.php` 添加如下配置,启用字典管理模块，请注意一定要加入别名，不然可能访问不到
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
3.在公共配置文件中启用系统组件，按如下配置,您就可以使用 Yii::$app->dic->getKey('base_status');取值了
````
   'components' => [
          'dic'=>[
              'class'=>'\ciniran\dic\components\DicTools',
                 ],
          ]
````
4.程序会自动检测并创建一个 system_dic 的数据表。


5.本程序支持多语言配置,
    多语言配置文件位@vendor/ciniran/yii2-dic/message/ 目录之下 
  ————————————————————————————————————————————————————————
  
## 使用方法：
    
#### 1. 在你的后台访问 http://yourdomain/dic,可以进行数据库的字典配置


#### 2. 视图文件中使用示例：
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
            'filter'=>Yii::$app->dic->getKey(base_status),
            'value' => function ($model) {
                return Yii::$app->dic->getText('do_status', $model->status);
            }
        ],
                 ]
  ?>
````
### 具体可调用工具类如下：

#### 1.强制删除缓存，无返回值
````     
      SysDic::cleanSystemDic();
````

#### 2.取得所有字典的数组，
````
     $array = Yii::$app->dic->getAllKeys(); //通过缓存取得
     
     $array = Yii::$app->dic->getAllKeys(false); //不通过缓存取得

````
#### 3.通过设定的名称取得字典数组
````
      $array =Yii::$app->dic->getKey('base_status'); //通过缓存取得
      
      $array =Yii::$app->dic->getKey('base_status',true); //获得已被禁用的项目
 

````

#### 4.通过设定的字典值取得显示值
````
        $string = Yii::$app->dic->getText('base_status','1');

````
#### 5.通过显示值取得字典值
````
        $value = Yii::$app->dic->getCode('base_status','是');

````
#### 6.正式版本加入了静态调用的方式，具体如下
````
       $value = SysDic::getCode('base_status', '是');

````

#### 如果本扩展有帮助到你，或者您觉得好用，请不要忘记为我点个star,非常感谢！


![](https://github.com/ciniran/yii2-dic/raw/master/images/1.png)
![](https://github.com/ciniran/yii2-dic/raw/master/images/2.png)
![](https://github.com/ciniran/yii2-dic/raw/master/images/3.png)
![](https://github.com/ciniran/yii2-dic/raw/master/images/4.png)
