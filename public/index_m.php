<!DOCTYPE html>
<html lang="en">
<head>

    <title>
    EN MANTENIMIENTO .
</title>

<link rel="icon" type="image/jpg" href="img/sees.png"/>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{csrf_token()}}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/buttons.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('js/dataTables.bootstrap4.min.js') }}">
  
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false&language=en"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>


<style>
    #mapa { height: 500px; }

.fakeimg {
    height: 200px;
    background: #aaa;
}

.guinda{
    color:black;
}

.guinda2{
    color:#802434;
}

.pagination{
    font-size:10px;
}
.page-item , .active{
    color:gray;
}
.letraa{
    font-size:12px;
}

.dorado{
    color:#D4AF37;
}

.colorBG{
    background-color: gray;
    color: white;
}

.colorBG2{
    background-color: #802434;
    color: white;
}

.rcorner {
  border-radius: 30px;
}

@media (min-width: 576px) {
    .tx { font-size: 8px; }
    .tx2 { font-size: 8px; }
    .anch {width:20% }
    .anchlog { width:20px; }
}
@media (min-width: 768px) {
    .tx { font-size: 10px; }
    .tx2 { font-size: 8px; }
    .anch { width:20% }
    .anchlog { width:20px; }
}
@media (min-width: 992px) {
    .tx { font-size: 10px; }
    .tx2 { font-size: 10px; }
    .anch { width:20% }
    .anchlog { width:20px; }
}
@media (min-width: 1200px) {
    .tx { font-size: 18px; }
    .tx2 { font-size: 14px; }
    .anch { width:20% }
    .anchlog { width:20px; }
}

img.zoom {
    -webkit-transition: all .2s ease-in-out;
    -moz-transition: all .2s ease-in-out;
    -o-transition: all .2s ease-in-out;
    -ms-transition: all .2s ease-in-out;
}
 
.transition {
    -webkit-transform: scale(1.8); 
    -moz-transform: scale(1.8);
    -o-transform: scale(1.8);
    transform: scale(1.8);
}
</style>

</head>
<body>

<header class="main-header"  style="border:0px;" >
    <div class="row container-fluid">
        <div class="col-12 bg-light shadow-sm" >
            <div class="d-flex-center" style='text-align:center';>

                <img src="img/log_edomex_inicio.png" class="anch img-fluid" >&nbsp;
                <b style="color:#D4AF37; font-family: Italic; font-size:40px;">  
                <i class="guinda">SEIEM</i> </b>
            </div>
        </div>
    </div>
</header>

<div class="row" style=" margin-top:30px;">
    <div class="col-sm-2">    </div>
    <div class="col-sm-8" >
        <center>
            <b class="guinda2" style="font-family: Italic; font-size:20px;">
                MANTENIMIENTO
                
            </b>
            <p>
            <img class="img-fluid" src="img/molestias.png" width="50%">
            </p>
           
             
        </center>
    </div>
    <div class="col-sm-2"></div>
</div>


<footer class="main-footer "  style="font-size:10px; margin-top:110px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-7 shadow" style="color:white; background-color:gray; border: .5px solid white;">
                <div class="flex-right" align="right">
                    <p>
                    <br><b>
                    <?php echo utf8_decode('Gobierno del Estado de México
                    <br>Secretaría de Educación
                    <br>Servicios Educativos Integrados al Estado de México
                    <br>Dirección de Informática y Telecomunicaciones
                    <br>Departamento de Desarrollo de Sistemas</b>'); ?>
                    </p>
                </div>
            </div>

            <div class="col-5 shadow" style="color:white; background-color:gray; border: .5px solid white;">
                <div class="flex-right">
                <br>
                    <a  href="https://maps.app.goo.gl/t7a9UgAZLpRxpsjv5"
                        target="_blank"
                        style="text-decoration: none; color:white;">
                        <i class="fa fa-map-marker" style="color:white;"></i>&nbsp;
                            <?php echo utf8_decode('Agripín García 1306, Santa Cruz Atzcapotzaltongo, 50030 Santiago Tlaxomulco, Méx.');?>
                    </a>
                <br>
                    <a  href="tel:+527222651600" target="_blank"
                        style="text-decoration: none; color:white;">
                        <i class="fa fa-phone"></i>&nbsp;
                        Tel: 01 (722) 279 77 00 Ext. 1101
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
                    </a>
                    <br> <b>SEIEM  | Copyright &#169; <?php echo date('Y'); ?></b>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

<script>
    $(document).ready(function(){
        $('.zoom').hover(function() {
            $(this).addClass('transition');
        }, function() {
            $(this).removeClass('transition');
        });
    });
</script>
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
  <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('js/dataTables.responsive.min.js') }}"></script>
  <script src="{{ asset('js/responsive.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('js/dataTables.buttons.min.js') }}"></script>
  <script src="{{ asset('js/buttons.bootstrap4.min.js') }}"></script>

  <script src="{{ asset('js/vfs_fonts.js') }}"></script>
  <script src="{{ asset('js/buttons.flash.min.js') }}"></script>
  <script src="{{ asset('js/buttons.html5.min.js') }}"></script>
  <script src="{{ asset('js/buttons.print.min.js') }}"></script>
  <script src="{{ asset('js/buttons.colVis.min.js') }}"></script>
  <script src="{{ asset('js/pdfmake.min.js') }}"></script>
