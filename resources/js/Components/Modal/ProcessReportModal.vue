<script setup>
import { ref, computed } from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    concern: Object,
    status: String,
});

const emit = defineEmits(["close"]);

const notes = ref("");
const uploadedFile = ref(null);

// Checklists for different stages
const newChecklist = ref([
    { label: "Verify report information is complete", checked: false },
    { label: "Check for duplicate reports", checked: false },
    { label: "Validate submitter credentials", checked: false },
    { label: "Acknowledge receipt to submitter", checked: false },
]);

const underReviewChecklist = ref([
    { label: "Review attached documentation", checked: false },
    { label: "Confirm affected systems/services", checked: false },
    { label: "Verify impact assessment", checked: false },
    { label: "Assign to appropriate team member", checked: false },
]);

const pendingActionChecklist = ref([
    { label: "Document troubleshooting steps taken", checked: false },
    { label: "Identify root cause", checked: false },
    { label: "Test potential solutions", checked: false },
    { label: "Update stakeholders on progress", checked: false },
]);

const resolvedChecklist = ref([
    { label: "Verify issue is fully resolved", checked: false },
    { label: "Document resolution steps", checked: false },
    { label: "Update knowledge base if applicable", checked: false },
    { label: "Collect feedback from stakeholders", checked: false },
]);

const completedChecklist = ref([
    { label: "Final review of documentation", checked: false },
    { label: "Archive report", checked: false },
    { label: "Send closure notification", checked: false },
    { label: "Update metrics dashboard", checked: false },
]);

const closeModal = () => {
    emit("close");
    resetForm();
};

const resetForm = () => {
    // Reset all checklists
    newChecklist.value.forEach((item) => (item.checked = false));
    underReviewChecklist.value.forEach((item) => (item.checked = false));
    pendingActionChecklist.value.forEach((item) => (item.checked = false));
    resolvedChecklist.value.forEach((item) => (item.checked = false));
    completedChecklist.value.forEach((item) => (item.checked = false));

    notes.value = "";
    uploadedFile.value = null;
};

const getChecklistTitle = () => {
    switch (props.status) {
        case "new":
            return "Initial Verification Checklist";
        case "under_review":
            return "Review Checklist";
        case "pending_action":
            return "Action Checklist";
        case "resolved":
            return "Resolution Checklist";
        case "completed":
            return "Completion Checklist";
        default:
            return "Checklist";
    }
};

const getChecklistItems = computed(() => {
    switch (props.status) {
        case "new":
            return newChecklist.value;
        case "under_review":
            return underReviewChecklist.value;
        case "pending_action":
            return pendingActionChecklist.value;
        case "resolved":
            return resolvedChecklist.value;
        case "completed":
            return completedChecklist.value;
        default:
            return [];
    }
});

const getNotesPlaceholder = () => {
    switch (props.status) {
        case "new":
            return "Add initial assessment notes here...";
        case "under_review":
            return "Add review notes here...";
        case "pending_action":
            return "Add action notes here...";
        case "resolved":
            return "Add resolution details here...";
        case "completed":
            return "Add completion notes here...";
        default:
            return "Add your notes here...";
    }
};

const handleFileUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        uploadedFile.value = file;
    }
};

const removeFile = () => {
    uploadedFile.value = null;
    // Reset the file input
    const fileInput = document.getElementById("file-upload");
    if (fileInput) {
        fileInput.value = "";
    }
};

const submitForm = async () => {
    try {
        const formData = new FormData();
        formData.append("notes", notes.value.trim());

        if (uploadedFile.value) {
            formData.append("img_proof", uploadedFile.value);
        }
        const response = await axios.post(
            `/update-status/${props.concern.id}`,
            formData,
            {
                headers: {
                    "Content-Type": "multipart/form-data",
                },
            }
        );

        closeModal();
        router.visit(window.location.href);
    } catch (error) {
        console.error("Full error object:", error);
    }
};
</script>

<template>
    <div
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
        @click.self="closeModal"
    >
        <div
            class="bg-white dark:bg-[#222831] rounded-lg shadow-lg w-full max-w-md max-h-[90vh] overflow-auto"
        >
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3
                        class="text-lg font-semibold dark:text-[#EEEEEE] text-[#222831]"
                    >
                        Process Report:
                        {{ concern.title || `Report #${concern.id}` }}
                    </h3>
                    <button
                        @click="closeModal"
                        class="dark:text-[#B0B0B0] text-[#4B5660] hover:dark:text-[#EEEEEE] hover:text-[#222831]"
                    >
                        ✕
                    </button>
                </div>

                <div class="space-y-4">
                    <div>
                        <h4
                            class="font-medium mb-2 dark:text-[#EEEEEE] text-[#222831]"
                        >
                            {{ getChecklistTitle() }}
                        </h4>
                        <div class="space-y-2">
                            <div
                                v-for="(item, index) in getChecklistItems"
                                :key="index"
                                class="flex items-start gap-2"
                            >
                                <input
                                    type="checkbox"
                                    :id="`check-${index}`"
                                    v-model="item.checked"
                                    class="rounded border-gray-300 dark:border-gray-700 text-primary focus:ring-primary mt-1"
                                />
                                <label
                                    :for="`check-${index}`"
                                    class="text-sm dark:text-[#EEEEEE] text-[#222831]"
                                    >{{ item.label }}</label
                                >
                            </div>
                        </div>
                    </div>

                    <!-- File Upload - For all statuses -->
                    <div
                        v-if="
                            status === 'pending_action' || status === 'resolved'
                        "
                        class="space-y-2"
                    >
                        <label
                            for="file-upload"
                            class="block text-sm font-medium dark:text-[#EEEEEE] text-[#222831]"
                            >Upload Documents</label
                        >
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
                                    @change="handleFileUpload"
                                />
                            </label>
                        </div>
                        <div
                            v-if="uploadedFile"
                            class="flex items-center gap-2 text-sm p-2 dark:bg-[#3C4053] bg-[#DDE3E7] rounded"
                        >
                            <span>📄</span>
                            <span
                                class="truncate dark:text-[#EEEEEE] text-[#222831]"
                                >{{ uploadedFile.name }}</span
                            >
                            <button
                                @click="removeFile"
                                class="ml-auto dark:text-[#B0B0B0] text-[#4B5660] hover:dark:text-[#EEEEEE] hover:text-[#222831]"
                            >
                                ✕
                            </button>
                        </div>
                    </div>

                    <div>
                        <label
                            for="notes"
                            class="block text-sm font-medium mb-1 dark:text-[#EEEEEE] text-[#222831]"
                            >Notes</label
                        >
                        <textarea
                            id="notes"
                            v-model="notes"
                            rows="4"
                            class="flex w-full rounded-md border dark:border-[#3C4053] border-[#DDE3E7] dark:bg-[#2C3042] bg-white px-3 py-2 text-sm dark:text-[#EEEEEE] text-[#222831] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                            :placeholder="getNotesPlaceholder()"
                        ></textarea>
                    </div>

                    <div class="flex justify-end gap-2 mt-4">
                        <SecondaryButton @click="closeModal">
                            Cancel
                        </SecondaryButton>
                        <PrimaryButton @click="submitForm">
                            Submit
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
