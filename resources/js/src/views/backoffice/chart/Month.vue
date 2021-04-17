<template>
  <vue-apex-charts
    type="line"
    height="350"
    :options="lineChartSimple.chartOptions"
    :series="lineChartSimple.series"
  ></vue-apex-charts>
</template>

<script>
import VueApexCharts from "vue-apexcharts";
import axios from "@/axios.js";
export default {
  data() {
    return {
      lineChartSimple: {
        series: [
          {
            name: "Car",
            data: [],
          },
        ],
        chartOptions: {
          chart: {
            height: 350,
            zoom: {
              enabled: false,
            },
          },
          colors: ["#7367F0", "#28C76F", "#EA5455", "#FF9F43", "#1E1E1E"],
          dataLabels: {
            enabled: false,
          },
          stroke: {
            curve: "straight",
          },
          title: {
            text: "Sum Car Parking by Month",
            align: "left",
          },
          grid: {
            row: {
              colors: ["#f3f3f3", "transparent"],
              opacity: 0.5,
            },
          },
          xaxis: {
            categories: [],
          },
        },
      },
    };
  },
  components: {
    VueApexCharts,
  },
  created() {
    this.fetchDataPerMonth();
  },
  methods: {
    fetchDataPerMonth() {
      axios
        .get("api/getDataPerMonth")
        .then((response) => {
          this.lineChartSimple.chartOptions = {
            xaxis: {
              categories: response.data.map((x) => x.month),
            },
          };
          this.lineChartSimple.series = [
            {
              data: response.data.map((x) => x.sum),
            },
          ];
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>