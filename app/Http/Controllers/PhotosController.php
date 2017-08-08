<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use  ResponseCache;

use App\Photo;
use App\Album;

use Image;

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($album_id)
    {
				$album = Album::find($album_id);
        return response()->view('admin.photos.show', ['album' => $album]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($albumId)
    {
    		$album = Album::find($albumId);

        return response()->view('admin.photos.create', [
        	'album' => $album
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$photo = [];

			foreach ($request->file('file') as $requestFile) {
				$intervention_image = Image::make($requestFile->getRealPath());
  			$exif_data = [];
  			$iptc_data = [];
  			$exif_data = ($intervention_image->exif()) ? json_encode($intervention_image->exif()) : null;
  			$iptc_data = ($intervention_image->iptc()) ? json_encode($intervention_image->iptc()) : null;

				$photo = new Photo();
				$photo->filename = $requestFile->getClientOriginalName();
				$photo->exif = $exif_data;
				$photo->iptc = $iptc_data;
				$photo->addMedia($requestFile)->toMediaCollection('images');
				$photo->save();
			}

   		return response()->json([true]);
    }


    public function getPhotoFeed()
    {
    	$response = [];
    	$photos = Photo::all();

    	foreach($photos as $photo)
    	{
    		$response['photos'][] = [
    			'url' => $photo->getMedia('images')->first()->getUrl('medium')
    		];
    	};

    	return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
