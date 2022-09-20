<?php

namespace App\Http\Controllers\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Photo\StorePhoto;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/*
 * Снеси не используемые методы и обозначь в рутах каке методы доступны
 */

class PhotosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $album_id = $request->album_id;
        return view('photos.create',compact('album_id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    /*
     * Аннотация != ответ
     */
    public function store(StorePhoto $request)
    {


        $files = $request->file('images');
        $captions = $request->captions;

//        dd($files);
        foreach ($files as $key => $file) {
            $image = Storage::disk('public')->put('/photos', $file);
            //Заменить на findOrFail
            $album = Album::find($request->album_id);
            //Зачем ты кладешь album_id в перемеенную?
            $album_id = $request->album_id;
            // Условие избыточно. $image у тебя полюбому есть, так как если это не так - ты не попадешь в контроллер
            // или приложение вылетит при сохранении. album_id также уже прошел валидацию в Request, а вслучае если
            // албома не найдется - отработает findOrFail. is_numeric - не надо.
            // И лесенка из if - зло. Если у тебя получается так - скорее всего ты делаешь что то не правильно.
            if($image && isset($album_id) && is_numeric($album_id)){
                // Юзать хелпер Arr::
                //Весь if заменить на ??
                if($captions[$key] !== NULL) {
                    Photo::create([
                        'caption' => $captions[$key],
                        'image' => Storage::url($image),
                        'album_id' => $album_id,
                    ]);
                } else {
                    Photo::create([
                        'caption' => $file->getClientOriginalName(),
                        'image' => Storage::url($image),
                        'album_id' => $album_id,
                    ]);
                }
                $album->update([ 'updated_at' => now() ]);
            }
        };

        return response()->json(['code'=>1,'msg'=>'Photos has been uploaded successfully','album_id'=> $request->album_id]);
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
    public function destroy(Photo $photo)
    {
        $photo->delete();

        return response()->json(['code'=>1,'msg'=>'Photo has been deleted successfully']);
    }
}
