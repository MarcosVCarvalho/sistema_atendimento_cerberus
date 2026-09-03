<script setup>

import { computed } from 'vue'
import { Link, usePage, router } from '@inertiajs/vue3'

const page = usePage()

const usuarioLogado = computed(() => page.props.auth.user)

const nomeUsuario = computed(() => {
    return usuarioLogado.value?.name ?? 'Usuário'
})

const emailUsuario = computed(() => {
    return usuarioLogado.value?.email ?? ''
})

const inicialUsuario = computed(() => {
    return nomeUsuario.value.charAt(0).toUpperCase()
})

const nivelUsuario = computed(() => {
    return usuarioLogado.value?.role === 'admin'
        ? 'Administrador'
        : 'Usuário'
})

const sair = () => {
    router.post('/logout')
}

const isActive = (path) => {
    return page.url === path ||
        (path !== '/' && page.url.startsWith(path))
}

</script>

<template>
    <aside
        class="fixed inset-y-0 left-0 z-50 hidden w-64 border-r border-slate-200 bg-white lg:flex lg:flex-col"
    >
        <!-- Logo -->
        <div class="flex h-20 items-center gap-3 border-b border-slate-200 px-6">
            <div
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-lg font-bold text-white shadow-sm"
            >
                C
            </div>

            <div>
                <h1 class="text-lg font-bold text-slate-900">
                    Cerberus
                </h1>

                <p class="text-xs text-slate-500">
                    Controle de Atendimentos
                </p>
            </div>
        </div>

        <!-- Navegação -->
        <nav class="flex-1 space-y-1 px-4 py-6">

            <Link
                href="/"
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition"
                :class="
                    isActive('/')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                "
            >
                <span>Home</span>
            </Link>


            <Link
                href="/pacientes"
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition"
                :class="
                    isActive('/pacientes')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                "
            >
                <span>Pacientes</span>
            </Link>


            <Link
                href="/atendimentos"
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition"
                :class="
                    isActive('/atendimentos')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                "
            >
                <span>Atendimentos</span>
            </Link>


            <Link
                href="/tipos-atendimento"
                class="flex items-center gap-3 rounded-lg px-4 py-3 text-sm font-medium transition"
                :class="
                    isActive('/tipos-atendimento')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                "
            >
                <span>Tipos de atendimento</span>
            </Link>

            <!-- Relatórios -->
            <Link
                v-if="usuarioLogado?.role === 'admin'"
                href="/relatorios"
                :class="[
                    'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition',

                    isActive('/relatorios')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                ]"
            >
                <span>
                    Relatórios
                </span>
            </Link>


            <!-- Auditorias -->
            <Link
                v-if="usuarioLogado?.role === 'admin'"
                href="/auditorias"
                :class="[
                    'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition',

                    isActive('/auditorias')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                ]"
            >
                <span>
                    Auditorias
                </span>
            </Link>

            <!-- Usuários -->
            <Link
                v-if="usuarioLogado?.role === 'admin'"
                href="/usuarios"
                :class="[
                    'flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition',

                    isActive('/usuarios')
                        ? 'bg-indigo-50 text-indigo-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'
                ]"
            >
                <span>
                    Usuários
                </span>
            </Link>

        </nav>

        <!-- Usuário -->

        <div class="border-t border-slate-200 p-4">

            <div
                v-if="usuarioLogado"
                class="flex items-center gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3"
            >

                <!-- Avatar -->

                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-sm font-bold text-indigo-700"
                >
                    {{ inicialUsuario }}
                </div>

                <!-- Informações -->

                <div class="min-w-0 flex-1">

                    <p class="truncate text-sm font-semibold text-slate-900">
                        {{ nomeUsuario }}
                    </p>

                    <p class="truncate text-xs text-slate-500">
                        {{ emailUsuario }}
                    </p>

                    <span
                        class="mt-1 inline-flex rounded-full bg-indigo-100 px-2 py-0.5 text-[11px] font-semibold text-indigo-700"
                    >
                        {{ nivelUsuario }}
                    </span>

                </div>

            </div>

            <!-- Logout -->

            <button
                type="button"
                @click="sair"
                class="mt-3 flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-red-50 hover:text-red-600"
            >
                <span>Sair</span>
            </button>

        </div>
    </aside>
</template>