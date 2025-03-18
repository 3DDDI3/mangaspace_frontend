@extends('admin.layouts.default')

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    @vite(['resources/admin/sass/layouts/title.sass', 'resources/admin/js/layouts/title.js'])
@endsection

@section('main')
    </script>
    {{-- <div id="image-container">
        <img src="{{ asset('media/Vsevedushchy chitatel/1/224/1_1.webp') }}" alt="Image" id="clickable-image"
            style="cursor: pointer; max-width: 100%;">
    </div> --}}

    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>
                {{ $title['name'] }}
            </h3>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Главная</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.titles.index') }}">Тайтлы</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title['name'] }}</li>
                        </ol>
                    </nav>

                </div>
                <div class="card-body">
                    <div class="row col-8 mb-4">
                        <h3>Основная информация</h3>
                        <div class="col-4 mb-3">
                            <span class="form-span fw-bolder">Обложки</span>
                            <div class="swiper">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <img class="d-block w-100 pt-2" id="clickable-image"
                                            src="/media/{{ $title['covers'][0]['path'] }}" alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img class="d-block w-100 pt-2" src="/media/{{ $title['covers'][0]['path'] }}"
                                            alt="">
                                    </div>
                                    <div class="swiper-slide">
                                        <img class="d-block w-100 pt-2" src="/media/{{ $title['covers'][0]['path'] }}"
                                            alt="">
                                    </div>
                                </div>
                                <div class="swiper-button-prev"></div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-scrollbar"></div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="titleName">Название тайтла</span>
                                <input type="text" class="form-control" placeholder="" value="{{ $title['name'] }}"
                                    aria-label="Username" aria-describedby="titleName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="type">Тип тайтла</label>
                                    <select class="form-select" id="type">
                                        <option selected="">{{ $title['type'] }}</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="type">Переводчик</label>
                                    <select class="form-select" id="type">

                                        <option selected="">{{ $title['type'] }}</option>
                                        {{-- @foreach ($tranlators as $tranlator)
                                            <option value="{{ $translator['id'] }}">{{ $translator['name'] }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1" class="form-label">Альтерантивные
                                    названия</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $title['description'] }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1" class="form-label">Описание</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3">{{ $title['description'] }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="titleStatus">Статус тайтла</label>
                                    <select class="form-select" id="titleStatus">
                                        <option selected="">{{ $title['titleStatus'] }}</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <select class="choices form-select multiple-remove" multiple="multiple">
                                    @foreach ($translators as $translator)
                                        <option value="{{ $translator['id'] }}">{{ $translator['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="translateStatus">Статус перевода</label>
                                    <select class="form-select" id="translateStatus">
                                        <option>{{ $title['translateStatus'] }}</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="releaseYear">Год релиза</label>
                                    <select class="form-select" id="releaseYear">
                                        <option selected="">{{ $title['releaseYear'] }}</option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Сохранить</button>
                        </div>
                        <div class="col-12">
                            <h3>Главы</h3>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th>Глава</th>
                                            <th>Том</th>
                                            <th class="w-50">Название</th>
                                            <th>Дата добавления</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($chapters as $chapter)
                                            <tr>
                                                <td>
                                                    <a
                                                        href="{{ route('admin.titles.chapter.index', ['slug' => $title['slug'], 'chapter' => $chapter['number']]) }}">
                                                        {{ $chapter['number'] }}
                                                    </a>
                                                </td>
                                                <td>{{ $chapter['volume'] }} </td>
                                                <td>{{ $chapter['name'] }}</td>
                                                <td>{{ $chapter['created_at'] }}</td>
                                                <td>
                                                    <div class="btn-group d-flex justify-content-end column-gap-2 ps-2"
                                                        role="group" aria-label="Basic example">
                                                        <a href="{{ route('admin.titles.chapter.index', ['slug' => $title['slug'], 'chapter' => $chapter['number']]) }}"
                                                            class="action-btn edit-btn btn icon btn-primary">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <a class="action-btn delete-btn btn icon btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{ $chapters->onEachSide(1)->links('vendor.pagination.datatable-bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>{{ \Carbon\Carbon::now()->format('Y') }} &copy; Mangaspace.ru</p>
                </div>
                <div class="float-end">
                    <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                        by <a href="https://saugi.me">Saugi</a></p>
                </div>
            </div>
        </footer>
    </div>
@endsection
