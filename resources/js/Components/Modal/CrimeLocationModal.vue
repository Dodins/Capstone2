<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";

const props = defineProps({
    location: Object,
});

const form = useForm({
    imageFile: "",
    name: "",
    description: "",
    lat: props.location.lat,
    lng: props.location.lng,
});

const imageUrl = ref(null);

const emit = defineEmits(["close"]);

const close = () => {
    form.description = "";
    form.imageUrl = "";
    props.location.lat = "";
    props.location.lng = "";
    form.name = "";
    emit("close");
};

const onFileChange = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.imageFile = file;
        imageUrl.value = URL.createObjectURL(file);
    }
};
const submit = async () => {
    try {
        const formData = new FormData();
        formData.append("name", form.name);
        formData.append("description", form.description);
        formData.append("lat", form.lat);
        formData.append("lng", form.lng);

        if (form.imageFile) {
            formData.append("image", form.imageFile);
        }

        await axios.post(route("map.store"), formData, {
            headers: {
                "Content-Type": "multipart/form-data",
            },
        });

        router.visit(window.location.href);
    } catch (error) {
        console.error("Upload error:", error.response?.data || error);
    }
};
</script>

<template>
    <form @submit.prevent="submit" class="h-full">
        <div
            class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
        >
            <div
                class="dark:bg-[#3C4053] bg-[#DDE3E7] p-4 rounded-[6px] relative flex flex-col gap-12"
            >
                <div class="flex flex-col w-88 gap-4">
                    <div class="flex w-full justify-between items-center">
                        <div>
                            <h1
                                class="dark:text-[#EEEEEE] text-[#222831] font-bold"
                            >
                                Crime Location
                            </h1>
                            <h1
                                class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]"
                            >
                                Provide details about the reported crime.
                            </h1>
                        </div>

                        <div
                            class="border-2 dark:border-[#6084FF] border-[#3B5FBF] w-10 h-10 rounded-full flex items-center justify-center"
                        >
                            <i
                                class="fa-solid fa-location-dot dark:text-[#6084FF] text-[#3B5FBF]"
                            ></i>
                        </div>
                    </div>
                    <div class="w-full">
                        <TextInput
                            v-model="form.name"
                            placeholder="Name"
                            class="dark:text-[#B0B0B0] text-[#4B5660] border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl px-4 w-full"
                        />
                    </div>
                    <div
                        class="border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl py-2 px-4 dark:text-[#B0B0B0] text-[#4B5660]"
                    >
                        <input type="file" class="" @change="onFileChange" />
                        <img
                            v-if="imageUrl"
                            :src="imageUrl"
                            alt="Preview"
                            class="mt-2 w-32 h-32 rounded-lg"
                        />
                    </div>
                    <div class="w-full h-24">
                        <textarea
                            name=""
                            v-model="form.description"
                            id="description"
                            placeholder="Description"
                            class="resize-none w-full h-full border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl dark:text-[#B0B0B0] text-[#4B5660] pt-2 px-4 focus:outline-none"
                        ></textarea>
                    </div>
                </div>
                <div class="flex justify-end items-center gap-4">
                    <SecondaryButton class="text-[12px]" @click="close">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton class="text-[12px]"> Confirm </PrimaryButton>
                </div>
            </div>
        </div>
    </form>
</template>
