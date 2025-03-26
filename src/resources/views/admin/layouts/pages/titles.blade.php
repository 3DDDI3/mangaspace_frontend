@extends('admin.layouts.default')

@section('styles')
    @vite(['resources/admin/js/layouts/titles.js', 'resources/admin/sass/layouts/titles.sass'])
@endsection

@section('main')
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        Тайтлы
                    </h5>
                </div>
                <div class="card-body">
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
                                <input type="search" name="title-search" class="form-control form-control-sm"
                                    placeholder="Поиск.." aria-controls="table2">
                            </label>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th data-field="ru_name" class="sorting">Название</th>
                                    <th data-field="category_id" class="sorting">Тип</th>
                                    <th data-field="translate_status_id" class="sorting">Статус перевода</th>
                                    <th data-field="title_status_id" class="sorting">Статус тайтла</th>
                                    <th data-field="release_year" class="sorting">Год релиза</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($titles as $title)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.titles.show', ['slug' => $title['slug']]) }}">
                                                {{ $title['name'] }}
                                            </a>
                                        </td>
                                        <td>{{ $title['type'] }}</td>
                                        <td><span class="badge bg-secondary">{{ $title['translateStatus'] }}</span></td>
                                        <td><span class="badge bg-secondary">{{ $title['titleStatus'] }}</span></td>
                                        <td>{{ $title['releaseYear'] }}</td>
                                        <td>
                                            <div class="btn-group d-flex justify-content-end column-gap-2 ps-2"
                                                role="group" aria-label="Basic example">
                                                <a href="{{ route('admin.titles.show', ['slug' => $title['slug']]) }}"
                                                    class="action-btn edit-btn btn icon btn-primary">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a data-slug="{{ $title['slug'] }}"
                                                    class="action-btn delete-btn btn icon btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $titles->onEachSide(1)->links('vendor.pagination.datatable-bootstrap-5') }}
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
