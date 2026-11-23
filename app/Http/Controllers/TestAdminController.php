<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestAdminController extends Controller
{
    public function index() {
    return view('admin.dashboard'); 
}

}
