<?php

namespace Xzxzyzyz\Laravel\FormRequest;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;

trait MultiMethodRule
{
    /**
     * Merge validation rules.
     *
     * @return array
     */
    public function mergeRules($baseRules, $mergeRules)
    {
        foreach ($mergeRules as $key => $rules) {
            if (array_key_exists($key, $baseRules)) {
                $baseRule = is_array($baseRules[$key])? $baseRules[$key]: explode('|', $baseRules[$key]);
            }
            else {
                $baseRule = [];
            }

            $rules = is_array($rules)? $rules: explode('|', $rules);

            foreach ($rules as $rule) {
                $baseRule[] = $rule;
            }

            $baseRules[$key] = $baseRule;
        }

        return $baseRules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function multiRules()
    {
        $rules = $this->rules();

        if ($this->method() === 'GET' && method_exists($this, 'getRules')) {
            $rules = $this->mergeRules($rules, $this->getRules());
        }
        elseif ($this->method() === 'POST' && method_exists($this, 'createRules')) {
            $rules = $this->mergeRules($rules, $this->createRules());
        }
        elseif ($this->method() === 'PUT' && method_exists($this, 'updateRules')) {
            $rules = $this->mergeRules($rules, $this->updateRules());
        }
        elseif ($this->method() === 'DELETE' && method_exists($this, 'deleteRules')) {
            $rules = $this->mergeRules($rules, $this->deleteRules());
        }

        return $rules;
    }

    /**
     * Create the default validator instance.
     *
     * @param  \Illuminate\Contracts\Validation\Factory  $factory
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function createDefaultValidator(ValidationFactory $factory)
    {
        return $factory->make(
            $this->validationData(), $this->container->call([$this, 'multiRules']),
            $this->messages(), $this->attributes()
        );
    }
}
