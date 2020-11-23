<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Traits\UploadTrait;

class PhotoController extends Controller
{
    use UploadTrait;
    
    /**
     * Display all stored images.
     *
     * @return view
     */
    public function index()
    {
        $images = Storage::disk('public')->allFiles('uploads'); //getting all uploaded images from the storage

        return view('welcome', ['images' => $images]);
    }

    /**
     * Save image from upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $folder = '/uploads/images/';
                $name = $request->date; //normally we could same original file name and date to db, although this is not required
                $validated = $request->validate([
                    'date' => 'required|string|max:10|date_format:d-m-Y', //validating format for consistency
                    'image' => 'required|mimes:jpg,jpeg,png|max:1014',
                ]);
                $this->uploadOne($image, $folder, 'public', $name);
            }
        }
        
        return \Redirect::back();
    }
    
    /**
     * Save image with api.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    public function storeApi(Request $request): JsonResponse
    {
        $url = $request->url;
        $name = $request->date;
        $validator = Validator::make($request->all(), [
            'date' => 'required|string|max:10|date_format:d-m-Y',
            'url' => [
                'required',
                'regex:/([a-z\-_0-9\/\:\.]*\.(jpg|jpeg|png))/i', //validating file format with regex
        ]]);
        
        if ($validator->fails()) {
           $result['errors'][] = $validator->errors()->get('*');
        } else {
            $folder = 'public/uploads/images/';
            $uploaded = $this->uploadFromUrl($url, $folder, $name);
            $result['success'] = $uploaded;
        }

        return response()->json($result);
    }
}
