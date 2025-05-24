# Credit App

This web application is part of a job application test.

This is used to retrieve data from the credit API and render it using cards and charts, so the user can make the best decision about which offer is best for their desired loan amount and payment terms.

## Tech Stack

Laravel, TailwindCSS, JQuery, Charts.js, JQuery.mask

## Installation

1. Clone the repository:
```bash
git clone https://github.com/GuibLuis/credit-app.git
cd credit-app
```

2. Install PHP dependencies:
```bash
composer install
```

3. Build assets:
```bash
npm run build
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in the `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run database migrations:
```bash
php artisan migrate
```

8. (OPTIONAL) Change to mockup API data if real one isn't loading
```bash
ConsultaController.php
Line 56 - '/consulta/' to '/mockup_data/'
```

## Run Locally

Run artisan serve:
```bash
php artisan serve
```

Go to the locahost url:
```bash
http://127.0.0.1:8000/
```

CPFs available for testing:
```bash
111.111.111-11
```
```bash
123.123.123.12 
```
```bash
222.222.222.22
```