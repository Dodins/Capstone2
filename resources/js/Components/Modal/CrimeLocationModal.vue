<script setup>
import { ref } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
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
        imageUrl.value = {
            url: URL.createObjectURL(file),
            name: file.name,
        };
    }
};

const removeFile = () => {
    imageUrl.value = null;
    // Reset the file input
    const fileInput = document.getElementById("file-upload");
    if (fileInput) {
        fileInput.value = "";
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
            @click.self="close"
        >
            <div
                class="dark:bg-[#222831] bg-[#DDE3E7] p-4 rounded-[6px] relative flex flex-col w-96"
            >
                <div class="flex w-full justify-between items-start">
                    <div
                        class="border-2 dark:border-[#6084FF] border-[#3B5FBF] w-10 h-10 rounded-full flex items-center justify-center"
                    >
                        <i
                            class="fa-solid fa-location-dot dark:text-[#6084FF] text-[#3B5FBF]"
                        ></i>
                    </div>
                    <div>
                        <i
                            class="fa-solid fa-xmark dark:text-[#EEEEEE] text-[#222831] cursor-pointer"
                            @click="close"
                        ></i>
                    </div>
                </div>
                <div class="mt-3">
                    <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold">
                        Crime Location
                    </h1>
                    <h1 class="dark:text-[#B0B0B0] text-[#4B5660] text-[14px]">
                        Provide details about the reported crime.
                    </h1>
                </div>
                <div class="mt-6">
                    <InputLabel for="name" value="Title" />
                    <TextInput
                        v-model="form.name"
                        placeholder="Add a title here"
                        class="dark:text-[#B0B0B0] text-[#4B5660] border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl px-4 w-full mt-2"
                    />
                </div>
                <div class="mt-3">
                    <InputLabel for="description" value="Description" />
                    <textarea
                        name=""
                        v-model="form.description"
                        id="description"
                        placeholder="Add a short description"
                        class="resize-none w-full h-24 border-2 dark:border-[#666A6D] border-[#A0A5AA] rounded-xl dark:text-[#B0B0B0] text-[#4B5660] pt-2 px-4 focus:outline-none mt-2"
                    ></textarea>
                </div>
                <div class="mt-3">
                    <div class="space-y-2">
                        <div class="flex items-center justify-center w-full">
                            <label
                                for="file-upload"
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer dark:border-[#3C4053] border-[#DDE3E7] dark:bg-[#2C3042]/50 bg-[#DDE3E7]/50 hover:dark:bg-[#2C3042] hover:bg-[#DDE3E7]"
                            >
                                <div
                                    class="flex flex-col items-center justify-center pt-5 pb-6"
                                >
                                    <span class="text-2xl mb-2">📤</span>
                                    <p
                                        class="mb-1 text-sm dark:text-[#B0B0B0] text-[#4B5660]"
                                    >
                                        <span class="font-semibold"
                                            >Click to upload</span
                                        >
                                        or drag and drop
                                    </p>
                                    <p
                                        class="text-xs dark:text-[#B0B0B0] text-[#4B5660]"
                                    >
                                        PDF, DOC, XLS, JPG, PNG (MAX. 10MB)
                                    </p>
                                </div>
                                <input
                                    id="file-upload"
                                    type="file"
                                    class="hidden"
                                    @change="onFileChange"
                                />
                            </label>
                        </div>
                        <div
                            v-if="imageUrl"
                            class="flex items-center gap-2 text-sm p-2 dark:bg-[#3C4053] bg-[#DDE3E7] rounded"
                        >
                            <span>📄</span>
                            <span
                                class="truncate dark:text-[#EEEEEE] text-[#222831]"
                                >{{ imageUrl.name }}</span
                            >
                            <button
                                @click="removeFile"
                                class="ml-auto dark:text-[#B0B0B0] text-[#4B5660] hover:dark:text-[#EEEEEE] hover:text-[#222831]"
                            >
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end items-center gap-4 mt-6">
                    <SecondaryButton class="text-[12px]" @click="close">
                        Cancel
                    </SecondaryButton>
                    <PrimaryButton class="text-[12px]"> Confirm </PrimaryButton>
                </div>
            </div>
        </div>
    </form>
</template>
