<?php

namespace App\Http\Controllers;

use App\Photo;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $photos = Photo::all();

        return response()->view('admin.photos.index', ['photos' => $photos]);
    }
}
