<?php

use App\Models\Drugs;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('create_drugs', function () {
    $file = simplexml_load_string(file_get_contents(__DIR__ . '/../data.xml'));
    $json = json_encode($file);
    $data = current(json_decode($json, true));

    foreach ($data as $item) {
        if (!isset($item['as_name_rus'])) {
            continue;
        }
        $active = explode('+', $item['as_name_rus']);
        $drug = new Drugs();
        $drug->packing_id = isset($item['packing_id']) ? (int)$item['packing_id'] : null;
        $drug->desc_id = isset($item['desc_id']) && is_string($item['desc_id']) ? (int)$item['desc_id'] : null;
        $drug->prep_id = isset($item['prep_id']) ? (int)$item['prep_id'] : null;
        $drug->as_id = isset($item['as_id']) ? (int)$item['as_id'] : null;
        $drug->dosage_form_id = isset($item['dosage_form_id']) ? (int)$item['dosage_form_id'] : null;
        $drug->dosage_form_full_name = $item['dosage_form_full_name'] ?? null;
        $drug->as_name_rus = mb_strtolower($item['as_name_rus']);
        $drug->as_name_primary = isset($active[0]) ? mb_strtolower(trim($active[0])) : null;
        $drug->as_name_secondary = isset($active[1]) ? mb_strtolower(trim($active[1])) : null;
        $drug->amount = $item['amount'] ?? null;
        $drug->prep_short = mb_strtolower($item['prep_short']);
        $drug->prep_full = mb_strtolower($item['prep_full']);

        $drug->save();
    }
});

Artisan::command('add_price', function () {
    $drugs = Drugs::all();
    foreach ($drugs as $drug) {
        $drug->price = rand(50, 1050);
        $drug->save();
    }
});

Artisan::command('add_recipe', function () {
    $file = simplexml_load_string(file_get_contents(__DIR__ . '/../data2.xml'));
    $json = json_encode($file);
    $data = current(json_decode($json, true));

    foreach ($data as $item) {
        $drug = Drugs::find($item['prep_id']);
        if ($drug === null) {
            continue;
        }
        $drug->is_recipe = is_bool($item['no_recipe']) === false;
        $drug->save();

    }
});
