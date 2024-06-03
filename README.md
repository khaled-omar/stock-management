<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Task Description

In a system that has three main models; Product, Ingredient, and Order. A Burger (Product) may have several ingredients: 
- 150g Beef 
- 30g Cheese 
- 20g Onion 

The system keeps the stock of each of these ingredients stored in the database.
You can use the following levels for seeding the database: 
- 20kg Beef 
- 5kg Cheese 
- 1kg Onion 
When a customer makes an order that includes a Burger. 

The system needs to update the stock of each of the ingredients so it reflects the amounts consumed. 
Also when any of the ingredients stock level reaches 50%, the system should send an email message to alert the merchant they need to buy more of this ingredient. 
Requirements: 

First, Write a controller action that: 
1. Accepts the order details from the request payload. 
2. Persists the Order in the database. 
3. Updates the stock of the ingredients. 


Second, ensure that en email is sent once the level of any of the ingredients reach below 50%. Only a single email should be sent, further consumption of the same ingredient below 50% shouldn't trigger an email. 
Finally, write several test cases that assert the order was correctly stored and the stock was correctly updated. 
The incoming payload may look like this: 
``` 
{
    "products": [ 
        {
            "product_id": 1, 
            "quantity": 2, 
        } 
    ] 
}
```


## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 1500 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.



## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
