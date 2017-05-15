/**
 * Created by ehernandez on 02/05/2017.
 */



Vue.directive('focus', {
    // When the bound element is inserted into the DOM...
    inserted: function (el) {
        // Focus the element
        el.focus()
    }
});

new Vue({
    el:"#content",
    data: {
        detalles:[],
        pallet:{descripcion:''},
        opcion:'',
        codigo:'',
        bandera:0
    },
    methods:{
        saveData : function () {

            var bandera =this.validateData();
            var v_obj = this;

            if (bandera){
                alert('debe ingresar un detalle para registrar Palet y los datos obligatorios');
            }else {

                //aca va la funcion de registrar

                var url = $('#ruta').val()+'/packing/pallet/regPallet';
                var token = $('#_token').val();

                $.ajax({
                    data: {pallet:v_obj.pallet,_token:token,detalles:v_obj.detalles},
                    url:url,
                    type: 'post',
                    beforeSend: function () {
                        $("#btnEnviar").attr('disabled',true);
                    },
                    success:    function (data) {
                        // console.log('si salio',data);

                        if (data.code == '200'){
                            if(v_obj.opcion === 'editar'){
                                window.location = $("#ruta_empleados").val()+'/packing/etapa/viewAll';
                            }else{
                                $("#btnEnviar").attr('disabled',false);
                                v_obj.codigo = data.codigo;
                                v_obj.detalles=[];
                                v_obj.pallet={descripcion:''};

                            }
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

            if(v.pallet.descripcion ===''){
                bandera = 1;
            }

            this.detalles.forEach(function (item,index) {
                if(item.estado !== 1){
                    v.detalles.splice(index,1);
                }
            });

            if(v.detalles.length === 0){
                return 1;
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
        getCaja : function (idCaja,item,index) {

            var ruta = $('#ruta').val()+'/packing/etapa/api/getById/'+idCaja;
            var v = this;

            $.getJSON( ruta)
                .done(function( data ) {

                    var bandera = 0;
                    v.detalles.forEach(function (item,i) {
                        if(item.id_caja === data.id && i !== index){
                            bandera =1;
                        }
                    });

                    if(bandera!==0 || data.estado == 1){
                        alert('Esta Caja ya está ingresada');

                    }else{

                        item.id_caja = data.id;
                        item.estado = 1;
                        $("#"+index).prop('disabled', true);
                        v.addDetail();

                    }
                })
                .fail(function (data) {
                  alert('El código no es  correcto');
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

            //console.log('llega aca');

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
        bandera:function () {

        }

    },
    updated: function () {

        var bandera =  this.detalles.length - 1 ;

      //  $("#"+bandera).focus();

     //   console.log(bandera);

    }



});

