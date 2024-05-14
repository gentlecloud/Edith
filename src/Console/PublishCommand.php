<?php

namespace Edith\Admin\Console;

use Illuminate\Console\Command;

class PublishCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'edith:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish the edith resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // 发布资源
        $this->call('vendor:publish', [
            '--provider' => "Edith\Admin\EdithAdminServiceProvider"
        ]);
    }
}