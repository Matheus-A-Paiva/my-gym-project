# My Gym - Multi-Tenant Gym Management System


<a href="#portuguese">Português</a> |
<a href="#english">English</a>
---

<p id="portuguese">Português<p/>
---

## Descrição
"My Gym" é um sistema SaaS de gerenciamento de academias com suporte a multi-tenancy. Cada cliente possui seu banco de dados dedicado, garantindo segurança, isolamento de dados e escalabilidade. O sistema permite o gerenciamento de membros, planos, academias e redes de academias, além de oferecer autenticação segura e processos automatizados para a criação e exclusão de tenants.

## 💻 Tecnologias
- **Tenancy for Laravel**: Suporte a multi-tenancy para isolar os dados por tenant.
- **Laravel**: Framework PHP para construção de aplicações robustas.
- **Laragon**: Ambiente de desenvolvimento local para aplicações Laravel.
- **Breeze**: Scaffold simples e minimalista para autenticação no Laravel.
- **REST API**: Comunicação via HTTP para interações cliente-servidor.

## 🚀 Começando

<h3>Pré-requisitos:</h3> PHP >= 8.4, Composer, Laravel, MySQL, Git, Nginx.

### Clonando o Projeto
Clone o repositório para a sua máquina local usando:

```bash
git clone https://github.com/Matheus-A-Paiva/my-gym-project.git my-gym-project
```
### Nginx no Laragon
Certifique-se de estar usando Nginx no seu ambiente Laragon. Você pode alternar para o Nginx selecionando-o no painel do Laragon. Após isso, configure o host virtual conforme mostrado abaixo e reinicie o Nginx para que a configuração tenha efeito.

### Configurando o Nginx para Suporte a Múltiplos Domínios
Para habilitar o suporte a multi-tenancy para vários domínios, adicione a seguinte configuração ao seu arquivo 00-default.conf no Nginx:

```nginx
server_name gym-manager-multi-tenancy.test *.localhost;
root "C:/laragon/www/my-gym-project/public";
```
### Rodar Composer install

```bash
composer install
```
### Criar .env e rodar Migrations
Depois de baixar os pacotes com composer, crie o .env baseado no .env.example e rode as migrations com --seed, assim cria um usuário para login:
```bash
cp .env.example .env

php artisan migrate --seed
```
## 📍 Endpoints da API
Após rodar as migrations, você pode começar a usar a API. Para exemplos de cada endpoint, você pode consultar a documentação do Postman:

https://documenter.getpostman.com/view/40446855/2sAYQZGrng

## Aprendizados Adquiridos

### Configuração de Multi-Tenancy
- Uma das partes mais interessantes foi configurar **multi-tenancy** no Laravel. Usei o pacote **Tenancy for Laravel** para criar bancos de dados isolados para cada cliente, o processo foi desafiador, mas satisfatório.

### Laravel & Desenvolvimento de API
- Este projeto me ajudou a me aprofundar mais no **Laravel** e como construir APIs REST. Aprendi mais sobre **rotas**, **controladores**, como tratar exceções e retornar respostas corretamente, o poder da validação, **modelos** e **migrations**.
- Configurar o **Breeze** para autenticação segura de usuários foi simples, mas me ensinou muito sobre como gerenciar usuários de maneira mais eficiente no Laravel.

### Configuração do Nginx
- Configurar o **Nginx** no **Laragon** para lidar com múltiplos domínios foi uma das partes mais desafiadoras deste projeto. Demorei um pouco para configurar tudo corretamente, mas agora sei como configurar o Nginx para gerenciar solicitações para diferentes inquilinos com base no domínio.

### Desafios
- A configuração de multi-tenancy envolveu muitos erros. Garantir que o banco de dados correto fosse selecionado com base no domínio foi complicado, mas quando funcionou, foi gratificante.
- Demorei bastante para descobrir que as rotas da API na biblioteca Tenancy for Laravel só funcionam no arquivo de rotas `tenant.php`, e que é necessário rodar `php artisan route:clear` sempre que usar o Nginx.

## Melhorias Futuras
- No futuro, pretendo focar em aprimorar a cobertura de testes da API para garantir sua confiabilidade.
- Também pretendo implementar a verificação de e-mail para autenticação e um recurso de recuperação de senha.


<p id="english">English<p/>
---

## Description
"My Gym" is a SaaS (Software as a Service) gym management API with multi-tenancy support, where each client has its own dedicated database. Clients can create their own users to log in, ensuring data isolation, security, and scalable performance. The system allows the management of members, plans, gyms, and gym networks. It also features secure authentication and automated processes for creating and deleting tenants.

## 💻 Technologies
- **Tenancy for Laravel**: Multi-tenancy support for isolating data per tenant.
- **Laravel**: PHP framework for building robust applications.
- **Laragon**: Local development environment for Laravel applications.
- **Breeze**: Simple and minimal Laravel authentication scaffold.
- **REST API**: Communication through HTTP for client-server interactions.

## 🚀 Getting Started

<h3>Prerequisites:</h3> PHP >= 8.4, Composer, Laravel, MySQL, Git, Nginx.

### Cloning the Project
Clone the repository to your local machine using:


```bash
git clone https://github.com/Matheus-A-Paiva/my-gym-project.git my-gym-project
```
### Nginx in Laragon
Make sure you are using **Nginx** in your Laragon environment. You can switch to Nginx by selecting it from the Laragon dashboard. Afterward, configure the virtual host as shown below and restart Nginx for the configuration to take effect.

### Configuring Nginx for Multi-Domain Support
To enable multi-tenancy support for multiple domains, add the following configuration to your `00-default.conf` file in Nginx:

```nginx
server_name gym-manager-multi-tenancy.test *.localhost;
root "C:/laragon/www/my-gym-project/public";
```

### Run Composer install
Install the required dependencies by running:

```bash
composer install
```
### Create .env and run migrations
After installing the dependencies, create the .env file based on .env.example and run the migrations with --seed option to create a admin user for login:
```bash
cp .env.example .env

php artisan migrate --seed
```

## 📍 API Endpoints
After running the migrations, you can begin using the API. For examples of each endpoint, you can refer to the Postman documentation:

https://documenter.getpostman.com/view/40446855/2sAYQZGrng

## Knowledge Gained

### Multi-Tenancy Setup
- One of the most interesting aspects I learned was setting up **multi-tenancy** in Laravel. I used the **Tenancy for Laravel** package to create isolated databases for each client, which was a bit challenging, but really rewarding once it worked.

### Laravel & API Development
- This project helped me dive deeper into **Laravel** and how to build REST APIs. I got a better grasp of **routes**, **controllers**, how to handle exceptions and return response correctly, the power of validation, **models**, and **migrations**.
- Setting up **Breeze** for secure user authentication was simple, but it really taught me how to manage users more efficiently in Laravel.

### Nginx Configuration
- Configuring **Nginx** in **Laragon** to handle multiple domains was one of the more challenging parts of this project. It took me a while to get everything set up, but now I know how to configure Nginx to handle requests for different tenants based on the domain.

### Challenges
- The multi-tenancy setup took a lot of errors. Making sure that the right database is selected based on the domain was tricky, but once it worked, it was nice.
- It took me a long time to figure out that the API routes in the Tenancy for Laravel library only work in the `tenant.php` route file, and that you need to run `php artisan route:clear` every time using nginx.

## Future Improvements
- Moving forward, I plan to focus on enhancing the test coverage of the API to ensure its reliability.
- I plan to implement email verification for authentication and a forgot password feature.


