/**
 * Created by root on 29/11/16.
 */



new Vue({
    el:'#app',
    data:{
        pallet:[],
        resource_url_pallet:$('#ruta').val()+'/packing/pallet/getAllPalletPaginate',
        cant_pallet: 0,
        cajas:[],
        personas:{},
        cant_pallets:0,
        tipo:'t_caja',
        f_i_barrasCaja:'-',
        f_f_barrasCaja:'-'
    },
    methods:{
        updateResource: function(data){
            this.pallet = data;
        },
        getCajasPallet: function (pallet) {

            var url = $("#ruta").val()+'/packing/etapa/api/getByCodigoPallet/'+pallet;
            var v = this;

            v.cajas=[];

            $.ajax({
                url:url,
                type: 'get',
                beforeSend: function () {

                },
                success:    function (data) {
                    v.personas = {};
                    v.cajas=data;
                },
                error:       function (data) {
                    console.log('error',data);
                    alert('ocurrio un error');
                    $("#btnEnviar").attr('disabled',false);
                }
            });
        },
        detailCaja: function (item) {

            var caja = this.cajas.filter(function (caja) {
                return caja.codigo === item.codigo;
            });

            this.personas = caja[0];
        },
        getMorrisCajaBar : function () {

            $('#revenue-chart').empty();

            var url = $("#ruta").val()+'/packing/inicio/getBarCajas/'+this.f_i_barrasCaja+'/'+this.f_f_barrasCaja+'/'+this.tipo;
            $.ajax({
                url:url,
                type: 'get',
                beforeSend: function () {

                },
                success:    function (data) {

                    Morris.Bar({
                        element: 'revenue-chart' ,
                        data: data,
                        xkey: 'codigo',
                        ykeys: ['cantidad'],
                        labels: ['Cantidad'],
                        stacked: true,
                        resize:true,
                        barColors: function (row, series, type) {
                            if (type === 'bar') {
                                var red = Math.ceil(255 * row.y / this.ymax);
                                return 'rgb(' + red + ',0,0)';
                            }
                            else {
                                return '#3fe9ea';
                            }
                        }
                    });

                },
                error:       function (data) {
                    console.log('error',data);
                    alert('ocurrio un error');
                }
            });
        },
        getBarCaja: function (tipo) {
            this.tipo=tipo;
            this.getMorrisCajaBar();
        }
    },
    components: {
        VPaginator: VuePaginator
    },
    mounted:function () {

        $('input[name="fecha"]').daterangepicker({
            format : "DD/MM/YYYY"
        });

        var url = $("#ruta").val()+'/packing/pallet/getCountNowPallet';
        var v = this;


        $.ajax({
            url:url,
            type: 'get',
            beforeSend: function () {

            },
            success:    function (data) {
                v.cant_pallets=data;
                console.log('as',data);
            },
            error:       function (data) {
                console.log('error',data);
                alert('ocurrio un error');
            }
        });


        /*agregar morris*/
        this.getMorrisCajaBar();
    }
});



