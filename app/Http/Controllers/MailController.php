<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SignUp;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MailController extends Controller
{
    public function index(Request $request) 
    {        
        // ************************* ZVALIDUJI SI DATA

        $validator = Validator::make($request->all(), [  //zvaliduji si data
            'delayed_send' => 'nullable|date_format:Y-m-d', // datum je bud prazdne-odesilam ihned, nebo v tomto formatu
            'email' => 'required|array',
            'email.*' => 'email',
            'bcc' => 'array', 
            'bcc.*' => 'email',              
            'label' => ['url', 'not_regex:/[<>{}]/'], //regulární výrazy, aby mi tam nešly html prvky atd
            'key' => ['required', 'not_regex:/[<>{}]/'] //regulární výrazy, aby mi tam nešly html prvky atd
        ]);
        
        if ($validator->fails()) {            
            Log::notice($validator->errors()); //loguji upozorneni že neprošlo validací
            return response()->json($validator->errors(), Response::HTTP_UNPROCESSABLE_ENTITY); //vrátím případné chyby ve formátu JSON
        }

        // ************************* VZTVOŘÍM SI EMAIL

        $inputjson = json_decode($request->getContent());     //vytvořím si svůj email jako pole
        $mailData = [
            "state" => "sended",
            "key" => $inputjson->key,
            "delayed_send" => $inputjson->delayed_send,
            "email" => $inputjson->email,
            "bcc" => $inputjson->bcc,        
            "id" => $inputjson->body_data->id,
            "date" => $inputjson->body_data->date,           
            "label" => $inputjson->body_data->link->label,
            "url" => $inputjson->body_data->link->url, 
            "ip" => $request->ip()  // zjistím z jaké IP adresy se k API přistupuje
        ];        

        // ************************* ODESÍLÁM EMAIL

        try {            
                if ($mailData['delayed_send'] === Carbon::now()->format('Y-m-d'))
                {
                        Mail::to($mailData['email'])->send(new SignUp($mailData));  //odesílám email           
                }
                 else 
                        Mail::to($mailData['email'])->later(1, new SignUp($mailData));  //přidávám do fronty email           

            Log::info(json_encode($mailData)); //loguji odeslaný email            
            return response()->json(['message' => 'Email has been sent.', 'status' => '200'], Response::HTTP_OK);
        } catch (\Exception $e) {  //chytám případnou vyjímku pokud by se nepodařilo email odeslat, chyby vracím jako JSON.
            $mailData['state'] = $e->getMessage(); //do pole  si zaznamenám chybu
            Log::error(json_encode($mailData)); //loguji error 
            return response()->json(['message' => 'Failed to send email.', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }   
                                 
    }
}
