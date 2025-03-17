<script setup>
import { ref } from "vue";
import { ChevronDownIcon } from "@heroicons/vue/24/solid";
import NavLink from "@/Components/NavLink.vue";

const props = defineProps({
    title: String,
    icon: Object,
    subLinks: Array,
    link: String,
});

const isOpen = ref(false);

const toggleSubmenu = () => {
    if (props.subLinks?.length) {
        isOpen.value = !isOpen.value;
    }
};
</script>

<template>
    <div class="relative">
        <button
            @click="toggleSubmenu"
            class="flex items-center w-full my-4  ps-4 text-left dark:text-[#B0B0B0] text-[#4B5660] hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
        >
            <component :is="icon" class="w-6 h-6 me-2" />
            <span>{{ title }}</span>
            <ChevronDownIcon
                v-if="props.subLinks?.length"
                class="w-4 h-4 ml-auto me-2 transform transition-transform duration-200"
                :class="{ 'rotate-180': isOpen }"
            />
        </button>

        <Transition name="dropdown" appear>
            <div v-if="isOpen && props.subLinks?.length" class="ml-8 mt-1 overflow-hidden">
                <div class="">
                    <NavLink
                        v-for="sub in props.subLinks"
                        :key="sub.href"
                        :href="sub.href"
                        class="hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors"
                    >
                        {{ sub.label }}
                    </NavLink>
                </div>
            </div>
        </Transition>
    </div>
</template>

<style scoped>
.dropdown-enter-active, .dropdown-leave-active {
    transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
}
.dropdown-enter-from, .dropdown-leave-to {
    max-height: 0;
    opacity: 0;
}
.dropdown-enter-to, .dropdown-leave-from {
    max-height: 200px;
    opacity: 1;
}
</style>
