<?php

namespace App\Http\Controllers;

use Creitive\Breadcrumbs\Facades\Breadcrumbs;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        Breadcrumbs::setDivider('');
        Breadcrumbs::addCrumb('Inicio', '/');
        Breadcrumbs::setCssClasses('breadcrumb');
    }
}