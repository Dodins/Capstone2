<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const form = useForm({
    title: "",
    description: "",
    date: "",
    color: "",
    schedule: [{ start_time: "", end_time: "", description: "" }],
});

const today = new Date().toISOString().split("T")[0];
const minDate = ref(today);

const addSchedule = () => {
    form.schedule.push({ start_time: "", end_time: "", description: "" });
};

const removeSchedule = (index) => {
    form.schedule.splice(index, 1);
};

const submit = () => {
    form.post(route("calendar.store"));
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
                                placeholder="Date"
                                :min="minDate"
                                class="dark:text-[#B0B0B0] text-[#4B5660] border-2 dark:border-[#3C4053] border-[#DDE3E7] rounded-xl py-4 px-4 w-full"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.title"
                            />
                        </div>
                    </div>
                    <div class="px-4 w-full pt-4 h-32">
                        <textarea
                            name=""
                            v-model="form.description"
                            id="description"
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
                                class="fa-solid fa-square-minus text-4xl me-2 dark:text-[#FF6666] text-[#FF4D4D] cursor-pointer"
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
                                id="colorPicker"
                                name="color"
                                class="h-full w-full cursor-pointer border-none opacity-0 absolute inset-0"
                            />
                            <div
                                id="colorBox"
                                class="h-full w-full rounded-lg cursor-pointer bg-black"
                                :style="{ backgroundColor: form.color }"
                            ></div>
                        </div>
                        <h1
                            id="colorText"
                            class="ml-3 text-[#4B5660] dark:text-[#B0B0B0]"
                        >
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
                        Post
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
