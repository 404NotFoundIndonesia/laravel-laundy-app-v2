<div align="center">
    <p>
        <a href="https://github.com/404NotFoundIndonesia/" target="_blank">
            <img src="https://avatars.githubusercontent.com/u/87377917?s=200&v=4" width="200" alt="404NFID Logo">
        </a>
    </p>

[![GitHub Stars](https://img.shields.io/github/stars/404NotFoundIndonesia/laravel-laundy-app-v2.svg)](https://github.com/404NotFoundIndonesia/laravel-laundy-app-v2/stargazers)
[![GitHub license](https://img.shields.io/github/license/404NotFoundIndonesia/laravel-laundy-app-v2)](https://github.com/404NotFoundIndonesia/laravel-laundy-app-v2/blob/main/LICENSE)

</div>

# Laundry App (Aplikasi Penatu)

This platform will provide laundry businesses with a robust set of tools to streamline their operations, enhance customer management, and optimise overall efficiency. The solution will be accessible via web, ensuring flexibility and convenience for users.

## Objectives

- Provide a user-friendly interface for laundry business owners.
- Enable efficient management of orders, customers, pricing, services, and inventory.
- Offer scalable solutions to accommodate growing business needs.
- Provide analytical tools to track performance and make informed decisions.

## Features

- __User Management__: Secure user registration, login, and role-based access control.
- __Customer Management__: Detailed customer profiles, loyalty programs, and communication tools.
- __Order Management__: Comprehensive order tracking, notifications, and barcode/QR code integration.
- __Inventory Management__: Stock tracking and supplier management.
- __Billing and Payments__: Automated invoice generation, multiple payment options, and subscription plans.
- __Pricing and Service Management__: Service listings, pricing management, and discount management.

## Technical Specifications

- __Backend__: php 8.3, Laravel 11
- __Database__: MySQL
- __Frontend__: Vue3

## Get Started

### Prerequisite

- You need [php](https://www.php.net/downloads) to run this, with a minimum installed version of **php 8.3.4**. Make sure you can also access php via the command line by adding it to the [path environment variable](https://rgrahardi.medium.com/pengaturan-path-php-dan-composer-di-environment-variables-windows-10-e1e22a637618).
- Make sure [Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos) is also installed and accessible via the command line.
- Ensure that you have also installed [MySQL](https://dev.mysql.com/downloads/mysql/).
- You need to install [Node.js](https://nodejs.org/en/download/current) to ensure that the HTML pages can be rendered when the application is running. Use Node.js version **v20.11.1 LTS** for the expected results.
- I recommend installing [Git](https://git-scm.com/downloads) for better code management.

### Get the Source Code
Of course, you need to put this code on your computer first. There are two ways to do this: by __downloading the project zip file__ or __by using Git (recommended)__.

1. **Download the Project Zip**

   You can click on [this link](https://github.com/404NotFoundIndonesia/laravel-laundy-app-v2/archive/refs/heads/main.zip) to download the zip file of this project.

2. **Git Clone**

   Make sure that you have installed git. Open the directory where you want to place the source code in the terminal. Then, run the following command:
    ```shell
    git clone git@github.com:404NotFoundIndonesia/laravel-laundy-app-v2.git
    ```

### Install Dependencies

__Make sure this project is open in your command line interface__. To confirm your current active directory in the terminal, use the following command:
```shell
pwd
```

To install all dependencies, use the following command:
```shell
composer setup
```

### How to Run
You need to open two command line instances to run this project. Each is used for the backend and frontend parts. Also, make sure the active directory in each command line is within this project.

To run the backend server, use the following command:
```shell
php artisan serve
```

To run the frontend server, use the following command:
```shell
npm run dev
```

Open `http://localhost:8000` in your browser to access the app. When you want to access this app in a web browser, make sure you **do not close or stop both of those processes**.

## License

__Laundry App__ is open-sourced software licensed under the [MIT license](https://github.com/404NotFoundIndonesia/laravel-laundy-app-v2?tab=MIT-1-ov-file).
