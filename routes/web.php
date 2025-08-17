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
    GenreShow
};

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
