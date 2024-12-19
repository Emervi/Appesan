<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function sendNotification()
    {
        // Mengirimkan data untuk SweetAlert2
        return redirect()->back()
                         ->with('swal', [
                             'type' => 'success',  // Jenis notifikasi (success, error, dll)
                             'message' => 'Notifikasi berhasil ditampilkan!'  // Pesan yang akan ditampilkan
                         ]);
    }
}
