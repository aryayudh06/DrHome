<script setup lang="ts">
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: 'designers/Form_response',
    },
];
// State untuk form fields
const buildingType = ref(''); // Contoh tipe bangunan: Rumah Tinggal, Villa, dll.
const designStyle = ref('');
const floorPlanFile = ref<File | null>(null);
const notes = ref('');
const designerInput = ref(''); // Bisa readonly atau diedit sesuai peran

// Handler untuk upload file denah/sketsa
const handleFileUpload = (event: Event) => {
  const target = event.target as HTMLInputElement;
  if (target.files && target.files.length > 0) {
    floorPlanFile.value = target.files[0];
    console.log('File selected:', floorPlanFile.value.name);
    // Bisa tambah preview atau validasi file di sini
  }
};

// Submit form handler
const submitForm = () => {
  console.log('Form submitted with data:', {
    buildingType: buildingType.value,
    designStyle: designStyle.value,
    floorPlanFileName: floorPlanFile.value?.name ?? 'No file selected',
    notes: notes.value,
    designerInput: designerInput.value,
  });
  // TODO: Kirim data ke backend API di sini

  alert('Form response sent! (See console for data)');
};
</script>

<template>

  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="page-wrapper form-page-background">
      <!-- Komponen header dengan prop active-link -->
      <PageHeader active-link="Portofolio" />

      <main class="main-content">
        <form @submit.prevent="submitForm" class="response-form">
          <div class="form-card">
            <h2 class="card-title">Design rumah</h2>

            <div class="form-group">
              <label for="buildingType">Tipe Bangunan</label>
              <select id="buildingType" v-model="buildingType" class="form-input" required>
                <option disabled value="">Pilih tipe bangunan...</option>
                <option value="Rumah Tinggal">Rumah Tinggal</option>
                <option value="Villa">Villa</option>
                <option value="Apartemen">Apartemen (Desain Interior)</option>
                <option value="Ruko">Ruko</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>

            <div class="form-group">
              <label for="designStyle">Gaya Desain</label>
              <input type="text" id="designStyle" v-model="designStyle" class="form-input"
                placeholder="Contoh: Minimalis Tropis, Skandinavian, dll." required />
            </div>

            <div class="form-group">
              <label for="floorPlanUpload">Upload Denah / Sketsa Awal</label>
              <input type="file" id="floorPlanUpload" @change="handleFileUpload" class="file-input-hidden"
                accept="image/*,.pdf,.dwg,.skp" />
              <label for="floorPlanUpload" class="file-upload-button" tabindex="0">
                <span class="plus-icon">+</span>
                <span v-if="floorPlanFile" class="file-name-display">{{ floorPlanFile.name }}</span>
                <span v-else class="file-name-display">Pilih file...</span>
              </label>
            </div>
          </div>

          <div class="form-card">
            <h2 class="card-title">Preferensi Tambahan</h2>

            <div class="form-group">
              <label for="notes">Catatan</label>
              <textarea id="notes" v-model="notes" class="form-textarea"
                placeholder="Catatan tambahan mengenai preferensi desain, kebutuhan khusus, dll."></textarea>
            </div>

            <div class="form-group">
              <label for="designerInput">Masukan dari Desainer</label>
              <textarea id="designerInput" v-model="designerInput" class="form-textarea"
                placeholder="Area ini mungkin diisi atau diedit oleh desainer..."></textarea>
            </div>
          </div>

          <div class="submit-button-container">
            <button type="submit" class="send-button">Send</button>
          </div>
        </form>
      </main>

      <PageFooter />
    </div>
  </AppLayout>
</template>

<style scoped>
.page-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

.form-page-background {
  background-color: #f0f0f0;
}

.main-content {
  flex-grow: 1;
  padding: 20px 30px;
  max-width: 800px;
  width: 100%;
  margin: 20px auto;
  box-sizing: border-box;
}

.response-form {
  display: flex;
  flex-direction: column;
  gap: 25px;
}

.form-card {
  background-color: #ffffff;
  border-radius: 12px;
  padding: 25px 30px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.card-title {
  font-size: 1.4em;
  font-weight: 600;
  color: #333;
  margin-bottom: 25px;
  padding-bottom: 10px;
}

.form-group {
  margin-bottom: 20px;
}

.form-group:last-child {
  margin-bottom: 0;
}

.form-group label {
  display: block;
  font-size: 0.95em;
  color: #454545;
  margin-bottom: 8px;
  font-weight: 500;
}

.form-input,
.form-textarea,
.form-select {
  width: 100%;
  padding: 12px 15px;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  background-color: #f9f9f9;
  box-sizing: border-box;
  font-size: 1em;
  color: #333;
  transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.form-input::placeholder,
.form-textarea::placeholder {
  color: #999;
}

.form-input:focus,
.form-textarea:focus,
.form-select:focus {
  outline: none;
  border-color: #007bff;
  box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.2);
}

.form-textarea {
  min-height: 120px;
  resize: vertical;
  font-family: inherit;
}

.file-input-hidden {
  display: none;
}

.file-upload-button {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: 100%;
  min-height: 80px;
  padding: 15px;
  border: 2px dashed #d0d0d0;
  border-radius: 8px;
  background-color: #f9f9f9;
  cursor: pointer;
  text-align: center;
  transition: border-color 0.2s ease-in-out, background-color 0.2s ease-in-out;
}

.file-upload-button:hover {
  border-color: #007bff;
  background-color: #f0f8ff;
}

.plus-icon {
  font-size: 2.5em;
  color: #777;
  line-height: 1;
}

.file-name-display {
  margin-top: 8px;
  font-size: 0.85em;
  color: #555;
  word-break: break-all;
}

.submit-button-container {
  display: flex;
  justify-content: flex-end;
  margin-top: 10px;
}

.send-button {
  background-color: #c8a070;
  color: white;
  border: none;
  padding: 12px 35px;
  border-radius: 25px;
  font-size: 1.1em;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out, transform 0.1s ease;
}

.send-button:hover {
  background-color: #b89060;
}

.send-button:active {
  transform: scale(0.98);
}

@media (max-width: 768px) {
  .main-content {
    padding: 20px 15px;
    margin: 15px auto;
  }

  .form-card {
    padding: 20px;
  }

  .card-title {
    font-size: 1.25em;
  }

  .form-input,
  .form-textarea,
  .form-select {
    padding: 10px 12px;
  }

  .send-button {
    width: 100%;
    padding: 12px 20px;
  }

  .submit-button-container {
    justify-content: center;
  }
}
</style>
