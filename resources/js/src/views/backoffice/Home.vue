<template>
  <div class="vx-row">
    <div class="vx-col w-full mb-base">
      <vx-card title="Report Parking">
        <vs-tabs>
          <vs-tab label="Year">
            <year></year>
          </vs-tab>
          <vs-tab label="Month">
            <month></month>
          </vs-tab>
          <vs-tab label="Day">
            <day></day>
          </vs-tab>
        </vs-tabs>
      </vx-card>
    </div>
  </div>
</template>

<script>
import Day from "./chart/Day.vue";
import Month from "./chart/Month.vue";
import Year from "./chart/Year.vue";

export default {
  components: {
    Day,
    Month,
    Year,
  },
};
</script>