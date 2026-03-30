

<template>
    <div class="flex flex-col items-center justify-center min-h-[80vh] px-6">
        <div class="w-full max-w-md bg-white dark:bg-[#161615] p-8 rounded-lg shadow-sm border border-[#19140015] dark:border-[#3E3E3A]">
            <h2 class="text-2xl font-semibold mb-6 text-center tracking-tight">Вхід в акаунт</h2>

            <form @submit.prevent="handleLogin" class="space-y-5">
            <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input
                    v-model="form.email"
                    type="email"
                    required
                    class="w-full px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#111110] outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-all"
                    placeholder="your@email.com"
                />
            </div>

            <div>
                <div class="flex justify-between mb-1">
                    <label class="block text-sm font-medium">Пароль</label>
                    <a href="#" class="text-xs text-gray-500 hover:underline">Забули пароль?</a>
                </div>
                <input
                    v-model="form.password"
                    type="password"
                    required
                    class="w-full px-4 py-2 rounded-sm border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#111110] outline-none focus:ring-2 focus:ring-black dark:focus:ring-white transition-all"
                />
            </div>

            <div v-if="error" class="text-red-500 text-sm bg-red-50 dark:bg-red-900/20 p-3 rounded-sm">
                {{ error }}
            </div>

            <button
                type="submit"
            :disabled="loading"
            class="w-full py-2.5 bg-[#1b1b18] dark:bg-[#eeeeec] text-white dark:text-[#1c1c1a] rounded-sm font-medium hover:opacity-90 transition-opacity disabled:opacity-50"
            >
            {{ loading ? 'Вхід...' : 'Увійти' }}
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-[#706f6c]">
        Немає акаунта?
        <router-link to="/test/register" class="text-black dark:text-white font-semibold hover:underline">
            Зареєструватися
        </router-link>
    </p>
</div>
</div>
</template>

<script setup>
    import { ref, reactive } from 'vue'
    import { useRouter } from 'vue-router'
    import axios from 'axios'
    import {VueReCaptcha} from "vue-recaptcha-v3";

    const recaptchaInstance = VueReCaptcha();
    const router = useRouter()
    const loading = ref(false)
    const error = ref(null)

    const form = reactive({
    email: '',
    password: '',
    remember: true
})

const handleLogin = async () => {
    await recaptchaLoaded()
    const token = await executeRecaptcha('login')

    loading.value = true
    error.value = null

    try {
        if (recaptchaInstance) {
            await recaptchaInstance.recaptchaLoaded()
            const token = await recaptchaInstance.executeRecaptcha('login')
            form.captcha_token = token
        }

    await axios.get('/sanctum/csrf-cookie')
    await axios.post('/api/v1/users/login', form)

    // 3. Редирект в случае успеха
    router.push({ name: 'dashboard' })
} catch (err) {
    error.value = err.response?.data?.message || 'Помилка при вході'
} finally {
    loading.value = false
}
}
</script>
