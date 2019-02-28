<?php

namespace App\Console\Commands;

use App\Models\Publication;
use Illuminate\Console\Command;
use PHPHtmlParser\Dom;
use Sunra\PhpSimple\HtmlDomParser;

class AddTrailSlashes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trail:slashes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Добавление во все внутренние ссылки статей слеш';

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
    public function handle()
    {
        $articles = Publication::select("block_body")->where("type", 5)->get();
        $bar = $this->output->createProgressBar($articles->count());
        $bar->start();
        foreach ($articles as $article){

            if(!empty($article->block_body)){
                foreach ($article->block_body as $key => $item) {
                    $text = $item["block"];
                    if($item["type"] == "text" && !is_array($text)) {
                        $html = new \DOMDocument();
                        libxml_use_internal_errors(true);
                        $html->loadHTML($text,LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                        //$html = HTMLDomParser::str_get_html($text);
                        foreach($html->getElementsByTagName('a') as $hr) {
                            $href = $hr->getAttribute('href');
                            if ($href && $href != "#") {
                                $href = str_replace("http://", "https://", $href);
                                $href = $href . "/";
                                $hr->setAttribute('href',$href);

                                $article->setAttribute("block_body.$key.block",$html->saveHTML());
                                //var_dump(utf8_decode($html->saveHTML($html->documentElement)));die;
                            }
                        }
                        //var_dump($html->saveHTML());die;
                        $article->setAttribute("block_body.$key.block",utf8_decode($html->saveHTML($html->documentElement)));
                        //var_dump(utf8_decode($html->saveHTML($html->documentElement)));die;
                    }
                }
            }
            $article->save();
            $bar->advance();
        }
        $bar->finish();

    }
}
