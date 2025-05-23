<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { Button } from '@/components/ui/button';
import { Avatar, AvatarImage, AvatarFallback } from '@/components/ui/avatar';
import Icon from '@/components/Icon.vue';
import { ref, computed, onMounted } from 'vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const props = defineProps<{
  designId: number
}>();

const design = ref<any>(null);
const loading = ref(true);
const error = ref<string | null>(null);

const recommendationsData = ref([
  { name: 'Ali Rohmadanu', role: 'Contractor', imageUrl: 'https://cdn.builder.io/api/v1/image/assets/TEMP/a985a5b23772e5cb50f72e965d8d1e9b463ff3c2?placeholderIfAbsent=true&apiKey=99ac6e2e518047159e4604b0a27afb34' },
  { name: 'Ali Rohmadanu', role: 'Contractor', imageUrl: 'https://cdn.builder.io/api/v1/image/assets/TEMP/a985a5b23772e5cb50f72e965d8d1e9b463ff3c2?placeholderIfAbsent=true&apiKey=99ac6e2e518047159e4604b0a27afb34' },
  { name: 'Ali Rohmadanu', role: 'Contractor', imageUrl: 'https://cdn.builder.io/api/v1/image/assets/TEMP/a985a5b23772e5cb50f72e965d8d1e9b463ff3c2?placeholderIfAbsent=true&apiKey=99ac6e2e518047159e4604b0a27afb34' },
  { name: 'Ali Rohmadanu', role: 'Contractor', imageUrl: 'https://cdn.builder.io/api/v1/image/assets/TEMP/a985a5b23772e5cb50f72e965d8d1e9b463ff3c2?placeholderIfAbsent=true&apiKey=99ac6e2e518047159e4604b0a27afb34' },
  { name: 'Ali Rohmadanu', role: 'Contractor', imageUrl: 'https://cdn.builder.io/api/v1/image/assets/TEMP/a985a5b23772e5cb50f72e965d8d1e9b463ff3c2?placeholderIfAbsent=true&apiKey=99ac6e2e518047159e4604b0a27afb34' },
]);

function designInitials(name: string) {
  return name.split(' ').map(n => n[0]).join('');
}

function handleImageError(event: Event) {
  const target = event.target as HTMLImageElement;
  target.src = '/images/default_Avatar.png';
}

onMounted(async () => {
  try {
    const response = await axios.get(`/api/designs/${props.designId}`);
    design.value = response.data;
    loading.value = false;
  } catch (err: any) { // Tambahkan tipe any atau AxiosError jika diimpor
    error.value = err.response?.data?.message || 'Failed to load design details';
    loading.value = false;
  }
});
</script>

<template>
  <AppLayout class="bg-[#F6F6F6]">
    <div class="min-h-screen flex flex-col bg-[#F6F6F6]">
      <div v-if="loading" class="flex items-center justify-center min-h-screen">
        <div class="text-[#714C25] text-xl">Loading...</div>
      </div>

      <div v-else-if="error" class="flex items-center justify-center min-h-screen">
        <div class="text-red-500 text-xl">{{ error }}</div>
      </div>

      <div v-else class="flex flex-1 gap-6 px-8 py-6 max-w-7xl w-full">
        <!-- Main Content -->
        <div class="flex-1 flex flex-col gap-6">
          <!-- Profile Card -->
          <Card class="py-0 rounded-[30px]">
            <div class="profile-header">
              <img
                :src="design.photo ? `data:image/jpeg;base64,${design.photo}` : '/images/default_Avatar.png'"
                alt="Design Cover"
                class="cover-image"
                @error="handleImageError"
              />
            </div>
            <div class="profile-content">
              <div class="profile-info mb-8 mt-20">
                <!-- <img
                  :src="design.photo ? `data:image/jpeg;base64,${design.photo}` : '/images/default_Avatar.png'"
                  alt="Design Photo"
                  class="profile-picture"
                  @error="handleImageError"
                /> -->
                <div class="info-details">
                  <h2 class="profile-name">{{ design.name }}</h2>
                  <!-- <div class="tags">
                    <span class="tag">{{ design.country }}</span>
                    <span class="tag">{{ design.specialty }}</span>
                  </div> -->
                  <div class="flex justify-between items-center">
                  <div class="tags">
                    <span class="tag">{{ design.country }}</span>
                    <span class="tag">{{ design.specialty }}</span>
                  </div>
                    <Link :href="route('designer.request', { id: design.id })" class="request-button">
                      Request
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </Card>

          <!-- About Card -->
          <!-- <Card class="bg-[#FAAE5C] text-white">
            <CardHeader>
              <CardTitle class="text-white">About</CardTitle>
            </CardHeader>
            <CardContent>
              <div class="mb-4">{{ design.description || '-' }}</div>
            </CardContent>
          </Card> -->
        </div>

        <!-- Sidebar -->
        <div class="w-80 flex flex-col gap-6">
          <Card>
            <CardHeader>
              <CardTitle class="text-[#714C25]">Rekomendasi Untukmu</CardTitle>
            </CardHeader>
            <CardContent>
              <div v-for="designer in recommendationsData" :key="designer.name" class="flex items-center gap-3 mb-4">
                <Avatar class="w-12 h-12">
                  <AvatarImage :src="designer.imageUrl" alt="Designer" />
                  <AvatarFallback>{{ designInitials(designer.name) }}</AvatarFallback>
                </Avatar>
                <div>
                  <div class="font-semibold" style="color: #714C25">{{ designer.name }}</div>
                  <div class="text-xs text-muted-foreground">{{ designer.role }}</div>
                </div>
              </div>
            </CardContent>
          </Card>
          <Button class="fixed bottom-8 right-8 shadow-lg rounded-full p-4" size="icon" variant="secondary">
            <Icon name="chat" />
          </Button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<style scoped>
.brand-title {
  color: #ae7a42;
  font-family: Archivo, -apple-system, Roboto, Helvetica, sans-serif;
  font-size: 51px;
  font-weight: 700;
  margin: 0;
}

.content-grid {
  display: flex;
  gap: 20px;
}

.left-column {
  width: 68%;
}

.right-column {
  width: 32%;
}

.profile-section {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 76px;
}

.profile-header {
  border-radius: 30px;
  position: relative;
  min-height: 358px;
  display: flex;
  align-items: flex-end;
  text-shadow: 4px 6px 5.8px rgba(0, 0, 0, 0.25);
}

.cover-image {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 30px;
}

.profile-name {
  position: relative;
  color: #ae7a42;
  font-family: Archivo, sans-serif;
  font-size: 51px;
  /* text-shadow: 2px 4px 10px rgba(0, 0, 0, 0.8); X offset, Y offset, blur radius, color */
  font-weight: 700;
  padding: 0;
  margin: 0;
}

.profile-content {
  margin-top: -125px;
  z-index: 1;
}

.profile-info {
  display: flex;
  gap: 20px;
  align-items: flex-start;
  padding: 0 20px;
}

.profile-picture {
  width: 35%;
  aspect-ratio: 1;
  border-radius: 50%;
  object-fit: contain;

  /* width: 100%; */
  max-width: 200px;
}

.info-details {
  flex: 1;
  margin-top: 0cm;
}

.tags {
  display: flex;
  gap: 13px;
}

.tag {
  color: #fff;
  background-color: #faae5c;
  border-radius: 10.679px;
  padding: 7px 20px;
  font-size: 12px;
}

.location {
  color: #714c25;
  font-size: 20px;
  margin-top: 24px;
  font-weight: 700;
}

.role {
  color: #714c25;
  font-size: 15px;
  margin-top: 5px;
  font-weight: 700;
}

.request-button {
  color: #fff;
  background-color: #ae7a42;
  border: none;
  border-radius: 32.213px;
  padding: 18px 39px;
  font-family: Archivo, sans-serif;
  font-size: 20px;
  font-weight: 800;
  margin-top: auto;
  cursor: pointer;
}

.about-section {
  background-color: #faae5c;
  border-radius: 30px;
  padding: 37px 64px 69px;
  box-shadow: 0px 4px 27.7px 0px rgba(0, 0, 0, 0.25);
}

.about-title {
  color: #fff;
  font-size: 36px;
  font-weight: 700;
  margin: 0 0 25px;
}

.about-text {
  color: #fff;
  font-size: 24px;
  margin: 0;
}

.section-block {
  margin-top: 30px;
}

.section-block h4 {
  color: #fff;
  font-size: 24px;
  margin-bottom: 15px;
}

.education-item,
.experience-item {
  margin-bottom: 20px;
}

.education-item h5,
.experience-item h5 {
  color: #fff;
  font-size: 18px;
  margin-bottom: 5px;
}

.education-item p,
.experience-item p {
  color: #fff;
  font-size: 16px;
}

.recommendations-sidebar {
  border-radius: 30px;
  box-shadow: -1px 6px 20.4px 0px rgba(0, 0, 0, 0.25);
  padding: 35px 80px 35px 37px;
  background-color: #fff;
  width: 100%;
}

.recommendations-title {
  font-size: 24px;
  font-weight: 800;
  font-family: Archivo, sans-serif;
  margin: 0 0 23px;
}

.recommendation-card {
  display: flex;
  align-items: center;
  gap: 10px;
  margin-top: 31px;
}

.recommendation-card:first-child {
  margin-top: 0;
}

.user-avatar {
  width: 77px;
  height: 77px;
  border-radius: 50%;
  object-fit: contain;
}

.user-info {
  flex: 1;
}

.user-name {
  font-size: 20px;
  font-weight: 700;
  margin: 0;
}

.user-role {
  font-size: 11px;
  font-weight: 500;
  margin: 14px 0 0;
}

.portfolio-section {
  width: 100%;
  padding: 60px 20px;
  margin-top: 30px;
  margin-bottom: 30px;
  background-color: #f9f9f9;
}

.portfolio-content {
  max-width: 1334px;
  margin: 0 auto;
}

.portfolio-title {
  color: #AE7A42;
  font-family: Archivo, sans-serif;
  font-size: 36px;
  font-weight: 700;
  margin-bottom: 40px;
  text-align: center;
}

.portfolio-container {
  width: 100%;
  overflow: hidden;
}

.portfolio-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 30px;
  justify-items: center;
}

.portfolio-card {
  width: 100%;
  max-width: 400px;
  border-radius: 15px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.portfolio-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.portfolio-image-container {
  position: relative;
  width: 100%;
  padding-top: 75%;
  /* 4:3 aspect ratio */
  overflow: hidden;
}

.portfolio-image {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.portfolio-card:hover .portfolio-image {
  transform: scale(1.05);
}

.portfolio-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
  color: white;
  padding: 20px;
  opacity: 0;
  transition: opacity 0.3s ease;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
}

.portfolio-card:hover .portfolio-overlay {
  opacity: 1;
}

.portfolio-info {
  transform: translateY(20px);
  transition: transform 0.3s ease;
}

.portfolio-card:hover .portfolio-info {
  transform: translateY(0);
}

.portfolio-item-title {
  font-size: 1.5rem;
  margin-bottom: 10px;
  color: white;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.5);
}

.portfolio-meta {
  display: flex;
  gap: 10px;
  margin-bottom: 8px;
}

.portfolio-location,
.portfolio-style {
  font-size: 0.9rem;
  background-color: rgba(174, 122, 66, 0.8);
  padding: 4px 10px;
  border-radius: 20px;
}

.portfolio-year {
  font-size: 0.9rem;
  margin-bottom: 10px;
  color: #FAE5CC;
}

.portfolio-description {
  font-size: 0.95rem;
  line-height: 1.4;
  margin-top: 8px;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.empty-portfolio {
  text-align: center;
  padding: 40px;
  color: #AE7A42;
  font-size: 1.2rem;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
  .portfolio-grid {
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  }
}

@media (max-width: 768px) {
  .portfolio-section {
    padding: 40px 15px;
  }

  .portfolio-title {
    font-size: 28px;
    margin-bottom: 30px;
  }

  .portfolio-grid {
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
  }

  .portfolio-item-title {
    font-size: 1.3rem;
  }
}

@media (max-width: 480px) {
  .portfolio-grid {
    grid-template-columns: 1fr;
  }

  .portfolio-card {
    max-width: 100%;
  }

  .portfolio-overlay {
    padding: 15px;
  }

  .portfolio-item-title {
    font-size: 1.2rem;
  }

  .portfolio-description {
    -webkit-line-clamp: 2;
  }
}

.decoration-image {
  position: absolute;
  right: 0;
  bottom: -290px;
  width: 110px;
  aspect-ratio: 1.45;
  object-fit: contain;
}

.brand-section {
  flex: 1;
  font-family: Archivo, sans-serif;
  color: #090909;
  font-weight: 700;
}

.brand-tagline {
  font-size: 40px;
  margin: 20px 0 0;
}

.contact-section {
  flex: 1;
  margin-top: 9px;
  font-family: Archivo, sans-serif;
  font-size: 24px;
  color: #090909;
}

.contact-title {
  font-weight: 700;
  margin: 0;
}

.contact-email {
  display: block;
  color: #090909;
  font-style: italic;
  font-weight: 500;
  margin-top: 24px;
  text-decoration: none;
}

.contact-phone {
  font-weight: 500;
  margin: 14px 0 0;
}

.contact-address {
  margin: 20px 0 0;
  font-style: normal;
}

.news-section {
  flex: 1;
}

.news-title {
  color: #090909;
  font-family: Archivo, sans-serif;
  font-size: 24px;
  font-weight: 700;
  margin: 0;
}

.news-images {
  display: flex;
  margin-top: 41px;
  gap: 20px;
  justify-content: space-between;
}

.news-image {
  width: 68px;
  aspect-ratio: 1;
  object-fit: contain;
}

.loading-state,
.error-state {
  text-align: center;
  padding: 2rem;
  font-size: 1.2rem;
  color: #AE7A42;
}

@media (max-width: 991px) {

  .brand-title {
    font-size: 40px;
  }

  .main-content {
    margin-top: 40px;
  }

  .content-grid {
    flex-direction: column;
  }

  .left-column,
  .right-column {
    width: 100%;
  }

  .profile-name {
    font-size: 40px;
    padding: 0px;
  }

  .profile-info {
    flex-direction: column;
  }

  .info-details {
    margin-top: 40px;
  }

  .request-button {
    margin-top: 40px;
    width: 100%;
  }

  .about-section {
    padding: 20px;
  }

  .recommendations-sidebar {
    padding: 20px;
    margin-top: 40px;
  }

  .portfolio-content {
    padding: 20px;
  }

  .portfolio-grid {
    flex-direction: column;
  }

  .portfolio-card {
    width: 100%;
    margin-top: 31px;
  }

  .portfolio-card:first-child {
    margin-top: 0;
  }


  .contact-section,
  .news-section {
    margin-top: 40px;
  }

  .news-images {
    margin-top: 40px;
    flex-wrap: wrap;
    justify-content: center;
  }
}
</style>
