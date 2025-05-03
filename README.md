
# 📋 Gestor de Chamados – Instalação

Este projeto é um sistema simples de gestão de chamados. Abaixo estão os passos necessários para instalar e rodar o sistema corretamente.

---

## ✅ 1. Banco de Dados

### a) Criar o banco e as tabelas

1. Localize o arquivo `install.sql` (que cria o banco de dados e tabelas).
2. Importe o arquivo no seu MySQL usando **phpMyAdmin**, **DBeaver**, **MySQL** **Workbench** ou pela linha de comando:

```bash
mysql -u SEU_USUARIO -p < install.sql
```

➡️ **O banco será criado com o nome:** `support_system`.

---

## ✅ 2. Configuração de Banco de Dados

O arquivo responsável pela conexão com o banco é:

```
./config/database.php
```

### 🚨 **Atenção: edite os seguintes dados:**

```php
private static $host = "localhost";
private static $dbname = "support_system";
private static $email = "root";       // SEU USUÁRIO DO BANCO
private static $password = "12345678"; // SUA SENHA DO BANCO
```

Altere esses valores para os dados do seu ambiente.

---

## ✅ 3. Rota Principal

Para acessar o sistema, utilize a seguinte URL:

```
/gestor_chamados/views/login.php
```

👉 **Exemplo em ambiente local:**

```
http://localhost/gestor_chamados/views/login.php
```

---

## 📂 Estrutura Importante

- `install.sql`: script para criar banco e tabelas.
- `./config/database.php`: arquivo de configuração da conexão com o banco.
- `/views/login.php`: página inicial para login.

---

## ❓ Problemas comuns

- **Erro de conexão:** verifique se os dados de conexão no `database.php` estão corretos.
- **Banco não encontrado:** confirme se você importou o `install.sql` corretamente e que o banco se chama `support_system`.

---

Pronto! Seu sistema estará configurado 🎉.
