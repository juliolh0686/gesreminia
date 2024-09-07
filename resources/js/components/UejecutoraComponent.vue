<template>

<div class="right_col" role="main">
    <div class="">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h3>Unidad Ejecutora</h3>
                        <div class="clearfix"></div>
                    </div>
                    <div class="col-sm-7">
                        <div class="inbox-body">
                            <div class="x_content">

                                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                    <div class="x_title">
                                        <div class="form-group row">
                                            <div class="col-md-4">
                                                <label for="text-input">Codigo de Unidad Ejecutora</label>
                                                <input type="text" v-model="uejecutora.ue_id " class="form-control" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="text-input">Nº RUC</label>
                                            <input type="text" v-model="uejecutora.ue_ruc" class="form-control">
                                            <span v-if="errors.ue_ruc" class="error">{{errors.ue_ruc[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="text-input">Nombre de Unidad Ejecutora</label>
                                            <input type="text" v-model="uejecutora.ue_nombre" class="form-control">
                                            <span v-if="errors.ue_nombre" class="error">{{errors.ue_nombre[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="text-input">Dirección</label>
                                            <input type="text" v-model="uejecutora.ue_direccion" class="form-control">
                                            <span v-if="errors.ue_direccion" class="error">{{errors.ue_direccion[0]}}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <img :src="imagen" class="fotologo">
                                    </div>

                                     <div class="form-group row">
                                        <input type="file" ref="file" id="file" class="custom-file-input" @change="obtenerImagen" accept="image/x-png,image/jpeg"/>
                                        <label for="file" class="labelfile"><i class="fa fa-cloud-upload"></i> Subir Logo</label>
                                    </div>
                                </form>


                                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                                    
                                    <div id="myTabContent" class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                                            <div class="modal-footer">
                                                <button type="button" v-if="!uejecutora.ue_id" class="btn btn-primary" @click="registrarUejecutora()">Guardar Registro</button>
                                                <button type="button" v-else class="btn btn-primary" @click="actualizarUejecutora()">Actualizar Registro</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
   
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</template>

<script>

    export default {
        data(){
            return {
                imagenMiniatura:'',
                uejecutora:{
                    ue_id:0,
                    ue_ruc:'',
                    ue_nombre:'',
                    ue_direccion:'',
                    ue_logo:'',
                },
                variablefoto:0,
                errors:[],
            }

        },

        computed:{

            imagen(){
                return this.imagenMiniatura;
            }
            
        },

        methods: {

            obtenerImagen(e){
                let file = e.target.files[0];
                console.log(file);
                this.uejecutora.ue_logo = file;
                this.cargarImagen(file);
            },

            cargarImagen(file){
                let reader = new FileReader();
                
                reader.onload=(e)=>{
                    this.imagenMiniatura=e.target.result;
                    this.variablefoto=1;
                }
                
                reader.readAsDataURL(file);

            },

            MostrarUe() {
                var me = this;
                var url = 'uejecutora/index';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta = response.data;
                    me.uejecutora.ue_id=respuesta.ue_id;
                    me.uejecutora.ue_ruc=respuesta.ue_ruc,
                    me.uejecutora.ue_nombre=respuesta.ue_nombre,
                    me.uejecutora.ue_direccion=respuesta.ue_direccion,
                    me.imagenMiniatura = '/logoue/'+respuesta.ue_logo
                    me.ValidarRegistro();
                }).catch(function (error) {
                    console.log(error);
                });
            },

            ValidarRegistro(){

                if(!this.uejecutora.ue_id){
                    this.imagenMiniatura='logoue/defaultlogo.png';
                    Swal.fire('No Registran Datos, Registrar su Unidad Ejecutora');
                }
                    
            },

            registrarUejecutora() {

                this.errors=[];

                var me = this;

                 //Inicializar los datos del formularios
                let formData = new FormData();
                // Agregue los datos del formulario que necesitamos enviar
                formData.append('ue_ruc', this.uejecutora.ue_ruc);
                formData.append('ue_nombre', this.uejecutora.ue_nombre);
                formData.append('ue_direccion', this.uejecutora.ue_direccion);
                formData.append('ue_logo', this.uejecutora.ue_logo);

                axios.post('uejecutora/store',formData)
                    .then(function(response){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    me.MostrarUe();
                }).catch(function (error) {
                    console.log(error);
                    if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
                });
            },

            actualizarUejecutora() {

                this.errors=[];

                var me = this;

                 //Inicializar los datos del formularios
                let formData = new FormData();
                // Agregue los datos del formulario que necesitamos enviar
                formData.append('ue_id', this.uejecutora.ue_id);
                formData.append('ue_ruc', this.uejecutora.ue_ruc);
                formData.append('ue_nombre', this.uejecutora.ue_nombre);
                formData.append('ue_direccion', this.uejecutora.ue_direccion);
                formData.append('ue_logo', this.uejecutora.ue_logo);
                formData.append('variablefoto', this.variablefoto);

                 axios.post('uejecutora/update',formData)
                    .then(function(response){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    me.MostrarUe();
                }).catch(function (error) {
                    console.log(error);
                    if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
                });
            },

        },

        mounted() {
            this.MostrarUe();

        }
    }
</script>

 <style>

       input[type="file"]{
            display: none;
        }

        .labelfile{
            border-radius: 5px;
            padding: 9px 25px;
            font-size: 12px;
            text-decoration: none;
            color: #fff;
            position: relative;
            display: block;
            background-color: #337AB7;
            box-shadow: 0px 5px 0px 0px #286090;
            cursor: pointer;
            width: 140px;
            margin: auto;
        }

        .labelfile:hover {
            background-color: #286090;
        }

        .labelfile:active {
            transform: translate(0px, 5px);
            -webkit-transform: translate(0px, 5px);
            box-shadow: 0px 1px 0px 0px;
        }

        .fotologo{
            width:180px;
            height:200px;
            display: block;
            margin: auto;
            border: 1px solid;
            border-color:#2A3F54;
            border-top-left-radius: 5px;
            border-bottom-right-radius: 5px;
            margin-top: 15px;
        }

        .modal-content{
          width: 100% !important;
          position: absolute !important;
        }

        .mostrar{
          display:list-item !important;
          opacity: 1 !important;
          background-color: #3c29297a !important;
        }

        .div-error{
          display:flex;
          justify-content: center;
        }

        .error{
            color: red !important;
            margin-left: 5px;
        }

        .text-error{
          color: red !important;
          font-weight: bold;
        }

        .img-foto {
            width: 100px;
            height: 120px;
        }


        .btitulo1{
            font-weight: bold;
            font-size: 12px;
            }

            .btitulo2{
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 5px;
            }

            .btitulo3{
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 10px;
            text-align: center;
            }


        .tablarep {
                border-collapse: collapse;
                width: 100%;
            }

            .bordesuperior {
                border-top: 1px solid #000;
            }

            .bordeinferior {
                border-bottom: 1px solid #000;
            }

            .bordederecha {
                border-right: 1px solid #000;
            }

            .bordeizquierda {
                border-left: 1px solid #000;
            }

            .tablarep td, #tablarep th {
                /*border: 1px solid #ddd;*/
                padding: 2px;
                font-size: 12px;
                width: 16.66%;
            }

        .tablarep th {
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: #4CAF50;
                font-size: 10px;
                color: white;
        }
        
        .detallemontos{
            vertical-align: top;
        }

        .datospersonales{
            margin: 10px 0;
        }

        .montos{
            margin: 5px 0;
            height: 220px;
        }

        .totales{
            margin-bottom: 15px;
            height: 55px;
            width: 100%;
        }

        .alinearnumero{
            text-align: right;
        }

        .tabladet td, #tabladet th {
                font-size: 12px;
                width: 100%;
            }

        .mensajes{
            margin-bottom: 10px 0;
            width: 100%;
        }

        .checkbox-css{
            padding-top: 28px;
        }

</style>
