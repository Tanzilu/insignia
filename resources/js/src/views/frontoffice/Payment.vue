<template>
  <div class="vx-row mb-2">
    <div class="vx-col w-full my-5">
      <vs-input
        class="w-full my-5"
        v-model="no_payment"
        label-placeholder="No Payment"
        name="no_payment"
        v-validate="{
          required: true,
        }"
      />
      <span class="text-danger text-sm" v-show="errors.has('no_payment')">{{
        errors.first("no_payment")
      }}</span>
      <vs-button class="mr-3 my-2" v-on:click="checkOut">Submit</vs-button>

      <div v-if="isAlreadyPay">
        <h3>Here your invoice</h3>
        <vs-input
          class="w-full my-5"
          v-model="data.no_payment"
          label="No Payment"
          disabled
        />
        <vs-input
          class="w-full my-5"
          v-model="data.price"
          label="Price"
          disabled
        />
        <vs-input
          class="w-full my-5"
          v-model="data.time"
          label="Estimate"
          disabled
        />
      </div>
    </div>
  </div>
</template>


<script>
import axios from "axios";
export default {
  data() {
    return {
      no_payment: "",
      data: {
        no_payment: "",
        price: "",
        time: "",
      },
      isAlreadyPay: "",
    };
  },

  methods: {
    checkOut() {
      const input = {
        no_payment: this.no_payment,
      };

      axios
        .put("api/exitParking", input)
        .then((response) => {
          this.$vs.notify({
            title: "Success",
            text: response.data.status,
            color: "success",
            position: "top-right",
          });
          this.data.no_payment = response.data.invoice.no_payment;
          this.data.price = response.data.invoice.price;
          this.data.time = response.data.invoice.time;
          this.isAlreadyPay = response.data.isAlreadyPay;
        })
        .catch((error) => {
          this.$vs.notify({
            title: "Failed",
            text: error.response.data.status,
            color: "danger",
            position: "top-right",
          });
          console.log(error.response.data);
        });
    },
  },
};
</script>