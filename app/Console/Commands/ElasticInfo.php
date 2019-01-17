<?php

namespace App\Console\Commands;

use App\Models\Publication;
use Illuminate\Console\Command;
use Elasticsearch\Client;

class ElasticInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(\Cviebrock\LaravelElasticsearch\Manager $elasticsearch)
    {
        $publications = Publication::where("id",153467)->where("type", 5)->where("status", 1)->get()->toArray();
//        var_dump($publications);
//        die;
        foreach ($publications as $pub)
        {
//            var_dump($pub);
//            die;
            $scalarData = self::toScalar($pub);
//            var_dump($scalarData);
           // die;

            unset($scalarData["block_body"]);
//            $scalarData["block_body"][0]["type"] = "text";
            $scalarData["block_body"][0]["block"] = "text text";
            $scalarData["block_body"][1]["block"] = "text text";
            $scalarData["block_body"][2]["block"] = "text text";
            $scalarData["block_body"][3]["block"] = "text text";
            $scalarData["block_body"][4]["block"] = "text text";
            $scalarData["block_body"][5]["block"] = "text text";
            $scalarData["block_body"][6]["block"] = "text text";
            $scalarData["block_body"][7]["block"] = "text text";
            $scalarData["block_body"][8]["block"] = "text text";
            $scalarData["updated"] = strtotime($pub["updated"]);
            $scalarData["created"] = strtotime($pub["created"]);

            $data = [
                "body" => $scalarData,
                "index" => "publications",
                "type" => "default",
                "id" => (string)$pub["_id"],
            ];
            //$elasticsearch->indices();
            //try {
                $elasticsearch->index($data);
            //}catch(\Exception $e){var_dump($e->getMessage());}
        }
//        $stats = $elasticsearch->getSource(['index' => 'publications',"type" => "default","id" => "55f15e5e32e2d4f53d8b456c" ]);
//        ///$source = $stats->_source;
//        $stats["title"] = "Замена порогов";


//        $data = [
//            "body" => $stats,
//            "index" => "publications",
//            "type" => "default",
//            "id" => "55f15e5e32e2d4f53d8b456c",
//        ];
//        //$elasticsearch->indices();
//        return $elasticsearch->index($data);
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
                $item = (int) $item->sec;
                break;
            default:
                return false;
        }
        //var_dump($item);
        return true;
    }
}
