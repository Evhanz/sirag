/**
 * Created by ehernandez on 02/05/2017.
 */

new Vue({
    el:"#content",
    data: {
        etapa:{
            calibre:'',
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

            return bandera;

        }

    },
    mounted:function () {


        $("#codigo").hide();
        this.opcion = $('#opcion').val();



    }

});
