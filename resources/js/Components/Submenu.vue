<script setup>
import { ref, watch } from "vue";
import { ChevronDownIcon } from "@heroicons/vue/24/solid";
import NavLink from "@/Components/NavLink.vue";

const isOpen = ref(false);

const props = defineProps({
    title: String,
    iconSolid: [Object, Function],
    iconOutline: [Object, Function],
    subLinks: Array,
});

if (props.subLinks?.some((sub) => sub.active)) {
    isOpen.value = true;
}

const toggleSubmenu = () => {
    if (props.subLinks?.length) {
        isOpen.value = !isOpen.value;
    }
};

watch(
    () => props.subLinks,
    (newSubLinks) => {
        if (newSubLinks?.some((sub) => sub.active)) {
            isOpen.value = true;
        }
    },
    { deep: true }
);
</script>
<template>
    <div class="relative">
        <button
            class="flex items-center w-full justify-between my-4 text-left dark:text-[#B0B0B0] text-[#4B5660] hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors cursor-pointer"
            @click="toggleSubmenu"
        >
            <component
                :is="isOpen ? props.iconSolid : props.iconOutline"
                class="w-6 h-6 me-2"
            />
            {{ title }}
            <ChevronDownIcon
                v-if="props.subLinks?.length"
                class="w-4 h-4 ml-auto me-2 transform transition-transform duration-200"
                :class="{ 'rotate-180': isOpen }"
            />
        </button>
        <Transition name="dropdown" appear>
            <div v-if="isOpen" class="ml-8 mt-1 overflow-hidden">
                <div class="flex flex-col dark:text-[#B0B0B0] text-[#4B5660]">
                    <NavLink
                        v-for="sub in props.subLinks"
                        :key="sub.href"
                        :href="sub.href"
                        :active="sub.active"
                        class="my-1 hover:dark:text-[#6084FF] hover:text-[#3B5FBF] transition-colors cursor-pointer"
                    >
                        {{ sub.label }}
                    </NavLink>
                </div>
            </div>
        </Transition>
    </div>
</template>

<!-- <style scoped>
.dropdown-enter-active,
.dropdown-leave-active {
    transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
}
.dropdown-enter-from,
.dropdown-leave-to {
    max-height: 0;
    opacity: 0;
}
.dropdown-enter-to,
.dropdown-leave-from {
    max-height: 200px;
    opacity: 1;
}
</style> -->
