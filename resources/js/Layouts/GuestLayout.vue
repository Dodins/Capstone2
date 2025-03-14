<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center justify-center dark:bg-[#2C2F40] bg-[#EAEFF2]"
    >
        <div>
            <Link href="/">
                <ApplicationLogo class="h-24 w-24 fill-current" />
            </Link>
        </div>

        <h1
            class="font-bold text-[40px] dark:text-[#EEEEEE] text-[#222831]"
        >
            SafeTrack
        </h1>

        <h1 class="mb-6 text-[12px] dark:text-[#B0B0B0] text-[#4B5660]">YOUR SAFETY, OUR PRIORITY</h1>

        <div class="w-1/4">
            <slot />
        </div>
    </div>
</template>
