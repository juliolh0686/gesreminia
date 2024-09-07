<template>
  <div class="right_col" role="main">
    <div class="">
      <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">  
            <div class="x_title">
              <h3>Areas</h3>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <button type="button" @click="abrirModalArea('registrar')" class="btn btn-primary float-right">
                <i class="icon-plus"></i>&nbsp;Nuevo
              </button>
          
              <div class="row">
                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <select class="form-control" v-model="criterio">
                    <option value="a_area">Area</option>
                    <option value="a_cod_area">Codigo Area</option>
                  </select>
                </div>
                <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <input type="text" v-model="buscar" @keyup.enter="listarArea(1,buscar,criterio)" class="form-control">
                </div>
                <button type="submit" @click="listarArea(1,buscar,criterio)" class="btn btn-primary">Buscar</button>
              </div>
  

              <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action table-bordered">
                  <thead>
                    <tr class="headings">
                      <th class="column-title">Nº</th>
                      <th class="column-title">Codigo</th>
                      <th class="column-title">Area</th>
                      <th class="column-title">Area Abreviado</th>
                      <th class="column-title no-link last"  colspan="3" style="text-align:center;"><span class="nobr">Acciones</span></th>
                    </tr>
                  </thead>

                  <tbody>
                  
                    <tr v-for="(area,index) in arrayArea" :key="area.a_cod_area" class="even pointer">
                      <td class=" " v-text="index+pagination.from"></td>
                      <td class=" " v-text="area.a_cod_area"></td>
                      <td class=" " v-text="area.a_area"></td>
                      <td class=" " v-text="area.a_abrev_area"></td>
                      <td>
                      <button type="button" @click="abrirModalArea('actualizar',area)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                      <button type="button" @click="eliminarArea(area.a_cod_area)" title='Eliminar' class="btn btn-danger btn-sm" disabled><i class="fa fa-trash"></i></button>
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
        <div class="modal fade" :class="{'mostrar':modalArea}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-primary" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" @click="cerrarModalArea()"><span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title" id="myModalLabel" v-text="tituloModalarea"></h3> 
                  </div>
                  <div class="modal-body">

                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                          <div class="form-group row">
                                <div class="col-md-2">
                                  <label for="text-input">Codigo</label>
                                  <input type="text" v-model="area.a_cod_area" id="a_cod_area" class="form-control">
                                  <span v-if="errors.a_cod_area" class="error">{{errors.a_cod_area[0]}}</span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <div class="col-md-12">
                                  <label for="text-input">Area</label>
                                  <input type="text" v-model="area.a_area" class="form-control">
                                  <span v-if="errors.a_area" class="error">{{errors.a_area[0]}}</span>
                              </div>
                          </div>

                          <div class="form-group row">
                              <div class="col-md-12">
                                  <label for="text-input">Area Abreviado</label>
                                  <input type="text" v-model="area.a_abrev_area" class="form-control">
                                  <span v-if="errors.a_abrev_area" class="error">{{errors.a_abrev_area[0]}}</span>
                              </div>
                          </div>

                      </form>

                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-info" @click="cerrarModalArea()">Cerrar</button>
                      <button type="button" v-if="tipoAccionarea==1" class="btn btn-primary" @click="registrarArea()">Guardar</button>
                      <button type="button" v-if="tipoAccionarea==2" class="btn btn-primary" @click="actualizarArea()">Actualizar</button>
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
                arrayArea: [],
                criterio: 'a_area',
                modalArea: 0,
                area:{
                    a_cod_area:'',
                    a_area:'',
                    a_abrev_area:'',
                },
                tituloModalarea: '',
                tipoAccionarea: 0,
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
            
        listarArea(page,buscar,criterio){
                let me=this;
                var url= 'area/index?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayArea=respuesta.area.data;
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
                me.listarArea(page,buscar,criterio);

            },


        abrirModalArea(accion,data=[]){
            switch(accion){
                case 'registrar':
                {
                    this.modalArea=1;
                    this.tituloModalarea='Nueva Area';
                    this.area.a_cod_area='';
                    this.area.a_area='';
                    this.area.a_abrev_area='';
                    this.tipoAccionarea=1;
                    document.getElementById("a_cod_area").disabled = false;
                    break;
                }
                case 'actualizar':
                {
                    this.modalArea = 1;
                    this.tituloModalarea = "Editar Area";
                    this.area.a_cod_area = data['a_cod_area'];
                    this.area.a_area = data['a_area'];
                    this.area.a_abrev_area = data['a_abrev_area'];
                    document.getElementById("a_cod_area").disabled = true;
                    this.tipoAccionarea = 2;
                    break;
                }
            }
        
        },

        cerrarModalArea(){
            this.modalArea = 0;
            this.tituloModalarea = '';
        },

        registrarArea() {

            this.errors=[];

            var me = this;

            axios.post('area/store', {
                'a_cod_area': me.area.a_cod_area,
                'a_area': me.area.a_area,
                'a_abrev_area': me.area.a_abrev_area,
            }).then(function (response) {
                me.cerrarModalArea();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarArea(1, '', 'a_area');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        actualizarArea() {

            this.errors=[];
        
            var me = this;

            axios.put('area/update', {
                'a_cod_area': me.area.a_cod_area,
                'a_area': me.area.a_area,
                'a_abrev_area': me.area.a_abrev_area,
            }).then(function (response) {
                me.cerrarModalArea();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarArea(1, '', 'a_area');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },


    eliminarArea(id){
            
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
                    axios.put('area/destroy', {
                        'a_cod_area': id
                    }).then(function (response) {
                        me.listarArea(1, '', 'a_area');
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
            this.listarArea(1,this.buscar,this.criterio);
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
