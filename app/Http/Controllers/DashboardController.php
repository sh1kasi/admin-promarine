<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Grei\TanggalMerah;
use Illuminate\Support\Collection;


class DashboardController extends Controller
{
    protected $data;

    public function index()
    {

        // $response = http::get("https://api-harilibur.vercel.app/api");

        return view('admin.dashboard');
    }
}
