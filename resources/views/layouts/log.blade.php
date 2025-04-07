<!DOCTYPE html>
<html lang="en">
<head>

    <title>
    @yield('title')
</title>

<link rel="icon" type="image/jpg" href="img/e-r.png"/>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{csrf_token()}}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
.fakeimg {
    height: 200px;
    background: #aaa;
}

.guinda{
    color:#802434;
}

.dorado{
    color:#D4AF37;
}

.colorBG{
    background-color: #802434;
    color: white;
}



@media (min-width: 576px) {
    .tx { font-size: 8px; }
    .tx2 { font-size: 8px; }
    .anch {width:65% }
    .anchlog { width:30px; }
}
@media (min-width: 768px) {
    .tx { font-size: 10px; }
    .tx2 { font-size: 8px; }
    .anch { width:35% }
    .anchlog { width:30px; }
}
@media (min-width: 992px) {
    .tx { font-size: 10px; }
    .tx2 { font-size: 10px; }
    .anch { width:35% }
    .anchlog { width:30px; }
}
@media (min-width: 1200px) {
    .tx { font-size: 18px; }
    .tx2 { font-size: 14px; }
    .anch { width:35% }
    .anchlog { width:50px; }
}
</style>
</head>
<body style="background: no-repeat url('img/back20.png'); background-size: cover ; background-attachment: fixed;  ;">

@yield('header')
<header class="main-header"  style="border:0px;" >
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 bg-light shadow-sm" >
                <div class="d-flex-center" style='text-align:center';>
                    <div class="row">
                        <div class="prueba col-12 col-lg-12">
                            @yield('header_img')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@yield('content')
<div class="row" style=" margin-top:100px;">
    <div class="col-sm-1">    </div>
    <div class="col-sm-7 " >
        <div class="flex-right">
            <center>
                @yield('header_text')
                @yield('content_img')
            </center>
            <span class="tx2">
                @yield('content_text')
            </span>
        </div>
        <center>
           
    </div>
    <div class="col-sm-3">
        @yield('login')
        <br>
         @include('auth.cards')
    </div>
    <div class="col-sm-1">    </div>
</div>


@yield('footer')
<footer class="main-footer "  style="font-size:10px; margin-top:150px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-7 shadow" style="color:white; background-color:#802434; border: .5px solid white;">
                <div class="flex-right" align="right">
                    <br>
                    <b>Servicios Educativos Integrados al Estado de México</b>
                    <br>
                    <i>Dirección de Educación Elemental</i>
                    <br>
                    <i>Dirección de Educacion Secundaria y Servicios de Apoyo</i>
                    <br>
                    <b><i>Dirección de Informática y Telecomunicaciones | Departamento de Desarrollo de Sistemas</i></b>
                    <br>
                    <span style="font-size:10px;">
                        Todos los derechos reservados &copy; {{date('Y')}}
                    </span> 
                </div>
            </div>

            <div class="col-5 shadow" style="color:white; background-color:#802434; border: .5px solid white;">
                <div class="flex-right">
                <br>
                    <a  href="https://goo.gl/maps/FykCgWiEd7CsyMZq8"
                        target="_blank"
                        style="text-decoration: none; color:white;">
                        <i class="fa fa-map-marker" style="color:white;"></i>&nbsp;
                            Profesor Agripín Garcia Estrada No. 1306<br>
                            Santa Cruz Atzcapotzaltongo. Toluca, México. C.P. 50030
                    </a>
                <br>
                    <a  href="tel:+527222651600" target="_blank"
                        style="text-decoration: none; color:white;">
                        <i class="fa fa-phone"></i>&nbsp;
                        Tel: 01 (722) 279 77 00 Ext. 1505
                    <br>
                    <a  class="tx"
                        href="https://www.facebook.com/SEIedomex/?ref=ts&amp%3Bfref=ts"
                        target="_blank"
                        style="text-decoration: none; color:white;">
                        <i class="fa fa-facebook-square"></i>
                    </a>
                    <a  class="tx"
                        href="https://twitter.com/SEIEM_"
                        target="_blank"
                        style="text-decoration: none; color:white;">
                        <i class="fa fa-twitter-square"></i>
                    </a>&nbsp;&nbsp;                    
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
