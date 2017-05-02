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
        }



    },
    methods:{

        sendData : function () {

            var etapa = this.etapa;
            var url = $('#apiSeleccionReg').val();
            var token = $('#_token').val();

            $.ajax({
                data: {etapa:etapa,_token:token},
                url:url,
                type: 'post',
                beforeSend: function () {

                },
                success:    function (data) {
                    console.log('si saliod',data);
                },
                error:       function (data) {
                    console.log('errortoken');
                }

            });



        }

    }

});
