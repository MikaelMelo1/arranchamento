# Sistema de Arranchamento Digital - 13º GAC

Sistema web para gerenciamento de arranchamento (refeições) do 13º Grupo de Artilharia de Campanha do Exército Brasileiro.

## 📋 Descrição

O Sistema de Arranchamento Digital é uma aplicação web desenvolvida em PHP que permite aos militares realizarem o arranchamento (marcação de refeições) de forma digital e automatizada. O sistema oferece controle de horários, bloqueios por data, justificativas obrigatórias e gerenciamento de cardápios.

## ✨ Funcionalidades

### Para Usuários
- **Arranchamento de Refeições**: Marcação de café, almoço e jantar para os próximos dias
- **Controle de Prazos**: Sistema automático de bloqueio por horário limite por dia da semana
- **Justificativas**: Obrigatoriedade de justificativa para arranchamento de almoço/jantar às sextas-feiras (exceto alunos)
- **Visualização de Cardápio**: Consulta do cardápio semanal
- **Edição de Conta**: Atualização de dados pessoais
- **Sistema de Hierarquia**: Controle de acesso baseado em posto e função

### Para Administradores
- **Gerenciamento de Cardápio**: Inserção e edição de cardápios
- **Relatórios**: Geração de relatórios de arranchamento
- **Bloqueio de Arranchamento**: Bloqueio de refeições por data específica
- **Configurações**: Gerenciamento de limites de horário e expedientes diferenciados

## 🛠️ Tecnologias Utilizadas

- **Backend**: PHP
- **Banco de Dados**: MySQL 8.x
- **Frontend**: 
  - Bootstrap Material Design
  - jQuery
  - HTML5/CSS3
- **Servidor**: Apache (XAMPP)

## 📦 Requisitos

### Instalação Tradicional
- PHP 7.4 ou superior
- MySQL 8.0 ou superior
- Apache (ou servidor web compatível)
- XAMPP (recomendado para desenvolvimento)

### Instalação com Docker (Recomendado)
- Docker 20.10 ou superior
- Docker Compose 2.0 ou superior

## 🚀 Instalação

### 1. Clone o repositório

```bash
git clone https://github.com/MikaelMelo1/arranchamento
cd arranchamento
```

### 2. Configure o banco de dados

Execute o script SQL para criar o banco de dados e as tabelas:

```bash
mysql -u root -p < arranchamento.sql
```

Ou importe o arquivo `arranchamento.sql` através do phpMyAdmin.

### 3. Configure as variáveis de ambiente

Crie um arquivo `.env` na raiz do projeto com as seguintes variáveis:

```env
DB_HOST=localhost
DB_USER=seu_usuario
DB_PASS=sua_senha
DB_NAME=arranchamento
DB_PORT=3306
NR_DIAS=7
LOCK=disabled
```

### 4. Configure o servidor web

- Coloque os arquivos na pasta `htdocs` do XAMPP (ou equivalente)
- Certifique-se de que o Apache está rodando
- Acesse: `http://localhost/arranchamento`

## 🐳 Instalação com Docker

A forma mais simples e recomendada de executar o projeto é utilizando Docker e Docker Compose. Isso garante que todas as dependências estejam configuradas corretamente.

### 1. Clone o repositório

```bash
git clone https://github.com/MikaelMelo1/arranchamento
cd arranchamento
```

### 2. Configure as variáveis de ambiente

Crie um arquivo `.env` na raiz do projeto com as seguintes variáveis:

```env
# Configurações do Banco de Dados
DB_HOST=db
DB_USER=arranchamento_user
DB_PASS=senha_segura_aqui
DB_NAME=arranchamento
DB_PORT=3306
DB_ROOT_PASS=senha_root_aqui

# Configurações da Aplicação
NR_DIAS=7
LOCK=disabled
```

**Importante**: 
- `DB_HOST` deve ser `db` (nome do serviço no docker-compose)
- `DB_ROOT_PASS` é a senha do usuário root do MySQL
- `DB_PASS` é a senha do usuário da aplicação

### 3. Execute o Docker Compose

```bash
docker-compose up -d
```

Este comando irá:
- Construir a imagem PHP 8.2 com Apache
- Criar e iniciar o container do MySQL 8.0
- Criar e iniciar o container do phpMyAdmin
- Executar automaticamente o script SQL para criar o banco de dados
- Iniciar todos os serviços

### 4. Acesse a aplicação

Após alguns segundos (aguarde o MySQL inicializar completamente), acesse:

- **Aplicação**: http://localhost:8080
- **phpMyAdmin**: http://localhost:8081
- **MySQL**: localhost:3307

### Comandos úteis do Docker

```bash
# Iniciar os containers
docker-compose up -d

# Parar os containers
docker-compose stop

# Parar e remover os containers
docker-compose down

# Ver os logs
docker-compose logs -f

# Ver logs de um serviço específico
docker-compose logs -f app
docker-compose logs -f db

# Reconstruir as imagens
docker-compose build

# Reconstruir e iniciar
docker-compose up -d --build

# Acessar o container da aplicação
docker exec -it arranchamento_app bash

# Acessar o MySQL via linha de comando
docker exec -it arranchamento_db mysql -u root -p
```

### Estrutura dos Serviços Docker

O `docker-compose.yml` configura três serviços:

1. **app** (arranchamento_app)
   - PHP 8.2 + Apache
   - Porta: 8080
   - Volume montado para desenvolvimento (alterações refletem imediatamente)

2. **db** (arranchamento_db)
   - MySQL 8.0
   - Porta: 3307
   - Volume persistente para dados
   - Script SQL executado automaticamente na primeira inicialização

3. **phpmyadmin** (arranchamento_pma)
   - phpMyAdmin 5
   - Porta: 8081
   - Interface web para gerenciar o banco de dados

### Troubleshooting Docker

**Problema**: Erro ao conectar ao banco de dados
- **Solução**: Aguarde alguns segundos após `docker-compose up`. O MySQL precisa de tempo para inicializar completamente.

**Problema**: Porta já em uso
- **Solução**: Altere as portas no `docker-compose.yml` ou pare o serviço que está usando a porta.

**Problema**: Banco de dados não foi criado
- **Solução**: Remova o volume e reinicie:
  ```bash
  docker-compose down -v
  docker-compose up -d
  ```

**Problema**: Alterações no código não aparecem
- **Solução**: O volume está montado, mas se necessário, reinicie o container:
  ```bash
  docker-compose restart app
  ```

## 📁 Estrutura do Projeto

```
arranchamento/
├── administrador.php          # Painel administrativo
├── arranchamento_form.php     # Formulário principal de arranchamento
├── arrancha.php               # Processamento do arranchamento
├── cardapio.php               # Visualização do cardápio
├── inserir_cardapio.php       # Inserção de cardápio (admin)
├── cadastro.php               # Cadastro de novos usuários
├── editar_conta.php           # Edição de conta do usuário
├── index.html                 # Página de login
├── ope.php                    # Processamento de login
├── logout.php                 # Encerramento de sessão
├── arranchamento.sql          # Script de criação do banco de dados
├── inc/                       # Arquivos de configuração
│   ├── conf.php              # Configuração de conexão com BD
│   ├── funcoes.php           # Funções auxiliares
│   └── envloader.php         # Carregador de variáveis de ambiente
├── relatorio/                 # Módulo de relatórios
├── img/                       # Imagens e ícones
└── material_design/           # Framework Material Design
```

## 🗄️ Estrutura do Banco de Dados

### Tabelas Principais

- **militares**: Cadastro de militares com informações pessoais e de acesso
- **arranchamento**: Registro de arranchamentos realizados
- **cardapio**: Cardápios das refeições por data
- **bloqueia_arranchamento**: Bloqueios temporários de refeições
- **limite_arranchamento**: Horários limite para arranchamento por dia da semana
- **expedientes_diferenciados**: Configuração de expedientes especiais
- **configuracoes**: Configurações gerais do sistema
- **avaliacao_app**: Avaliações dos usuários sobre o sistema
- **msgerros**: Log de erros do sistema

## 👥 Tipos de Usuário

- **ALUNO**: Acesso básico para arranchamento
- **ADMINISTRADOR**: Acesso completo ao sistema, incluindo gerenciamento e relatórios
- **FURRIEL**: Acesso intermediário com permissões específicas

## 🔐 Segurança

- Autenticação por CPF e senha
- Sessões PHP para controle de acesso
- Validação de permissões por tipo de usuário
- Proteção contra SQL Injection (usando prepared statements recomendado)
- Conexão SSL/TLS para banco de dados (configurável)

## 📝 Regras de Negócio

1. **Horários Limite**: Cada dia da semana possui um horário limite para arranchamento
2. **Bloqueio de Hoje**: Não é possível arranchar para o dia atual
3. **Finais de Semana**: Sábados e domingos são marcados como "Sem expediente"
4. **Justificativa de Sexta**: Almoço e jantar de sexta-feira requerem justificativa (exceto alunos)
5. **Hierarquia**: Sistema respeita hierarquia militar para controle de acesso

## 🐛 Troubleshooting

### Erro de conexão com banco de dados
- Verifique as credenciais no arquivo `.env`
- Certifique-se de que o MySQL está rodando
- Verifique se o banco de dados foi criado corretamente

### Erro "headers already sent"
- Verifique se há espaços ou caracteres antes de `<?php` nos arquivos
- Certifique-se de que `session_start()` é chamado antes de qualquer saída

### Problemas com sessão
- Verifique as permissões da pasta de sessões do PHP
- Limpe o cache do navegador

## 📄 Licença

Este projeto foi desenvolvido para uso interno para as OMs do Exército Brasileiro.

## 👨‍💻 Desenvolvimento

### Contribuindo

1. Faça um fork do projeto
2. Crie uma branch para sua feature (`git checkout -b feature/AmazingFeature`)
3. Commit suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. Push para a branch (`git push origin feature/AmazingFeature`)
5. Abra um Pull Request



