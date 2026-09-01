<script setup>

import { router, Link } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layout/AppLayout.vue'

const props = defineProps({
    atendimento: {
        type: Object,
        required: true,
    },
})

const voltar = () => {
    router.visit('/atendimentos')
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

</script>

<template>


<AppLayout>

    <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-4xl mx-auto">

            <!-- Cabeçalho -->

            <div
                class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6"
            >

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Gestão de atendimentos
                    </p>

                    <h1 class="mt-1 text-3xl font-bold text-slate-900">
                        Atendimento #{{ atendimento.id }}
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Visualização dos dados do atendimento.
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


            <!-- Card principal -->

            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden"
            >

                <!-- Cabeçalho do atendimento -->

                <div
                    class="p-6 border-b border-slate-200 bg-slate-50"
                >

                    <div class="flex items-center gap-4">

                        <!-- Avatar -->

                        <div
                            class="w-14 h-14 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold shrink-0"
                        >
                            {{
                                atendimento.paciente?.nome
                                    ?.charAt(0)
                                    ?.toUpperCase()
                            }}
                        </div>

                        <div>

                            <p class="text-xs font-medium text-slate-400 uppercase tracking-wide">
                                Paciente
                            </p>

                            <h2 class="text-xl font-bold text-slate-800">
                                {{ atendimento.paciente?.nome ?? 'Paciente não informado' }}
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Atendimento #{{ atendimento.id }}
                            </p>

                        </div>

                    </div>

                </div>


                <!-- Informações -->

                <div class="p-6">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Paciente -->

                        <div>

                            <p class="text-sm font-medium text-slate-500 mb-1">
                                Paciente
                            </p>

                            <p class="text-base font-semibold text-slate-800">
                                {{ atendimento.paciente?.nome ?? 'Não informado' }}
                            </p>

                        </div>


                        <!-- CPF -->

                        <div>

                            <p class="text-sm font-medium text-slate-500 mb-1">
                                CPF
                            </p>

                            <p class="text-base font-semibold text-slate-800">
                                {{ atendimento.paciente?.cpf ?? 'Não informado' }}
                            </p>

                        </div>


                        <!-- Tipo -->

                        <div>

                            <p class="text-sm font-medium text-slate-500 mb-1">
                                Tipo de atendimento
                            </p>

                            <span
                                class="inline-flex items-center rounded-lg bg-indigo-50 px-3 py-1.5 text-sm font-semibold text-indigo-700"
                            >
                                {{ atendimento.tipo_atendimento?.nome ?? 'Não informado' }}
                            </span>

                        </div>


                        <!-- Data e hora -->

                        <div>

                            <p class="text-sm font-medium text-slate-500 mb-1">
                                Data e hora
                            </p>

                            <p class="text-base font-semibold text-slate-800">
                                {{ formatarDataHora(atendimento.data_hora) }}
                            </p>

                        </div>


                        <!-- Telefone -->

                        <div>

                            <p class="text-sm font-medium text-slate-500 mb-1">
                                Telefone
                            </p>

                            <p class="text-base font-semibold text-slate-800">
                                {{ atendimento.paciente?.telefone ?? 'Não informado' }}
                            </p>

                        </div>


                        <!-- WhatsApp -->

                        <div>

                            <p class="text-sm font-medium text-slate-500 mb-1">
                                WhatsApp
                            </p>

                            <p class="text-base font-semibold text-slate-800">
                                {{ atendimento.paciente?.whatsapp ?? 'Não informado' }}
                            </p>

                        </div>

                    </div>


                    <!-- Observações -->

                    <div class="mt-8 pt-6 border-t border-slate-200">

                        <p class="text-sm font-medium text-slate-500 mb-2">
                            Observações
                        </p>

                        <div
                            class="rounded-xl bg-slate-50 border border-slate-200 p-4"
                        >

                            <p
                                v-if="atendimento.observacoes"
                                class="text-sm leading-6 text-slate-700 whitespace-pre-line"
                            >
                                {{ atendimento.observacoes }}
                            </p>

                            <p
                                v-else
                                class="text-sm text-slate-400 italic"
                            >
                                Nenhuma observação registrada.
                            </p>

                        </div>

                    </div>


                    <!-- Encaminhamentos -->

                    <div class="mt-6">

                        <p class="text-sm font-medium text-slate-500 mb-2">
                            Encaminhamentos
                        </p>

                        <div
                            class="rounded-xl bg-slate-50 border border-slate-200 p-4"
                        >

                            <p
                                v-if="atendimento.encaminhamentos"
                                class="text-sm leading-6 text-slate-700 whitespace-pre-line"
                            >
                                {{ atendimento.encaminhamentos }}
                            </p>

                            <p
                                v-else
                                class="text-sm text-slate-400 italic"
                            >
                                Nenhum encaminhamento registrado.
                            </p>

                        </div>

                    </div>


                    <!-- Responsável -->

                    <div class="mt-6">

                        <p class="text-sm font-medium text-slate-500 mb-2">
                            Responsável pelo atendimento
                        </p>

                        <div
                            class="rounded-xl bg-slate-50 border border-slate-200 p-4"
                        >

                            <p
                                v-if="atendimento.usuario"
                                class="text-sm font-semibold text-slate-700"
                            >
                                {{ atendimento.usuario.name }}
                            </p>

                            <p
                                v-else
                                class="text-sm text-slate-400 italic"
                            >
                                Usuário não informado.
                            </p>

                        </div>

                    </div>


                    <!-- Ações -->

                    <div
                        class="flex justify-end gap-3 mt-8 pt-6 border-t border-slate-200"
                    >

                        <button
                            type="button"
                            @click="voltar"
                            class="btn btn-ghost"
                        >
                            Voltar
                        </button>

                        <Link
                            :href="`/atendimentos/${atendimento.id}/edit`"
                            class="btn btn-primary"
                        >
                            Editar atendimento
                        </Link>

                    </div>

                </div>

            </div>

        </div>

    </div>

</AppLayout>
```

</template>
