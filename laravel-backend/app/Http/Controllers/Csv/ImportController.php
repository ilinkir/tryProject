<?php

namespace App\Http\Controllers\Csv;

use App\Http\Controllers\Controller;
use App\Http\Requests\UploadImportModelRequest;
use App\Models\Import;
use Illuminate\Support\Facades\Auth;
use League\Csv\Reader;
use League\Csv\Statement;

class ImportController extends Controller
{
    public function importProcess(UploadImportModelRequest $request)
    {
        $originalFile = $request->file('import_file');
        $import = Import::query()->create([
            'filename' => $originalFile->getClientOriginalName(),
            'user_id' => Auth::id(),
        ]);
        $file = $import->addMediaFromRequest('import_file')
            ->toMediaCollection('imports');
        $filename = storage_path('app/' . $file->id . '/' . $file->file_name);
        dd($filename);

        $csv = Reader::createFromPath($filename, 'r');
        $csv->setHeaderOffset(0)->setEnclosure("'"); //set the CSV header offset

        //get 25 records starting from the 11th row
        $stmt = Statement::create()
            ->offset(10)
            ->limit(25)
        ;

        $records = $stmt->process($csv);
        foreach ($records as $record) {
            dd($record);
        }
    }
}
