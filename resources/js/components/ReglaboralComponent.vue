<template>
  <div class="right_col" role="main">
    <div class="">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">  
            <div class="x_title">
              <h3>Regimen Laboral</h3>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <button type="button" @click="abrirModalReglaboral('registrar')" class="btn btn-primary float-right">
                <i class="icon-plus"></i>&nbsp;Nuevo
              </button>
          
              <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <select class="form-control" v-model="criterio">
                    <option value="rl_regimen_laboral">Regimen Laboral</option>
                    <option value="cod_regimen_laboral">Codigo Regimen Laboral</option>
                  </select>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <input type="text" v-model="buscar" @keyup.enter="listarReglaboral(1,buscar,criterio)" class="form-control">
                </div>
                <button type="submit" @click="listarReglaboral(1,buscar,criterio)" class="btn btn-primary">Buscar</button>
              </div>
  

              <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action table-bordered">
                  <thead>
                    <tr class="headings">
                      <th class="column-title">Nº</th>
                      <th class="column-title">Codigo</th>
                      <th class="column-title">Regimen Laboral</th>
                      <th class="column-title no-link last"  colspan="3" style="text-align:center;"><span class="nobr">Acciones</span></th>
                    </tr>
                  </thead>

                  <tbody>
                  
                    <tr v-for="(reglaboral,index) in arrayReglaboral" :key="reglaboral.cod_regimen_laboral" class="even pointer">
                      <td class=" " v-text="index+pagination.from"></td>
                      <td class=" " v-text="reglaboral.cod_regimen_laboral"></td>
                      <td class=" " v-text="reglaboral.rl_regimen_laboral"></td>
                      <td>
                      <button type="button" @click="abrirModalReglaboral('actualizar',reglaboral)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                      <button type="button" @click="eliminarReglaboral(reglaboral.cod_regimen_laboral)" title='Eliminar' class="btn btn-danger btn-sm" disabled><i class="fa fa-trash"></i></button>
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
        <div class="modal fade" :class="{'mostrar':modalReglaboral}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-primary" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" @click="cerrarModalReglaboral()"><span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title" id="myModalLabel" v-text="tituloModalreglaboral"></h3> 
                  </div>
                  <div class="modal-body">

                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                          <div class="form-group row">
                                <div class="col-md-2">
                                  <label for="text-input">Codigo</label>
                                  <input type="text" v-model="reglaboral.cod_regimen_laboral" id="cod_regimen_laboral" class="form-control">
                                  <span v-if="errors.cod_regimen_laboral" class="error">{{errors.cod_regimen_laboral[0]}}</span>
                              </div>

                              <div class="col-md-10">
                                  <label for="text-input">Regimen Laboral</label>
                                  <input type="text" v-model="reglaboral.rl_regimen_laboral" class="form-control">
                                  <span v-if="errors.rl_regimen_laboral" class="error">{{errors.rl_regimen_laboral[0]}}</span>
                              </div>
                              
                          </div>

                      </form>

                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-info" @click="cerrarModalReglaboral()">Cerrar</button>
                      <button type="button" v-if="tipoAccionreglaboral==1" class="btn btn-primary" @click="registrarReglaboral()">Guardar</button>
                      <button type="button" v-if="tipoAccionreglaboral==2" class="btn btn-primary" @click="actualizarReglaboral()">Actualizar</button>
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
                arrayReglaboral: [],
                criterio: 'rl_regimen_laboral',
                modalReglaboral: 0,
                reglaboral:{
                    cod_regimen_laboral:'',
                    rl_regimen_laboral:'',
                },
                tituloModalreglaboral: '',
                tipoAccionreglaboral: 0,
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
            
        listarReglaboral(page,buscar,criterio){
                let me=this;
                var url= 'regimenlaboral/index?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayReglaboral=respuesta.reglaboral.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });

            },

        cambiarPagina(page,buscar,criterio){

                let me = this;
                //actualizar la pagina actual
                me.pagination.current_page=page;
                //envia la peticion para visualizar la data de esa pagina
                me.listarReglaboral(page,buscar,criterio);

            },


        abrirModalReglaboral(accion,data=[]){
            switch(accion){
                case 'registrar':
                {
                    this.modalReglaboral=1;
                    this.tituloModalreglaboral='Nuevo Regimen';
                    this.reglaboral.cod_regimen_laboral='';
                    this.reglaboral.rl_regimen_laboral='';
                    this.tipoAccionreglaboral=1;
                    document.getElementById("cod_regimen_laboral").disabled = false;
                    break;
                }
                case 'actualizar':
                {
                    this.modalReglaboral = 1;
                    this.tituloModalreglaboral = "Editar Regimen";
                    this.reglaboral.cod_regimen_laboral = data['cod_regimen_laboral'];
                    this.reglaboral.rl_regimen_laboral = data['rl_regimen_laboral'];
                    document.getElementById("cod_regimen_laboral").disabled = true;
                    this.tipoAccionreglaboral = 2;
                    break;
                }
            }
        
        },

        cerrarModalReglaboral(){
            this.modalReglaboral = 0;
            this.tituloModalreglaboral = '';
        },

        registrarReglaboral() {

            this.errors=[];

            var me = this;

            axios.post('regimenlaboral/store', {
                'cod_regimen_laboral': me.reglaboral.cod_regimen_laboral,
                'rl_regimen_laboral': me.reglaboral.rl_regimen_laboral,
            }).then(function (response) {
                me.cerrarModalReglaboral();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarReglaboral(1, '', 'rl_regimen_laboral');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        actualizarReglaboral() {

            this.errors=[];
        
            var me = this;

            axios.put('regimenlaboral/update', {
                'cod_regimen_laboral': me.reglaboral.cod_regimen_laboral,
                'rl_regimen_laboral': me.reglaboral.rl_regimen_laboral,
            }).then(function (response) {
                me.cerrarModalReglaboral();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarReglaboral(1, '', 'rl_regimen_laboral');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },


    eliminarReglaboral(id){
            
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
                    axios.put('regimenlaboral/destroy', {
                        'cod_regimen_laboral': id
                    }).then(function (response) {
                        me.listarReglaboral(1, '', 'rl_regimen_laboral');
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
            this.listarReglaboral(1,this.buscar,this.criterio);
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
