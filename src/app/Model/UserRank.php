<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;


class UserRank extends NotORM {

    protected function getTableName($id) {
        return 'user_rank';
    }

    protected function getTableKey($table)
    {
        return 'rank_id';
    }

    public function getUserRankItems($page, $perpage) {
        return $this->getORM()
            ->select('*')
            ->order('rank_id DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getUserRankTotal() {
        $total = $this->getORM()
            ->count('rank_id');

        return intval($total);
    }

    public function getUserRankInfo($where)
    {   
        return $this->getORM()
        ->where($where)
        ->fetchOne();
    }

}
