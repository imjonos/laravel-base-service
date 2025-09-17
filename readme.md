# 📦 Laravel Base Service

[![Latest Version on Packagist](https://img.shields.io/packagist/v/imjonos/laravel-base-service.svg?style=flat-square)](https://packagist.org/packages/imjonos/laravel-base-service)  
[![Total Downloads](https://img.shields.io/packagist/dt/imjonos/laravel-base-service.svg?style=flat-square)](https://packagist.org/packages/imjonos/laravel-base-service)

A **generic base service class** for Laravel projects that provides a consistent and reusable way to handle business logic and data access. It integrates with `laravel-base-repository` and simplifies working with Eloquent models by encapsulating common operations like create, read, update, delete (CRUD), pagination, and more.

---

## 🧩 Overview

This package provides an abstract `BaseService` class that wraps around a repository and offers a clean interface for handling business logic in a structured and testable way. It is designed to be used in conjunction with the `laravel-base-repository` package, but it can also work with any custom repository implementing the required interface.

---

## 🛠 Installation

Install the package via Composer:

```bash
composer require imjonos/laravel-base-service
```

> ✅ This package depends on `imjonos/laravel-base-repository`. Make sure it is installed in your project as well.

---

## ✅ Usage

### 1. Create Your Service Class

Create a new service class that extends `BaseService` and specifies the repository class:

```php
namespace App\Services;

use App\Repositories\OrderRepository;
use Nos\BaseService\BaseService;

class OrderService extends BaseService
{
    protected string $repositoryClass = OrderRepository::class;
}
```

### 2. Use the Service in a Controller or Other Logic

Inject the service and use its methods:

```php
namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $orders = $this->orderService->all();
        return view('orders.index', compact('orders'));
    }

    public function store(Request $request)
    {
        $order = $this->orderService->create($request->all());
        return redirect()->route('orders.show', $order->id);
    }
}
```

---

## 🔧 Available Methods

| Method | Description |
|--------|-------------|
| `getRepository()` | Returns the repository instance |
| `all()` | Get all records |
| `count()` | Count all records |
| `find(int $modelId)` | Find a record by ID |
| `exists(int $modelId)` | Check if a record exists |
| `create(array $data)` | Create a new record (throws exception on failure) |
| `update(int $modelId, array $data)` | Update a record by ID |
| `delete(int $modelId)` | Delete a record by ID |
| `updateOrCreate(array $attributes, array $data)` | Update or create a record |
| `paginate(int $pageNumber, int $pageSize, callable $builderCallback)` | Paginate results with optional query builder callback |

---

## 🌐 Project Structure

```
vendor/
└── imjonos/
    └── laravel-base-service/
        ├── src/
        │   └── BaseService.php
```

---

## 📦 Requirements

- PHP 8.0+
- Laravel 9+

---

## 🧪 Testing

You can easily mock the service and its repository in your tests, which helps keep your application logic decoupled and improves test coverage.

---

## 📝 License

This package is open-sourced software licensed under the MIT license.
Please see the [license file](license.md) for more information.

---

## 🚀 Contributing

Please see [contributing.md](contributing.md) for details and a todolist.
