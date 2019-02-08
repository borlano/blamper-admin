<?php
/**
 * Created by PhpStorm.
 * User: alexey
 * Date: 09.01.2019
 * Time: 11:59
 */

namespace App\Admin\Http\Controllers;


use App\Models\Publication;
use App\Models\Subject;
use Carbon\Carbon;
use Illuminate\Http\Request;
use \MongoDB\BSON\ObjectID as MongoId;

class PublicationController
{
    /**
     * @param Request $request
     * @param \Cviebrock\LaravelElasticsearch\Manager $elasticsearch
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createPublication(Request $request,\Cviebrock\LaravelElasticsearch\Manager $elasticsearch){
//dd($request->get("subject"));
        $subject_id = new Mongoid ($request->get("subject"));
//dd($subject_id);
        $subject = Subject::where("_id",$subject_id)->first()->toArray();

        //dd($subject);
        $maxId = Publication::max("id");
        $maxId++;
        $res = $request->get("extra");
        $pub = Publication::create([
            "title"         => $request->get("title"),
            "status"        => (float)$request->get("status"),
            "type"          => (int)$request->get("type"),
            "id"            => $maxId,
            "short_body"    => $request->get("short_body"),
            "created"       => Carbon::now(),
            "updated"       => Carbon::now(),
            "removed"       => (float)$request->get("removed"),
            "tags"          => [],
            "block_body"    => [["type" => "text", "block" => $res["source"]]],
            "answers"       => [],
            "subjects"      => [
                0 => [
                    "id" => $subject["id"],
                    "name" => $subject["name"],
                    "slug" => $subject["slug"],
                    "path" => [0 => 1, 1 => $subject["id"]]
                ]
            ],
        ]);



        $pub->author()->create([
            "id" => 1,
            "user_id" => "52244c5419ecc27f043c16f8",
            "avatar" => null,
            "firstname" => "Редакция",
            "lastname" => "Blamper"
        ]);
        $pub->extra()->create([
            "source" => $res["source"],
            "cover" => new MongoId($res["cover"]),
            "cover_basename" => $res["cover"]
        ]);
        $scalarData = self::toScalar($pub->getAttributes());

        $data = [
            "body" => $scalarData,
            "index" => "publications",
            "type" => "default",
            "id" => (string)$pub->_id,
        ];
        $data["body"]["block_body"][0]["block"] = substr($data["body"]["block_body"][0]["block"], 0, 10000);
        $data["body"]["block_body"][0]["block"] = mb_convert_encoding($data["body"]["block_body"][0]["block"], 'UTF-8', 'UTF-8');
        $data["body"]["block_body"] = json_encode($data["body"]["block_body"]);
//        echo "<pre>";
//        var_dump(json_last_error_msg());
//        echo "</pre>";
//        die;
        unset($data["body"]["extra"]["_id"]);
        unset($data["body"]["author"]["_id"]);



        $elasticsearch->index((object)$data);
        //return $data;
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
        switch (get_class($item)) {
            case "MongoDB\BSON\ObjectId":
                $item = (string) $item;
                break;
            case "MongoDB\BSON\UTCDateTime":
                $item = (int)(string) $item;
                break;
            default:
                return false;
        }
        return true;
    }
}