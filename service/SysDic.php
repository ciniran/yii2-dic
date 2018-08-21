<?php
/**
 * Created by PhpStorm.
 * User: boxie
 * Date: 2018/4/1
 * Time: 下午10:21
 */

namespace ciniran\dic\service;

use ciniran\dic\models\SystemDic;
use Exception;
use Yii;

/**
 * 系统字字典的静态调用工具
 * Class SysDic
 * @package ciniran\dic\service
 */
class SysDic
{
    /**
     * @var array $dicKeys ;
     */
    private static $dicKeys;

    /**
     * 根据指定的数据字典key返回数据字典数组,默认为去掉已禁用的项目
     * @param $key
     * @param bool $status false 不显示已禁用项目，true显示已禁用项目
     * @return mixed
     * @throws Exception
     */
    public static function getKey($key, $status = false)
    {
        if (!self::$dicKeys) {
            self::initKeys();
        }
        $keys = self::$dicKeys;
        if (!isset($keys[$key])) {
            throw new Exception(Yii::t('dic', "Not find the key: '{key}' , in system dic", ['key' => $key]));
        }
        $result = $keys[$key];
        if (!$result) {
            return null;
        }
        if (!$status) {
            //去掉禁用的
            $result = array_filter($result, function ($item) {
                if ($item['status'] == 1) {
                    return true;
                } else {
                    return false;
                }
            });

        }
        return array_column($result, 'name', 'value');
    }

    /**
     * 根据字典显示值返回真实的key值
     * @param $key
     * @param $text
     * @return int|string
     * @throws Exception
     */
    public static function getCode($key, $text)
    {
        $keys = self::getKey($key);
        foreach ($keys as $k => $v) {
            if ($v == $text) {
                return $k;
            }
        }
        throw new Exception(Yii::t('dic', "Not find text: '{text}' , in '{key}' key", ['text' => $text, 'key' => $key]));

    }

    /**
     * 根据字典的键值返回字典的显示文本
     * @param $key
     * @param $code
     * @return string
     * @throws Exception
     */
    public static function getText($key, $code)
    {
        $keys = self::getKey($key);
        if (isset($keys[$code])) {
            return $keys[$code];
        }
        throw new Exception(Yii::t('dic', "Not find the code:'{code}' , in '{key}' key", ['code' => $code, 'key' => $key]));

    }


    private static function initKeys()
    {
        $keys = Yii::$app->cache->get('DicToolsAllKey');
        if ($keys) {
            self::$dicKeys = $keys;
        } else {
            self::getKeyFromDb();
        }
        if (!isset(Yii::$app->i18n->translations['dic'])) {
            Yii::$app->i18n->translations['dic'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath' => '@ciniran/dic/messages'
            ];
        }
    }

    public static function getKeyFromDb()
    {
        $keyArrays = SystemDic::find()->asArray()->all();
        $res = [];
        foreach ($keyArrays as $key => $value) {
            if ($value['pid']) {
                if (isset($res[$value['pid']])) {
                    $res[$value['pid']]['subKeys'][] = $value;
                } else {
                    throw new Exception(Yii::t('dic', 'To ensure that the parent entries are added to the database first, modify the data entry order!'));
                }
            } else {
                $res[$value['id']] = $value;
            }
        }
        $result = [];
        foreach ($res as $item) {
            if (isset($item['subKeys'])) {
                $sort = array_column($item['subKeys'], 'sort');
                array_multisort($sort, SORT_DESC, $item['subKeys']);
                $temp = [];
                foreach ($item['subKeys'] as $v) {
                    $temp[$v['id']] = $v;
                }
                $result[$item['value']] = $temp;
            } else {
                $result[$item['value']] = null;
            }
        }
        Yii::$app->cache->set('DicToolsAllKey', $result);
        self::$dicKeys = $result;
        return $result;

    }


}