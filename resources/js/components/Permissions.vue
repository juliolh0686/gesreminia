<template>

<div class="right_col" role="main">
          <div class="">
          <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    
                <div class="x_title">
                    <h3>Permissions</h3>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action table-bordered">
                        <thead>
                          <tr class="headings">
                            <th class="column-title">Nº</th>
                            <th class="column-title">Nombre</th>
                          </tr>
                        </thead>

                        <tbody>
                        
                          <tr v-for="(permission,index) in arrayPermissions" :key="permission.id" class="even pointer">
                            <td class=" " v-text="index+pagination.from"></td>
                            <td class=" " v-text="permission.name"></td>
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
                arrayPermissions: [],
                criterio: 'name',
                modalSexo: 0,
                sexo:{
                    name:'',
                    username:'',
                },
                tituloModalsexo: '',
                tipoAccionsexo: 0,
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
            
        listarPermissions(page,buscar,criterio){
                let me=this;
                var url= 'permissions?page='+page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta = response.data;
                    me.arrayPermissions=respuesta.user.data;
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
                me.listarUsers(page,buscar,criterio);

            },


        abrirModalSexo(accion,data=[]){
            switch(accion){
                case 'registrar':
                {
                    this.modalSexo=1;
                    this.tituloModalsexo='Nuevo Sexo';
                    this.sexo.cod_sexo ='';
                    this.sexo.s_sexo='';
                    this.tipoAccionsexo=1;
                    document.getElementById("cod_sexo").disabled = false;
                    break;
                }
                case 'actualizar':
                {
                    this.modalSexo = 1;
                    this.tituloModalsexo = "Editar Sexo";
                    this.sexo.cod_sexo = data['cod_sexo'];
                    this.sexo.s_sexo = data['s_sexo'];
                    document.getElementById("cod_sexo").disabled = true;
                    this.tipoAccionsexo = 2;
                    break;
                }
            }
        
        },

        cerrarModalSexo(){
            this.modalSexo = 0;
            this.tituloModalSexo = '';
        },

        registrarSexo() {

            this.errors=[];

            var me = this;

            axios.post('sexo/store', {
                'cod_sexo' : me.sexo.cod_sexo,
                's_sexo' : me.sexo.s_sexo,
            }).then(function (response) {
                me.cerrarModalSexo();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarSexo(1, '', 's_sexo');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },

        actualizarSexo() {

            this.errors=[];
        
            var me = this;

            axios.put('sexo/update', {
                'cod_sexo': me.sexo.cod_sexo,
                's_sexo' : me.sexo.s_sexo,
            }).then(function (response) {
                me.cerrarModalSexo();
                Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Proceso Realizado con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                    })
                me.listarSexo(1, '', 's_sexo');
            }).catch(function (error) {
                console.log(error);
                if(error.response.status==422){
                        me.errors=error.response.data.errors;
                    }
            });
        },


    eliminarSexo(id){
            
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
                    axios.put('sexo/destroy', {
                        'cod_sexo': id
                    }).then(function (response) {
                        me.listarSexo(1, '', 's_sexo');
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
            this.listarPermissions(1,this.buscar,this.criterio);
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
