<script setup>

import { router, Link } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'

defineProps({
    usuarios: {
        type: Array,
        default: () => [],
    },
})

const excluir = (usuario) => {

    if (!confirm(`Deseja realmente excluir o usuário "${usuario.name}"?`)) {
        return
    }

    router.delete(`/usuarios/${usuario.id}`)
}

</script>

<template>

    <AppLayout>

        <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-7xl mx-auto">

            <!-- Cabeçalho -->
            <div class="lex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

                <div>
                    <p class="text-sm font-medium text-indigo-600">
                        Gestão de Usuários
                    </p>

                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Usuários
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Gerencie os usuários e seus níveis de acesso.
                    </p>

                </div>

                <Link
                    href="/usuarios/create"
                    class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-95"
                >
                    <span class="text-lg leading-none">+</span>
                    Novo usuário
                </Link>

            </div>

            <!-- Resumo -->
            <div class="w-full mb-6">

                <!-- Total -->
                <div class="bg-white rounded-xl border border-slate-200 p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <div>

                            <p class="text-sm font-medium text-slate-500">
                                Total cadastrados
                            </p>

                            <p class="text-2xl font-bold text-slate-800 mt-1">
                                {{ usuarios.length }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>
            <!-- Tabela -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">

                <table class="w-full">

                    <thead class="bg-slate-50 border-b border-slate-200">

                        <tr>

                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">
                                Nome
                            </th>

                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">
                                E-mail
                            </th>

                            <th class="text-left px-6 py-4 text-sm font-semibold text-slate-600">
                                Nível
                            </th>

                            <th class="text-right px-6 py-4 text-sm font-semibold text-slate-600">
                                Ações
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <tr
                            v-for="usuario in usuarios"
                            :key="usuario.id"
                            class="border-b border-slate-100 last:border-0 hover:bg-slate-50"
                        >

                            <td class="px-6 py-4">

                                <div class="font-medium text-slate-800">
                                    {{ usuario.name }}
                                </div>

                            </td>

                            <td class="px-6 py-4 text-slate-600">
                                {{ usuario.email }}
                            </td>

                            <td class="px-6 py-4">

                                <span
                                    v-if="usuario.role === 'admin'"
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-700"
                                >
                                    Administrador
                                </span>

                                <span
                                    v-else
                                    class="px-3 py-1 text-xs font-semibold rounded-full bg-slate-100 text-slate-600"
                                >
                                    Usuário
                                </span>

                            </td>

                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        :href="`/usuarios/${usuario.id}/edit`"
                                        class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-950""
                                    >
                                        Editar
                                    </a>

                                    <button
                                        @click="excluir(usuario)"
                                        class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-red-700 hover:shadow-md active:scale-95"
                                    >
                                        Excluir
                                    </button>

                                </div>

                            </td>

                        </tr>

                        <tr v-if="usuarios.length === 0">

                            <td
                                colspan="4"
                                class="px-6 py-10 text-center text-slate-500"
                            >
                                Nenhum usuário cadastrado.
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>
        </div>

    </AppLayout>

</template>