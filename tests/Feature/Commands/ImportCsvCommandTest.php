<?php declare(strict_types=1);

namespace Tests\Feature\Commands;

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ImportCsvCommandTest extends TestCase
{
    use LazilyRefreshDatabase;

    /**
     * @return void
     */
    #[Test]
    public function test_success_path(): void
    {
        $this->artisan('app:import test.csv --storage=test')->assertOk();
    }

    /**
     * @return void
     */
    #[Test]
    public function test_failed_path_command_execute(): void
    {
        $this->artisan('app:import files/test')->assertFailed();
    }

    /**
     * @return void
     */
    #[Test]
    public function test_database_save_result()
    {
        $this->assertDatabaseMissing('tblProductData', [
            'strProductCode' => 'P0002',
        ]);

        $this->artisan('app:import test.csv --storage=test');

        $this->assertDatabaseHas('tblProductData', [
            'strProductCode' => 'P0002',
        ]);
    }
}
