<?php

// +----------------------------------------------------------------------
// | Author: Jayin Ton <tonjayin@gmail.com>
// +----------------------------------------------------------------------

namespace Area\Model;


/**
 * 镇,街道级别,如如,佛山市南海区狮山镇
 *
 * @package Area\Model
 */
class StreetModel extends BaseModel{

    protected $tableName = 'area_street';

    public function getStreetsByDistrictId($id) {
        // 设置缓存
        $data = S('getStreetsBy'.$id);
        if($data) return $data;

        $data = $this->get($id, self::LEVEL_STREET);
        S('getStreetsBy'.$id,$data,3600);
        return $data;
    }

    public function getStreetById($id){
        $result = $this->where(['id' => $id])->find();
        return $result;
    }

}