# Desafio3_Pagamentos – API de Pagamentos em PHP com Arquitetura MVC

Este projeto é uma **API de gestão de pagamentos** desenvolvida em **PHP** utilizando o padrão arquitetural **MVC (Model-View-Controller)**.  
O objetivo principal é praticar e consolidar conhecimentos de organização de código, separação de responsabilidades e criação de endpoints voltados para operações de pagamentos, mantendo uma estrutura escalável e fácil de manter.

---

## Sobre o Projeto

- 🏗️ **Arquitetura:** MVC – com Models, Controllers e organização clara
- 🖥️ **Linguagem:** PHP
- 💳 **Domínio:** Processamento e controle de registros de pagamentos
- 🎯 **Objetivo:** Criar uma base de API backend organizada, permitindo integração com sistemas maiores e pronta para evolução

---

## Estrutura Geral

O projeto conta com uma estrutura com três camadas bem definidas:

- **Models:**  
  Responsáveis por representar as entidades e regras de negócio relacionadas aos pagamentos (ex.: cadastro, atualização, exclusão e consultas de registros).
  
- **Controllers:**  
  Recebem e tratam as requisições, interagem com os Models e retornam as respostas no formato adequado (JSON, por exemplo).
  
- **Config/Rotas:**  
  Definem as entradas da API (endpoints) para as operações de pagamento, conectando URLs aos respectivos controllers e métodos.

> **Nota:** Não há View tradicional, já que o objetivo é expor a API para consumo via ferramentas como Postman, Insomnia ou integração com outros sistemas.

---

## Funcionalidades

- **Cadastro de pagamentos**
- **Listagem de pagamentos**
- **Atualização e exclusão de registros**
- Estrutura com integração a banco de dados
- Organização modular para fácil manutenção e expansão


---
