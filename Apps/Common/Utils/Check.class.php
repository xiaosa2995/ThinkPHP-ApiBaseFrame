<?php

/**
 * 校验类
 * Created by PhpStorm.
 * User: xiaosa
 * Date: 17/7/26
 * Time: 上午9:38
 */
namespace Common\Utils;

class Check
{
    public static function is_number($data){
        return preg_match('/^\d*$/', $data);
    }

    public static function is_null($data){
        return empty($data) ? false : true;
    }

    public static function is_string($data){
        if(!self::id_special($data)) {
            return is_string($data);
        }
        return false;
    }

    public static function is_string_number($data){
        if(!self::id_special($data)) {
            return preg_match('/^(?![^a-zA-Z]+$)(?!\D+$).{8,12}$/', $data);
        }
        return false;
    }

    public static function is_md5($data){
        if(!self::id_special($data)) {
            return preg_match('/^(?![^a-zA-Z]+$)(?!\D+$).{32}$/', $data);
        }
        return false;
    }

    public function is_date($data){
        if(!empty($data)) {
            return preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $data);
        }
        return true;
    }

    public static function id_special($data){
        return preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/",$data);
    }

    /**
     * 判断手机号是否符合规则
     *
     * @param $mobile
     * @return bool
     */
    public static function is_valid_mobile($mobile)
    {
        if (strlen($mobile) == 11) {
            return preg_match('/^1[3-8]{1}\d{9}$/', $mobile);
        }
        return false;
    }
}