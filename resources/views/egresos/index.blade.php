@extends('core.layout')

@section('contenido')
     <!-- Breadcrumb -->
      <section class="content-header">
        <h1>
          Alumnos egresados
          <small>ciclo {{ $ciclo }}</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-home"></i> Ver</a></li>
          <li class="active">Egresos</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
          <div class="row">
              <div class="col-md-9">
                  @include('egresos.tabla',['data'=>$egresos])
              </div>
              <div class="col-md-3">
                  @include('sidebar_filtros',[
                    'action' => route('egresos.index')
                  ])
                  <!-- /. box -->
              </div>
          </div>
      </section>
      <!-- /.content -->
@endsection
