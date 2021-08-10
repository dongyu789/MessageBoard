<?php


namespace App\Http\Controllers;






use Hufeiyu\CallBaiduVoice\CallBaiduVoice;
use Illuminate\Http\Request;

class BaiduVideoController extends Controller
{



    //接收语音进行处理
    public function receiveVideo(Request $request)
    {
        if($request->session()->get('login_status') != true) {
            return redirect('index/login');
        }
        return view('BaiduVideo/videoMessage');
    }

    //接收语音进行处理
    public function receiveVideoOver(Request $request)
    {
        $file = $request->file('video');
        if($file == null) {
            return view('leavingMessage', [
                'username' => $request->session()->get('username'),
                'message'=> ''
            ]);
        }
        $fileInfo = $file->getFileInfo();

        $pathName = $fileInfo->getPathname();

        //$client = new AipSpeech(APP_ID, API_KEY, SECRET_KEY);

        $format = $file->getClientOriginalExtension();
      // dd($format);

        if (!($format == 'wav' || $format == 'pcm' || $format == 'amr')) {
            return view('leavingMessage', [
                'username' => $request->session()->get('username'),
                'message'=> ''
            ]);
        }
        $rate = $format == 'amr' ? 8000 : 16000;
        $devPid = 1537;
        switch ($request->get('langType')) {
            case 1 :
                //普通话
                $devPid = 1537;
                break;
            case 2:
                //四川话
                $devPid = 1837;
                break;
            case 3:
                //粤语
                $devPid = 1637;
                break;
            case 4:
                //英语
                $devPid = 1737;
                break;
        }

       //$result = app(CallBaiduVoice::class)->voiceConversion($pathName, $format, $rate, $devPid);
        $test = new CallBaiduVoice();
        $result = $test->voiceConversion($pathName, $format, $rate, $devPid);
        $message = $result['result'][0];

        return view('leavingMessage', [
            'username' => $request->session()->get('username'),
            'message'=> $message
        ]);
    }

}
