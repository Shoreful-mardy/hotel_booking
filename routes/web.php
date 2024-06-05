<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Backend\TeamController;
use App\Http\Controllers\Backend\BookAreaController;
use App\Http\Controllers\Backend\RoomTypeController;
use App\Http\Controllers\Frontend\FrontendRoomController;
use App\Http\Controllers\Frontend\BookingController;
use App\Http\Controllers\Backend\RoomController;
use App\Http\Controllers\Backend\RoomListController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TestimonialController;
use App\Http\Controllers\Backend\BlogController;

// Route::get('/', function () {
//     return view('frontend.main_master');
// });
Route::get('/', [UserController::class, 'index']);

Route::get('/dashboard', function () {
    return view('frontend.dashboard.user_dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//===========Start User Group Middleware=======
Route::middleware('auth')->group(function () {

    Route::get('/profile', [UserController::class, 'Profile'])->name('user.profile');
    Route::get('/user/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/user/profile/store', [UserController::class, 'UserProfileStore'])->name('user.profile.store');
    Route::get('/user/change/password', [UserController::class, 'UserChangePassword'])->name('user.change.password');
    Route::post('/user/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');

     /// USER CHECKOUT ROUTE START FROM HERE
     Route::controller(BookingController::class)->group(function(){
        Route::get('/checkout/','CheckOut')->name('checkout');
        Route::post('/booking/store/','UserBookingStore')->name('user_booking_store');
        Route::post('/checkout/store/','CheckOutStore')->name('checkout.store');
        Route::match(['get', 'post'],'/stripe_pay', [BookingController::class, 'stripe_pay'])->name('stripe_pay');
     });
     ///  USER CHECKOUT ROUTE END HERE

     //User Booking Dashboard
     Route::controller(BookingController::class)->group(function(){
        Route::get('/user/booking/','UserBooking')->name('user.booking');
        Route::get('/user/invoice/{id}','UserDownloadInvoice')->name('user.invoice');
     });




});
//=======End User Group Middleware=======

require __DIR__.'/auth.php';
//===========Start Admin Group Middleware=======
 Route::middleware(['auth','roles'])->group(function(){
     Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
     Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
     Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
     Route::post('/admin/profile/store', [AdminController::class, 'AdminProfileStore'])->name('admin.profile.store');
     Route::get('/admin/change/password', [AdminController::class, 'AdminChangePassword'])->name('admin.change.password');
     Route::post('/admin/change/update', [AdminController::class, 'AdminChangeUpdate'])->name('admin.change.update');


     /// TEAM ALL ROUTE START FROM HERE
     Route::controller(TeamController::class)->group(function(){
        Route::get('/all/team','AllTeam')->name('all.team');
        Route::get('/add/team','AddTeam')->name('add.team');
        Route::post('/store/team','TeamStore')->name('team.store');
        Route::get('/edit/team/{id}','EditTeam')->name('edit.team');
        Route::post('/update/team','TeamUpdate')->name('team.update');
        Route::get('/delete/team/{id}','TeamDelete')->name('delete.team');
     });
     /// TEAM ALL ROUTE END  HERE


     /// BOOK AREA ALL ROUTE START FROM HERE
     Route::controller(BookAreaController::class)->group(function(){
        Route::get('/book/area/','BookArea')->name('book.area');
        Route::post('/update/book/area','UpdateBookArea')->name('update.book.area');
     });
     ///BOOK AREA ALL ROUTE END  HERE


     /// ROOM TYPE ALL ROUTE START FROM HERE
     Route::controller(RoomTypeController::class)->group(function(){
        Route::get('/room/type/','RoomTypeList')->name('room.type');
        Route::get('/add/room/type/','AddRoomType')->name('add.room.type');
        Route::post('/store/room/type/','StoreRoomType')->name('room.type.store');
     });
     ///ROOM TYPE ALL ROUTE END  HERE


     /// ROOM  ALL ROUTE START FROM HERE
     Route::controller(RoomController::class)->group(function(){
        Route::get('/edit/room/{id}','EditRoom')->name('edit.room');
        Route::post('/update/room/{id}','UpdateRoom')->name('update.room');
        Route::get('/multi/image/delete/{id}','MultiImageDelete')->name('multi.image.delete');
        Route::post('/store/room/no/{id}','StoreRoomNo')->name('store.room.no');
        Route::get('/edit/room/no/{id}','EditRoomNo')->name('edit.room.number');
        Route::post('/update/room/no/{id}','UpdateRoomNo')->name('update.room.no');
        Route::get('/delete/room/no/{id}','DeleteRoomNo')->name('delete.room.number');

        Route::get('/delete/room/{id}','DeleteRoom')->name('delete.room');
     });
     ///ROOM  ALL ROUTE END  HERE

     /// Admin booking ALL ROUTE START FROM HERE
     Route::controller(BookingController::class)->group(function(){
        Route::get('/booking/list/','BookingList')->name('booking.list');
        Route::get('/edit/booking/{id}','EditBooking')->name('edit_booking');
        Route::post('/update/booking/status/{id}','UpdateBookingStatus')->name('update.booking.status');
        Route::post('/update/booking/{id}','UpdateBooking')->name('update.booking');
        //For Assign Room Route
        Route::get('/assign/room/{id}','AssignRoom')->name('assign_room');
        Route::get('/assign/room/store/{booking_id}/{room_no_id}','AssignRoomStore')->name('assign_room_store');
        Route::get('/assign/room/delete/{id}','AssignRoomDelete')->name('assign_room_delete');

        Route::get('/download/invoice/{id}','DownloadInvoice')->name('download.invoice');
     });
     ///Admin booking ALL ROUTE END  HERE

     /// Room List All Route start
     Route::controller(RoomListController::class)->group(function(){
        Route::get('view/room/list/','ViewRoomList')->name('view.room.list');
        Route::get('add/room/list/','AddRoomList')->name('add.room.list');
        Route::post('/store/roomlist', 'StoreRoomList')->name('store.roomlist');
     });
     //Room List All Route end

     /// SMTP Setting All Route start
     Route::controller(SettingController::class)->group(function(){
        Route::get('smtp/setting/','SmtpSetting')->name('smtp.setting');
        Route::post('smtp/update/','SmtpUpdate')->name('smtp.update');
     });
     //SMTP Setting All Route end

     /// Testimonial All Route start
     Route::controller(TestimonialController::class)->group(function(){
        Route::get('/all/testimonial','AllTestimonial')->name('all.testimonial');
        Route::get('/add/testimonial','AddTestimonial')->name('add.testimonial');
        Route::post('/store/testimonial','StoreTestimonial')->name('testimonial.store');
        Route::get('/edit/testimonial/{id}','EditTestimonial')->name('edit.testimonial');
        Route::post('/update/testimonial/','UpdateTestimonial')->name('testimonial.update');
        Route::get('/delete/testimonial/{id}','DeleteTestimonial')->name('delete.testimonial');
     });
     //Testimonial All Route end


     /// Blog Category All Route start
     Route::controller(BlogController::class)->group(function(){

        Route::get('/all/blog/category','AllBlogCategory')->name('all.blog.category');
        Route::post('/store/blog/category','StoreBlogCategory')->name('store.blog.category');
        Route::get('/edit/blog/category/{id}','EditBlogCategory');
        Route::post('/update/blog/category','UpdateBlogCategory')->name('update.blog.category');
        Route::get('/delete/blog/category/{id}','DeleteBlogCategory')->name('delete.blog.category');

     });
     //Blog Category All Route end

     /// Blog Post All Route start
     Route::controller(BlogController::class)->group(function(){

        Route::get('/all/blog/post','AllBlogPost')->name('all.blog.post');
        Route::get('/add/blog/post','AddBlogPost')->name('add.blog.post');
        Route::post('/store/blog/post','StoreBlogPost')->name('store.blog.post');
        Route::get('/edit/blog/post/{id}','EditBlogPost')->name('edit.blog.post');
        Route::post('/update/blog/post/','UpdateBlogPost')->name('update.blog.post');
        Route::get('/delete/blog/post/{id}','DeleteBlogPost')->name('delete.blog.post');

     });
     //Blog Post All Route end



 });

 //=======End Admin Group Middleware=======



// admin login route
 Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
 // admin login route

/// FRONTENT ROOM  ALL ROUTE START FROM HERE
 Route::controller(FrontendRoomController::class)->group(function(){
    Route::get('all/rooms/','AllFrontendRooms')->name('froom.all');
    Route::get('/room/details/{id}','RoomDetailsPage');
    Route::get('/booking/search/','BookingSearch')->name('booking.search');
    Route::get('/search/room/details/{id}','SearchRoomDetails')->name('search_room_details');
    Route::get('/check_room_availability/', 'CheckRoomAvailability')->name('check_room_availability');
 });
///FRONTENT ROOM  ALL ROUTE END  HERE

///Frontend Blog Post All Route start
 Route::controller(BlogController::class)->group(function(){
    Route::get('/blog/details/{id}','BlogDetails')->name('blog.details');
    Route::get('/all/blog/','AllBlog')->name('all.blog');

 });
 //Frontend Blog Post All Route end

