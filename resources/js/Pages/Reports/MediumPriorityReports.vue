<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import LowPriorityTabs from "../../Components/Reports/Tab/PriorityTabs.vue";

const props = defineProps({
    concerns: Array,
});
</script>

<template>
    <Head title="Low Priority Reports" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Medium Priority Reports</h2>
        </template>
        <div class="h-full w-full flex flex-col gap-4">
            <div
                class="h-2/16 flex justify-between items-center dark:bg-[#3C4053] bg-[#DDE3E7] px-4 rounded-xl"
            >
                <div>
                    <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                        Medium Priority Reports
                    </h1>
                    <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                        Review and manage Medium priority reports.
                    </h1>
                </div>
            </div>
            <div class="h-14/16 w-full">
                <LowPriorityTabs :concerns="props.concerns" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
