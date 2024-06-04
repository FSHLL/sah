<template>
    <el-switch
        v-model="isDark"
        :active-action-icon="moon"
        :inactive-action-icon="sunny"
    />
</template>

<script setup>
import { useDark, useToggle } from '@vueuse/core'
import { Moon, Sunny } from '@element-plus/icons-vue'

const isDark = useDark()
const toggleDark = useToggle(isDark)
const moon = Moon
const sunny = Sunny
</script>
