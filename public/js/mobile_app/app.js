
var a  = function(){
  return v.valor;
};


//funcion controladora

var getCajas = function(){

var cajas = [];

  v.cajas.forEach(function(element) {

    var obj = {
      codigo:element.codigo,
      uva:element.uva
    };

    cajas.push(obj);

  }, this);

  return cajas;
};

// Init F7 Vue Plugin
Vue.use(Framework7Vue);

// Init Page Components
Vue.component('page-about', {
  template: '#page-about',
  data:function(){

    return {
      items: []
    }
  },
  methods: {
    // Function to proceed search results
    searchAll: function (query) {
      var self = this;
      var found = [];
      for (var i = 0; i < self.items.length; i++) {
        if (self.items[i].codigo.indexOf(query) >= 0 || query.trim() === '') found.push(i);
      }
      return found;
    },
    onSearch: function (query, found) {
        //console.log('search', query);
    }
  },
  mounted: function() {

     var cajas = getCajas();
     this.items = cajas;
  }
});
Vue.component('page-form', {
  template: '#page-form'
});
Vue.component('page-dynamic-routing', {
  template: '#page-dynamic-routing'
});

// Init App
var v = new Vue({
  el: '#app',
  framework7: {
    root: '#app',
    /* Uncomment to enable Material theme: */
    material: true,
    routes: [
      {
        path: '/about/',
        component: 'page-about' 
      }/*,
      
      {
        path: '/form/',
        component: 'page-form'
      },
      {
        path: '/dynamic-route/blog/:blogId/post/:postId/',
        component: 'page-dynamic-routing'
      }
      */
    ]
  },
  data: {
    etapa:{
      calibre:'',
      seleccion_estado:0,
      pesaje_estado:0,
      embalaje_estado:0,
      peso_fijo_estado:0,
      codigo_estado:0,
      embalaje:'',
      pesaje:'',
      peso:0,
      seleccion:'',
      peso_fijo:'',
      t_caja:'',
      uva:'',
      codigo:''
    },
    codigo:'',
    opcion:'',
    tipo:'normal',
    codigo_pallet_estado:0,
    codigo_pallet : '',
    prueba:'prueba',
    valor:13,
    cajas:[]

  },

  methods:{
      getCodigoCaja: function (codigo) {

      var v= this;

      alert(codigo);
      $("#input_seleccion").focus();

      var ruta = $("#url_base").val()+'/packing/etapa/api/getByCodigo/'+codigo+'/etapa';
      v.changeEstateInput('c',true);

      if (codigo === '' || codigo.length < 8 || codigo.length > 8){
        alert('Ingrese una código válido');
        v.changeEstateInput('c',false);
        v.etapa.codigo = '';
        $("#input_seleccion").focus();
      }else{
        $.getJSON( ruta)
            .done(function( data ) {


              if(data.length ===1 ){
                v.etapa.codigo_estado = 1;
                $("#input_seleccion").focus();


              }else if(data.length === 0){
                alert('La Caja no se ha ingresado');
                v.changeEstateInput('c',false);
                v.etapa.codigo = '';
                $("#input_codigo_caja").focus();
              }
              console.log(data);
            })
            .fail(function (data) {
              alert('ocurrio un error');
              v.changeEstateInput('c',false);
            });
      }
    },
      getTrabajador: function (ficha,tipo) {
       ficha = ficha.trim();
       var v = this;
       //var ruta = $("#ruta_empleados").val()+'/packing/etapa/api/getEmpleadoByFichaTipo/'+ficha+'/'+tipo;
       v.changeEstateInput(tipo,true);
       if (ficha === ''){
         alert('Ingrese una ficha');
         v.changeEstateInput(tipo,false);
        }else{

          switch (tipo) {
            case 's':
              v.etapa.seleccion_estado = 1;
              $("#input_pesaje").focus();
              break;
            case 'p':
              v.etapa.pesaje_estado = 1;
              $("#input_embalaje").focus();
              break;
            case 'e':
              $("#t_caja").focus();
              v.etapa.embalaje_estado = 1;
              break;
            case 'f':
              $("#t_caja").focus();
              v.etapa.peso_fijo_estado = 1;
              break;
          }

        }


    },
      changeEstateInput: function (tipo, estado) {
      switch (tipo) {
        case 's':
          $("#input_seleccion").prop('disabled', estado);
          break;
        case 'p':
          $("#input_pesaje").prop('disabled', estado);
          break;
        case 'e':
          $("#input_embalaje").prop('disabled', estado);
          break;
        case 'f':
          $("#input_peso_fijo").prop('disabled', estado);
          break;
        case 'c':
          $("#input_codigo_caja").prop('disabled', estado);
          break;
        default:
          $("#input_seleccion").prop('disabled', estado);
          $("#input_pesaje").prop('disabled', estado);
          $("#input_embalaje").prop('disabled', estado);
          $("#input_peso_fijo").prop('disabled', estado);
          $("#input_codigo_caja").prop('disabled', estado);
          break;
      }

    },
      etapaWrite: function (etapa) {
      var v = this;
      switch (etapa) {
        case 's':
          v.etapa.seleccion_estado = 0;
          break;
        case 'p':
          v.etapa.pesaje_estado = 0;
          break;
        case 'e':
          v.etapa.embalaje_estado = 0;
          break;
        case 'f':
          v.etapa.peso_fijo_estado = 0;
          break;
      }
    },
      guardarCaja: function(){




      var caja = this.etapa ;

      this.cajas.push(caja);

      this.etapa = {
        calibre:'',
        seleccion_estado:0,
        pesaje_estado:0,
        embalaje_estado:0,
        peso_fijo_estado:0,
        codigo_estado:0,
        embalaje:'',
        pesaje:'',
        peso:0,
        seleccion:'',
        peso_fijo:'',
        t_caja:'',
        uva:'',
        codigo:''
      };
      this.changeEstateInput('-',false);
      $("#input_codigo_caja").focus();
      alert('Correcto');

   
    },
      validateFom:function () {

        var bandera = 0;

        if ( this.etapa.seleccion_estado  == 0,
              this.etapa.pesaje_estado    == 0,
              this.etapa.embalaje_estado  ==  0,
              this.etapa.peso_fijo_estado ==  0,
              this.etapa.codigo_estado    ==  0){

        }



      }

  },  
  beforeMount: function () {
   //todo vue a sido mointado 

   
    
    
    
  }
  // Init Framework7 by passing parameters here
  
});





//jquery 

/*
$( ".button-fill" ).click(function(){
    if($( ".button-fill" ).find(".ripple-wave").length){
           $(".ripple-wave").remove();
    }else{
           
    }

});

$('*[data-fun="btn"]').click(function(){
    if($('*[data-fun="btn"]').find(".ripple-wave").length){
      $(".ripple-wave").remove();
    }
});

*/