<!-- =========================================================================================
    File Name: Login.vue
    Description: Login Page
    ----------------------------------------------------------------------------------------
    Item Name: Vuexy - Vuejs, HTML & Laravel Admin Dashboard Template
      Author: Pixinvent
    Author URL: http://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
  <div
    class="h-screen flex w-full bg-img vx-row no-gutter items-center justify-center"
    id="page-login"
  >
    <div class="vx-col sm:w-1/2 md:w-1/2 lg:w-3/4 xl:w-3/5 sm:m-0 m-4">
      <vx-card>
        <div slot="no-body" class="full-page-bg-color">
          <div class="vx-row no-gutter justify-center items-center">
            <div class="vx-col hidden lg:block lg:w-1/2">
              <img
                src="@assets/images/pages/login.png"
                alt="login"
                class="mx-auto"
              />
            </div>

            <div class="vx-col sm:w-full md:w-full lg:w-1/2 d-theme-dark-bg">
              <div class="p-8 login-tabs-container">
                <div class="vx-card__title mb-4">
                  <h4 class="mb-4">Login</h4>
                  <p>Welcome back, please login to your account.</p>
                </div>

                <form @submit="onSubmit">
                  <vs-input
                    name="email"
                    icon-no-border
                    icon="icon icon-user"
                    icon-pack="feather"
                    label-placeholder="Email"
                    v-model="form.email"
                    class="w-full"
                  />
                  <span
                    class="text-danger text-sm"
                    v-show="errors.has('email')"
                    >{{ errors.first("email") }}</span
                  >
                  <vs-input
                    type="password"
                    name="password"
                    icon-no-border
                    icon="icon icon-lock"
                    icon-pack="feather"
                    label-placeholder="Password"
                    v-model="form.password"
                    class="w-full mt-6"
                  />
                  <vs-alert
                    class="my-2"
                    v-if="error.invalid"
                    color="danger"
                    active="true"
                  >
                    {{ error.invalid }}
                  </vs-alert>

                  <div class="flex flex-wrap justify-between my-5"></div>

                  <vs-button
                    ref="loadableButton"
                    id="button-with-loading"
                    class="vs-con-loading__container"
                    v-on:click.prevent="login(form)"
                    type="relief"
                    vslor="primary"
                    >Login</vs-button
                  >
                </form>
              </div>
            </div>
          </div>
        </div>
      </vx-card>
    </div>
  </div>
</template>

<script>
import { mapActions, mapMutations, mapGetters, mapState } from 'vuex'

export default {
  data () {
    return {
      form: {
        email: '',
        password: ''
      },
      backgroundLoading: 'primary',
      colorLoading: '#fff'
    }
  },
  computed: {
    ...mapGetters(['isAuth']),
    ...mapState(['error'])
  },
  methods: {
    // ...mapActions(["checkLogin"]),
    ...mapMutations(['clearError']),
    login (data) {
      this.$vs.loading({
        background: this.backgroundLoading,
        color: this.colorLoading,
        container: '#button-with-loading',
        scale: 0.45
      })
      this.$store.dispatch('checkLogin', {
        email: data.email,
        password: data.password
      })
      this.$router.push({ name: 'dashboard' })
    },
    onSubmit (e) {
      e.preventDefault()
    }
  }
}
</script>
<style lang="stylus">
.fill-row {
  flex: 0 0 100%;
  margin-top: 20px;
  margin-bottom: 20px;
}

#div-with-loading {
  width: 200px;
  height: 200px;
  margin: auto;
  display: flex;
  justify-content: center;
  align-items: center;
  border-radius: 5px;
  box-shadow: 0px 3px 10px 0px rgba(0, 0, 0, 0.1);
}
</style>
<style lang="scss">
#page-login {
  .social-login-buttons {
    .bg-facebook {
      background-color: #1551b1;
    }
    .bg-twitter {
      background-color: #00aaff;
    }
    .bg-google {
      background-color: #4285f4;
    }
    .bg-github {
      background-color: #333;
    }
  }
}
</style>
