<?php
/**
 * 公共父类Model
 * Created by PhpStorm.
 * User: xiaosa
 * Date: 17/9/11
 * Time: 下午5:02
 */

namespace Common\Model;


use Think\Model;

class BaseModel extends Model
{
    function addModel($data)
    {
        return $this->db(0)->add($data);
    }

    function addAllModel($data)
    {
        //批量添加会覆盖原有的数据
        return $this->db(0)->addAll($data, array(), true);
    }

    function delModel($where)
    {
        return $this->db(0)->where($where)->delete();
    }

    function updateModel($data, $where)
    {
        return $this->db(0)->where($where)->save($data);
    }

    //根据条件获取一个字段的值
    function getFieldModel($field, $where, $order = '')
    {
        return $this->db(0)->where($where)->order($order)->getField($field);
    }

    //根据条件获取几个字段的值
    function getFindModel($where, $fields = '*', $order = '')
    {
        return $this->db(0)->where($where)->field($fields)->order($order)->find();
    }

    //获取一行值
    function getRowModel($where, $order)
    {
        return $this->db(0)->where($where)->order($order)->find();
    }

    //获取所有行，排序，限制数量
    function getAllModel($where, $fields = '*', $order = '', $limit = '')
    {
        return $this->db(0)->where($where)->field($fields)->order($order)->limit($limit)->select();
    }

    //获取所有行，排序，限制数量
    function getGroupAllModel($where, $fields = '*', $group = '', $limit = '')
    {
        return $this->db(0)->where($where)->field($fields)->group($group)->limit($limit)->select();
    }

    //获取条数
    function countModel($where)
    {
        return $this->db(0)->where($where)->count();
    }

    //执行查询sql
    function querySql($sql)
    {
        return $this->db(0)->query($sql);
    }

    //执行更新sql
    function executeSql($sql)
    {
        return $this->db(0)->execute($sql);
    }
}