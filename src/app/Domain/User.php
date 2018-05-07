<?php
namespace App\Domain;

use App\Model\User as ModelUser;

class User {

    public function getList($page, $perpage) {
        $rs = array('items' => array(), 'total' => 0);

        $model = new ModelUser();
        $items = $model->getUserItems($page, $perpage);
        $total = $model->getUserTotal();

        $rs['items'] = $items;
        $rs['total'] = $total;

        return $rs;
    }

    public function getInfo($where)
    {
        $rs = array('info' => array());
        foreach( $where as $k=> $v )
        {
            if(empty($v))
            {
                unset($where[$k]);
            }
        }
        $model = new ModelUser();
        $info = $model->getUserInfo($where);
        $rs['info'] = $info;
        return $rs;
    }

    public function insert($data)
    {
        // todo 验证用户名 邮箱的唯一性
        $model = new ModelUser();
        $data['password'] = md5($data['password'].$data['ec_salt'] );
        $data['reg_time'] = strtotime(date("Y-m-d H:i:s"));
        $data['aite_id'] = '';
        $data['nick_name'] = '';
        $data['alias'] = '';
        $data['msn'] = '';
        $data['qq'] = '';
        $data['office_phone'] = '';
        $data['home_phone'] = '';
        $data['mobile_phone'] = '';
        $data['credit_line'] = 0;
        $data['user_picture'] = '';
        $data['old_user_picture'] = '';
        return $model->insert($data);
    }

    public function update($user_id, $data)
    {
        $model = new ModelUser();
        foreach( $data as $k=> $v )
        {
            if(empty($v))
            {
                unset($data[$k]);
            }
        }

        if(isset($data['password']))
        {
            $data['ec_salt'] = rand( 1000, 9999);
            $data['password'] = md5($data['password'].$data['ec_salt']);
        }

        $data['last_time'] = date('Y-m-d H:i:s');
        return $model->update($user_id,$data);
    }

    public function delete($user_id)
    {
        $model = new ModelUser();
        return $model->delete($user_id);
    }

    public function login($user_name, $password)
    {
        /**
        * 校验用户名和密码
        */

        $model = new ModelUser();
        $user = $model->getUserInfo(array('user_name'=>trim($user_name)));
        if($user)
        {
            $ec_salt = $user['ec_salt'];
            if(md5($password.$ec_salt) == $user['password'])
            {
                //存入session
                return $user;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
