<?php

namespace Tests\Unit;

use App\Exceptions\PasswordFactoryException;
use App\Services\Factories\PasswordStrengthGeneratorFactory;
use PHPUnit\Framework\TestCase;

class PasswordGeneratorTest extends TestCase
{
    /**
     * @return void
     * @throws PasswordFactoryException
     */
    public function test_password_generate_hash_min_one_upper_case_and_min_two_lower_cases_success()
    {
        $passwordGenerator = PasswordStrengthGeneratorFactory::create(1, 6);
        $password = $passwordGenerator->generate();
        $this->assertMatchesRegularExpression("/[a-z]+/" , $password);
        $this->assertMatchesRegularExpression("/[A-Z]++/" , $password);
    }

    /**
     * @return void
     * @throws PasswordFactoryException
     */
    public function test_password_generate_string_min_one_upper_case_and_min_lower_case_and_int_range_from_2_to_5_success()
    {
        $passwordGenerator = PasswordStrengthGeneratorFactory::create(2, 6);
        $password = $passwordGenerator->generate();
        $this->assertMatchesRegularExpression("/[a-z]+/" , $password);
        $this->assertMatchesRegularExpression("/[A-Z]++/" , $password);
        $this->assertMatchesRegularExpression("/[2-5]+/" , $password);
    }

    /**
     * @return void
     * @throws PasswordFactoryException
     */
    public function test_password_generate_has_min_one_upper_case_and_min_lower_case_and_int_range_from_2_to_5_and_spec_chars_success()
    {
        $passwordGenerator = PasswordStrengthGeneratorFactory::create(3, 6);
        $password = $passwordGenerator->generate();
        $this->assertMatchesRegularExpression("/[a-z]+/" , $password);
        $this->assertMatchesRegularExpression("/[A-Z]++/" , $password);
        $this->assertMatchesRegularExpression("/\W+/" , $password);
        $this->assertMatchesRegularExpression("/[2-5]+/" , $password);
    }
}
