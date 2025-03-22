<script setup>
import {
    ref,
    watchEffect,
    onMounted,
    onUnmounted,
    markRaw,
    h,
    createApp,
} from "vue";
import CrimeLocationModal from "@/Components/Modal/CrimeLocationModal.vue";
import CrimePopup from "@/Components/Modal/CrimePopup.vue";
import { Map, config, Marker, Popup } from "@maptiler/sdk";
import "@maptiler/sdk/dist/maptiler-sdk.css";

const props = defineProps({
    crimeLocation: Array,
    disableClicks: Boolean,
});

const showModal = ref(false);
const locationData = ref({
    lat: null,
    lng: null,
});

const mapContainer = ref(null);
const map = ref(null);
const markers = ref([]);
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
    addMarkers();
};

const addMarkers = () => {
    markers.value.forEach((marker) => marker.remove());
    markers.value = [];

    if (!props.crimeLocation) return;

    props.crimeLocation.forEach((location) => {
        if (!location.lat || !location.lng) return;

        const popupElement = document.createElement("div");
        const app = createApp(CrimePopup, { location });
        app.mount(popupElement);

        const popup = new Popup().setDOMContent(popupElement);

        const marker = new Marker({ color: "red" })
            .setLngLat([location.lng, location.lat])
            .addTo(map.value)
            .setPopup(popup);

        marker.getElement().addEventListener("click", (event) => {
            event.stopPropagation();
            marker.togglePopup();
        });

        markers.value.push(marker);
    });
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
    locationData.value.lat = lat;
    locationData.value.lng = lng;
    showModal.value = true;
};

watchEffect(() => {
    if (map.value) addMarkers();
});

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
        <CrimeLocationModal
            v-if="showModal"
            :location="locationData"
            @close="showModal = false"
        />
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
