<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <title>My App</title>
    <link rel="stylesheet" href="{{asset('css/movil/framework7.material.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/movil/framework7.material.colors.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/movil/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/movil/framework7-icons/css/framework7-icons.css')}}">
</head>
<body>
<div id="app">
    <!-- Statusbar -->
    <f7-statusbar></f7-statusbar>

    <!-- Left Panel -->
    <f7-panel left reveal layout="dark">
        <f7-view id="left-panel-view" navbar-through :dynamic-navbar="true">
            <f7-navbar v-if="$theme.ios" title="Leftasdasd" sliding></f7-navbar>
            <f7-pages>
                <f7-page>
                    <f7-navbar v-if="$theme.ios" title="Left Panel" sliding></f7-navbar>
                    <f7-block-title>Load page in panel</f7-block-title>
                    <f7-list>
                        <f7-list-item link="/about/" title="About"></f7-list-item>
                        <f7-list-item link="/form/" title="Form"></f7-list-item>
                    </f7-list>
                    <f7-block-title>Load page in main as</f7-block-title>
                    <f7-list>
                        <f7-list-item link="/about/" title="About" link-view="#main-view" link-close-panel></f7-list-item>
                        <f7-list-item link="/form/" title="Form" link-view="#main-view" link-close-panel></f7-list-item>
                    </f7-list>
                </f7-page>
            </f7-pages>
        </f7-view>
    </f7-panel>

    <!-- Right Panel -->
    <f7-panel right cover layout="dark">
        <f7-view id="right-panel-view" navbar-through :dynamic-navbar="true">
            <f7-navbar v-if="$theme.ios" title="Right Panel" sliding></f7-navbar>
            <f7-pages>
                <f7-page>
                    <f7-navbar v-if="$theme.ios" title="Right Panel" sliding></f7-navbar>
                    <f7-block>
                        <p>Right panel content goes here</p>
                    </f7-block>
                    <f7-block-title>Load page in panel</f7-block-title>
                    <f7-list>
                        <f7-list-item link="/about/" title="About"></f7-list-item>
                        <f7-list-item link="/form/" title="Form"></f7-list-item>
                    </f7-list>
                    <f7-block-title>Load page in main view</f7-block-title>
                    <f7-list>
                        <f7-list-item link="/about/" title="About" link-view="#main-view" link-close-panel></f7-list-item>
                        <f7-list-item link="/form/" title="Form" link-view="#main-view" link-close-panel></f7-list-item>
                    </f7-list>
                </f7-page>
            </f7-pages>
        </f7-view>
    </f7-panel>

    <!-- Main Views -->
    <f7-views>

        <f7-view id="main-view" navbar-through :dynamic-navbar="true" main>
            <!-- iOS Theme Navbar -->
            <f7-navbar v-if="$theme.ios"  class="theme-teal">
                <f7-nav-left>
                    <f7-link icon="icon-bars" open-panel="left"></f7-link>
                </f7-nav-left>
                <f7-nav-center sliding>Framework7</f7-nav-center>
                <f7-nav-right>
                    <f7-link icon="icon-bars" open-panel="right"></f7-link>
                </f7-nav-right>
            </f7-navbar>
            <!-- Pages -->
            <f7-pages>
                <f7-page>
                    <!-- Material Theme Navbar -->
                    <f7-navbar v-if="$theme.material">
                        <f7-nav-left>
                            <f7-link icon="icon-bars" open-panel="left" data-fun='btn'></f7-link>
                        </f7-nav-left>
                        <f7-nav-center sliding style="width:60%">Packing</f7-nav-center>
                        <!--
                        <f7-nav-right>
                          <f7-link icon="icon-bars" open-panel="right"></f7-link>
                        </f7-nav-right>
                        -->
                    </f7-navbar>

                    <f7-block-title >
                        Ingreso de Pallets : veremos
                        <f7-link class="btn_perzonalizado " style="float: right;" href="/about/">
                            <!-- <i class="f7-icons">data_fill</i> -->
                            <f7-badge color="orange" style="float: right;font-size: 15px;">@{{cajas.length}}</f7-badge>
                        </f7-link>


                    </f7-block-title>
                    <f7-block inner id="content_block_input">
                        <div class="list-block" id="block_input">
                            <ul>
                                <li>

                                    <div class="item-content">
                                        <div class="item-media">
                                            <i v-if="etapa.codigo_estado == 0 " class="f7-icons color-red">check_round</i>
                                            <i v-else="etapa.codigo_estado == 0 " class="f7-icons color-green">check_round</i>
                                        </div>
                                        <div class="item-inner">
                                            <div class="item-title floating-label">Codigo de Caja</div>
                                            <div class="item-input">
                                                <input id="input_codigo_caja"  @keyup="etapa.codigo_estado = 0 " @keyup.enter="getCodigoCaja(etapa.codigo,'c')" type="text" v-model='etapa.codigo'>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i v-if="etapa.seleccion_estado == 0 " class="f7-icons color-red">check_round</i>
                                            <i v-else="etapa.seleccion_estado == 0 " class="f7-icons color-green">check_round</i>
                                        </div>
                                        <div class="item-inner">
                                            <div class="item-title floating-label">Seleccion</div>
                                            <div class="item-input">
                                                <input id="input_seleccion" @keyup="etapaWrite('s')" @keyup.enter="getTrabajador(etapa.seleccion,'s')" type="text"  v-model='etapa.seleccion'>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i v-if="etapa.pesaje_estado == 0 " class="f7-icons color-red">check_round</i>
                                            <i v-else="etapa.pesaje_estado == 0 " class="f7-icons color-green">check_round</i>
                                        </div>
                                        <div class="item-inner">
                                            <div class="item-title floating-label">Pesaje</div>
                                            <div class="item-input">
                                                <input id="input_pesaje"  type="text" @keyup="etapaWrite('p')" @keyup.enter="getTrabajador(etapa.pesaje,'p')"  v-model='etapa.pesaje'>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="item-content">
                                        <div class="item-media">
                                            <i v-if="etapa.embalaje_estado == 0 " class="f7-icons color-red">check_round</i>
                                            <i v-else="etapa.embalaje_estado == 0 " class="f7-icons color-green">check_round</i>
                                        </div>
                                        <div class="item-inner">
                                            <div class="item-title floating-label">Embalaje</div>
                                            <div class="item-input">
                                                <input id="input_embalaje" type="text" @keyup="etapaWrite('e')" @keyup.enter="getTrabajador(etapa.embalaje,'e')" v-model='etapa.embalaje' >
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <a @click="guardarCaja()" id="btnSaveCaja" class="button button-fill color-green button-round notification-custom" >Guardar Caja</a>
                                    <br>

                                </li>
                                <li>
                                    <div class="card">
                                        <div class="card-header">Codigo de pallet</div>
                                        <div class="card-content">

                                            <div class="item-content">
                                                <div class="item-media">
                                                    <i v-if="codigo_pallet_estado == 0 " class="f7-icons color-red">check_round</i>
                                                    <i v-else="codigo_pallet_estado == 0 " class="f7-icons color-green">check_round</i>
                                                </div>
                                                <div class="item-inner">
                                                    <div class="item-title floating-label">Codigo de Pallet</div>
                                                    <div class="item-input">
                                                        <input type="text" name="name" v-model='codigo_pallet'>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="" class="button button-fill color-green button-round notification-custom" style="width:100%">Guardar Pallet</a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <!-- <a href="#" data-picker=".picker-1" class="open-picker">Open Picker </a> -->
                                </li>
                            </ul>
                        </div>
                    </f7-block>

                </f7-page>
            </f7-pages>
            <!-- Floating Action Button -->
            <a href="#" class="floating-button color-pink">
                <i class="icon icon-plus"></i>
            </a>



            <!-- Picker -->
            <div class="picker-modal picker-1">
                <div class="toolbar">
                    <div class="toolbar-inner">
                        <div class="left"></div>
                        <div class="right"><a href="#" class="close-picker">
                                <span style="color:white;">Ok</span></a></div>
                    </div>
                </div>
                <div class="picker-modal-inner">
                    <div class="content-block">
                        <h4>Info 1</h4>
                        <p>Lorem ipsum dolor...</p>
                    </div>
                </div>
            </div>




        </f7-view>
    </f7-views>

    <!-- Popup -->
    <f7-popup id="popup">
        <f7-view navbar-fixed>
            <f7-pages>
                <f7-page>
                    <f7-navbar title="Popup">
                        <f7-nav-right>
                            <f7-link close-popup>Close</f7-link>
                        </f7-nav-right>
                    </f7-navbar>
                    <f7-block>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque, architecto. Cupiditate laudantium rem nesciunt numquam, ipsam. Voluptates omnis, a inventore atque ratione aliquam. Omnis iusto nemo quos ullam obcaecati, quod.</f7-block>
                </f7-page>
            </f7-pages>
        </f7-view>
    </f7-popup>

    <!-- Login Screen -->
    <f7-login-screen id="login-screen">
        <f7-view>
            <f7-pages>
                <f7-page login-screen>
                    <f7-login-screen-title>Login</f7-login-screen-title>
                    <f7-list form>
                        <f7-list-item>
                            <f7-label>Username</f7-label>
                            <f7-input name="username" placeholder="Username" type="text"></f7-input>
                        </f7-list-item>
                        <f7-list-item>
                            <f7-label>Password</f7-label>
                            <f7-input name="password" type="password" placeholder="Password"></f7-input>
                        </f7-list-item>
                    </f7-list>
                    <f7-list>
                        <f7-list-button title="Sign In" close-login-screen></f7-list-button>
                        <f7-list-label>
                            <p>Click Sign In to close Login Screen</p>
                        </f7-list-label>
                    </f7-list>
                </f7-page>
            </f7-pages>
        </f7-view>
    </f7-login-screen>
</div>

<!-- About Page Template -->
<template id="page-about">
    <f7-page>
        <f7-navbar title="Cajas Ingresadas" back-link="Back" sliding></f7-navbar>


        <f7-searchbar
                cancel-link="Cancel"
                search-list="#search-list"
                placeholder="Search in items"
                :clear-button="true"
                @searchbar:search="onSearch"
        ></f7-searchbar>

        <!-- Will be visible if there is no any results found, defined by "searchbar-not-found" class -->
        <f7-list class="searchbar-not-found">
            <f7-list-item title="Nothing found"></f7-list-item>
        </f7-list>

        <!-- Search-through list -->
        <f7-list class="searchbar-found" id="search-list">
            <f7-list-item v-for="item in items" :title="'Caja Codigo: ' + item.codigo + ' '+ item.uva"></f7-list-item>
        </f7-list>



    </f7-page>



</template>



<script
        src="https://code.jquery.com/jquery-2.2.4.min.js"
        integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
        crossorigin="anonymous"></script>
<script src="{{asset('js/mobile_app/framework7.min.js')}}"></script>
<script src="{{asset('js/mobile_app/vue.min.js')}}js/"></script>
<script src="{{asset('js/mobile_app/framework7-vue.min.js')}}"></script>
<script src="{{asset('js/mobile_app/app.js')}}"></script>





<!--Pasar a un css-->

<style>
    #block_input{
        margin-top: 0;
        margin-bottom: 0;
    }

    #content_block_input{
        margin-bottom: 0;
    }


    #content_block_input > .content-block-inner{
        padding-top:0;
        padding-bottom: 0;
    }
</style>

<!--pasar a un js -->

<script>
    /*

     var myApp = new Framework7({
     material: true
     });
     var mainView = myApp.addView('#main-view');

     var $$ = Dom7;

     $$('.notification-custom').on('click', function () {
     myApp.addNotification({
     message: 'Nice yellow button',
     button: {
     text: 'Click me',
     color: 'yellow'
     },
     onClose: function () {
     myApp.alert('Notification closed');
     }
     });
     });
     */


</script>

</body>
</html>