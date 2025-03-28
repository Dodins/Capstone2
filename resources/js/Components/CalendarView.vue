<script setup>
import { computed } from "vue";
import { router } from "@inertiajs/vue3";
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from "@fullcalendar/daygrid";
import interactionPlugin from "@fullcalendar/interaction";

const props = defineProps({
    events: Array,
});

const emit = defineEmits(["dateSelected"]);

const onDateClick = (info) => {
    emit("dateSelected", info.dateStr);
};

const calendarOptions = computed(() => ({
    plugins: [dayGridPlugin, interactionPlugin],
    initialView: "dayGridMonth",
    headerToolbar: {
        start: "title",
        center: "",
        end: "addEventButton prev next",
    },
    customButtons: {
        addEventButton: {
            text: "Add event",
            click: () => {
                router.visit(route("calendar.create"));
            },
        },
    },
    events: props.events.map((event) => ({
        title: event.title,
        start: event.date,
        backgroundColor: event.color,
        borderColor: event.color,
    })),
    contentHeight: "100%",
    dateClick: onDateClick,
    selectable: true,
}));
</script>

<template>
    <FullCalendar
        @dateClick="onDateClick"
        :options="calendarOptions"
        class="h-full w-full"
    />
</template>

<style scoped>
:deep(.fc-toolbar > div) {
    display: flex !important;
    align-items: center;
}

:deep(.fc-scrollgrid) {
    background: transparent !important;
    border: 1px solid #a0a5aa !important;
}
:deep(.fc-col-header-cell) {
    border: 1px solid #a0a5aa !important;
    color: #222831 !important;
}

:deep(.fc-toolbar-title) {
    color: #222831 !important;
    font-weight: bold;
    font-size: 18px;
    margin-right: 4px;
}

:deep(.fc-addEventButton-button) {
    background: #3b5fbf !important;
    color: #eeeeee;
    font-weight: bold;
    font-size: 12px !important;
    border: none !important;
    padding: 8px 24px !important;
    border-radius: 6px !important;
    transition: all 0.2s ease-in-out;
}

:deep(.fc-prev-button),
:deep(.fc-next-button) {
    background: #3b5fbf !important;
    color: #eeeeee;
    font-weight: bold;
    font-size: 12px !important;
    border: none !important;
    padding: 8px 10px !important;
    border-radius: 6px !important;
    transition: all 0.2s ease-in-out;
}

:deep(.fc-addEventButton-button:hover),
:deep(.fc-prev-button:hover),
:deep(.fc-next-button:hover) {
    background: #2f4c99 !important;
    color: #eeeeee !important;
}

:deep(.fc-daygrid-day) {
    border: 1px solid #a0a5aa !important;
}

:deep(.fc-daygrid-body) {
    background: #eaeff2;
    color: #222831;
}

/* DARK MODE STYLES */
@media (prefers-color-scheme: dark) {
    :deep(.fc-col-header-cell) {
        border: 1px solid #666a6d !important;
        color: #eeeeee !important;
    }
    :deep(.fc-toolbar-title) {
        color: #eeeeee !important;
        font-weight: bold;
    }

    :deep(.fc-scrollgrid) {
        background: transparent !important;
        border: 1px solid #666a6d !important;
        box-sizing: border-box;
    }

    :deep(.fc-addEventButton-button) {
        background: #6084ff !important;
        color: #eeeeee;
        font-weight: bold;
        font-size: 12px !important;
        border: none !important;
        padding: 8px 24px !important;
        border-radius: 6px !important;
        transition: all 0.2s ease-in-out;
    }
    :deep(.fc-prev-button),
    :deep(.fc-next-button) {
        background: #6084ff !important;
    }

    :deep(.fc-prev-button:hover),
    :deep(.fc-next-button:hover) {
        background: #4d6acc !important;
    }
    :deep(.fc-daygrid-day) {
        border: 1px solid #666a6d !important;
    }
    :deep(.fc-daygrid-body) {
        background: #2c2f40 !important;
        color: #eeeeee;
    }
}
</style>
