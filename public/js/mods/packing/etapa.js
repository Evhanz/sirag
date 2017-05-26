/**
 * Created by ehernandez on 02/05/2017.
 */

new Vue({
    el:"#content",
    data: {
        etapa:{
            calibre:'',
            seleccion_estado:0,
            pesaje_estado:0,
            embalaje_estado:0,
            peso_fijo_estado:0,
            embalaje:'',
            pesaje:'',
            peso:'',
            seleccion:'',
            peso_fijo:'',
            t_caja:'',
            uva:''
        },
        codigo:'',
        opcion:'',
        tipo:'normal'

    },
    methods:{

        sendData : function () {

            var etapa = this.etapa;
            var url = $('#url_send').val();
            var token = $('#_token').val();
            var v_obj = this;
            var bandera = v_obj.validateForm();

            console.log('aqui',url);

            if(bandera == 0 ){
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
            }else{
                alert('Tiene que registrar todos los datos');
            }





        },
        validateForm: function () {

            var etapa = this.etapa;
            var bandera = 0;
            var tipo = this.tipo;

            if(tipo === 'normal'){
                if(etapa.calibre == ''){
                    bandera = 1;
                }
                if(etapa.embalaje == ''){
                    bandera = 1;
                }
                if (etapa.pesaje == ''){
                    bandera=1;
                }
                if(etapa.seleccion_estado === 0){
                    bandera=1;
                }
                if(etapa.pesaje_estado === 0){
                    bandera=1;
                }
                if(etapa.embalaje_estado === 0){
                    bandera=1;
                }

            }else{
                if(etapa.peso_fijo === ''){
                    bandera = 1;
                }
                if(etapa.peso_fijo_estado === 0){
                    bandera=1;
                }
            }



            if (etapa.seleccion == ''){
                bandera=1;
            }
            if(etapa.t_caja == ''){
                bandera=1;
            }


            return bandera;

        },
        getTrabajador: function (ficha,tipo) {

            ficha = ficha.trim();
            var v = this;


            var ruta = $("#ruta_empleados").val()+'/rh/api/getTrabajadorBy/'+ficha;

            $.getJSON( ruta)
                .done(function( data ) {
                   if(data!=0){

                       switch (tipo) {

                           case 's':
                               v.etapa.seleccion_estado = 1;
                               break;
                           case 'p':
                               v.etapa.pesaje_estado = 1;
                               break;
                           case 'e':
                               v.etapa.embalaje_estado = 1;
                               break;
                           case 'f':
                               v.etapa.peso_fijo_estado = 1;
                               break;
                       }
                   }
                   console.log(v.etapa.seleccion_estado);
                });

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
            }
        },
        changeTipo: function () {
            var tipo = this.tipo;

            if (tipo === 'normal') {
                $('*[data-opcion="normal"]').show();
                $('*[data-opcion="peso_fijo"]').hide();

            } else {
                $('*[data-opcion="peso_fijo"]').show();
                $('*[data-opcion="normal"]').hide();
            }




        }


    },
    mounted:function () {

        //se oculta el código
        $("#codigo").hide();
        this.opcion = $('#opcion').val();

        var v = this;

        //se evalua si está activo el tipo
        v.changeTipo();

        //esto es el id de la caja
        var id_etapa = $("#id_etapa").val();

        if(id_etapa !== ''){
            //trae a la etapa

            var ruta = $("#ruta_empleados").val()+'/packing/etapa/api/getById/'+id_etapa;

            $.getJSON( ruta)
                .done(function( data ) {

                    data.seleccion= data.u_seleccion ;
                    data.pesaje = data.u_pesaje ;
                    data.embalaje = data.u_embalaje  ;


                    v.etapa = data;
                });
        }







    }

});
