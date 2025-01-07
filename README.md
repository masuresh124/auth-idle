
# Laravel Auth Idle Activity
This plugin offer an intuitive, user-friendly script where users can easily capture the session idle activitity of a user


## Installation

Install laravel auth idle component with the composer
```bash
 composer require masuresh124/auth-idle
```

Run the following command to publish the service provider
```bash
  php artisan vendor:publish --provider="Masuresh124\AuthIdle\Providers\AuthIdleProvider"
```

Add the following code in config\app.php
```javascript
 return [
  .
  .
  .
'providers'   =>[
  .
  .
  Masuresh124\AuthIdle\Providers\AuthIdleProvider::class
]
  ];
```
 
In `app\Http\Kernel.php` add the following middleware 
```javascript
     protected $routeMiddleware = [
        .
        .
        'auth-idle'      => \Masuresh124\AuthIdle\Http\Middleware\AuthIdleMiddleware::class,
    ];
```

In `routes/web.php` add the following middleware for routes
```javascript
  Auth::routes();

  Route::middleware(['auth', 'auth-idle'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
});
```


 
## Updating 
If the package is already installed and you are trying to update it to the latest version, please follow the instructions below:

 - Take a backup of the existing config file located at app/config/auth-idle.php.
 - Run the following commands:

 <p><b>Note: The commands below will replace the existing config file with the new one. After that, compare the new config file with your backup and add any missing values as needed.</b></p>
 
```bash
  composer require masuresh124/auth-idle
  php artisan vendor:publish --provider="Masuresh124\AuthIdle\Providers\AuthIdleProvider"  --tag="config-auth-idle" --force

```

## Badges
[![MIT License](https://img.shields.io/badge/License-MIT-green.svg)](https://choosealicense.com/licenses/mit/)

## Authors
- [@Suresh M A](https://github.com/masuresh124)

## Features

- Capture the user idle activity
- Can add custom time 
- Add custom conditions
 

