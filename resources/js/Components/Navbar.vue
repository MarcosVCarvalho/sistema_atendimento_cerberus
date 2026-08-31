<script setup>
import { Link, usePage } from '@inertiajs/vue3'

const page = usePage()

const isActive = (url) => {
    return page.url === url
}

const isSectionActive = (url) => {
    return page.url.startsWith(url)
}
</script>

<template>
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-6">

            <div class="flex items-center justify-between h-16">

                <!-- Logo -->
                <div class="flex items-center gap-3">

                    <div
                        class="w-10 h-10 rounded-xl bg-primary text-primary-content
                               flex items-center justify-center font-bold text-lg"
                    >
                        C
                    </div>

                    <div>
                        <h1 class="font-bold text-gray-800 text-lg leading-tight">
                            Cerberus
                        </h1>

                        <p class="text-xs text-gray-500">
                            Controle de Atendimentos
                        </p>
                    </div>

                </div>


                <!-- Navegação -->
                <div class="hidden md:flex items-center gap-2">

                    <!-- Home -->
                    <Link
                        href="/"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition"
                        :class="isActive('/')
                            ? 'bg-primary text-primary-content'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'"
                    >
                        Home
                    </Link>


                    <!-- Pacientes -->
                    <Link
                        href="/pacientes"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition"
                        :class="isSectionActive('/pacientes')
                            ? 'bg-primary text-primary-content'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'"
                    >
                        Pacientes
                    </Link>


                    <!-- Atendimentos -->
                    <Link
                        href="/atendimentos"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition"
                        :class="isSectionActive('/atendimentos')
                            ? 'bg-primary text-primary-content'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'"
                    >
                        Atendimentos
                    </Link>


                    <!-- Tipos de atendimento -->
                    <Link
                        href="/tipos-atendimento"
                        class="px-4 py-2 rounded-lg text-sm font-medium transition"
                        :class="isSectionActive('/tipos-atendimento')
                            ? 'bg-primary text-primary-content'
                            : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900'"
                    >
                        Tipos
                    </Link>

                </div>


                <!-- Área do usuário -->
                <div class="flex items-center gap-3">

                    <div
                        class="hidden sm:flex items-center justify-center
                               w-9 h-9 rounded-full bg-gray-100
                               text-gray-600 font-semibold"
                    >
                        M
                    </div>


                    <!-- Menu mobile -->
                    <div class="dropdown dropdown-end md:hidden">

                        <button
                            tabindex="0"
                            class="btn btn-ghost btn-circle"
                        >
                            ☰
                        </button>

                        <ul
                            tabindex="0"
                            class="menu dropdown-content bg-white rounded-box
                                   z-[1] mt-3 w-52 p-2 shadow-lg border"
                        >

                            <li>
                                <Link href="/">
                                    Home
                                </Link>
                            </li>

                            <li>
                                <Link href="/pacientes">
                                    Pacientes
                                </Link>
                            </li>

                            <li>
                                <Link href="/atendimentos">
                                    Atendimentos
                                </Link>
                            </li>

                            <li>
                                <Link href="/tipos-atendimento">
                                    Tipos de atendimento
                                </Link>
                            </li>

                        </ul>

                    </div>

                </div>

            </div>

        </div>
    </nav>
</template>