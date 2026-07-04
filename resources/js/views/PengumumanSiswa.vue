<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const loading = ref(true)

const pengumumanList = ref([])

const showModal = ref(false)

const selected = ref(null)

const loadData = async () => {
    try {

        const res = await axios.get('/api/pengumuman')

        pengumumanList.value = res.data

    } catch (err) {

        console.error(err)

    } finally {

        loading.value = false

    }
}

const lihatDetail = (item) => {
    selected.value = item
    showModal.value = true
}

const closeModal = () => {
    showModal.value = false
}

onMounted(() => {
    loadData()
})
</script>

<template>

<div>

    <div v-if="loading">
        Memuat pengumuman...
    </div>

    <div v-else>

        <div
            v-for="item in pengumumanList"
            :key="item.id"
            class="announcement-card"
        >

            <div class="top-row">

                <div>

                    <h3>{{ item.judul }}</h3>

                    <span>
                        📅 {{ item.tanggal }}
                    </span>

                </div>

                <button
                    class="detail-btn"
                    @click="lihatDetail(item)"
                >
                    Detail
                </button>

            </div>

            <p>
                {{
                    item.isi.length > 120
                    ? item.isi.substring(0,120) + '...'
                    : item.isi
                }}
            </p>

        </div>

    </div>

    <!-- MODAL -->

    <div
        v-if="showModal"
        class="modal-overlay"
        @click.self="closeModal"
    >

        <div class="modal-box">

            <h2>
                {{ selected?.judul }}
            </h2>

            <div class="date-text">
                📅 {{ selected?.tanggal }}
            </div>

            <hr>

            <p class="content-text">
                {{ selected?.isi }}
            </p>

            <button
                class="close-btn"
                @click="closeModal"
            >
                Tutup
            </button>

        </div>

    </div>

</div>

</template>

<style scoped>

.announcement-card{
    background:white;
    border-radius:10px;
    padding:20px;
    margin-bottom:15px;
    border-left:5px solid #005F7F;
}

.top-row{
    display:flex;
    justify-content:space-between;
}

.top-row h3{
    color:#005F7F;
    margin-bottom:8px;
}

.detail-btn{
    background:#005F7F;
    color:white;
    border:none;
    padding:10px 15px;
    border-radius:5px;
    cursor:pointer;
}

.modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.5);
    display:flex;
    justify-content:center;
    align-items:center;
}

.modal-box{
    width:700px;
    max-width:95%;
    background:white;
    border-radius:12px;
    padding:30px;
}

.content-text{
    margin-top:20px;
    line-height:1.8;
    white-space:pre-line;
}

.close-btn{
    margin-top:20px;
    background:#005F7F;
    color:white;
    border:none;
    padding:10px 20px;
    border-radius:5px;
}

</style>