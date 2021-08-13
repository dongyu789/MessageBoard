<?php
/**
 *
 * 用来进行es筛选
 */

namespace App\Http\Controllers;

use App\Service\ESSearchMessageService;
use Illuminate\Http\Request;

class ESController extends Controller
{
    //
    public function elasticSearchMessage(Request $request)
    {
        $username = $request->session()->get('username');
        $tags = $request->input('tags');

        if ($tags == null) {
            return view('esMessage', [
                'username' => $username,
                'datas' => []
            ]);
        }

        $datas = app(ESSearchMessageService::class)->searchMessage($tags);



        return view('esMessage',[
            'username' => $username,
            'datas' => $datas
        ]);
    }
}
