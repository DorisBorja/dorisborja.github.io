<style scoped>
.fondo{
  background-image: url('/images/logo_login.jpg'); 
  background-repeat: no-repeat;
  background-attachment: fixed;
  background-position: center; background-size: cover;
}
</style>
<template>
  <v-row>
    <v-col cols="12" lg="7" xl="6" class="fondo d-none d-md-flex align-center justify-center">
      <v-container>
        <div class="pa-10">
          <v-row justify="center">
            <v-col cols="8" xl="5">
              <div>
                <!-- <h2
                  class="display-1 white--text font-weight-medium"
                >Elegant Design with unlimited features, built with love</h2> -->
                <!-- <img src="/images/logo_login.jpg" /> -->
                <!-- <h6
                  class="subtitle-1 mt-4 white--text op-5 font-weight-regular"
                >El futuro es ahora.</h6>
                <v-btn class="mt-4" x-large outlined color="white" href="/">Ir a la tienda...</v-btn> -->
              </div>
            </v-col>
          </v-row>
        </div>
      </v-container>
    </v-col>
    <v-col cols="12" lg="5" xl="6" class="d-flex align-center">
      <v-container>
        <v-btn
          fab
          large
          top
          right
          class="info"
          href="/"
        >
          <v-icon>mdi-home</v-icon>
        </v-btn>
        <div class="pa-7 pa-sm-12">
          <v-row>
            <v-col cols="12" lg="12" xl="12">
              <center><img src="/images/logo.png" height="200" width="200"/></center>
              <h1 class="font-weight-bold mt-4 blue-grey--text text--darken-2">Iniciar Sesión</h1>
              <v-form
                ref="form"
                v-model="valid"
                lazy-validation
              >
                <v-text-field
                  v-model="email"
                  label="Email"
                  :rules="emailRules"
                  outlined
                  required
                  autofocus
                ></v-text-field>
            
                <v-text-field
                  v-model="password"
                  label="Password"
                  :rules="passwordRules"
                  outlined
                  required
                  :append-icon="show ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="show ? 'text' : 'password'"
                  @keyup.enter="login"
                  @click:append="show = !show"
                ></v-text-field>

                <div class="d-block d-sm-flex align-center mb-4 mb-sm-0">
                  <v-checkbox
                    v-model="remember"
                    label="Recuerdame?"
                  ></v-checkbox>
                  <div class="ml-auto">
                    <a href="javascript:void(0)" class="link">Olvido la contraseña?</a>
                  </div>
                </div>
                <v-btn
                  :disabled="!valid"
                  color="info"
                  block
                  class="mr-4"
                  submit
                  @click="login"
                >
                  Ingresar
                </v-btn>
              </v-form>
            </v-col>
          </v-row>
        </div>
      </v-container>
    </v-col>
  </v-row>
</template>
<script>
//import Swal from 'sweetalert2/dist/sweetalert2.js'
//import 'sweetalert2/src/sweetalert2.scss'
export default {
  data(){
    return{
      show: false,
      valid: false,
      email: '',
      password: '',
      remember: false,
      passwordRules: [
        (v) => !!v || "Contraseña es obligatoria",
        /* (v) => (v && v.length <= 10) || "Password must be less than 10 characters" */],
      //email: "",
      emailRules: [
        (v) => !!v || "E-mail es obligatorio",
        (v) =>
          /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(v) ||
          "Correo debe ser válido",
      ],
    }
  },
  methods: {
    login(){
      if (this.$refs.form.validate()) {

        axios.post('/login', {
        email: this.email,
        password: this.password,
        remember: this.remember
      })
        .then(response => {

          //console.log(response.data.message);
          window.location.href = '/home';

        }).catch(error => {

          this.$swal({
            icon: 'error',
            title: 'Oops...',
            text: error.response.data.errors.email[0],
            showConfirmButton: false,
            timer: 2000
          });
          //console.log(error.response.data.message);
          /* Swal.fire({
            icon: 'error',
            title: error.response.data.errors.email[0],
            showConfirmButton: false,
            timer: 1500
          }) */
        });
      }
    }
  }
}
</script>
