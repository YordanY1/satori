<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\{
    Catalog,
    Authors,
    Events,
    Blog,
    About,
    Contact,
    BlogShow,
    BookShow,
    AuthorShow,
    EventShow,
    Cart,
    Checkout,
    OrderShow,
    Genres,
    GenreShow,
    ThankYou
};

use App\Http\Controllers\Http\Newsletter\ConfirmController;
use App\Http\Controllers\Http\Newsletter\UnsubscribeController;
use App\Http\Controllers\Http\Newsletter\ExcerptController;


use App\Livewire\Auth\LoginPage;
use App\Livewire\Auth\RegisterPage;
use App\Livewire\Profile\Overview;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Profile\Settings;
use App\Livewire\Profile\Orders;
use App\Livewire\Profile\Favorites;


use App\Livewire\Pages\PrivacyPolicy;
use App\Livewire\Pages\CookiePolicy;
use App\Livewire\Pages\Terms;




Route::get('/', Home::class)->name('home');

Route::get('/catalog', Catalog::class)->name('catalog');
Route::get('/authors', Authors::class)->name('authors');
Route::get('/events', Events::class)->name('events');
Route::get('/blog', Blog::class)->name('blog');
Route::get('/about', About::class)->name('about');
Route::get('/contact', Contact::class)->name('contact');

Route::get('/blog/{slug}', BlogShow::class)->name('blog.show');
Route::get('/book/{slug}', BookShow::class)->name('book.show');
Route::get('/author/{slug}', AuthorShow::class)->name('author.show');
Route::get('/event/{slug}', EventShow::class)->name('event.show');

Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/order/{id}', OrderShow::class)->name('order.show');

Route::get('/genres', Genres::class)->name('genres');
Route::get('/genre/{slug}', GenreShow::class)->name('genre.show');
Route::get('/thank-you/{order}', ThankYou::class)->name('thankyou');


Route::get('/newsletter/confirm/{token}', ConfirmController::class)->name('newsletter.confirm');
Route::get('/newsletter/unsubscribe/{token}', UnsubscribeController::class)->name('newsletter.unsubscribe');
Route::get('/newsletter/excerpt/{token}', ExcerptController::class)->name('newsletter.excerpt');


Route::middleware('guest')->group(function () {
    Route::get('/login', LoginPage::class)->name('login');
    Route::get('/register', RegisterPage::class)->name('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', Overview::class)->name('profile.overview');
    Route::get('/profile', Overview::class)->name('profile.overview');
    Route::get('/profile/orders', Orders::class)->name('profile.orders');
    Route::get('/profile/favorites', Favorites::class)->name('profile.favorites');
    Route::get('/profile/settings', Settings::class)->name('profile.settings');

    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('home');
    })->name('logout');
});


Route::get('/privacy-policy', PrivacyPolicy::class)->name('privacy');
Route::get('/cookie-policy', CookiePolicy::class)->name('cookies');
Route::get('/terms', Terms::class)->name('terms');
