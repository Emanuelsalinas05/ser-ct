@extends('layouts.app')

{{-- Customize layout sections --}}
@section('title', 'ORGANIZACIÓN DE CENTROS DE TRABAJO')
@section('content_header_title', 'Home')
@section('content_header_subtitle', ' ORGANIZACIÓN DE CENTROS DE TRABAJO')

{{-- Content body: main page content --}}

@section('content')
<div class="col-12 card card-secondary card-outline shadow" >
    <div class="card-header bg-light shadow-sm d-flex mb-2">
        <div class="d-flex justify-content-between">
            <b><i class="nav-icon fa fa-folder-open"></i>&nbsp;
                ORGANIZACIÓN DE CENTROS DE TRABAJO 
            </b> 
        </div>
    </div>
    <div class="card-body table-responsive">
        




<link href="cdnjs.cloudflare.com/ajax/libs/twitter-boo…" rel="stylesheet">
<link rel="stylesheet" href="use.fontawesome.com/releases/v5.7.0/css/al…" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="cdnjs.cloudflare.com/ajax/libs/jquery/3.4.…"></script>


        <div class="row">
            <div class="col-md-12">
                <ul id="tree1" class="text-info">
                    @foreach($sectores  as $key  => $ctsector)
                    <li>
                        <a>{{ $ctsector->cct_sector }} - {{ $ctsector->ctsec->onombre_ct }}</a>

                        @foreach($superviciones  as $key  => $ctsupervision)
                        @if($ctsupervision->idcct_sector==$ctsector->idcct_sector)
                        <ul>
                            
                            <li>
                                {{ $ctsupervision->cct_supervision }} - {{ $ctsupervision->ctsup->onombre_ct }}
                                
                                <ul class="text-dark">
                                    <li>
                                        VER ESCUELAS
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        @endif
                        @endforeach
                    </li>
                    @endforeach
                </ul>
            </div>
<!--
            <div class="col-md-4">
                  <ul id="tree2">
                    <li>
                        <a >TECH</a>
                        <ul>
                            <li>Company Maintenance</li>
                            <li>
                                Employees
                                <ul>
                                    <li>
                                        Reports
                                        <ul>
                                           <li>Report1</li>
                                           <li>Report2</li>
                                           <li>Report3</li>
                                        </ul>
                                    </li>
                                    <li>Employee Maint.</li>
                                </ul>
                            </li>
                            <li>Human Resources</li>
                        </ul>
                    </li>
                </ul>
            </div>
        -->
        </div>

<script>
$.fn.extend({
    treed: function (o) {

      var openedClass = 'fa-minus-circle';
      var closedClass = 'fa-plus-circle';

      if (typeof o != 'undefined'){
        if (typeof o.openedClass != 'undefined'){
        openedClass = o.openedClass;
        }
        if (typeof o.closedClass != 'undefined'){
        closedClass = o.closedClass;
        }
      };

        //initialize each of the top levels
        var tree = $(this);
        tree.addClass("tree");
        tree.find('li').has("ul").each(function () {
            var branch = $(this); //li with children ul
            branch.prepend("<i class='indicator fas " + closedClass + "'></i>");
            branch.addClass('branch');
            branch.on('click', function (e) {
                if (this == e.target) {
                    var icon = $(this).children('i:first');
                    icon.toggleClass(openedClass + " " + closedClass);
                    $(this).children().children().toggle();
                }
            })
            branch.children().children().toggle();
        });
        //fire event from the dynamically added icon
      tree.find('.branch .indicator').each(function(){
        $(this).on('click', function () {
            $(this).closest('li').click();
        });
      });
        //fire event to open branch if the li contains an anchor instead of text
        tree.find('.branch>a').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
        //fire event to open branch if the li contains a button instead of text
        tree.find('.branch>button').each(function () {
            $(this).on('click', function (e) {
                $(this).closest('li').click();
                e.preventDefault();
            });
        });
    }
});

//Initialization of treeviews

$('#tree1').treed();

$('#tree2').treed({openedClass:'fa-folder-open', closedClass:'fa-folder'});

</script>



        
    </div>
</div>
@stop