<?php

namespace ciniran\dic;

use Yii;

/**
 * dic module definition class
 */
class Module extends \yii\base\Module
{

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (!isset(Yii::$app->i18n->translations['dic'])) {
            Yii::$app->i18n->translations['dic'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@ciniran/dic/messages'
            ];
        }
        // custom initialization code goes here
    }
}
