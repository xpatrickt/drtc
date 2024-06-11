<template>
    <div class="p-3 pt-5">
         <div class="col-md-12" style="margin-left: -15px;">
        <button class="btn btn-outline-secondary float-right"  type="button" @click="nuevo"> Nuevo </button>
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
                                    v-validate="'required|max:250'">
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
                                    v-validate="'required|max:600'">
                                    <span class="text-danger">{{errors.first("form_registro.descripcion")}}</span>
                                </div>

                                <div class="form-group col-md-6">
                                <p class="m-0">
                                    <strong>Inicio</strong>
                                </p>
                                <input type="date"
                                v-model="modal.proyecto.fecha_inicio"
                                class="form-control"
                                data-vv-as="Inicio"
                                placeholder="Inicio"
                                name="fecha_inicio">
                                <span class="text-danger">{{
                                    errors.first("form_registro.fecha_inicio")
                                }}</span>
                                </div>                            
                                <div class="form-group col-md-6">
                                <p class="m-0">
                                    <strong>Fin</strong>
                                </p>
                                <input type="date"
                                v-model="modal.proyecto.fecha_fin"
                                class="form-control"
                                data-vv-as="Fin"
                                placeholder="Fin"
                                name="fecha_fin">
                                <span class="text-danger">{{
                                    errors.first("form_registro.fecha_fin")
                                }}</span>
                                </div>

                                <div class="form-group col-md-6">
                                <input type="hidden"
                                v-model="modal.proyecto.estado"
                                class="form-control"
                                data-vv-as="Estado"
                                placeholder="Estado"
                                value="1"
                                name="estado">
                                <span class="text-danger">{{
                                    errors.first("form_registro.estado")
                                }}</span>
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
 
                deshabilitado: false,
                modal:{
                    tipo: '',
                    titulo:  '',
                    proyecto:{
                        nombre:  '',
                        descripcion:'',
                        fecha_inicio: '',
                        fecha_fin:'',
                        estado:1,
                    },

                },
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
                    proyecto:{
                        nombre:  '',
                        descripcion:'',
                        estado:'',
                        fecha_inicio: '',
                        fecha_fin:'',
                        estado:1,
                    },
                    deshabilitado: false,   
                }
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
                this.modal = {
                    titulo:  'Ver proyecto',
                    tipo: 'ver',
                    id_proyecto: row.id,

                    proyecto:{
                        nombre: row.nombre,
                        descripcion: row.descripcion,
                        fecha_inicio: row.fecha_inicio,
                        fecha_fin: row.fecha_fin,
                        estado: row.estado,
                    },
  
                    deshabilitado: true,
                }
            },
            editar(row, index){
                $("#modal-proyecto").modal('show');
                this.limpiarFormulario();
                this.modal = {
                    titulo:  'Editar proyecto',
                    tipo: 'editar',
                    id_proyecto: row.id,
                    proyecto:{
                        nombre: row.nombre,
                        descripcion: row.descripcion,
                        fecha_inicio: row.fecha_inicio,
                        fecha_fin: row.fecha_fin,
                        estado: 1,
                      },
                    deshabilitado: false
                }
            },
            guardar(){
                this.$validator.validateAll('form_registro').then(result => {
                    if (result) { 

                        if(this.modal.proyecto.subido){
                            let _this = this;
                            let data = new FormData();
                            data.append('nombre', _this.modal.proyecto.nombre);
                            data.append('descripcion', _this.modal.proyecto.descripcion);
                            data.append('fecha_inicio', _this.modal.proyecto.fecha_inicio);
                            data.append('fecha_fin', _this.modal.proyecto.fecha_fin);
                            data.append('estado', _this.modal.proyecto.estado);
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
                    row.estado = false;
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
                    row.estado = true;
                })
                .catch((error) => {
                    this.$toastr.e(error.response.data.message);
                });
            },
           
            exportar(){
                let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listarProyectos.filtrosBusqueda);
                window.open(url);
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