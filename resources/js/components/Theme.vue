<template>
    <button @click="toggleDark()">
        <em v-if="isDark" class="pi pi-sun"></em>
        <em v-else class="pi pi-moon"></em>
    </button>
</template>

<script setup>
import { useDark, useToggle } from '@vueuse/core'

const isDark = useDark()
const toggleDark = useToggle(isDark)
</script>
