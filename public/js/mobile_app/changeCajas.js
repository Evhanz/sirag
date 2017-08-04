

// Init F7 Vue Plugin
Vue.use(Framework7Vue);

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
    caja_saliente:{
        estado_get:0,
        codigo:''
    },
    caja_cambiar:{
        estado_get:0,
        codigo:''
    },
    codigo_motivo:''


  },

  methods:{
      getCodigoCaja: function (codigo,tipo) {
        var v= this;

        var ruta = $("#url_base").val()+'/packing/etapa/api/getByCodigo/'+codigo+'/etapa';

        if (codigo === '' || codigo.length < 8 || codigo.length > 8 || v.caja_saliente.codigo === v.caja_cambiar.codigo){
          alert('Ingrese una código válido');

            if(tipo === 'saliente'){

                v.caja_saliente.estado_get = 0;
                v.caja_saliente.codigo = '';
                $("#cod_caja_saliente").focus();

            }else{
                v.caja_cambiar.estado_get = 0;
                v.caja_cambiar.codigo = '';
                $("#cod_caja_cambiar").focus();
            }

        }else{
          $.getJSON( ruta)
              .done(function( data ) {
                  if(data.length ===1 ){

                      if(tipo === 'saliente'){
                          v.caja_saliente = data[0];
                          v.estado_get = 1;
                          $("#cod_caja_cambiar").focus();
                          $("#cod_caja_saliente").prop('disabled',true);

                      }else{
                          v.caja_cambiar = data[0];
                          v.estado_get = 1;
                          $("#selectType").focus();
                          $("#cod_caja_cambiar").prop('disabled',true);
                      }

                  }else {
                      alert('La Caja no ha sido creado');

                      if(tipo === 'saliente'){
                          v.caja_saliente =
                              {estado_get:0,
                              codigo:''};
                      }else{
                          v.caja_cambiar = {estado_get:0,
                              codigo:''};
                      }
                  }
                  console.log(data);
              })
              .fail(function (data) {
                alert('ocurrio un error');

              });
        }
      },

      saveCambio: function(){

        var url = $('#url_send_cambios').val();
        var token = $('#_token').val();
        var v_obj = this;

        $.ajax({
            data: {
                caja_saliente:v_obj.caja_saliente,
                caja_cambiar:v_obj.caja_cambiar,
                codigo_motivo:v_obj.codigo_motivo,
                _token:token},
            url:url,
            type: 'post',
            beforeSend: function () {
                $("#btnSaveCambio").attr('disabled',true);
            },
            success:    function (data) {

                if(data['code']===200){

                    alert('Correcto');

                }else{

                    alert('Hubo Un error , verificar la consola');
                    console.log(data);
                }


                v_obj.resetForm();
            },
            error:       function (data) {
                console.log('error',data);
                alert('ocurrio un error');
                $("#btnSaveCaja").attr('disabled',false);
            }
        });

      },



      resetForm:    function () {

          var v = this;

          $("#cod_caja_saliente").prop('disabled',false);
          $("#cod_caja_cambiar").prop('disabled',false);

          v.caja_saliente = {estado_get:0,  codigo:''};
          v.caja_cambiar = {estado_get:0,   codigo:''};


          v.codigo_motivo = null;
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