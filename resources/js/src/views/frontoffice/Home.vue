<template>
  <div class="h-screen flex w-full bg-img">
    <div
      class="grid sm:grid-cols-1 md:grid-cols-2 md:gap-10 lg:gap-20 items-center justify-center sm:w-1/2 md:w-3/4 lg:w-3/4 xl:w-9/12 mx-auto"
    >
      <div class="text-center">
        <img
          src="@assets/images/Hero.svg"
          alt="Hero"
          class="mx-auto mb-4 max-w-full"
        />
        <h1 class="font-bold">Parking App</h1>
      </div>

      <vx-card title="Parking Now">
        <vs-tabs>
          <vs-tab label="Parking">
            <parking></parking>
          </vs-tab>
          <vs-tab label="Payment">
            <payment></payment>
          </vs-tab>
        </vs-tabs>
      </vx-card>
    </div>
  </div>
</template>

<script>
import VxCard from "@/components/vx-card/VxCard.vue";
import Parking from "./Parking.vue";
import Payment from "./Payment.vue";
export default {
  components: {
    VxCard,
    Payment,
    Parking,
  },
};
</script>
