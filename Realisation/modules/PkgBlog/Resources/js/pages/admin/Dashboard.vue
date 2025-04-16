<template>
    <Layout>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6">
            <!-- Bar Chart showing Article Counts -->
            <div class="shadow-lg rounded-lg overflow-hidden bg-white">
                <Chart v-if="barChartData" :chartType="'bar'" :chartData="barChartData" :chartOptions="chartOptions" />
            </div>

            <!-- Line Chart showing Views -->
            <div class="shadow-lg rounded-lg overflow-hidden bg-white">
                <Chart v-if="lineChartData" :chartType="'line'" :chartData="lineChartData"
                    :chartOptions="chartOptions" />
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

import Layout from "../../components/Layout.vue";
import Chart from "../../components/Chart.vue";

// Reactive variables for chart data
const barChartData = ref(null);
const lineChartData = ref(null);
const chartOptions = ref({
    responsive: true,
    maintainAspectRatio: false,
});

const fetchChartData = async () => {
    try {
        const response = await axios.get("/chart-data/articles");

        // Bar Chart Data (Article count per month)
        barChartData.value = {
            labels: response.data.labels,
            datasets: [
                {
                    label: "Articles Created",
                    data: response.data.datasets[0].data,
                    backgroundColor: "rgba(75, 192, 192, 0.6)",
                },
            ],
        };

        // Line Chart Data (View count per month)
        lineChartData.value = {
            labels: response.data.labels,
            datasets: [
                {
                    label: "Total Views",
                    data: response.data.datasets[1].data,
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 2,
                    fill: false,
                },
            ],
        };
    } catch (error) {
        console.error("Error fetching chart data:", error);
    }
};

// Fetch data on mounted
onMounted(fetchChartData);
</script>
