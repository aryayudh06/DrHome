<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue'; 
import { type BreadcrumbItem } from '@/types';
import { ref } from 'vue';

// --- Common State and Props ---
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/designer/dashboard', // Sesuaikan route-nya
    },
];
const userName = ref('Ayu Nabila'); // Bisa dinamis dari props/store
const currentView = ref<'track' | 'inbox'>('track'); // Default view

// --- Track View Data & Logic ---
interface TrackApplication {
  id: number;
  name: string;
  avatarUrl: string;
  status: 'Diterima' | 'Revisi' | 'Ditolak';
}
const applicationsTrack = ref<TrackApplication[]>([
  { id: 1, name: 'Nabil Riskan', avatarUrl: 'https://via.placeholder.com/50/A0A0A0/FFFFFF?Text=NR', status: 'Diterima' },
  { id: 2, name: 'Diddy Krizznady', avatarUrl: 'https://via.placeholder.com/50/A8A8A8/FFFFFF?Text=DK', status: 'Revisi' },
  { id: 3, name: 'Hadi Kresnadi', avatarUrl: 'https://via.placeholder.com/50/B0B0B0/FFFFFF?Text=HK', status: 'Ditolak' },
]);
const getStatusClass = (status: TrackApplication['status']) => {
  if (status === 'Diterima') return 'status-diterima';
  if (status === 'Revisi') return 'status-revisi';
  if (status === 'Ditolak') return 'status-ditolak';
  return '';
};
const currentPageTrack = ref(1);
const openChatTrack = () => {
  console.log('Chat FAB clicked from Track section');
};

// --- Inbox View Data & Logic ---
interface InboxRequest {
  id: number;
  name: string;
  avatarUrl: string;
  projectLocation: string;
  landArea: string;
  landShape: string;
  landDimensions: string;
}
const newRequestsCountInbox = ref(2);
const requestsInbox = ref<InboxRequest[]>([
  { id: 1, name: 'Rom Doni', avatarUrl: 'https://via.placeholder.com/50/C0C0C0/FFFFFF?Text=RD', projectLocation: 'Mataram, Nusa Tenggara Barat', landArea: '400m²', landShape: 'Persegi', landDimensions: 'Persegi (20 x 20)' },
  { id: 2, name: 'Diddy Krizznady', avatarUrl: 'https://via.placeholder.com/50/C8C8C8/FFFFFF?Text=DK', projectLocation: 'Bandung, Jawa Barat', landArea: '400m²', landShape: 'Persegi', landDimensions: 'Persegi (20 x 20)' },
]);
const currentPageInbox = ref(1);
const openChatInbox = () => {
  console.log('Chat FAB clicked from Inbox section');
};

// --- View Switching ---
const showTrackView = () => {
    currentView.value = 'track';
};
const showInboxView = () => {
    currentView.value = 'inbox';
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 rounded-xl p-4 md:p-6 main-dashboard-container">
            
            <section class="welcome-and-controls bg-card-bg-light dark:bg-card-bg-dark p-4 sm:p-6 rounded-lg shadow">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <h1 class="text-2xl font-semibold text-text-primary dark:text-text-primary-dark">
                        Welcome, {{ userName }} !
                    </h1>
                    <div class="flex gap-3">
                        <button
                            @click="showTrackView"
                            :class="[
                                'px-5 py-2 rounded-full text-sm font-medium transition-colors dashboard-toggle-button',
                                currentView === 'track'
                                    ? 'bg-primary text-white'
                                    : 'bg-button-secondary-bg-light dark:bg-button-secondary-bg-dark text-button-secondary-text-light dark:text-button-secondary-text-dark hover:bg-primary-hover dark:hover:bg-primary-hover-dark',
                            ]"
                        >
                            Track
                        </button>
                        <button
                            @click="showInboxView"
                            :class="[
                                'px-5 py-2 rounded-full text-sm font-medium transition-colors dashboard-toggle-button',
                                currentView === 'inbox'
                                    ? 'bg-primary text-white'
                                    : 'bg-button-secondary-bg-light dark:bg-button-secondary-bg-dark text-button-secondary-text-light dark:text-button-secondary-text-dark hover:bg-primary-hover dark:hover:bg-primary-hover-dark',
                            ]"
                        >
                            Inbox
                        </button>
                    </div>
                </div>
            </section>

            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    v-for="i in 3"
                    :key="'placeholder-' + i"
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-card-bg-light dark:bg-card-bg-dark"
                >
                    <PlaceholderPattern />
                </div>
            </div>

            <div class="dynamic-content-wrapper relative flex-1 rounded-xl border border-sidebar-border/70 dark:border-sidebar-border p-1 md:p-0 bg-card-bg-light dark:bg-card-bg-dark min-h-[60vh]">
                <div v-if="currentView === 'track'" class="view-container p-4 md:p-6">
                    <div class="application-list">
                        <div v-for="app in applicationsTrack" :key="app.id" class="application-item">
                            <img :src="app.avatarUrl" :alt="app.name" class="avatar avatar-track" />
                            <div class="info">
                                <h3 class="name">{{ app.name }}</h3>
                                <p class="status">Status: <span :class="getStatusClass(app.status)">{{ app.status }}</span></p>
                            </div>
                            <button class="cek-button">Cek</button>
                        </div>
                    </div>
                    <nav class="pagination">
                        <button class="page-nav" :disabled="currentPageTrack === 1">&lt;</button>
                        <span class="current-page">{{ currentPageTrack }}</span>
                        <button class="page-nav" :disabled="true">&gt;</button>
                    </nav>
                    <button class="fab-chat" @click="openChatTrack">💬</button>
                </div>

                <div v-else-if="currentView === 'inbox'" class="view-container p-4 md:p-6">
                    <div class="inbox-header mb-6 p-4 rounded-lg bg-info-bg-light dark:bg-info-bg-dark shadow-sm">
                        <h2 class="text-xl font-semibold text-info-text-light dark:text-info-text-dark">
                            You have {{ newRequestsCountInbox }} new request !
                        </h2>
                    </div>
                    <div class="application-list">
                        <div v-for="req in requestsInbox" :key="req.id" class="application-item inbox-item">
                            <img :src="req.avatarUrl" :alt="req.name" class="avatar avatar-inbox" />
                            <div class="info">
                                <h3 class="name">{{ req.name }}</h3>
                                <p class="detail-text">Lokasi proyek: {{ req.projectLocation }}</p>
                                <p class="detail-text">Ukuran Tanah: {{ req.landArea }}</p>
                                <p class="detail-text">Bentuk Lahan: {{ req.landShape }}</p>
                                <p class="detail-text">Ukuran Tanah: {{ req.landDimensions }}</p>
                            </div>
                            <button class="cek-button">Cek</button>
                        </div>
                    </div>
                    <nav class="pagination">
                        <button class="page-nav" :disabled="currentPageInbox === 1">&lt;</button>
                        <span class="current-page">{{ currentPageInbox }}</span>
                        <button class="page-nav" :disabled="true">&gt;</button>
                    </nav>
                    <button class="fab-chat" @click="openChatInbox">💬</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<style scoped>
/* --- Container --- */
.main-dashboard-container {
    height: 100%;
}

/* Buttons Track/Inbox */
.dashboard-toggle-button {
    cursor: pointer;
}

/* Colors (default & dark) */
.bg-card-bg-light { background-color: #ffffff; }
.dark .bg-card-bg-dark { background-color: #2d3748; }
.text-text-primary { color: #1a202c; }
.dark .text-text-primary-dark { color: #e2e8f0; }

.bg-primary { background-color: #4299e1; }
.text-white { color: #fff; }
.bg-primary-hover { background-color: #2b6cb0; }
.dark .bg-primary-hover-dark { background-color: #2c5282; }

.bg-button-secondary-bg-light { background-color: #e2e8f0; }
.dark .bg-button-secondary-bg-dark { background-color: #4a5568; }
.text-button-secondary-text-light { color: #718096; }
.dark .text-button-secondary-text-dark { color: #a0aec0; }

.border-sidebar-border { border-color: #cbd5e0; }
.dark .border-sidebar-border { border-color: #4a5568; }

/* --- Track / Inbox List Items --- */
.application-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.application-item {
    display: flex;
    align-items: center;
    background-color: #edf2f7;
    border-radius: 10px;
    padding: 10px 15px;
    box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
    transition: background-color 0.3s ease;
}

.dark .application-item {
    background-color: #4a5568;
}

.application-item:hover {
    background-color: #e2e8f0;
}

.avatar {
    border-radius: 50%;
    object-fit: cover;
    margin-right: 15px;
}

.avatar-track {
    width: 50px;
    height: 50px;
}

.avatar-inbox {
    width: 50px;
    height: 50px;
}

.info {
    flex-grow: 1;
}

.name {
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.2rem;
    color: #2d3748;
}

.dark .name {
    color: #e2e8f0;
}

.status {
    font-weight: 500;
}

.status-diterima {
    color: #38a169; /* green */
    font-weight: 700;
}

.status-revisi {
    color: #dd6b20; /* orange */
    font-weight: 700;
}

.status-ditolak {
    color: #e53e3e; /* red */
    font-weight: 700;
}

.detail-text {
    font-size: 0.9rem;
    color: #4a5568;
    margin: 0 0 2px 0;
}

.dark .detail-text {
    color: #a0aec0;
}

.cek-button {
    background-color: #3182ce;
    color: white;
    border: none;
    padding: 0.4rem 1rem;
    border-radius: 8px;
    cursor: pointer;
    font-weight: 600;
    transition: background-color 0.3s ease;
}

.cek-button:hover {
    background-color: #2b6cb0;
}

/* Pagination */
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 1rem;
    gap: 1rem;
}

.page-nav {
    background-color: #e2e8f0;
    border: none;
    padding: 6px 12px;
    font-weight: 600;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.page-nav:disabled {
    cursor: default;
    opacity: 0.5;
}

.page-nav:hover:not(:disabled) {
    background-color: #3182ce;
    color: white;
}

.current-page {
    font-weight: 700;
    font-size: 1.1rem;
}

/* FAB Chat Button */
.fab-chat {
    position: fixed;
    bottom: 24px;
    right: 24px;
    background-color: #3182ce;
    color: white;
    border: none;
    border-radius: 50%;
    width: 56px;
    height: 56px;
    font-size: 24px;
    cursor: pointer;
    box-shadow: 0 6px 12px rgba(49, 130, 206, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    transition: background-color 0.3s ease;
}

.fab-chat:hover {
    background-color: #2b6cb0;
}

/* Inbox Header Info */
.inbox-header {
    border-radius: 10px;
}

.bg-info-bg-light {
    background-color: #bee3f8;
}

.dark .bg-info-bg-dark {
    background-color: #2c5282;
}

.text-info-text-light {
    color: #2c5282;
}

.dark .text-info-text-dark {
    color: #bee3f8;
}

/* Responsive tweaks */
@media (max-width: 640px) {
    .welcome-and-controls {
        flex-direction: column;
        gap: 1rem;
    }
    .dashboard-toggle-button {
        width: 100%;
    }
}
</style>
