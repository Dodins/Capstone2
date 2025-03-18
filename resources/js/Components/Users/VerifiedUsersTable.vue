<script setup>
import { ref, onMounted, nextTick } from "vue";
import axios from "axios";

const users = ref([]);
const allUsers = ref([]);
const itemsPerPage = 10;
const observer = ref(null);
const isLoading = ref(false);
const scrollTarget = ref(null);

// Fetch users from API
const fetchUsers = async () => {
    try {
        isLoading.value = true;

        // Uncomment this when using API
        // const response = await axios.get("verified-users");
        // allUsers.value = response.data;

        // Mocking users (avoiding duplicate additions)
        if (allUsers.value.length === 0) {
            for (let i = 1; i <= 50; i++) {
                allUsers.value.push({
                    id: i,
                    name: `John Brandon Lambino ${i}`,
                    email: `user${i}@example.com`,
                    contact: `+12345678${i}`,
                });
            }
        }

        users.value = allUsers.value.slice(0, itemsPerPage);
    } catch (error) {
        console.error("Error fetching users:", error);
    } finally {
        isLoading.value = false;
    }
};

// Load more users when reaching the bottom
const loadMoreUsers = () => {
    if (isLoading.value) return;

    isLoading.value = true;
    nextTick(() => {
        const nextBatch = allUsers.value.slice(
            users.value.length,
            users.value.length + itemsPerPage
        );

        if (nextBatch.length > 0) {
            users.value.push(...nextBatch);
        }

        isLoading.value = false;
    });
};

// Attach Intersection Observer
const observeBottom = () => {
    if (!scrollTarget.value) return;

    observer.value = new IntersectionObserver(
        (entries) => {
            if (entries[0].isIntersecting) {
                loadMoreUsers();
            }
        },
        { threshold: 1.0 }
    );

    observer.value.observe(scrollTarget.value);
};

// Initialize on mount
onMounted(async () => {
    await fetchUsers();
    nextTick(observeBottom);
});
</script>

<template>
    <div class="h-full flex flex-col w-full">
        <h1 class="dark:text-[#EEEEEE] text-[#222831] font-bold mb-2">
            Verified Users
        </h1>
        <div
            class="overflow-y-auto h-full no-scrollbar"
        >
            <table class="table-auto h-[400px] max-h-full w-full">
                <thead class="sticky top-0 dark:bg-[#3C4053] bg-[#DDE3E7]">
                    <tr>
                        <th
                            class="w-1/13 pb-1 pt-2 dark:text-[#EEEEEE] text-[#222831] text-[12px]"
                        >
                            •
                        </th>
                        <th
                            class="w-4/13 pb-1 pt-2 dark:text-[#EEEEEE] text-[#222831] text-[12px] text-start ps-4"
                        >
                            Name
                        </th>
                        <th
                            class="w-4/13 pb-1 pt-2 dark:text-[#EEEEEE] text-[#222831] text-[12px] text-start ps-4"
                        >
                            Email
                        </th>
                        <th
                            class="w-4/13 pb-1 pt-2 dark:text-[#EEEEEE] text-[#222831] text-[12px] text-start ps-4"
                        >
                            Contact No.
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-if="users.length === 0">
                        <td
                            colspan="4"
                            class="dark:text-[#EEEEEE] text-[#222831] text-[16px] text-center h-full"
                        >
                            No verified users found.
                        </td>
                    </tr>

                    <tr v-for="user in users" :key="user.id">
                        <td
                            class="mb-2 flex-1 items-center flex justify-center h-full"
                        >
                            <div
                                class="dark:bg-[#6084FF] bg-[#3B5FBF] rounded-full w-8 h-8"
                            ></div>
                        </td>
                        <td
                            class="mb-2 truncate max-w-[200px] ps-4 dark:text-[#EEEEEE] text-[#222831] text-[14px] font-bold"
                        >
                            {{ user.name }}
                        </td>
                        <td
                            class="mb-2 truncate max-w-[250px] ps-4 dark:text-[#EEEEEE] text-[#222831] text-[14px]"
                        >
                            {{ user.email }}
                        </td>
                        <td
                            class="mb-2 truncate max-w-[150px] ps-4 dark:text-[#EEEEEE] text-[#222831] text-[14px]"
                        >
                            {{ user.contact }}
                        </td>
                    </tr>

                    <!-- Loading Indicator -->
                    <tr v-if="isLoading">
                        <td
                            colspan="4"
                            class="text-center dark:text-[#EEEEEE] text-[#222831] py-3"
                        >
                            Loading more users...
                        </td>
                    </tr>

                    <!-- Scroll Detector -->
                    <tr ref="scrollTarget">
                        <td colspan="4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<style>
.no-scrollbar::-webkit-scrollbar {
    display: none;
}
.no-scrollbar {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
