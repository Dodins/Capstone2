<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import ProfilePicture from "@/Components/ProfilePicture.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import {
    Squares2X2Icon,
    ShieldCheckIcon,
    ClipboardIcon,
    CalendarIcon,
    MapIcon,
    MegaphoneIcon,
    VideoCameraIcon,
} from "@heroicons/vue/24/solid";
import { Link } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div
        class="dark:bg-[#2C2F40] bg-[#EAEFF2] h-screen w-screen px-4 py-6 flex"
    >
        <aside
            class="dark:bg-[#3C4053] bg-[#DDE3E7] rounded-[16px] me-2 flex flex-col"
        >
            <div class="flex items-center mt-6 ms-4">
                <ApplicationLogo
                    class="block h-10 w-auto fill-current pt-2 me-2"
                />
                <h1
                    class="font-bold dark:text-[#EEEEEE] text-[#222831] text-[20px]"
                >
                    SafeTrack
                </h1>
            </div>
            <div class="flex-1 flex flex-col justify-center">
                <div
                    class="font-bold text-sm pb-[12px] ms-4 dark:text-[#B0B0B0] text-[#4B5660]"
                >
                    <h1>GENERAL</h1>
                </div>
                <NavLink
                    :href="route('dashboard')"
                    :active="route().current('dashboard')"
                    :icon="Squares2X2Icon"
                >
                    Dashboard
                </NavLink>
                <NavLink
                    :href="route('verification')"
                    :active="route().current('verification')"
                    :icon="ShieldCheckIcon"
                >
                    Verification
                </NavLink>
                <NavLink :href="route('dashboard')" :icon="ClipboardIcon">
                    Reports
                </NavLink>
                <NavLink :href="route('dashboard')" :icon="CalendarIcon">
                    Calendar
                </NavLink>
                <NavLink :href="route('dashboard')" :icon="MapIcon">
                    Map
                </NavLink>
                <NavLink :href="route('dashboard')" :icon="MegaphoneIcon">
                    Announcements
                </NavLink>
                <NavLink :href="route('dashboard')" :icon="VideoCameraIcon">
                    CCTV
                </NavLink>
            </div>

            <ResponsiveNavLink
                :href="route('logout')"
                method="post"
                as="button"
            >
                Log Out
            </ResponsiveNavLink>
        </aside>

        <div class="w-full h-full flex flex-col ms-2">
            <header
                class="w-full flex justify-between items-center dark:bg-[#3C4053] bg-[#DDE3E7] rounded-[16px] p-4"
                v-if="$slots.header"
            >
                <div
                    class="dark:text-[#EEEEEE] text-[#222831] font-bold text-[24px]"
                >
                    <slot name="header" />
                </div>
                <ProfilePicture class="" />
            </header>
            <main class="h-full w-full mt-4">
                <slot/>
            </main>
        </div>
    </div>
</template>
