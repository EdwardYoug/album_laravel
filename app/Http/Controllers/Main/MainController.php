<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
 * Этот контроллер не должен быть ресурсным (снеси все неиспользуемые методы). Ресурсные контроллеры предназначены для REST.
 * тут REST нету и не предвидиться
 */

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
     * 1) return =! аннотации
     * 2) if else по моему тут не нужно само по себе, можно обойтись if внутри которого есть return.
     * 3) У тебя и в if и в else возвращается одно и то же
     * 4) Проверить авторизацию можно в Request, или если тебе нужен просто userId - его можно вытащить из view
     */
    public function index()
    {
        $albums = Album::with('photos')->orderBy('updated_at','desc')->paginate(10);
        $randomPhoto = Photo::get();

        $AuthorizedUserId = 0;
        if(Auth::user()) {
            $AuthorizedUserId = Auth::user()->id;
            return view('main.index',compact('albums','randomPhoto','AuthorizedUserId'));
        } else {
            return view('main.index',compact('albums','randomPhoto', 'AuthorizedUserId'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
