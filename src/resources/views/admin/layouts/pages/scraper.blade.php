@extends('admin.layouts.default')

@section('styles')
    @vite(['resources/admin/sass/layouts/scraper.sass'])
@endsection

@section('main')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Парсер тайтлов</h3>
        </div>
        <div class="page-content">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="mangalib-tab" data-engine="mangalib" data-bs-toggle="tab"
                                href="#mangalib" role="tab" aria-controls="mangalib" aria-selected="true">Mangalib</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="remanga-tab" data-engine="remanga" data-bs-toggle="tab" href="#remanga"
                                role="tab" aria-controls="remanga" aria-selected="true" tabindex="-1">Remanga</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="mangaclub-tab" data-engine="mangaclub" data-bs-toggle="tab"
                                href="#mangaclub" role="tab" aria-controls="mangaclub" aria-selected="false"
                                tabindex="-1">MangaClub</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade active show" id="mangalib" role="tabpanel"
                            aria-labelledby="mangalib-tab">

                            <div class="card mt-4 mb-4">
                                <h4 class="mb-3">Настройка парсера</h4>
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="input-group" data-bs-toggle="tooltip"
                                                data-bs-original-title="Пример диапозона: 1..5,10..15">
                                                <span class="input-group-text" id="basic-addon1">Диапазон страниц</span>
                                                <input type="text" class="form-control" placeholder="1..5,10..15"
                                                    name="pages" aria-label="pages" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="#" class="btn btn-primary w-100" name="parseTitle">Начать
                                                парсинг</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text"
                                                        name="url">https://mangalib.me/</span>
                                                    <input type="text" class="form-control" name="pathname"
                                                        placeholder="Ссылка на тайтл" aria-label="pathname"
                                                        aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="btn btn-primary w-100" data-bs-toggle="collapse"
                                                href="#mangalibChapters" role="button" name="getChapters"
                                                aria-expanded="false" aria-controls="mangalibChapters">
                                                Получить главы
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row chapters collapse" id="mangalibChapters">
                                        <div class="card chapters">
                                            <div class="loader-layer">
                                                <img src="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20width='38'%20height='38'%20stroke='%235d79d3'%20viewBox='0%200%2038%2038'%3e%3cg%20fill='none'%20fill-rule='evenodd'%3e%3cg%20stroke-width='2'%20transform='translate(1%201)'%3e%3ccircle%20cx='18'%20cy='18'%20r='18'%20stroke-opacity='.5'/%3e%3cpath%20d='M36%2018c0-9.94-8.06-18-18-18'%3e%3canimateTransform%20attributeName='transform'%20dur='1s'%20from='0%2018%2018'%20repeatCount='indefinite'%20to='360%2018%2018'%20type='rotate'/%3e%3c/path%3e%3c/g%3e%3c/g%3e%3c/svg%3e"
                                                    alt="audio">
                                            </div>
                                            <div class="card-content">
                                                <ul class="list-group">
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col log d-flex justify-content-end">
                                                <a href="#" class="btn btn-primary me-3"
                                                    name="parseChapters">Начать
                                                    парсинг глав</a>
                                                <a href="#" class="btn btn-primary me-3"
                                                    name="selectAllChapters">Выбрать
                                                    все</a>
                                                <a href="#" class="btn btn-primary"
                                                    name="removeSelectedChapters">Убрать
                                                    все</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Результаты парсинга</div>
                            </div>
                            <div class="row titles">
                                <div class="col-lg-8">
                                    <div class="card titles">
                                        {!! $block !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row flex-column">
                                        <div class="col">
                                            <h4 class="mt-4 mb-4">Лог</h4>
                                            <div contenteditable="false" readonly class="form-control logs-textarea"
                                                style="height: 200px; overflow-y: auto">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <h4 class="mt-4 mb-4">Ошибки</h4>
                                            <ul class="list-group error-textarea"
                                                style="min-height: 200px; background-color: #151521">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="tab-pane fade" id="remanga" role="tabpanel" aria-labelledby="remanga-tab">
                            <div class="card mt-4 mb-4">
                                <h4 class="mb-3">Настройка парсера</h4>
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="input-group" data-bs-toggle="tooltip"
                                                data-bs-original-title="Пример диапозона: 1..5,10..15">
                                                <span class="input-group-text" id="basic-addon1">Диапазон страниц</span>
                                                <input type="text" class="form-control" placeholder="1..5,10..15"
                                                    name="pages" aria-label="pages" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="#" class="btn btn-primary w-100" name="parseTitle">Начать
                                                парсинг</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text"
                                                        name="url">https://remanga.org/</span>
                                                    <input type="text" class="form-control"
                                                        placeholder="Ссылка на тайтл" name="pathname"
                                                        aria-label="pathname" aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="btn btn-primary w-100" data-bs-toggle="collapse"
                                                href="#remangaChapters" role="button" name="getChapters"
                                                aria-expanded="false" aria-controls="remangaChapters">
                                                Получить главы
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row chapters collapse" id="remangaChapters">
                                        <div class="card chapters">
                                            <div class="loader-layer">
                                                <img src="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20width='38'%20height='38'%20stroke='%235d79d3'%20viewBox='0%200%2038%2038'%3e%3cg%20fill='none'%20fill-rule='evenodd'%3e%3cg%20stroke-width='2'%20transform='translate(1%201)'%3e%3ccircle%20cx='18'%20cy='18'%20r='18'%20stroke-opacity='.5'/%3e%3cpath%20d='M36%2018c0-9.94-8.06-18-18-18'%3e%3canimateTransform%20attributeName='transform'%20dur='1s'%20from='0%2018%2018'%20repeatCount='indefinite'%20to='360%2018%2018'%20type='rotate'/%3e%3c/path%3e%3c/g%3e%3c/g%3e%3c/svg%3e"
                                                    alt="audio">
                                            </div>
                                            <div class="card-content">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <input id="checkbox-1" class="form-check-input me-1"
                                                            data-url="https://remanga.org/manga/omniscient-reader"
                                                            type="checkbox" value="" aria-label="...">
                                                        <label for="checkbox-1">Cras justo odio</label>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input id="checkbox-2" class="form-check-input me-1"
                                                            data-url="https://remanga.org/manga/omniscient-reader"
                                                            type="checkbox" value="" aria-label="...">
                                                        <label for="checkbox-2">Dapibus ac facilisis in</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col log d-flex justify-content-end">
                                                <a href="#" class="btn btn-primary me-3"
                                                    name="parseChapters">Начать
                                                    парсинг глав</a>
                                                <a href="#" class="btn btn-primary me-3"
                                                    name="selectAllChapters">Выбрать
                                                    все</a>
                                                <a href="#" class="btn btn-primary"
                                                    name="removeSelectedChapters">Убрать
                                                    все</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Результаты парсинга</div>
                            </div>
                            <div class="row titles">
                                <div class="col-lg-8">
                                    <div class="card">
                                        {!! $block !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row flex-column">
                                        <div class="col">
                                            <h4 class="mt-4 mb-4">Лог</h4>
                                            <div contenteditable="false" class="form-control logs-textarea"
                                                style="height: 200px; overflow-y: auto"></div>
                                        </div>
                                        <div class="col">
                                            <h4 class="mt-4 mb-4">Ошибки</h4>
                                            <ul class="list-group error-textarea"
                                                style="min-height: 200px; background-color: #151521">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="mangaclub" role="tabpanel" aria-labelledby="mangaclub-tab">
                            <div class="card mt-4 mb-4">
                                <h4 class="mb-3">Настройка парсера</h4>
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="input-group" data-bs-toggle="tooltip"
                                                data-bs-original-title="Пример диапозона: 1..5,10..15">
                                                <span class="input-group-text" id="basic-addon1">Диапазон страниц</span>
                                                <input type="text" name="pages" class="form-control"
                                                    placeholder="1..5,10..15" aria-label="pages"
                                                    aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="#" class="btn btn-primary w-100" name="parseTitle">Начать
                                                парсинг</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-content">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="input-group">
                                                <div class="input-group mb-4">
                                                    <span class="input-group-text"
                                                        name="url">https://mangaclub.ru/</span>
                                                    <input type="text" class="form-control"
                                                        placeholder="Ссылка на тайтл" name="pathname"
                                                        aria-label="pathname" aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="btn btn-primary w-100" data-bs-toggle="collapse"
                                                href="#mangaclubChapters" role="button" name="getChapters"
                                                aria-expanded="false" aria-controls="mangaclubChapters">
                                                Получить главы
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row chapters collapse" id="mangaclubChapters">
                                        <div class="card chapters">
                                            <div class="loader-layer">
                                                <img src="data:image/svg+xml,%3csvg%20xmlns='http://www.w3.org/2000/svg'%20width='38'%20height='38'%20stroke='%235d79d3'%20viewBox='0%200%2038%2038'%3e%3cg%20fill='none'%20fill-rule='evenodd'%3e%3cg%20stroke-width='2'%20transform='translate(1%201)'%3e%3ccircle%20cx='18'%20cy='18'%20r='18'%20stroke-opacity='.5'/%3e%3cpath%20d='M36%2018c0-9.94-8.06-18-18-18'%3e%3canimateTransform%20attributeName='transform'%20dur='1s'%20from='0%2018%2018'%20repeatCount='indefinite'%20to='360%2018%2018'%20type='rotate'/%3e%3c/path%3e%3c/g%3e%3c/g%3e%3c/svg%3e"
                                                    alt="audio">
                                            </div>
                                            <div class="card-content">
                                                <ul class="list-group">
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col log d-flex justify-content-end">
                                                <a href="#" class="btn btn-primary me-3"
                                                    name="parseChapters">Начать
                                                    парсинг глав</a>
                                                <a href="#" class="btn btn-primary me-3"
                                                    name="selectAllChapters">Выбрать
                                                    все</a>
                                                <a href="#" class="btn btn-primary"
                                                    name="removeSelectedChapters">Убрать
                                                    все</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Результаты парсинга</div>
                            </div>
                            <div class="row titles">
                                <div class="col-lg-8">
                                    <div class="card">
                                        {!! $block !!}
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row flex-column">
                                        <div class="col">
                                            <h4 class="mt-4 mb-4">Лог</h4>
                                            <div contenteditable="false" class="form-control logs-textarea"
                                                style="height: 200px; overflow-y: auto"></div>
                                        </div>
                                        <div class="col">
                                            <h4 class="mt-4 mb-4">Ошибки</h4>
                                            <ul class="list-group error-textarea"
                                                style="min-height: 200px; background-color: #151521">
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

@vite(['resources/admin/js/layouts/scraper.js'])
