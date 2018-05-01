<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;


class Region extends NotORM {

    protected function getTableName($id) {
        return 'region';
    }

    protected function getTableKey($table)
    {
        return 'region_id';
    }

    public function getRegionItems($page, $perpage) {
        return $this->getORM()
            ->select('*')
            ->order('region_id DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getRegionTotal() {
        $total = $this->getORM()
            ->count('region_id');

        return intval($total);
    }

    public function getRegionInfo($where)
    {   
        return $this->getORM()
        ->where($where)
        ->fetchOne();
    }

}
