<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ArticlesCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'CRON para ser executado diariamente às 9h e armazenar no banco os novos artigos';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}
