<script setup>

import { computed, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'

const props = defineProps({
    filtros: {
        type: Object,
        required: true
    },

    resumo: {
        type: Object,
        required: true
    },

    porTipo: {
        type: Array,
        default: () => []
    },

    porUsuario: {
        type: Array,
        default: () => []
    },

    porDia: {
        type: Array,
        default: () => []
    }
})

const filtro = reactive({
    data_inicio: props.filtros.data_inicio,
    data_fim: props.filtros.data_fim
})

const gerarRelatorio = () => {

    router.get('/relatorios', {
        data_inicio: filtro.data_inicio,
        data_fim: filtro.data_fim
    }, {
        preserveState: true,
        preserveScroll: true
    })
}

const definirPeriodo = (tipo) => {

    const hoje = new Date()

    if (tipo === 'hoje') {

        const data = hoje.toISOString().split('T')[0]

        filtro.data_inicio = data
        filtro.data_fim = data
    }

    if (tipo === 'mes') {

        const ano = hoje.getFullYear()
        const mes = String(hoje.getMonth() + 1).padStart(2, '0')

        filtro.data_inicio = `${ano}-${mes}-01`

        const ultimoDia = new Date(ano, hoje.getMonth() + 1, 0)
            .getDate()

        filtro.data_fim =
            `${ano}-${mes}-${String(ultimoDia).padStart(2, '0')}`
    }

    if (tipo === 'mes_anterior') {

        const data = new Date(
            hoje.getFullYear(),
            hoje.getMonth() - 1,
            1
        )

        const ano = data.getFullYear()
        const mes = String(data.getMonth() + 1).padStart(2, '0')

        const ultimoDia = new Date(
            ano,
            data.getMonth() + 1,
            0
        ).getDate()

        filtro.data_inicio = `${ano}-${mes}-01`

        filtro.data_fim =
            `${ano}-${mes}-${String(ultimoDia).padStart(2, '0')}`
    }
}

const maiorQuantidadeTipo = computed(() => {

    if (!props.porTipo.length) {
        return 1
    }

    return Math.max(
        ...props.porTipo.map(item => item.quantidade)
    )
})

const porcentagemBarra = (quantidade) => {

    return `${Math.max(
        (quantidade / maiorQuantidadeTipo.value) * 100,
        4
    )}%`
}

const exportarPdf = () => {

    const params = new URLSearchParams({
        data_inicio: filtro.data_inicio,
        data_fim: filtro.data_fim,
    })

    window.open(`/relatorios/pdf?${params.toString()}`, '_blank')
}


</script>

<template>

    <AppLayout>

        <div class="min-h-screen bg-slate-50">


            <!-- Cabeçalho -->

            <div class="mb-8">

                <h1 class="text-3xl font-bold text-slate-800">
                    Relatórios
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Consulte os indicadores e estatísticas dos atendimentos.
                </p>

            </div>



            <!-- Filtros -->

            <div
                class="mb-8 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
            >

                <div class="mb-5">

                    <h2 class="text-lg font-semibold text-slate-800">
                        Período do relatório
                    </h2>

                    <p class="text-sm text-slate-500">
                        Selecione o período que deseja analisar.
                    </p>

                </div>


                <div class="grid gap-4 md:grid-cols-2">

                    <div>

                        <label
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Data inicial
                        </label>

                        <input
                            v-model="filtro.data_inicio"
                            type="date"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >

                    </div>


                    <div>

                        <label
                            class="mb-2 block text-sm font-medium text-slate-700"
                        >
                            Data final
                        </label>

                        <input
                            v-model="filtro.data_fim"
                            type="date"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100"
                        >

                    </div>

                </div>


                <div class="mt-5 flex flex-wrap gap-2">

                    <button
                        type="button"
                        @click="definirPeriodo('hoje')"
                        class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                    >
                        Hoje
                    </button>

                    <button
                        type="button"
                        @click="definirPeriodo('mes')"
                        class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                    >
                        Este mês
                    </button>

                    <button
                        type="button"
                        @click="definirPeriodo('mes_anterior')"
                        class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50"
                    >
                        Mês anterior
                    </button>

                    <div class="flex flex-wrap gap-3">

                    <button
                        type="button"
                        @click="gerarRelatorio"
                        class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-95"
                    >
                        Gerar relatório
                    </button>

                    <button
                        type="button"
                        @click="exportarPdf"
                        class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-red-700 hover:shadow-md active:scale-95"
                    >
                        <span class="text-lg">📄</span>
                        Exportar PDF
                    </button>

                    </div>

                </div>

            </div>


            <!-- RESUMO -->

            <div class="mb-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">


                <!-- Total -->

                <div
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
                >

                    <p class="text-sm font-medium text-slate-500">
                        Total de atendimentos
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-800"> 
                        {{ resumo.total }}
                    </p>

                </div>


                <!-- Pacientes -->

                <div
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
                >

                    <p class="text-sm font-medium text-slate-500">
                        Pacientes atendidos
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ resumo.pacientes }}
                    </p>

                </div>


                <!-- Tipos -->

                <div
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
                >

                    <p class="text-sm font-medium text-slate-500">
                        Tipos utilizados
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ resumo.tipos }}
                    </p>

                </div>


                <!-- Usuários -->

                <div
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
                >

                    <p class="text-sm font-medium text-slate-500">
                        Usuários atendentes
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ resumo.usuarios }}
                    </p>

                </div>

            </div>


            <!-- GRÁFICOS -->

            <div class="mb-8 grid gap-6 xl:grid-cols-2">


                <!-- Atendimentos por dia -->

                <div
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
                >

                    <div class="mb-6">

                        <h2 class="text-lg font-semibold text-slate-800">
                            Atendimentos por dia
                        </h2>

                        <p class="text-sm text-slate-500">
                            Distribuição dos atendimentos no período.
                        </p>

                    </div>


                    <div
                        v-if="porDia.length"
                        class="flex h-64 items-end gap-2 overflow-x-auto border-b border-slate-200 pb-0"
                    >

                        <div
                            v-for="item in porDia"
                            :key="item.data"
                            class="flex min-w-10 flex-1 flex-col items-center justify-end gap-2"
                        >

                            <span
                                class="text-xs font-semibold text-slate-600"
                            >
                                {{ item.quantidade }}
                            </span>

                            <div
                                class="w-full rounded-t-lg bg-indigo-500 transition hover:bg-indigo-600"
                                :style="{
                                    height: `${Math.max(
                                        (item.quantidade / Math.max(...porDia.map(i => i.quantidade))) * 180,
                                        8
                                    )}px`
                                }"
                            ></div>

                            <span class="text-[11px] text-slate-500">
                                {{ item.data }}
                            </span>

                        </div>

                    </div>


                    <div
                        v-else
                        class="flex h-64 items-center justify-center text-sm text-slate-400"
                    >
                        Nenhum atendimento no período.
                    </div>

                </div>


                <!-- Por tipo -->

                <div
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
                >

                    <div class="mb-6">

                        <h2 class="text-lg font-semibold text-slate-800">
                            Atendimentos por tipo
                        </h2>

                        <p class="text-sm text-slate-500">
                            Distribuição percentual dos atendimentos.
                        </p>

                    </div>


                    <div
                        v-if="porTipo.length"
                        class="space-y-5"
                    >

                        <div
                            v-for="tipo in porTipo"
                            :key="tipo.id"
                        >

                            <div class="mb-2 flex items-center justify-between">

                                <span
                                    class="text-sm font-medium text-slate-700"
                                >
                                    {{ tipo.nome }}
                                </span>

                                <span
                                    class="text-sm font-semibold text-slate-800"
                                >
                                    {{ tipo.quantidade }}
                                    <span class="ml-1 text-slate-400">
                                        ({{ tipo.porcentagem }}%)
                                    </span>
                                </span>

                            </div>


                            <div
                                class="h-3 overflow-hidden rounded-full bg-slate-100"
                            >

                                <div
                                    class="h-full rounded-full bg-indigo-500 transition-all"
                                    :style="{
                                        width: porcentagemBarra(tipo.quantidade)
                                    }"
                                ></div>

                            </div>

                        </div>

                    </div>


                    <div
                        v-else
                        class="flex h-64 items-center justify-center text-sm text-slate-400"
                    >
                        Nenhum atendimento no período.
                    </div>

                </div>

            </div>


            <!-- TABELAS -->

            <div class="grid gap-6 xl:grid-cols-2">


                <!-- Por tipo -->

                <div
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                >

                    <div class="border-b border-slate-200 p-6">

                        <h2 class="text-lg font-semibold text-slate-800">
                            Resumo por tipo
                        </h2>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead>

                                <tr class="border-b border-slate-100 bg-slate-50">

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Tipo
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Quantidade
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        %
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr
                                    v-for="tipo in porTipo"
                                    :key="tipo.id"
                                    class="border-b border-slate-100 last:border-0 hover:bg-slate-50"
                                >

                                    <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                        {{ tipo.nome }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm font-semibold text-slate-800">
                                        {{ tipo.quantidade }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm text-slate-500">
                                        {{ tipo.porcentagem }}%
                                    </td>

                                </tr>


                                <tr v-if="!porTipo.length">

                                    <td
                                        colspan="3"
                                        class="px-6 py-10 text-center text-sm text-slate-400"
                                    >
                                        Nenhum dado encontrado.
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>


                <!-- Por usuário -->

                <div
                    class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                >

                    <div class="border-b border-slate-200 p-6">

                        <h2 class="text-lg font-semibold text-slate-800">
                            Atendimentos por usuário
                        </h2>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="w-full">

                            <thead>

                                <tr class="border-b border-slate-100 bg-slate-50">

                                    <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Usuário
                                    </th>

                                    <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                        Atendimentos
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr
                                    v-for="usuario in porUsuario"
                                    :key="usuario.id"
                                    class="border-b border-slate-100 last:border-0 hover:bg-slate-50"
                                >

                                    <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                        {{ usuario.nome }}
                                    </td>

                                    <td class="px-6 py-4 text-right text-sm font-semibold text-slate-800">
                                        {{ usuario.quantidade }}
                                    </td>

                                </tr>


                                <tr v-if="!porUsuario.length">

                                    <td
                                        colspan="2"
                                        class="px-6 py-10 text-center text-sm text-slate-400"
                                    >
                                        Nenhum dado encontrado.
                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </AppLayout>

</template>