<template>
  <div class="pembayaran-wrapper">
    <div class="pembayaran-card">
      <h4 class="card-title">💳 Riwayat Pembayaran Iuran</h4>

      <div class="filter-box">
        <div class="filter-group">
          <label>Cari Periode / Jenis</label>
          <input 
            type="text" 
            v-model="searchQuery" 
            placeholder="Contoh: Bulanan / Mei 2026..." 
            class="form-control"
          />
        </div>
        <div class="filter-group">
          <label>Status Pembayaran</label>
          <select v-model="statusFilter" class="form-control">
            <option value="semua">Semua Status</option>
            <option value="lunas">Lunas</option>
            <option value="belum">Belum Lunas</option>
          </select>
        </div>
      </div>

      <div v-if="loading" class="loading-container">
        <p>Sedang memuat histori transaksi iuran Anda...</p>
      </div>

      <div v-else-if="error" class="error-container">
        <p>⚠️ Gagal memuat data riwayat pembayaran dari server.</p>
      </div>

      <div v-else-if="filteredRiwayat.length === 0" class="no-data-info">
        <p>Tidak ada catatan riwayat pembayaran yang cocok atau ditemukan.</p>
      </div>

      <div v-else class="table-responsive">
        <table class="table-custom">
          <thead>
            <tr>
              <th style="width: 60px;">No</th>
              <th>Tanggal Bayar</th>
              <th>Jenis Iuran</th>
              <th>Periode</th>
              <th>Nominal</th>
              <th>Keterangan</th>
              <th style="text-align: center; width: 130px;">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, idx) in filteredRiwayat" :key="idx">
              <td>{{ idx + 1 }}</td>
              <td>{{ formatTanggal(item.tanggal) }}</td>
              <td>
                <span class="type-badge">{{ item.jenis }}</span>
              </td>
              <td class="font-semibold">{{ item.periode }}</td>
              <td class="price-text">{{ formatRupiah(item.nominal) }}</td>
              <td><span class="text-muted-table">{{ item.keterangan }}</span></td>
              <td style="text-align: center;">
                <span 
                  class="status-badge" 
                  :class="item.status === 'lunas' ? 'badge-lunas' : 'badge-belum'"
                >
                  {{ item.status === 'lunas' ? 'Lunas' : 'Belum' }}
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed, defineProps } from 'vue'
import axios from 'axios'

// Menerima parameter id siswa yang sedang login dari DashboardSiswa.vue
const props = defineProps({
  siswaId: {
    type: [Number, String],
    required: true
  }
})

// State manajemen data komponen
const loading = ref(true)
const error = ref(false)
const listRiwayat = ref([])

// State untuk fitur pencarian interaktif
const searchQuery = ref('')
const statusFilter = ref('semua')

/**
 * Mengubah format nominal angka menjadi format Rupiah Indonesia (Rp xx.xxx)
 */
const formatRupiah = (angka) => {
  if (!angka) return 'Rp 0'
  return 'Rp ' + Number(angka).toLocaleString('id-ID', { minimumFractionDigits: 0 })
}

/**
 * Mengubah string tanggal standard YYYY-MM-DD menjadi format teks Indonesia resmi
 */
const formatTanggal = (dateStr) => {
  if (!dateStr) return '-'
  const opsi = { year: 'numeric', month: 'long', day: 'numeric' }
  return new Date(dateStr).toLocaleDateString('id-ID', opsi)
}

/**
 * Memanggil endpoint API backend terpisah (SiswaPembayaranController)
 */
const loadPembayaranData = async () => {
  if (!props.siswaId) return
  
  try {
    loading.value = true
    error.value = false
    
    // Melakukan request ke controller terpisah di backend
    const response = await axios.get(`/api/siswa/pembayaran/${props.siswaId}`)
    
    // Mencocokkan data response json struktur baru
    if (response.data && response.data.status) {
      listRiwayat.value = response.data.data || []
    }
  } catch (err) {
    console.error("Gagal menarik data transaksi iuran siswa:", err)
    error.value = true
  } finally {
    loading.value = false
  }
}

/**
 * Logika filter pencarian client-side secara real-time (reactive)
 */
const filteredRiwayat = computed(() => {
  return listRiwayat.value.filter(item => {
    // Filter berdasarkan ketikan input jenis atau periode
    const matchesSearch = 
      item.jenis.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      item.periode.toLowerCase().includes(searchQuery.value.toLowerCase())
      
    // Filter berdasarkan pilihan dropdown status lunas / belum
    const matchesStatus = 
      statusFilter.value === 'semua' || 
      item.status.toLowerCase() === statusFilter.value.toLowerCase()

    return matchesSearch && matchesStatus
  })
})

// Eksekusi pemanggilan fungsi saat komponen dipasang ke DOM
onMounted(() => {
  loadPembayaranData()
})
</script>

<style scoped>
.pembayaran-wrapper {
  width: 100%;
}

.pembayaran-card {
  background: #ffffff;
  padding: 25px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
}

.card-title {
  color: #005F7F;
  margin-bottom: 25px;
  font-size: 18px;
  font-weight: 600;
  border-bottom: 2px solid #eceff1;
  padding-bottom: 12px;
}

/* Form Kontrol Filter Box */
.filter-box {
  display: flex;
  gap: 15px;
  margin-bottom: 25px;
  flex-wrap: wrap;
}

.filter-group {
  display: flex;
  flex-direction: column;
  gap: 6px;
  flex: 1;
  min-width: 200px;
}

.filter-group label {
  font-size: 13px;
  font-weight: 600;
  color: #555;
}

.form-control {
  height: 42px;
  padding: 0 15px;
  border: 1px solid #cccccc;
  border-radius: 6px;
  font-family: 'Poppins', sans-serif;
  font-size: 14px;
  outline: none;
  background: #fdfdfd;
  transition: border-color 0.2s ease;
}

.form-control:focus {
  border-color: #005F7F;
  background: #fff;
}

/* Tabel Kustomisasi Berwarna Tema Langlang Buana */
.table-responsive {
  width: 100%;
  overflow-x: auto;
}

.table-custom {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  font-size: 14.5px;
}

.table-custom th {
  background: #8DB1BA;
  color: white;
  font-weight: 600;
  padding: 14px 16px;
}

.table-custom td {
  padding: 14px 16px;
  border-bottom: 1px solid #f0f0f0;
  color: #333333;
}

.table-custom tbody tr:hover {
  background-color: #fafbfc;
}

/* Penataan Badges Teks */
.font-semibold { 
  font-weight: 500; 
}

.price-text { 
  font-weight: 600; 
  color: #005F7F; 
}

.text-muted-table { 
  font-size: 13px; 
  color: #777; 
}

.type-badge {
  background: #eef2f3;
  color: #455a64;
  padding: 4px 10px;
  border-radius: 4px;
  font-size: 12.5px;
  font-weight: 500;
}

.status-badge {
  font-size: 12.5px;
  padding: 4px 14px;
  border-radius: 20px;
  font-weight: 600;
  display: inline-block;
}

.badge-lunas {
  background: #e6f4ea;
  color: #137333;
}

.badge-belum {
  background: #fce8e6;
  color: #c5221f;
}

/* Feedback Box State */
.loading-container, .error-container, .no-data-info {
  padding: 50px 0;
  text-align: center;
  font-style: italic;
  color: #777777;
}

.loading-container { 
  color: #005F7F; 
  font-style: normal; 
}

.error-container {
  background: #fdf3f2;
  color: #b71c1c;
  border-radius: 6px;
  padding: 20px;
  font-style: normal;
}
</style>