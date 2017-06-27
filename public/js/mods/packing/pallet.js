/**
 * Created by ehernandez on 02/05/2017.
 */



Vue.directive('focus', {
    // When the bound element is inserted into the DOM...
    inserted: function (el) {
        // Focus the element
        //el.focus()
    }
});

new Vue({
    el:"#content",
    data: {
        detalles:[],
        pallet:{descripcion:''},
        opcion:'',
        codigo:'',
        bandera:0,
        caja:'',
        codigo_pallet:'',
        isDisabled:true
    },
    methods:{
        saveData : function () {

            var bandera =this.validateData();
            var v_obj = this;

            if (bandera){
                alert('debe ingresar un detalle para registrar Palet y los datos obligatorios');
            }else {

                var url = '';

                //aca va la funcion de registrar
                if(v_obj.opcion==='editar'){
                    url = $('#ruta').val()+'/packing/pallet/editPallet';
                }else{
                    url = $('#ruta').val()+'/packing/pallet/regPallet';
                }

                var token = $('#_token').val();

                $.ajax({
                    data: {pallet:v_obj.codigo_pallet,_token:token,detalles:v_obj.detalles},
                    url:url,
                    type: 'post',
                    beforeSend: function () {
                        $("#btnEnviar").attr('disabled',true);
                    },
                    success:    function (data) {
                        // console.log('si salio',data);

                        if (data.code == '200'){

                            /*
                            if(v_obj.opcion === 'editar'){
                                window.location = $("#ruta_empleados").val()+'/packing/etapa/viewAll';
                            }else{


                            }
                            */

                            $("#btnEnviar").attr('disabled',false);
                            // v_obj.codigo = data.codigo;
                            v_obj.detalles=[];
                            //  v_obj.pallet={descripcion:''};
                            v_obj.codigo_pallet='';
                            $("#codigo_pallet").prop('disabled',false);
                            v_obj.opcion = '';

                            alert('Correcto');

                        }else{
                            alert('Error: '+ data.code);
                        }

                    },
                    error:       function (data) {
                        console.log('error',data);
                        alert('ocurrio un error');
                        $("#btnEnviar").attr('disabled',false);
                    }
                });

            }


        },
        
        validateData : function () {

            var bandera = 0;
            var v = this;

            if(v.codigo_pallet === ''){
                bandera = 1;
            }


            return bandera;
            
        },
        addDetail : function () {

            var detalle = {};
            this.detalles.push(detalle);
            this.bandera ++;

        },
        quitDetail : function (index) {


            var res = confirm('Esta seguro ?');

            if(res===true){
                this.detalles.splice(index,1);
            }
        },
        getCaja : function (idCaja) {
            /*el idcaja es el codigo de la caja*/

            var ruta = $('#ruta').val()+'/packing/etapa/api/getByCodigo/'+idCaja+'/pallet';
            var v = this;
            v.isDisabled = true;
            $.getJSON( ruta)
                .done(function( data ) {

                    if(data === 1 ){

                        var b = '';

                        v.detalles.find(function (i,index) {
                           if( i.id_caja === idCaja)  b = index;
                        });

                        if(b===''){
                            var e = {id_caja:idCaja};
                            v.detalles.splice(0, 0,e);
                            v.caja = '';

                            $('.details tbody tr:nth-child(1)').removeClass('detalle').animate({'nothing':null}, 1, function () {
                                $(this).addClass('detalle');
                            });
                           // $("#code_caja").delay(1500).prop('disabled',false);

                            v.isDisabled = false;

                        }else {
                            alert('El código ya a sido ingresado');
                            v.caja = '';
                            v.isDisabled = false;
                            $("#code_caja").focus();
                            v.isDisabled = false;
                        }

                    }else{
                        alert("No existe ese código o no está hábil");
                        v.isDisabled = false;
                        v.caja = '';
                       // $("#code_caja").attr('disabled',true);
                    }

                    var bandera = 0;
                    //acamodificar toda la lógica
                    v.detalles.forEach(function (item,i) {


                    });




                })
                .fail(function (data) {
                  alert('El código no es  correcto');
                  v.isDisabled = false;
                });

        },
        viewPallet : function (p) {

            var ruta  = $("#ruta").val()+'/packing/pallet/getDetailsPallet/'+p;
            var v = this;

            $.getJSON( ruta)
                .done(function( data ) {
                    v.detalles = data;
                    console.log(data);
                })
                .fail(function (data) {
                    alert('El código no es  correcto');
                    console.log(data);
                });

            $("#modalPallet").modal('show');


        },
        validateCodePallet: function(codigo_pallet){
            /*esta funcion mediante el codigo , ferifica si el código está disponible */

            var ruta  = $("#ruta").val()+'/packing/pallet/getPalletBy/'+codigo_pallet;
            var v = this;

            if(v.codigo_pallet === '' || v.codigo_pallet.length < 6 || v.codigo_pallet.length > 6){
                alert('Ingrese un código válido');
            }else{
                $.getJSON( ruta)
                    .done(function( data ) {
                        if(data.existe < 1 ){
                            v.codigo_pallet = codigo_pallet;
                            $("#codigo_pallet").prop('disabled',true);
                            v.isDisabled = false ;
                        }else{

                            /*si entra aqui entonces quiere decir que existe */
                           // alert("El codigo no está disponible");
                           // v.detalles = data.detalles;

                            data.detalles.forEach(function (item) {
                                var e = {id_caja:item.codigo};
                                v.detalles.push(e);
                            });

                            v.codigo_pallet = codigo_pallet;
                            $("#codigo_pallet").prop('disabled',true);
                            v.isDisabled = false;
                            v.opcion = 'editar';
                        }


                    })
                    .fail(function (data) {
                        alert("Error");
                        console.log(data);
                    });
            }
        },
        reset: function () {

            var a = confirm('Seguro Que desea continuar ??, Se borrará los datos en el formulario');

            if(a === true){
                this.codigo_pallet = '';
                this.detalles=[];
                $("#codigo_pallet").prop('disabled',false);
            }


        }
    },
    mounted:function () {

        $("#codigo").hide();
        this.opcion = $('#opcion').val();
        var v = this;

        var id_etapa = $("#id_etapa").val();

        if(id_etapa !== ''){
            //trae a la etapa

        }


        $('input[name="fecha"]').daterangepicker({
            format : "DD/MM/YYYY"
        });


    },
    watch: {
        caja:function () {



        }

    },
    updated: function () {

        var bandera =  this.detalles.length - 1 ;

        var a =  $("#codigo_pallet:disabled" ).val();

        if(a!==undefined){
            $("#code_caja").focus();
        }




    }



});

