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
            embalaje:'',
            pesaje:'',
            peso:'',
            seleccion:'',
            t_caja:'',
            uva:''
        },
        codigo:'',
        opcion:''

    },
    methods:{

        sendData : function () {

            var etapa = this.etapa;
            var url = $('#apiSeleccionReg').val();
            var token = $('#_token').val();
            var v_obj = this;
            var bandera = v_obj.validateForm();

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
                                window.location = data.url;
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
                                    uva:''
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

            if(etapa.calibre == ''){
                bandera = 1;
            }
            if(etapa.embalaje == ''){
                bandera = 1;
            }
            if (etapa.pesaje == ''){
                bandera=1;
            }
            if (etapa.peso == ''){
                bandera = 1;
            }
            if (etapa.seleccion == ''){
                bandera=1;
            }
            if(etapa.t_caja == ''){
                bandera=1;
            }
            if(etapa.uva == ''){
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
        }


    },
    mounted:function () {


        $("#codigo").hide();
        this.opcion = $('#opcion').val();



    }

});
