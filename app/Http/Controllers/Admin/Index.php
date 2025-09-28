<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Flasher\Prime\FlasherInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Index extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role_or_permission:SuperAdmin|AdminPanel access', ['only' => 'index']);
    }

    public function index(FlasherInterface $flasher)
    {
        $flasher->addSuccess('Welcome ' . auth()->user()->name . '!', 'Dashboard');
        return view('admin.index');
    }
}
