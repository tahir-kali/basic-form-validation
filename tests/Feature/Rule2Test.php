<?php

namespace Tests\Feature;

use App\Http\Requests\Form\StoreRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class Rule2Test extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $request = new StoreRequest();
        // Set up the necessary data for the test
        $request->replace([
            'formId' => 2,
            'fields' => [
                '20' => 2222,
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
