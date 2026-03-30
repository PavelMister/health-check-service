<template>
    <div class="min-h-screen bg-gray-50 dark:bg-[#0a0a0a] text-gray-900 dark:text-gray-100 font-sans">
        <nav class="p-6 flex justify-end gap-4">
            <router-link to="/test/login" class="hover:underline">Вхід</router-link>
            <router-link to="/test/register" class="px-4 py-2 bg-black text-white dark:bg-white dark:text-black rounded">
                Реєстрація
            </router-link>
        </nav>

        <main>
            <router-view v-slot="{ Component }">
                <transition name="fade" mode="out-in">
                    <component :is="Component" />
                </transition>
            </router-view>
        </main>
    </div>
</template>

<style>
.fade-enter-active, .fade-leave-active {
    transition: opacity 0.2s ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
}
</style>
