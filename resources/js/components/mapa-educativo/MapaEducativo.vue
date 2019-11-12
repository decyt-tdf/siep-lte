<template >
  <div id="top" class="align-content-space-between justify-center" >
    <div class="row">
      <div class="col-xs-12 col-md-12 col-lg-4 col-xl-4">
        <div class="row">
          <div class="col-xs12 col-md-12 col-lg-12 col-xl-12 space-between">
            <select-api-forms 
            v-model="filtro.nombre" 
            form="centros" 
            placeholder="-- Busque por Nombre de Institución --" 
            custom="nombre"/>
          </div>
          <div class="text-center col-xs12 col-md-12 col-lg-12 col-xl-12 space-between">
            <label>Si lo desea, además puede utilizar los filtros</label>
          </div>
          <div class="col-xs12 col-md-12 col-lg-12 col-xl-12 space-between">
            <v-select 
            v-model="filtro.ciudad"
            :options="combo_ciudades_api"
            label="nombre"
            placeholder="-- Seleccione Ubicación --">
            </v-select>
          </div>
          <div class="col-xs12 col-md-12 col-lg-12 col-xl-12 space-between">
            <v-select 
            v-model="filtro.nivel_servicio"
            :options="combo_niveles"
            label="nombre"
            placeholder="-- Seleccione Nivel --">
            </v-select>
          </div>
          <div class="col-xs12 col-md-12 col-lg-12 col-xl-12 space-between">
            <v-select 
            v-model="filtro.sector"
            :options="combo_sectores"
            label="nombre"
            placeholder="-- Seleccione Sector --">
            </v-select>
          </div>
          <div class="col-xs12 col-md-12 col-lg-12 col-xl-12 space-between">
            <v-select
            v-model="filtro.ambito"
            :options="combo_ambito"
            label="nombre"
            placeholder="-- Seleccione Ambito --">
            </v-select>
          </div>
          <div class="col-xs12 col-md-12 col-lg-12 col-xl-12 space-between">
            <button type="button" class="btn btn-success btn-block" @click="findInstitution()" :disabled="searching">
              <i v-if="searching" class="fa fa-refresh fa-spin"></i>
              <i v-else class="fa fa-search"></i>
              Buscar
            </button>
          </div>
          <hr>
          <div class="col-xs12 col-md-12 col-lg-12 col-xl-12 space-between">
            <div class="row" style="margin:0 5px 0 5px;">
              <!-- Resultados de busqueda -->
              <div class="box">
                <div class="box-body scrollable-content">
                  <div v-for="item in resultado" :key="item.id" class="col-xs12 col-md-12 col-lg-12 col-xl-12 space-between">
                    <ul class="nav nav-stacked">
                      <li>
                        <div>
                          <strong>CUE Anexo:</strong> {{ item.cue }} - {{ item.nombre }}
                        </div>
                        <div>
                          <button class="btn bg-purple btn-block" @click="showCenterInfo(item)">Ver en Mapa</button>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
                    <!-- <v-list dense>
                      <h3 class="subheading mb-0 align-start"><strong>CUE Anexo: </strong>{{ item.cue }} - {{ item.nombre }}</h3>
                    </v-list> -->
                    <!-- <v-btn  v-scroll-to="{
                      el: '#maps',
                      duration: 500,
                      easing: 'ease-in-out',
                      offset: -50,
                      force: true,
                      cancelable: true,
                      onStart: function(element) {
                        showCenterInfo(item);
                      },
                      x: false,
                      y: true
                    }"
                      outline color="indigo">
                      Ver En Mapa
                    </v-btn> -->
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-12 col-lg-8 col-xl-8">
        <!-- Google Maps -->
        <div id="maps" ref="maps">
          <google-map :coords="coords" :markers_array="markers"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  // import * as easings from 'vuetify/es5/util/easing-patterns'

  import GoogleMap from "./GoogleMaps"
  import SelectApiForms from './selectbox'
  import instituciones from '../../store/model/instituciones'


  export default {
    components: { GoogleMap, SelectApiForms },
    mounted: function(){
      this.fillLocations();
      this.onResize();
    },
    data: ()=>({
      isMobile:false,
      coords:{
        latitud: -68.2746,
        longitud: -68.3186003,
      },
      markers:[],
      selected: 'Button',
      elements: ['Button', 'Radio group'],
      duration: 800,
      offset: -10,
      easing: 'easeInOutCubic',
      error:"",
      searching:false,
      headers:['Nombre'],
      hidden:false,
      apigw: process.env.SIEP_API_GW_INGRESS || 'http://localhost:7777',
      filtro:{},
      resultado:[],
      findCentroRunning:false,
      centro_nombre:"",
      combo_ciudades_api:[],
      combo_ciudades_searching:false,
      combo_niveles: ['Maternal - Inicial','Común - Inicial','Común - Primario','Adultos - Primario','Común - Secundario','Adultos - Secundario', 'Común - Superior'],
      combo_sectores:["ESTATAL","PRIVADO"],
      combo_ambito: ['Rural', 'Urbano'],
      dialog_ops:{
        dialog: false,
        buttonName:"",
        dialogTitle:"Información del Centro",
        dialogContent:instituciones,
        icon:"visibility"
  }
    }),
    computed:{
      targetSearch () {
        this.findInstitution()
        return this.$refs.button;
      },
      targetMap () {
        return this.$refs.maps;
      },
      scrollOptions () {
        return {
          duration: this.duration,
          offset: this.offset
        }
      },
      element () {
        if (this.selected === 'Button') return this.$refs.button
        else if (this.selected === 'Radio group') return this.$refs.radio
      }
    },
    methods:{
      onResize () {
        if(window.innerWidth <= 480){
          this.isMobile = true;
        }else{
          this.isMobile = false;
        }
      },

      fillLocations: function() {
        var vm = this;
        const curl = axios.create({
          baseURL: vm.apigw
        });
        vm.combo_ciudades_searching = true;
        return curl.get('/api/public/siep_admin/v1/forms/ciudades')
          .then(function (response) {
            vm.combo_ciudades_api  = response.data.map(x => {
              return x.nombre
            });
            vm.combo_ciudades_searching = false;
          })
          .catch(function (error) {
            vm.error = error.message;
            // vm.loading_nivel = false;
            console.log(vm.error);
            vm.searching = false;
            vm.combo_ciudades_searching = false;
          });
      },

      findInstitution: function () {
        var vm = this;
        vm.searching = true;
        vm.markers = [];
        console.log("Filtros: ",vm.filtro)

        const curl = axios.create({
          baseURL: vm.apigw
        });
        vm.filtro.with='barrio,cursos.titulacion';
        return curl.get('/api/public/siep_admin/v1/centros',{
          params: _.omitBy(vm.filtro, _.isEmpty)
        })
          .then(function (response) {
            let render = response.data.map(function(x) {
              let res ={
                position:{
                  lat: x.lat,
                  lng: x.lng
                },
                data:x
              };
              if(x.lng != 0 && x.lat != 0 && !isNaN(x.lng) && !isNaN(x.lat)){
                vm.markers.push(res);
              }
              return x;
            });

            vm.resultado = render;
            vm.searching = false;
          })
          .catch(function (error) {
            vm.error = error.message;
            vm.loading_nivel = false;
            console.log(vm.error);

            vm.searching = false;
          });

          // var options = {
          //   el: '#results', 
          //   easing: 'ease-in',
          //   duration: 800,
          //   offset: 0,
          //   force: true,
          //   cancelable: true,
          //   x: false,
          //   y: true
          // }

          // VueScrollTo.scrollTo(options);
      },

      findInstitutionByName:function(){
        var vm = this;
      },

      showCenterInfo(centro){

        let vm = this;
        vm.coords ={
          latitud: centro.lat,
          longitud: centro.lng
        };
      },

      goTop:function(){
        var element = document.getElementById("top");
        var top = element.offsetTop;
        element.scrollTo(0,0);
      },

      verifyFilters:function(){
        this.filtro = _.remove(this.filtro , function(f){
          return f.isNaN
        })
      }
    }
  }
</script>

<style scoped>

  .scrollable-content {
    height: 550px;
    background: white;
    flex-grow: 1;

    overflow: auto;

    /* for Firefox */
    min-height: 0;
  }

  .scrollable-content-mobile {
    height: 600px;
    background: white;
    flex-grow: 1;

    overflow: auto;

    /* for Firefox */
    min-height: 0;
  }

  .space-between {
    padding-top:5px;
    padding-bottom:5px;
  }

</style>
