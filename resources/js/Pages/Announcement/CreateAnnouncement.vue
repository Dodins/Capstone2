<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import { Head, useForm } from "@inertiajs/vue3";

const form = useForm({
    title: "",
    description: "",
});

const submit = () => {
    form.post(route("announcement.store"));
};
</script>

<template>
    <Head title="Announcement" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="">Announcement</h2>
        </template>
        <form @submit.prevent="submit" class="h-full">
            <div
                class="h-full w-full flex flex-col rounded-xl overflow-hidden border-2 dark:border-[#3C4053] border-[#DDE3E7]"
            >
                <div class="h-full w-full">
                    <h1
                        class="dark:text-[#EEEEEE] text-[#222831] font-bold dark:bg-[#3C4053] bg-[#DDE3E7] p-4"
                    >
                        Announcements and press
                    </h1>
                    <h1
                        class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px] px-4 pt-4"
                    >
                        Fill in the subject and body of the announcement and
                        press send. Users will receive a notifications on thier
                        phone
                    </h1>
                    <div class="px-4 w-full pt-4">
                        <TextInput
                            v-model="form.title"
                            placeholder="Title"
                            class="dark:text-[#B0B0B0] text-[#4B5660] border-2 dark:border-[#3C4053] border-[#DDE3E7] rounded-xl py-4 px-4 w-full"
                        />
                        <InputError class="mt-2" :message="form.errors.title" />
                    </div>
                    <div class="px-4 w-full pt-4 h-64">
                        <textarea
                            name=""
                            v-model="form.description"
                            id="description"
                            placeholder="Your announcement body"
                            class="w-full h-full border-2 dark:border-[#3C4053] border-[#DDE3E7] rounded-xl dark:text-[#B0B0B0] text-[#4B5660] py-4 px-4 focus:outline-none"
                        ></textarea>
                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>
                </div>
                <div class="w-full flex justify-end pb-4 pe-4">
                    <PrimaryButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="px-8"
                    >
                        Announce
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </AuthenticatedLayout>
</template>
