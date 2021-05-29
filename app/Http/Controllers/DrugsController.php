<?php

namespace App\Http\Controllers;

use App\Models\Drugs;
use Illuminate\Http\Request;

class DrugsController extends Controller
{
    public function index(Request $request)
    {
        #TODO Два поиска или фильтр
        $activeSubstance = '';
        $q = $request->input('q');
        $q = '+' . $q . '*';
        #TODO сервис
        $query = Drugs::query();
        $drugSearch = $query->whereRaw('MATCH(prep_full) AGAINST(? IN BOOLEAN MODE)', [$q])->get();

        foreach ($drugSearch as $drug) {
            $activeSubstance = $drug->as_name_rus;
            break;
        }

        $q = '+' . $activeSubstance . '*';
        $drugRecommended = $query->whereRaw('MATCH(as_name_primary) AGAINST(? IN BOOLEAN MODE)', [$activeSubstance])->get();

        return response()->json([
            'active_substance' => $activeSubstance,
            'drug_recommended' => $drugRecommended,
            'drug_search' => $drugSearch
        ]);
    }
}
