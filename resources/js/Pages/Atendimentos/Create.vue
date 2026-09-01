<script setup>

import { reactive, ref } from 'vue'
import { router } from '@inertiajs/vue3'
import AppLayout from '/resources/js/Layout/AppLayout.vue'

const props = defineProps({
    pacientes: {
        type: Array,
        default: () => [],
    },

    tipos: {
        type: Array,
        default: () => [],
    },
})

const form = reactive({
    paciente_id: '',
    tipo_atendimento_id: '',
    observacoes: '',
    encaminhamentos: '',
})

const erros = ref({})
const carregando = ref(false)

const cadastrar = () => {

    carregando.value = true
    erros.value = {}

    router.post('/atendimentos', form, {

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
                class="lex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6">

                <div>

                    <p class="text-sm font-medium text-indigo-600">
                        Gestão de atendimentos
                    </p>

                    <h1 class="text-3xl font-bold text-slate-800">
                        Novo Atendimento
                    </h1>

                    <p class="text-slate-500 mt-1">
                        Registre um novo atendimento no sistema
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

                    <form @submit.prevent="cadastrar">

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
                                class="btn btn-primary"
                                :disabled="carregando"
                            >

                                <span
                                    v-if="carregando"
                                    class="loading loading-spinner loading-sm"
                                ></span>

                                {{
                                    carregando
                                        ? 'Registrando...'
                                        : 'Registrar atendimento'
                                }}

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</AppLayout>


</template>
