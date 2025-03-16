@extends('admin.layouts.default')

@section('styles')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    @vite(['resources/admin/js/datatable.js', 'resources/admin/sass/layouts/chapter.sass'])
@endsection

@section('main')
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

        {{-- @dd($chapter) --}}

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Главная</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.titles.index') }}">Тайтлы</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('admin.titles.show', ['slug' => $title['slug']]) }}">{{ $title['name'] }}</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $chapter['number'] }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="card-body">
                    <div class="row col-xs-12 col-xl-10 mb-4">
                        <h3>Основная информация</h3>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="titleName">Том</span>
                                <input type="text" class="form-control" placeholder="" value="{{ $chapter['volume'] }}"
                                    aria-label="Username" aria-describedby="titleName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="titleName">Глава</span>
                                <input type="text" class="form-control" placeholder="" value="{{ $chapter['number'] }}"
                                    aria-label="Username" aria-describedby="titleName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="titleName">Название</span>
                                <input type="text" class="form-control" placeholder="" value="{{ $chapter['name'] }}"
                                    aria-label="Username" aria-describedby="titleName">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="type">Переводчик</label>
                                    <select class="form-select" id="type">
                                        <option selected="">{{ $chapter['translator_branch'][0]['translator']['name'] }}
                                        </option>
                                        <option value="1">One</option>
                                        <option value="2">Two</option>
                                        <option value="3">Three</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Сохранить</button>
                        </div>
                        <div class="col-12">
                            <h3>Изображения</h3>
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                @foreach ($chapter['translator_branch'][0]['images'] as $image)
                                    <div class="accordion-item">
                                        <div class="images d-flex align-items-center">
                                            <i class="icon flex-shrink-0 bi bi-list"></i>
                                            <h2 class="accordion-header w-100" id="flush-heading-{{ $loop->index + 1 }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-collapse-{{ $loop->index + 1 }}"
                                                    aria-expanded="false"
                                                    aria-controls="flush-collapse-{{ $loop->index + 1 }}">
                                                    {{ $image }}
                                                </button>
                                            </h2>
                                            <div class="btn-group d-flex column-gap-2 ps-2" role="group"
                                                aria-label="Basic example">
                                                <a class="action-btn image-edit-btn btn icon btn-primary"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a class="action-btn image-delete-btn btn icon btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div id="flush-collapse-{{ $loop->index + 1 }}" class="accordion-collapse collapse"
                                            aria-labelledby="flush-heading-{{ $loop->index + 1 }}"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body p-0">
                                                <img class="w-100"
                                                    src="/media/{{ $chapter['path'] . $chapter['translator_branch'][0]['translator']['slug'] . '/' . $image }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
@endsection
