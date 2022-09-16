
@extends('layouts.main')

@section('content')

<body class="bg-light">

<div class="container">

    <div class="row d-flex justify-content-center" style="padding-top: 20%;padding-bottom: 21%;">
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Добавьте фотографии в альбом</h4>
            <p class="mb-3" style="text-align: center;">Вы можете добавить сразу несколько фотографий.Выделите их и нажмите кнопку добавить.</p>
            <form action="#" method="POST" novalidate id="uploadImages" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="image">Фото</label>
                    <input type="file" class="form-control" id="addImages" name="images[]" multiple required>
                    <span class="text-danger error-text images_error" ></span>
                </div>
                <input type="hidden" name="album_id" value="{{ $album_id }}" required>

                <ul id="uploadImagesList">
                    <li class="item template">
                        <span class="img-wrap">
                            <img src="image.jpg" alt="Превьюшка">
                        </span>
                        <input type="text" name="caption" placeholder="Подпись">
                        <span class="delete-link" title="Удалить">Удалить</span>
                    </li>
                </ul>

                <div class="clear"></div>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block mb-2" type="submit">Добавить</button>
                <a href="{{ route('albums.index') }}" class="btn btn-primary btn-lg btn-block">Вернуться на Главную</a>
            </form>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="/dist/js/bootstrap.min.js"></script>


<script>
    jQuery(document).ready(function ($) {

        var maxFileSize = 2 * 1024 * 1024; // (байт) Максимальный размер файла (2мб)
        var queue = {};
        var form = $('form#uploadImages');
        var imagesList = $('#uploadImagesList');

        var itemPreviewTemplate = imagesList.find('.item.template').clone();
        itemPreviewTemplate.removeClass('template');
        imagesList.find('.item.template').remove();


        $('#addImages').on('change', function () {
            var files = this.files;

            for (var i = 0; i < files.length; i++) {
                var file = files[i];

                if ( !file.type.match(/image\/(jpeg|jpg|png|gif)/) ) {
                    alert( 'Фотография должна быть в формате jpg, png или gif' );
                    continue;
                }

                if ( file.size > maxFileSize ) {
                    alert( 'Размер фотографии не должен превышать 2 Мб' );
                    continue;
                }

                preview(files[i]);
            }

            this.value = '';
        });

        // Создание превью
        function preview(file) {
            var reader = new FileReader();
            reader.addEventListener('load', function(event) {
                var img = document.createElement('img');

                var itemPreview = itemPreviewTemplate.clone();

                itemPreview.find('.img-wrap img').attr('src', event.target.result);
                itemPreview.data('id', file.name);

                imagesList.append(itemPreview);

                queue[file.name] = file;

            });
            reader.readAsDataURL(file);
        }

        // Удаление фотографий
        imagesList.on('click', '.delete-link', function () {
            var item = $(this).closest('.item'),
                id = item.data('id');

            delete queue[id];

            item.remove();
        });


        // Отправка формы
        form.on('submit', function(event) {

            var formData = new FormData(this);

            for (var id in queue) {
                formData.append('images[]', queue[id]);
            }

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                async: true,
                success: function (res) {
                    alert(res)
                },
                cache: false,
                contentType: false,
                processData: false
            });

            return false;
        });

    });

</script>


<script>
    $(document).ready(function() {

        $('#uploadImages').on('submit', function(e) {
            e.preventDefault();
            var form = this;

            $.ajax({
                url:"{{ route('photos.store') }}",
                method: "POST",
                data: new FormData(form),
                processData:false,
                dataType: 'json',
                contentType: false,
                beforeSend: function () {
                    $(form).find('span.error-text').text('');
                },
                success: function (data) {
                    $(form)[0].reset();
                    alert(data.msg);
                    $(location).attr('href','http://localhost/albums/'+data.album_id);
                },
                error: function (data) {
                    // console.log(data.responseJSON.errors);
                    if(data.hasOwnProperty('responseJSON') &&  data.responseJSON.hasOwnProperty('errors')) {}
                    $.each(data.responseJSON.errors, function(prefix,val) {
                        if(prefix.includes('images.')) {
                            $(form).find('span.images_error').text('Вы можете загружать только файлы формата: jpg,jpeg,bmp,png,gif');
                        } else {
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        }
                    });
                }
            })
        });

    });


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

</body>

@endsection
