<script setup>

import { Link, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'

const props = defineProps({
    atendimentos: {
        type: Object,
        required: true,
    },

    filtros: {
        type: Object,
        default: () => ({
            busca: '',
        }),
    },
})

const excluir = (id) => {

    if (!confirm('Tem certeza que deseja excluir este atendimento?')) {
        return
    }

    router.delete(`/atendimentos/${id}`)
}

const formatarDataHora = (data) => {

    if (!data) {
        return '-'
    }

    const dataObj = new Date(data)

    return dataObj.toLocaleString('pt-BR', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    })
}

function verAtendimento(id) {
    router.visit(`/atendimentos/${id}`)
}

const busca = ref(props.filtros.busca || '')

function buscar() {
    router.get(
        '/atendimentos',
        {
            busca: busca.value || undefined,
        },
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}

function limparBusca() {
    busca.value = ''

    router.get(
        '/atendimentos',
        {},
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}

</script>

<template>

<AppLayout>

    <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-7xl mx-auto">

            <!-- Cabeçalho -->

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Gestão de atendimentos
                    </p>

                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Atendimentos
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Consulte e gerencie os atendimentos registrados no sistema.
                    </p>

                </div>

                <Link
                    href="/atendimentos/create"
                    class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-95"
                >
                    <span class="text-lg leading-none">+</span>
                     Novo atendimento
                    </Link>
                    
                </div>
                
                <!-- Busca -->
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
    
                <form
                    @submit.prevent="buscar"
                    class="flex flex-col sm:flex-row gap-3"
                >
    
                    <div class="flex-1">
                        <input
                            v-model="busca"
                            type="text"
                            placeholder="Buscar por nome, CPF ou telefone..."
                            class="input input-bordered w-full"
                        />
                    </div>
    
                    <button
                        type="submit"
                        class="btn btn-primary"
                    >
                        Buscar
                    </button>
    
                    <button
                        v-if="busca"
                        type="button"
                        @click="limparBusca"
                        class="btn btn-outline"
                    >
                        Limpar
                    </button>
    
                </form>
    
            </div>
                
            <!-- Card da tabela -->

            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <!-- Cabeçalho da tabela -->

                <div
                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 border-b border-slate-200 p-6">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Lista de atendimentos
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ atendimentos.total }} atendimento(s) registrado(s)
                        </p>

                    </div>

                    <Link
                        href="/atendimentos/hoje"
                        class="btn btn-sm btn-outline"
                    >
                        Atendimentos de hoje
                    </Link>

                </div>



                <!-- Tabela -->

                <div class="overflow-x-auto">

                    <table class="table w-full">

                        <thead>

                            <tr class="bg-slate-50 border-b border-slate-200">

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                                    ID
                                </th>

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                                    Paciente
                                </th>

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                                    Tipo de atendimento
                                </th>

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                                    Data e hora
                                </th>

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">
                                    Responsável
                                </th>

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm text-right">
                                    Ações
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            <!-- Registros -->

                            <tr
                                v-for="atendimento in atendimentos.data"
                                :key="atendimento.id"
                                @click="verAtendimento(atendimento.id)"
                                class="cursor-pointer border-b border-slate-100 hover:bg-slate-50 transition-colors"
                            >

                                <!-- ID -->

                                <td class="px-6 py-5">

                                    <span class="font-medium text-slate-500">
                                        #{{ atendimento.id }}
                                    </span>

                                </td>


                                <!-- Paciente -->

                                <td class="px-6 py-5">

                                    <div class="flex items-center gap-3">

                                        <div
                                            class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold shrink-0"
                                        >
                                            {{
                                                atendimento.paciente?.nome
                                                    ?.charAt(0)
                                                    ?.toUpperCase()
                                            }}
                                        </div>

                                        <div>

                                            <p class="font-semibold text-slate-800">
                                                {{ atendimento.paciente?.nome ?? 'Paciente não informado' }}
                                            </p>

                                            <p class="text-xs text-slate-400 mt-0.5">
                                                CPF: {{ atendimento.paciente?.cpf ?? '-' }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                <!-- Tipo -->

                                <td class="px-6 py-5">

                                    <span
                                        class="inline-flex items-center rounded-lg bg-slate-100 px-3 py-1.5 text-sm font-medium text-slate-700"
                                    >
                                        {{ atendimento.tipo_atendimento?.nome ?? 'Não informado'}}
                                    </span>

                                </td>


                                <!-- Data -->

                                <td class="px-6 py-5">

                                    <p class="text-sm font-medium text-slate-700">
                                        {{ formatarDataHora(atendimento.data_hora) }}
                                    </p>

                                </td>


                                <!-- Usuário -->

                                <td class="px-6 py-5">

                                    <p class="text-sm text-slate-600">
                                        {{ atendimento.usuario?.name ?? 'Não informado' }}
                                    </p>

                                </td>


                                <!-- Ações -->

                                <td class="px-6 py-5">

                                    <div
                                        class="flex justify-end items-center gap-2"
                                    >
                                        <!-- Editar -->

                                        <Link
                                            @click.stop
                                            :href="`/atendimentos/${atendimento.id}/edit`"
                                            class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-950"
                                        >
                                            Editar
                                        </Link>


                                        <!-- Excluir -->

                                        <button      
                                            @click.stop="excluir(atendimento.id)"
                                            class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-red-700 hover:shadow-md active:scale-95"
                                        >
                                            Excluir
                                        </button>

                                    </div>

                                </td>

                            </tr>


                            <!-- Nenhum registro -->

                            <tr v-if="atendimentos.data.length === 0">

                                <td
                                    colspan="6"
                                    class="px-6 py-16"
                                >

                                    <div
                                        class="flex flex-col items-center justify-center text-center"
                                    >

                                        <div
                                            class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-2xl mb-4"
                                        >
                                            ☰
                                        </div>

                                        <h3 class="text-lg font-bold text-slate-800">
                                            Nenhum atendimento cadastrado
                                        </h3>

                                        <p class="text-sm text-slate-500 mt-1 max-w-md">
                                            Ainda não existem atendimentos registrados no sistema.
                                        </p>

                                        <Link
                                            href="/atendimentos/create"
                                            class="btn btn-primary btn-sm mt-5"
                                        >
                                            + Cadastrar primeiro atendimento
                                        </Link>

                                    </div>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <!-- Paginação -->

                <div
                    v-if="props.atendimentos.links?.length"
                    class="flex flex-wrap gap-2 border-t border-slate-200 px-6 py-4"
                >

                    <Link
                        v-for="link in props.atendimentos.links"
                        :key="link.label"
                        :href="link.url ?? '#'"
                        class="rounded-lg px-3 py-2 text-sm transition"
                        :class="[
                            link.active
                                ? 'bg-indigo-600 text-white'
                                : 'bg-slate-100 text-slate-600 hover:bg-slate-200',
                            !link.url
                                ? 'pointer-events-none opacity-50'
                                : ''
                        ]"
                        v-html="link.label"
                    />

                </div>

            </div>

        </div>

    </div>

</AppLayout>

</template>
