# College Library Manage System

The **College Library Manage System** is a RESTful API developed using Laravel 11. It enables efficient management of books, students, and library transactions, serving as the backend for a library management system. This API facilitates seamless integration with front-end applications.

## Table of Contents

- [Introduction](#introduction)
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [API Documentation](#api-documentation)

## Introduction

The **College Library Manage System** is a RESTful API developed using Laravel. It allows for the management of books, students, and library transactions efficiently. This API serves as the backend for a library management system, enabling seamless integration with front-end applications.

## Features

- **User Management**: Register, update, and manage users. Association of users to campuses and academic programs as applicable.
- **Book Management**: Create, update, delete, and list books. Management of stock for each book, which is independent for each campus.
- **Category Management**: Create, update, delete, and list book categories.
- **Campus Management**: Manage campuses and associate them with academic programs.
- **Academic Program Management**: Create, update, delete, and list academic programs.
- **Transaction Management**: Handle book loans and returns.
- **Role-based Access Control**: Different permissions for users based on their roles (admin, employee, student).
- **Email Notifications**: Send notifications via email for various events such as book reservations, expirations, and status updates.


## Requirements

- PHP >= 8.2
- Composer
- MySQL
- Laravel 11.x

## Installation

1. **Clone the repository:**
    ```sh
    git clone https://github.com/Javier-Miguras/college-library-manage-system.git
    ```

2. **Install dependencies:**
    ```sh
    composer install
    ```

3. **Configure your `.env` file:**
    ```sh
    cp .env.example .env
    ```

4. **Generate an application key:**
    ```sh
    php artisan key:generate
    ```

5. **Configure your `.env` file:**
    Update the database credentials and other necessary configuration in your `.env` file.

6. **Run the migrations**
    ```sh
    php artisan migrate
    ```

7. **Start the development server:**
    ```sh
    php artisan serve
    ```

## Usage

### Running the API

After setting up the project as described in the [Installation](#installation) section, you can start the API server with the following command:

```sh
php artisan serve
```

### Database Seeding (Optional)

To enhance development and testing, you can optionally use the seeders and factories provided in this project to populate the database with sample data. 

1. **Modify Seeders**: Customize the `/database/seeders/DatabaseSeeder.php` file as needed to include the specific seeders you want to use.

2. **Run Seeders**: Execute the following command to seed the database:

    ```sh
    php artisan db:seed
    ```

3. **Advanced Seeding**: For more control, you can create and customize additional seeders and factories. To seed specific tables, use individual seeders by specifying their class names:

    ```sh
    php artisan db:seed --class=SeederClassName
    ```

Feel free to adapt or extend the seeders and factories according to your testing and development needs.

## API Documentation

For detailed API documentation, you can refer to our **Postman Collection**.

You can import this collection into your Postman application to test all endpoints easily.


[<img src="https://run.pstmn.io/button.svg" alt="Run In Postman" style="width: 128px; height: 32px;">](https://god.gw.postman.com/run-collection/34890076-f117b2a6-ff6e-4b49-a64a-5f5de2f39c29?action=collection%2Ffork&source=rip_markdown&collection-url=entityId%3D34890076-f117b2a6-ff6e-4b49-a64a-5f5de2f39c29%26entityType%3Dcollection%26workspaceId%3D9e470097-9998-46b8-b0a2-4d3446facaee)



