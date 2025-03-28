<script setup>
import { ref, onMounted, watch } from "vue";
import axios from "axios";
import { BellIcon } from "@heroicons/vue/24/outline";
import { BellIcon as BellIconSolid } from "@heroicons/vue/24/solid";

const props = defineProps({
    showNotifications: Boolean,
});

const emit = defineEmits(["close", "notificationsRead"]);

const notifications = ref([]);
const unreadCount = ref(0);
const loading = ref(true);
const error = ref(null);

// Fetch notifications from the controller
const fetchNotifications = async () => {
    try {
        loading.value = true;
        error.value = null;
        const response = await axios.get("/notification");
        notifications.value = response.data.notifications;
        unreadCount.value = response.data.unreadCount;

        // If there are unread notifications, mark them as read automatically
        if (unreadCount.value > 0) {
            await markAllAsRead();
        }
    } catch (err) {
        console.error("Error fetching notifications:", err);
        error.value = "Failed to load notifications";
    } finally {
        loading.value = false;
    }
};

// Mark all notifications as read
const markAllAsRead = async () => {
    try {
        await axios.post("/markAsRead");
        unreadCount.value = 0;

        // Emit event to parent to update the badge
        emit("notificationsRead");

        // Update the read status in the local notifications array
        notifications.value = notifications.value.map((notification) => ({
            ...notification,
            read_at: notification.read_at || new Date().toISOString(),
        }));
    } catch (err) {
        console.error("Error marking notifications as read:", err);
    }
};

// Format notification date
const formatDate = (dateString) => {
    const date = new Date(dateString);
    const now = new Date();
    const diffInMs = now - date;
    const diffInMinutes = Math.floor(diffInMs / (1000 * 60));
    const diffInHours = Math.floor(diffInMs / (1000 * 60 * 60));
    const diffInDays = Math.floor(diffInMs / (1000 * 60 * 60 * 24));

    if (diffInMinutes < 60) {
        return `${diffInMinutes} min ago`;
    } else if (diffInHours < 24) {
        return `${diffInHours} hour${diffInHours > 1 ? "s" : ""} ago`;
    } else if (diffInDays < 7) {
        return `${diffInDays} day${diffInDays > 1 ? "s" : ""} ago`;
    } else {
        return date.toLocaleDateString("en-US", {
            month: "short",
            day: "numeric",
            year: "numeric",
        });
    }
};

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
    const dropdown = document.getElementById("notification-dropdown");
    if (
        dropdown &&
        !dropdown.contains(event.target) &&
        !event.target.classList.contains("notification-bell")
    ) {
        emit("close");
    }
};

// Watch for prop changes to fetch notifications when dropdown opens
watch(
    () => props.showNotifications,
    (newVal) => {
        if (newVal) {
            fetchNotifications();
            // Add click outside listener
            setTimeout(() => {
                document.addEventListener("click", handleClickOutside);
            }, 100);
        } else {
            // Remove click outside listener
            document.removeEventListener("click", handleClickOutside);
        }
    }
);

onMounted(() => {
    // Initial fetch if dropdown is open
    if (props.showNotifications) {
        fetchNotifications();
    }
});
</script>

<template>
    <div
        v-if="showNotifications"
        id="notification-dropdown"
        class="notification-dropdown"
    >
        <div class="dropdown-header">
            <h3>Notifications</h3>
        </div>

        <div class="dropdown-content">
            <div v-if="loading" class="loading-state">
                <div class="loading-spinner"></div>
                <p>Loading notifications...</p>
            </div>

            <div v-else-if="error" class="error-state">
                <p>{{ error }}</p>
                <button @click="fetchNotifications" class="retry-btn">
                    Retry
                </button>
            </div>

            <div v-else-if="notifications.length === 0" class="empty-state">
                <p>No notifications</p>
            </div>

            <template v-else>
                <div
                    v-for="notification in notifications"
                    :key="notification.id"
                    class="notification-item"
                >
                    <div class="notification-content">
                        <div class="notification-title">
                            {{ notification.data.title || "Notification" }}
                        </div>
                        <div class="notification-message">
                            {{ notification.data.message }}
                        </div>
                        <div class="notification-time">
                            {{ formatDate(notification.created_at) }}
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<style scoped>
.notification-dropdown {
    position: absolute;
    top: 60px;
    right: 80px;
    width: 320px;
    max-height: 400px;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    z-index: 50;
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

.dark .notification-dropdown {
    background-color: #2a2e3f;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.dropdown-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    border-bottom: 1px solid #e5e7eb;
}

.dark .dropdown-header {
    border-bottom: 1px solid #3c4053;
}

.dropdown-header h3 {
    font-weight: 600;
    font-size: 16px;
    color: #222831;
}

.dark .dropdown-header h3 {
    color: #eeeeee;
}

.dropdown-content {
    overflow-y: auto;
    flex: 1;
    max-height: 350px;
}

.notification-item {
    padding: 12px 16px;
    border-bottom: 1px solid #e5e7eb;
    cursor: pointer;
    transition: background-color 0.2s;
}

.notification-item:last-child {
    border-bottom: none;
}

.notification-item:hover {
    background-color: #f9fafb;
}

.dark .notification-item {
    border-bottom: 1px solid #3c4053;
}

.dark .notification-item:hover {
    background-color: #343950;
}

.notification-content {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.notification-title {
    font-weight: 600;
    font-size: 14px;
    color: #222831;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.dark .notification-title {
    color: #eeeeee;
}

.notification-message {
    font-size: 13px;
    color: #4b5660;
    line-height: 1.4;
}

.dark .notification-message {
    color: #b0b0b0;
}

.notification-time {
    font-size: 12px;
    color: #6b7280;
    margin-top: 4px;
}

.dark .notification-time {
    color: #9ca3af;
}

.loading-state,
.error-state,
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 24px 16px;
    text-align: center;
    color: #4b5660;
    font-size: 14px;
}

.dark .loading-state,
.dark .error-state,
.dark .empty-state {
    color: #b0b0b0;
}

.loading-spinner {
    width: 24px;
    height: 24px;
    border: 2px solid rgba(59, 95, 191, 0.2);
    border-radius: 50%;
    border-top-color: #3b5fbf;
    animation: spin 1s linear infinite;
    margin-bottom: 12px;
}

.dark .loading-spinner {
    border: 2px solid rgba(96, 132, 255, 0.2);
    border-top-color: #6084ff;
}

.retry-btn {
    margin-top: 8px;
    padding: 6px 12px;
    background-color: #3b5fbf;
    color: white;
    border: none;
    border-radius: 4px;
    font-size: 12px;
    cursor: pointer;
}

.dark .retry-btn {
    background-color: #6084ff;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}
</style>
