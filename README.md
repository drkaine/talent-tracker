# Talent Tracker
[![Pipeline-CI](https://github.com/drkaine/talent-tracker/actions/workflows/CI.yml/badge.svg)](https://github.com/drkaine/talent-tracker/actions/workflows/CI.yml)

Talent Tracker is a web application designed to track and manage talents. This project uses Laravel for the back end and React for the front end, with integration of TypeScript, Jest, ESLint, and other libraries.

## Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js 18 or higher
- NPM
- SQLite

## Installation

### Clone the repository

```bash
git clone https://github.com/your-username/talent-tracker.git
cd talent-tracker
```

### Backend Configuration

1. Install PHP dependencies:

```bash
composer install
```

2. Copy the environment file and generate the application key:

```bash
cp .env.example .env
php artisan key:generate
```

3. Configure the SQLite database:

```bash
touch database/database.sqlite
```

Modify the `.env` file to use SQLite:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

4. Run the migrations:

```bash
php artisan migrate
```

5. Start the Laravel server:

```bash
php artisan serve
```

### Frontend Configuration

1. Install JavaScript dependencies:

```bash
npm install
```

2. Start the Vite development server:

```bash
npm run dev
```

### Testing and linter

#### Laravel Tests

To run the Laravel tests, use the following command:

```bash
php artisan test
```
To run php cs fixer :

```bash
vendor/bin/php-cs-fixer fix
```

#### React Tests

To run ESLint:

```bash
npm run lint
```

To run Jest:

```bash
npm test
```

### CI

This project uses GitHub Actions for continuous integration. The configuration is located in `.github/workflows/ci.yml`.

### Contributing

Contributions are welcome! Please follow these steps:

1. Fork the project
2. Create your feature branch (`git checkout -b feature/feature-name`)
3. Commit your changes (`git commit -m 'Add some feature'`)
4. Push to the branch (`git push origin feature/feature-name`)
5. Open a Pull Request

### License

This project is licensed under the MIT License. See the [LICENSE](./LICENSE) file for more details.
