<script setup>
import AppLayout from '/resources/js/Layouts/AppLayout.vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
    auditorias: {
        type: Object,
        required: true
    }
})

const formatarData = (data) => {
    if (!data) return '-'

    return new Date(data).toLocaleString('pt-BR')
}

const classeAcao = (acao) => {
    switch (acao) {
        case 'criado':
            return 'bg-emerald-100 text-emerald-700'

        case 'atualizado':
            return 'bg-amber-100 text-amber-700'

        case 'excluído':
            return 'bg-red-100 text-red-700'

        case 'relatório':
            return 'bg-indigo-100 text-indigo-700'

        default:
            return 'bg-slate-100 text-slate-700'
    }
}
</script>

<template>
    <AppLayout>

        <div class="space-y-6">

            <!-- Cabeçalho -->
            <div class="flex items-center justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-slate-800">
                        Auditorias
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Histórico das ações realizadas no sistema.
                    </p>
                </div>

            </div>


            <!-- Tabela -->
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead class="border-b border-slate-200 bg-slate-50">

                            <tr>

                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">
                                    Usuário
                                </th>

                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">
                                    Ação
                                </th>

                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">
                                    Entidade
                                </th>

                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">
                                    Descrição
                                </th>

                                <th class="px-6 py-4 text-sm font-semibold text-slate-600">
                                    Data
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr
                                v-for="auditoria in props.auditorias.data"
                                :key="auditoria.id"
                                class="border-b border-slate-100 transition-colors hover:bg-slate-50"
                            >

                                <!-- Usuário -->
                                <td class="px-6 py-4">

                                    <div class="font-medium text-slate-800">
                                        {{ auditoria.usuario?.name ?? 'Sistema' }}
                                    </div>

                                </td>


                                <!-- Ação -->
                                <td class="px-6 py-4">

                                    <span
                                        class="inline-flex rounded-full px-3 py-1 text-xs font-semibold"
                                        :class="classeAcao(auditoria.acao)"
                                    >
                                        {{ auditoria.acao }}
                                    </span>

                                </td>


                                <!-- Entidade -->
                                <td class="px-6 py-4">

                                    <span class="text-sm font-medium text-slate-700">
                                        {{ auditoria.entidade }}
                                    </span>

                                    <span
                                        v-if="auditoria.entidade_id"
                                        class="ml-1 text-xs text-slate-400"
                                    >
                                        #{{ auditoria.entidade_id }}
                                    </span>

                                </td>


                                <!-- Descrição -->
                                <td class="max-w-md px-6 py-4">

                                    <p class="text-sm text-slate-600">
                                        {{ auditoria.descricao }}
                                    </p>

                                </td>


                                <!-- Data -->
                                <td class="whitespace-nowrap px-6 py-4">

                                    <span class="text-sm text-slate-500">
                                        {{ formatarData(auditoria.created_at) }}
                                    </span>

                                </td>

                            </tr>


                            <!-- Nenhum registro -->
                            <tr v-if="!props.auditorias.data.length">

                                <td
                                    colspan="5"
                                    class="px-6 py-12 text-center text-sm text-slate-500"
                                >
                                    Nenhuma auditoria registrada.
                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>


                <!-- Paginação -->
                <div
                    v-if="props.auditorias.links?.length"
                    class="flex flex-wrap gap-2 border-t border-slate-200 px-6 py-4"
                >

                    <Link
                        v-for="link in props.auditorias.links"
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

    </AppLayout>
</template>