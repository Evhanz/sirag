/**
 * Created by ehernandez on 21/06/2017.
 */
new Vue({
    el:"#content",
    data: {
        detalles:[],
        codigo:'',
        pallet:'',
        tipo:'salida',
        origen:'ALM. CAMARAS',
        destino: 'EXPORTACION'

    },
    methods:{

        gePallet: function (codigoPallet) {

            var token = $("#_token").val();

            if(codigoPallet !== ''){

                var url = $("#url").val()+'/packing/movimiento/getPalletByCodigoMovimiento';
                var v = this;
                var b = '';

                v.detalles.find(function (i,index) {
                    if( i.codigo === codigoPallet)  b = index;
                });

                if(b===''){
                    $.post(
                        url,
                        {   _token: token,
                            origen:v.origen,
                            destino:v.destino,
                            tipo:v.tipo,
                            codigo_pallet:codigoPallet
                        }
                    ).done(function( data ) {

                        if(data.existe === 0){
                            alert(data.mensaje);
                        }else{
                            var d = data.data;
                            v.detalles.push(d);
                        }

                    }).fail(function (data) {
                        console.log(data);
                    });

                    v.pallet = '';

                }else {
                    alert('El código ya a sido ingresado');
                    v.pallet = '';
                    $("#code_pallet").focus();
                }

            }
        },
        quitDetail : function (index) {

            var res = confirm('Esta seguro ?');
            if(res===true){
                this.detalles.splice(index,1);
            }
        },
        sendData : function () {

            var bandera = this.validateData();
            if(bandera === 0){
                $("#form_movimiento").submit();
            }

        },
        validateData : function () {

            var bandera = 0;
            var mensaje = '';

            if (this.detalles.length === 0) {
                bandera = 1;
                mensaje += 'Debe Ingresar Los detalles';
            }
            if (this.codigo === '' && this.tipo === 'salida') {
                bandera = 1;
                mensaje += ' Debe ingresar un Codigo Para el Movimiento';
            }

            if (this.tipo === '' ) {
                bandera = 1;
                mensaje += ' Debe ingresar el tipo de movimiento';
            }

            if(bandera === 1){
                alert(mensaje);
            }

            return bandera;

        }


    },
    mounted:function () {

        $('input[name="daterange"]').daterangepicker({
            format : "DD/MM/YYYY"
        });

    },
    watch: {
        tipo: function (val) {
            if(val==='entrada'){
                this.origen='ALM. PACKING';
                this.destino='ALM. CAMARAS';
            }else{
                this.origen='ALM. CAMARAS';
                this.destino='EXPORTACION';
            }
        }

    },
    updated: function () {

    }

});

