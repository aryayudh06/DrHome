<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: 'designers/Detail_request',
    },
];

//contoh data
const requestDetails = ref({
  requesterAvatar: 'https://example.com/avatar.jpg',
  requesterName: 'John Doe',
  summary: {
    province: 'Jakarta',
    landSize: '500 m²',
    buildingArea: '350 m²',
    landDimensions: '20m x 25m',
    buildingStyle: 'Modern'
  },
  generalInfo: {
    previewPicture: 'https://example.com/preview.jpg',
    budget: 'Rp 1.000.000.000'
  },
  architecturalStyle: {
    propertyType: 'Residential',
    style: 'Contemporary',
    references: 'https://example.com/reference.jpg'
  },
  roomLayout: {
    facilities: ['Living Room', 'Kitchen', '3 Bedrooms', '2 Bathrooms']
  },
  ambient: {
    sunOrientation: 'East-West',
    windOrientation: 'North-South',
    moreInformation: ['Good ventilation', 'Natural light']
  },
  timeline: {
    deadline: '2025-12-31'
  }
})
</script>

<template>
  <Head title="Dashboard" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="main-content-area">
      <section class="requester-info">
        <img :src="requestDetails.requesterAvatar" alt="Requester Avatar" class="requester-avatar" />
        <h1 class="requester-name">{{ requestDetails.requesterName }}</h1>
      </section>

      <div class="info-card">
        <h2 class="card-title">Summary</h2>
        <div class="info-grid">
          <div class="info-item"><span class="info-label">Province</span><span class="info-value">{{ requestDetails.summary.province }}</span></div>
          <div class="info-item"><span class="info-label">Ukuran Tanah</span><span class="info-value">{{ requestDetails.summary.landSize }}</span></div>
          <div class="info-item"><span class="info-label">Bangunan</span><span class="info-value">{{ requestDetails.summary.buildingArea }}</span></div>
          <div class="info-item"><span class="info-label">Ukuran Tanah</span><span class="info-value">{{ requestDetails.summary.landDimensions }}</span></div>
          <div class="info-item"><span class="info-label">Style Bangunan</span><span class="info-value">{{ requestDetails.summary.buildingStyle }}</span></div>
        </div>
      </div>

      <div class="info-card">
        <h2 class="card-title">General Information</h2>
        <div class="info-item">
          <span class="info-label">Preview Picture</span>
          <img :src="requestDetails.generalInfo.previewPicture" alt="Preview" class="info-image" />
        </div>
        <div class="info-item"><span class="info-label">Budget</span><span class="info-value">{{ requestDetails.generalInfo.budget }}</span></div>
      </div>

      <div class="info-card">
        <h2 class="card-title">Architectural Style</h2>
        <div class="info-item"><span class="info-label">Property Type</span><span class="info-value">{{ requestDetails.architecturalStyle.propertyType }}</span></div>
        <div class="info-item"><span class="info-label">Style</span><span class="info-value">{{ requestDetails.architecturalStyle.style }}</span></div>
        <div class="info-item">
          <span class="info-label">References</span>
          <img :src="requestDetails.architecturalStyle.references" alt="Reference" class="info-image" />
        </div>
      </div>

      <div class="info-card">
        <h2 class="card-title">Room Layout</h2>
        <ul class="facilities-list">
          <li v-for="(facility, index) in requestDetails.roomLayout.facilities" :key="index">{{ facility }}</li>
        </ul>
      </div>

      <div class="info-card">
        <h2 class="card-title">Ambient</h2>
        <div class="info-item"><span class="info-label">Sun Orientation</span><span class="info-value">{{ requestDetails.ambient.sunOrientation }}</span></div>
        <div class="info-item"><span class="info-label">Wind Orientation</span><span class="info-value">{{ requestDetails.ambient.windOrientation }}</span></div>
        <ul class="more-info-list">
          <li v-for="(info, index) in requestDetails.ambient.moreInformation" :key="index">{{ info }}</li>
        </ul>
      </div>

      <div class="info-card">
        <h2 class="card-title">Timeline</h2>
        <div class="info-item"><span class="info-label">Deadline</span><span class="info-value">{{ requestDetails.timeline.deadline }}</span></div>
      </div>
    </div>
  </AppLayout>
</template>


<style scoped>
.main-content-area {
  padding: 20px;
  max-width: 900px;
  margin: 0 auto;
}
.requester-info {
  display: flex;
  align-items: center;
  background: #f8f9fa;
  border-radius: 8px;
  padding: 10px;
  margin-bottom: 30px;
}
.requester-avatar {
  width: 100px;
  height: 100px;
  object-fit: cover;
  border-radius: 8px;
  margin-right: 20px;
}
.requester-name {
  font-size: 2em;
  font-weight: bold;
}
.info-card {
  background: #fff;
  border: 1px solid #eee;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 20px;
}
.card-title {
  font-size: 1.2em;
  font-weight: bold;
  margin-bottom: 15px;
}
.info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 10px;
}
.info-item {
  margin-bottom: 10px;
}
.info-label {
  font-weight: 600;
  color: #555;
}
.info-value {
  color: #333;
}
.info-image {
  max-width: 100%;
  border-radius: 4px;
  margin-top: 5px;
}
.facilities-list,
.more-info-list {
  list-style: disc;
  padding-left: 20px;
  margin: 0;
}
</style>
