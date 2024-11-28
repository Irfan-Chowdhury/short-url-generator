<div align='center'>

# URL Shortening Service

</div>

## Task Overview
This project implements a URL shortening service, which allows users to shorten long URLs into short, easy-to-share links. The project includes the core functionality of the service. Cover unit tests for various scenarios. Additional optimizations for handling duplicate long URLs to ensure database efficiency and display all short urls records in a data table.

### 1. Data Structure : Hash Table

A `hash table`  is a data structure that maps keys to values using a hashing function. In the context of this URL shortening service, the hash table concept is applied to manage the relationship between the `original URL` and its corresponding `short code`.

<b>Storing Key-Value Pairs:</b>

- Key: The `short code` (6-character alphanumeric string).
- Value: The `original_url` (the long URL).

Hash tables offer <b>constant-time complexity (O(1))</b> for lookups and insertions, making them ideal for quickly checking if a short code or URL already exists. Although the system uses a `relational database` for actual storage, the logic for checking duplicates and generating unique short codes mirrors a hash table’s key-value mapping behavior.


### 2. Indexing :
Indexing is used to improve the `performance` of database queries and ensure that the database can efficiently handle lookups and maintain scalability as the number of URLs increases. They reduce the time complexity of queries, improving overall system performance. <br>
In this project, indexes are applied to the following fields:
- `short_code`: Helps in quickly retrieving records when a user accesses a short URL.
- `created_at`: Optimizes ordering records by their creation date to see all short urls data in a table list.



### 3. Approach to Handling Short URL Uniqueness :
- I <b>generate a random 6-character code</b> for each long URL using the `Str::random(6)` method in Laravel.
- <b>Check for existing short URL :</b> Before saving the new short URL, I check if the `original_url` already exists in the database:
    - If the `original_url` already exists, I return the existing `short_code` instead of creating a new one, which prevents duplicate data and reduces database load.    
    - If the `original_url` does not exist, a new `short_code` is created, and then return the short URL.
- <b>Collision Handling :</b>
    If a generated short code already exists (which is rare but possible), a new code is generated until a unique one is found. This process ensures that no two different URLs share the same short code

### 4. Validation:
Ensures only valid URLs are processed, enhancing security.
- <b>URL Format Validation:</b> Verifies that the input is a valid URL.
- <b>Malicious Input Prevention:</b> Protects against potential <b>XSS attacks</b> or <b>SQL injection</b> by sanitizing inputs and enforcing strict validation rules.

### 5. Unit Testing
- <b>Short Code Generation:</b>  Verifying that the generated short codes are unique and have the correct format.
- Duplicate Handling
- <b>Validation Logic:</b> Confirming that invalid URLs are rejected and valid ones are processed correctly.
- <b>Edge Cases:</b> Handling scenarios like empty URLs, extremely long URLs, or invalid characters.


### 6. Additional features :
- <b>Handling Duplicate Long URLs:</b> <br>
While the task did not explicitly require handling duplicate long URLs, I implemented this as an additional feature for optimization:
    - <b>Behavior:</b> Prevents storing duplicate long URLs by checking if a URL already exists in the database. If a duplicate is found, the existing short code is returned. 
    - <b>Why:</b> This reduces database storage overhead, ensures consistency and enhances the system’s efficiency and improve performance by avoiding redundant data and providing consistent short codes for the same long URL.

- <b>Display all Short URLs:</b> <br>
Created another page to display all shortened URL information, including the creation date and the total number of hits. The data is sorted in descending order by the creation date.

- <b>Count total clicks :</b> <br>
Created another feature to check how much click on a specific short url

## Technologies
- <b>Programming Language:</b> PHP 8.1
- <b>Framework:</b> Laravel 10
- <b>Code Formatter:</b> [Laravel Pint](https://laravel.com/docs/11.x/pint)
- <b>Testing Framework:</b> [PEST](https://pestphp.com)
- <b>Database:</b> MySQL

## How to run this project

### 1. Clone the Project
```bash
git clone git@github.com:Irfan-Chowdhury/url-shortening-service.git
cd <repository_directory>
``` 

### 2. Install dependencies: 
```bash
composer install
```

### 3. Set up your `.env` file and configure the database:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Run migrations: 
```bash
php artisan migrate
```

### 5. Run the development server:
```bash
php artisan serve
```

### 6. Access the application at 
```bash
http://localhost:8000
```


### 7. Seeder (Optional)
```bash
php artisan db:seed
```

## Test Case Result 
Here two type test. Feature and Unit Test. Just run below the command.
<br>
(Database will be refresh after running the tests.)

```bash
php artisan test
```

<img src="https://snipboard.io/LVf9yI.jpg">


## Visit Page

- Home Page : http://127.0.0.1:8000

<img src="https://snipboard.io/xRhpXc.jpg">

<br>

- All URL List : http://127.0.0.1:8000/all-url-list

<img src="https://snipboard.io/w348XF.jpg">


## Validation

- Field must be required : 

<img src="https://snipboard.io/NELT02.jpg">

<br>

- When try to input invalid url : 

<img src="https://snipboard.io/U4enZR.jpg">

<br>

## Conclusion
This URL shortening service meets the core requirements of shortening URLs. The implementation ensures efficient database usage, user-friendly behavior, and allows for easy scaling in the future.

