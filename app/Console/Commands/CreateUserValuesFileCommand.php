<?php

namespace App\Console\Commands;

use App\Exceptions\FailedValidationException;
use App\Services\IO\UserFilterValuesIO;
use App\Services\Transformers\UserFilterValuesTransformerService;
use App\Services\ValidationService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 * class CreateImportFileCommand
 *
 * @package App\Console\Commands
 */
class CreateUserValuesFileCommand extends Command
{
    const EXPORT_FILE_NAME = 'user_values.json';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:create-user-values-file {languageCode} {fileName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to create import-ready file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param ValidationService                  $validationService
     * @param UserFilterValuesIO                 $userFilterValuesIO
     * @param UserFilterValuesTransformerService $userValuesTransformerService
     *
     * @return int
     */
    public function handle(
        ValidationService $validationService,
        UserFilterValuesIO $userFilterValuesIO,
        UserFilterValuesTransformerService $userValuesTransformerService
    ): int {
        $languageCode       = $this->argument('languageCode');
        $fileName       = $this->argument('fileName');
        $inputFilePath  = config('constants.input_path') . $fileName;
        $outputFilePath = config('constants.output_path') . self::EXPORT_FILE_NAME;

        try {
            $validationService->validateFileExists($inputFilePath);

            $userValuesCsvData = $userFilterValuesIO->readCSV($inputFilePath);

            $normalizedUserValues = $userValuesTransformerService->transform(
                $languageCode,
                $userValuesCsvData
            );

            $userFilterValuesIO->writeJson($outputFilePath, $normalizedUserValues);

            return SymfonyCommand::SUCCESS;
        } catch (FailedValidationException $exception) {
            $this->error($exception->getMessage());

            return SymfonyCommand::INVALID;
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());

            return SymfonyCommand::FAILURE;
        }
    }
}
