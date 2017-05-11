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

                    item.id_caja = data.id;
                    item.estado = 1;
                    $("#"+index).prop('disabled', true);
                    v.addDetail();
                })
                .fail(function (data) {
                   // console.log(data);
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







    }

});
