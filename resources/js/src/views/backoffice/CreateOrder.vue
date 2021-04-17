<template>
  <div class="centerx"> 
    <vs-button @click="popupActivo=true" color="primary" type="border">Create Order</vs-button>
    <vs-popup class="holamundo"  title="Lorem ipsum dolor sit amet" :active.sync="popupActivo">
       
        <div>
            <label class="my-5" for="Email">
                Email
            </label>
            <vs-input
                class="w-full my-5"
                v-model="email"
                placeholder="Email"
                name="email"
                v-validate="{
                    required: true,
                    email: true
                }"
            />
            <span class="text-danger text-sm" v-show="errors.has('email')">
                {{ errors.first("email") }}
            </span>
        </div>

        <div>
            <label class="my-5" for="Payment Status">
                Payment Status
            </label>
            <v-select v-model="payment_status" class="my-5" :options="['Unpaid', 'Fully paid' ]"></v-select>
        </div>

        <div>
            <label class="my-5" for="Fulfillment Status">
                Fulfillment Status
            </label>
            <v-select v-model="fulfillment_status" class="my-5" :options="['Unfulfillment', 'Fulfillment' ]"></v-select>
        </div>

        <div>
            <label class="my-5" for="Total">
                Total
            </label>
            <vs-input
                class="w-full my-5"
                v-model="total"
                placeholder="Total"
                name="total"
                v-validate="{
                    required: true,
                    numeric: true
                }"
            />
            <span class="text-danger text-sm" v-show="errors.has('total')">
                {{ errors.first("total") }}
            </span>
        </div>

        <vs-button class="mr-3 my-2" v-on:click="submit">Submit</vs-button>
    </vs-popup>

  </div>
</template>

<script>
import vSelect from 'vue-select'
import axios from '@/axios.js'

export default {
  components: {
    vSelect
  },
  data () {
    return {
      email: '',
      payment_status: '',
      fulfillment_status: '',
      total: '',
      popupActivo:false
    }
  },
  methods: {
    submit () {
      const input = {
        email: this.email,
        payment_status: this.payment_status,
        fulfillment_status: this.fulfillment_status,
        total: this.total
      }
      console.log(this.fulfillment_status)
      axios
        .post('api/createOrder', input)
        .then((response) => {
          this.$vs.notify({
            title: 'Success',
            text: response.data.status,
            color: 'success',
            position: 'top-right'
          })
          this.popupActivo = false         
        })
        .catch((error) => {
    
          console.log(error.response.data)
        })
    }
  }
}
</script>