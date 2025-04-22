<!DOCTYPE html>
<html lang="en">
<head>

    <title>@yield('title')</title>

    <link rel="icon" type="image/jpg" href="img/e-r.png"/>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <style>
        /* Clases principales */
        .fakeimg {
            height: 200px;
            background: #aaa;
        }
        .guinda {
            color: #802434;
        }
        .dorado {
            color: #D4AF37;
        }
        .colorBG {
            background-color: #802434;
            color: white;
        }
        .custom-body {
            background: no-repeat url('img/back20.png');
            background-size: cover;
            background-attachment: fixed;
        }

        /* Responsive Fonts y Espaciados */

        @media (max-width: 576px) {
            .tx { font-size: 10px; }
            .tx2 { font-size: 10px; }
            .anch { width: 80%; }
            .anchlog { width: 30px; }
            h3 { font-size: 24px; }
            h5 { font-size: 18px; }
            p { font-size: 13px; }
            input.form-control {
                padding: 8px 15px;
                font-size: 14px;
            }
            .btn {
                padding: 8px 0px;
                font-size: 14px;
                width: 100%;
            }
        }
        @media (min-width: 577px) and (max-width: 767px) {
            .tx { font-size: 10px; }
            .tx2 { font-size: 10px; }
            .anch { width: 65%; }
            .anchlog { width: 30px; }
        }
        @media (min-width: 768px) and (max-width: 991px) {
            .tx { font-size: 12px; }
            .tx2 { font-size: 12px; }
            .anch { width: 50%; }
            .anchlog { width: 30px; }
        }
        @media (min-width: 992px) {
            .tx { font-size: 16px; }
            .tx2 { font-size: 14px; }
            .anch { width: 35%; }
            .anchlog { width: 40px; }
        }
        @media (max-width: 767px) {
            .custom-body {
                background: none;
                background-color: #ffffff;
            }
        }
    </style>

</head>

<body class="custom-body">

@yield('header')

<header class="main-header" style="border:0px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 bg-light shadow-sm">
                <div class="text-center">
                    <div class="row">
                        <div class="col-12">
                            @yield('header_img')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')

<div class="row mt-5">
    <div class="col-sm-1"></div>

    <div class="col-sm-7">
        <div class="text-center">
            @yield('header_text')
            @yield('content_img')
        </div>
        <span class="tx2 d-block text-center mt-2">
            @yield('content_text')
        </span>
    </div>

    <div class="col-sm-3">
        @yield('login')
        <br>
        @include('auth.cards')
    </div>

    <div class="col-sm-1"></div>
</div>

@yield('footer')

@yield('footer')
<footer class="main-footer" style="font-size: 12px; margin-top: 150px; background-color: #802434; color: white;">
    <div class="container-fluid py-4">
        <div class="row">

            <!-- Información institucional -->
            <div class="col-md-7 mb-3 mb-md-0 text-md-right text-center" style="border-right: 1px solid white;">
                <strong>Servicios Educativos Integrados al Estado de México</strong><br>
                <i>Dirección de Educación Elemental</i><br>
                <i>Dirección de Educación Secundaria y Servicios de Apoyo</i><br>
                <i>Dirección de Informática y Telecomunicaciones | Departamento de Desarrollo de Sistemas</i><br>
                <small>Todos los derechos reservados &copy; {{date('Y')}}</small>
            </div>

            <!-- Contacto y redes -->
            <div class="col-md-5 text-center text-md-left mt-3 mt-md-0">
                <div class="mb-2">
                    <a href="https://goo.gl/maps/FykCgWiEd7CsyMZq8" target="_blank" style="text-decoration: none; color: white;">
                        <i class="fas fa-map-marker-alt"></i> Profesor Agripín García Estrada No. 1306, Santa Cruz Atzcapotzaltongo, Toluca, México. C.P. 50030
                    </a>
                </div>
                <div class="mb-2">
                    <a href="tel:+527222651600" style="text-decoration: none; color: white;">
                        <i class="fas fa-phone-alt"></i> Tel: (722) 279 77 00 Ext. 1505
                    </a>
                </div>
                <div>
                    <a href="https://www.facebook.com/SEIedomex" target="_blank" class="mx-2" style="color: white;">
                        <i class="fab fa-facebook-square fa-lg"></i>
                    </a>
                    <a href="https://twitter.com/SEIEM_" target="_blank" class="mx-2" style="color: white;">
                        <i class="fab fa-twitter-square fa-lg"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</footer>


</body>
</html>

<script>
    $(document).ready(function() {
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "fa-eye-slash" );
                $('#show_hide_password i').removeClass( "fa-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "fa-eye-slash" );
                $('#show_hide_password i').addClass( "fa-eye" );
            }
        });
    });
</script>
