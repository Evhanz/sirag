/**
 * Created by ehernandez on 12/06/2017.
 */
/**
 * Created by ehernandez on 02/05/2017.
 */

new Vue({
    el:"#content",
    data: {
        pallets:[]


    },
    methods:{

        getPalletByCodigo:function () {

            var v = this;
            var codigoPallet = $("#codigoPallet").val();

            if(codigoPallet.length === 6){
                var url = $("#ruta").val()+'/packing/pallet/getPalletByCodigoWithDetails';
                var token = $("#_token").val();

                $.ajax({
                    data: {codigo:codigoPallet,_token:token},
                    url:url,
                    type: 'post',
                    beforeSend: function () {

                    },
                    success:    function (data) {
                        v.pallets = [];
                        v.pallets.push(data);
                        console.log(data);
                    },
                    error:       function (data) {
                        console.log('error',data);
                        alert('ocurrio un error');

                    }
                });

            }else{
                alert('Codigo incorrecto');
            }

        },
        viewDetail: function (item) {
            item.detail_show = !item.detail_show;
        },
        getPalletByFechas:function () {

            var v = this;
            var fecha = $("#fecha").val();

            if(fecha.length !== 0){

                fecha = fecha.split('-');
                var f_inicio = (fecha[0].trim()).split('/');
                f_inicio = f_inicio[2]+'-'+f_inicio[1]+'-'+f_inicio[0];
                var f_fin = (fecha[1].trim()).split('/');
                f_fin = f_fin[2]+'-'+f_fin[1]+'-'+f_fin[0];

                var url = $("#ruta").val()+'/packing/pallet/getPalletByFechas';
                var token = $("#_token").val();

                $.ajax({
                    data: {
                        _token:token,
                        f_inicio:f_inicio,
                        f_fin:f_fin
                    },
                    url:url,
                    type: 'post',
                    beforeSend: function () {

                    },
                    success:    function (data) {

                        v.pallets = [];
                        v.pallets = data;

                        //console.log(data);
                    },
                    error:       function (data) {
                        console.log('error',data);
                        alert('ocurrio un error');

                    }
                });

            }else{
                alert('Debe Ingresar la fecha');
            }

        }

    },
    mounted:function () {
        $('#fecha').daterangepicker({
            format : "DD/MM/YYYY"
        });
    },
    watch: {


    },
    updated: function () {

    }

});

