<?php

namespace App\Types\Src;

abstract class VodType
{
    //
    const Msr       = 'Msr';
    const AliyunVod = 'AliyunVod';
    
    //
    public static function check($type)
    {
        switch ($type) {
            case VodType::Msr:
            case VodType::AliyunVod:
                return true;
            default:
                return false;
        }
    }
    
    //
    public static function list()
    {
        return [
            ['type' => 'Msr',       'value' => VodType::Msr,       'text' => '愛錄客'],
            ['type' => 'AliyunVod', 'value' => VodType::AliyunVod, 'text' => '阿里雲'],
        ];
    }
}
