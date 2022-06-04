<template>
  <v-container>
    <v-data-table
      :headers="headers"
      :items="livestocks"
      :search="search"
      sort-by="id"
      class="elevation-1"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title
            ><v-icon>mdi-cow</v-icon> Ganado</v-toolbar-title
          >
          <v-divider class="mx-4" inset vertical></v-divider>
          <v-spacer></v-spacer>
          <v-dialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on, attrs }">
              <v-btn color="primary" dark class="mb-2" v-bind="attrs" v-on="on">
                <v-icon>mdi-plus</v-icon> Registrar
              </v-btn>
            </template>
            <v-card>
              <v-form ref="form" v-model="valid" lazy-validation>
                <v-card-title>
                  <span class="headline">{{ formTitle }}</span>
                </v-card-title>

                <v-card-text>
                  <v-container>
                    <v-row>
                      <v-col>
                        <v-row>
                          <v-col cols="12" sm="6" md="6">
                            <v-text-field
                              v-model="editedItem.first_name"
                              :rules="[v => !!v || 'Nombre es obligatorio', rules.lettersOnly, rules.min]"
                              label="Nombre*"
                              prepend-icon="mdi-card-account-details"
                              required
                              dense
                            ></v-text-field>
                          </v-col>
                          <v-col
                            cols="12"
                            sm="6"
                          >
                            <v-select
                              v-model="editedItem.breed_id"
                              :items="breeds"
                              :item-text="'name'"
                              :item-value="'id'"
                              :rules="[v => !!v || 'Raza es obligatorio']"
                              label="Selecciona la raza*"
                              prepend-icon="mdi-barn"
                              dense
                            ></v-select>
                          </v-col>
                          <v-col cols="12" sm="6" md="6">
                            <v-switch
                              v-model="editedItem.status"
                              inset
                              label="Inactivo/Activo"
                              dense
                            ></v-switch>
                          </v-col>
                        </v-row>
                      </v-col>
                    </v-row>
                  </v-container>
                  <small>*campos obligatorios</small>
                </v-card-text>

                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn color="error" @click="close"> Cancelar </v-btn>
                  <v-btn :loading="loading" :disabled="loading" color="primary" @click="save"> Guardar </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
          <v-dialog v-model="dialogDelete" max-width="650px">
            <v-card>
              <v-card-title class="headline justify-center"
                >Esta seguro que desea eliminar este registro?</v-card-title
              >
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error" text @click="closeDelete">Cancelar</v-btn>
                <v-btn color="primary" text @click="deleteItemConfirm">Confirmar</v-btn>
                <v-spacer></v-spacer>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-toolbar>
        <v-text-field
          class="pa-6 ma-2"
          v-model="search"
          append-icon="mdi-magnify"
          label="Ingrese criterio de busqueda..."
          solo
          single-line
          hide-details
        ></v-text-field>
      </template>
      <template v-slot:[`item.actions`]="{ item }">
        <v-icon small class="mr-2" @click="editItem(item, editPassword)"> mdi-pencil </v-icon>
        <v-icon small @click="deleteItem(item)"> mdi-delete </v-icon>
      </template>
      <template v-slot:[`item.status`]="{ item }">
        <v-chip v-if="item.status === true" :color="getColor(item.status)">Activo</v-chip>
        <v-chip v-else :color="getColor(item.status)">Inactivo</v-chip>
      </template>
      <template v-slot:no-data> NO HAY DATOS </template>
    </v-data-table>
  </v-container>
</template>

<script>
export default {
  data: () => ({
    dialog: false,
    dialogDelete: false,
    loading: false,
    valid: false,
    search: "",
    rules: {
      min: (v) => (v && v.length >=2 ) || "Minimo 2 caracteres",
      lettersOnly: (v) =>
          /^[A-Za-z]+$/.test(v) || "Solo debe ingresar letras",
    },    
    headers: [
      {
        text: "ID",
        align: "start",
        sortable: false,
        value: "id",
      },
      { text: "Nombre", value: "name" },
      { text: "Identificacion", value: "identification" },
      { text: "Descripcion", value: "description" },
      { text: "Sexo", value: "sex" },
      { text: "Raza", value: "breed_id" },
      { text: "Fecha Nacimiento", value: "birth_date" },
      { text: "Fecha de Compra", value: "purchase_date" },
      { text: "Fecha de Muerte", value: "death_date" },
      { text: "Estado", value: "status" },
      { text: "Acciones", value: "actions", sortable: false },
    ],
    livestocks: [],
    breeds: [],
    editedIndex: -1,
    editedItem: {
      name: "",
      identification: "",
      description: "",
      sex: "",
      birth_date: "",
      purchase_date: "",
      death_date: "",
      breed_id: "",
      image: "",
      status: true,
    },
    defaultItem: {
      name: "",
      identification: "",
      description: "",
      sex: "",
      birth_date: "",
      purchase_date: "",
      death_date: "",
      breed_id: "",
      image: "",
      status: true,
    },
  }),
  mounted() {
    this.getData();
    this.getBreeds();
  },
  computed: {
    formTitle() {
      return this.editedIndex === -1 ? "Nuevo Ganado" : "Editar Ganado";
    },
  },
  watch: {
    dialog(val) {
      val || this.close();
    },
    dialogDelete(val) {
      val || this.closeDelete();
    },
  },
  methods: {
    getColor(estado) {
      if (estado === true) return "success";
      else return "error";
    },
    getBreeds() {
        axios.get("/breeds")
          .then((response) => {
            this.breeds = response.data.data;
          })
          .catch((err) => {
            //console.log(err.response.data.message);
          });
      },
    getData() {
      axios
        .get("/livestocks")
        .then((response) => {
          this.livestocks = response.data.data;
        })
        .catch((err) => {
          //console.log(err.response.data.message);
        });
    },
    editItem(item) {
      this.editedIndex = this.livestocks.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialog = true;
    },
    deleteItem(item) {
      this.editedIndex = this.livestocks.indexOf(item);
      this.editedItem = Object.assign({}, item);
      this.dialogDelete = true;
    },
    deleteItemConfirm() {
      axios
        .delete("/livestocks/" + this.editedItem.id)
        .then((response) => {

          this.livestocks.splice(this.editedIndex, 1);
          this.getData();
          this.$swal({
            position: 'top-end',
            icon: 'success',
            title: response.data.message,
            showConfirmButton: false,
            timer: 1500
          });

        })
        .catch((error) => {

        });
      this.closeDelete();
    },
    close() {
      this.$refs.form.reset();
      this.dialog = false;
      this.loading = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    closeDelete() {
      this.dialogDelete = false;
      this.$nextTick(() => {
        this.editedItem = Object.assign({}, this.defaultItem);
        this.editedIndex = -1;
      });
    },
    save() {
      if (this.editedIndex > -1) {
        Object.assign(this.livestocks[this.editedIndex], this.editedItem);

        if (this.$refs.form.validate()) {
          this.loading = true;
          axios
            .put("/livestocks/" + this.editedItem.id, {
              name: this.editedItem.name,
              identification: this.editedItem.identification,
              description: this.editedItem.description,
              sex: this.editedItem.sex,
              birth_date: this.editedItem.birth_date,
              purchase_date: this.editedItem.purchase_date,
              death_date: this.editedItem.death_date,
              breed_id: this.editedItem.breed_id,
              status: this.editedItem.status,
            })
            .then((response) => {
              this.$swal({
                position: 'top-end',
                icon: 'success',
                title: response.data.message,
                showConfirmButton: false,
                timer: 1500
              });

              this.getData();
              this.loading = false;
              this.close();
            })
            .catch((error) => {});
        }
      } else {

        if (this.$refs.form.validate()) {
          this.loading = true;
          axios
            .post("/livestocks", {
              name: this.editedItem.name,
              identification: this.editedItem.identification,
              description: this.editedItem.description,
              sex: this.editedItem.sex,
              birth_date: this.editedItem.birth_date,
              purchase_date: this.editedItem.purchase_date,
              death_date: this.editedItem.death_date,
              breed_id: this.editedItem.breed_id,
              status: this.editedItem.status,
            })
            .then((response) => {
              this.$swal({
                position: 'top-end',
                icon: 'success',
                title: response.data.message,
                showConfirmButton: false,
                timer: 1500
              });

              this.getData();
              this.loading = false;
              this.close();
            })
            .catch((error) => {
              this.loading = false;
              /* this.errores = [];
                if (error.response.data.errors.descripcion) {
                    this.errores.push(error.response.data.errors.descripcion[0]);
                }

                if (error.response.data.errors.estado) {
                    this.errores.push(error.response.data.errors.estado[0]);
                } */
            });
        }
      }
    },
  },
};
</script>
