<?php

namespace App\Http\Controllers;

use App\Http\Models\User;
use Illuminate\Http\Request;

class TestController extends Controller
{


    //hello
    public function testLogin()
    {
        return view('test.testLogin');
    }
    //github
    public function testGetSession(Request $request)
    {
        $request->session()->put('username', $request->get('username'));
        $request->session()->put('pwd', $request->get('pwd'));
        dump($request->session('pwd'));
    }

    public function test3()
    {
        dump('action');
    }

    ///hello
    ///


}
