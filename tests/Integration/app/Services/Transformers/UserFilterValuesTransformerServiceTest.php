<?php

namespace Tests\Integration\app\Services\Transformers;

use App\Exceptions\FailedValidationException;
use App\Models\UserFilterValues;
use App\Services\Loaders\FilterLoader;
use App\Services\Loaders\UserLoader;
use App\Services\Transformers\UserFilterValuesTransformerService;
use Tests\TestCase;


/**
 * class UserFilterValuesTransformerServiceTest
 *
 * @package Tests\Feature\app\Services\Transformers
 */
class UserFilterValuesTransformerServiceTest extends TestCase
{
    /** @var UserFilterValuesTransformerService */
    private UserFilterValuesTransformerService $userFilterValuesTransformerService;

    /**
     * @return void
     *
     * @throws FailedValidationException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->userFilterValuesTransformerService = new UserFilterValuesTransformerService(
            new UserLoader(),
            new FilterLoader()
        );
    }

    /**
     * @return array[]
     */
    public function transformProvider(): array
    {
        return [
            'all csv values are found'      => [
                'languageCode'             => 'en',
                'csvData'                  => [
                    'ferrand.georges@hoolie.com' => [
                        'Salary bracket' => '[60k€ et +[',
                        'Contract type'  => 'Fixed-term contract',
                    ],
                ],
                'expectedUserFilterValues' => [
                    new UserFilterValues(
                        '60fa8738ddf98b7abc26ee90',
                        ['60fa8738ddf98b7abc26ee4f', '60fa8738ddf98b7abc26ee62']
                    ),
                ],
            ],
            'language code does not exist'  => [
                'languageCode'             => 'whatever',
                'csvData'                  => [
                    'ferrand.georges@hoolie.com' => [
                        'Salary bracket' => '[60k€ et +[',
                        'Contract type'  => 'Fixed-term contract',
                    ],
                ],
                'expectedUserFilterValues' => [
                    new UserFilterValues('60fa8738ddf98b7abc26ee90', []),
                ],
            ],
            '1 email is not found'          => [
                'languageCode'             => 'fr',
                'csvData'                  => [
                    'ferrand.georges@hoolie.com'   => [
                        'Tranche de salaire' => '[60k€ et +[',
                        'Type de contrat'    => 'CDD',
                    ],
                    'philippine.daniel@hoolie.com' => [
                        'Tranche de salaire' => '[60k€ et +[',
                        'Type de contrat'    => 'CDD',
                    ],
                    'bad email'                    => [
                        'Tranche de salaire' => '[60k€ et +[',
                        'Type de contrat'    => 'Fixed-term contract',
                    ],
                ],
                'expectedUserFilterValues' => [
                    new UserFilterValues(
                        '60fa8738ddf98b7abc26ee90',
                        ['60fa8738ddf98b7abc26ee4f', '60fa8738ddf98b7abc26ee62']
                    ),
                    new UserFilterValues(
                        '60fa8738ddf98b7abc26ee98',
                        ['60fa8738ddf98b7abc26ee4f', '60fa8738ddf98b7abc26ee62']
                    ),
                ],
            ],
            '1 filter is not found'         => [
                'languageCode'             => 'fr',
                'csvData'                  => [
                    'ferrand.georges@hoolie.com'   => [
                        'Tranche de salaire' => '[60k€ et +[',
                        'Type de contrat'    => 'CDD',
                    ],
                    'philippine.daniel@hoolie.com' => [
                        'Tranche de salaire'      => '[60k€ et +[',
                        'Le filtre n\'existe pas' => 'CDD',
                    ],
                ],
                'expectedUserFilterValues' => [
                    new UserFilterValues(
                        '60fa8738ddf98b7abc26ee90',
                        ['60fa8738ddf98b7abc26ee4f', '60fa8738ddf98b7abc26ee62']
                    ),
                    new UserFilterValues('60fa8738ddf98b7abc26ee98', ['60fa8738ddf98b7abc26ee4f']),
                ],
            ],
            '2 filter values are not found' => [
                'languageCode'             => 'en',
                'csvData'                  => [
                    'ferrand.georges@hoolie.com' => [
                        'Salary bracket' => '[60k€ et +[',
                        'Contract type'  => 'this value does not exist',
                        'Seniority'      => 'this value also does not exist',
                    ],
                ],
                'expectedUserFilterValues' => [
                    new UserFilterValues('60fa8738ddf98b7abc26ee90', ['60fa8738ddf98b7abc26ee4f']),
                ],
            ],

        ];
    }

    /**
     *
     * @dataProvider transformProvider
     *
     * @param string $languageCode
     * @param array  $csvData
     * @param array  $expectedUserFilterValues
     *
     * @return void
     */
    public function testTransform(string $languageCode, array $csvData, array $expectedUserFilterValues): void
    {
        $actualUserFilterValues = $this->userFilterValuesTransformerService->transform($languageCode, $csvData);

        self::assertEquals($actualUserFilterValues, $expectedUserFilterValues);
    }
}
