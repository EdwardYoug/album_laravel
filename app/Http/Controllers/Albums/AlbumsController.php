<?php

namespace App\Http\Controllers\Albums;

use App\Http\Controllers\Controller;
use App\Http\Requests\Album\StoreAlbum;
use App\Http\Requests\Album\UpdateAlbum;
use App\Models\Album;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;

class AlbumsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /*
     * 1) Наверное лучше будет завести одну переменную(например data[] и в нее складывать все данные,
     * чем в compact перечислять много переменных).
     * 2) В аннотации к методу прописанно, что он вернет \Illuminate\Http\Response по факут он возвращает View.
     */
    public function index()
    {
        $albums = Album::where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->paginate(10);
        $randomPhoto = Photo::get();


        return view('albums.index', compact('albums', 'randomPhoto'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    /*
     * В аннотации к методу прописанно, что он вернет \Illuminate\Http\Response по факут он возвращает View.
     */
    public function create()
    {
        $albums = Album::all();
        return view('albums.create', compact('albums'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */

    /*
     * 1) Метод возвращает JsonResponse, а не то что указано в аннотации
     * 2) По хорошему тут Album::create должно быть передано $request->validated(),
     * а user_id нгазначаться например в Observer (Почитай за это. если освоишь будет круто)
     * есть и другие способы слушания событий модели.
     * 3) Аннотация != return
     */
    public function store(StoreAlbum $request)
    {

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'user_id' => Auth::user()->id,
        ];
        Album::create($data);

        return response()->json(['code' => 1, 'msg' => 'New album has been created successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /*
    * 1) Наверное лучше будет завести одну переменную(например data[] и в нее складывать все данные,
    * чем в compact перечислять много переменных).
    * 2) user_id по моему незачем тащить в view - его не зазорно получить прям от туда(из view)
    * 3) Не понятно зачем ты пишешь ->get()->all()
    * 4) Опять метод возвращет по факту не то что в описании
    */
    public function show(Album $album)
    {
        $photos = Photo::with('album')->where('album_id', $album->id)->get()->all();

        $AuthorizedUserId = Auth::user()->id;

        return view('albums.show', compact('album', 'photos', 'AuthorizedUserId'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /*
     * Опять метод возвращет по факту не то что в описании как и во всех остальных - дальше дублировать не буду
     */

    public function edit(Album $album)
    {
        return view('albums.edit', compact('album'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /*
     * 1) Метод возвращет по факту не то что в описании
     * 2) в $album->update положить $request->validated()
     */

    public function update(UpdateAlbum $request, Album $album)
    {

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        $album->update($data);
        return response()->json(['code' => 1, 'msg' => 'Album has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    /*
     * 1) Вот тут не совсем понятно, что происходит.
     * Ты должен удалить альбом, а все его подчиненные записи, должны удалиться автоматически -
     * должно отработать каскадное удаление и обновление данных, которое ты должен был настроить
     * в данном случае в миграциях
     *
     * 2) В коде проекта не должно быть никаких комментариев (168 стр.)
     */

    public function destroy(Album $album)
    {
        $photos = Photo::with('album')->where('album_id', $album->id)->get()->all();

        if (!empty($photos)) {
            foreach ($photos as $photo) {
                $photo->delete();
            }
        }


        $album->delete();

//        return redirect()->route('main.index',);
        return response()->json(['code' => 1, 'msg' => 'Album has been deleted successfully']);
    }
}
