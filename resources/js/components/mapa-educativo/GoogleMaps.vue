<template>
    <gmap-map
      :center="center"
      :zoom="zoom"
      class="googleMaps"
      ref="mapRef"
    >
      <gmap-info-window :options="infoOptions" :position="infoWindowPos" :opened="infoWinOpen" @closeclick="infoWinOpen=false">
        <div v-html="infoContent"></div>
      </gmap-info-window>
      <gmap-marker
        :key="index"
        v-for="(m, index) in markers"
        :position="m.position"
        :draggable="true"
        :clickable="true"
        title="Click para mostrar Información"
        icon= "http://maps.google.com/mapfiles/kml/shapes/info-i.png"
        @click="showCenterInfo(m,index)"
      ></gmap-marker>
    </gmap-map>

    
</template>

<script>
  export default {
    name: "GoogleMap",
    props:['coords','markers_array'],
    data() {
      return {
        apigw: process.env.SIEP_API_GW_INGRESS,
        latitud:0,
        longitud:0,
        center: { lat : 0, lng : 0},
        markers: [],
        // maps_icon: ,
        markers_temp: [],
        places: [],
        currentPlace: null,
        zoom:15,
        infoOptions: {
          pixelOffset: {
            width: 0,
            height: -35
          }
        },
        infoWindowPos: null,
        infoWinOpen: false,
        infoContent:'',
        currentMidx: null
      };
    },

    mounted() {
      this.geolocate();
    },
    created(){
    },
    watch:{
      coords: function(latlong){
        this.latitud = latlong.latitud;
        this.longitud = latlong.longitud;
        this.geolocateCenter();
      },
      markers_array:function(){
        this.addStaticMarker();
        this.infoWinOpen = false;
      },
      markers(markers){
        if (markers.length > 2) {
          const bounds = new google.maps.LatLngBounds();
          for (let m of markers) {
            let latitud = m.position.lat;
            let longitud = m.position.lng;
            let pos = [parseFloat(latitud),parseFloat(longitud)];
            bounds.extend(m.position)
          }
          this.$refs.mapRef.fitBounds(bounds)
          this.markers_temp = markers;
        }else if(markers.length < 1 && this.markers_temp.length > 0){
          // Se limpian los marcadores mostrados en el mapa en cada nueva busqueda
          this.markers_temp.map(function(marker){
            if(!_.isEmpty(marker.position.lat) && !_.isEmpty(marker.position.lng)){
              marker.setMap(null);
            }
          });
          this.markers_temp = [];
        }
      }
    },

    methods: {
      // receives a place object via the autocomplete component
      setPlace(place) {
        this.currentPlace = place;
      },
      addStaticMarker() {
        this.markers = this.markers_array;
      },
      geolocate: function() {
        navigator.geolocation.getCurrentPosition(position => {
          this.center = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
        });
      },
      geolocateCenter: function() {

        let _marker = {
          lat: this.latitud,
          lng: this.longitud
        };
        // this.markers.push({ position: marker });
        this.places.push(_marker);
        this.center = _marker;
        this.currentPlace = null;
        this.zoom = this.zoom === 15 ? 16 : 15;
      },
      showCenterInfo: function(centro,index) {
        if(_.isEmpty(centro.data.barrio)){
          Vue.set(centro.data,'barrio',{'nombre':''});
        }
        if(_.isEmpty(centro.data.url)){
          centro.data.url = '';
        }
        if(_.isEmpty(centro.data.email)){
          centro.data.email = '';
        }
        if(centro.data.telefono === null){
          centro.data.telefono = '';
        }
        this.center = centro.position;
        this.infoWindowPos = centro.position;
        let titulations = [];
        this.infoContent =
        '<div style="text-align:left;"><strong>CUE Anexo:</strong> '+centro.data.cue+'</div>'+
        '<div style="text-align:left;"><strong>Nombre:</strong> '+centro.data.nombre+'</div>'+
        '<div style="text-align:left;"><strong>Dirección:</strong> '+centro.data.direccion+'</div>'+
        '<div style="text-align:left;"><strong>Barrio:</strong> '+centro.data.barrio.nombre+'</div>'+
        '<div style="text-align:left;"><strong>Código Postal:</strong> '+centro.data.cp+'</div>'+
        '<div style="text-align:left;"><strong>Código Localidad:</strong> '+centro.data.codigo_localidad+'</div>'+
        '<div style="text-align:left;"><strong>Ciudad:</strong> '+centro.data.ciudad.nombre+'</div>'+
        '<div style="text-align:left;"><strong>Teléfono:</strong> '+centro.data.telefono+'</div>'+
        '<div style="text-align:left;"><strong>Email:</strong> '+centro.data.email+'</div>'+
        '<div style="text-align:left;"><strong>URL:</strong> '+centro.data.url+'</div>';

        // Titulaciones solo para nivel Secundario
        if(_.endsWith(centro.data.nivel_servicio,"Secundario")){
          
          centro.data.cursos.map(curso => {
            if(curso.division!="" && curso.division!=null){
              if(titulations.indexOf(curso.titulacion.nombre) === -1 && !_.startsWith(curso.titulacion.nombre,"NIVEL")){
                titulations.push(curso.titulacion.nombre);
              }
            }
          })
          if(titulations.length > 0){
            this.infoContent+='<hr'+
            '<div style="text-align:left;"><strong>TITULACIONES:</strong></div>'+
            '<div style="text-align:left;">';
            titulations.map(titulation =>{
              this.infoContent+="- "+titulation+"<br>";
            });
          }
          this.infoContent +='</div>';
        }

        //check if its the same marker that was selected if yes toggle
            if (this.currentMidx == index) {
              this.infoWinOpen = !this.infoWinOpen;
            }
            //if different marker set infowindow to open and reset current marker index
            else {
              this.infoWinOpen = true;
              this.currentMidx = index;
            }
            
        this.zoom = this.zoom === 15 ? 16 : 15;
      }
    }
  };
</script>
<style>
.googleMaps{
  margin-left: 5px;
  width: 100%;
  height: 550px;
}
</style>

