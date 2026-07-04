<template>
  <div class="jadwal-container">
    <div v-if="loading" class="loading-state-box">
      <p>Memuat data jadwal latihan Anda...</p>
    </div>

    <div v-else-if="error" class="error-state-box">
      <p>⚠️ {{ errorMessage }}</p>
    </div>

    <div v-else>
      <!-- Info Banner Kategori Kelas Siswa -->
      <div class="kelas-banner">
        <p>Kategori Kelas Anda saat ini: <strong>{{ namaKelas }}</strong></p>
      </div>

      <!-- Jika data jadwal dari admin kosong -->
      <div v-if="listJadwal.length === 0" class="empty-state-card">
        <p>Belum ada jadwal latihan yang aktif untuk kategori kelas tari Anda saat ini.</p>
      </div>

      <!-- Tampilan Split Layout Sesuai Gambar Referensi -->
      <div v-else class="split-jadwal-layout">
        <div v-for="jadwal in listJadwal" :key="jadwal.id" class="jadwal-row-wrapper">
          
          <!-- SISI KIRI: BANNER TEKS KETERANGAN UTAMA (DINAMIS DARI DATA ADMIN) -->
          <div class="deskripsi-section">
            <div class="deskripsi-header-banner">
              <h3>Keterangan</h3>
            </div>
            <div class="deskripsi-body-content">
              <!-- Menampilkan keterangan dinamis dari backend Dcat Admin -->
              <div v-if="jadwal.keterangan" class="pre-wrapped-text">
                {{ jadwal.keterangan }}
              </div>
              <!-- Jika admin tidak mengisi kolom keterangan -->
              <div v-else class="empty-keterangan">
                <p class="italic text-muted">Tidak ada keterangan tambahan untuk jadwal latihan ini.</p>
              </div>
            </div>
          </div>

          <!-- SISI KANAN: KARTU RINGKASAN JADWAL (WIDGET CARD) -->
          <div class="info-card-section">
            <div class="sanggar-brand-header">
              <!-- Logo diambil dari direktori storage sesuai berkas referensi image_c3c586.png -->
              <div class="sanggar-logo-circle">
                <img src="/storage/images/logo-langlang.jpg" alt="Logo Sanggar" class="sanggar-logo-img" />
              </div>
              <span class="brand-title">Langlang Buana</span>
            </div>
            
            <div class="brand-divider"></div>

            <div class="info-card-body">
              <h4 class="training-title">Latihan {{ namaKelas }}</h4>
              
              <ul class="spec-info-list">
                <li>
                  <span class="spec-icon">📅</span>
                  <span class="spec-text">{{ jadwal.hari }}</span>
                </li>
                <li>
                  <span class="spec-icon">🕒</span>
                  <span class="spec-text">{{ formatWaktu(jadwal.jam_mulai) }} WIB - Selesai</span>
                </li>
                <li>
                  <span class="spec-icon">🚀</span>
                  <span class="spec-text">{{ jadwal.lokasi }}</span>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const listJadwal = ref([])
const namaKelas = ref('-')
const loading = ref(false)
const error = ref(false)
const errorMessage = ref('')

// Helper Format Waktu Standar (Contoh: "13:00:00" -> "13:00")
const formatWaktu = (timeStr) => {
  if (!timeStr) return '--:--'
  return timeStr.substring(0, 5)
}

const fetchJadwal = async () => {
  try {
    loading.value = true
    error.value = false
    errorMessage.value = ''

    const userData = localStorage.getItem('user-info') || localStorage.getItem('user')
    if (!userData) {
      error.value = true
      errorMessage.value = 'Sesi Anda habis. Silakan login kembali.'
      return
    }

    const user = JSON.parse(userData)
    const idSiswa = user.id || user.id_user

    if (!idSiswa) {
      error.value = true
      errorMessage.value = 'ID Anggota tidak valid.'
      return
    }

    const res = await axios.get(`/api/siswa/jadwal/${idSiswa}`)

    if (res.data && (res.data.status === true || res.data.success === true)) {
      listJadwal.value = res.data.data || []
      namaKelas.value = res.data.kelas || '-'
    } else {
      error.value = true
      errorMessage.value = 'Gagal memuat format data dari server.'
    }

  } catch (err) {
    console.error('Error terhubung ke API Jadwal:', err)
    error.value = true
    if (err.response && err.response.data && err.response.data.message) {
      errorMessage.value = err.response.data.message
    } else {
      errorMessage.value = 'Gagal terhubung ke server untuk memuat jadwal latihan.'
    }
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchJadwal()
})
</script>

<style scoped>
.jadwal-container {
  width: 100%;
}

.loading-state-box {
  padding: 40px;
  text-align: center;
  color: #005F7F;
  font-weight: 500;
}

.error-state-box {
  background: #fce8e6;
  color: #c5221f;
  padding: 15px 20px;
  border-radius: 6px;
  border-left: 5px solid #c5221f;
  font-weight: 500;
}

.kelas-banner {
  background: #8DB1BA;
  color: white;
  padding: 15px 20px;
  border-radius: 6px;
  margin-bottom: 25px;
  font-size: 16px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}

.empty-state-card {
  background: white;
  padding: 40px;
  border-radius: 8px;
  text-align: center;
  color: #777;
  border: 2px dashed #cccccc;
}

/* Penataan Layout Utama Dua Kolom Sampingan */
.split-jadwal-layout {
  display: flex;
  flex-direction: column;
  gap: 30px;
  width: 100%;
}

.jadwal-row-wrapper {
  display: flex;
  gap: 30px;
  align-items: flex-start;
  width: 100%;
}

/* === SISI KIRI: KOTAK KETERANGAN DETAIL === */
.deskripsi-section {
  flex: 1.6;
  background: #F5F5F5;
  border-radius: 16px;
  padding: 25px;
  box-shadow: inset 0 0 4px rgba(0,0,0,0.02);
}

.deskripsi-header-banner {
  background: #005F7F;
  color: white;
  padding: 12px 25px;
  border-radius: 8px;
  font-size: 20px;
  font-weight: 600;
  margin-bottom: 25px;
  display: inline-block;
  width: 100%;
}

.deskripsi-body-content {
  color: #333333;
  font-size: 15.5px;
  line-height: 1.7;
}

.pre-wrapped-text {
  white-space: pre-line; /* Memastikan baris baru (\n) tercetak rapi */
}

.empty-keterangan {
  padding: 20px 0;
  text-align: center;
}

/* === SISI KANAN: WIDGET KARTU JADWAL RINGKAS === */
.info-card-section {
  flex: 1;
  background: #F5F5F5;
  border-radius: 20px;
  padding: 30px 25px;
  box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
  border: 1px solid #eef0f2;
}

.sanggar-brand-header {
  display: flex;
  align-items: center;
  gap: 12px;
  padding-bottom: 5px;
}

.sanggar-logo-circle {
  width: 45px;
  height: 45px;
  background: #fff;
  border: 2px solid #005F7F;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden; /* Mencegah gambar keluar batas lingkaran */
}

.sanggar-logo-img {
  width: 100%;
  height: 100%;
  object-fit: cover; /* Agar gambar memenuhi lingkaran dengan rapi */
}

.brand-title {
  font-size: 22px;
  font-weight: 600;
  color: #005F7F;
  font-family: serif;
}

.brand-divider {
  height: 1.5px;
  background: #cccccc;
  margin: 18px 0;
  width: 100%;
}

.training-title {
  font-size: 22px;
  color: #005F7F;
  font-weight: 700;
  margin-bottom: 20px;
}

.spec-info-list {
  list-style: none;
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.spec-info-list li {
  display: flex;
  align-items: center;
  gap: 14px;
}

.spec-icon {
  font-size: 18px;
  color: #555;
  width: 24px;
  text-align: center;
}

.spec-text {
  font-size: 15px;
  color: #444444;
  font-weight: 500;
}

/* Teks Helper */
.italic { font-style: italic; }
.text-muted { color: #777; }

/* RESPONSIVE LAYOUT UNTUK LAYAR MOBILE */
@media (max-width: 992px) {
  .jadwal-row-wrapper {
    flex-direction: column;
  }
  .deskripsi-section, .info-card-section {
    width: 100%;
    flex: none;
  }
}
</style>