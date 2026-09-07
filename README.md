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


Cadastrar
    ↓
Atender
    ↓
Registrar
    ↓
Consultar

## 1. Cadastrar

O paciente é cadastrado no sistema com suas informações pessoais e endereço.

## 2. Atender

Um atendimento é registrado para o paciente, permitindo selecionar o tipo de atendimento e a data.

## 3. Registrar

São armazenadas informações como:

observações;
encaminhamentos;
profissional responsável;
data e hora.
## 4. Consultar

O histórico do paciente pode ser consultado posteriormente, permitindo visualizar seus atendimentos anteriores.

⚙️ Funcionalidades
👤 Pacientes
Cadastro de pacientes;
Edição de pacientes;
Consulta de pacientes;
Busca por nome;
Busca por CPF;
Busca por telefone;
Busca por WhatsApp;
Validação matemática do CPF;
Controle de CPF duplicado;
Cadastro de endereço;
Informações separadas de:
Rua;
Bairro;
Cidade;
Histórico de atendimentos;
Exclusão lógica através de Soft Delete.
🏥 Atendimentos
Cadastro de atendimento;
Seleção do paciente;
Seleção do tipo de atendimento;
Definição da data e hora;
Registro de observações;
Registro de encaminhamentos;
Identificação do usuário responsável;
Edição de atendimentos;
Consulta de atendimentos;
Busca por paciente;
Busca por tipo de atendimento;
Busca por CPF;
Busca por observações;
Busca por encaminhamentos;
Busca por data.
## 📋 Tipos de atendimento

O sistema permite administrar os tipos de atendimento disponíveis.

Exemplos:

Odontologia;
Cardiologia;
Oftalmologia;
Dermatologia;
Clínico Geral;
Fisioterapia;
Nutrição;
Gastroenterologia;
Cirurgia Plástica;
Otorrinolaringologia.

Os tipos podem ser:

cadastrados;
editados;
consultados;
removidos logicamente.
## 👥 Usuários

O sistema possui gerenciamento de usuários com controle de permissões.

Administrador

Possui acesso a funcionalidades administrativas, incluindo:

gerenciamento de usuários;
relatórios;
auditoria;
gerenciamento dos demais recursos do sistema.
Usuário comum

Possui acesso às funcionalidades operacionais necessárias para realizar os atendimentos, sem acesso às áreas administrativas restritas.

## 🔐 Segurança

A aplicação possui diferentes mecanismos de segurança e controle de acesso.

Autenticação

As funcionalidades do sistema são protegidas por autenticação.

Usuários precisam estar autenticados para acessar as áreas protegidas.

Autorização

O sistema utiliza Middleware e Policies para controlar permissões.

A aplicação diferencia:

Autenticação
"Quem é o usuário?"

        ↓

Autorização
"O que esse usuário pode fazer?"

O acesso administrativo é protegido através de middleware específico.

Além disso, Policies são utilizadas para autorização de ações sobre recursos.

## 🗑️ Soft Delete

Recursos importantes utilizam exclusão lógica.

Ao invés de remover imediatamente um registro do banco de dados, o sistema registra a data de exclusão.

Isso permite preservar os dados e possibilita futuras funcionalidades de recuperação.

## 📝 Auditoria

O sistema possui mecanismo de auditoria para registrar operações importantes.

A auditoria registra informações como:

usuário responsável;
ação realizada;
entidade afetada;
identificador da entidade;
descrição da operação;
data e hora.

Exemplo conceitual:

Administrador
      ↓
Atualizou paciente
      ↓
Paciente #25
      ↓
05/09/2026 14:32

A implementação utiliza Observers para registrar automaticamente determinadas operações realizadas nos Models.

São monitoradas entidades como:

Pacientes;
Atendimentos;
Tipos de atendimento.

A geração de relatórios também pode ser registrada através de Events e Listeners.

## 📊 Relatórios

O sistema possui um módulo de relatórios para análise dos atendimentos.

É possível consultar informações como:

Indicadores
Total de atendimentos;
Pacientes atendidos;
Tipos de atendimento utilizados;
Usuários responsáveis pelos atendimentos.
Distribuições
Atendimentos por tipo;
Atendimentos por usuário;
Atendimentos por dia;
Atendimentos por cidade;
Atendimentos por bairro.
Filtros

Os relatórios podem ser filtrados por:

Data inicial;
Data final;
Cidade;
Bairro.
Exportação

Os relatórios podem ser exportados em formato PDF.

## 🛠️ Tecnologias utilizadas
Backend
PHP 8.4+
Laravel
Eloquent ORM
MySQL
Composer
Frontend
Vue.js 3
Inertia.js
JavaScript
Tailwind CSS
DaisyUI
Vite
Autenticação e infraestrutura
Laravel Breeze
Ziggy
Middleware
Policies
Events
Listeners
Observers
Testes
PHPUnit / Pest
Banco de dados separado para testes
Versionamento
Git
GitHub

## 🏗️ Arquitetura

A aplicação utiliza a arquitetura tradicional do Laravel, separando responsabilidades entre diferentes camadas.

                    ┌─────────────────────┐
                    │      Vue.js 3       │
                    │      Frontend       │
                    └──────────┬──────────┘
                               │
                               │ Inertia.js
                               ↓
                    ┌─────────────────────┐
                    │      Laravel        │
                    │      Backend        │
                    └──────────┬──────────┘
                               │
              ┌────────────────┼────────────────┐
              ↓                ↓                ↓
        Controllers         Policies         Middleware
              │
              ↓
           Models
              │
        ┌─────┴──────┐
        ↓            ↓
    Observers      Events
        │            │
        ↓            ↓
    Auditoria     Listeners
                     │
                     ↓
                  MySQL
                  
## 📁 Estrutura do projeto
sistema_atendimento_cerberus/
│
├── app/
│   ├── Events/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Listeners/
│   ├── Models/
│   ├── Observers/
│   └── Policies/
│
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
│
├── resources/
│   ├── css/
│   ├── js/
│   │   ├── Components/
│   │   ├── Layout/
│   │   └── Pages/
│   └── views/
│
├── routes/
│   ├── auth.php
│   └── web.php
│
├── tests/
│   ├── Feature/
│   └── Unit/
│
├── .env.example
├── composer.json
├── package.json
├── vite.config.js
└── README.md

## 🧩 Padrões e recursos utilizados

Durante o desenvolvimento foram utilizados recursos e conceitos de arquitetura e Design Patterns para resolver problemas reais da aplicação.

Observer

Utilizado para registrar automaticamente ações realizadas sobre entidades do sistema.

Model
  ↓
Observer
  ↓
Auditoria

Isso evita espalhar lógica de auditoria por diversos Controllers.

Event / Listener

Utilizado para desacoplar determinadas ações do fluxo principal.

Um exemplo é o registro da geração de relatórios:

Relatório gerado
       ↓
     Event
       ↓
    Listener
       ↓
   Auditoria
Policy

Utilizada para concentrar regras de autorização relacionadas aos recursos.

Exemplo:

$this->authorize('update', $paciente);
Middleware

Utilizado para controlar acesso a áreas específicas da aplicação.

Exemplo:

Usuário autenticado
        ↓
   Middleware
        ↓
   Área administrativa
   
## 🗄️ Banco de dados

O banco de dados é gerenciado através das migrations do Laravel.

Principais entidades:

users
   │
   ├──────────────┐
   │              │
   ↓              ↓
atendimentos   auditorias
   │
   ├──────────────→ pacientes
   │
   └──────────────→ tipos_atendimento
Relacionamentos principais
Paciente
    │
    └── possui vários atendimentos

Atendimento
    ├── pertence a um paciente
    ├── pertence a um tipo de atendimento
    └── pertence a um usuário

Tipo de Atendimento
    └── possui vários atendimentos

Usuário
    ├── realiza atendimentos
    └── realiza ações registradas na auditoria
    
## 🧪 Testes

O projeto possui testes automatizados para validar comportamentos importantes da aplicação.

Entre os cenários testados estão:

autorização de usuários;
acesso administrativo;
regras de negócio;
relatórios;
auditoria.

Os testes utilizam um banco de dados separado para evitar alterações no banco utilizado durante o desenvolvimento.

## Para executar:

php artisan test
🚀 Instalação
Requisitos

Antes de executar o projeto, certifique-se de possuir:

PHP 8.4+
Composer
Node.js
npm
MySQL
Git

1. Clonar o projeto
git clone https://github.com/MarcosVCarvalho/sistema_atendimento_cerberus.git

Entre na pasta:

cd sistema_atendimento_cerberus
2. Instalar dependências PHP
composer install
3. Instalar dependências JavaScript
npm install
4. Configurar o ambiente

Copie o arquivo de configuração:

cp .env.example .env

No Windows PowerShell:

Copy-Item .env.example .env

Configure no .env as informações do banco de dados.

Exemplo:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
5. Gerar a chave da aplicação
php artisan key:generate
6. Executar migrations e seeders
php artisan migrate --seed
7. Iniciar o servidor Laravel
php artisan serve
8. Iniciar o Vite

Em outro terminal:

npm run dev

A aplicação estará disponível em:

http://127.0.0.1:8000
🔑 Usuário de demonstração

Para ambiente de demonstração:

E-mail:
admin@prefeitura.test

Senha:
password

⚠️ Essas credenciais são destinadas apenas ao ambiente de demonstração/desenvolvimento. Em produção, devem ser substituídas.

## 🖥️ Interface

A aplicação utiliza uma interface construída com Vue.js, Inertia.js e Tailwind CSS.

Principais áreas:

Dashboard
   │
   ├── Pacientes
   │
   ├── Atendimentos
   │
   ├── Tipos de Atendimento
   │
   ├── Relatórios
   │
   ├── Auditoria
   │
   └── Usuários

As capturas de tela da aplicação podem ser adicionadas posteriormente na pasta docs/screenshots.

## 📈 Evolução do projeto

O projeto começou com o objetivo de atender às funcionalidades básicas de cadastro e controle de atendimentos.

Durante o desenvolvimento, foram adicionados recursos para tornar a aplicação mais completa e próxima de um sistema real.

Evolução
CRUD básico
     ↓
Autenticação
     ↓
Controle de permissões
     ↓
Policies
     ↓
Soft Delete
     ↓
Auditoria
     ↓
Relatórios
     ↓
Filtros avançados
     ↓
Exportação PDF
     ↓
Testes automatizados

## 🔮 Possíveis evoluções futuras

Algumas funcionalidades podem ser adicionadas futuramente:

Exportação para Excel/CSV;
Dashboard com indicadores mais avançados;
Recuperação de registros excluídos;
Notificações;
Histórico detalhado de alterações;
Controle de status do atendimento;
Filas de atendimento;
API para integração com outros sistemas;
Controle de unidades de atendimento;
CI/CD através do GitHub Actions.
📌 Considerações técnicas

Algumas decisões do projeto foram tomadas buscando manter o código organizado e facilitar futuras evoluções.

Laravel

Responsável pelas regras de negócio, persistência, autenticação, autorização e estrutura principal da aplicação.

Vue.js

Responsável pela construção da interface dinâmica.

Inertia.js

Permite utilizar Vue no frontend mantendo a estrutura de rotas e Controllers do Laravel, reduzindo a necessidade de construir uma API separada para cada tela.

Eloquent

Utilizado para trabalhar com os modelos e relacionamentos do banco de dados.

Policies e Middleware

Utilizados conjuntamente para separar controle de acesso geral de autorização específica de recursos.

Observers e Events

Utilizados para desacoplar comportamentos secundários, como auditoria.

## 👨‍💻 Autor

Desenvolvido por Marcos V. Carvalho.

Projeto desenvolvido para fins de estudo, portfólio e demonstração de conhecimentos em desenvolvimento web utilizando Laravel e Vue.js.

## 📄 Licença

Este projeto foi desenvolvido para fins educacionais e de portfólio.
