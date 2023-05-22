<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignUp;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {        
        $validator = Validator::make($request->all(), [  //zvaliduji si data
            'delayed_send' => 'required|date_format:Y-m-d',
            'email' => 'required|array',
            'email.*' => 'email',
            'bcc' => 'array', 
            'bcc.*' => 'email',              
            'label' => ['url', 'not_regex:/[<>{}]/'],
            'key' => ['required', 'not_regex:/[<>{}]/']
        ]);
        
        if ($validator->fails()) { //vrátím případné chyby ve formátu JSON
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $inputjson = json_decode($request->getContent());     //vytvořím si svůj email jako pole
        $mailData = [
            "key" => $inputjson->key,
            "delayed_send" => $inputjson->delayed_send,
            "email" => $inputjson->email,
            "bcc" => $inputjson->bcc,        
            "id" => $inputjson->body_data->id,
            "date" => $inputjson->body_data->date,           
            "label" => $inputjson->body_data->link->label,
            "url" => $inputjson->body_data->link->url 
        ];        
        try {
            Mail::to($mailData['email'])->send(new SignUp($mailData));  //odesílám email
            return response()->json(['message' => 'Email has been sent.', 'status' => '200'], Response::HTTP_OK);
        } catch (\Exception $e) {  //chytám případnou vyjímku pokud by se nepodařilo email odeslat, chyby vracím jako JSON.
            return response()->json(['message' => 'Failed to send email.', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }   
                                 
    }
}
