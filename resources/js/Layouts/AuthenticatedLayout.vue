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
        class="dark:bg-[#2C2F40] bg-[#EAEFF2] h-screen overflow-hidden flex px-8 py-6 gap-4"
    >
        <div class="h-full w-1/6">
            <aside
                class="flex flex-col h-full dark:bg-[#3C4053] bg-[#DDE3E7] rounded-2xl py-4 ps-4"
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
                    <!-- <h1
                        class="ps-4 dark:text-[#B0B0B0] text-[#4B5660]dark:text-[#B0B0B0] text-[#4B5660] font-bold text-xs"
                    >
                        GENERAL
                    </h1> -->
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
        </div>
        <div class="h-full w-5/6 flex flex-col">
            <header
                class="h-1/11 w-full flex items-center justify-between px-4 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-2xl"
            >
                <div>
                    <div
                        class="flex dark:text-[#B0B0B0] text-[#4B5660] text-[12px] font-bold"
                    >
                        <h1 class="me-1">Pages /</h1>
                        <slot name="header" />
                    </div>
                    <div
                        class="dark:text-[#EEEEEE] text-[#222831] text-[18px] font-bold"
                    >
                        <slot name="header" />
                    </div>
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
            <main class="h-10/11 w-full">
                <slot />
            </main>
        </div>
    </div>
</template>
