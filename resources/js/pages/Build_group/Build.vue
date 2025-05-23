<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
// import { ref } from 'vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Build',
    href: '/build',
  },
];

//Placeholder (delete if all is set)
const designers = ref([
  {
    id: "1",
    name: "Ayu Nabila",
    country: "Indonesia",
    origin_city: "Malang",
    specialty: "UI Designer",
    photo_url: "https://imagedelivery.net/LBWXYQ-XnKSYxbZ-NuYGqQ/dacfb96d-c3fe-42d4-912d-083418f0f300/avatarhd",
    description: "Desainer antarmuka berpengalaman dengan fokus pada aksesibilitas dan desain mobile."
  }
]);

//if use api https://script.googleusercontent.com/a/macros/student.ub.ac.id/echo?user_content_key=AehSKLhFqtyCuqkN3PX8ZDVq9VNrNYyp0XkillEmOPjcMSFbuXzUk8ZJ2o-ho2JlHrtcN_tmez9g4MIza-T2whTMiwvsPLLlPie1EdhajQ1k7vDQv-2-P7X2UBx3GezUeSmshFcKkOs1FBGHf3jVKgDP4KQDtyZzrAZP_HMDSxV5fVhXYp4Dzjbmb7mmFjF5c2zCJT9YAX23WKSbJEkstK4gitlYbY6hnAdovn_WNmwJp8ElDV80hARiCR_EA-jeGHej6tGPMdPKfwe8ZYWmU8lX_pWE3BEA6PZdC6ESYyXkQQ-gOhiSXxdLetOjpUD_IA&lib=MY3sxZ67jnVyCQPWapYVsx-JYzTukwziq');

onMounted(async () => {
  try {
    const response = await axios.get('https://script.googleusercontent.com/a/macros/student.ub.ac.id/echo?user_content_key=AehSKLhFqtyCuqkN3PX8ZDVq9VNrNYyp0XkillEmOPjcMSFbuXzUk8ZJ2o-ho2JlHrtcN_tmez9g4MIza-T2whTMiwvsPLLlPie1EdhajQ1k7vDQv-2-P7X2UBx3GezUeSmshFcKkOs1FBGHf3jVKgDP4KQDtyZzrAZP_HMDSxV5fVhXYp4Dzjbmb7mmFjF5c2zCJT9YAX23WKSbJEkstK4gitlYbY6hnAdovn_WNmwJp8ElDV80hARiCR_EA-jeGHej6tGPMdPKfwe8ZYWmU8lX_pWE3BEA6PZdC6ESYyXkQQ-gOhiSXxdLetOjpUD_IA&lib=MY3sxZ67jnVyCQPWapYVsx-JYzTukwziq');
    console.log('API response:', response.data);
    designers.value = response.data.data.map(d => ({
      ...d,
      photo_url: `data:${d.photo_type};base64,${d.photo}`
    }));
  } catch (error) {
    console.error('Error:', error);
    designers.value = []; // Fallback
  }
});

designers.value = designers.value.map(d => {
  // Jika photo_type dan photo ada
  if (d.photo_type && d.photo) {
    return {
      ...d,
      photo_url: `data:${d.photo_type};base64,${d.photo}`
    };
  }
  return d;
});


function handleImageError(event: Event) {
  const target = event.target as HTMLImageElement;
  target.src = '/images/default_Avatar.png'; //fallback image
}

</script>

<template>

  <Head title="Build" />

  <AppLayout :breadcrumbs="breadcrumbs" class="bg-[#F6F6F6]">
    <div class="video-container">
      <!-- Video dengan fallback native HTML -->
      <video autoplay loop muted playsinline class="rounded-video" poster="/images/build.jpg">
        <source src="/videos/build.mp4" type="video/mp4">
        <img src="/images/build.jpg" alt="Background" class="fallback-img">
      </video>
    </div>

    <!-- Search Bar -->
    <div class="search-container">
      <div class="search-bar">
        <button class="filter-button">
          <img src="/images/filter.svg" alt="Filter" class="icon-30" />
        </button>
        <input type="text" placeholder="Search your favourite designer..." class="search-input">
        <button class="search-button">
          <img src="/images/search.svg" alt="Search" class="icon-30" />
        </button>
      </div>
    </div>

    <!-- Designers Grid Section -->
    <div class="designers-container">
      <h2 class="section-title">Designers</h2>

      <div v-if="designers.length === 0" class="empty-state">
        <p>Tidak ada desainer yang ditampilkan</p>
      </div>

      <div v-else class="designers-grid">
        <Link v-for="designer in designers" :key="designer.id" :href="route('designerdetail', { id: designer.id })"
          class="designer-card">
        <img :src="designer.photo_url" :alt="designer.name" class="designer-photo" @error="handleImageError">
        <div class="designer-info">
          <h3>{{ designer.name }}</h3>
          <p class="country">{{ designer.country }}</p>
          <p class="specialty">{{ designer.specialty }}</p>
        </div>
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.video-container {
  display: grid;
  place-items: center;
  padding: 2rem;
}

.rounded-video,
.fallback-img {
  width: 100%;
  max-width: 1000px;
  border-radius: 20px;
  aspect-ratio: 2.35/1;
  object-fit: cover;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
}

.icon-30 {
  width: 30px;
  height: 30px;
  display: block;
}

/* Search Bar Styles */
.search-container {
  display: grid;
  place-items: center;
  padding: 0 2rem 2rem;
  width: 100%;
}

.search-bar {
  display: flex;
  align-items: center;
  background: white;
  border-radius: 20px;
  height: 50px;
  padding: 0.5rem 1rem;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 1000px;
}

.search-input {
  flex: 1;
  border: none;
  outline: none;
  padding: 0.8rem 1rem;
  font-size: 1rem;
  color: #484848;
  background: transparent;
}

.filter-button,
.search-button {
  background: transparent;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  padding: 0.5rem;
}

.filter-button {
  margin-right: 0.5rem;
}

.search-button {
  margin-left: 0.5rem;
}

/* Hover Effects */
.filter-button:hover svg,
.search-button:hover svg {
  stroke: #4F46E5;
}

/* Responsive Design */
@media (max-width: 768px) {

  .video-container,
  .search-container {
    padding: 1rem;
  }

  .rounded-video,
  .search-bar {
    border-radius: 12px;
  }
}

/* Designers Grid Styles */
.designers-container {
  width: 100%;
  max-width: 1100px;
  margin: 0 auto;
  padding: 0 2rem 3rem;
}

.section-title {
  text-align: center;
  margin-bottom: 2rem;
  font-family: 'Archivo', sans-serif;
  font-weight: 500;
  font-size: 24px;
  color: #AE7A42;
  font-size: 1.8rem;
}

.designers-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1.5rem;
}

.designer-card {
  background: white;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.designer-card:hover {
  transform: translateY(-5px);
}

.designer-photo {
  width: 100%;
  height: 260px;
  object-fit: cover;
  border-top-left-radius: 20px;
  border-top-right-radius: 20px;
}

.designer-info {
  padding: 0.7rem;
  text-align: center;
}

.designer-info h3 {
  margin: 0 0 0.5rem;
  font-size: 1.1rem;
  color: #333;
}

.specialty {
  color: #666;
  font-size: 0.9rem;
  margin-bottom: 0.8rem;
}

.country {
  color: #888;
  font-size: 0.85rem;
  margin-bottom: 0.5rem;
}

.empty-state {
  text-align: center;
  padding: 2rem;
  font-weight: 300;
  font-size: 15px;
  color: #AE7A42;
}
</style>
