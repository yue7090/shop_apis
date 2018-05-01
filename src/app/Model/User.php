<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;


class User extends NotORM {

    protected function getTableName($id) {
        return 'users';
    }

    protected function getTableKey($table)
    {
        return 'user_id';
    }

    public function getUserItems($page, $perpage) {
        return $this->getORM()
            ->select('*')
            ->order('user_id DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getUserTotal() {
        $total = $this->getORM()
            ->count('user_id');

        return intval($total);
    }

    public function getUserInfo($where)
    {   
        return $this->getORM()
        ->where($where)
        ->fetchOne();
    }

    public function regist($data)
    {
        $data['reg_time'] = strtotime(now());

        $model = new ModelUser();
        return $model->insert($data);
    }
}
