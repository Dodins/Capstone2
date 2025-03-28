<script setup>
import { ref, watch, onMounted, onUnmounted } from "vue";
import axios from "axios";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import ProfilePicture from "@/Components/ProfilePicture.vue";
import SosAlertModal from "../Components/Modal/SosAlertModal.vue";
import NotificationDropdown from "@/Components/Notification/NotificationDropdown.vue"; // Import the new component
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

const showSosModal = ref(false);
const sosAlertData = ref(null);
const showNotifications = ref(false); // Add this for notification dropdown
const unreadNotifications = ref(0); // Track unread notifications

// Function to handle incoming SOS alerts
const handleSosAlert = (event) => {
    sosAlertData.value = event;
    showSosModal.value = true;
};

// Function to toggle notification dropdown
const toggleNotifications = () => {
    showNotifications.value = !showNotifications.value;
};

// Function to close notification dropdown
const closeNotifications = () => {
    showNotifications.value = false;
};

// Function to handle notifications being read
const handleNotificationsRead = () => {
    unreadNotifications.value = 0;
};

// Function to update unread notification count
const updateUnreadCount = async () => {
    try {
        const response = await axios.get("/notification");
        unreadNotifications.value = response.data.unreadCount;
    } catch (error) {
        console.error("Error fetching notification count:", error);
    }
};

// Setup Echo listener on component mount
onMounted(() => {
    window.Echo.channel("sos-alerts").listen(".sos.alerts", (event) => {
        handleSosAlert(event);
    });

    // Initial fetch of unread notification count
    updateUnreadCount();

    // Set up interval to periodically check for new notifications (every 30 seconds)
    const notificationInterval = setInterval(updateUnreadCount, 30000);

    // Clean up interval on unmount
    onUnmounted(() => {
        clearInterval(notificationInterval);
    });

    // Listen for new notification events if you have them
    window.Echo.private("App.Models.User." + userId).notification(
        (notification) => {
            // Increment the unread count when a new notification arrives
            unreadNotifications.value++;
        }
    );
});

// Clean up listener on component unmount
onUnmounted(() => {
    window.Echo.leave("sos-alerts");
});

// Method to close the modal
const closeSosModal = () => {
    showSosModal.value = false;
    sosAlertData.value = null;
};
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
                                active: route().current(
                                    'mediumPriorityReports'
                                ),
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
                    <!-- Updated Bell Icon with notification indicator -->
                    <div class="relative">
                        <button
                            @click="toggleNotifications"
                            class="notification-bell focus:outline-none"
                        >
                            <BellIcon
                                class="h-6 w-6 text-[#3B5FBF] dark:text-[#6084FF]"
                            />
                            <!-- Notification badge -->
                            <span
                                v-if="unreadNotifications > 0"
                                class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center"
                            >
                                {{
                                    unreadNotifications > 9
                                        ? "9+"
                                        : unreadNotifications
                                }}
                            </span>
                        </button>
                        <!-- Notification dropdown -->
                        <NotificationDropdown
                            :showNotifications="showNotifications"
                            @close="closeNotifications"
                            @notifications-read="handleNotificationsRead"
                        />
                    </div>
                    <ProfilePicture class="ml-4" />
                </div>
            </header>
            <main class="h-8/9 w-full">
                <slot />
            </main>
        </div>
    </div>
    <SosAlertModal
        v-if="showSosModal"
        :sosData="sosAlertData"
        @close="closeSosModal"
    />
</template>

<style scoped>
.notification-bell {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
</style>
