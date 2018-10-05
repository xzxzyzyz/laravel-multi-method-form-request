# Laravel Multi Method Form Request

[![CircleCI](https://circleci.com/gh/xzxzyzyz/laravel-multi-method-form-request.svg?style=svg)](https://circleci.com/gh/xzxzyzyz/laravel-multi-method-form-request)
[![Latest Stable Version](https://poser.pugx.org/xzxzyzyz/laravel-multi-method-form-request/version)](https://packagist.org/packages/xzxzyzyz/laravel-multi-method-form-request)
[![License](https://poser.pugx.org/xzxzyzyz/laravel-multi-method-form-request/license)](https://packagist.org/packages/xzxzyzyz/laravel-multi-method-form-request)

Attaching the validation rules to the request method on `FormRequest`.

Rules will be merged when some requests.

## Installation

```bash
composer require xzxzyzyz/laravel-multi-method-form-request
```

## Usage

Using `Xzxzyzyz\Laravel\FormRequest\MultiMethodRule` trait in your `FormRequest` class.

```php
use Xzxzyzyz\Laravel\FormRequest\MultiMethodRule;

class ExampleRequest extends FormRequest
{
	use MultiMethodRule;
	
	// ...
}
```

Methods corresponding to each request method:

 Request Method  | Rule Method
:---------|:----------
 GET    | getRules()
 POST    | createRules()
 PUT    | updateRules()
 DELETE    | deleteRules()
 
 And, default `rules()` method is always merged.
 
 
### Example

FormRequest is:

```php
use Xzxzyzyz\Laravel\FormRequest\MultiMethodRule;

class ExampleRequest extends FormRequest
{
    use MultiMethodRule;

    public function rules()
    {
        return [
            'default' => 'required'
        ];
    }

    public function getRules()
    {
        return [
            'default' => 'it_is_get_rule',
            'get' => 'required'
        ];
    }

    public function createRules()
    {
        return [
            'default' => 'it_is_create_rule',
            'post' => 'required'
        ];
    }

    public function updateRules()
    {
        return [
            'default' => 'it_is_update_rule',
            'put' => 'required'
        ];
    }

    public function deleteRules()
    {
        return [
            'default' => 'it_is_delete_rule',
            'delete' => 'required'
        ];
    }
}
```

If `GET` request, Return rules is:

 name    | rules
:--------|:----------
 default | required, it_is_get_rule
 get     | required


If `POST` request, Return rules is:

 name    | rules
:--------|:----------
 default | required, it_is_create_rule
 post    | required


If `PUT` request, Return rules is:

 name    | rules
:--------|:----------
 default | required, it_is_update_rule
 put     | required


If `DELETE` request, Return rules is:

 name      | rules
:----------|:----------
 default   | required, it_is_delete_rule
 delete    | required
