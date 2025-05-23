@extends('admin.layouts.auth.auth-default')

@section('head')
    <title>{{ config('app.name') }} | Сброс пароля</title>
@endsection

@section('main')
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="{{ route('admin.index') }}"><img
                                src="data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%20228%2034%22%20fill-rule%3D%22evenodd%22%20stroke-linejoin%3D%22round%22%20stroke-miterlimit%3D%222%22%20width%3D%22228%22%20height%3D%2234%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cpath%20d%3D%22M0%2027.472c0%204.409%206.18%205.552%2013.5%205.552%207.281%200%2013.5-1.103%2013.5-5.513s-6.179-5.552-13.5-5.552c-7.281%200-13.5%201.103-13.5%205.513%22%20fill%3D%22%23435ebe%22%20fill-rule%3D%22nonzero%22%2F%3E%3Ccircle%20cx%3D%2213.5%22%20cy%3D%228.8%22%20r%3D%228.8%22%20fill%3D%22%2341bbdd%22%2F%3E%3Ctext%20xml%3Aspace%3D%22preserve%22%20style%3D%22font-style%3Anormal%3Bfont-variant%3Anormal%3Bfont-weight%3A700%3Bfont-stretch%3Anormal%3Bfont-size%3A32px%3Bfont-family%3ANunito%3B-inkscape-font-specification%3A%26quot%3BNunito%2C%20Bold%26quot%3B%3Bfont-variant-ligatures%3Anormal%3Bfont-variant-caps%3Anormal%3Bfont-variant-numeric%3Anormal%3Bfont-variant-east-asian%3Anormal%3Btext-align%3Astart%3Bwriting-mode%3Alr-tb%3Bdirection%3Altr%3Btext-anchor%3Astart%3Bopacity%3A1%3Bfill%3A%23435ebe%3Bfill-opacity%3A1%3Bstroke%3A%23000%3Bstroke-width%3A.6%3Bstroke-dasharray%3Anone%3Bstroke-dashoffset%3A0%3Bstroke-opacity%3A1%3Bpaint-order%3Astroke%20markers%20fill%22%20x%3D%2234.696%22%20y%3D%2226.097%22%3E%3Ctspan%20x%3D%2234.696%22%20y%3D%2226.097%22%20style%3D%22font-style%3Anormal%3Bfont-variant%3Anormal%3Bfont-weight%3A700%3Bfont-stretch%3Anormal%3Bfont-size%3A32px%3Bfont-family%3ANunito%3B-inkscape-font-specification%3A%26quot%3BNunito%2C%20Bold%26quot%3B%3Bfont-variant-ligatures%3Anormal%3Bfont-variant-caps%3Anormal%3Bfont-variant-numeric%3Anormal%3Bfont-variant-east-asian%3Anormal%3Bstroke%3A%23435ebe%3Bstroke-width%3A.6%3Bstroke-linecap%3Asquare%3Bstroke-linejoin%3Abevel%3Bstroke-dasharray%3Anone%3Bstroke-opacity%3A1%3Bpaint-order%3Astroke%20markers%20fill%22%3EMangaSpace%3C%2Ftspan%3E%3C%2Ftext%3E%3C%2Fsvg%3E"
                                alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Сброс пароля</h1>
                    <p class="auth-subtitle mb-5"></p>

                    <form id="reset-password">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl" placeholder="Email"
                                data-parsley-required="true" data-parsley-type="email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Отправить</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class='text-gray-600'>Вспомнили пароль? <a href="{{ route('admin.login') }}"
                                class="font-bold">Авторизоваться</a>.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>

    </div>
@endsection
