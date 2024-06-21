<template>
    <div class="p-3 pt-5">
      <div class="col-md-12" style="margin-left: -15px">
        <button class="btn btn-outline-secondary float-right" type="button" @click="nuevo"> Nuevo </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Actividades</h4></div>
      <br />
  
      <div class="table-responsive">
        <vue-good-table
          :columns="listarTareas.columns"
          :rows="listarTareas.data"
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
          id="modal-tarea"
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
                      v-model="modal.tarea.id_proyecto"
                      data-vv-as="Proyecto"
                      placeholder="Seleccione Proyecto"
                      v-validate="'required'"
                    >
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
                    <input
                      type="text"
                      v-model="modal.tarea.nombre"
                      class="form-control"
                      data-vv-as="Tarea"
                      placeholder="Actividad"
                      name="tarea"
                      v-validate="'required|max:250'"
                    />
                    <span class="text-danger">{{
                      errors.first("form_registro.tarea")
                    }}</span>
                  </div>
                  <div class="form-group">
                    <p class="m-0">
                      <strong>Descripcion</strong>
                    </p>
                    <textarea 
                      type="text"
                      v-model="modal.tarea.descripcion"
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
                                v-model="modal.tarea.fecha_inicio"
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
                                v-model="modal.tarea.fecha_fin"
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
                      <strong>Estado</strong>
                    </p>
                    <select v-model="val" name="estado" class="form-control"
                    placeholder="Seleccione Estado"
                    v-validate="'required'">
                 <option v-for="row in estados" 
                 :key="row.estado" 
                 :value="row.estado" 
                 v-text="row.estado"></option>
                </select>
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
  import Helper from "../../services/helper";
  import Multiselect from "vue-multiselect";
  export default {
    name: "Ayudas",
    components: {
            Multiselect,
    },
    data() {
      return {
        val:null,
        listarTareas: {
          data: [],
          columns: [
            { label: "Proyecto", field: "proyecto.nombre" },
            { label: "Nombre", field: "nombre" },
            { label: "Descripcion", field: "descripcion" },
            { label: "Inicio", field: "fecha_inicio" },
            { label: "Fin", field: "fecha_fin" },
            { label: "Estado", field: "estado" },
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
        deshabilitado: false,
        modal: {
          tipo: '',
          titulo: '',
          nivelID: null,
          tarea: {
            nombre: '',
            descripcion: '',
            id_proyecto: '',
            fecha_inicio: '',
            fecha_fin: '',
            estado: '',
            prioridad:'',
            meta:'',
            avance:'',
          },
        },
        estados: [
        { estado: "pendiente" },
        { estado: "proceso" },
        
        { estado: "finalizado" },
      ]
      };
    },
    created() {
      this.listarTarea();
      this.listarProyecto();
    },
    methods: {
      listarTarea() {
        axios
          .get(
            "api/tarea/listar" +
              Helper.getFilterURL(this.listarTareas.filtrosBusqueda)
          )
          .then((response) => {
            let data = response.data;
            this.listarTareas.data = data;
            console.log(this.listarTareas);
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
              Helper.getFilterURL(this.listarTareas.filtrosBusqueda)
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

     
      limpiarFormulario() {
        this.modal = {
          titulo: '',
          nivelID: null,
          tarea: {
            nombre: '',
            descripcion: '',
            id_proyecto: '',
            fecha_inicio: '',
            fecha_fin: '',
            estado: '',
            prioridad:'',
            meta:'',
            avance:'',
          },
          deshabilitado: false,
        };
        this.$validator.reset();
      },
      nuevo() {
        $("#modal-tarea").modal("show");
        this.limpiarFormulario();
        this.modal.titulo = "Nueva Actividad";
        this.modal.tipo = "nuevo";
      },
      ver(row, index) {
        $("#modal-tarea").modal("show");
        this.limpiarFormulario();
        this.modal = {
          titulo: "Ver Actividad",
          tipo: "ver",
          tarea: {
            nombre: row.nombre,
            descripcion: row.descripcion,
            fecha_inicio: row.fecha_inicio,
            fecha_fin: row.fecha_fin,
            estado: row.estado,
            prioridad: row.prioridad,
            meta: row.meta,
            avance: row.avance,
            id_proyecto: row.id_proyecto,
          },
          deshabilitado: true,
        };
      },

      editar(row, index) {
        $("#modal-tarea").modal("show");
        this.limpiarFormulario();
        this.modal = {
          titulo: "Editar Actividad",
          tipo: "editar",
          nivelID: row.id,
          tarea: {
            nombre: row.nombre,
            descripcion: row.descripcion,
            id_proyecto: row.id_proyecto,
          },
          deshabilitado: false,
        };
      },
      guardar() {
        this.$validator.validateAll("form_registro").then((result) => {
          if (result) {
            axios
              .post("api/grado/crear", this.modal.grado)
              .then((response) => {
                this.$toastr.s(response.data.message);
                $("#modal-tarea").modal("hide");
                this.listarGrado();
              })
              .catch((error) => {
                console.log(error);
                this.$toastr.e(error.response.data.message);
              });
          }
        });
      },

      modificar() {
        this.$validator.validateAll("form_registro").then((result) => {
          if (result) {
            axios
              .put("api/grado/modificar/" + this.modal.nivelID, this.modal.grado)
              .then((response) => {
                this.$toastr.s(response.data.message);
                $("#modal-tarea").modal("hide");
                this.listarGrado();
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
          .put("api/grado/eliminar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.activo = false;
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
        this.listarGrado();
                  });
       
      },
       eliminarGradoCurso(row, index) {
          this.$confirm("¿Esta seguro de eliminar el registro?").then(() => {
                    //
                    axios
          .put("api/grado_curso/eliminar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.activo = false;
            this.listarGradoCurso(row.id_grado);
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
        this.listarGrado();
                  });
        
      },
      activar(row, index) {
        axios
          .put("api/grado/activar/" + row.id)
          .then((response) => {
            this.$toastr.s(response.data.message);
            row.activo = true;
          })
          .catch((error) => {
            this.$toastr.e(error.response.data.message);
          });
      },
      listarContenidoPeligroso() {
        this.listarGrados.filtrosBusqueda.contenidoPeligroso = true;
        this.listarGrado();
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
          Helper.getFilterURL(this.listarGrados.filtrosBusqueda);
        window.open(url);
      },
    },
  };
  </script>
  <style >
  </style>  