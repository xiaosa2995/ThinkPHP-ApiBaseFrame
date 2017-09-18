<?php
/**
 * Created by PhpStorm.
 * User: xiaosa
 * Date: 17/9/11
 * Time: 下午4:51
 */
namespace Common\Utils;

class AuthUtils
{
    /**
     * hmac 为安全的加密比对工具,为避免提交及返回的数据别篡改
     * @param array $data 参数列表，请严格按照顺序传入
     * @param string $key 加密密钥
     *
     * @return string
     */
    public static function _sign($data,$key) {
        $str = self::_sign_string($data);
        return md5(EncryptUtils::encode($str,$key),false);
    }

    /**
     * 拼接签名,如果data为数组则拼接value,依次递归,如果为字符串则直接拼接
     * @param $data mixed 要拼接的数据
     *
     * @return string
     */
    private static function _sign_string($data) {
        $str = '';
        if (is_array($data)) {
            $keys = array_keys($data);
            sort($keys);
            for ($index = 0;$index < count($keys); ++$index) {
                $part = $data[$keys[$index]];
                if (is_array($part)) {
                    $str .= self::_sign_string($part);
                }else {
                    $str .= $part;
                }
            }
            return $str;
        }
        $str .= $data;
        return $str;
    }

    /**
     * hmac 为安全的加密比对工具,为避免提交及返回的数据别篡改
     * @param array $data 参数列表，请严格按照顺序传入
     * @param string $appId 用户编号
     *
     * @return string
     */
    public static function sign($data,$appId) {
        if (empty($data) || empty($appId)) return false;
        $secret_key = C(APP_STATUS)[$appId];
        return self::_sign($data,$secret_key);
    }

    /**
     * 校验data内的签名是否正确
     * @param $data array 参数列表,必须包含sign_key对应的字段
     *
     * @return bool
     */
    public static function check_sign($data) {
        if (empty($data)) return false;
        $sign = $data['sign'];
        if (empty($sign)) return false;
        $app_id = $data['appId'];
        if (empty($app_id)) return false;
        unset($data['sign']);
        return $sign == self::sign($data,$app_id);
    }

    /**
     * sessionid加密，避免SID被劫持后模仿请求
     * @param $parameters
     * @return bool|string
     */
    public static function session_sign($parameters){
        if(empty($parameters['device_id'])){
            return false;
        }
        return md5(EncryptUtils::decode($parameters['device_id'].session_id(),C('APP_SECRET')));
    }

    /**
     * 校验cookie，防止session被劫持后模仿请求
     * @param $parameters 参数列表
     * @return bool
     */
    public static function check_cookie($parameters){
        if(empty($parameters['device_id'])){
            return false;
        }

        return cookie('S') == self::session_sign($parameters);
    }
}