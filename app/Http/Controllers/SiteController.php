<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Photo;

class SiteController extends Controller
{
    public function index()
    {
			$photos = Photo::all();

			return response()->view('album_grid', ['photos' => $photos]);
    }

    public function showPhoto($photo_id){
    	$photo = Photo::findOrFail($photo_id);

    	return response()->view('detail', ["photo" =>  $photo]);
    }
}
