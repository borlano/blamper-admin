<?php

namespace App\Console\Commands;

use App\Models\AutoMark;
use Illuminate\Console\Command;

class AutoMarkUrls extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change:urlmark';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Меняем в модели auto_mark description url из http на https';

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
        $automarks = AutoMark::all();
        $this->output->progressStart($automarks->count());
        foreach ($automarks as $automark) {
            $automark->description_url = str_replace("http","https",$automark->description_url);
            $automark->save();
            $this->output->progressAdvance();
        }
        $this->output->progressFinish();
        echo "Complete!";
    }
}
