
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
        codigo:'',
        id:''

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
        $("#input_seleccion").focus();
        var ruta = $("#url_base").val()+'/packing/etapa/api/getByCodigo/'+codigo+'/etapa';
        v.changeEstateInput('c',true);
        if (codigo === '' || codigo.length < 8 || codigo.length > 8){
          alert('Ingrese una código válido');
          v.changeEstateInput('c',false);
          v.etapa.codigo = '';
          $("#input_codigo_caja").focus();
        }else{
          $.getJSON( ruta)
              .done(function( data ) {
                  if(data.length ===1 && data[0].estado == 0 && data[0].cod_pallet === null){
                    v.etapa.codigo_estado = 1;
                    $("#input_seleccion").focus();
                    v.etapa.calibre = data[0].calibre;
                    v.etapa.t_caja = data[0].t_caja;
                    v.etapa.uva = data[0].uva;
                    v.etapa.id = data[0].id;
                  }else if(data.length === 0){
                    alert('La Caja no se ha ingresado');
                    v.changeEstateInput('c',false);
                    v.etapa.codigo = '';
                    $("#input_codigo_caja").focus();
                  }else {
                      alert('La Caja no está disponible');
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
        var ruta = $("#url_base").val()+'/packing/etapa/api/getEmpleadoByFichaTipo/'+ficha+'/'+tipo;
        v.changeEstateInput(tipo,true);
        if (ficha === ''){
          alert('Ingrese una ficha');
          v.changeEstateInput(tipo,false);
        }
        else{
          $.getJSON( ruta)
              .done(function( data ) {
                if(data===1){
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
               else{
                   alert('Codigo de Trabajador incorrecto');
                   v.changeEstateInput(tipo,false);
                   switch (tipo) {
                       case 's':
                           v.etapa.seleccion ='';
                           break;
                       case 'p':
                           v.etapa.pesaje ='';
                           break;
                       case 'e':
                           v.etapa.embalaje ='';
                           break;
                       case 'f':
                           v.etapa.peso_fijo ='';
                           break;
                   }
               }
             }).fail(function (data) {
               alert('Error:');
               console.log(data);
               v.changeEstateInput(tipo,false);
             });
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
        var url = $('#url_send_caja').val();
        var token = $('#_token').val();
        var v_obj = this;
        var bandera = v_obj.validateForm();

        var b = v_obj.validateNewCaja(caja);

        if(b===0){
            if(bandera === 0 ){
                $.ajax({
                    data: {etapa:caja,_token:token},
                    url:url,
                    type: 'post',
                    beforeSend: function () {
                        $("#btnSaveCaja").attr('disabled',true);
                    },
                    success:    function (data) {

                        if (data.code == '200'){
                            $("#btnSaveCaja").attr('disabled',false);
                            $("#input_codigo_caja").focus();
                            v_obj.changeEstateInput('all',false);
                            v_obj.cajas.push(caja);
                            v_obj.etapa = {
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
                            v_obj.changeEstateInput('-',false);
                            alert('Correcto');

                        }else{
                            alert('Error: '+ data.code);
                            $("#btnSaveCaja").attr('disabled',false);
                        }

                    },
                    error:       function (data) {
                        console.log('error',data);
                        alert('ocurrio un error');
                        $("#btnSaveCaja").attr('disabled',false);
                    }
                });
            } else {
                alert('Tiene que registrar todos los datos');
            }

        }else{

            $("#btnSaveCaja").attr('disabled',false);
            $("#input_codigo_caja").focus();
            v_obj.changeEstateInput('all',false);
            v_obj.etapa = {
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
            v_obj.changeEstateInput('-',false);

            alert('No se puede ingresar caja diferente parametros ');
        }

      },
      validateForm:function () {

        var bandera = 0;
        var v = this;

        if ( v.etapa.seleccion_estado  === 0 ||
            v.etapa.pesaje_estado    === 0 ||
            v.etapa.embalaje_estado  ===  0 ||
            v.etapa.codigo_estado    ===  0){

          bandera = 1;

        }

        return bandera;



      },
      validateNewCaja: function (caja) {
          var bandera  = 0,
              v = this,
              cajas = v.cajas;

          if(cajas.length > 0){
              var c = cajas[0];
              if ( c.uva    !== caja.uva ||
                 c.calibre  !== caja.calibre ||
                 c.t_caja   !== caja.t_caja ){

                  bandera = 1;
              }
          }


          return bandera;

      },
      savePallet : function () {

          var a = confirm('Desea Guardar los cambios ? ');

          if(a === true){
              //obtenemos todos los codigos de cajas

              var cajas  = this.cajas,
                  cod_cajas = []
                  ,token = $('#_token').val()
                  ,url =  $("#url_base").val()+'/packing/pallet/regPallet'
                  ,v = this;


              cajas.forEach(function (item) {
                  var a = {id_caja:item.codigo};
                  cod_cajas.push(a);
              });


              $.ajax({
                  data: {
                      detalles:cod_cajas,
                      _token:token,
                      pallet:v.codigo_pallet
                  },
                  url:url,
                  type: 'post',
                  beforeSend: function () {
                      $("#btnSaveCaja").attr('disabled',true);
                      $("#btnSavePallet").attr('disabled',true);
                  },
                  success:    function (data) {

                      if(data.code === 200){
                          alert('Correcto');

                          /*Hard Reset*/
                          v.hardResetForm();
                          $("#input_codigo_caja").focus();

                      }else {
                          alert('Error: revisar la consola');
                      }

                      $("#btnSaveCaja").attr('disabled',false);
                      $("#btnSavePallet").attr('disabled',false);

                  },
                  error:       function (data) {

                      alert('Error Conexion: revisar consola');

                      $("#btnSaveCaja").attr('disabled',false);
                      $("#btnSavePallet").attr('disabled',false);
                  }
              });

          }
      },
      validateCodePallet: function(){
          /*esta funcion mediante el codigo , ferifica si el código está disponible */

          var ruta  = $("#url_base").val()+'/packing/pallet/getPalletBy/'+this.codigo_pallet;
          var v = this;

          if(v.codigo_pallet === '' || v.codigo_pallet.length < 6 || v.codigo_pallet.length > 6){
              alert('Ingrese un código válido');
              v.codigo_pallet = '';
          }else{
              $.getJSON( ruta)
                  .done(function( data ) {
                      if(data.existe < 1 ){

                          //entra si no existe y esta disponible

                          $("#codigo_pallet").prop('disabled',true);
                          v.codigo_pallet_estado = 1 ;
                      }else{

                          /*si entra aqui entonces quiere decir que existe */
                          alert("El codigo no está disponible");
                          v.codigo_pallet = '';
                          $("#codigo_pallet").prop('disabled',false);
                      }

                  })
                  .fail(function (data) {
                      alert("Error");
                      console.log(data);
                  });
          }
      },
      hardResetForm:    function () {

          var v = this;
          v.codigo_pallet_estado=0;
          v.codigo_pallet = '';
          v.cajas=[];
          v.etapa = {
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

          v.changeEstateInput('all',false);
      },
      resetForm:    function () {

          var b = confirm('Desea limpiar el formulario');

          if(b){
              var v = this;

              v.etapa = {
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
                  codigo:'',
                  id:''
              };

              v.changeEstateInput('all',false);
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