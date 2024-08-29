# MagicPort Case Study
This project is a basic project management tool that allows users to manage projects and tasks. The project is developed using **Laravel** and **Vue.js** and is structured with a **Service Layer architecture**.

The Service Layer pattern was used to make the project modular and to control the business logic. This approach ensures that the code is cleaner, easier to maintain, and more reusable.

The Service Layer contains classes specific to each business domain, such as projects (ProjectService) and tasks (TaskService). Controllers depend directly on these Service classes and only call these Services to perform specific tasks.

In addition to the core requirements, I also implemented several bonus features. These include **Advanced Search & Filtering**, which allows users to search projects by name. **Dockerization** for simplified setup and deployment, and **Unit Testing** to ensure the application’s key functionalities are thoroughly tested and reliable.

# Requirements & Deployment

[Docker Desktop](https://www.docker.com/get-started/#h_installation) has to be installed and running.

**Step 1**: Clone the repo

```bash
git clone https://github.com/emreensr/magic-port-case.git
```

**Step 2**: Go inside the project directory from command prompt terminal
```bash
cd magic-port-case
```

**Step 3**: Set Up Environment Variables
```bash
cp .env.example .env
```

**Step 4**: Start the docker containers using the following command
```bash
docker-compose up -d
```
**Step 5**: Install Composer Dependencies
```bash
docker-compose exec app composer install
```

**Step 6**: Generate Application Key
```bash
docker-compose exec app php artisan key:generate
```

**Step 7**: Run Database Migrations
```bash
docker-compose exec app php artisan migrate
```

**Step 8**: Seed the Database
```bash
docker-compose exec app php artisan db:seed
```

This will create a user with the following credentials:

- Email: john.doe@example.com
- Password: password123
  
You can use these credentials to log in to the application.

**Step 9**: Compile Frontend Assets
```bash
npm install && npm run dev
```

## Project Screenshots

Below are some screenshots showcasing the functionality and user interface of the project across different devices.

### Desktop View

<img src="https://github.com/user-attachments/assets/a86e8cd5-daf9-4b60-a282-25b89f7e88a0" width="400"/>
<img src="https://github.com/user-attachments/assets/ce06dcfd-921a-4a2a-9570-b1b8bf3212b5" width="400"/>

### Mobile View

<img src="https://github.com/user-attachments/assets/5b0a8ba1-ac5a-4051-bf93-b60d7945aaaa" width="300"/>
<img src="https://github.com/user-attachments/assets/3101a54a-6a7d-4620-b073-ced5ce60097b" width="300"/>

### Additional Desktop Screenshots

<img src="https://github.com/user-attachments/assets/c7819d73-d3f8-453e-91e5-14fbfe9ba44c" width="400


