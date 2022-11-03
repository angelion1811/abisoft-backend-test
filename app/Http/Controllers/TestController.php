<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PingRequest;
use Illuminate\Support\Facades\DB;
use App\Models\Test;
use App\Models\Item;
use App\Models\User;
use Auth;
class TestController extends Controller
{

    public function ping(PingRequest $request){
        $item = Item::where('id',$request['item_id'])->first();
        $pingResult  = $this->curlPing($item->ipv4);
        $test = Test::create([
            'item_id'=>$request['item_id'],
            'user_id'=>Auth::user()->id,
            'confirmed'=> $pingResult,
        ]);
        return response()->json($test, 201);
    }

    public function curlPing($ipv4)
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            exec("ping -n 4 " . $ipv4, $output, $result);
        } else {
            exec("ping -c 4 " . $ipv4, $output, $result);
        }
        return ($result == 0);
    }

    public function index(Request $request)
    {
        return response()->json(Test::with('user','item')->paginate());
    }

    public function getByUser(Request $request)
    {
        return response()->json(Test::where('user_id', $request['user_id'])->with('user','item')->paginate());
    }

    public function getByUsers(Request $request)
    {
        $result = Test::select(
                DB::raw("count(*) as total, user_id,
                        count(case confirmed when '1' then 1 else null end) as total_confirmed,
                        count(case confirmed when '0' then 1 else null end) as total_unconfirmed"))
                ->groupBy('user_id')
                ->with('user')
                ->paginate();
        return response()->json($result);
    }

    public function getToItem(Request $request)
    {
        return response()->json(Test::where('item_id', $request['item_id'])->with('user','item')->paginate());
    }

    public function getToItems(Request $request)
    {
        $result = Test::select(
            DB::raw("count(*) as total, item_id,
                    count(case confirmed when '1' then 1 else null end) as total_confirmed,
                    count(case confirmed when '0' then 1 else null end) as total_unconfirmed"))
            ->groupBy('item_id')
            ->with('item')
            ->paginate();
        return response()->json($result);
    }

    public function getGeneralReport(Request $request)
    {
        $result = Test::select(
            DB::raw("count(*) as total,
                    count(case confirmed when '1' then 1 else null end) as total_confirmed,
                    count(case confirmed when '0' then 1 else null end) as total_unconfirmed"))
            ->first();
        return response()->json($result);

    }

}
