<?php
namespace Dashboard\Model;
use Think\Model;
class UserModel extends Model{

    protected $tableName = 'user';
    // 对象的数据表
    protected $trueTableName = 'art_user';
    
    // 字段限定信息
    protected $_validate = array(
        array(
            'u_name',
            'require',
            '用户名必须！'
        ), // 默认情况下用正则进行验证
        array(
            'u_pwd',
            'require',
            '密码必须！'
        ),
        array(
            'u_name',
            '',
            '帐号名称已经存在！',
            0,
            'unique',
            1
        ),
    ); // 在新增的时候验证name字段是否唯一
      // array('value',array(1,2,3),'值的范围不正确！',2,'in'), // 当值不为空的时候判断是否在一个范围内
      // array('repassword','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
      // array('password','checkPwd','密码格式不正确',0,'function'), // 自定义函数验证密码格式
    /**
     * 自动完成
     */
    protected $_auto = array (
        array('u_pwd', 'md5', 3, 'function') , // 对password字段在新增和编辑的时候使md5函数处理
    );
    
    public function getUserIdByUserName($nickname)
    {
        $cond['u_name']=$nickname;
        $r = $this->where($cond)->getField('u_id');
        return $r;
    }

    public function isValidUser($nickname, $pwd)
    {
        $count = $this->where(array(
            'u_name' => $nickname,
            'u_pwd' => md5($pwd),
        ))->count();
        return $count;
    }
}