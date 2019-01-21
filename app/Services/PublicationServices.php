<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 18.01.2019
 * Time: 17:20
 */

namespace App\Services;


class PublicationServices
{
    /**
     * Генерим пусть до файла
     *
     * @param $mongoId
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public static function genPathToFile($mongoId, $type = 'original')
    {
        $originalPath = $type;

        $firstDir  = substr($mongoId, 0, 2);
        $secondDir = substr($mongoId, 2, 2);
        $thirdDir  = substr($mongoId, 4, 2);

        return $firstDir .'/'. $secondDir .'/'. $thirdDir .'/'. $originalPath;
    }
}