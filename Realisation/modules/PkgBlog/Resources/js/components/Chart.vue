<template>
    <div class="card bg-base-100 shadow-xl w-full max-w-full mx-auto p-4">
        <canvas ref="chartCanvas" class="w-full h-72"></canvas>
    </div>
</template>

<script>
import { ref, onMounted, watch } from 'vue';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

export default {
    props: {
        chartType: { type: String, required: true },
        chartData: { type: Object, required: true },
        chartOptions: { type: Object, default: () => ({}) },
    },
    setup(props) {
        const chartCanvas = ref(null);
        let chartInstance = null;

        onMounted(() => {
            if (chartCanvas.value) {
                chartInstance = new Chart(chartCanvas.value, {
                    type: props.chartType,
                    data: props.chartData,
                    options: props.chartOptions,
                });
            }
        });

        watch(() => props.chartData, (newData) => {
            if (chartInstance) {
                chartInstance.data = newData;
                chartInstance.update();
            }
        }, { deep: true });

        return { chartCanvas };
    },
};
</script>
