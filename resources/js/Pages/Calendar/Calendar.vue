<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import CalendarView from "@/Components/CalendarView.vue";
import { Head, router } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import DeleteConfirmation from "@/Components/Modal/DeleteConfirmation.vue";

const eventId = ref(null);

const props = defineProps({
    events: Array,
});

const currentDate = computed(() => {
    const date = new Date();
    return date.toLocaleDateString("en-US", {
        month: "long",
        day: "numeric",
        year: "numeric",
    });
});

const selectedDate = ref(new Date().toISOString().split("T")[0]);

const filteredEvents = computed(() => {
    if (!selectedDate.value) return props.events;
    return props.events.filter((event) => event.date === selectedDate.value);
});

const getEventTimeRange = (schedules) => {
    if (!schedules || schedules.length === 0) return "";

    const startTimes = schedules.map((s) => s.start_time);
    const endTimes = schedules.map((s) => s.end_time);

    const earliestStart = startTimes.sort()[0];
    const latestEnd = endTimes.sort().reverse()[0];

    return `${formatTime(earliestStart)} - ${formatTime(latestEnd)}`;
};

const formatTime = (time) => {
    if (!time) return "";

    const [hours, minutes] = time.split(":");
    const date = new Date();
    date.setHours(hours, minutes);

    return date.toLocaleTimeString("en-US", {
        hour: "numeric",
        minute: "2-digit",
        hour12: true,
    });
};

const getContrastColor = (hex) => {
    if (!hex) return "#222831";

    let r = parseInt(hex.slice(1, 3), 16);
    let g = parseInt(hex.slice(3, 5), 16);
    let b = parseInt(hex.slice(5, 7), 16);

    let luminance = (0.299 * r + 0.587 * g + 0.114 * b) / 255;

    return luminance > 0.6 ? "#222831" : "#EEEEEE";
};

const showDeleteConfirmation = ref(false);
const openDeleteModal = (id) => {
    eventId.value = id;
    console.log(id);
    showDeleteConfirmation.value = true;
};
const closeDeleteModal = () => {
    showDeleteConfirmation.value = false;
};

const navigateToEditEvent = (id) => {
    router.visit(route("calendar.edit", { id }));
};
</script>

<template>
    <Head title="Calendar" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Calendar</h2>
        </template>
        <div class="flex gap-4 h-full w-full">
            <div
                class="h-full w-5/7 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-xl p-4"
            >
                <CalendarView
                    @dateSelected="(date) => (selectedDate = date)"
                    :events="props.events"
                />
            </div>
            <div
                class="h-full w-2/7 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-xl p-4"
            >
                <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                    Today's Event
                </h1>
                <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                    {{ currentDate }}
                </h1>
                <div
                    v-if="filteredEvents.length > 0"
                    v-for="event in filteredEvents"
                    :key="event.id"
                    :style="{
                        backgroundColor: event.color,
                        color: getContrastColor(event.color),
                    }"
                    class="p-2 mt-4 rounded-lg text-white"
                >
                    <div class="flex justify-between items-center">
                        <h1 class="text-[18px]">
                            <strong>{{ event.title }}</strong>
                        </h1>
                        <div class="flex items-center gap-2">
                            <i
                                class="fa-solid fa-pen"
                                @click="navigateToEditEvent(event.id)"
                            ></i>
                            <i
                                class="fa-solid fa-trash"
                                @click="openDeleteModal(event.id)"
                            ></i>
                        </div>
                    </div>
                    <h1 v-if="event.schedules.length" class="text-[14px]">
                        {{ getEventTimeRange(event.schedules) }}
                    </h1>
                    <p class="text-[14px]">
                        {{ event.description }}
                    </p>
                    <p class="mt-4 text-[14px] font-bold">
                        Schedule of activites:
                    </p>
                    <ul>
                        <li
                            v-for="schedule in event.schedules"
                            :key="schedule.id"
                            class="text-[14px] mt-2"
                        >
                            {{ formatTime(schedule.start_time) }} -
                            {{ formatTime(schedule.end_time) }}:
                            {{ schedule.description }}
                        </li>
                    </ul>
                </div>
                <div v-else class="h-full flex items-center justify-center">
                    <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                        No events for this day.
                    </h1>
                </div>
            </div>
        </div>
        <DeleteConfirmation
            :id="eventId"
            :title="'Delete Event!'"
            :message="'Are you sure you want to delete this event?'"
            :show="showDeleteConfirmation"
            :type="'event'"
            @close="closeDeleteModal"
        />
    </AuthenticatedLayout>
</template>
