# 🏥 Sistema de Controle de Atendimentos

Sistema web desenvolvido para gerenciamento de pacientes e atendimentos, permitindo centralizar informações, registrar atendimentos, consultar históricos e gerar relatórios para acompanhamento da demanda.

O projeto foi desenvolvido com foco em organização, segurança, rastreabilidade das operações e facilidade de uso para equipes responsáveis pelo atendimento.

---

## 📋 Sobre o projeto

O Sistema de Controle de Atendimentos tem como objetivo centralizar o gerenciamento de pacientes e seus respectivos atendimentos em uma única aplicação.

A solução permite:

- cadastrar e gerenciar pacientes;
- registrar atendimentos;
- consultar o histórico de cada paciente;
- cadastrar tipos de atendimento;
- gerenciar usuários e permissões;
- acompanhar indicadores através de relatórios;
- filtrar atendimentos por período, cidade e bairro;
- exportar relatórios em PDF;
- registrar ações importantes realizadas no sistema através de auditoria.

O sistema foi desenvolvido utilizando Laravel no backend e Vue.js com Inertia.js no frontend.

---

## 🎯 Objetivos

### Objetivo principal

Centralizar o controle de pacientes e atendimentos, reduzindo a dependência de processos manuais, planilhas e registros descentralizados.

### Objetivos específicos

- Facilitar o cadastro de pacientes;
- Permitir localização rápida de pacientes;
- Manter o histórico de atendimentos;
- Organizar os tipos de atendimento;
- Controlar usuários e permissões;
- Gerar indicadores para acompanhamento da demanda;
- Registrar ações realizadas no sistema;
- Garantir maior integridade e segurança dos dados.

---

## 🔄 Fluxo do atendimento

O sistema foi estruturado considerando o seguinte fluxo:

```text
Cadastrar
    ↓
Atender
    ↓
Registrar
    ↓
Consultar
