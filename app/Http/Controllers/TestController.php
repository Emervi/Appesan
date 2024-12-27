<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function sendSuccess()
    {
        return redirect()->back()->with('success', 'Berhasil cok!');
    }

    public function sendFail()
    {
        return redirect()->back()->with('fail', 'Gagal cok!');
    }
}
