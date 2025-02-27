@extends('admin.layouts.default')

@section('styles')
    @vite(['resources/admin/js/datatable.js'])
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
                    <div class="text-end mb-3">
                        <div class="col-5 col-sm-3 col-md-3 col-lg-2 d-inline-block">
                            <input type="text" id="last-name" class="form-control" name="fname" placeholder="Поиск">
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>Название</th>
                                    <th>Тип</th>
                                    <th>Статус перевода</th>
                                    <th>Статус тайтла</th>
                                    <th>Год релиза</th>
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
