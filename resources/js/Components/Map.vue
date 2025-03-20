<script setup>
import { ref, watchEffect, onMounted, onUnmounted, markRaw } from "vue";
import { Map, config } from "@maptiler/sdk";
import "@maptiler/sdk/dist/maptiler-sdk.css";

const props = defineProps({
    disableClicks: Boolean,
});

const handleClick = () => {
    if (props.disableClicks) {
        console.log("Click event disabled on this page.");
        return;
    }
    console.log("Function executed!");
};

const mapContainer = ref(null);
const map = ref(null);
const darkMode = ref(window.matchMedia("(prefers-color-scheme: dark)").matches);
const API_KEY = import.meta.env.VITE_MAPTILER_API_KEY;

const mapStyles = {
    light: "https://api.maptiler.com/maps/streets-v2/style.json?key=PNHeovVDmztHH8OxssW9",
    dark: "https://api.maptiler.com/maps/streets-v2-dark/style.json?key=PNHeovVDmztHH8OxssW9",
};

const initializeMap = () => {
    config.apiKey = API_KEY;
    const initialState = { lng: 120.3333, lat: 16.0433, zoom: 16 };

    map.value = markRaw(
        new Map({
            container: mapContainer.value,
            style: darkMode.value ? mapStyles.dark : mapStyles.light,
            center: [initialState.lng, initialState.lat],
            zoom: initialState.zoom,
            navigationControl: false,
            geolocateControl: false,
            fullscreenControl: false,
        })
    );
    map.value.on("click", getLatLng);
};

const getLatLng = (event) => {
    if (props.disableClicks) {
        return;
    }
    if (!event.lngLat) {
        console.error("Event does not contain lngLat data:", event);
        return;
    }
    const { lng, lat } = event.lngLat;
    console.log(
        `You clicked the map at latitude: ${lat} and longitude: ${lng}`
    );
};

onMounted(() => {
    initializeMap();

    const mediaQuery = window.matchMedia("(prefers-color-scheme: dark)");
    const updateTheme = (e) => {
        darkMode.value = e.matches;
        map.value.setStyle(darkMode.value ? mapStyles.dark : mapStyles.light);
    };

    mediaQuery.addEventListener("change", updateTheme);
});

onUnmounted(() => {
    if (map.value) {
        map.value.off("click", getLatLng);
        map.value.remove();
    }
});
</script>

<template>
    <div class="map-wrap">
        <div class="map" ref="mapContainer"></div>
    </div>
</template>

<style scoped>
.map-wrap {
    position: relative;
    width: 100%;
    height: 100%;
}

.map {
    width: 100%;
    height: 100%;
}
</style>
