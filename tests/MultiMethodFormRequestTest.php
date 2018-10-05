<?php

namespace Xzxzyzyz\Laravel\Test;

use Illuminate\Foundation\Http\FormRequest;
use Xzxzyzyz\Laravel\FormRequest\MultiMethodRule;

class MultiMethodFormRequestTest extends TestCase
{
    /**
     * @dataProvider dataMethods
     */
    public function testArrayRuleRequest($method)
    {
        $request = new ArrayRuleRequest;
        $request->setMethod(strtoupper($method));
        $rules = $request->multiRules();

        $this->assertArrayHasKey('default', $rules);
        $this->assertContains('required', $rules['default']);
        $this->assertContains('string', $rules['default']);
        $this->assertContains('url', $rules['default']);
        $this->assertContains('active_url', $rules['default']);

        $this->assertArrayHasKey($method, $rules);
        $this->assertContains('required', $rules[$method]);
        $this->assertContains('string', $rules[$method]);
    }

    /**
     * @dataProvider dataMethods
     */
    public function testStringRuleRequest($method)
    {
        $request = new StringRuleRequest;
        $request->setMethod(strtoupper($method));
        $rules = $request->multiRules();

        $this->assertArrayHasKey('default', $rules);
        $this->assertContains('required', $rules['default']);
        $this->assertContains('string', $rules['default']);
        $this->assertContains('url', $rules['default']);
        $this->assertContains('active_url', $rules['default']);

        $this->assertArrayHasKey($method, $rules);
        $this->assertContains('required', $rules[$method]);
        $this->assertContains('string', $rules[$method]);
    }

    /**
     * @dataProvider dataMethods
     */
    public function testMixRuleRequest($method)
    {
        $request = new MixRuleRequest;
        $request->setMethod(strtoupper($method));
        $rules = $request->multiRules();

        $this->assertArrayHasKey('default', $rules);
        $this->assertContains('required', $rules['default']);
        $this->assertContains('string', $rules['default']);
        $this->assertContains('url', $rules['default']);
        $this->assertContains('active_url', $rules['default']);

        $this->assertArrayHasKey($method, $rules);
        $this->assertContains('required', $rules[$method]);
        $this->assertContains('string', $rules[$method]);
    }

    /**
     * @dataProvider dataMethods
     */
    public function testNotExistsMethodRuleRequest($method)
    {
        $request = new NotExistsMethodRuleRequest;
        $request->setMethod(strtoupper($method));
        $rules = $request->multiRules();

        $this->assertArrayHasKey('default', $rules);
        $this->assertContains('required', $rules['default']);
        $this->assertContains('string', $rules['default']);
        $this->assertCount(2, $rules['default']);
    }

    public function dataMethods()
    {
        return [
            'GET' => ['get'],
            'POST' => ['post'],
            'PUT' => ['put'],
            'DELETE' => ['delete']
        ];
    }
}

class ArrayRuleRequest extends FormRequest
{
    use MultiMethodRule;

    public function rules()
    {
        return [
            'default' => [
                'required',
                'string'
            ]
        ];
    }

    public function getRules()
    {
        return [
            'default' => [
                'url',
                'active_url'
            ],
            'get' => [
                'required',
                'string'
            ]
        ];
    }

    public function createRules()
    {
        return [
            'default' => [
                'url',
                'active_url'
            ],
            'post' => [
                'required',
                'string'
            ]
        ];
    }

    public function updateRules()
    {
        return [
            'default' => [
                'url',
                'active_url'
            ],
            'put' => [
                'required',
                'string'
            ]
        ];
    }

    public function deleteRules()
    {
        return [
            'default' => [
                'url',
                'active_url'
            ],
            'delete' => [
                'required',
                'string'
            ]
        ];
    }
}

class StringRuleRequest extends FormRequest
{
    use MultiMethodRule;

    public function rules()
    {
        return [
            'default' => 'required|string'
        ];
    }

    public function getRules()
    {
        return [
            'default' => 'url|active_url',
            'get' => 'required|string'
        ];
    }

    public function createRules()
    {
        return [
            'default' => 'url|active_url',
            'post' => 'required|string'
        ];
    }

    public function updateRules()
    {
        return [
            'default' => 'url|active_url',
            'put' => 'required|string'
        ];
    }

    public function deleteRules()
    {
        return [
            'default' => 'url|active_url',
            'delete' => 'required|string'
        ];
    }
}

class MixRuleRequest extends FormRequest
{
    use MultiMethodRule;

    public function rules()
    {
        return [
            'default' => [
                'required',
                'string'
            ]
        ];
    }

    public function getRules()
    {
        return [
            'default' => 'url|active_url',
            'get' => 'required|string'
        ];
    }

    public function createRules()
    {
        return [
            'default' => 'url|active_url',
            'post' => 'required|string'
        ];
    }

    public function updateRules()
    {
        return [
            'default' => 'url|active_url',
            'put' => 'required|string'
        ];
    }

    public function deleteRules()
    {
        return [
            'default' => 'url|active_url',
            'delete' => 'required|string'
        ];
    }
}

class NotExistsMethodRuleRequest extends FormRequest
{
    use MultiMethodRule;

    public function rules()
    {
        return [
            'default' => [
                'required',
                'string'
            ]
        ];
    }
}
