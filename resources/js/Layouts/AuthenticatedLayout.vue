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
import {
    Squares2X2Icon as Squares2X2IconOutline,
    ShieldCheckIcon as ShieldCheckIconOutline,
    ClipboardIcon as ClipboardIconOutline,
    CalendarIcon as CalendarIconOutline,
    MapIcon as MapIconOutline,
    MegaphoneIcon as MegaphoneIconOutline,
    VideoCameraIcon as VideoCameraIconOutline,
    MinusCircleIcon as MinusCircleIconOutline,
    BellIcon as BellIconOutline,
    MoonIcon as MoonIconOutline,
} from "@heroicons/vue/24/outline";
</script>

<template>
    <div
        class="dark:bg-[#2C2F40] bg-[#EAEFF2] h-screen overflow-hidden flex px-8 py-6 gap-4"
    >
        <div class="h-full w-1/7">
            <aside
                class="flex flex-col h-full dark:bg-[#3C4053] bg-[#DDE3E7] rounded-xl py-6 ps-4"
            >
                <div class="flex items-center">
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
                        :iconSolid="Squares2X2Icon"
                        :iconOutline="Squares2X2IconOutline"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        Dashboard
                    </NavLink>
                    <NavLink
                        :href="route('verification')"
                        :active="route().current('verification')"
                        :iconSolid="ShieldCheckIcon"
                        :iconOutline="ShieldCheckIconOutline"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        Verification
                    </NavLink>
                    <Submenu
                        title="Reports"
                        :iconSolid="ClipboardIcon"
                        :iconOutline="ClipboardIconOutline"
                        :subLinks="[
                            {
                                label: 'Incoming concern',
                                href: route('incomingReports'),
                                active: route().current('incomingReports'),
                            },
                            {
                                label: 'High priority',
                                href: route('highPriorityReports'),
                                active: route().current('highPriorityReports'),
                            },
                            {
                                label: 'Medium priority',
                                href: route('mediumPriorityReports'),
                                active: route().current('mediumPriorityReports'),
                            },
                            {
                                label: 'Low priority',
                                href: route('lowPriorityReports'),
                                active: route().current('lowPriorityReports'),
                            },
                        ]"
                    />
                    <NavLink
                        :href="route('calendar')"
                        :active="route().current().startsWith('calendar')"
                        :iconSolid="CalendarIcon"
                        :iconOutline="CalendarIconOutline"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        Calendar
                    </NavLink>
                    <NavLink
                        :href="route('map')"
                        :active="route().current('map')"
                        :iconSolid="MapIcon"
                        :iconOutline="MapIconOutline"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        Map
                    </NavLink>
                    <NavLink
                        :href="route('announcement')"
                        :active="route().current().startsWith('announcement')"
                        :iconSolid="MegaphoneIcon"
                        :iconOutline="MegaphoneIconOutline"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        Announcements
                    </NavLink>
                    <NavLink
                        :href="route('dashboard')"
                        :iconSolid="VideoCameraIcon"
                        :iconOutline="VideoCameraIconOutline"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        CCTV
                    </NavLink>
                </div>
                <NavLink
                    :href="route('logout')"
                    method="post"
                    :iconSolid="MinusCircleIcon"
                    :iconOutline="MinusCircleIconOutline"
                >
                    Log Out
                </NavLink>
            </aside>
        </div>
        <div class="h-full w-6/7 flex flex-col gap-4">
            <header
                class="h-1/9 w-full flex items-center justify-between px-4 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-xl"
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
            <main class="h-8/9 w-full">
                <slot />
            </main>
        </div>
    </div>
</template>
