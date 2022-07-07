<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\SendMail;
use App\Models\User;

class MailController extends Controller
{
    public function index()
    {
        $stockData = [
            'title' => 'Correo de cafeteriakonecta@gmail.com',
            'body' => 'El stock de los productos esta a punto de agotarse, se recomienda surtir la tienda.'
        ];

        $rol = User::select('email')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'cliente');
        })->get();

        Mail::to($rol)->send(new SendMail ($stockData));

        return response()->json([
            'message' => 'Correo enviado con exito',
        ]);
    }
}
