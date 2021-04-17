<template>
    <form>
      <div class="vx-row mb-2">
        <div class="vx-col w-full my-5">
          <vs-input
            class="w-full"
            v-model="license_plate"
            label-placeholder="License Plate"
            name="license_plate"
            v-validate="{
              required: true,
              regex: /^[A-Z]{1,2}-[0-9]{1,4}-[A-Z]{1,3}$/i,
            }"
          />
          <span class="text-sm text-black my-2">*i.e. <i>Z-0000-XX</i></span> <br>

          <span
            class="text-danger text-sm"
            v-show="errors.has('license_plate')"
            >{{ errors.first("license_plate") }}</span
          ><br />

          <vs-input disabled class="w-full" v-if="isParking" v-model="data.no_payment" label="Here is your number payment"/>

        </div>
      </div>
      <vs-button class="mr-3 mb-2" :class="{'activeLoading':activeLoading}" :id="[`loading-${type}`]" v-on:click="checkIn">Submit</vs-button>
    </form>
  </vs-tab>
</template>


<script>
import axios from "axios";
export default {
  data() {
    return {
      license_plate: "",
      data: {
        no_payment: "",
      },
      isParking: "",
      activeLoading: false,
      type: "point",
    };
  },

  methods: {
    checkIn() {
      this.activeLoading = true;

      const input = {
        license_plate: this.license_plate,
      };
      this.$validator.validateAll().then((result) => {
        if (result) {
          axios
            .post("api/enterParking", input)
            .then((response) => {
              this.$vs.notify({
                title: "Success",
                text: response.data.status,
                color: "success",
                position: "top-right",
              });
              this.data.no_payment = response.data.invoice.no_payment;
              this.isParking = response.data.IsParking;
              this.activeLoading = false;
            })
            .catch((error) => {
              console.log(error.response.data);
            });
        } else {
          // form have errors
        }
      });
    },
  },
};
</script>

<style lang="scss">
.fill-row-loading {
  display: flex;
  align-items: center;
  justify-content: center;
  flex-wrap: wrap;
  .loading-example {
    width: 120px;
    float: left;
    height: 120px;
    box-shadow: 0px 5px 20px 0px rgba(0, 0, 0, 0.05);
    border-radius: 10px;
    margin: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
    &:hover {
      box-shadow: 0px 0px 0px 0px rgba(0, 0, 0, 0.05);
      transform: translate(0, 4px);
    }
    h4 {
      z-index: 40000;
      position: relative;
      text-align: center;
      padding: 10px;
    }
    &.activeLoading {
      opacity: 0 !important;
      transform: scale(0.5);
    }
  }
}
</style>