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
        // 设置缓存
        $data = S('getDistrictsBy'.$id);
        if($data) return $data;

        $data = $this->get($id, self::LEVEL_DISTRICT);
        S('getDistrictsBy'.$id,$data,3600);
        return $data;
    }

    public function getDistrictById($id){
        $result = $this->where(['id' => $id])->find();
        return $result;
    }

}