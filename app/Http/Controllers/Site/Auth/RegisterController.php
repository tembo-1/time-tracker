<?php

namespace App\Http\Controllers\Site\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Site\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        $region = Region::query()
            ->where('id', $data['region'])
            ->first();

        $manager = ManagerRegion::query()
            ->where('region_id', $region->id)
            ->first()
            ->manager;

        unset($data['region']);

        $data['region_id']  = $region->id;
        $data['manager_id'] = $manager->id;

        $pass = Str::random(100);

        $user = User::query()
            ->create([
                'login'     => $data['inn'],
                'password'  => $pass,
                'role_id'   => 2,
            ])
            ->userInfo()
            ->create($data);

        $to_name = $data['email'];
        $to_email = $data['email'];



        Mail::send('emails.reg', ['pass' => $pass], function ($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Ваша заявка будет рассмотрена менеджером!');
            $message->from('b2b@sendis.ru', 'b2b@sendis.ru');
        });

        return $user;
    }
}
