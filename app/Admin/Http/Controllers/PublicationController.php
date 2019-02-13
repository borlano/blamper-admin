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
     * Обработчик создания публикации(статьи или вопроса)
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
            "removed"       => 0,//(float)$request->get("removed"),
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

    public static function editPublication(Request $request,\Cviebrock\LaravelElasticsearch\Manager $elasticsearch, $id){
//        $subject_id = new Mongoid ($request->get("subject"));
//
//        $subject = Subject::where("_id",$subject_id)->first()->toArray();

        $title          = $request->get("title");
        $type           = $request->get("type");
        $status         = $request->get("status");
        $removed        = $request->get("removed");
        $short_body     = $request->get("short_body");
        //$res            = $request->get("extra");

        Publication::where("_id", $id)->update([
            "title"         => $title,
            "status"        => $status?$status:0,
            "type"          => $type,
            "short_body"    => $short_body,
            "removed"       => $removed?$removed:0,
//            "tags"          => [],
//            "answers"       => [],//TODO доделать теги и ответы на вопросы
//            "block_body"    => [["type" => "text", "block" => $res["source"]]],
//            "subjects"      => [
//                0 => [
//                    "id" => $subject["id"],
//                    "name" => $subject["name"],
//                    "slug" => $subject["slug"],
//                    "path" => [0 => 1, 1 => $subject["id"]]
//                ]
//            ],
        //TODO Доделать вывод рубрик статьи
            "updated"       => Carbon::now()->toDateTimeString(),
        ]);
        //$publication = Publication::where("_id", $id)->first();

//        $pub->author()->create([
//            "id" => 1,
//            "user_id" => "52244c5419ecc27f043c16f8",
//            "avatar" => null,
//            "firstname" => "Редакция",
//            "lastname" => "Blamper"
//        ]); TODO Сделать изменения автора статьи
//        $pub->extra()->create([
//            "source" => $res["source"],
//            "cover" => new MongoId($res["cover"]),
//            "cover_basename" => $res["cover"]
//        ]); TODO Сделать изменения оригинала текста и изменение аватарки
        //$scalarData = self::toScalar($publication->getAttributes());

        $data = [
            "body" => [
                'doc' => [
                    "title"         => $title,
                    "status"        => $status,
                    "type"          => $type,
                    "short_body"    => $short_body,
                    "removed"       => $removed,
                ]
            ],
            "index" => "publications",
            "type" => "default",
            "id" => (string)$id,
        ];
//        $data["body"]["block_body"][0]["block"] = substr($data["body"]["block_body"][0]["block"], 0, 10000);
//        $data["body"]["block_body"][0]["block"] = mb_convert_encoding($data["body"]["block_body"][0]["block"], 'UTF-8', 'UTF-8');
        //$data["body"]["block_body"] = json_encode($data["body"]["block_body"]);
        //dd($data["body"]["updated"]);
//        echo "<pre>";
//        var_dump(json_last_error_msg());
//        echo "</pre>";
//        die;
//        unset($data["body"]["extra"]["_id"]);
//        unset($data["body"]["author"]["_id"]);



        $elasticsearch->update($data);

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