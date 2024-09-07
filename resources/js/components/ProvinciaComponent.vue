<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Provincias</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                
                <button type="button" @click="abrirModalProvincia('registrar')" class="btn btn-primary float-right">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                </button>
               
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <select class="form-control" v-model="criterio">
                            <option value="cod_provincia">Codigo Provincia</option>
                            <option value="pro_provincia">Provincia</option>
                        </select>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                        <input type="text" v-model="buscar" @keyup.enter="listarProvincia(1,buscar,criterio)" class="form-control">
                    </div>
                    <button type="submit" @click="listarProvincia(1,buscar,criterio)" class="btn btn-primary">Buscar</button>
                </div>
       

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
                            <th class="column-title">Codigo</th>
                            <th class="column-title">Provincia</th>
                            <th class="column-title no-link last" style="text-align:center;"><span class="nobr">Acciones</span></th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(provincia,index) in arrayProvincia" :key="provincia.cod_provincia" class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="provincia.cod_provincia"></td>
                            <td class=" " v-text="provincia.pro_provincia"></td>
                            <td>
                            <button type="button" @click="abrirModalProvincia('actualizar',provincia)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                            <button type="button" @click="eliminarProvincia(provincia.cod_provincia)" title='Eliminar' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                            </td>
                          </tr>
                          
                        </tbody>
                      </table>
                      <nav>
                          <ul class="pagination">
                              <li class="page-item" v-if="pagination.current_page>1">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio)">Anterior</a>
                              </li>
                               <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active':'']">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page">1</a>
                              </li>
                               <li class="page-item" v-if="pagination.current_page<pagination.last_page">
                                  <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Siguiente</a>
                              </li>
                          </ul>
                      </nav>
                    </div>

				<!--Inicio del modal agregar/actualizar planilla-->
              <div class="modal fade" :class="{'mostrar':modalProvincia}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" @click="cerrarModalprovincia()"><span aria-hidden="true">&times;</span></button>
                            <h3 class="modal-title" id="myModalLabel" v-text="tituloModalprovincia"></h3> 
                        </div>
                        <div class="modal-body">

                             <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                <div class="col-md-12">
                                <label for="text-input">Departamento</label>
                                    <select class="form-control" v-model="provincia.departamento_cod_departamento"  @change="selectProvincia(provincia.departamento_cod_departamento)">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="departamento in arrayDepartamento" :key="departamento.cod_departamento" :value="departamento.cod_departamento" v-text="departamento.dep_departamento"></option>
                                    </select>
                                    <span v-if="errors.iddepartamento" class="error">{{errors.iddepartamento[0]}}</span>
                                </div>
                                </div>

                                <div class="form-group row">
                                     <div class="col-md-2">
                                        <label for="text-input">Codigo</label>
                                        <input type="text" v-model="provincia.cod_provincia" id="cod_provincia" class="form-control">
                                        <span v-if="errors.cod_provincia" class="error">{{errors.cod_provincia[0]}}</span>
                                    </div>

                                    <div class="col-md-10">
                                        <label for="text-input">Provincia</label>
                                        <input type="text" v-model="provincia.pro_provincia" class="form-control">
                                        <span v-if="errors.pro_provincia" class="error">{{errors.pro_provincia[0]}}</span>
                                    </div>
                                    
                                </div>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-info" @click="cerrarModalprovincia()">Cerrar</button>
                            <button type="button" v-if="tipoAccionprovincia==1" class="btn btn-primary" @click="registrarProvincia()">Guardar</button>
                            <button type="button" v-if="tipoAccionprovincia==2" class="btn btn-primary" @click="actualizarProvincia()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
						
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
                arrayProvincia: [],
                arrayDepartamento:[],
                criterio: 'pro_provincia',
                modalProvincia: 0,
                provincia:{
                    cod_provincia:'',
                    pro_provincia:'',
                    departamento_cod_departamento:'',
                },
                tituloModalprovincia: '',
                tipoAccionprovincia: 0,
                buscar: '',
                pagination: {
                    'total': 0,
                    'current_page': 0,
                    'per_page': 0,
                    'last_page': 0,
                    'from': 0,
                    'to': 0
                },
                errors:[],
                offset: 3,
               
            }

        },

        computed:{
            isActived:function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginacion
            pagesNumber: function(){
                if (!this.pagination.to) {
                return [];
                }

                var from = this.pagination.current_page - this.offset;
                    if (from < 1) {
                        from = 1;
                    }

                var to = from + (this.offset*2);
                if(to >= this.pagination.last_page){
                    to=this.pagination.last_page;
                }

                var pagesArray=[];
                while(from <=to){
                    pagesArray.push(from);
                    from++;
                }

                return pagesArray;

            }
        },

        methods: {
            
        listarProvincia(page,buscar,criterio){
                let me=this;
                var url= 'provincia/index?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayProvincia=respuesta.provincia.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

            selectDepartamento() {
            var me = this;
            var url = 'departamentos/selectDepartamento';
            axios.get(url).then(function (response) {
                // console.log(response);
                var respuesta = response.data;
                me.arrayDepartamento = respuesta.departamento;
            }).catch(function (error) {
                console.log(error);
            });
        },

        cambiarPagina(page,buscar,criterio){

                let me = this;
                //actualizar la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarProvincia(page,buscar,criterio);

            },


        abrirModalProvincia(accion,data=[]){
            switch(accion){
                case 'registrar':
                {
                    this.modalProvincia=1;
                    this.tituloModalprovincia='Nueva Provincia';
                    this.provincia.cod_provincia ='';
                    this.provincia.pro_provincia='';
                    this.provincia.departamento_cod_departamento = '';
                    this.tipoAccionprovincia=1;
                    document.getElementById("cod_provincia").disabled = false;
                    break;
                }
                case 'actualizar':
                {
                    this.modalProvincia = 1;
                    this.tituloModalprovincia= "Editar Provincia";
                    this.provincia.cod_provincia = data['cod_provincia'];
                    this.provincia.pro_provincia = data['pro_provincia'];
                    this.provincia.departamento_cod_departamento = data['departamento_cod_departamento'];
                    document.getElementById("cod_provincia").disabled = true;
                    this.tipoAccionprovincia = 2;
                    break;
                }
            }
        
        },

        cerrarModalprovincia(){
            this.modalProvincia = 0;
            this.tituloModalprovincia = '';
        },

        registrarProvincia() {

            this.errors=[];

            var me = this;

            axios.post('provincia/store', {
                'cod_provincia' : me.provincia.cod_provincia,
                'pro_provincia' : me.provincia.pro_provincia,
                'departamento_cod_departamento' : me.provincia.departamento_cod_departamento,
            }).then(function (response) {
                me.cerrarModalprovincia();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarProvincia(1, '', 'pro_provincia');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        actualizarProvincia() {

            this.errors=[];
        
            var me = this;

            axios.put('provincia/update', {
                'cod_provincia' : me.provincia.cod_provincia,
                'pro_provincia' : me.provincia.pro_provincia,
                'departamento_cod_departamento' : me.provincia.departamento_cod_departamento,
            }).then(function (response) {
                me.cerrarModalprovincia();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarProvincia(1, '', 'pro_provincia');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },


    eliminarProvincia(id){
            
            let me=this;

            Swal.fire({
                title: '¿Estas seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Si, elimínalo!',
                cancelButtonText: '¡No, cancelar!',
                }).then((result) => {
                if (result.value) {
                    axios.put('provincia/destroy', {
                        'cod_provincia' : me.provincia.cod_provincia,
                    }).then(function (response) {
                        me.listarProvincia(1, '', 'cod_provincia');
                         Swal.fire(
                            '¡Eliminado!',
                            'Registro Eliminado.',
                            'success'
                            )
                    }).catch(function (error) {
                        console.log(error);
                    });
                   
                }
                })
        }

        },
        mounted() {
            this.listarProvincia(1,this.buscar,this.criterio);
            this.selectDepartamento();
        }
    }
</script>

 <style>

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

        .text-error{
          color: red !important;
          font-weight: bold;
        }

</style>
