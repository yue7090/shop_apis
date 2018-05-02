<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;


class Warehouse extends NotORM {

    protected function getTableName($id) {
        return 'region_warehouse';
    }

    protected function getTableKey($table)
    {
        return 'region_id';
    }


    public function getWarehouseItems($page, $perpage) {
        return $this->getORM()
            ->select('*')
            ->order('region_id DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getWarehouseTotal() {
        $total = $this->getORM()
            ->count('region_id');

        return intval($total);
    }

    public function getWarehouseInfo($where)
    {   
        return $this->getORM()
        ->where($where)
        ->fetchOne();
    }

}
