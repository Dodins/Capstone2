<script setup>
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { Head, Link } from "@inertiajs/vue3";
</script>

<template>
    <Head title="Welcome" />
    <div class="h-screen w-screen dark:bg-[#2C2F40] bg-[#EAEFF2]">
        <nav
            class="dark:bg-[#3C4053] bg-[#DDE3E7] flex justify-between py-3 px-32"
        >
            <div class="flex items-center">
                <Link href="/">
                    <ApplicationLogo class="w-8 h-10 pt-2" />
                </Link>
                <h1
                    class="font-bold dark:text-[#EEEEEE] text-[#222831] ms-4 text-[20px]"
                >
                    SafeTrack
                </h1>
            </div>
            <div>
                <Link :href="route('register')"
                    ><SecondaryButton>Register</SecondaryButton></Link
                >
                <Link :href="route('login')"
                    ><PrimaryButton class="ms-4"> Login </PrimaryButton></Link
                >
            </div>
        </nav>
    </div>
</template>
