<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Support\File;

class ModulesController extends Controller
{
    /**
     * @var string|null 
     */
    protected ?string $title = '应用模块';

    public function render()
    {
        if (!file_exists((new File)->getCachedServicesPath('edith_admin_cloud.php'))) {

        } else {

        }
    }
}