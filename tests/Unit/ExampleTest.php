<?php

namespace Tests\Unit;

use App\Http\Requests\Form\StoreRequest;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_that_true_is_true()
    {
        $request = new StoreRequest();
        // Set up the necessary data for the test
        $request->replace([
            'formId' => 2,
            'fields' => [
                '20' => 'adsfasdfa',
            ],
        ]);

        // Call the rules() method to get the validation rules
        $rules = $request->rules();

        // Call the validate() method to trigger validation
        $validator = $this->app['validator']->make($request->all(), $request->rules());
        $errors = $validator->errors();

        // Assert that the errors are as expected
        $this->assertTrue($validator->fails());
        // Add more assertions for the specific validation rules
    }
}
