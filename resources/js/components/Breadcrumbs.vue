<script setup lang="ts">
import { Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbPage, BreadcrumbSeparator } from '@/components/ui/breadcrumb';
import { Link } from '@inertiajs/vue3';

interface BreadcrumbItem {
    title: string;
    href?: string;
}

defineProps<{
    breadcrumbs: BreadcrumbItem[];
}>();
</script>

<template>
    <Breadcrumb>
        <BreadcrumbList>
            <template v-for="(item, index) in breadcrumbs" :key="index">
                <BreadcrumbItem>
                    <template v-if="index === breadcrumbs.length - 1">
                        <BreadcrumbPage class="breadcrumb-current">Dr.Home</BreadcrumbPage>
                    </template>
                    <template v-else>
                        <BreadcrumbLink as-child>
                            <Link :href="item.href ?? '#'" class="breadcrumb-link">{{ item.title }}</Link>
                        </BreadcrumbLink>
                    </template>
                </BreadcrumbItem>
                <BreadcrumbSeparator v-if="index !== breadcrumbs.length - 1" class="breadcrumb-separator" />
            </template>
        </BreadcrumbList>
    </Breadcrumb>
</template>

<style scoped>
/* Gaya untuk semua bagian breadcrumb */
:deep(.breadcrumb-current),
:deep(.breadcrumb-link),
:deep(.breadcrumb-separator) {
    font-family: 'Archivo', sans-serif;
    font-weight: 700;
    font-size: 24px;
    color: #AE7A42;
}

/* Gaya khusus untuk link */
:deep(.breadcrumb-link) {
    text-decoration: none;
    transition: opacity 0.2s;
}

:deep(.breadcrumb-link:hover) {
    opacity: 0.8;
}

/* Gaya untuk separator (/) */
:deep(.breadcrumb-separator) {
    margin: 0 8px;
}
</style>