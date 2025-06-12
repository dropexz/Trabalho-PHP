---

### 📄 `README.txt`

```
===========================
SISTEMA DE TAREFAS - PHP
===========================
Desenvolvido para fins acadêmicos — sistema com cadastro de usuários, login seguro e gerenciamento de tarefas.

📁 ESTRUTURA DO PROJETO
------------------------
Pasta principal: Trabalho

├── sql/
│   └── criar_banco.sql            – Script SQL com criação de tabelas
│
├── index.php                      – Login
├── cadastro_usuario.php           – Cadastro de usuário
├── logout.php                     – Finaliza a sessão
├── dashboard.php                  – Tela principal após login
├── itens.php                      – Lista de tarefas do usuário
├── novo_item.php                  – Formulário para cadastrar nova tarefa
└── editar_item.php                – Edição de tarefa existente

⚙️ REQUISITOS
---------------
- PHP 7.4+ e MySQL
- Servidor local (ex: XAMPP)
- Navegador moderno

📦 INSTALAÇÃO
--------------
1. Copie a pasta **Trabalho** para dentro do diretório do XAMPP:
```

C:\xampp\htdocs\Trabalho

```

2. Inicie os serviços:
- Apache
- MySQL

3. Acesse o phpMyAdmin:
```

[http://localhost/phpmyadmin](http://localhost/phpmyadmin)

````
- Crie ou selecione o banco de dados `sistema_tarefas`.
- Importe o arquivo:
  ```
  sql/criar_banco.sql
  ```

4. Acesse o sistema no navegador:
````

[http://localhost/Trabalho/](http://localhost/Trabalho/)

```

🔐 USUÁRIO DE TESTE
-------------------
- **E‑mail:** teste@gmail.com  
- **Senha:** teste123

📌 OBSERVAÇÕES
---------------
- Após login, é possível cadastrar, editar e excluir tarefas.
- Cada tarefa é associada ao usuário logado.
- Autenticação, validação (campos obrigatórios) e mensagens estão implementadas.
- Layout responsivo com Bootstrap.

👨‍💻 AUTORES
-------------
- Pedro Henrique Valeriano
```
