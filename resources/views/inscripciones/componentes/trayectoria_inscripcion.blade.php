<!-- timeline time slot -->
<li class="time-label">
<span class="bg-red">
  {{ \Carbon\Carbon::parse($inscripcion['fecha_alta'])->format('d/m/y') }}
</span>
</li>
<li>
  <i class="fa fa-user bg-blue"></i>
  <div class="timeline-item">
      <div class="timeline-body">
          <div class="row">
              <div class="col-md-12">
                  <div class="box box-widget widget-user">
                        @php
                            $headerStyle = '';
                            switch($inscripcion['centro']['nivel_servicio'])
                            {
                            case 'Común - Inicial':
                                $headerStyle = '';
                            break;
                            case 'Común - Primario':
                                $headerStyle = 'bg-info';
                            break;
                            case 'Común - Secundario':
                                $headerStyle = 'bg-primary';
                            break;
                            }
                        @endphp
                      <div class="widget-user-header {{$headerStyle}}">
                          <span class="pull-right">
                                <small>
                                    #{{ $inscripcion['id'] }}
                                </small>
                            </span>

                          <h5 class="widget-user-desc">{{ $inscripcion['tipo_inscripcion'] }}</h5>
                          <h4>{{ $inscripcion['centro']['nombre'] }}</h4>
                                  <div class="row">
                                  @foreach($inscripcion['curso'] as $curso)
                                      <div class="col-sm-2">
                                          <div>
                                              {{ $curso['anio'] }}
                                              {{ $curso['division'] }}
                                              {{ $curso['turno'] }}
                                          </div>
                                          <small>
                                              {{ $curso['tipo'] }}
                                          </small>
                                      </div>
                                  @endforeach
                                  </div>
                                  <!-- /.row -->
                      </div>
                      <!-- /.widget-user-header -->
                      <div class="box-footer no-padding">
                          <div class="row">
                              <div class="col-sm-6 border-right">
                                  <div class="description-block">
                                      <span class="description-text">{{ $inscripcion['legajo_nro'] }}</span>
                                  </div>
                                  <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              <div class="col-sm-6">
                                  <div class="description-block">
                                      <span class="description-text">{{ $inscripcion['estado_inscripcion'] }}</span>
                                  </div>
                                  <!-- /.description-block -->
                              </div>
                              <!-- /.col -->
                              @include('inscripciones.componentes.trayectoria_extra')
                          </div>
                      </div>
                      <!-- /.box-footer-->
                  </div>
                  <!-- /.box-widget -->
              </div>
              <div class="col-md-12">
                  <div class="box box-primary">
                      <div class="box-body">
                          <a href="{{ route('constancia.inscripcion',[$inscripcion['id']]) }}" class="btn btn-default btn-block" target="_blank">Constancia de Inscripción</a>
                          <a href="{{ route('constancia.regular',[$inscripcion['id']]) }}" class="btn btn-default btn-block" target="_blank">Constancia de Alumno Regular</a>
                          @if($inscripcion['ciclo']['nombre']==\Carbon\Carbon::now()->year)
                              <a href="{{ route('pases.create',['inscripcion_id'=>$inscripcion['id'],'paso'=>3]) }}" class="btn btn-default btn-block" target="_blank">Iniciar solicitud de pase</a>
                          @endif
                      </div>
                      <!-- /.box-body -->
                  </div>
              </div>
          </div>
      </div>
  </div>
</li>
<!-- END timeline slot -->
