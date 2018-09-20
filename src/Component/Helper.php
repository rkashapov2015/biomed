<?php
/**
 * Created by PhpStorm.
 * User: rinat
 * Date: 19.09.18
 * Time: 11:44
 */

namespace App\Component;


class Helper
{
    public static function convertRusToEn(string $str) {
        $dictionary = [
            'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g',
            'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
            'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
            'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r',
            'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h',
            'ц' => 'ts', 'ч' => 'ch', 'ш' => 'sh', 'щ' => '', 'ъ' => '',
            'ы' => '', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
        ];

        $newstr = '';
        foreach (preg_split('//u',$str, null, PREG_SPLIT_NO_EMPTY) as $letter) {
            if (in_array($letter, array_keys($dictionary))) {
                $newstr .= $dictionary[$letter];
            } else {
                $newstr .= $letter;
            }
        }

        return $newstr;
    }

    public static function getJsonData($string) {
        try {
            $data = json_decode($string, true);
            return $data ? $data : [];
        } catch (\Exception $ex) {
            return [];
        }
    }
}