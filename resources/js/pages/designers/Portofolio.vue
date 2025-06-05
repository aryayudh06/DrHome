<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

// Data form
const designFile = ref<File | null>(null);
const additionalNotes = ref('');
const fileInput = ref<HTMLInputElement | null>(null);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: 'designers/Detail_request',
    },
];

const handleFileUpload = (event: Event) => {
  const input = event.target;
  if (input instanceof HTMLInputElement && input.files && input.files[0]) {
    designFile.value = input.files[0];
  }
};

const submitPortofolio = () => {
  if (!designFile.value && !additionalNotes.value.trim()) {
    alert('Mohon unggah desain atau isi catatan tambahan.');
    return;
  }
  console.log({
    fileName: designFile.value?.name || 'No file selected',
    notes: additionalNotes.value,
  });
  alert('Portofolio Design submitted! (See console for data)');
};

const triggerFileSelect = () => {
  fileInput.value?.click();
};
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">

    <main class="main-content">
      <h2 class="page-title">Portofolio Design</h2>

      <form @submit.prevent="submitPortofolio" class="form">
        <div class="form-group">
          <label for="designFileUpload">Upload Design</label>
          <input
            type="file"
            id="designFileUpload"
            @change="handleFileUpload"
            accept="image/*,.pdf,.dwg,.skp,.zip,.rar"
            class="file-input"
          />
          <div class="file-upload-label" @click="triggerFileSelect">
            <span class="plus-icon">+</span>
            <span v-if="designFile" class="file-name">{{ designFile.name }}</span>
            <span v-else>Pilih file</span>
          </div>
        </div>

        <div class="form-group">
          <label for="additionalNotes">Catatan tambahan</label>
          <textarea
            id="additionalNotes"
            v-model="additionalNotes"
            placeholder="Deskripsi singkat, konsep, atau catatan lainnya..."
            rows="8"
            class="textarea"
          />
        </div>

        <div class="form-actions">
          <button type="submit" class="btn-primary">Send</button>
        </div>
      </form>
    </main>
  </AppLayout>
</template>

<style scoped>
.main-content {
  max-width: 700px;
  margin: 2rem auto;
  padding: 0 1rem;
}

.page-title {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  color: #333;
}

.form {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #555;
}

.file-input {
  display: none;
}

.file-upload-label {
  display: inline-flex;
  align-items: center;
  gap: 0.75rem;
  padding: 1rem 1.25rem;
  border: 1px solid #ccc;
  border-radius: 8px;
  background-color: #fafafa;
  cursor: pointer;
  user-select: none;
  max-width: 300px;
  font-size: 1rem;
  color: #666;
  transition: border-color 0.2s;
}
.file-upload-label:hover {
  border-color: #007bff;
  background-color: #e7f1ff;
}

.plus-icon {
  font-size: 1.5rem;
  color: #999;
  font-weight: 700;
}

.file-name {
  max-width: 200px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  color: #333;
}

.textarea {
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  font-size: 1rem;
  resize: vertical;
  font-family: inherit;
  color: #333;
  transition: border-color 0.2s;
}

.textarea:focus {
  outline: none;
  border-color: #007bff;
  box-shadow: 0 0 4px #007bff66;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
}

.btn-primary {
  background-color: #c8a070;
  color: white;
  border: none;
  padding: 0.75rem 2.5rem;
  border-radius: 25px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s ease-in-out;
}

.btn-primary:hover {
  background-color: #b89060;
}

.btn-primary:active {
  transform: scale(0.98);
}

@media (max-width: 768px) {
  .main-content {
    margin: 1rem auto;
  }
  .file-upload-label {
    max-width: 100%;
    justify-content: center;
  }
  .form-actions {
    justify-content: center;
  }
  .btn-primary {
    width: 100%;
  }
}
</style>
