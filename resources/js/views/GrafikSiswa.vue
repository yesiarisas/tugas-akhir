<template>
  <div class="grafik-wrapper">
    <div v-if="loading" class="loading-container">
      <p>Sedang mengambil data perkembangan latihan...</p>
    </div>

    <div v-else-if="error" class="error-container">
      <p>⚠️ {{ errorMessage }}</p>
    </div>

    <div v-else>
      <div class="chart-card">
        <h4 class="card-title">Grafik Perkembangan Nilai Latihan</h4>
        <div class="chart-box" v-if="chartOptions.xaxis.categories.length > 0">
          <apexchart 
            type="bar" 
            height="380" 
            :options="chartOptions" 
            :series="chartSeries"
          ></apexchart>
        </div>
        <div v-else class="no-data-info">
          <p>Belum ada rekaman riwayat penilaian performa latihan dari pelatih.</p>
        </div>
      </div>

      <div class="catatan-card">
        <h4 class="card-title">📝 Catatan Evaluasi Terkini</h4>
        <div v-if="catatanList.length === 0" class="no-data-info">
          <p>Tidak ada catatan atau evaluasi tertulis khusus untuk Anda saat ini.</p>
        </div>
        <div v-else class="catatan-wrapper">
          <div v-for="(item, idx) in catatanList" :key="idx" class="catatan-block">
            <div class="catatan-meta">
              <span class="date-badge">📅 {{ item.tanggal }}</span>
            </div>
            <p class="catatan-content">" {{ item.isi }} "</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, defineProps } from 'vue'
import axios from 'axios'
import apexchart from 'vue3-apexcharts'

const props = defineProps({
  siswaId: {
    type: [Number, String],
    required: true
  }
})

const loading = ref(true)
const error = ref(false)
const errorMessage = ref('')
const catatanList = ref([])

// Konfigurasi Chart Konten
const chartSeries = ref([])
const chartOptions = ref({
  chart: {
    type: 'bar',
    stacked: false, // DIUBAH: false agar grafik batang menjadi sejajar/berdampingan
    toolbar: { show: false }
  },
  colors: ['#005F7F', '#8DB1BA', '#d4b000'], // Konsistensi palet warna Langlang Buana
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '55%', // DISESUAIKAN: Sedikit diperlebar agar proporsional saat berdampingan
      borderRadius: 4
    }
  },
  dataLabels: {
    enabled: true, // DIUBAH: true jika Anda ingin nilai angka langsung muncul di atas setiap batang
    style: {
      fontSize: '11px',
      colors: ['#fff']
    }
  },
  xaxis: {
    categories: [],
    title: { 
      text: 'Periode Evaluasi Latihan (Bulan-Minggu)',
      style: { fontFamily: 'Poppins, sans-serif', color: '#555' }
    }
  },
  yaxis: {
    min: 0,   // DIUBAH: Batas bawah nilai standar 0
    max: 100, // DIUBAH: Mengunci garis batas maksimal ukur tepat di angka 100
    tickAmount: 5, // TAMBAHAN: Membuat garis pembagi sumbu Y rapi kelipatan 20 (0, 20, 40, 60, 80, 100)
    title: { 
      text: 'Nilai Perkembangan Latihan', // DIUBAH: Menyesuaikan indikator dari akumulasi ke nilai riil
      style: { fontFamily: 'Poppins, sans-serif', color: '#555' }
    }
  },
  legend: {
    position: 'top',
    horizontalAlign: 'center',
    fontFamily: 'Poppins'
  },
  tooltip: {
    y: {
      formatter: (val) => val + " Poin"
    }
  }
})

// Request ke endpoint SiswaEvaluasiController
const loadEvaluasiData = async () => {
  if (!props.siswaId) return
  
  try {
    loading.value = true
    error.value = false
    
    const response = await axios.get(`/api/siswa/evaluasi/${props.siswaId}`)
    
    if (response.data && response.data.status) {
      chartSeries.value = response.data.chart_data.series
      chartOptions.value = {
        ...chartOptions.value,
        xaxis: {
          ...chartOptions.value.xaxis,
          categories: response.data.chart_data.labels
        }
      }
      catatanList.value = response.data.catatan || []
    }
  } catch (err) {
    console.error("Gagal menarik data api evaluasi:", err)
    error.value = true
    errorMessage.value = "Gagal memuat visualisasi grafik dari server."
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  loadEvaluasiData()
})
</script>

<style scoped>
.grafik-wrapper {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.chart-card, .catatan-card {
  background: #ffffff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 4px 12 rgba(0, 0, 0, 0.05);
}

.card-title {
  color: #005F7F;
  margin-bottom: 25px;
  font-size: 18px;
  font-weight: 600;
  border-bottom: 2px solid #eceff1;
  padding-bottom: 12px;
}

.chart-box {
  padding: 5px 0;
}

.no-data-info {
  text-align: center;
  padding: 40px 0;
  color: #777777;
  font-style: italic;
  font-size: 14px;
}

.catatan-wrapper {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.catatan-block {
  background: #fdfcf9;
  padding: 15px 20px;
  border-radius: 6px;
  border: 1px solid #f3ebd7;
  border-left: 5px solid #d4b000;
}

.catatan-meta {
  margin-bottom: 8px;
}

.date-badge {
  font-size: 12px;
  background: #8DB1BA;
  color: #ffffff;
  padding: 4px 12px;
  border-radius: 20px;
  font-weight: 500;
}

.catatan-content {
  font-size: 14px;
  color: #333333;
  line-height: 1.5;
  font-style: italic;
}

.loading-container, .error-container {
  padding: 40px;
  text-align: center;
  font-weight: 500;
}

.loading-container { color: #005F7F; }
.error-container {
  background: #fdf3f2;
  color: #b71c1c;
  border-radius: 6px;
  border-left: 5px solid #b71c1c;
}
</style>