<?php

namespace Edith\Admin\Console;

use Edith\Admin\Facades\EdithAdmin;
use Edith\Admin\Support\Rsa;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
        if (version_compare(ltrim(EdithAdmin::version(), 'v'), '2.0.1', '<=') || empty(config('edith.rsa.public_key'))) {
            $this->updateAdminRsaKey();
        }
    }

    public function updateAdminRsaKey()
    {
        try {
            $rsaInfo = (new Rsa())->generate();
            modify_config_file('edith.php', 'rsa', $rsaInfo);
        } catch (\Exception $e) {
            Log::error("Edith Admin install Failed. Init Rsa ErrMsg:" . $e->getMessage());
        }
    }
}