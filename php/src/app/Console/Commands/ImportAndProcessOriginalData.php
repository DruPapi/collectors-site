<?php

namespace App\Console\Commands;

use App\Actions\CreatesOrdersByItems;
use App\Contracts\OnlyForDataImport;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Collectible;
use App\Models\Import\Kategoria;
use App\Models\Import\Kosar;
use App\Models\Import\Szalveta;
use App\Models\Import\UsersOld;
use App\Models\ItemType;
use App\Models\User;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportAndProcessOriginalData extends Command implements OnlyForDataImport
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-and-process-original';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import database contents from previous site and store it in the current database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Model::preventLazyLoading(false);

        $dumpFile = $this->getDumpFile();

        $this->prepare($dumpFile);

        $this->import($dumpFile);

        $this->fillPreviouslyHardcodedData();

        $this->mapOldData();
    }

    private function getDumpFile(): string
    {
        $disk = Storage::disk('previousDb');
        $files = $disk->allFiles();
        if (count($files) != 1) {
            throw new Exception('Could not find dump to import, there are ' . count($files) . ' files!');
        }

        return $disk->path($files[0]);
    }

    private function prepare($file): void
    {
        if (Schema::hasTable((new UsersOld)->getTable())) {
            throw new Exception('Looks like the import has already been completed!');
        }

        $this->alterFileToBeImported($file);
    }

    /**
     * Default DB dump file contains the selection of DB to be used
     * and the users table name is used in both systems.
     */
    private function alterFileToBeImported(string $file): void
    {
        File::put($file, Str::replace(
            [
                'CREATE DATABASE `szalveta` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;',
                'USE `szalveta`;',
                'CREATE TABLE IF NOT EXISTS `users` (',
                'INSERT INTO `users` (`ID`, `username`, `pass`, `email`, `nev`, `ir_szam`, `telepules`, `cim`, `telefon_szam`, `weblap`, `nyilvanos`) VALUES',
            ],
            [
                '',
                '',
                'CREATE TABLE IF NOT EXISTS `users_old` (',
                'INSERT INTO `users_old` (`ID`, `username`, `pass`, `email`, `nev`, `ir_szam`, `telepules`, `cim`, `telefon_szam`, `weblap`, `nyilvanos`) VALUES',
            ],
            File::get($file)
        ));
    }

    private function import(string $dumpFile): void
    {
        DB::unprepared(File::get($dumpFile));
    }

    private function mapOldData(): void
    {
        foreach ($this->getRelations() as $model => $relation) {
            app()->make($model)
                ->orderBy($relation['key'])
                ->chunk(
                    100,
                    fn (Collection $items) => $relation['target']::insert(
                        $items->map(fn ($item) => $item->toMappedRow())
                            ->all()
                    )
                );
        }

        (new CreatesOrdersByItems)->execute();
    }

    private function fillPreviouslyHardcodedData(): void
    {
        $types = [
            1 => 'Papírzsepi',
            2 => 'Fagyis',
            3 => 'Alátét',
            11 => 'Egyrétegű, Normál',
            12 => 'Egyrétegű, Koktél',
            13 => 'Egyrétegű, Kicsi',
            14 => 'Egyrétegű, Nagy',
            15 => 'Egyrétegű, Hosszúkás',
            21 => 'Többrétegű, Normál',
            22 => 'Többrétegű, Koktél',
            23 => 'Többrétegű, Kicsi',
            24 => 'Többrétegű, Nagy',
            25 => 'Többrétegű, Hosszúkás',
        ];

        foreach ($types as $id => $name) {
            (new ItemType)->forceFill([
                'id' => $id,
                'name' => $name,
            ])->save();
        }
    }

    private function getRelations(): array
    {
        return [
            UsersOld::class => [
                'key' => 'ID',
                'target' => User::class,
            ],
            Kategoria::class => [
                'key' => 'ID',
                'target' => Category::class,
            ],
            Szalveta::class => [
                'key' => 'szalveta',
                'target' => Collectible::class,
            ],
            Kosar::class => [
                'key' => 'szalveta',
                'target' => CartItem::class,
            ],
        ];
    }
}
