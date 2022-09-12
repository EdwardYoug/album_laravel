@extends('layouts.main')

@section('content')

<body class="bg-light">

<div class="container">
{{--    <div class="py-5 text-center">--}}
{{--        <img class="d-block mx-auto mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">--}}
{{--        <h2>Checkout form</h2>--}}
{{--        <p class="lead">Below is an example form built entirely with Bootstrap's form controls. Each required form group has a validation state that can be triggered by attempting to submit the form without completing it.</p>--}}
{{--        @dd($albums)--}}
{{--        11111111111111111111--}}
{{--        <table class="table table-hover table-condensed" id="albums-table">--}}
{{--            <thead class="d-flex justify-content-between">--}}
{{--            <th>id</th>--}}
{{--            <th>Название</th>--}}
{{--            <th>Описание</th>--}}
{{--            <th>Автор</th>--}}
{{--            </thead>--}}
{{--            <tbody class="d-flex flex-column" >--}}
{{--            @foreach($albums as $album)--}}
{{--                <tr>--}}
{{--                    <td>{{ $album->id }}</td>--}}
{{--                    <td>{{ $album->title }}</td>--}}
{{--                    <td>{{ $album->description }}</td>--}}
{{--                    <td>{{ $album->user_id }}</td>--}}
{{--                <tr/>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--        1111111111111111111111111111--}}
{{--    </div>--}}

{{--    @dd($album)--}}

    <div class="row d-flex justify-content-center" style="padding-top: 20%;padding-bottom: 21%;">
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Редактирование албома</h4>
            <form action="{{route('albums.update',$album->id)}}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PATCH')
                <div class="mb-3">
                    <label for="title">Название</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Введите название альбома" required value="{{ $album->title }}">
{{--                    <div class="invalid-feedback">--}}
{{--                        Please enter your shipping address.--}}
{{--                    </div>--}}
                </div>

                <div class="mb-3">
                    <label for="description">Описание</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="Введите описание альбома" required value="{{ $album->description }}">
{{--                    <div class="invalid-feedback">--}}
{{--                        Please enter your shipping address.--}}
{{--                    </div>--}}
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Сохранить</button>
                <a href="{{ route('albums.index') }}" class="btn btn-primary btn-lg btn-block">Вернуться на Главную</a>
            </form>
        </div>
    </div>


</div>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
<script src="../../assets/js/vendor/popper.min.js"></script>
<script src="../../dist/js/bootstrap.min.js"></script>
<script src="../../assets/js/vendor/holder.min.js"></script>
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';

        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');

            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>
{{--<script>--}}
{{--    $(function() {--}}
{{--        alert('hello');--}}
{{--    })--}}
{{--</script>--}}
</body>

@endsection