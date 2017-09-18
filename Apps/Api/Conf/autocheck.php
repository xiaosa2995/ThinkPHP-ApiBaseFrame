<?php
/**
 * Created by PhpStorm.
 * User: xiaosa
 * Date: 17/9/11
 * Time: 下午7:44
 */
return array(
    // 接口校验参数
    'Index' => array(
        array('uid', array('is_null','is_number'), true, 'UTILS_CHECK'),
    ),

    // check类路径
    'CLASS_URL_NAME' => array(
        'UTILS_CHECK' => '\Common\Utils\Check'
    ),
);