<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;"><button class="btn btn-outline-secondary float-right"  type="button" @click="nuevo"> Nuevo </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Proyectos</h4></div>
        <br>
        <div class="table-responsive">
            <vue-good-table
            :columns="listarProyectos.columns"
            :rows="listarProyectos.data"
            :search-options="{
                enabled: true,
                placeholder: 'Buscar en la tabla',
            }"
            :pagination-options="{
                enabled: true,
                mode: 'pages',
                nextLabel: 'Sig',
                prevLabel: 'Ant',
                rowsPerPageLabel: 'Registros por página',
                ofLabel: 'de',
                pageLabel: 'Página', // for 'pages' mode
                allLabel: 'Todo',
            }"
            >
            <template slot="table-row" slot-scope="props">
                <span v-if="props.column.field == 'options'">
                <button class="btn btn-outline-secondary btn-sm btn-icon" @click.prevent="ver(props.row, props.index)" data-toggle="tooltip" title="Ver"><i class="fas fa-eye"></i></button>
                <button class="btn btn-outline-info btn-sm btn-icon" @click.prevent="editar(props.row, props.index)" data-toggle="tooltip" title="Editar"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-outline-danger btn-sm btn-icon" @click.prevent="eliminar(props.row, props.index)" data-toggle="tooltip" title="Eliminar"><i class="fas fa-trash-alt"></i></button>
                </span>
            </template>
            </vue-good-table>
        </div>
        <!-- Modal -->
        <template>
            <div class="modal fade" id="modal-proyecto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle" v-text="modal.titulo"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form" data-vv-scope="form_registro">
                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Nombre</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.proyecto.nombre"
                                    class="form-control"
                                    data-vv-as="Nombre"
                                    placeholder="Nombre"
                                    name="nombre"
                                    v-validate="'required|max:500'">
                                    <span class="text-danger">{{errors.first("form_registro.nombre")}}</span>
                                </div>

                                <div class="form-group">
                                    <p class="m-0">
                                        <strong>Descripción</strong>
                                    </p>
                                    <input type="text"
                                    v-model="modal.proyecto.descripcion"
                                    class="form-control"
                                    data-vv-as="Descripcion"
                                    placeholder="Descripcion"
                                    name="descripcion"
                                    v-validate="'required|max:5000'">
                                    <span class="text-danger">{{errors.first("form_registro.descripcion")}}</span>
                                </div>
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                  <li class="nav-item" role="presentation" @click="cambiarTipo()">
                                    <button class="nav-link active" id="link-tab" data-toggle="tab" data-target="#link" type="button" role="tab" aria-controls="link" aria-selected="true">Copiar Link PDF</button>
                                  </li>
                                  <li class="nav-item" role="presentation" @click="cambiarTipo()">
                                    <button class="nav-link" id="upload-tab" data-toggle="tab" data-target="#upload" type="button" role="tab" aria-controls="upload" aria-selected="false">Subir archivo PDF</button>
                                  </li>
                                </ul>
                                <div class="tab-content" id="myTabContent">
                                  <div class="tab-pane fade show active" id="link" role="tabpanel" aria-labelledby="link-tab">
                                    <div class="form-group" v-if="!modal.proyecto.subido">
                                        <p class="m-0">
                                            <strong>URL</strong>
                                        </p>
                                        <input type="text"
                                        v-model="modal.proyecto.url"
                                        class="form-control"
                                        data-vv-as="URL"
                                        placeholder="URL"
                                        name="url"
                                        v-validate="'required|max:500'">
                                        <span class="text-danger">{{errors.first("form_registro.url")}}</span>
                                    </div>
                                  </div>
                                  <div class="tab-pane fade" id="upload" role="tabpanel" aria-labelledby="upload-tab">
                                    <div class="form-group" v-if="modal.proyecto.subido">
                                        <p class="m-0">
                                            <strong>Ubicación</strong>
                                        </p>

                                        <div class="form-group row">
                                            <div class="col-md-12">                                        
                                                <input type="file" name="url" data-vv-as="URL" id="url" class="form-control" accept="application/pdf" v-validate="'required|max:500'"> 
                                            </div>
                                        </div>
                                        <span class="text-danger">{{errors.first("form_registro.url")}}</span>
                                    </div>
                                  </div>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cerrar</button>
                            <button type="button" v-if="modal.tipo == 'nuevo'" class="btn btn-primary" @click="guardar">Guardar</button>
                            <button type="button" v-else-if="modal.tipo == 'editar'" class="btn btn-primary" @click="modificar">Actualizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>

<script>

import Multiselect from "vue-multiselect";
import Helper from "../../services/helper";
import Crypt from "../../services/Crypt";

    export default {
        name:'Ayudas',
        components:{
            Multiselect,
        },
        data(){
            return{
                listarProyectos:{
                    data: [],
                    columns:[
                        {label: 'Nombre', field: 'nombre',},
                        {label: 'Descripción', field: 'descripcion',},
                        {label: 'Inicio', field: 'fecha_inicio',},
                        {label: 'Fin', field: 'fecha_fin',},
                        {label: 'Estado', field: 'estado',},
                        {label: 'Opciones', field: 'options',},
                    ],
                    total: 0,
                    filtrosBusqueda:{
                        tipo:'',
                        orden: 'asc',
                        ordenPor: 'id',
                        regPagina: '10',
                    },
                    deshabilitarEdicion: false,
                },
                listarGradoCurso:[],
                deshabilitado: false,
                modal:{
                    tipo: '',
                    titulo:  '',
                    nivelID: null,
                    id_lib_cur: null,
                    proyecto:{
                        nombre:  '',
                        autor: '',
                        descripcion:'',
                        url:'',
                        subido: false,
                        id_grado_cur:'',
                    },

                },
                curso: null,
                listarNiveles:[],
                listarGrados: [],
                listarCursos: [],
                editarDocumento: false,
                documento: '',

            }
        },
        created(){
            this.listarProyecto();
        },
        methods:{
            listarProyecto(){
                axios.get("api/proyecto/listar"+Helper.getFilterURL(this.listarProyectos.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    this.listarProyectos.data = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                }); 
            },
        limpiarFormulario(){
                this.modal = {
                    titulo:  '',
                    id_lib_cur: null,
                    nivelID: null,
                    proyecto:{
                        nombre:  '',
                        autor: '',
                        descripcion:'',
                        url:'',
                        subido: false,
                        id_grado_cur:'',
                    },
                    deshabilitado: false,   
                }
                this.listarCursos = null;
                this.$validator.reset();
            },
            nuevo(){
                $("#modal-proyecto").modal('show');
                this.limpiarFormulario();
                this.modal.titulo = 'Nuevo proyecto';
                this.modal.tipo = 'nuevo';

            },
            ver(row, index){
                $("#modal-proyecto").modal('show');
                this.limpiarFormulario();
                this.listarGrado(row.grado_curso.grado.id_nivel);
                this.listarCurso(row.grado_curso.id_grado);
                this.modal = {
                    titulo:  'Ver proyecto',
                    tipo: 'ver',
                    id_proyecto: row.id,
                    nivelID: row.grado_curso.grado.id_nivel,
                    proyecto:{
                        nombre: row.nombre,
                        autor: row.autor,
                        descripcion: row.descripcion,
                        url: row.url,
                        subido: row.subido,
                        id_grado_cur: row.id_grado_cur,
                    },
                    grado_curso: row.grado_curso,
                    deshabilitado: true,
                }
            },
            editar(row, index){
                $("#modal-proyecto").modal('show');
                this.limpiarFormulario();
                this.listarGrado(row.grado_curso.grado.id_nivel)
                this.listarCurso(row.grado_curso.id_grado);
                this.modal = {
                    titulo:  'Editar proyecto',
                    tipo: 'editar',
                    id_proyecto: row.id,
                    nivelID: row.grado_curso.grado.id_nivel,
                    proyecto:{
                        nombre: row.nombre,
                        autor: row.autor,
                        descripcion: row.descripcion,
                        url: row.url,
                        subido: row.subido,
                        id_grado_cur: row.id_grado_cur,
                    },
                    grado_curso: row.grado_curso,
                    deshabilitado: false
                }
            },
            guardar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) { 

                        if(this.modal.proyecto.subido){
                            let _this = this;
                            let data = new FormData();
                            data.append('url', document.getElementById('url').files[0]);
                            data.append('nombre', _this.modal.proyecto.nombre);
                            data.append('autor', _this.modal.proyecto.autor);
                            data.append('descripcion', _this.modal.proyecto.descripcion);
                            data.append('subido', _this.modal.proyecto.subido);
                            data.append('id_grado_cur', _this.modal.proyecto.id_grado_cur);
                            axios.post("api/proyecto/crear", data)
                            .then((response) => {
                                this.$toastr.s(response.data.message);
                                $("#modal-proyecto").modal('hide');
                                this.listarProyecto();
                            })
                            .catch((error) => {
                                console.log(error);
                                this.$toastr.e(error.response.data.message);
                            });
                        } else {
                            axios.post("api/proyecto/crear", this.modal.proyecto)
                            .then((response) => {
                                this.$toastr.s(response.data.message);
                                $("#modal-proyecto").modal('hide');
                                this.listarProyecto();
                            })
                            .catch((error) => {
                                console.log(error);
                                this.$toastr.e(error.response.data.message);
                            });
                        }
                    }
                }); 
            },
            modificar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) {  
                        axios.put("api/proyecto/modificar/" + this.modal.id_proyecto, this.modal.proyecto)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-proyecto").modal('hide');
                            this.listarProyecto();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                    }
                }); 
            },
            eliminar(row, index){
                 this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                  //
                  axios.put("api/proyecto/eliminar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = false;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
                this.listarProyecto();
                });
                
            },
            activar(row, index){
                axios.put("api/proyecto/activar/"+row.id)
                .then((response) => {
                    this.$toastr.s(response.data.message);
                    row.activo = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
           
            exportar(){
                let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listarProyectos.filtrosBusqueda);
                window.open(url);
            },
            
            cambiarTipo(){
                this.modal.proyecto.subido = !this.modal.proyecto.subido;
                this.modal.proyecto.url = ''
            },

            cambiarDocumento(){

            }
        },
    }
</script>
<style >

#myTabContent{
    border: 1px solid;
    border-top: none;
    border-color: #dee2e6;
    padding: 1rem 1rem 0 1rem;
    margin-bottom: 1rem;
}

</style>