<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() { return view('welcome'); }
    public function login() { return view('auth.login'); }
    public function authenticate(Request $request) { return "Login attempt processed"; }
    public function register() { return view('auth.register'); }
    public function logout(Request $request) { return redirect('/'); }
}