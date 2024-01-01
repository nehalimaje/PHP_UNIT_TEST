# InventoryManagementSystem

Inventory Management System with Laravel 10 and MySql.

**#Features** : 
Item Management
Category Management

**Follow below steps to get clone of repository.**

1. Clone repository 'git clone https://github.com/nehalimaje5477/InventoryManagementSystem.git'
2. Go into the repository 'cd InventoryManagementSystem'.
3. Install package 'Composer Install'.
4. Add your database credentials to '.env' file.

**Start the laravel server with below command**
$ php artisan serve

**Run migration:**
$ php artisan migrate

**API Endpoints as below :**
**FOR Item :**
1. GET api/items : It will get all the item details.
2. POST api/items : It will create new item with provided details
3. PUT api/items/{id} : Update the specifiec item details
4. DELETE api/items/{id} : Delete the specific item.

**For Category:**
1. GET api/category : it will show all the categories.
2. POST api/category : it will insert new category.
3. PUT api/category/{id} : it will update specifiec category details
4. DELETE api/category/{id} : it will delete the category details. 

**Please check below link for postman collection.**
https://github.com/nehalimaje5477/InventoryManagementSystem/blob/master/InventorySystem.postman_collection.json

**Middleware details :** 
Bearer Token : 'secrete-auth-token'

