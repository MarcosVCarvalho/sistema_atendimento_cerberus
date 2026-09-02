<script setup>

import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'

const props = defineProps({
    usuario: {
        type: Object,
        required: true,
    },
})

const form = reactive({
    name: props.usuario.name ?? '',
    email: props.usuario.email ?? '',
    password: '',
    password_confirmation: '',
    role: props.usuario.role ?? 'user',
})

const erros = ref({})
const carregando = ref(false)

const atualizar = () => {

    carregando.value = true
    erros.value = {}

    router.put(`/usuarios/${props.usuario.id}`, form, {

        preserveScroll: true,

        onError: (errors) => {
            erros.value = errors
        },

        onFinish: () => {
            carregando.value = false
        },

    })
}

</script>

<template>

    <AppLayout>

        <div class="max-w-3xl mx-auto px-4 py-8">

            <!-- Cabeçalho -->
            <div class="mb-6">

                <a
                    href="/usuarios"
                    class="text-sm text-slate-500 hover:text-slate-700"
                >
                    ← Voltar para usuários
                </a>

                <h1 class="text-2xl font-bold text-slate-800 mt-3">
                    Editar usuário
                </h1>

                <p class="text-slate-500 mt-1">
                    Altere os dados e o nível de acesso do usuário.
                </p>

            </div>


            <!-- Formulário -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6">

                <form @submit.prevent="atualizar" class="space-y-5">

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


                    <!-- Nova senha -->
                    <div>

                        <label
                            for="password"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            Nova senha
                        </label>

                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Deixe vazio para manter a senha atual"
                            class="w-full px-4 py-3 border border-slate-300 rounded-xl outline-none focus:border-slate-500 focus:ring-2 focus:ring-slate-200"
                            :class="{ 'border-red-400': erros.password }"
                        >

                        <p class="text-xs text-slate-500 mt-1">
                            Preencha somente se quiser alterar a senha.
                        </p>

                        <p
                            v-if="erros.password"
                            class="text-sm text-red-600 mt-1"
                        >
                            {{ erros.password }}
                        </p>

                    </div>


                    <!-- Confirmar nova senha -->
                    <div>

                        <label
                            for="password_confirmation"
                            class="block text-sm font-medium text-slate-700 mb-2"
                        >
                            Confirmar nova senha
                        </label>

                        <input
                            id="password_confirmation"
                            v-model="form.password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            placeholder="Digite a nova senha novamente"
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
                            class="px-5 py-3 border border-slate-300 text-slate-900 rounded-xl hover:bg-slate-100 transition"
                        >
                            Cancelar
                        </a>

                        <button
                            type="submit"
                            :disabled="carregando"
                            class="px-5 py-3 rounded-xl bg-indigo-600 text-white font-semibold hover:bg-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                        >
                            {{ carregando ? 'Salvando...' : 'Salvar alterações' }}
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </AppLayout>

</template>