<template>

<div class="right_col" role="main">
    <div class="">
    <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
          <div class="x_panel">
              
          <div class="x_title">
              <h3>Distritos</h3>
              <div class="clearfix"></div>
          </div>
          <div class="x_content">

          
          <button type="button" @click="abrirModalDistrito('registrar')" class="btn btn-primary float-right">
                      <i class="icon-plus"></i>&nbsp;Nuevo
          </button>
          
          <div class="row">
              <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <select class="form-control" v-model="criterio">
                      <option value="cod_distrito">Codigo Distrito</option>
                      <option value="dis_distrito">Distrito</option>
                  </select>
              </div>
              <div class="col-md-3 col-sm-12 col-xs-12 form-group">
                  <input type="text" v-model="buscar" @keyup.enter="listarDistritos(1,buscar,criterio)" class="form-control">
              </div>
              <button type="submit" @click="listarDistritos(1,buscar,criterio)" class="btn btn-primary">Buscar</button>
          </div>
  

              <div class="table-responsive">
                <table class="table table-striped jambo_table bulk_action table-bordered">
                  <thead>
                    <tr class="headings">
                      <th class="column-title">Nº</th>
                      <th class="column-title">Codigo</th>
                      <th class="column-title">Distrito</th>
                      <th class="column-title no-link last" style="text-align:center;"><span class="nobr">Acciones</span></th>
                    </tr>
                  </thead>

                  <tbody>
                  
                    <tr v-for="(distrito,index) in arrayDistritos" :key="distrito.cod_distrito" class="even pointer">
                      <td class=" " v-text="index+pagination.from"></td>
                      <td class=" " v-text="distrito.cod_distrito"></td>
                      <td class=" " v-text="distrito.dis_distrito"></td>
                      <td>
                      <button type="button" @click="abrirModalDistrito('actualizar',distrito)" title='Editar' class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                      <button type="button" @click="eliminarProvincia(distrito.cod_distrito)" title='Eliminar' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
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
        <div class="modal fade" :class="{'mostrar':modalDistrito}" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-primary" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" @click="cerrarModalDistrito()"><span aria-hidden="true">&times;</span></button>
                      <h3 class="modal-title" id="myModalLabel" v-text="tituloModaldistrito"></h3> 
                  </div>
                  <div class="modal-body">

                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

                          <div class="form-group row">
                          <div class="col-md-12">
                          <label for="text-input">Departamento</label>
                              <select class="form-control" v-model="distritos.departamento_cod_departamento"  @change="selectProvincias(distritos.departamento_cod_departamento)">
                                  <option value="0" disabled>Seleccione</option>
                                  <option v-for="departamento in arrayDepartamento" :key="departamento.cod_departamento" :value="departamento.cod_departamento" v-text="departamento.dep_departamento"></option>
                              </select>
                              <span v-if="errors.iddepartamento" class="error">{{errors.iddepartamento[0]}}</span>
                          </div>
                          </div>

                          <div class="form-group row">
                          <div class="col-md-12">
                          <label for="text-input">Provincia</label>
                              <select class="form-control" v-model="distritos.provincia_cod_provincia">
                                  <option value="0" disabled>Seleccione</option>
                                  <option v-for="provincia in arrayProvincia" :key="provincia.cod_provincia" :value="provincia.cod_provincia" v-text="provincia.pro_provincia"></option>
                              </select>
                              <span v-if="errors.iddepartamento" class="error">{{errors.iddepartamento[0]}}</span>
                          </div>
                          </div>

                          <div class="form-group row">
                                <div class="col-md-2">
                                  <label for="text-input">Codigo</label>
                                  <input type="text" v-model="distritos.cod_distrito" id="cod_distrito" class="form-control">
                                  <span v-if="errors.cod_provincia" class="error">{{errors.cod_provincia[0]}}</span>
                              </div>

                              <div class="col-md-10">
                                  <label for="text-input">Distrito</label>
                                  <input type="text" v-model="distritos.dis_distrito" class="form-control">
                                  <span v-if="errors.pro_provincia" class="error">{{errors.pro_provincia[0]}}</span>
                              </div>
                              
                          </div>

                      </form>

                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-info" @click="cerrarModalDistrito()">Cerrar</button>
                      <button type="button" v-if="tipoAcciondistrito==1" class="btn btn-primary" @click="registrarDistrito()">Guardar</button>
                      <button type="button" v-if="tipoAcciondistrito==2" class="btn btn-primary" @click="actualizarDistrito()">Actualizar</button>
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
          arrayDistritos: [],
          arrayProvincia: [],
          arrayDepartamento:[],
          criterio: 'dis_distrito',
          modalDistrito: 0,
          distritos:{
              cod_distrito:'',
              dis_distrito:'',
              provincia_cod_provincia:'',
              departamento_cod_departamento:'',
          },
          tituloModaldistrito: '',
          tipoAcciondistrito: 0,
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
          
      listarDistritos(page,buscar,criterio){
              let me=this;
              var url= 'distrito/index?page='+page+'&buscar='+buscar+'&criterio='+criterio;
              axios.get(url).then(function (response) {
                  var respuesta = response.data;
                  me.arrayDistritos=respuesta.distritos.data;
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

      selectProvincias(iddepartamento) {
        var me = this;
        var url = 'provincia/selectProvincia?iddepartamento='+iddepartamento;
        axios.get(url).then(function (response) {
            // console.log(response);
            var respuesta = response.data;
            me.arrayProvincia = respuesta.provincia;
        }).catch(function (error) {
            console.log(error);
        });
      },

      cambiarPagina(page,buscar,criterio){

              let me = this;
              //actualizar la pagina actual
              me.pagination.current_page=page;
              //envia la peticion para visualizar la data de esa pagina
              me.listarDistritos(page,buscar,criterio);

          },


      abrirModalDistrito(accion,data=[]){
          switch(accion){
              case 'registrar':
              {
                  this.modalDistrito=1;
                  this.tituloModaldistrito='Nuevo Distrito';
                  this.distritos.cod_distrito ='';
                  this.distritos.dis_distrito='';
                  this.distritos.departamento_cod_departamento = '';
                  this.distritos.provincia_cod_provincia = '';
                  this.tipoAcciondistrito=1;
                  document.getElementById("cod_distrito").disabled = false;
                  break;
              }
              case 'actualizar':
              {
                  this.modalDistrito = 1;
                  this.tituloModalprovincia= "Editar Distrito";
                  this.distritos.departamento_cod_departamento = data['departamento_cod_departamento'];
                  this.selectProvincias(this.distritos.departamento_cod_departamento);
                  this.distritos.provincia_cod_provincia = data['provincia_cod_provincia'];
                  this.distritos.cod_distrito = data['cod_distrito'];
                  this.distritos.dis_distrito = data['dis_distrito'];
                  document.getElementById("cod_distrito").disabled = true;
                  this.tipoAcciondistrito = 2;
                  break;
              }
          }
      
      },

      cerrarModalDistrito(){
          this.modalDistrito = 0;
          this.tituloModaldistrito = '';
      },

      registrarDistrito() {

          this.errors=[];

          var me = this;

          axios.post('distrito/store', {
              'cod_distrito' : me.distritos.cod_distrito,
              'dis_distrito' : me.distritos.dis_distrito,
              'provincia_cod_provincia' : me.distritos.provincia_cod_provincia,
          }).then(function (response) {
              me.cerrarModalDistrito();
              Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Proceso Realizado con Éxito',
                      showConfirmButton: false,
                      timer: 1500
                  })
              me.listarDistritos(1, '', 'dis_distrito');
          }).catch(function (error) {
              console.log(error);
              if(error.response.status==422){
                      me.errors=error.response.data.errors;
                  }
          });
      },

      actualizarDistrito() {

          this.errors=[];
      
          var me = this;

          axios.put('distrito/update', {
              'cod_distrito' : me.distritos.cod_distrito,
              'dis_distrito' : me.distritos.dis_distrito,
              'provincia_cod_provincia' : me.distritos.provincia_cod_provincia,
          }).then(function (response) {
              me.cerrarModalDistrito();
              Swal.fire({
                      position: 'top-end',
                      icon: 'success',
                      title: 'Proceso Realizado con Éxito',
                      showConfirmButton: false,
                      timer: 1500
                  })
              me.listarDistritos(1, '', 'dis_distrito');
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
                  axios.put('distrito/destroy', {
                      'cod_distrito' : id,
                  }).then(function (response) {
                      me.listarDistritos(1, '', 'dis_distrito');
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
          this.listarDistritos(1,this.buscar,this.criterio);
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
