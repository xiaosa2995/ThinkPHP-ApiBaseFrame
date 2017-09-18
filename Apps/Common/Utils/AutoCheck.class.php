<?php
/**
 * Created by PhpStorm.
 * User: xiaosa
 * Date: 17/9/11
 * Time: 下午7:10
 */

namespace Common\Utils;


class AutoCheck
{
    const ERROR = '缺少关键性参数：';
    /**
     * 递归校验参数方法
     *
     * @param $parameter
     * @param $info 需校验参数数组
     * @param $parameter 参数数组
     * @param $info
     * @param $class_name
     * @return bool|string
     *
     * $v[0] : 参数名
     * $v[1] : 验证方法                数组|string
     * $v[2] : 是否是必传参数           true必验证，false有就验证没有则跳过
     * $v[3] : 验证类路径              验证类绝对路径
     * $v[4] : 错误提示                如果此参数验证失败则报对应的错误信息
     * $v[5] : 校验方法扩展参数         验证方法下的扩展参数
     * $v[6] : array转json转base65    参数是数组的情况下
     */
    public static function check($parameter, $info, $class_name){
        if(empty($class_name)) return self::ERROR;
        foreach ($info as $k => $v) {
            $parameter_name = $v[0];//校验参数
            $check_function = $v[1];//校验方法
            $is_required = $v[2];//是否必传
            $check_url = $v[3];//验证类路径
            $error_msg = empty($v[4]) ? 'ERROR-2' : $v[4];//错误提示
            $check_parameter = $v[5];//校验方法多余参数
            $array_parameter = $v[6];//参数数组验证

            if ($is_required || (!$is_required && array_key_exists($parameter_name, $parameter))) {// 判断参数是否可以验证
                if (!array_key_exists($parameter_name, $parameter)) {// 缺少必传参数
                    return self::ERROR . $parameter_name;
                }
                if (!empty($array_parameter) && !is_array($array_parameter)) {// 验证array转json参数
                    $parameters = json_decode(base64_decode($parameter[$parameter_name]), true);
                    if ($result = self::check($parameters, $array_parameter) !== true) {
                        return $result;
                    }
                } else {
                    $this_parameter = $parameter[$parameter_name];
                    if (is_array($check_function)) { // 参数多次验证
                        foreach ($check_function as $key => $val) {
                            if(is_array($check_url)){
                                $check_result = $class_name[$check_url[$key]]::$val($this_parameter, $check_parameter);
                            }else {
                                $check_result = $class_name[$check_url]::$val($this_parameter, $check_parameter);
                            }
                        }
                    } else { // 参数单次验证
                        $check_result = $class_name[$check_url]::$check_function($this_parameter,$check_parameter);
                    }
                    if(!$check_result){
                        return C('IS_OPEN_ERROR_MSG') ? $parameter_name . '参数未通过' . $val . '校验' : C($error_msg);
                    }
                }
            }
        }
        return true;
    }
}