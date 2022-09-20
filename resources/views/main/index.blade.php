@extends('layouts.main')


@section('content')
    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Список всех альбомов на сайте</h1>
                @auth
                    <a href="{{ route('albums.create') }}" class="btn btn-primary my-2">Создать альбом</a>
                @endauth
            </div>
        </section>

        <div class="album py-5 bg-light">
            <div class="container">
                <div class="row" style="margin-bottom: 50px;">
                    @foreach($albums as $album)
                        {{--Подумать как можно по другому вытащить одну фотку из альбома. Это удалить!--}}
                        @php
                            $photosInAlbum = $album->photos->where('album_id',$album->id);
                            $albumIsEmpty = empty($photosInAlbum->toArray());


                            if( !$albumIsEmpty ) {
                                $randomOnePhoto = $photosInAlbum->random(1)->toArray();
                            } else {
                                $randomOnePhoto = NULL;
                            }
                        @endphp
                        {{----}}
                        <div class="col-md-4">
                            <div class="card mb-4 box-shadow">
                                {{--Заменить на ?? --}}
                                @if( isset($randomOnePhoto) )
                                {{--Любые операции с массивами лучше делать через хелпер Arr::--}}
                                    <img class="card-img-top" src="{{ $randomOnePhoto[0]["image"] }}" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_183143f4407%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_183143f4407%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.68333435058594%22%20y%3D%22120.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                                @elseif($randomOnePhoto == NULL)
                                    <img class="card-img-top" src="noimage.png" alt="Здесь должно быть фото" style="height: 225px; width: 100%; display: block;" src="data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22348%22%20height%3D%22225%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20348%20225%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_183143f4407%20text%20%7B%20fill%3A%23eceeef%3Bfont-weight%3Abold%3Bfont-family%3AArial%2C%20Helvetica%2C%20Open%20Sans%2C%20sans-serif%2C%20monospace%3Bfont-size%3A17pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_183143f4407%22%3E%3Crect%20width%3D%22348%22%20height%3D%22225%22%20fill%3D%22%2355595c%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%22116.68333435058594%22%20y%3D%22120.3%22%3EThumbnail%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" data-holder-rendered="true">
                                @endif
                                {{----}}
                                    <div class="card-body">
                                    <strong>{{ $album->title }}</strong>
                                    <p>{{ $album->photos->count() . ' Фото' }}</p>
                                    <p class="card-text">{{ $album->description }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="btn-group">
                                            <a href="{{ route('albums.show',$album->id) }}" type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center">View</a>
                                            @auth
                                                @if ( $album->user_id == $AuthorizedUserId)
                                                    <a href="{{ route('albums.edit',$album->id) }}" type="button" class="btn btn-sm btn-outline-secondary d-flex align-items-center">Edit</a>
                                                    {{--                                        <button type="button" class="btn btn-sm btn-outline-secondary">Delete</button>--}}
{{--                                                    <form class="btn btn-sm btn-outline-secondary d-flex align-items-center" action="{{ route('albums.destroy',$album->id) }}" data-albumid="{{$album->id}}" method="DELETE">--}}
                                                    <form class="btn btn-sm btn-outline-secondary d-flex align-items-center" action="#" data-albumid="{{$album->id}}" method="DELETE">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="border-0 bg-transparent btn btn-sm btn-outline-secondary" type="submit">Delete</button>
                                                    </form>
                                                @endif
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


                </div>
               <div style="display: flex;justify-content: center">
                   <div>
                       {{ $albums->links() }}
                   </div>
               </div>
            </div>
        </div>

    </main>


    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    {{--Все скрипты лучше выносить в отдельные файлы и через mix сжимать. почитай про это и сделай--}}
    <script>
        $(document).ready(function() {

            $('.album form').on('submit', function(e) {
                e.preventDefault();

                var form = this;
                //Использовать route()
                $.ajax({
                    url:"/albums/"+$(this).data('albumid'),
                    method: "POST",
                    data: new FormData(form),
                    processData:false,
                    dataType: 'json',
                    contentType: false,
                    success: function (data) {
                        $(form)[0].reset();
                        alert(data.msg);
                        window.location.reload();
                    }
                })
            });

        });
    </script>
@endsection