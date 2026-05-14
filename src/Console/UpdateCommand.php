<?php

namespace Edith\Admin\Console;

use Illuminate\Console\Command;

class UpdateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $signature = 'edith:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the edith version';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('migrate');
    }
}