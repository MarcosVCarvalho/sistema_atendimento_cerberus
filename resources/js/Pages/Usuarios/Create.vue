<script setup>

import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'

const form = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: 'user',
})

const erros = ref({})
const carregando = ref(false)

const cadastrar = () => {

    carregando.value = true
    erros.value = {}

    router.post('/usuarios', form, {
        preserveScroll: true,

        onError: (errors) => {
            erros.value = errors
        },

        onFinish: () => {
            carregando.value = false
        },
    })
}
const voltar = () => {
    router.visit('/usuarios')
}

</script>

<template>

    <AppLayout>

        <div class="min-h-screen bg-slate-50 p-6">
        <div class="max-w-3xl mx-auto">

            <!-- Cabeçalho -->
            <div class="lex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">

                <div>
                    <p class="text-sm font-medium text-indigo-600">
                        Novo Tipo de Atendimento
                    </p>
                    <h1 class="text-3xl font-bold text-slate-800">
                        Novo usuário
                    </h1>
                    <p class="text-slate-500 mt-1">
                        Cadastre um novo usuário no sistema.
                    </p>
                </div>
                <button
                    type="button"
                    @click="voltar"
                    class="btn btn-outline"
                >
                    ← Voltar
                </button>
                
            </div>


            <!-- Formulário -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">

                <form @submit.prevent="cadastrar" class="space-y-5">

                    <!-- Nome -->
                    <div>

                        <label
                            for="name"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            Nome
                        </label>

                        <input
                            id="name"
                            v-model="form.name"
                            type="text"
                            autocomplete="name"
                            placeholder="Digite o nome do usuário"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                            :class="{ 'border-red-400': erros.name }"
                        >

                        <p
                            v-if="erros.name"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ erros.name }}
                        </p>

                    </div>


                    <!-- E-mail -->
                    <div>

                        <label
                            for="email"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            E-mail
                        </label>

                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            autocomplete="email"
                            placeholder="usuario@cerberus.com"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                            :class="{ 'border-red-400': erros.email }"
                        >

                        <p
                            v-if="erros.email"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ erros.email }}
                        </p>

                    </div>


                    <!-- Senha -->
                    <div>

                        <label
                            for="password"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            Senha
                        </label>

                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Mínimo de 8 caracteres"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                            :class="{ 'border-red-400': erros.password }"
                        >

                        <p
                            v-if="erros.password"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ erros.password }}
                        </p>

                    </div>


                    <!-- Confirmar senha -->
                    <div>

                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            Confirmar senha
                        </label>

                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Digite a senha novamente"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                        >

                    </div>


                    <!-- Nível de acesso -->
                    <div>

                        <label
                            for="role"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            Nível de acesso
                        </label>

                        <select
                            id="role"
                            v-model="form.role"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl bg-white outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                            :class="{ 'border-red-400': erros.role }"
                        >

                            <option value="user">
                                Usuário
                            </option>

                            <option value="admin">
                                Administrador
                            </option>

                        </select>

                        <p
                            v-if="erros.role"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ erros.role }}
                        </p>

                    </div>


                    <!-- Ações -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">

                        <a
                            href="/usuarios"
                            class="px-5 py-2.5 border border-slate-300 text-slate-900 rounded-xl hover:bg-slate-50 transition"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            :disabled="carregando"
                            class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-95"
                        >

                            <span v-if="carregando">
                                Cadastrando...
                            </span>

                            <span v-else>
                                Cadastrar usuário
                            </span>

                        </button>

                    </div>

                </form>

            </div>

        </div>
        </div>

    </AppLayout>

</template>