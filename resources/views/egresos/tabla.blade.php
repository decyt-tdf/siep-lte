@php
    if(isset($data['meta'])){
        $total = $data['meta']['total'];
    } else {
        $total = $data['total'];
    }
@endphp
<div class="box">
  <div class="box-header">
      <h3 class="box-title">Registros en total: {{ $total }}</h3>
      <div class="box-tools">
          <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
              <form method="GET" action="{{ route('egresos.exportar.excel') }}">
                  <input type="hidden" name="ciclo" value="2019">
                  <input type="hidden" name="centro_id" value="19">
                  <button type="submit" class="btn btn-success"><i class="fa fa-download"></i> Exportar a excel</button>
              </form>
          </div>
      </div>
  </div>
    <!-- /.box-header -->
  <div class="box-body table-responsive no-padding">
      <table class="table table-hover table-striped table-bordered">
          <tbody><tr>
              <th>Nombre</th>
              <th>Desde</th>
              <th>Hacia</th>
              <th>Hermano</th>
          </tr>
          @foreach($data['data'] as $dt)
          <tr>
              <td>
                  <a href="{{ route('inscripciones.show',$dt['desde']['inscripcion']['id']) }}">{{ $dt['alumno']['persona']['nombre_completo'] }}</a>
                  <br>
                  DNI: {{ $dt['alumno']['persona']['documento_nro'] }}
              </td>
              <td>
                  {{ $dt['desde']['inscripcion']['tipo_inscripcion'] }}
                  <br>
                  <b>
                      {{ $dt['desde']['centro']['nombre'] }}
                  </b>
                  <br>
                  {{ $dt['desde']['curso']['anio'] }}
                  {{ $dt['desde']['curso']['division'] }}
                  {{ $dt['desde']['curso']['turno'] }}
              </td>
              <td>
                  @if(isset($dt['hacia']['centro']['nombre']))
                      {{ $dt['hacia']['inscripcion']['tipo_inscripcion'] }}
                      <br>
                      <b>
                          {{ $dt['hacia']['centro']['nombre'] }}
                      </b>
                      <br>
                      {{ $dt['hacia']['curso']['anio'] }}
                      {{ $dt['hacia']['curso']['division'] }}
                      {{ $dt['hacia']['curso']['turno'] }}
                  @else
                      <div class="callout callout-danger">
                          <h4>Error!</h4>

                          <p>
                              No fue posible obtener la inscripcion de egreso
                          </p>
                      </div>
                  @endif
              </td>
              <td>
                  @if(isset($dt['hacia']['hermano']['nombre_completo']))
                      {{ $dt['hacia']['hermano']['nombre_completo'] }}
                      <br>
                      DNI: {{ $dt['hacia']['hermano']['documento_nro'] }}
                  @endif
              </td>
          </tr>
          @endforeach
          </tbody>
      </table>

      @include('core.pagination',[
        'data' => $data
      ])
  </div>
  <!-- /.box-body -->
</div>
