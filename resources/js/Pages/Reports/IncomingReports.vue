<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import IncomingReports from "../../Components/Reports/Tab/IncomingReports.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    incomingConcerns: Array,
});
</script>

<template>
    <Head title="Reports" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Reports</h2>
        </template>
        <div class="h-full w-full flex flex-col gap-4">
            <div
                class="h-2/16 flex justify-between items-center dark:bg-[#3C4053] bg-[#DDE3E7] px-4 rounded-xl"
            >
                <div>
                    <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                        Incoming concerns
                    </h1>
                    <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                        Review incoming concerns for approval.
                    </h1>
                </div>
            </div>
            <div class="h-14/16 w-full">
                <IncomingReports :incomingConcerns="props.incomingConcerns" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
