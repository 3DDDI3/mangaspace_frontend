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
                <div class="card-header">asd</div>
                <div class="card-body">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="mangalib-tab" data-bs-toggle="tab" href="#mangalib"
                                role="tab" aria-controls="mangalib" aria-selected="true">Mangalib</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                aria-controls="profile" aria-selected="true" tabindex="-1">Profile</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#contact" role="tab"
                                aria-controls="contact" aria-selected="false" tabindex="-1">Contact</a>
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
                                                    aria-label="Username" aria-describedby="basic-addon1">
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <a href="#" class="btn btn-primary w-100">Начать парсинг</a>
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
                                                    <span class="input-group-text" id="basic-addon1">https://</span>
                                                    <input type="text" class="form-control" placeholder="Ссылка на тайтл"
                                                        aria-label="Username" aria-describedby="basic-addon1">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2">
                                            <a class="btn btn-primary w-100" data-bs-toggle="collapse"
                                                href="#collapseExample" role="button" aria-expanded="false"
                                                aria-controls="collapseExample">
                                                Получить главы
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row chapters collapse" id="collapseExample">
                                        <div class="card">
                                            <div class="card-content">
                                                <ul class="list-group">
                                                    <li class="list-group-item">
                                                        <input id="checkbox-1" class="form-check-input me-1" type="checkbox"
                                                            value="" aria-label="...">
                                                        <label for="checkbox-1">Cras justo odio</label>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input id="checkbox-2" class="form-check-input me-1"
                                                            type="checkbox" value="" aria-label="...">
                                                        <label for="checkbox-2">Dapibus ac facilisis in</label>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input id="checkbox-3" class="form-check-input me-1"
                                                            type="checkbox" value="" aria-label="...">
                                                        <label for="checkbox-3">Morbi leo risus</label>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input id="checkbox-4" class="form-check-input me-1"
                                                            type="checkbox" value="" aria-label="...">
                                                        <label for="checkbox-4">Porta ac consectetur ac</label>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input id="checkbox-5" class="form-check-input me-1"
                                                            type="checkbox" value="" aria-label="...">
                                                        <label for="checkbox-5">Vestibulum at eros</label>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input id="checkbox-6" class="form-check-input me-1"
                                                            type="checkbox" value="" aria-label="...">
                                                        <label for="checkbox-6">Vestibulum at eros</label>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <input id="checkbox-7" class="form-check-input me-1"
                                                            type="checkbox" value="" aria-label="...">
                                                        <label for="checkbox-7">Vestibulum at eros</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col log d-flex justify-content-end">
                                                <a href="#" class="btn btn-primary me-3">Выбрать все</a>
                                                <a href="#" class="btn btn-primary">Убрать все</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="divider">
                                <div class="divider-text">Результаты парсинга</div>
                            </div>
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="card">
                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingOne">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                                        aria-expanded="false" aria-controls="flush-collapseOne">
                                                        Accordion Item #1
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseOne" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingOne"
                                                    data-bs-parent="#accordionFlushExample" style="">
                                                    <div class="accordion-body">Placeholder content for this
                                                        accordion, which is intended to demonstrate the
                                                        <code>.accordion-flush</code> class. This is the first
                                                        item's accordion body.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingTwo">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                                        aria-expanded="false" aria-controls="flush-collapseTwo">
                                                        Accordion Item #2
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingTwo"
                                                    data-bs-parent="#accordionFlushExample" style="">
                                                    <div class="accordion-body">
                                                        <h4 class="mb-2 mt-2">Главы</h4>
                                                        <div class="accordion accordion-flush" id="accordionFlush">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="flush-heading">
                                                                    <button class="accordion-button collapsed"
                                                                        type="button" data-bs-toggle="collapse"
                                                                        data-bs-target="#flush-collapse"
                                                                        aria-expanded="false"
                                                                        aria-controls="flush-collapse">
                                                                        Главы
                                                                    </button>
                                                                </h2>
                                                                <div id="flush-collapse"
                                                                    class="accordion-collapse collapse"
                                                                    aria-labelledby="flush-heading"
                                                                    data-bs-parent="#accordionFlush" style="">
                                                                    <div class="accordion-body">Placeholder content for
                                                                        this
                                                                        accordion, which is intended to demonstrate the
                                                                        <code>.accordion-flush</code> class. This is the
                                                                        first
                                                                        item's accordion body.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="flush-headingThree">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                                        aria-expanded="false" aria-controls="flush-collapseThree">
                                                        Accordion Item #3
                                                    </button>
                                                </h2>
                                                <div id="flush-collapseThree" class="accordion-collapse collapse"
                                                    aria-labelledby="flush-headingThree"
                                                    data-bs-parent="#accordionFlushExample" style="">
                                                    <div class="accordion-body">Placeholder content for this
                                                        accordion, which is intended to demonstrate the
                                                        <code>.accordion-flush</code> class. This is the third
                                                        item's accordion body. Nothing more exciting happening here
                                                        in terms of content, but just filling up the space to make
                                                        it look, at least at first glance, a bit more representative
                                                        of how this would look in a real-world application.
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="row flex-column">
                                        <div class="col">
                                            <h4 class="mt-4 mb-4">Лог</h4>
                                            <textarea class="form-control logs-textarea" rows="8"></textarea>
                                        </div>
                                        <div class="col">
                                            <h4 class="mt-4 mb-4">Ошибки</h4>
                                            <ul class="list-group">
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span> Biscuit jelly beans macaroon danish pudding.</span>
                                                    <span class="badge bg-warning badge-pill badge-round ms-1">
                                                        <i class="bi bi-exclamation-triangle"></i>
                                                    </span>
                                                </li>
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <span> Oat cake icing pastry pie carrot</span>
                                                    <span class="badge bg-danger badge-pill badge-round ms-1">
                                                        <i class="bi bi-exclamation-circle"></i>
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            Integer interdum diam eleifend metus lacinia, quis gravida eros mollis. Fusce non sapien
                            sit amet magna dapibus
                            ultrices. Morbi tincidunt magna ex, eget faucibus sapien bibendum non. Duis a mauris ex.
                            Ut finibus risus sed massa
                            mattis porta. Aliquam sagittis massa et purus efficitur ultricies. Integer pretium dolor
                            at sapien laoreet ultricies.
                            Fusce congue et lorem id convallis. Nulla volutpat tellus nec molestie finibus. In nec
                            odio tincidunt eros finibus
                            ullamcorper. Ut sodales, dui nec posuere finibus, nisl sem aliquam metus, eu accumsan
                            lacus felis at odio. Sed lacus
                            quam, convallis quis condimentum ut, accumsan congue massa. Pellentesque et quam vel
                            massa pretium ullamcorper vitae eu
                            tortor.
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            <p class="mt-2">Duis ultrices purus non eros fermentum hendrerit. Aenean ornare interdum
                                viverra. Sed ut odio velit. Aenean eu diam
                                dictum nibh rhoncus mattis quis ac risus. Vivamus eu congue ipsum. Maecenas id
                                sollicitudin ex. Cras in ex vestibulum,
                                posuere orci at, sollicitudin purus. Morbi mollis elementum enim, in cursus sem
                                placerat ut.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer>
            <div class="footer clearfix mb-0 text-muted">
                <div class="float-start">
                    <p>2023 &copy; Mazer</p>
                </div>
                <div class="float-end">
                    <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                        by <a href="https://saugi.me">Saugi</a></p>
                </div>
            </div>
        </footer>
    </div>
@endsection
