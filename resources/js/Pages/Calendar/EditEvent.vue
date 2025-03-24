<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref, watch } from "vue";

const props = defineProps({
    events: Object,
});

const form = ref(
    useForm({
        title: "",
        description: "",
        date: "",
        color: "#000000",
        schedule: [{ start_time: "", end_time: "", description: "" }],
    })
);

const updateForm = (eventData) => {
    form.value.title = eventData?.title || "";
    form.value.description = eventData?.description || "";
    form.value.date = eventData?.date || "";
    form.value.color = eventData?.color || "#000000";
    form.value.schedule = eventData?.schedules?.length
        ? eventData.schedules
        : [{ start_time: "", end_time: "", description: "" }];
};

watch(
    () => props.events,
    (newVal) => {
        if (newVal) {
            updateForm(newVal);
        }
    },
    { deep: true, immediate: true }
);

const addSchedule = () => {
    form.value.schedule.push({ start_time: "", end_time: "", description: "" });
};

const removeSchedule = (index) => {
    form.value.schedule.splice(index, 1);
};

const submit = () => {
    form.value.post(route("calendar.update", { id: props.events.id }));
};
</script>

<template>
    <Head title="Calendar" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Calendar</h2>
        </template>
        <form @submit.prevent="submit" class="h-full">
            <div
                class="h-full w-full flex flex-col rounded-xl overflow-hidden border-2 dark:border-[#3C4053] border-[#DDE3E7]"
            >
                <div class="h-full w-full">
                    <h1
                        class="dark:text-[#EEEEEE] text-[#222831] font-bold dark:bg-[#3C4053] bg-[#DDE3E7] p-4"
                    >
                        Post your barangay event here
                    </h1>
                    <h1
                        class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px] px-4 pt-4"
                    >
                        Provide full event details below to keep barangay
                        members informed and encourage participation.
                    </h1>
                    <div class="px-4 w-full pt-4 flex gap-4">
                        <div class="w-8/10">
                            <TextInput
                                v-model="form.title"
                                placeholder="Title"
                                class="dark:text-[#B0B0B0] text-[#4B5660] border-2 dark:border-[#3C4053] border-[#DDE3E7] rounded-xl py-4 px-4 w-full"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.title"
                            />
                        </div>
                        <div class="w-2/10">
                            <TextInput
                                v-model="form.date"
                                type="date"
                                class="dark:text-[#B0B0B0] text-[#4B5660] border-2 dark:border-[#3C4053] border-[#DDE3E7] rounded-xl py-4 px-4 w-full"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.date"
                            />
                        </div>
                    </div>
                    <div class="px-4 w-full pt-4 h-32">
                        <textarea
                            v-model="form.description"
                            placeholder="Your event body"
                            class="resize-none w-full h-full border-2 dark:border-[#3C4053] border-[#DDE3E7] rounded-xl dark:text-[#B0B0B0] text-[#4B5660] py-4 px-4 focus:outline-none"
                        ></textarea>
                        <InputError
                            class="mt-2"
                            :message="form.errors.description"
                        />
                    </div>
                    <div class="px-4 pt-8 flex items-center justify-between">
                        <h1
                            class="dark:text-[#EEEEEE] text-[#222831] font-bold"
                        >
                            Time schedule:
                        </h1>
                        <div class="flex gap-2 items-center">
                            <i
                                @click="addSchedule"
                                class="fa-solid fa-square-plus text-4xl dark:text-[#6084FF] text-[#3B5FBF] cursor-pointer"
                            ></i>

                            <i
                                @click="removeSchedule(index)"
                                class="fa-solid fa-square-minus text-4xl dark:text-[#FF6666] text-[#FF4D4D] cursor-pointer"
                            ></i>
                        </div>
                    </div>
                    <div
                        v-for="(schedule, index) in form.schedule"
                        :key="index"
                        class="flex gap-4 px-4 pt-2"
                    >
                        <div class="w-2/12">
                            <TextInput
                                v-model="schedule.start_time"
                                type="time"
                                placeholder="Start time"
                                class="dark:text-[#B0B0B0] text-[#4B5660] border-2 dark:border-[#3C4053] border-[#DDE3E7] rounded-xl py-4 px-4 w-full"
                            />
                        </div>
                        <div class="w-2/12">
                            <TextInput
                                v-model="schedule.end_time"
                                type="time"
                                placeholder="End time"
                                class="dark:text-[#B0B0B0] text-[#4B5660] border-2 dark:border-[#3C4053] border-[#DDE3E7] rounded-xl py-4 px-4 w-full"
                            />
                        </div>
                        <div class="w-8/12">
                            <TextInput
                                v-model="schedule.description"
                                placeholder="Description"
                                class="dark:text-[#B0B0B0] text-[#4B5660] border-2 dark:border-[#3C4053] border-[#DDE3E7] rounded-xl py-4 px-4 w-full"
                            />
                        </div>
                    </div>
                </div>
                <div class="w-full flex justify-between pb-4 px-4">
                    <div class="flex items-center">
                        <div
                            class="h-[50px] w-[50px] rounded-xl overflow-hidden relative"
                        >
                            <input
                                v-model="form.color"
                                type="color"
                                class="h-full w-full cursor-pointer border-none opacity-0 absolute inset-0"
                            />
                            <div
                                class="h-full w-full rounded-lg cursor-pointer"
                                :style="{ backgroundColor: form.color }"
                            ></div>
                        </div>
                        <h1 class="ml-3 text-[#4B5660] dark:text-[#B0B0B0]">
                            {{
                                form.color
                                    ? `Selected Color: ${form.color}`
                                    : "Select a color for your event."
                            }}
                        </h1>
                    </div>
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="px-8"
                    >
                        Update event
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
