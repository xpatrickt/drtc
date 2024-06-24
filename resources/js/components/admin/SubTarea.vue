<template>
    <div class="p-3 pt-5">
      <div class="col-md-12" style="margin-left: -15px">
        <button class="btn btn-outline-secondary float-right" type="button" @click="nuevo"> Nuevo </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Tareas</h4></div>
      <br />
  
      <div class="table-responsive">
        <vue-good-table
          :columns="listarSubtareas.columns"
          :rows="listarSubtareas.data"
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
              <button
                class="btn btn-outline-secondary btn-sm btn-icon"
                @click.prevent="ver(props.row, props.index)"
                data-toggle="tooltip"
                title="Ver"
              >
                <i class="fas fa-eye"></i>
              </button>
              <button
                class="btn btn-outline-info btn-sm btn-icon"
                @click.prevent="editar(props.row, props.index)"
                data-toggle="tooltip"
                title="Editar"
              >
                <i class="fas fa-pencil-alt"></i>
              </button>
              <button
                class="btn btn-outline-danger btn-sm btn-icon"
                @click.prevent="eliminar(props.row, props.index)"
                data-toggle="tooltip"
                title="Eliminar"
              >
                <i class="fas fa-trash-alt"></i>
              </button>
            </span>
          </template>
        </vue-good-table>
      </div>
      <!-- Modal -->
   <template>
        <div
          class="modal fade"
          id="modal-subtarea"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalCenterTitle"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5
                  class="modal-title"
                  id="exampleModalLongTitle"
                  v-text="modal.titulo"
                ></h5>
                <button
                  type="button"
                  class="close"
                  data-dismiss="modal"
                  aria-label="Close"
                >
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="form" data-vv-scope="form_registro">
                  <div class="form-group">
                    <p class="m-0">
                      <strong>Proyecto</strong>
                    </p>
                    <select
                      name="proyecto"
                      class="form-control"
                      v-model="modal.subtarea.id_proyecto"
                      data-vv-as="Proyecto"
                      placeholder="Seleccione Proyecto"
                      v-validate="'required'"
                      @change="listarTarea(modal.subtarea.id_proyecto)">
                      <option
                        v-for="row in listarProyectos"
                        :key="row.id"
                        :value="row.id"
                        v-text="row.nombre"
                      ></option>
                    </select>
                    <span class="text-danger">{{
                      errors.first("form_registro.proyecto")
                    }}</span>
                  </div>
                  <div class="form-group">
                                    <p class="m-0">
                                        <strong>Actividad</strong>
                                    </p>
                                    <select name="tarea"
                                    class="form-control"
                                    v-model="modal.subtarea.id_tarea"
                                    data-vv-as="Tarea"
                                    placeholder="Seleccione Actividad"
                                    v-validate="'required'">
                                        <option v-for="row in listarTareas" :key="row.id" :value="row.id" v-text="row.nombre" ></option>
                                    </select>
                                    <span class="text-danger">{{errors.first("form_registro.tarea")}}</span>
                  </div>


                  <div class="form-group">
                    <p class="m-0">
                      <strong>Tarea</strong>
                    </p>
                    <input
                      type="text"
                      v-model="modal.subtarea.nombre"
                      class="form-control"
                      data-vv-as="Tarea"
                      placeholder="Tarea"
                      name="subtarea"
                      v-validate="'required|max:250'"
                    />
                    <span class="text-danger">{{
                      errors.first("form_registro.subtarea")
                    }}</span>
                  </div>
                  <div class="form-group">
                    <p class="m-0">
                      <strong>Descripcion</strong>
                    </p>
                    <textarea 
                      type="text"
                      v-model="modal.subtarea.descripcion"
                      class="form-control"
                      data-vv-as="Descripcion"
                      placeholder="Descripcion"
                      name="descripcion"
                      v-validate="'max:600'"></textarea>
                   
                    <span class="text-danger">{{
                      errors.first("form_registro.descripcion")
                    }}</span>
                  </div>
                  <div class="form-group">
                                <p class="m-0">
                                    <strong>Inicio</strong>
                                </p>
                                <input type="date"
                                v-model="modal.subtarea.fecha_inicio"
                                class="form-control"
                                data-vv-as="Inicio"
                                placeholder="Inicio"
                                name="fecha_inicio">
                                <span class="text-danger">{{
                                    errors.first("form_registro.fecha_inicio")
                               }}</span>
                  </div>  
                  <div class="form-group">
                                <p class="m-0">
                                    <strong>Fin</strong>
                                </p>
                                <input type="date"
                                v-model="modal.subtarea.fecha_fin"
                                class="form-control"
                                data-vv-as="Inicio"
                                placeholder="Inicio"
                                name="fecha_fin">
                                <span class="text-danger">{{
                                    errors.first("form_registro.fecha_fin")
                               }}</span>
                  </div>  

                  <div class="form-group">
                    <p class="m-0">
                      <strong>Situación</strong>
                    </p>
                    <select v-model="modal.subtarea.situacion" name="situacion" class="form-control"
                    placeholder="Seleccione Situación"
                    v-validate="'required'">
                 <option v-for="row in situaciones" 
                 :key="row.situacion" 
                 :value="row.situacion" 
                 v-text="row.situacion"></option>
                </select>
                    <span class="text-danger">{{
                      errors.first("form_registro.situacion")
                    }}</span>
                  </div>
                  <div class="form-group">
                    <p class="m-0">
                      <strong>Prioridad</strong>
                    </p>
                    <input
                      type="number"
                      max="10"
                      min="1"
                      v-model="modal.subtarea.prioridad"
                      class="form-control"
                      data-vv-as="Prioridad"
                      placeholder="Prioridad"
                      name="prioridad"
                      v-validate="'required|max:250'"
                    />
                    <span class="text-danger">{{
                      errors.first("form_registro.prioridad")
                    }}</span>
                  </div>
                  <div class="form-group">
                    <p class="m-0">
                      <strong>Meta</strong>
                    </p>
                    <input
                      type="text"
                      v-model="modal.subtarea.meta"
                      class="form-control"
                      data-vv-as="Meta"
                      placeholder="Meta"
                      name="meta"
                      v-validate="'required|max:250'"
                    />
                    <span class="text-danger">{{
                      errors.first("form_registro.meta")
                    }}</span>
                  </div>
                  <div class="form-group">
                    <p class="m-0">
                      <strong>Avance</strong>
                    </p>
                    <input
                      type="text"
                      v-model="modal.subtarea.avance"
                      class="form-control"
                      data-vv-as="Avance"
                      placeholder="Avance"
                      name="avance"
                      v-validate="'required|max:250'"
                    />
                    <span class="text-danger">{{
                      errors.first("form_registro.avance")
                    }}</span>
                  </div>
                  <div class="form-group col-md-6">
                                <input type="hidden"
                                v-model="modal.subtarea.estado"
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
                <button
                  type="button"
                  class="btn btn-outline-primary"
                  data-dismiss="modal"
                >
                  Cerrar
                </button>
                <button
                  type="button"
                  v-if="modal.tipo == 'nuevo'"
                  class="btn btn-primary"
                  @click="guardar"
                >
                  Guardar
                </button>
                <button
                  type="button"
                  v-else-if="modal.tipo == 'editar'"
                  class="btn btn-primary"
                  @click="modificar">
                  Actualizar
                </button>
              </div>
            </div>
          </div>
        </div>
      </template>

    </div>
  </template>
  
  <script>
  import Log from "laravel-mix/src/Log";
import Helper from "../../services/helper";
  import Multiselect from "vue-multiselect";
import { Modal } from "bootstrap";
  export default {
    name: "Ayudas",
    components: {
            Multiselect,
    },
    data() {
      return {
        val:null,
        listarSubtareas: {
          data: [],
          columns: [
            { label: "Proyecto", field: "tarea.proyecto.nombre" },
            { label: "Tarea", field: "tarea.nombre" },
            { label: "Nombre", field: "nombre" },
            { label: "Descripcion", field: "descripcion" },
            { label: "Inicio", field: "fecha_inicio" },
            { label: "Fin", field: "fecha_fin" },
            { label: "Situación", field: "situacion" },
            { label: "Prioridad", field: "prioridad" },
            { label: "Meta", field: "meta" },
            { label: "Avance", field: "avance" },
            { label: "Opciones", field: "options" },
          ],
          total: 0,
          filtrosBusqueda: {
            tipo: '',
            orden: "asc",
            ordenPor: "id",
            regPagina: "10",
          },
          deshabilitarEdicion: false,
        },
        listarProyectos: [],
        listarTareas: [],
        deshabilitado: false,
        modal: {
          tipo: '',
          titulo: '',
          nivelID: null,
          subtarea: {
            nombre: '',
            descripcion: '',
            id_tarea: '',
            id_proyecto: '',
            fecha_inicio: '',
            fecha_fin: '',
            situacion: '',
            prioridad:'',
            meta:'',
            estado:1,
            avance:'',
          },
        },
        situaciones: [
        { situacion: "pendiente" },
        { situacion: "proceso" },
        { situacion: "finalizado" },
      ]
      };
    },
    created() {
      this.listarSubtarea();
    },
    methods: {
        listarSubtarea(){
                axios.get("api/subtarea/listar"+Helper.getFilterURL(this.listarSubtareas.filtrosBusqueda))
                .then((response) => {
                    let data = response.data;
                    this.listarSubtareas.data = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
            },
        listarProyecto() {
        axios
          .get(
            "api/proyecto/listar" +
              Helper.getFilterURL(this.listarSubtareas.filtrosBusqueda)
          )
          .then((response) => {
            let data = response.data;
            this.listarProyectos = data;
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
      },            
        listarTarea(id_proyecto) {
        axios
          .get(
            "api/tarea/llenar_combo/" +id_proyecto)
            .then((response) => {
            let data = response.data;
            this.listarTareas = data;
            console.log(this.listarTareas);
          })
          .catch((error) => {
            console.log(error);
            this.$toastr.e(error.response.data.message);
          });
      },


     
      limpiarFormulario() {
        this.modal = {
          titulo: '',
          nivelID: null,
          subtarea: {
            nombre: '',
            descripcion: '',
            id_tarea: '',
            fecha_inicio: '',
            fecha_fin: '',
            situacion: '',
            prioridad:'',
            meta:'',
            avance:'',
            estado:1,
          },
          deshabilitado: false,
        };
        this.$validator.reset();
      },
      nuevo() {
        this.listarProyecto();
        $("#modal-subtarea").modal("show");
        this.limpiarFormulario();
        this.modal.titulo = "Nueva Tarea";
        this.modal.tipo = "nuevo";
      },
      ver(row, index) {
        this.listarProyecto();
        this.listarTarea(row.tarea.id_proyecto);
        $("#modal-subtarea").modal("show");
        this.limpiarFormulario();
        this.modal = {
          titulo: "Ver Subtarea",
          tipo: "ver",
          subtarea: {
            nombre: row.nombre,
            descripcion: row.descripcion,
            fecha_inicio: row.fecha_inicio,
            fecha_fin: row.fecha_fin,
            situacion: row.situacion,
            estado: row.estado,
            prioridad: row.prioridad,
            meta: row.meta,
            avance: row.avance,
            id_proyecto:row.tarea.id_proyecto,
            id_tarea: row.id_tarea,
          },
          deshabilitado: true,
        };
      },

      editar(row, index) {
        this.listarProyecto();
        this.listarTarea(row.tarea.id_proyecto);
        $("#modal-subtarea").modal("show");
        this.limpiarFormulario();

        this.modal = {
          titulo: "Editar Tarea",
          tipo: "editar",
          nivelID: row.id,
          subtarea: {
            nombre: row.nombre,
            descripcion: row.descripcion,
            fecha_inicio: row.fecha_inicio,
            fecha_fin: row.fecha_fin,
            situacion: row.situacion,
            prioridad: row.prioridad,
            meta: row.meta,
            avance: row.avance,
            estado: 1,
            id_proyecto:row.tarea.id_proyecto,
            id_tarea: row.id_tarea,
          },
          deshabilitado: false,
        };
      },
      guardar() {
        this.$validator.validateAll("form_registro").then((result) => {
          if (result) {
            axios
              .post("api/subtarea/crear", this.modal.subtarea)
              .then((response) => {
                this.$toastr.s(response.data.message);
                $("#modal-subtarea").modal("hide");
                this.listarSubtarea();
              })
              .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
              });
          }
        });
      },

      modificar() {
        console.log(this.modal.subtarea);
        this.$validator.validateAll("form_registro").then((result) => {
          if (result) {
            axios
              .put("api/subtarea/modificar/" + this.modal.nivelID, this.modal.subtarea)
              .then((response) => {
                this.$toastr.s(response.data.message);
                $("#modal-subtarea").modal("hide");
                this.listarSubtarea();
              })
              .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
              });
          }
        });
      },
      eliminar(row, index) {
         this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                    //
                     axios
          .put("api/subtareas/eliminar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.estado = false;
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
        this.listarSubtarea();
                  });
       
      },

      activar(row, index) {
        axios
          .put("api/subtarea/activar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.estado = true;
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
      },
      listarContenidoPeligroso() {
        this.listarSubtareas.filtrosBusqueda.contenidoPeligroso = true;
        this.listarSubtarea();
      },
      obtenerTipo(row) {
        if (row.tipo == 1) return "Inicio";
        else if (row.tipo == 2) return "Pregunta";
        else if (row.tipo == 1) return "Publicación";
      },
      exportar() {
        let url =
          process.env.MIX_APP_URL +
          "/exportar/ocupaciones" +
          Helper.getFilterURL(this.listarSubtareas.filtrosBusqueda);
        window.open(url);
      },
    },
  };
  </script>
  <style >
  </style>  