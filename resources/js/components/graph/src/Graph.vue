<template>
  <div class="chart-container">
    <canvas ref="canvasRef"></canvas>
  </div>
</template>

<script setup>
import { ref, watch, onMounted, onBeforeUnmount, computed } from 'vue'
import { Chart, registerables } from 'chart.js'

// Registrar componentes de Chart.js
Chart.register(...registerables)

// Props
const props = defineProps({
  type: {
    type: String,
    default: 'doughnut'
  },
  allData: {
    type: Object,
    default: () => ({})
  }
})

// Refs
const canvasRef = ref(null)
const chart = ref(null)
const observer = ref(null)
const themeChangeHandler = ref(null)

// Estado
const colors = ref({
  primary: '#0d6efd',
  danger: '#dc3545',
  warning: '#ffc107',
})

// Plugin personalizado para etiquetas en doughnut
const doughnutLabelPlugin = {
  id: 'doughnutLabel',
  beforeDraw(chart) {
    if (chart.config.options.plugins?.doughnutlabel) {
      const width = chart.width
      const height = chart.height
      const ctx = chart.ctx

      ctx.restore()

      const mainFontSize = Math.min(height / 10, 16)
      ctx.font = `bold ${mainFontSize}px Arial, sans-serif`
      ctx.textBaseline = 'middle'
      ctx.textAlign = 'center'

      const text = chart.config.options.plugins.doughnutlabel.labels[0].text
      ctx.fillStyle = chart.config.options.plugins.doughnutlabel.labels[0].color
      ctx.fillText(text, width / 2, height / 2 - 10)

      const subFontSize = Math.min(height / 16, 12)
      ctx.font = `${subFontSize}px Arial, sans-serif`
      ctx.fillStyle = chart.config.options.plugins.doughnutlabel.labels[1].color
      ctx.fillText('Total', width / 2, height / 2 + 15)

      ctx.save()
    }
  }
}

// Registrar el plugin solo una vez usando una variable global
if (!window._doughnutLabelPluginRegistered) {
  try {
    Chart.register(doughnutLabelPlugin)
    window._doughnutLabelPluginRegistered = true
  } catch (error) {
    // Si el plugin ya está registrado, Chart.js lanzará un error
    // pero eso está bien, solo significa que ya está registrado
    console.warn('Plugin doughnutLabel ya estaba registrado o hubo un error:', error)
    window._doughnutLabelPluginRegistered = true
  }
}

// Computed
const getTotal = computed(() => {
  if (!props.allData?.datasets?.[0]) return 'S/ 0.00'
  const total = props.allData.datasets[0].data.reduce((a, b) => a + b, 0)
  return (total < 0 ? 'S/ -' : 'S/ ') + Math.abs(total).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
})

const getTextColor = computed(() => {
  const isDarkMode = document.documentElement.classList.contains('dark')
  if (!props.allData?.datasets?.[0]) {
    return isDarkMode ? '#ffffff' : '#4A4A4A'
  }
  const total = props.allData.datasets[0].data.reduce((a, b) => a + b, 0)
  if (isDarkMode) return '#ffffff'
  return total < 0 ? colors.value.danger : colors.value.primary
})

const chartOptions = computed(() => {
  return {
    maintainAspectRatio: false,
    cutout: '75%',
    rotation: -0.5 * Math.PI,
    circumference: 2 * Math.PI,
    plugins: {
      legend: { display: false },
      doughnutlabel: {
        labels: [
          {
            text: getTotal.value,
            font: { size: '20', family: "'Arial', sans-serif", weight: 'bold' },
            color: getTextColor.value,
          },
          {
            text: 'Total',
            font: { size: '16', family: "'Arial', sans-serif" },
            color: '#9B9B9B',
          },
        ],
      },
    },
    elements: {
      arc: { 
        borderWidth: 2, 
        borderColor: '#FFFFFF', 
        borderAlign: 'center', 
        borderRadius: 15, 
        spacing: 10 
      },
    },
  }
})

// Métodos
const refreshColors = () => {
  const style = getComputedStyle(document.documentElement)
  const fallback = {
    primary: '#0d6efd',
    danger: '#dc3545',
    warning: '#ffc107',
  }

  colors.value = {
    primary: style.getPropertyValue('--primary-color').trim() || colors.value.primary || fallback.primary,
    danger: style.getPropertyValue('--danger').trim() || colors.value.danger || fallback.danger,
    warning: style.getPropertyValue('--warning').trim() || colors.value.warning || fallback.warning,
  }
}

const hexToRgba = (hex, alpha = 1) => {
  let r = 0, g = 0, b = 0

  if (hex.startsWith('#')) hex = hex.slice(1)

  if (hex.length === 3) {
    r = parseInt(hex[0] + hex[0], 16)
    g = parseInt(hex[1] + hex[1], 16)
    b = parseInt(hex[2] + hex[2], 16)
  } else if (hex.length === 6) {
    r = parseInt(hex.slice(0, 2), 16)
    g = parseInt(hex.slice(2, 4), 16)
    b = parseInt(hex.slice(4, 6), 16)
  }

  return `rgba(${r}, ${g}, ${b}, ${alpha})`
}

const getSegmentColors = (data) => {
  const customColors = ['#004387', '#16a34a']
  return data.map((value, index) => {
    const color = customColors[index % customColors.length]
    return {
      backgroundColor: hexToRgba(color, 0.8),
      borderColor: hexToRgba(color, 1),
      hoverBackgroundColor: hexToRgba(color, 0.9),
      hoverBorderColor: hexToRgba(color, 1)
    }
  })
}

const createChart = () => {
  if (!props.allData?.datasets || !canvasRef.value) {
    return
  }

  if (chart.value) {
    chart.value.destroy()
  }

  const datasets = props.allData.datasets.map(dataset => {
    const segmentColors = getSegmentColors(dataset.data)

    return {
      ...dataset,
      backgroundColor: segmentColors.map(c => c.backgroundColor),
      borderColor: segmentColors.map(c => c.borderColor),
      borderWidth: 2,
    }
  })

  chart.value = new Chart(canvasRef.value.getContext('2d'), {
    type: 'doughnut',
    data: {
      labels: props.allData.labels || [],
      datasets: datasets
    },
    options: chartOptions.value,
  })
}

const handleThemeChange = () => {
  refreshColors()
  if (props.allData?.datasets?.length) {
    createChart()
  }
}

const setupThemeObserver = () => {
  teardownThemeObserver()

  const handler = () => {
    handleThemeChange()
  }

  window.addEventListener('theme:change', handler)
  themeChangeHandler.value = handler

  observer.value = new MutationObserver(() => {
    handleThemeChange()
  })

  observer.value.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class', 'style'],
  })
}

const teardownThemeObserver = () => {
  if (observer.value) {
    observer.value.disconnect()
    observer.value = null
  }

  if (themeChangeHandler.value) {
    window.removeEventListener('theme:change', themeChangeHandler.value)
    themeChangeHandler.value = null
  }
}

// Watch
watch(() => props.allData, () => {
  createChart()
}, { deep: true })

// Lifecycle
onMounted(() => {
  refreshColors()
  setupThemeObserver()

  // Crear gráfico inicial si ya hay datos
  if (props.allData?.datasets) {
    createChart()
  }
})

onBeforeUnmount(() => {
  teardownThemeObserver()

  if (chart.value) {
    chart.value.destroy()
  }
})
</script>

<style scoped>
.chart-container {
  position: relative;
  margin: auto;
  height: 220px;
  width: 220px;
}

.chart-container .chartjs-render-monitor {
  height: inherit !important;
  width: inherit !important;
}
</style>
