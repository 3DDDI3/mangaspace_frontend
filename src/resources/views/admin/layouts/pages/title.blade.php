@extends('admin.layouts.default')

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    @vite(['resources/admin/sass/layouts/title.sass', 'resources/admin/js/layouts/title.js'])
@endsection

@section('main')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>
        <div id="editor-container"></div>
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
                    <div class="row col-xxl-8 col-lg-12 mb-4">
                        <h3>Основная информация</h3>
                        <div class="col-4 mb-3">
                            <h5 class="form-span fw-bolder mt-2">Обложки</h5>
                            <div class="col-12 covers-wrapper">
                                <div class="btn-group-vertical" role="group" aria-label="Basic example">
                                    <a class="action-btn image-edit-btn btn icon btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModalCenter">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a class="action-btn image-delete-btn btn icon btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                                <div class="swiper cover-slider">
                                    <div class="swiper-wrapper">
                                        @foreach ($title['covers'] as $cover)
                                            <div class="swiper-slide">
                                                <img class="cover d-block w-100" data-image-id="{{ $cover['id'] }}"
                                                    src="/media/{{ $cover['path'] }}" alt="{{ $title['name'] }}">
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-scrollbar"></div>
                                </div>
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
                                        @foreach ($categories as $category)
                                            @if ($title['type'] == $category)
                                                <option selected value="{{ $category['id'] }}">
                                                    {{ $category['category'] }}
                                                </option>
                                            @endif
                                        @endforeach
                                        @foreach ($categories as $category)
                                            @if ($title['type'] != $category)
                                                <option value="{{ $category['id'] }}">{{ $category['category'] }}
                                                </option>
                                            @endif
                                        @endforeach
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
                                        @foreach ($titleStatuses as $titleStatus)
                                            @if ($titleStatus['status'] == $title['titleStatus'])
                                                <option selected value="{{ $titleStatus['id'] }}">
                                                    {{ $titleStatus['status'] }}
                                                </option>
                                            @endif
                                        @endforeach
                                        @foreach ($titleStatuses as $titleStatus)
                                            @if ($titleStatus['status'] != $title['titleStatus'])
                                                <option value="{{ $titleStatus['id'] }}">{{ $titleStatus['status'] }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 mb-4">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="translators">Переводчики</label>
                                    <select id="translators" class="choices form-select multiple-remove" disabled="disabled"
                                        multiple="multiple">
                                        @foreach ($translators as $translator)
                                            <option {{ $currentTranslators->contains($translator) ? 'selected' : null }}
                                                value="{{ $translator['id'] }}">
                                                {{ $translator['name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="translateStatus">Статус перевода</label>
                                    <select class="form-select" id="translateStatus">
                                        @foreach ($translateStatuses as $translateStatus)
                                            <option
                                                {{ $title['translateStatus'] == $translateStatus['status'] ? 'selected' : null }}
                                                value="{{ $translateStatus['id'] }}">{{ $translateStatus['status'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="releaseYear">Год релиза</label>
                                    <select class="form-select" id="releaseYear">
                                        @for ($i = (int) \Carbon\Carbon::now()->subYears(50)->format('Y'); $i < (int) \Carbon\Carbon::now()->format('Y'); $i++)
                                            <option {{ $title['releaseYear'] == $i ? 'selected' : null }}
                                                value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Сохранить</button>
                        </div>
                        <div class="col-12">
                            <h3>Главы</h3>
                            <div class="row mb-4">
                                <div class="col-4">
                                    <label class="table-record-header-wrapper" for="table-record-header">
                                        Показывать
                                        <select aria-controls="table-record-header" id="table-record-header"
                                            class="form-select form-select-sm">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                        записей
                                    </label>
                                </div>
                                <div class="col-8 d-flex justify-content-end">
                                    <label>
                                        <input type="search" name="chapter-search" class="form-control form-control-sm"
                                            placeholder="Поиск.." aria-controls="table2">
                                    </label>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped mb-0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th data-field="number" class="sorting">Глава</th>
                                            <th data-field="volume" class="sorting">Том</th>
                                            <th data-field="name" class="sorting ">Название</th>
                                            <th data-field="created_at" class="sorting">Дата добавления</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($chapters as $chapter)
                                            <tr>
                                                <td>
                                                    <div class="btn-group d-flex justify-content-center" role="group"
                                                        aria-label="Basic example">
                                                        <i class="icon sorting-button flex-shrink-0 bi bi-list"></i>
                                                    </div>
                                                </td>
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

        <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Редактирование изображения
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="uppy-dashboard"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Закрыть</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

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
