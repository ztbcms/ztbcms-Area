<?php

// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Area\Model;


/**
 * 县、区级别,如:佛山市南海区
 *
 * @package Area\Model
 */
class DistrictModel extends BaseModel {


    protected $tableName = 'area_district';

    public function getDistrictsByCityId($id) {
        return $this->get($id, self::LEVEL_DISTRICT);
    }

    public function getDistrictById($id){
        $result = $this->where(['id' => $id])->find();
        return $result;
    }

}