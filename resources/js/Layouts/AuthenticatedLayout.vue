<script setup>
import { ref } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import ProfilePicture from "@/Components/ProfilePicture.vue";
import NavLink from "@/Components/NavLink.vue";
import Submenu from "@/Components/Submenu.vue";
import {
    Squares2X2Icon,
    ShieldCheckIcon,
    ClipboardIcon,
    CalendarIcon,
    MapIcon,
    MegaphoneIcon,
    VideoCameraIcon,
    MinusCircleIcon,
    BellIcon,
    MoonIcon,
} from "@heroicons/vue/24/solid";
</script>

<template>
    <div
        class="dark:bg-[#2C2F40] bg-[#EAEFF2] h-screen overflow-hidden flex flex-col px-8 py-6"
    >
        <div class="w-full h-full flex">
            <aside
                class="flex flex-col h-full dark:bg-[#3C4053] bg-[#DDE3E7] rounded-lg"
            >
                <div class="flex items-center ps-4 pt-2">
                    <ApplicationLogo
                        class="h-10 w-auto fill-current pt-2 me-2"
                    />
                    <h1
                        class="font-bold dark:text-[#EEEEEE] text-[#222831] text-[20px]"
                    >
                        SafeTrack
                    </h1>
                </div>

                <div class="flex-1 flex flex-col justify-center">
                    <h1
                        class="ps-4 dark:text-[#B0B0B0] text-[#4B5660]dark:text-[#B0B0B0] text-[#4B5660] font-bold text-xs"
                    >
                        GENERAL
                    </h1>
                    <NavLink
                        :href="route('dashboard')"
                        :active="route().current('dashboard')"
                        :icon="Squares2X2Icon"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        Dashboard
                    </NavLink>
                    <NavLink
                        :href="route('verification')"
                        :active="route().current('verification')"
                        :icon="ShieldCheckIcon"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        Verification
                    </NavLink>
                    <Submenu
                        title="Reports"
                        :icon="ClipboardIcon"
                        :subLinks="[
                            {
                                label: 'Incoming concern',
                            },
                            {
                                label: 'High priority',
                            },
                            {
                                label: 'Medium priority',
                            },
                            {
                                label: 'Low priority',
                            },
                        ]"
                    />
                    <NavLink
                        :href="route('dashboard')"
                        :icon="CalendarIcon"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        Calendar
                    </NavLink>
                    <NavLink
                        :href="route('dashboard')"
                        :icon="MapIcon"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        Map
                    </NavLink>
                    <NavLink
                        :href="route('dashboard')"
                        :icon="MegaphoneIcon"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        Announcements
                    </NavLink>
                    <NavLink
                        :href="route('dashboard')"
                        :icon="VideoCameraIcon"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        CCTV
                    </NavLink>
                </div>
                <NavLink
                    :href="route('logout')"
                    method="post"
                    :icon="MinusCircleIcon"
                >
                    Log Out
                </NavLink>
            </aside>
            <div class="flex flex-col h-full w-full ms-4">
                <header
                    class="flex justify-between items-center dark:bg-[#3C4053] bg-[#DDE3E7] rounded-lg p-4"
                >
                    <div
                        class="dark:text-[#EEEEEE] text-[#222831] font-bold text-[18px]"
                    >
                        <div
                            class="flex dark:text-[#B0B0B0] text-[#4B5660] text-[12px]"
                        >
                            <h1 class="me-1">Pages /</h1>
                            <slot name="header" />
                        </div>
                        <slot name="header" />
                    </div>
                    <div class="flex items-center">
                        <MoonIcon
                            class="h-6 w-6 text-[#3B5FBF] dark:text-[#6084FF] me-4"
                        />
                        <BellIcon
                            class="h-6 w-6 text-[#3B5FBF] dark:text-[#6084FF] me-4"
                        />
                        <ProfilePicture class="" />
                    </div>
                </header>
                <main class="h-full w-full">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>
