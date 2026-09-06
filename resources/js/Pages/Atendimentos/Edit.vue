<script setup>

import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layouts/AppLayout.vue'

const props = defineProps({
    atendimento: {
        type: Object,
        required: true,
    },

    pacientes: {
        type: Array,
        default: () => [],
    },

    tipos: {
        type: Array,
        default: () => [],
    },
})

const formatarDataHora = (data) => {
    if (!data) return ''

    return data.replace(' ', 'T').slice(0, 16)
}

const form = reactive({
    paciente_id: props.atendimento.paciente_id ?? '',
    tipo_atendimento_id: props.atendimento.tipo_atendimento_id ?? '',
     data_hora: formatarDataHora(props.atendimento.data_hora),
    observacoes: props.atendimento.observacoes ?? '',
    encaminhamentos: props.atendimento.encaminhamentos ?? '',
})

const erros = ref({})
const carregando = ref(false)

const atualizar = () => {

    carregando.value = true
    erros.value = {}

    router.put(`/atendimentos/${props.atendimento.id}`, form, {

        onError: (errors) => {
            erros.value = errors
        },

        onSuccess: () => {
            // O Controller redireciona para /atendimentos
        },

        onFinish: () => {
            carregando.value = false
        },

    })
}

const voltar = () => {
    router.visit('/atendimentos')
}

</script>

<template>


<AppLayout>

    <div class="min-h-screen bg-slate-50 p-6">

        <div class="max-w-3xl mx-auto">

            <!-- Cabeçalho -->

            <div
                class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6"
            >

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Gestão de atendimentos
                    </p>

                    <h1 class="text-3xl font-bold text-slate-800">
                        Editar Atendimento
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Altere as informações do atendimento #{{ atendimento.id }}
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


            <!-- Formulário -->

            <div
                class="bg-white rounded-2xl shadow-sm border border-slate-200"
            >

                <div class="p-6">

                    <form @submit.prevent="atualizar">

                        <!-- Paciente -->

                        <div class="form-control mb-5">

                            <label class="label">

                                <span
                                    class="label-text font-semibold text-slate-700"
                                >
                                    Paciente *
                                </span>

                            </label>

                            <select
                                v-model="form.paciente_id"
                                class="select select-bordered w-full"
                                :class="{
                                    'select-error': erros.paciente_id
                                }"
                            >

                                <option value="" disabled>
                                    Selecione um paciente
                                </option>

                                <option
                                    v-for="paciente in pacientes"
                                    :key="paciente.id"
                                    :value="paciente.id"
                                >
                                    {{ paciente.nome }}
                                </option>

                            </select>

                            <label
                                v-if="erros.paciente_id"
                                class="label"
                            >

                                <span class="label-text-alt text-error">
                                    {{ erros.paciente_id[0] }}
                                </span>

                            </label>

                        </div>


                        <!-- Tipo de atendimento -->

                        <div class="form-control mb-5">

                            <label class="label">

                                <span
                                    class="label-text font-semibold text-slate-700"
                                >
                                    Tipo de atendimento *
                                </span>

                            </label>

                            <select
                                v-model="form.tipo_atendimento_id"
                                class="select select-bordered w-full"
                                :class="{
                                    'select-error': erros.tipo_atendimento_id
                                }"
                            >

                                <option value="" disabled>
                                    Selecione o tipo de atendimento
                                </option>

                                <option
                                    v-for="tipo in tipos"
                                    :key="tipo.id"
                                    :value="tipo.id"
                                >
                                    {{ tipo.nome }}
                                </option>

                            </select>

                            <label
                                v-if="erros.tipo_atendimento_id"
                                class="label"
                            >

                                <span class="label-text-alt text-error">
                                    {{ erros.tipo_atendimento_id[0] }}
                                </span>

                            </label>

                        </div>

                        <!-- Data e hora -->

                        <div class="form-control mb-5">

                            <label class="label">

                                <span
                                    class="label-text font-semibold text-slate-700"
                                >
                                    Data e hora do atendimento *
                                </span>

                            </label>

                            <input
                                v-model="form.data_hora"
                                type="datetime-local"
                                class="input input-bordered w-full"
                                :class="{
                                    'input-error': erros.data_hora
                                }"
                            />

                            <label
                                v-if="erros.data_hora"
                                class="label"
                            >

                                <span class="label-text-alt text-error">
                                    {{ erros.data_hora[0] }}
                                </span>

                            </label>

                        </div>


                        <!-- Observações -->

                        <div class="form-control mb-5">

                            <label class="label">

                                <span
                                    class="label-text font-semibold text-slate-700"
                                >
                                    Observações
                                </span>

                            </label>

                            <textarea
                                v-model="form.observacoes"
                                class="textarea textarea-bordered w-full min-h-32"
                                placeholder="Digite as observações do atendimento..."
                                :class="{
                                    'textarea-error': erros.observacoes
                                }"
                            ></textarea>

                            <label
                                v-if="erros.observacoes"
                                class="label"
                            >

                                <span class="label-text-alt text-error">
                                    {{ erros.observacoes[0] }}
                                </span>

                            </label>

                        </div>


                        <!-- Encaminhamentos -->

                        <div class="form-control mb-6">

                            <label class="label">

                                <span
                                    class="label-text font-semibold text-slate-700"
                                >
                                    Encaminhamentos
                                </span>

                            </label>

                            <textarea
                                v-model="form.encaminhamentos"
                                class="textarea textarea-bordered w-full min-h-32"
                                placeholder="Digite os encaminhamentos necessários..."
                                :class="{
                                    'textarea-error': erros.encaminhamentos
                                }"
                            ></textarea>

                            <label
                                v-if="erros.encaminhamentos"
                                class="label"
                            >

                                <span class="label-text-alt text-error">
                                    {{ erros.encaminhamentos[0] }}
                                </span>

                            </label>

                        </div>


                        <!-- Botões -->

                        <div
                            class="flex justify-end gap-3 pt-2"
                        >

                            <button
                                type="button"
                                @click="voltar"
                                class="btn btn-ghost"
                            >
                                Cancelar
                            </button>

                            <button
                                type="submit"
                                class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-indigo-700 hover:shadow-md active:scale-95"
                                :disabled="carregando"
                            >

                                <span
                                    v-if="carregando"
                                    class="loading loading-spinner loading-sm"
                                ></span>

                                {{
                                    carregando
                                        ? 'Salvando...'
                                        : 'Salvar alterações'
                                }}

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</AppLayout>
```

</template>
