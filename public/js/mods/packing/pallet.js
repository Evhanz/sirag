/**
 * Created by ehernandez on 02/05/2017.
 */

new Vue({
    el:"#content",
    data: {
        detalles:[],
        pallet:{},
        opcion:''
    },
    methods:{
        saveData : function () {

            var bandera =this.validateData();
            if (bandera){
                alert('debe ingresar un detalle para registrar Palet');
            }else {

                //aca va la funcion de registrar

                var url = $('#ruta').val();
                var token = $('#_token').val();

                $.ajax({
                    data: {etapa:etapa,_token:token},
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
                                $("#codigo").show();
                                v_obj.etapa = {
                                    calibre:'',
                                    embalaje:'',
                                    pesaje:'',
                                    peso:'',
                                    seleccion:'',
                                    t_caja:'',
                                    uva:'',
                                    seleccion_estado:0,
                                    pesaje_estado:0,
                                    embalaje_estado:0
                                };
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

                    if(bandera!==0){
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

    },
    watch: {
        detalles: function (val, oldVal) {
            console.log('new: %s, old: %s', val, oldVal);

            //esta funcion observa pero despues que se renderiza el DOM
            var bandera = oldVal.length-1;

            //console.log(bandera);
            $("#"+bandera).focus();
        }
    },
    updated: function () {

        var bandera =  this.detalles.length - 1 ;

        $("#"+bandera).focus();

        console.log(bandera);

    }



});

