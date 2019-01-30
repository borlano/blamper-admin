<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 18.01.2019
 * Time: 17:20
 */

namespace App\Services;
use Intervention\Image\ImageManagerStatic as Image;


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

    public static function resizeImages($filename, $withoutExt){
        Image::configure(array('driver' => 'gd'));
        $service = PublicationServices::genPathToFile($withoutExt);
        $image = Image::make(public_path("/steady/".$service."/".$withoutExt."/").$filename)->resize(1150, 230);
        if (!file_exists(public_path("/steady/".$service."/".$withoutExt."/"))) {
            mkdir(public_path("/steady/".$service."/".$withoutExt."/"), 0777, true);
        }
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $image->save(public_path("/steady/".$service."/".$withoutExt."/")."1150x230.".$ext);

        $image = Image::make(public_path("/steady/".$service."/".$withoutExt."/").$filename)->resize(568, 390);
        $image->save(public_path("/steady/".$service."/".$withoutExt."/")."568x390.".$ext);
        $serviceSave = PublicationServices::genPathToFile($withoutExt,"covers");

        if (!file_exists(public_path("/steady/".$serviceSave."/".$withoutExt."/"))) {
            mkdir(public_path("/steady/".$serviceSave."/".$withoutExt."/"), 0777, true);
        }
        $image = Image::make(public_path("/steady/".$service."/".$withoutExt."/").$filename)->resize(565, 565);
        $image->save(public_path("/steady/".$serviceSave."/".$withoutExt."/")."565x565.".$ext);

        $image = Image::make(public_path("/steady/".$service."/".$withoutExt."/").$filename)->resize(195, 195);
        $image->save(public_path("/steady/".$serviceSave."/".$withoutExt."/")."195x195.".$ext);

        $image = Image::make(public_path("/steady/".$service."/".$withoutExt."/").$filename)->resize(150, 150);
        $image->save(public_path("/steady/".$serviceSave."/".$withoutExt."/")."150x150.".$ext);

        $image = Image::make(public_path("/steady/".$service."/".$withoutExt."/").$filename)->resize(232, 232);
        $image->save(public_path("/steady/".$serviceSave."/".$withoutExt."/")."232x232.".$ext);

        $image = Image::make(public_path("/steady/".$service."/".$withoutExt."/").$filename)->resize(235, 235);
        $image->save(public_path("/steady/".$serviceSave."/".$withoutExt."/")."235x235.".$ext);

        $image = Image::make(public_path("/steady/".$service."/".$withoutExt."/").$filename)->resize(484, 290);
        $image->save(public_path("/steady/".$serviceSave."/".$withoutExt."/")."484x290.".$ext);

        $image = Image::make(public_path("/steady/".$service."/".$withoutExt."/").$filename)->resize(490, 290);
        $image->save(public_path("/steady/".$serviceSave."/".$withoutExt."/")."490x290.".$ext);
    }
}