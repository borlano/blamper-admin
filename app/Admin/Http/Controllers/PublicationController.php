<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 09.01.2019
 * Time: 11:59
 */

namespace App\Admin\Http\Controllers;


use App\Models\Publication;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PublicationController
{
    public function createPublication(Request $request,\Cviebrock\LaravelElasticsearch\Manager $elasticsearch){
        $maxId = Publication::where("type", 5)->where("status", 1)->max("id");
        $maxId++;
        //dd($maxId);
        $pub = Publication::create([
            "title" => $request->get("title"),
            "status" => (float)$request->get("status"),
            "type" => (int)$request->get("type"),
            "id" => $maxId,
            "short_body" => "",
            "created" => Carbon::now(),
            "updated" => Carbon::now(),
            "removed" => (float)$request->get("removed")
        ]);
        $extra = $pub->extra;
        $res = $request->get("extra");
        $pub->author()->create([
            "id" => 1,
            "user_id" => "52244c5419ecc27f043c16f8",
            "avatar" => null,
            "firstname" => "Редакция",
            "lastname" => "Blamper"
        ]);
        $pub->extra()->create(["source" => $res["source"]]);
        $scalarData = self::toScalar($pub->getAttributes());

        $data = [
            "body" => $scalarData,
            "index" => "publications",
            "type" => "default",
            "id" => (string)$pub->_id,
        ];
        unset($data["body"]["extra"]["_id"]);
        unset($data["body"]["author"]["_id"]);
//        echo "<pre>";
//        var_dump($data);
//        echo "</pre>";
//        die;


        $elasticsearch->index((object)$data);
        return $data;
        return redirect()->back();
    }


    /**
     * Convert data with Mongo types to scalar
     * @param array $data Data with mongo-types
     * @param bool $recursive Flag of recursive looping data
     * @return mixed
     */
    public static function toScalar($data, $recursive = true)
    {
        if (is_object($data) && ($data instanceof \Iterator || $data instanceof \ArrayAccess) || is_array($data)) {

            foreach ($data as &$item) {
                if ($recursive) {

                    $item = static::toScalar($item);
                } else {

                    static::_objectToScalar($item);
                }
            }
        } else {
            static::_objectToScalar($data);
        }
        return $data;
    }

    protected static function _objectToScalar(&$item)
    {
        if (!is_object($item)) {
            return false;
        }
//var_dump($item);
        //$item = (string) $item;
        //var_dump(get_class($item));
        switch (get_class($item)) {
            case "MongoDB\BSON\ObjectId":
                $item = (string) $item;
                break;
            case "MongoDB\BSON\UTCDateTime":
//                var_dump($item->toDateTime());
//                die;
                $item = (int)(string) $item;
                //var_dump($item);
                break;
            default:
                return false;
        }
        //var_dump($item);
        return true;
    }
}