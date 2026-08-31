<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const isActive = (path) => {
    if (path === '/') {
        return page.url === '/'
    }

    return page.url.startsWith(path)
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
                <span>Dashboard</span>
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
        </nav>

        <!-- Usuário -->
        <div class="border-t border-slate-200 p-4">
            <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">
                <div
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 font-semibold text-indigo-700"
                >
                    M
                </div>

                <div class="min-w-0">
                    <p class="truncate text-sm font-semibold text-slate-900">
                        Marcos
                    </p>

                    <p class="text-xs text-slate-500">
                        Administrador
                    </p>
                </div>
            </div>
        </div>
    </aside>
</template>