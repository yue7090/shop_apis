<?php
namespace App\Model;

use PhalApi\Model\NotORMModel as NotORM;


class Brand extends NotORM {

    protected function getTableName($id) {
        return 'brand';
    }

    protected function getTableKey($table)
    {
        return 'brand_id';
    }

    public function getBrandItems($page, $perpage) {
        return $this->getORM()
            ->select('*')
            ->order('brand_id DESC')
            ->limit(($page - 1) * $perpage, $perpage)
            ->fetchAll();
    }

    public function getBrandTotal() {
        $total = $this->getORM()
            ->count('brand_id');

        return intval($total);
    }

    public function getBrandInfo($where)
    {   
        return $this->getORM()
        ->where($where)
        ->fetchOne();
    }

}
