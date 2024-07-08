<template>
    <div class="p-3 pt-5">
        <div class="col-md-12" style="margin-left: -15px;">
            <h4 class="text-color-2 mb-3">Avance de Actividades</h4>
        </div>
        <br>
        <div class="tab-pane fade show active" id="paso1" role="tabpanel" aria-labelledby="paso1-tab">
            <div class="row">

                <div class="form-group col-3">
                    <p class="m-0">
                      <strong>Proyecto</strong>
                    </p>
                    <select
                      name="proyecto"
                      class="form-control"
                      v-model="subtarea.id_proyecto"
                      data-vv-as="Proyecto"
                      placeholder="Seleccione Proyecto"
                      v-validate="'required'"
                      @change="listarTarea(subtarea.id_proyecto)">
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
                <div class="form-group col-3">
                    <p class="m-0">
                        <strong>Actividad</strong>
                        </p>
                                    <select name="tarea"
                                    class="form-control"
                                    v-model="subtarea.id_tarea"
                                    data-vv-as="Tarea"
                                    placeholder="Seleccione Actividad"
                                    v-validate="'required'">
                                        <option v-for="row in listarTareas" :key="row.id" :value="row.id" v-text="row.nombre" ></option>
                                    </select>
                                    <span class="text-danger">{{errors.first("form_registro.tarea")}}</span>
                </div>
                <div class="form-group col-3">
                    <p class="m-0">
                        <strong>Listar</strong>
                    </p>
                    <button class="btn btn-outline-success float-left" type="button" @click="generarLista"> Generar
                    </button>
                </div>
            </div>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border">Listado</legend>
                <div class="control-group">
                    <div class="table-responsive">
                        <vue-good-table :columns="listarRegistros.columns" :rows="listarRegistros.data" :search-options="{
                            enabled: true,
                            placeholder: 'Buscar en la tabla',
                        }">
                            <template slot="table-row" slot-scope="props">

                                <span v-if="props.column.field == 'avance'">
                                    <input type="number" v-model="props.row.avance" class="form-control" data-vv-as="Avance"
                                        placeholder="Avance" name="avance" max="5" min="0"
                                        @keyup.enter="modificarNota(props.row.id, props.row.nota_examen)">
                                </span>
                            </template>
                        </vue-good-table>
                    </div>

                </div>
            </fieldset>
        </div>
        <div class="tab-pane fade" id="paso2" role="tabpanel" aria-labelledby="paso2-tab">

        </div>
        <div class="tab-pane fade" id="paso3" role="tabpanel" aria-labelledby="paso3-tab">

        </div>
    </div>
</template>

<script>

import Log from "laravel-mix/src/Log";
import Helper from "../../services/helper";
  import Multiselect from "vue-multiselect";
import { Modal } from "bootstrap";

export default {
    
    name: 'Ayudas',
    components: {
            Multiselect,
    },
    data() {
        return {
            val:null,
            listarSubtareas: {
                data: [],
                columns: [

                    { label: "Proyecto", field: "" },
                    { label: "Actividad", field: "" },
                    { label: "Tarea", field: "" },
                    { label: "Meta", field: "" },
                    { label: "Avance", field: "" },
                ],
                total: 0,
                filtrosBusqueda: {
                    tipo: "",
                    orden: "asc",
                    ordenPor: "id",
                    regPagina: "10",
                },
                deshabilitarEdicion: false,
            },
            listarProyectos: [],
            listarTareas: [],
            deshabilitado: false,
        };
    },

    created() {
        this.listarSubtarea();
        this.listarProyecto();
        this.listarTarea(row.tarea.id_proyecto);    
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

        guardar() {
            this.$validator.validateAll('form_registro').then(result => {
                if (result) {
                    axios.post("api/nivel/crear", this.modal.nivel)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-nivel").modal('hide');
                            this.listarNivel();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                }
            });
        },
        modificar() {
            this.$validator.validateAll('form_registro').then(result => {
                if (result) {
                    axios.put("api/nivel/modificar/" + this.modal.nivelID, this.modal.nivel)
                        .then((response) => {
                            this.$toastr.s(response.data.message);
                            $("#modal-nivel").modal('hide');
                            this.listarNivel();
                        })
                        .catch((error) => {
                            console.log(error);
                            this.$toastr.e(error.response.data.message);
                        });
                }
            });
        },
        modificarNota(id, nota) {
            const data = {
                nota,
            }
            axios.put("api/examen/modificar/" + id, data)
                .then((response) => {
                    this.$toastr.s(response);
                    this.generarLista();
                    
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });

        },

        generarLista() {
            let datos = {
                convocatoria: this.idConvocatoria,
                provincia: this.idProcincia,
            }
            console.log(datos);
            axios.post("api/examen/generar", datos)
                .then((response) => {
                    this.listarRegistros.data = response.data;
                    this.$toastr.s(response.data.message);
                })
                .catch((error) => {
                    console.log("error");
                });
        },
        obtenerTipo(row) {
            if (row.tipo == 1) return 'Inicio';
            else if (row.tipo == 2) return 'Pregunta';
            else if (row.tipo == 1) return 'Publicación';
        },
        exportar() {
            let url = process.env.MIX_APP_URL + '/exportar/ocupaciones' + Helper.getFilterURL(this.listarSecciones.filtrosBusqueda);
            window.open(url);
        }

    },
};
</script>
<style >
fieldset.scheduler-border {
    border: 1px solid #dee2e6 !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow: 0px 0px 0px 0px #000;
    box-shadow: 0px 0px 0px 0px #000;
}

legend.scheduler-border {
    font-size: 1rem !important;
    font-weight: bold !important;
    text-align: left !important;
    border: none;
    width: 120px;
}
</style>