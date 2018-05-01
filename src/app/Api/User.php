<?php
namespace App\Api;

use PhalApi\Api;
use App\Domain\User as DomainUser;
use PhalApi\Exception\BadRequestException;
/**
 * 默认接口服务类
 *
 * @author: dogstar <chanzonghuang@gmail.com> 2014-10-04
 */

class User extends Api 
{
    public function getRules() 
    {
        return array(
            'list' => array(
                'page' 	=> array('name' => 'page', 'default' => '1', 'desc' => '页码', 'require' => true),
                'perpage' 	=> array('name' => 'perpage', 'default' => \PhalApi\DI()->config->get('comm.perpage'), 'desc' => '每页显示条数', 'require' => true),
            ),
            'info' => array(
                'user_id' => array('name' => 'user_id', 'desc'=> 'user_id'),
                'email' => array('name' => 'email'),
                'user_name' => array('name' => 'user_name'),
                'mobile_phone' => array('name' => 'mobile_phone')
            ),
            'regist' => array(
                'user_name' => array('name' => 'user_name', 'desc' => '用户名', 'require' => true ),
                'email' => array('name' => 'email', 'desc' => '邮箱', 'require' => true ),
                'password' => array('name' => 'password', 'desc' => '密码', 'require' => true ),
                'ec_salt' => array('name' => 'ec_salt', 'desc' => 'MD5加密盐值', 'default' => rand(1000, 9999), 'require' => true),
            ),
            'update' => array(
                'user_id' =>array('name' => 'user_id', 'require' => true, 'type' => 'int'),
                'user_name' => array('name' => 'user_name', 'desc' => '用户名'),
                'email' => array('name' => 'email', 'desc' => '邮箱' ),
                'password' => array('name' => 'password', 'desc' => '密码' ),
            ),
            'delete' => array(
                'user_id' => array('name' => 'user_id', 'type' => 'int', 'require' => true)
            )
        );
    }

    public function list() 
    {
        $user = new DomainUser();
        return array(
            'users' => $user->getList($this->page, $this->perpage)
        );
    }
    
    public function info() 
    {
        if(empty($this->user_id) && empty($this->email) && empty($this->user_name) && empty($this->mobile_phone))
        {
            throw new BadRequestException('请求参数为空', 1);
        }

        $where = array(
            'user_id' => $this->user_id,
            'email' => $this-> email,
            'mobile_phone' => $this->mobile_phone,
            'user_name' => $this->user_name
        );
        
        $user = new DomainUser();
        return array(
            'user' => $user->getInfo($where)
        );
    }

    public function regist() 
    {
        $user = new DomainUser();
        $data = array(
            'user_name' => $this->user_name,
            'email' => $this->email,
            'password' => $this->password,
            'ec_salt' => $this->ec_salt,
        );
        if( $id = $user->insert($data))
        {
            $rs['id'] = $id;
            return $rs; 
        }else{
            throw new BadRequestException('注册失败', 1);
        }
    }

    public function update()
    {
        if(empty($this->user_id))
        {
            throw new BadRequestException('user_id为空', 1);
        }
        if(empty($this->password) && empty($this->email) && empty($this->user_name))
        {
            throw new BadRequestException('请求参数为空', 1);
        }
        $user = new DomainUser();
        $data =array();
        $data['password'] = $this->password;
        $data['email'] = $this->email;
        $data['user_name'] = $this->user_name;

        return $user->update($this->user_id, $data);
    }

    public function delete()
    {
        $user = new DomainUser();
        return $user->delete($this->user_id);
    }
}
