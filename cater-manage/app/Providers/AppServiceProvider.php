<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'package'   => \App\Models\Package::class,
            'menu_item' => \App\Models\MenuItem::class,
        ]);
        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Please Verify Email Address')
                ->view('emails.email-verification-msg', ['url' => $url]);
        });

        View::composer('*', function ($view) {
            $cartCount = 0;
            if (Auth::check()) {
                $user = Auth::user();
                $cart = $user->cart ?? Cart::create(['user_id' => $user->id]);
                $cartCount = CartItem::where('cart_id', $cart->id)->count(); 
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
