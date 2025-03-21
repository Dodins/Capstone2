<script setup>
import { ref, computed, watch, onMounted, getCurrentInstance } from "vue";
import axios from "axios";
import ImageView from "@/Components/Modal/ImageView.vue";

const { proxy } = getCurrentInstance();
const hostUrl = proxy.$hostUrl;
const currentPage = ref(1);
const itemsPerPage = ref(10);
const totalPages = ref(1);
const residents = ref([]);
const totalItems = ref(0);
const selectedImage = ref(null);

const fetchResidents = async () => {
    try {
        const response = await axios.get(
            `unverifiedResident?page=${currentPage.value}`
        );
        residents.value = response.data.data;
        totalPages.value = response.data.last_page;
        totalItems.value = response.data.total;
        itemsPerPage.value = response.data.per_page;
    } catch (error) {
        console.error("Error fetching residents:", error);
    }
};

watch(currentPage, fetchResidents);

onMounted(fetchResidents);

const pageNumbers = computed(() => {
    const pages = [];
    const total = totalPages.value;
    const current = currentPage.value;

    let start = Math.max(1, current - 2);
    let end = Math.min(total, start + 4);

    if (end - start < 4) {
        start = Math.max(1, end - 4);
    }

    for (let i = start; i <= end; i++) {
        pages.push(i);
    }

    return pages;
});

const goToPage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
    }
};

const openImageView = (imageUrl) => {
    selectedImage.value = `${hostUrl}/${imageUrl}`;
};

const handleAccept = async (id) => {
    try {
        await axios.put(`/accept-verification/${id}/accept`);
        fetchResidents();
    } catch (error) {
        console.error("Error accepting resident:", error);
        alert("Failed to accept resident.");
    }
};

const handleReject = async (id) => {
    try {
        await axios.put(`/reject-verification/${id}/reject`);
        fetchResidents();
    } catch (error) {
        console.error("Error rejecting resident:", error);
        alert("Failed to reject resident.");
    }
};
</script>

<template>
    <div class="h-full w-full">
        <div class="overflow-y-auto h-12/13 no-scrollbar">
            <table class="table-fixed w-full">
                <thead class="sticky top-0">
                    <tr>
                        <th
                            class="w-1/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-center rounded-tl-xl rounded-bl-xl dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            •
                        </th>
                        <th
                            class="w-2/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Name
                        </th>
                        <th
                            class="w-2/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Email
                        </th>
                        <th
                            class="w-2/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Contact No.
                        </th>
                        <th
                            class="w-2/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7] overflow-hidden whitespace-nowrap text-ellipsis"
                        >
                            Emergency Contact No.
                        </th>
                        <th
                            class="w-3/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Address
                        </th>
                        <th
                            class="w-1/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Gender
                        </th>
                        <th
                            class="w-3/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-start dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Proof of IDs
                        </th>
                        <th
                            class="w-2/18 py-2 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] text-center rounded-tr-xl rounded-br-xl dark:bg-[#3C4053] bg-[#DDE3E7]"
                        >
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="resident in residents" :key="resident.id">
                        <td
                            class="text-center py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                        >
                            •
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                            :title="resident.full_name"
                        >
                            {{ resident.full_name }}
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                            :title="resident.email"
                        >
                            {{ resident.email }}
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                            :title="resident.phone_number"
                        >
                            {{ resident.phone_number }}
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                            :title="resident.emergency_contact_number"
                        >
                            {{ resident.emergency_contact_number }}
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                            :title="resident.address"
                        >
                            {{ resident.address }}
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831] overflow-hidden whitespace-nowrap text-ellipsis"
                            :title="resident.gender"
                        >
                            {{ resident.gender }}
                        </td>
                        <td
                            class="text-start py-1 px-2 text-[14px] text-[#EEEEEE] cursor-pointer"
                            :title="resident.barangay_id_image"
                        >
                            <div
                                @click="
                                    openImageView(resident.barangay_id_image)
                                "
                                class="hover:dark:bg-[#4D6ACC] hover:bg-[#2F4C99] dark:bg-[#6084FF] bg-[#3B5FBF] rounded-full overflow-hidden whitespace-nowrap text-ellipsis py-1 px-2"
                            >
                                {{ resident.barangay_id_image }}
                            </div>
                        </td>
                        <td
                            class="text-center py-1 px-2 text-[14px] dark:text-[#EEEEEE] text-[#222831]"
                        >
                            <button
                                @click="handleAccept(resident.id)"
                                class="dark:text-[#6084FF] text-[#3B5FBF] text-[14px] me-2 font-bold hover:dark:text-[#4D6ACC] hover:text-[#2F4C99] cursor-pointer"
                            >
                                Accept
                            </button>
                            <button
                                @click="handleReject(resident.id)"
                                class="dark:text-[#EEEEEE] text-[#222831] text-[14px] font-bold hover:dark:text-[#DDDDDD] hover:text-[#000000] cursor-pointer"
                            >
                                Reject
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="flex justify-between items-center">
            <button
                @click="goToPage(currentPage - 1)"
                :disabled="currentPage === 1"
                class="px-4 py-2 dark:bg-[#3C4053] bg-[#DDE3E7] dark:text-[#EEEEEE] text-[#222831] rounded-xl disabled:opacity-50"
            >
                &#x276E;
            </button>
            <div>
                <button
                    v-for="page in pageNumbers"
                    :key="page"
                    @click="goToPage(page)"
                    class="px-4 py-2 mx-1 rounded-xl"
                    :class="{
                        'dark:bg-[#6084FF] bg-[#3B5FBF] text-white':
                            page === currentPage,
                        'dark:bg-[#3C4053] bg-[#DDE3E7] text-[#222831] dark:text-[#EEEEEE]':
                            page !== currentPage,
                    }"
                >
                    {{ page }}
                </button>
            </div>
            <button
                @click="goToPage(currentPage + 1)"
                :disabled="currentPage === totalPages"
                class="px-4 py-2 dark:bg-[#3C4053] bg-[#DDE3E7] dark:text-[#EEEEEE] text-[#222831] rounded-xl disabled:opacity-50"
            >
                &#x276F;
            </button>
        </div>
    </div>
    <ImageView
        v-if="selectedImage"
        :imageSrc="selectedImage"
        :show="!!selectedImage"
        @close="selectedImage = null"
    />
</template>
