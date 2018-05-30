<?php
/**
 * 数据字典获取组件
 * Created by PhpStorm.
 * User: 谢波
 * Date: 2017/9/6
 * Time: 14:02
 */

namespace ciniran\dic\components;

use ciniran\dic\models\SystemDic;
use Exception;
use Yii;
use yii\base\BaseObject;


class DicTools extends BaseObject
{
    /**
     * @var array $dicKeys ;
     */
    private static $dicKeys;


    /**
     * @return mixed
     */
    protected function getDicKeys()
    {
        return self::$dicKeys;
    }

    public function init()
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

    /**
     * 取得所有的系统字典数组
     * @param bool $status false
     * @return array
     */
    public function getAllKeys($status = true)
    {
        if ($status) {
            return self::$dicKeys;
        }
        return self::getKeyFromDb();
    }





    /**
     * 清除字典缓存
     */
    public static function cleanSystemDic()
    {
        Yii::$app->cache->delete('DicToolsAllKey');
    }



    private static function getKeyFromDb()
    {
        $keyArrays = SystemDic::find()->asArray()->all();
        $res = [];
        foreach ($keyArrays as $key => $value) {
            if ($value['pid']) {
                if(isset($res[$value['pid']]))
                {
                    $res[$value['pid']]['subKeys'][] = $value;
                }else{
                    throw new Exception(Yii::t('dic','To ensure that the parent entries are added to the database first, modify the data entry order!'));
                }
            } else {
                $res[$value['id']] = $value;
            }
        }
        $result = [];
        foreach ($res as $item) {
            $sort = array_column($item['subKeys'], 'sort');
            array_multisort($sort, SORT_DESC, $item['subKeys']);
            $temp = [];
            foreach ($item['subKeys'] as $v) {
                $temp[$v['id']] = $v;
            }
            $result[$item['value']] = $temp;
        }
        Yii::$app->cache->set('DicToolsAllKey', $result);
        self::$dicKeys = $result;
        return $result;

    }

    /**
     * 根据指定的数据字典key返回数据字典数组,默认为去掉已禁用的项目
     * @param $key
     * @param bool $status false 不显示已禁用项目，true显示已禁用项目
     * @return array|null
     * @throws Exception
     */
    public function getKey($key, $status = false)
    {
        $keys = self::$dicKeys;
        if(!isset($keys[$key])){
            throw new Exception(Yii::t('dic', "Not find the key: '{key}' , in system dic", ['key' => $key]));
        }
        $result = $keys[$key];
        if (!$result) {
            return null;
        }
        if(!$status){
            //去掉禁用的
            $result =  array_filter($result,function($item){
                if ($item['status'] == 1) {
                    return true;
                }else{
                    return false;
                }
            });

        }
        return array_column($result, 'name', 'value');
    }

    /**
     * 通过字典key的值取得编码,默认显示已禁用的
     * @param $key
     * @param $text
     * @param bool $status
     * @return mixed
     * @throws Exception
     */
    public function getCode($key, $text, $status = true)
    {
        $array = $this->getKey($key, $status);
        foreach ($array as $k => $v) {
            if ($v == $text) {
                return $k;
            }
        }
        throw new Exception(Yii::t('dic', "Not find text: '{text}' , in '{key}' key", ['text' => $text, 'key' => $key]));
    }

    public function getText($key, $code, $status = true)
    {
        $array = $this->getKey($key, $status);
        if (isset($array[$code])) {
            return $array[$code];
        }
        throw new Exception(Yii::t('dic', "Not find the code:'{code}' , in '{key}' key", ['code' => $code, 'key' => $key]));
    }
}