<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;

class FrontendController extends Controller
{
    public function getIndex()
    {
        // return front end framework   
        return File::get(public_path() .'/app/index.html');
    }
}
