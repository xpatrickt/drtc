<template>
    <div class="p-3 pt-5">
        <div class="col-md-12" style="margin-left: -15px;">
            <h4 class="text-color-2 mb-3">CONVOCATORIA: Registro de Recepcion de CV</h4>
        </div>
        <br>

        <div class="row justify-content-md-center">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="">Ingrese Número de DNI</label>
                    <input type="text" name="" class="form-control" v-model="numeroDni" @keyup.enter="buscar">
                </div>
            </div>
        </div>
        <div class="row justify-content-md-center">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="">DOCUMENTO</label>
                    <input type="text" name="" class="form-control" v-model="mostrar.documento" disabled>
                </div><div class="form-group">
                    <label for="">APELLIDOS</label>
                    <input type="text" name="" class="form-control" v-model="mostrar.apellidos" disabled>
                </div>
                <div class="form-group">
                    <label for="">NOMBRES</label>
                    <input type="text" name="" class="form-control" v-model="mostrar.nombres" disabled>
                </div>
                <div class="form-group" disabled>
                    <label for="">SEDE PROVINCIAL</label>
                    <input type="text" name="" class="form-control" v-model="mostrar.provincia" disabled>
                </div>
                <div class="form-group" disabled>
                    <label for="">CARGO</label>
                    <input type="text" name="" class="form-control" v-model="mostrar.cargo" disabled>
                </div>
                <div class="form-group">
                    <label for="">REGISTRO</label>
                    <input type="text" name="" class="form-control" v-model="mostrar.num_registro" disabled>
                </div>
            </div>
        </div>
        <hr>
    </div>
</template>

<script>


export default {
    name: 'Ayudas',
    components: {
    },
    data() {
        return {
            numeroDni: '',
            idConvocatoria: '',
            listarConvocatorias: [],
            filtrosBusqueda: {
                tipo: '',
                orden: 'asc',
                ordenPor: 'apellido_pat',
            },
            mostrar: {
                documento : '',
                apellidos: '',
                nombres: '',
                provincia: '',
                cargo: '',
                num_registro: '',
            }
        }
    },
    created() {
        this.listarConvocatoria();
    },
    methods: {
        buscar() {
            axios.get("api/evaluacion/ver/" + this.numeroDni)
                .then((response) => {
                    let data = response.data;
                    this.mostrar.documento=this.numeroDni;
                    if (response.data.flag == 0) {
                        this.$toastr.e(response.data.message);
                        this.mostrar.apellidos = data.persona[0].apellido_pat + " " + data.persona[0].apellido_mat;
                        this.mostrar.documento = data.persona[0].documento;
                        this.mostrar.nombres = data.persona[0].nombres;
                        this.mostrar.provincia = data.provincia.nombre_sede;
                        this.mostrar.cargo = data.cargo;
                        this.mostrar.num_registro = data.num_registro;
                        console.log(data);
                        console.log(this.mostrar);
                        this.numeroDni='';
                    } else if(response.data.flag == 1) {
                        this.$toastr.s(response.data.message);
                        this.mostrar.apellidos = data.persona[0].apellido_pat + " " + data.persona[0].apellido_mat;
                        this.mostrar.documento = data.persona[0].documento;
                        this.mostrar.nombres = data.persona[0].nombres;
                        this.mostrar.cargo = data.cargo;
                        this.mostrar.provincia = data.provincia.nombre_sede;
                        this.mostrar.num_registro = data.num_registro;
                        this.numeroDni='';

                    }
                    else{ this.$toastr.e(response.data.message);}
                    //         this.listaAlumnos.data=response.data.lista;
                    //         console.log(this.listaAlumnos);
                    // let dni = response.data;
                    // console.log(dni);
                })
                .catch((error) => {
                    console.log("error");
                });
        },
        listarConvocatoria() {
            axios.get("api/convocatoria/listar")
                .then((response) => {
                    let data = response.data;
                    this.listarConvocatorias = data;
                })
                .catch((error) => {
                    console.log(error);
                    this.$toastr.e(error.response.data.message);
                });
        },
    },
}
</script>
<style ></style>
