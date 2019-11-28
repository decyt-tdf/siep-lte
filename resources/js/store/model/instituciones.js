// Modelo Instituciones
const instituciones = {
  ambito:String,
  barrio:{
    ciudad_id:Number,
    created:Date,
    id:Number,
    modified:Date,
    nombre:String
  },
  ciudad:{
    created:Date,
    departamento_id:Number,
    id:Number,
    modified:Date,
    nombre:String
  }
};

export default instituciones
