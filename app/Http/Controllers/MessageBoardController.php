<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\ResetPasswordController;
use App\Jobs\CommentJob;
use App\Models\Comment;
use App\Models\Message;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\RegisterRequest;
use App\Service\CommentService;
use App\Service\MessageService;
use App\Service\RabbitMQService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Queue\RedisQueue;
use Illuminate\Support\Facades\Log;
use phpDocumentor\Reflection\Types\True_;

class MessageBoardController extends Controller
{

    //项目真实控制器

    //登录页面
    public function login()
    {
        return view('login');
    }

    //注册页面
    public function register()
    {
        return view('register');
    }

    //登录结束处理数据----->留言页面
    public function loginOver(LoginRequest $request)
    {
        $request->validated();

        $username = $request->get('username');
        $pwd = $request->get('pwd');
        $result = User::where('user_id', $username)->get();


        if ($result->isEmpty() || !(password_verify($pwd, $result[0]->pwd))) {
            return redirect()->route('MessageBoard.login');
        }
        //使用session记录登录状态
        $request->session()->put('username', $username);
        $request->session()->put('pwd', $pwd);
        $request->session()->put('login_status', true);

        //return 'hello';
        return redirect('/index/leavingMessage');
    }

    //留言页面
    public function leavingMessage(Request $request)
    {
        if ($request->session()->get('login_status') != true) {
            return redirect('index/login');
        }

        //返回视图,并且把用户名传过去，因为还要继续用
        return view('leavingMessage', [
            'username' => $request->session()->get('username'),
            'message'=> ''
        ]);
    }

    //注册完毕---->注册完毕-->跳转到登录页面
    public function registerOver(RegisterRequest $request)
    {
        //筛选
        $request->validated();

        $username = $request->get('username');
        $pwd = $request->get('pwd');

        $result = User::withTrashed()->where('user_id', $username)->get();

        if ($result->isEmpty()) {
            $user = new User();
            $user->user_id = $username;
            //对密码进行加密
            $user->pwd = password_hash($pwd, PASSWORD_DEFAULT);
            $user->save();
        } else {
            return redirect()->back();
        }


        $local = 'login';
        return <<<html
    <meta http-equiv="refresh" content="3;url='{$local}'">
            <div><center><h1>恭喜您，注册成功<br><br>三秒后自动跳转到登录页面</h1></center><br/></div>
                    
html;
    }

    //留言完毕----->留言完毕页面---->跳转到查看所有留言页面
    public function leavingMessageOver(Request $request)
    {
        //$request->validated();

        $username = $request->session()->get('username');
        $message = $request->get('message');


        Log::info('开始留言');
        //使用job来进行处理
        if (!empty($message)) {
            RabbitMQService::getInstance()->sendMessage($username, $message);
        }
        //$this->dispatch((new CommentJob($username, $message))->onQueue('comment'));

        return redirect()->route('MessageBoard.viewMessage');//注意这里
    }

    //查看所有留言
    public function viewMessage(Request $request)
    {
        $username = $request->session()->get('username', '游客');

        $messages = Message::paginate(5);
        //$messages = Message::get();
        return view('viewMessage', [
            'messages' => $messages,
            'username' => $username
        ]);

    }


    //查看自己的留言
    public function viewMyselfMessage(Request $request)
    {
        if ($request->session()->get('login_status') != true) {
            return redirect('/index/login');
        }
        $user_id = $request->session()->get('username');
        $id = User::where('user_id', $user_id)->first()->id;
        $messages = User::find($id)->message()->paginate(5);

        return view('viewMyselfMessage', [
            'messages' => $messages,
            'username' => $request->session()->get('username')
        ]);
    }

    //注销页面
    public function cancellation()
    {
        return view('cancellation');
    }

    //注销完毕-----跳转到注销完毕页面-----三秒后跳转到登录页面
    public function cancellationOver(Request $request)
    {
        $user_id = $request->get('username');
        $pwd = $request->get('pwd');

        $user = User::where('user_id', $user_id)->get();

        if ($user->isEmpty() || !(password_verify($pwd, $user[0]->pwd))) {
            return redirect()->back();
        } else {
            User::where('user_id', $user_id)->delete();
        }

        $local = 'login';
        return <<<html
    <meta http-equiv="refresh" content="3;url='{$local}'">
            <div><center><h1>注销成功，再见<br><br>三秒后自动跳转到登录页面</h1></center><br/></div>
                    
html;
    }

    //删除自己的留言
    public function deleteMessage(Request $request)
    {
        if ($request->session()->get('login_status') != true) {
            return redirect('index/login');
        }
        $message_id = $request->message_id;
        app(MessageService::class)->deleteMessage($message_id);

        return redirect('/index/viewMyselfMessage');
    }

    //编辑自己的留言
    public function updateMessage(Request $request)
    {
        $old_message = $request->old_message;
        $message_id = $request->message_id;
        return view('updateMessage', [
            'old_message' => $old_message,
            'message_id' => $message_id,
            'username' => $request->session()->get('username')
        ]);
    }

    //编辑留言完成
    public function updateMessageOver(Request $request)
    {
        $newMessage = $request->new_message;
        $messageId = $request->message_id;

        app(MessageService::class)->updateMessage($messageId, $newMessage);

        return redirect('/index/viewMyselfMessage');

        //return back();
    }

    //评论准备
    public function commentBegin(Request $request)
    {
        $request->session()->put('message_id', $request->get('message_id'));
        return redirect('/index/commentMessage');
    }

    //评论页面
    public function commentMessage(Request $request)
    {
        if ($request->session()->get('login_status') != true || !($request->session()->has('message_id'))) {
            return redirect('index/login');
        }

        $message_id = $request->session()->get('message_id');
        $message = Message::find($message_id);//主留言
        $comments = Comment::where('message_id', $message_id)->paginate(5);//其他评论

        return view('commentMessage', [
            'username' => $request->session()->get('username'),
            'message' => $message,
            'comments' => $comments
        ]);
    }

    //评论完成---跳转到评论页面
    public function commentMessageOver(Request $request)
    {
        $messageId = $request->get('message_id');
        $username = $request->session()->get('username');
        $comment = $request->get('comment');

        if (!empty($comment)) {
            app(CommentService::class)->commitComment($comment, $username, $messageId);
        }

        return redirect('index/commentMessage');
    }

    //退出
    public function quit(Request $request)
    {
        $request->session()->flush();
        return redirect('index/login');
    }




}
