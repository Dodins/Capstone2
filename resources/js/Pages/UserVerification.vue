<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import VerificationRequestTable from "@/Components/Tables/VerificationRequestTable.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    residents: Array,
});
</script>

<template>
    <Head title="Verification" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="">User verification</h2>
        </template>
        <div class="flex flex-col w-full h-full">
            <div
                class="h-2/16 flex justify-between items-center dark:bg-[#3C4053] bg-[#DDE3E7] px-4 rounded-xl"
            >
                <div>
                    <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                        Verification Request
                    </h1>
                    <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                        Review pending user submissions for approval.
                    </h1>
                </div>
                <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </h1>
            </div>
            <div class="h-14/16 w-full pt-4">
                <VerificationRequestTable :residents="props.residents" />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
