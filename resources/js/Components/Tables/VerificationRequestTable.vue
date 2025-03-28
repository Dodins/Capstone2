<script setup>
import { ref, getCurrentInstance, computed } from "vue";
import axios from "axios";
import ImageView from "@/Components/Modal/ImageView.vue";
import { router } from "@inertiajs/vue3";
import {
    EyeIcon,
    CheckCircleIcon,
    XCircleIcon,
    UserIcon,
} from "@heroicons/vue/24/outline";

const { proxy } = getCurrentInstance();
const hostUrl = proxy.$hostUrl;
const selectedImage = ref(null);
const searchQuery = ref("");
const processingId = ref(null);

const props = defineProps({
    residents: Array,
});

// Filter residents based on search
const filteredResidents = computed(() => {
    if (!searchQuery.value || !props.residents) return props.residents || [];

    const query = searchQuery.value.toLowerCase();
    return props.residents.filter(
        (resident) =>
            resident.full_name?.toLowerCase().includes(query) ||
            resident.email?.toLowerCase().includes(query) ||
            resident.address?.toLowerCase().includes(query)
    );
});

const openImageView = (imageUrl) => {
    selectedImage.value = `${hostUrl}/${imageUrl}`;
};

const handleAccept = async (id) => {
    try {
        processingId.value = id;
        await axios.put(`/accept-verification/${id}/accept`);
        router.visit(window.location.href);
    } catch (error) {
        console.error("Error accepting resident:", error);
        alert("Failed to accept resident.");
    } finally {
        processingId.value = null;
    }
};

const handleReject = async (id) => {
    try {
        processingId.value = id;
        await axios.put(`/reject-verification/${id}/reject`);
        router.visit(window.location.href);
    } catch (error) {
        console.error("Error rejecting resident:", error);
        alert("Failed to reject resident.");
    } finally {
        processingId.value = null;
    }
};

// Format phone number for display
const formatPhoneNumber = (phone) => {
    if (!phone) return "—";
    return phone;
};

// Truncate text with ellipsis
const truncateText = (text, length = 25) => {
    if (!text) return "—";
    return text.length > length ? text.substring(0, length) + "..." : text;
};
</script>

<template>
    <div class="h-full w-full overflow-hidden rounded-xl flex flex-col">
        <!-- Search bar -->
        <div
            class="p-4 dark:bg-[#3C4053] bg-[#DDE3E7] rounded-t-xl border-b dark:border-[#4A5173] border-[#C5CDD3]"
        >
            <div class="relative">
                <input
                    v-model="searchQuery"
                    type="text"
                    placeholder="Search by name, email or address..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg dark:bg-[#2A2E3F] bg-white border dark:border-[#4A5173] border-[#C5CDD3] dark:text-[#EEEEEE] text-[#222831] text-sm focus:outline-none focus:ring-2 focus:ring-[#6084FF]"
                />
                <div class="absolute left-3 top-2.5">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 dark:text-[#B0B0B0] text-[#4B5660]"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                        />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Table container -->
        <div
            class="overflow-y-auto no-scrollbar flex-grow min-h-0 max-h-[calc(100vh-239px-56px)] dark:bg-[#222631] bg-white"
        >
            <!-- Empty state -->
            <div
                v-if="!filteredResidents || filteredResidents.length === 0"
                class="flex flex-col items-center justify-center h-full p-8"
            >
                <UserIcon
                    class="h-16 w-16 dark:text-[#3C4053] text-[#DDE3E7] mb-4"
                />
                <h3
                    class="text-lg font-medium dark:text-[#EEEEEE] text-[#222831] mb-2"
                >
                    No residents found
                </h3>
                <p
                    class="text-sm dark:text-[#B0B0B0] text-[#4B5660] text-center max-w-md"
                >
                    {{
                        searchQuery
                            ? "No residents match your search criteria. Try a different search term."
                            : "There are no pending verification requests at this time."
                    }}
                </p>
            </div>

            <!-- Table -->
            <table v-else class="table-fixed w-full border-collapse">
                <thead class="sticky top-0 z-10">
                    <tr>
                        <th
                            class="w-[3%] py-3 px-2 text-[13px] dark:text-[#EEEEEE] text-[#222831] text-center dark:bg-[#3C4053] bg-[#DDE3E7] border-b dark:border-[#4A5173] border-[#C5CDD3]"
                        >
                            #
                        </th>
                        <th
                            class="w-[15%] py-3 px-2 text-[13px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7] border-b dark:border-[#4A5173] border-[#C5CDD3]"
                        >
                            Name
                        </th>
                        <th
                            class="w-[15%] py-3 px-2 text-[13px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7] border-b dark:border-[#4A5173] border-[#C5CDD3]"
                        >
                            Email
                        </th>
                        <th
                            class="w-[12%] py-3 px-2 text-[13px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7] border-b dark:border-[#4A5173] border-[#C5CDD3]"
                        >
                            Contact
                        </th>
                        <th
                            class="w-[12%] py-3 px-2 text-[13px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7] border-b dark:border-[#4A5173] border-[#C5CDD3]"
                        >
                            Emergency
                        </th>
                        <th
                            class="w-[18%] py-3 px-2 text-[13px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7] border-b dark:border-[#4A5173] border-[#C5CDD3]"
                        >
                            Address
                        </th>
                        <th
                            class="w-[5%] py-3 px-2 text-[13px] dark:text-[#EEEEEE] text-[#222831] text-center dark:bg-[#3C4053] bg-[#DDE3E7] border-b dark:border-[#4A5173] border-[#C5CDD3]"
                        >
                            Gender
                        </th>
                        <th
                            class="w-[8%] py-3 px-2 text-[13px] dark:text-[#EEEEEE] text-[#222831] text-center dark:bg-[#3C4053] bg-[#DDE3E7] border-b dark:border-[#4A5173] border-[#C5CDD3]"
                        >
                            ID
                        </th>
                        <th
                            class="w-[12%] py-3 px-2 text-[13px] dark:text-[#EEEEEE] text-[#222831] text-center dark:bg-[#3C4053] bg-[#DDE3E7] border-b dark:border-[#4A5173] border-[#C5CDD3]"
                        >
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(resident, index) in filteredResidents"
                        :key="resident.id"
                        class="hover:dark:bg-[#2A2E3F] hover:bg-[#F5F7F9] transition-colors duration-150"
                    >
                        <td
                            class="text-center py-2.5 px-2 text-[13px] dark:text-[#B0B0B0] text-[#4B5660] border-b dark:border-[#3C4053] border-[#DDE3E7]"
                        >
                            {{ index + 1 }}
                        </td>
                        <td
                            class="text-start py-2.5 px-2 border-b dark:border-[#3C4053] border-[#DDE3E7]"
                        >
                            <div
                                class="font-medium text-[13px] dark:text-[#EEEEEE] text-[#222831]"
                                :title="resident.full_name"
                            >
                                {{ truncateText(resident.full_name, 18) }}
                            </div>
                        </td>
                        <td
                            class="text-start py-2.5 px-2 text-[13px] dark:text-[#B0B0B0] text-[#4B5660] border-b dark:border-[#3C4053] border-[#DDE3E7] overflow-hidden whitespace-nowrap text-ellipsis"
                            :title="resident.email"
                        >
                            {{ truncateText(resident.email, 18) }}
                        </td>
                        <td
                            class="text-start py-2.5 px-2 text-[13px] dark:text-[#B0B0B0] text-[#4B5660] border-b dark:border-[#3C4053] border-[#DDE3E7] overflow-hidden whitespace-nowrap text-ellipsis"
                            :title="resident.phone_number"
                        >
                            {{ formatPhoneNumber(resident.phone_number) }}
                        </td>
                        <td
                            class="text-start py-2.5 px-2 text-[13px] dark:text-[#B0B0B0] text-[#4B5660] border-b dark:border-[#3C4053] border-[#DDE3E7] overflow-hidden whitespace-nowrap text-ellipsis"
                            :title="resident.emergency_contact_number"
                        >
                            {{
                                formatPhoneNumber(
                                    resident.emergency_contact_number
                                )
                            }}
                        </td>
                        <td
                            class="text-start py-2.5 px-2 text-[13px] dark:text-[#B0B0B0] text-[#4B5660] border-b dark:border-[#3C4053] border-[#DDE3E7] overflow-hidden whitespace-nowrap text-ellipsis"
                            :title="resident.address"
                        >
                            {{ truncateText(resident.address, 25) }}
                        </td>
                        <td
                            class="text-center py-2.5 px-2 border-b dark:border-[#3C4053] border-[#DDE3E7]"
                        >
                            <span
                                class="inline-flex items-center justify-center px-2 py-0.5 text-xs rounded-full dark:bg-[#3C4053] bg-[#DDE3E7] dark:text-[#EEEEEE] text-[#222831]"
                            >
                                {{ resident.gender }}
                            </span>
                        </td>
                        <td
                            class="text-center py-2.5 px-2 border-b dark:border-[#3C4053] border-[#DDE3E7]"
                        >
                            <button
                                @click="
                                    openImageView(resident.barangay_id_image)
                                "
                                class="inline-flex items-center justify-center px-2.5 py-1.5 text-xs rounded-lg dark:bg-[#6084FF] bg-[#3B5FBF] text-white hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99] transition-colors duration-150"
                                :title="resident.barangay_id_image"
                            >
                                <EyeIcon class="h-4 w-4 mr-1" />
                                View
                            </button>
                        </td>
                        <td
                            class="text-center py-2.5 px-2 border-b dark:border-[#3C4053] border-[#DDE3E7]"
                        >
                            <div
                                class="flex flex-col items-center justify-center gap-2"
                            >
                                <button
                                    @click="handleAccept(resident.id)"
                                    :disabled="processingId === resident.id"
                                    class="w-full inline-flex items-center justify-center px-3 py-1.5 text-xs rounded-lg dark:bg-[#6084FF] bg-[#3B5FBF] text-white hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99] transition-colors duration-150 disabled:opacity-50 disabled:cursor-wait"
                                >
                                    <CheckCircleIcon
                                        v-if="processingId !== resident.id"
                                        class="h-4 w-4 mr-1"
                                    />
                                    <svg
                                        v-else
                                        class="animate-spin h-4 w-4 mr-1 text-white"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                        ></circle>
                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        ></path>
                                    </svg>
                                    Accept
                                </button>
                                <button
                                    @click="handleReject(resident.id)"
                                    :disabled="processingId === resident.id"
                                    class="w-full inline-flex items-center justify-center px-3 py-1.5 text-xs rounded-lg dark:bg-[#3C4053] bg-[#DDE3E7] dark:text-[#EEEEEE] text-[#222831] hover:dark:bg-[#4A5173] hover:bg-[#C5CDD3] transition-colors duration-150 disabled:opacity-50 disabled:cursor-wait"
                                >
                                    <XCircleIcon
                                        v-if="processingId !== resident.id"
                                        class="h-4 w-4 mr-1"
                                    />
                                    <svg
                                        v-else
                                        class="animate-spin h-4 w-4 mr-1"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <circle
                                            class="opacity-25"
                                            cx="12"
                                            cy="12"
                                            r="10"
                                            stroke="currentColor"
                                            stroke-width="4"
                                        ></circle>
                                        <path
                                            class="opacity-75"
                                            fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                        ></path>
                                    </svg>
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Image viewer modal -->
    <ImageView
        v-if="selectedImage"
        :imageSrc="selectedImage"
        :show="!!selectedImage"
        @close="selectedImage = null"
    />
</template>

<style scoped>
/* Custom scrollbar */
.no-scrollbar::-webkit-scrollbar {
    width: 5px;
}

.no-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.no-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(156, 163, 175, 0.5);
    border-radius: 20px;
}

.dark .no-scrollbar::-webkit-scrollbar-thumb {
    background-color: rgba(75, 85, 99, 0.5);
}

/* Smooth transitions */
tr {
    transition: all 0.2s ease-in-out;
}

/* Loading spinner animation */
@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
