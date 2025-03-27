<script setup>
import { MapPinIcon, PhoneIcon, EnvelopeIcon } from "@heroicons/vue/24/solid";

const props = defineProps({
    sosData: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(["close"]);

const closeModal = () => {
    emit("close");
};

const openMaps = () => {
    const { latitude, longitude } = props.sosData;
    if (latitude && longitude) {
        window.open(
            `https://www.google.com/maps?q=${latitude},${longitude}`,
            "_blank"
        );
    }
};

const initiateCall = () => {
    const { phone_number } = props.sosData;
    if (phone_number) {
        window.location.href = `tel:${phone_number}`;
    }
};

const sendEmail = () => {
    const { email } = props.sosData;
    if (email) {
        window.location.href = `mailto:${email}`;
    }
};
</script>

<template>
    <div
        class="fixed inset-0 bg-black/70 flex items-center justify-center z-50"
        @click.self="closeModal"
    >
        <div
            class="bg-white dark:bg-[#3C4053] rounded-xl shadow-2xl w-[500px] p-6 relative"
        >
            <!-- Close Button -->
            <button
                @click="closeModal"
                class="absolute top-4 right-4 text-gray-600 dark:text-gray-300 hover:text-red-500 transition-colors"
            >
                ✕
            </button>

            <!-- SOS Alert Header -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-[#D72638] dark:text-[#FF5252]">
                    EMERGENCY SOS ALERT
                </h2>
                <p class="text-sm text-[#4B5660] dark:text-[#B0B0B0]">
                    Urgent assistance required
                </p>
            </div>

            <!-- User Details -->
            <div class="bg-gray-100 dark:bg-[#2C2F40] p-4 rounded-lg mb-4">
                <div class="flex items-center mb-2">
                    <span class="font-semibold mr-2 dark:text-[#EEEEEE] text-[#222831]">Name:</span>
                    <span class="dark:text-[#EEEEEE] text-[#222831]">{{ sosData.name }}</span>
                </div>
                <div class="flex items-center mb-2">
                    <EnvelopeIcon class="h-5 w-5 mr-2 text-blue-600" />
                    <span class="dark:text-[#EEEEEE] text-[#222831]">{{ sosData.email }}</span>
                </div>
                <div class="flex items-center">
                    <PhoneIcon class="h-5 w-5 mr-2 text-green-600" />
                    <span class="dark:text-[#EEEEEE] text-[#222831]">{{ sosData.phone_number }}</span>
                </div>
            </div>

            <!-- SOS Message -->
            <div
                class="bg-[#D72638] dark:bg-[#FF5252] dark:bg-opacity-30 p-4 rounded-lg mb-4"
            >
                <h3 class="font-semibold mb-2 text-[#EEEEEE]">
                    Alert Message:
                </h3>
                <p class="text-[#EEEEEE]">
                    {{ sosData.message || "No additional message provided" }}
                </p>
            </div>

            <!-- Location Details -->
            <div class="flex items-center mb-4">
                <MapPinIcon class="h-6 w-6 mr-2 text-[#D72638] dark:text-[#FF5252]" />
                <span class="dark:text-[#EEEEEE] text-[#222831]">Latitude: {{ sosData.latitude }}</span>
                <span className="mx-2 dark:text-[#EEEEEE] text-[#222831]">|</span>
                <span class="dark:text-[#EEEEEE] text-[#222831]">Longitude: {{ sosData.longitude }}</span>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-between space-x-4">
                <button
                    @click="openMaps"
                    class="flex-1 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center"
                >
                    <MapPinIcon class="h-5 w-5 mr-2" />
                    View Location
                </button>
                <button
                    @click="initiateCall"
                    class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors flex items-center justify-center"
                >
                    <PhoneIcon class="h-5 w-5 mr-2" />
                    Call
                </button>
                <button
                    @click="sendEmail"
                    class="flex-1 bg-[#D72638] dark:bg-[#FF5252] text-white py-2 rounded-lg hover:bg-red-700 transition-colors flex items-center justify-center"
                >
                    <EnvelopeIcon class="h-5 w-5 mr-2" />
                    Email
                </button>
            </div>
        </div>
    </div>
</template>
