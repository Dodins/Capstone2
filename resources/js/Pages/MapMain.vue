<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Map from "@/Components/Map.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    crimeLocation: Array,
});

</script>

<template>
    <Head title="Map" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Map</h2>
        </template>
        <div class="h-full w-full">
            <div class="dark:bg-[#3C4053] bg-[#DDE3E7] h-full w-full rounded-2xl overflow-hidden">
                <Map :crimeLocation="props.crimeLocation"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
