<?php
/**
 * Created by PhpStorm.
 * User: xiaosa
 * Date: 17/9/11
 * Time: 下午5:32
 */

namespace Common\Utils;


class EncryptUtils
{
    /**
     * 加密
     * @param String $string 需要加密的字串
     * @param String $skey 加密EKK为短信验证码或固定字符串
     * @return String
     */
    public static function encode($string = '', $skey = '') {
        $strArr = str_split(base64_encode($string));
        $strCount = count($strArr);
        foreach (str_split(md5($skey)) as $key => $value){
            if($key < $strCount){
                $strArr[$key].=$value;
            }
        }
        $sign = array('=', '+', '/','a');
        $a_sign = array('@','^','#','*');
        return str_replace($sign, $a_sign, join('', $strArr));
    }

    /**
     * 解密
     * @param String $string 需要解密的字串
     * @param String $skey 解密KEY为短信验证码或固定字符串
     * @return String
     */
    public static function decode($string, $skey) {
        $sign = array('=', '+', '/','a');
        $a_sign = array('@','^','#','*');
        $strArr = str_split(str_replace($a_sign, $sign, $string), 2);
        $strCount = count($strArr);
        foreach (str_split(md5($skey)) as $key => $value){
            if($key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value){
                $strArr[$key] = $strArr[$key][0];
            }
        }
        return base64_decode(join('', $strArr));
    }
}