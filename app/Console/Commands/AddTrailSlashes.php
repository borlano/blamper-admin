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
        echo "Start adding trail slashes to end of links";
        $bar->start();
        foreach ($articles as $article){

            if(!empty($article->block_body)){
                foreach ($article->block_body as $key => $item) {
                    $text = $item["block"];
                    if($item["type"] == "text" && !is_array($text)) {
                        $html = new \DOMDocument();
                        libxml_use_internal_errors(true);
                        $html->loadHTML($text,LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

                        foreach($html->getElementsByTagName('a') as $hr) {
                            $href = $hr->getAttribute('href');
                            if ($href && $href != "#" && substr($href, 0, 1) != "#") {
                                $href = str_replace("http://", "https://", $href);
                                if(substr($href, -1, 1) != "/") {
                                    $href = $href . "/";
                                }
                                $hr->setAttribute('href',$href);
                                $article->setAttribute("block_body.$key.block",$html->saveHTML());
                            }
                        }
                        $article->setAttribute("block_body.$key.block",utf8_decode($html->saveHTML($html->documentElement)));
                    }
                }
            }
            $article->save();
            $bar->advance();
        }
        $bar->finish();
        echo "Finish!";
    }
}
