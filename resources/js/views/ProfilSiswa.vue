<script setup>
import { ref, onMounted, watch } from 'vue'
import axios from 'axios'

const props = defineProps({
    siswaId: {
        type: [Number, String],
        required: true
    }
})

// State utama
const profil = ref({
    nama: '',
    no_hp: '',
    email: '',
    tanggal_lahir: '',
    alamat: ''
})
const kelasJenjang = ref('-')
const isLoading = ref(true)
const isEditing = ref(false)
const isSaving = ref(false)

// Fungsi ambil data dari Laravel
const fetchProfilSiswa = async (id) => {
    if (!id) {
        isLoading.value = false
        return
    }
    
    isLoading.value = true
    try {
        const response = await axios.get(`/api/siswa/profil/${id}`)
        if (response.data && response.data.siswa) {
            const dataSiswa = response.data.siswa
            
            // Satukan pemetaan field agar tidak crash jika ada kolom null
            profil.value = {
                nama: dataSiswa.nama || dataSiswa.nama_anggota || dataSiswa.nama_pendaftar || '',
                no_hp: dataSiswa.no_hp || dataSiswa.telepon || '',
                email: dataSiswa.email || '',
                tanggal_lahir: dataSiswa.tanggal_lahir || dataSiswa.tgl_lahir || '',
                alamat: dataSiswa.alamat || ''
            }
            kelasJenjang.value = response.data.kelas || '-'
        }
    } catch (err) {
        console.error("Gagal mengambil data profil:", err)
    } finally {
        isLoading.value = false
    }
}

// Fungsi Simpan Perubahan ke Laravel
const simpanPerubahan = async () => {
    isSaving.value = true
    try {
        await axios.put(`/api/siswa/profil/update/${props.siswaId}`, profil.value)
        alert("Profil berhasil diperbarui!")
        isEditing.value = false
        fetchProfilSiswa(props.siswaId)
    } catch (err) {
        console.error("Gagal menyimpan data:", err)
        alert("Gagal memperbarui profil.")
    } finally {
        isSaving.value = false
    }
}

onMounted(() => {
    fetchProfilSiswa(props.siswaId)
})

watch(() => props.siswaId, (newId) => {
    if (newId) fetchProfilSiswa(newId)
})

const formatTgl = (str) => {
    if (!str) return '-'
    const d = new Date(str)
    if (isNaN(d.getTime())) return str
    return `${String(d.getDate()).padStart(2, '0')}-${String(d.getMonth() + 1).padStart(2, '0')}-${d.getFullYear()}`
}
</script>

<template>
    <div v-if="isLoading" class="loading-component">
        <p>🔄 Menyelaraskan data diri siswa...</p>
    </div>

    <div v-else class="profile-container">
        
        <div class="profile-header">
            <div class="header-text">
                <h3>👤 Informasi Data Pribadi</h3>
                <p>Rincian biodata resmi Anda yang terdaftar pada Sanggar Tari Langlang Buana.</p>
            </div>
            
            <div class="header-action">
                <button v-if="!isEditing" class="edit-btn" @click="isEditing = true">
                    📝 Edit Profil
                </button>
                <div v-else class="action-group">
                    <button class="cancel-btn" :disabled="isSaving" @click="isEditing = false">
                        Batal
                    </button>
                    <button class="save-btn" :disabled="isSaving" @click="simpanPerubahan">
                        {{ isSaving ? 'Menyimpan...' : 'Simpan ✅' }}
                    </button>
                </div>
            </div>
        </div>

        <div class="profile-grid">
            
            <div class="field-box">
                <label>Nama Lengkap</label>
                <input v-if="isEditing" type="text" v-model="profil.nama" class="input-editable">
                <div v-else class="input-readonly">{{ profil.nama || '-' }}</div>
            </div>

            <div class="field-box">
                <label>No. Handphone / WhatsApp</label>
                <input v-if="isEditing" type="text" v-model="profil.no_hp" class="input-editable">
                <div v-else class="input-readonly">{{ profil.no_hp || '-' }}</div>
            </div>

            <div class="field-box">
                <label>Email Akun</label>
                <div class="input-readonly email-locked">{{ profil.email || '-' }}</div>
            </div>

            <div class="field-box">
                <label>Tingkat Jenjang Kelas</label>
                <div class="input-readonly text-bold-blue">{{ kelasJenjang }}</div>
            </div>

            <div class="field-box">
                <label>Tanggal Lahir</label>
                <input v-if="isEditing" type="date" v-model="profil.tanggal_lahir" class="input-editable">
                <div v-else class="input-readonly">{{ formatTgl(profil.tanggal_lahir) }}</div>
            </div>

            <div class="field-box full-width">
                <label>Alamat Rumah</label>
                <textarea v-if="isEditing" v-model="profil.alamat" class="input-editable textarea-style"></textarea>
                <div v-else class="input-readonly textarea-style">{{ profil.alamat || '-' }}</div>
            </div>
            
        </div>
    </div>
</template>

<style scoped>
.profile-container { background: #ffffff; padding: 35px; border-radius: 8px; border: 1px solid #e2e2e2; }
.profile-header { margin-bottom: 30px; border-bottom: 2px solid #ECE8DD; padding-bottom: 15px; display: flex; justify-content: space-between; align-items: center; gap: 20px; }
.profile-header h3 { color: #005F7F; font-size: 22px; font-weight: 600; }
.profile-header p { font-size: 13px; color: #666666; margin-top: 5px; }

.edit-btn { background: #005F7F; color: white; border: none; padding: 10px 20px; border-radius: 6px; font-weight: 600; cursor: pointer; transition: 0.2s; }
.edit-btn:hover { background: #00465e; }
.action-group { display: flex; gap: 10px; }
.save-btn { background: #2e7d32; color: white; border: none; padding: 10px 18px; border-radius: 6px; font-weight: 600; cursor: pointer; }
.save-btn:hover { background: #1b5e20; }
.cancel-btn { background: #e0e0e0; color: #333; border: none; padding: 10px 18px; border-radius: 6px; font-weight: 600; cursor: pointer; }
.cancel-btn:hover { background: #d5d5d5; }

.profile-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 25px; }
.field-box { display: flex; flex-direction: column; gap: 8px; }
.field-box.full-width { grid-column: span 2; }
.field-box label { font-size: 14px; font-weight: 600; color: #444444; }

.input-readonly { background: #f9f9f9; border: 1px solid #e2e2e2; height: 50px; line-height: 48px; padding: 0 16px; border-radius: 6px; font-size: 15px; color: #222222; }
.email-locked { background: #f0f0f0; color: #777; cursor: not-allowed; }
.input-editable { background: #ffffff; border: 1px solid #005F7F; height: 50px; padding: 0 16px; border-radius: 6px; font-size: 15px; color: #222222; outline: none; }
.textarea-style { height: auto; min-height: 90px; line-height: 1.6; padding: 12px 16px; }
.text-bold-blue { font-weight: 600; color: #005F7F; background: #f0f6f8; }
.loading-component { padding: 50px; text-align: center; color: #005F7F; font-size: 16px; font-weight: 500; }

@media(max-width: 768px) { 
    .profile-header { flex-direction: column; align-items: flex-start; }
    .profile-grid { grid-template-columns: 1fr; } 
    .field-box.full-width { grid-column: span 1; } 
}
</style>