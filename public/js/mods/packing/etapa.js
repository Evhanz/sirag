/**
 * Created by ehernandez on 02/05/2017.
 */

var v_etapa=new Vue({
    el:"#content",
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
            }else {
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

            var ruta = $("#ruta_empleados").val()+'/packing/etapa/api/getEmpleadoByFichaTipo/'+ficha+'/'+tipo;

            switch (tipo) {
                case 's':
                    $("#input_seleccion").prop('disabled', true);
                    break;
                case 'p':
                    $("#input_pesaje").prop('disabled', true);
                    break;
                case 'e':
                    $("#input_embalaje").prop('disabled', true);
                    break;
                case 'f':
                    $("#input_peso_fijo").prop('disabled', true);
                    break;
            }

            $.getJSON( ruta)
                .done(function( data ) {
                   if(data===1){

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
                   }else{
                       alert('Codigo de Trabajador incorrecto');
                   }
                }).fail(function (data) {
                    alert('Error:');
                console.log(data);
                switch (tipo) {
                    case 's':
                        $("#input_seleccion").prop('disabled', false);
                        break;
                    case 'p':
                        $("#input_pesaje").prop('disabled', false);
                        break;
                    case 'e':
                        $("#input_embalaje").prop('disabled', false);
                        break;
                    case 'f':
                        $("#input_peso_fijo").prop('disabled', false);
                        break;
                }
            });

        },
        getCodigoCaja: function (codigo) {

            var ruta = $("#ruta_empleados").val()+'/packing/etapa/api/getByCodigo/'+codigo;

            var v= this;
            $.getJSON( ruta)
                .done(function( data ) {
                    if(data == 0){
                        v.etapa.codigo_estado = 1;
                    }else if(data >0){
                        alert('La Caja ya se ha ingresado');
                    }
                }).fail(function (data) {
                alert('ocurrio un error');
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



new Vue({
    el:"#opciones",
    data: {
        calibres:[],
        t_cajas:[]
    },
    methods:{

    },
    mounted:function () {

        var ruta = $("#ruta_empleados").val()+'/packing/inicio/getOpcionesGenerales/packing_mobile';
        var v = this;

        $("#opciones").show();

        $.getJSON( ruta)
            .done(function( data ) {

                var calibre = '';

                data.calibre.forEach(function (item) {
                    var opcion = "<option  value='"+item.CODIGO+"'>"+item.CODIGO +"</option> ";
                    calibre = calibre +opcion;
                });

                var t_caja = '';

                data.tipo_caja.forEach(function (item) {
                    var opcion = "<option  value='"+item.CODIGO+"'>"+item.CODIGO +"</option> ";
                    t_caja = t_caja +opcion;
                });



                var html ="<li><a >Calibre</a></li>" +
                    "<li style='padding: 0px 15px 0px 15px'>" +
                        "<select class='form-control s_opciones' name='calibre' id='calibre'>" +
                        "<option value=''>-------------</option> " +
                            calibre+
                        "</select> " +
                    "</li>" +
                    "<li><a >Tipo Caja</a></li> " +
                    "<li style='padding: 0px 15px 0px 15px'> " +
                        "<select class='form-control s_opciones' name='t_caja' id='t_caja' > " +
                        "<option value=''>-------------</option>" +
                            t_caja+
                        "</select> " +
                    "</li>";

                $("#opciones").html(html);

                /*
                console.log(data);
                v.calibres = data.calibre;
                v.t_cajas = data.tipo_caja;*/
            });


    }

});



//asignamos las funciones que controles los cambios de los select

$( "#opciones" ).change(function() {

    v_etapa.etapa.calibre=$( "#calibre" ).val();
    v_etapa.etapa.t_caja=$( "#t_caja" ).val();
});
