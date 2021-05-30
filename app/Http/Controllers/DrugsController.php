<?php

namespace App\Http\Controllers;

use App\Models\Drugs;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DrugsController extends Controller
{
    #TODO массив с тимами лекарств? или доп.таблица(таблетки/мази/инъекции),
    # чтобы если в запросе это есть, то не выдывать другие лекарства
    public function index(Request $request)
    {

        #TODO Два поиска или фильтр(экран домой/основной/переход на поиск по дейст.вещ?(данные уже есть на клиенте))
        $q = urldecode($request->input('q'));

        $q = '+' . $q . '*';
        #TODO сервис
        $query = Drugs::query();
        $drugSearch = $query
            ->whereRaw('MATCH(prep_full) AGAINST(? IN BOOLEAN MODE)', [$q])
            ->get();

        $activeSubstance = current($drugSearch->all()) !== false ? current($drugSearch->all())->as_name_rus : '';

        $drugRecommended = $query->whereRaw('MATCH(as_name_primary) AGAINST(? IN BOOLEAN MODE)', [$activeSubstance])->get();

        return response()->json([
                'active_substance' => $activeSubstance,
                'drug_recommended' => $this->filterFields($drugRecommended),
                'drug_search' => $this->filterFields($drugSearch),
        ]);
    }

    private function filterFields(Collection $collect): array
    {
        foreach ($collect as $item) {
            $item = collect($item);
            $result[] = $item
                ->except([
                    'created_at', 'updated_at', 'amount', 'packing_id', 'desc_id', 'prep_id', 'as_id', 'dosage_form_id'
                ]);
        }
        return $result ?? [];
    }
}
