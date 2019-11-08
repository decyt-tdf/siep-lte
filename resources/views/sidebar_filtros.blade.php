<div class="box box-solid">
    <form method="GET" action="{{ $action }}">
    <div class="box-header with-border">
        <h3 class="box-title">Filtros</h3>
    </div>
    <div class="box-body">
        <div class="form-group">
            <label>Centro</label>
            @include('ui.componente.autocomplete_centros',['name'=>'centro_id'])
        </div>

        <div class="form-group">
            <label>Ciclo</label>
            <select name="ciclo" class="form-control">
                <option value="">- Seleccionar ciclo -</option>
                <option value="2017" {{ (request('ciclo')=='2017')  ? ' selected=selected' : ''}}>2017</option>
                <option value="2018" {{ (request('ciclo')=='2018')  ? ' selected=selected' : ''}}>2018</option>
                <option value="2019" {{ (request('ciclo')=='2019')  ? ' selected=selected' : ''}}>2019</option>
                <option value="2020" {{ (request('ciclo')=='2020')  ? ' selected=selected' : ''}}>2020</option>
            </select>
        </div>

        <div class="form-group">
            <label>Nivel de servicio</label>
            <select name="nivel_servicio" class="form-control">
                <option value="">- Seleccionar nivel de servicio -</option>
                <option value="Común - Inicial" {{ (request('nivel_servicio')=='Común - Inicial')  ? ' selected=selected' : ''}}>Común - Inicial</option>
                <option value="Común - Primario" {{ (request('nivel_servicio')=='Común - Primario')  ? ' selected=selected' : ''}}>Común - Primario</option>
                <option value="Común - Secundario" {{ (request('nivel_servicio')=='Común - Secundario')  ? ' selected=selected' : ''}}>Común - Secundario</option>
            </select>
        </div>

        <div class="form-group">
            <label>Sector</label>
            <select name="sector" class="form-control">
                <option value="">- Seleccionar sector -</option>
                <option value="ESTATAL" {{ (request('sector')=='ESTATAL')  ? ' selected=selected' : ''}}>ESTATAL</option>
                <option value="PRIVADO" {{ (request('sector')=='PRIVADO')  ? ' selected=selected' : ''}}>PRIVADO</option>
            </select>
        </div>

        <div class="form-group">
            <label>Division</label>
            <select name="division" class="form-control">
                <option value="">- Seleccionar division -</option>
                <option value="con" {{ (request('division')=='con')  ? ' selected=selected' : ''}}>Con division</option>
                <option value="sin" {{ (request('division')=='sin')  ? ' selected=selected' : ''}}>Sin division</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ciudad</label>
            <select name="ciudad" class="form-control">
                <option value="" >- Seleccionar ciudad -</option>
                <option value="ushuaia" {{ (request('ciudad')=='ushuaia')  ? ' selected=selected' : ''}}>Ushuaia</option>
                <option value="tolhuin" {{ (request('ciudad')=='tolhuin')  ? ' selected=selected' : ''}}>Tolhuin</option>
                <option value="rio grande" {{ (request('ciudad')=='rio grande')  ? ' selected=selected' : ''}}>Rio Grande</option>
            </select>
        </div>

        <div class="form-group">
            <label>Estado inscripcion</label>
            <select name="estado_inscripcion" class="form-control">
                <option value="">- Seleccionar estado de inscripcion -</option>
                <option value="CONFIRMADA" {{ (request('estado_inscripcion')=='CONFIRMADA')  ? ' selected=selected' : ''}}>CONFIRMADA</option>
                <option value="NO CONFIRMADA" {{ (request('estado_inscripcion')=='NO CONFIRMADA')  ? ' selected=selected' : ''}}>NO CONFIRMADA</option>
                <option value="BAJA" {{ (request('estado_inscripcion')=='BAJA')  ? ' selected=selected' : ''}}>BAJA</option>
            </select>
        </div>


        <div class="form-group">
            <label>Año</label>
            <select name="anio" class="form-control">
                <option value="" >- Seleccionar año -</option>
                <option value="1ro" {{ (request('anio')=='1ro')  ? ' selected=selected' : ''}}>1ro</option>
                <option value="2do" {{ (request('anio')=='2do')  ? ' selected=selected' : ''}}>2do</option>
                <option value="3ro" {{ (request('anio')=='3ro')  ? ' selected=selected' : ''}}>3ro</option>
                <option value="4to" {{ (request('anio')=='4to')  ? ' selected=selected' : ''}}>4to</option>
                <option value="5to" {{ (request('anio')=='5to')  ? ' selected=selected' : ''}}>5to</option>
                <option value="6to" {{ (request('anio')=='6to')  ? ' selected=selected' : ''}}>6to</option>
            </select>
        </div>

        <div class="form-group">
            <label>Turno</label>
            <select name="turno" class="form-control">
                <option value="" >- Seleccionar turno -</option>
                <option value="mañana" {{ (request('turno')=='mañana')  ? ' selected=selected' : ''}}>Mañana</option>
                <option value="tarde" {{ (request('turno')=='tarde')  ? ' selected=selected' : ''}}>Tarde</option>
                <option value="noche" {{ (request('turno')=='noche')  ? ' selected=selected' : ''}}>Noche</option>
            </select>
        </div>

        <div class="form-group">
	    <label>Vacantes</label>
            <select name="vacantes" class="form-control">
                <option value="" >- Seleccionar filtro -</option>
                <option value="con" {{ (request('vacantes')=='con')  ? ' selected=selected' : ''}}>Con vacantes</option>
                <option value="sin" {{ (request('vacantes')=='sin')  ? ' selected=selected' : ''}}>Sin vacantes</option>
            </select>
        </div>

    </div>
    <!-- /.box-body -->
    <div class="box-footer">
        <button type="submit" class="btn btn-success pull-right">Aplicar</button>
    </div>
    <!-- /.box-footer-->
    </form>
</div>
