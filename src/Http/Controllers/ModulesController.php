<?php
namespace Edith\Admin\Http\Controllers;

use Edith\Admin\Models\EdithModule;
use Edith\Admin\Support\File;
use Illuminate\Http\Request;

class ModulesController extends Controller
{
    /**
     * @var string|null 
     */
    protected ?string $title = '应用模块';

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $all = app('edith.modules')->scan();
        $installs = EdithModule::select('name', 'title', 'version', 'status')->get();
        $installed = [];
        $disabled = [];
        foreach ($installs as $row) {
            $installs[$row['name']]['is_install'] = $row['status'] == 1;
            if ($row['status'] == 1) {
                $installed[$row['name']] = $row;
            } else if ($row['status'] == 2) {
                $disabled[$row['name']] = $row;
            }
        }

        return success(compact('installed', 'disabled', 'all'));
    }
}