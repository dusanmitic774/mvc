# mvc
- This is a simple MVC app.

## routes
```
Inside web.php file you register your routes
Route class has get() & post() methods, where both require 2 parameters
First being a route, and second controller name and a method to call
- example:
Route::get('/home', 'BlogsController@index');
```
### named routes
```
You can add named routes as well by chaining name() method
Route::get('/users/create', 'UsersController@create')->name('users.create');
```
## DB class
```
DB class has methods for basic CRUD operations
To use them, you need to create a instance of a Model class
```
### DB class methods
- get()
```
returns query results
```
- select()
```
accepts an array of column names, it will select those columns,
if left empty it will select *.
```
- where()
```
accepts an array of conditions, with each condition being an array
you can chain this onto select() method
-example:
$user = new User();
$results = $user->select()->where(['lname', '=', ''Mitic'], ['id', '<', 4]])->get()
```
- orWhere()
```
accepts an array of conditions, same as where
you can chain this onto where() method.
-example:
$user = new User();
$results = $user->select()->where(['lname', '=', ''Mitic']])->orWhere([['id', '=', 2]])->get()
```
- orderBy()
```
accepts 2 arguments, a column name(default is 'id') and direction in which to sort('ASC' or 'DESC')
you can chain this as well, it will sort according to second parameter, default being 'DESC'
-example:
$user = new User();
$results = $user->select()->orderBy('id', 'ASC')->get()
```
- limit()
```
accepts an integer value
limits the results to that number
-example:
$user = new User();
$results = $user->select()->orderBy('id', 'ASC')->limit(5)->get()
```
- find()
```
search based on id number
-example:
$user = new User();
$results = $user->select()->find(4)->get()
```
- first()
```
returns a first result
-example:
$user = new User();
$results = $user->select()->first()->get()
```
