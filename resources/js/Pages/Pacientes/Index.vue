<script setup>
import { ref } from 'vue'
import {formatarCpf,formatarTelefone} from '/resources/js/Utils/formacoes.js'
import { router, Link } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'

const props = defineProps({
    pacientes: {
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

const busca = ref(props.filtros.busca || '')

function buscar() {
    router.get(
        '/pacientes',
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
        '/pacientes',
        {},
        {
            preserveState: true,
            preserveScroll: true,
        }
    )
}

function verHistorico(id) {
    router.visit(`/pacientes/${id}/ficha`)
}

function excluir(id) {
    if (!confirm('Tem certeza que deseja excluir este paciente?')) {
        return
    }

    router.delete(`/pacientes/${id}`, {
        preserveScroll: true,
    })
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
                        Gestão de pacientes
                    </p>

                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Pacientes
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Consulte e gerencie os pacientes registrados no sistema.
                    </p>

                </div>

                <Link
                    href="/pacientes/create"
                    class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-95"
                >
                    <span class="text-lg leading-none">+</span>
                     Novo paciente
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
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <!-- Cabeçalho da tabela -->
                <div class="px-6 py-4 border-b border-slate-200">

                    <div>

                        <h2 class="font-semibold text-slate-900">
                            Pacientes cadastrados
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            {{ pacientes.total }} paciente(s) registrado(s)
                        </p>

                    </div>

                </div>


                <!-- Tabela -->
                <div class="overflow-x-auto">

                    <table class="table w-full">

                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">

                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">ID</th>
                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">Nome</th>
                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">CPF</th>
                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">Telefone</th>
                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm">WhatsApp</th>
                                <th class="px-6 py-4 text-slate-500 font-semibold text-sm text-right">Ações</th>

                            </tr>
                        </thead>


                        <tbody>

                        <!-- Registros -->

                        <tr
                            v-for="paciente in pacientes.data"
                            :key="paciente.id"
                            @click="verHistorico(paciente.id)"
                            class="cursor-pointer border-b border-slate-100 hover:bg-slate-50 transition-colors"
                        >

                            <!-- ID -->

                            <td class="px-5 py-4 w-24 text-slate-500 font-medium">
                                #{{ paciente.id }}
                            </td>


                            <!-- Paciente -->

                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    <!-- Inicial -->

                                    <div
                                        class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold shrink-0"
                                    >
                                        {{ paciente.nome.charAt(0).toUpperCase() }}
                                    </div>

                                    <!-- Informações -->

                                    <div>

                                        <p class="font-semibold text-slate-800">
                                            {{ paciente.nome }}
                                        </p>

                                        <p class="text-xs text-slate-400 mt-0.5">
                                            Paciente
                                        </p>

                                    </div>

                                </div>

                            </td>


                            <!-- CPF -->

                            <td class="px-5 py-4">

                                <span class="text-sm text-slate-600">
                                    {{ formatarCpf(paciente.cpf) }}
                                </span>

                            </td>


                            <!-- Telefone -->

                            <td class="px-5 py-4">

                                <span
                                    class="text-sm text-slate-600"
                                >
                                    {{ formatarTelefone(paciente.telefone) || '-' }}
                                </span>

                            </td>


                            <!-- WhatsApp -->

                            <td class="px-5 py-4">

                                <span
                                    class="text-sm text-slate-600"
                                >
                                    {{ formatarTelefone(paciente.whatsapp) || '-' }}
                                </span>

                            </td>


                            <!-- Ações -->

                            <td class="px-5 py-4 w-64">

                                <div class="flex justify-end items-center gap-1">

                                    <!-- Realizar atendimento -->

                                    <Link
                                        @click.stop
                                        :href="`/atendimentos/create?paciente_id=${paciente.id}`"
                                        class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-950"
                                    >
                                        Atendimento
                                    </Link>


                                    <!-- Editar -->

                                    <Link
                                        @click.stop
                                        :href="`/pacientes/${paciente.id}/edit`"
                                        class="inline-flex items-center rounded-lg bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-950"
                                    >
                                        Editar
                                    </Link>


                                    <!-- Excluir -->

                                    <button
                                        @click.stop="excluir(paciente.id)"
                                        class="inline-flex items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-red-700 hover:shadow-md active:scale-95"
                                    >
                                        Excluir
                                    </button>

                                </div>

                            </td>

                        </tr>


                        <!-- Nenhum paciente -->

                        <tr v-if="pacientes.data.length === 0">

                            <td
                                colspan="6"
                                class="px-6 py-16"
                            >

                                <div class="flex flex-col items-center justify-center text-center">

                                    <div
                                        class="w-16 h-16 rounded-2xl bg-slate-100 flex items-center justify-center text-2xl mb-4"
                                    >
                                        👤
                                    </div>

                                    <h3 class="text-lg font-bold text-slate-800">
                                        Nenhum paciente encontrado
                                    </h3>

                                    <p class="text-sm text-slate-500 mt-1 max-w-md">
                                        Não encontramos pacientes para a busca realizada.
                                    </p>

                                    <Link
                                        href="/pacientes/create"
                                        class="btn btn-primary btn-sm mt-5"
                                    >
                                        + Cadastrar paciente
                                    </Link>

                                </div>

                            </td>

                        </tr>

                        </tbody>

                    </table>

                </div>


                <!-- Paginação -->
                <div
                    v-if="props.pacientes.links?.length"
                    class="flex flex-wrap gap-2 border-t border-slate-200 px-6 py-4"
                >

                    <Link
                        v-for="link in props.pacientes.links"
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