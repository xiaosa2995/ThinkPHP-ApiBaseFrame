<?php
/**
 * Created by PhpStorm.
 * User: xiaosa
 * Date: 17/9/11
 * Time: 下午4:51
 */

namespace Common\Controller;


use Common\Utils\AuthUtils;
use Common\Utils\AutoCheck;
use Think\Controller;

class ApiController extends Controller
{
    public function _initialize()
    {
        $this->secure_check();
    }

    private function secure_check(){
        //接收参数
        $parameters = I('param.');

        //签名校验
        if(!in_array(strtolower(CONTROLLER_NAME), C('UNCKECK_SIGN')) && !AuthUtils::check_sign($parameters)){
            echo 'error1';
        }

        //时间校验
        if(!in_array(strtolower(CONTROLLER_NAME), C('UNCKECK_TIME')) && time() - intval($parameters['time']) > C('VALIDATE_API_EXPIRED')){
            echo 'error2';
        }

        //cookie校验
        if(!in_array(strtolower(CONTROLLER_NAME), C('UNCKECK_COOKIE')) && AuthUtils::check_cookie($parameters)){
            echo 'error3';
        }

        //参数校验
        $check_result = AutoCheck::check($parameters,C(CONTROLLER_NAME),C('CLASS_URL_NAME'));
        if($check_result !== true){
            echo 'error4';
        }
    }
}