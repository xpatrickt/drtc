<template>
    <div class="p-3 pt-5">
      <div class="col-md-12" style="margin-left: -15px">
        <button
          class="btn btn-outline-secondary float-right"
          type="button"
          @click="nuevo"
        >
          Nuevo
        </button>
        <h4 class="text-color-2 mb-3">Mantenimiento de Actividades</h4>
      </div>
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
                      <strong>Nivel</strong>
                    </p>
                    <select
                      name="nivel"
                      class="form-control"
                      v-model="modal.grado.id_nivel"
                      data-vv-as="Nivel"
                      placeholder="Seleccione Nivel"
                      v-validate="'required'"
                    >
                      <option
                        v-for="row in listarNiveles"
                        :key="row.id"
                        :value="row.id"
                        v-text="row.nombre"
                      ></option>
                    </select>
                    <span class="text-danger">{{
                      errors.first("form_registro.nivel")
                    }}</span>
                  </div>
                  <div class="form-group">
                    <p class="m-0">
                      <strong>Grado</strong>
                    </p>
                    <input
                      type="text"
                      v-model="modal.grado.grado"
                      class="form-control"
                      data-vv-as="Grado"
                      placeholder="Grado"
                      name="grado"
                      v-validate="'required|max:30'"
                    />
                    <span class="text-danger">{{
                      errors.first("form_registro.grado")
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


      <!-- Modal agregar Cursos -->

     <!-- <template>
        <div
          class="modal fade"
          id="modal-agregarCurso"
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
                <form class="form" data-vv-scope="form_registro_grado_curso">
                  <div class="row">
                    <div class="form-group col-6">
                      <p class="m-0">
                        <strong>Nivel</strong>
                      </p>
                      <select
                        name="id_nivel"
                        disabled
                        class="form-control"
                        v-model="modalAgregar.grado.id_nivel"
                        data-vv-as="id_nivel"
                        placeholder="Seleccione Nivel"
                        v-validate="'required'"
                      >
                        <option
                          v-for="row in listarNiveles"
                          :key="row.id"
                          :value="row.id"
                          v-text="row.nombre"
                        ></option>
                      </select>
                    </div>
                    <div class="form-group col-6">
                      <p class="m-0">
                        <strong>Grado</strong>
                      </p>
                      <input
                        type="text"
                        v-model="modalAgregar.grado.grado"
                        disabled
                        class="form-control"
                        data-vv-as="Nombre"
                        placeholder="Nombre"
                        name="grado"
                        :id="modalAgregar.grado.id"
                        v-validate="'required'"
                      />
                    </div>
                    <div class="form-group col-10">
                      <p class="m-0">
                        <strong>Cursos</strong>
                      </p>
                      <select
                        name="Curso"
                        class="form-control"
                        v-model="modalAgregar.grado.id_curso"
                        data-vv-as="Curso"
                        placeholder="Seleccione Curso"
                        v-validate="'required'"
                      >
                        <option
                          v-for="row in listarCursos"
                          :key="row.id"
                          :value="row.id"
                          v-text="row.nombre"
                        ></option>
                      </select>
                      <span class="text-danger">{{
                        errors.first("form_registro_grado_curso.nivel")
                      }}</span>
                    </div>
                    <div class="form-group col-2">
                      <p class="m-0 col-12">
                        <strong> &nbsp;</strong>
                      </p>
                      <button
                        type="button"
                        class="btn btn-success"
                        @click="guardarAgregarCurso"
                      >
                        Agregar
                      </button>
                    </div>
                  </div>
                  <div class="table-responsive">
                    <vue-good-table
                      :columns="listarGradoCursos.columns"
                      :rows="listarGradoCursos.data"
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
                            class="btn btn-outline-danger btn-sm btn-icon"
                            @click.prevent="eliminarGradoCurso(props.row, props.index)"
                            data-toggle="tooltip"
                            title="Eliminar"
                          >
                            <i class="fas fa-trash-alt"></i>
                          </button>
                        </span>
                      </template>
                    </vue-good-table>
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
                  @click="modificar"
                >
                  Actualizar
                </button>
              </div>
            </div>
          </div>
        </div>
      </template>-->
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
        listarCursos: [],
        deshabilitado: false,
        modal: {
          tipo: '',
          titulo: '',
          nivelID: null,
          grado: {
            grado: '',
            id_nivel: '',
          },
        },

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
          grado: {
            grado: '',
          },
          deshabilitado: false,
        };
        this.$validator.reset();
      },
      nuevo() {
        $("#modal-tarea").modal("show");
        this.limpiarFormulario();
        this.modal.titulo = "Nueva Tarea";
        this.modal.tipo = "nuevo";
      },
      ver(row, index) {
        $("#modal-tarea").modal("show");
        this.limpiarFormulario();
        this.modal = {
          titulo: "Ver Tarea",
          tipo: "ver",
          tarea: {
            nombre: row.nombre,
            id_proyecto: row.id_proyecto,
          },
          deshabilitado: true,
        };
      },

      editar(row, index) {
        $("#modal-tarea").modal("show");
        this.limpiarFormulario();
        this.modal = {
          titulo: "Editar Tarea",
          tipo: "editar",
          nivelID: row.id,
          grado: {
            grado: row.grado,
            id_nivel: row.id_nivel,
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
  