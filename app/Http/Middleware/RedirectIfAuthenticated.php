<?php
namespace App\Http\Middleware; use Closure; use Illuminate\Support\Facades\Auth; class RedirectIfAuthenticated { public function handle($spa27895, Closure $sp5a8deb, $spfd664f = null) { if (Auth::guard($spfd664f)->check()) { return redirect('/home'); } return $sp5a8deb($spa27895); } }