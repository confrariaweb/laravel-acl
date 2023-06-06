# Package ACL Laravel
This is a simple, easy to use access control (ACL) package for laravel.

Package page: 
[https://confrariaweb.github.io/laravel-acl](https://confrariaweb.github.io/laravel-acl)
## Package installation
> Before starting, you need to make sure that the database access settings are configured.


In your terminal just use the command line below.
```php
composer require confrariaweb/laravel-acl
```
After the installation is complete, add the following item to the array at app/http/kernel.php array $routeMiddleware.
```php
'check.permission' => \ConfrariaWeb\Acl\Middleware\CheckPermission::class,
```
The next configuration step you should only use if you are not using the "confrariaweb / laravel-user" package, if you are using this package there is no need to implement the configuration below as it is already included in the "laravel-user" package.
```php
class User extends Authenticatable
{
	//add this call to the application's user model
	use \ConfrariaWeb\Acl\Traits\AclTrait;
```
The next step is to place the configuration file in the "/config" directory.
```php
php artisan vendor:publish --provider="ConfrariaWeb\Acl\Providers\AclServiceProvider"
```
We are almost there, the next commands are to restructure the configuration cache and run the migration of the tables respectively.
At the command terminal, type the following commands.
```php
php artisan config:cache
php artisan migrate
```
Optional: You can run the command below to create some items in the database, it is not mandatory and you can still modify them later if you find it convenient.
```php
php artisan db:seed
```
Performing the above procedure the package is already available for use.
## Package usage
This package can be used at different points in your application.
### Use in middlewares
To use the middleware, it uses the route name as a permission parameter.
In the example below it checks if the user has the 'admin.profile' permission to access the route.
```php
Route::get('admin/profile', function () {
    //
})->middleware('check.permission')->name('admin.profile');
```
### Use in controllers
The proper way to use access control on controllers is as follows.
#### By roles
```php
abort_unless(Auth::user()->hasRole('name-role'), 403);
```
#### By permissions
```php
abort_unless(Auth::user()->hasPermission('name-permission'), 403);
```
#### Example of use
```php
<?php
namespace  App\Http\Controllers;
use Illuminate\Http\Request;
class  HomeController  extends  Controller
{
	public  function  index()
	{
		/*Here we check if the user is included in the roles of editing users*/
		abort_unless(Auth::user()->hasRole('edit-user'), 403);
		return  view('home');
	}
}
```
### Use in views
To do version control in views (.blade) you can use control by roles or permissions.
#### By roles
```php
@role('name-role')
<p>this content is only visible to those who have permission...</p>
@endrole
```
#### By permissions
```php
@permission('name-permission')
<p>this content is only visible to those who have permission...</p>
@endpermission
```
## License
The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).