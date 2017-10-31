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
use Yii;
use yii\base\Component;


class DicTools extends Component
{
    private static $dicKeys;

    /**
     * @return mixed
     */
    private static function getDicKeys()
    {
        return self::$dicKeys;
    }


    /**
     * 取得所有的系统字典数组,为ture时不走缓存
     * @param bool $status
     * @return mixed
     */
    public static function getAllKeys($status = false)
    {
        self::initKey($status);
        return self::$dicKeys;
    }


    /**
     * 根据指定的数据字典key返回数据字典数组,默认为去掉已禁用的项目
     * @param $key
     * @param bool $status false 不显示已禁用项目，true显示已禁用项目
     * @return mixed
     */
    public static function getKeyByName($key, $status = false)
    {
        self::initKey();
        $keys = self::$dicKeys;
        //去掉已禁用项目
        if (!$status) {
            foreach ($keys as $k => $v) {
                if ($v['status'] != 1) {
                    unset($keys[$k]);
                } else {
                    if (isset($v['subKeys'])) {
                        foreach ($v['subKeys'] as $k2 => $v2) {
                            if ($v2['status'] != 1) {
                                unset($keys[$k]['subKeys'][$k2]);
                            }
                        }
                    }
                }
            }
        }
        foreach ($keys as $v) {
            //找出每一个子key
            if ($v['value'] == $key && isset($v['subKeys']) && $v['subKeys']) {
                return array_column($v['subKeys'], 'name', 'value');
            }
        }
    }

    /**
     * 清除字典缓存
     */
    public static function cleanSystemDic()
    {
        Yii::$app->cache->delete('DicToolsAllKey');
    }

    /**
     * 根据字典显示值返回真实的key值
     * @param $keyName
     * @param $text
     * @return int|string
     */
    public static function getKeyByText($keyName, $text)
    {
        self::initKey();
        $keys = self::getKeyByName($keyName);
        foreach ($keys as $k => $v) {
            if ($v == $text) {
                return $k;
            }
        }
    }

    /**
     * 根据字典的键值返回字典的显示文本
     * @param $keyName
     * @param $Key
     * @return string
     */
    public static function getTextByKey($keyName, $Key)
    {
        self::initKey();
        $keys = self::getKeyByName($keyName);
        if (isset($keys[$Key])) {
            return $keys[$Key];
        } else {
            return '';
        }
    }


    protected static function initKey($status = false)
    {
        if (!$status) {
            $keys = Yii::$app->cache->get('DicToolsAllKey');
            if (!$keys) {
                $keys = self::getKeyFromDb();
            }
        } else {
            $keys = self::getKeyFromDb();
        }
        self::$dicKeys = $keys;
    }

    private static function getKeyFromDb()
    {
        $keyArrays = SystemDic::find()->asArray()->all();
        $res = [];
        foreach ($keyArrays as $key => $value) {
            if ($value['pid']) {
                foreach ($res as $k => $v) {
                    if ($k == $value['pid']) {
                        $res[$k]['subKeys'][$value['id']] = $value;
                        continue;
                    }
                }
            } else {
                $res[$value['id']] = $value;
            }
        }
        Yii::$app->cache->set('DicToolsAllKey', $res);
        return $res;

    }

}