# Laravel Reverse Generate Migrations

Laravel Reverse Generate Migrations is a custom Laravel package that allows you to reverse generate migration files for all tables in your database, including their respective collation and charset settings. This can be useful when you want to generate migration files based on an existing database schema.

## Installation

To install the package, use Composer:

```
composer require kabir-ibi/laravel-reverse-generate-migrations
```

>N.B: To use this package only for dev environment, use following command ```composer require --dev kabir-ibi/laravel-reverse-generate-migrations```

# Usage
Once installed, you can run the `reverse:generate-all-migrations` command to generate migration files for all tables in the database:

```
php artisan reverse:generate-all-migrations
```

The migration files will be created in the database/migrations directory, with each file prefixed with a timestamp.

# Configuration
There is no additional configuration required for this package. The package will use the default database connection configured in your Laravel application.

# License
This package is open-source software licensed under the [MIT license](https://chat.openai.com/c/LICENSE).

# Contributing
Contributions are welcome! If you find any issues or want to contribute enhancements, please feel free to submit a pull request.

#About the Author
This package is maintained by KH MOHAIMENUL KABIR. You can contact me at skabir.diu@gmail.com.