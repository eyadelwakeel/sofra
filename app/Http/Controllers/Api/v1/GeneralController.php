<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;
use App\Models\City;
use App\Models\Restaurant;
use App\Models\Order;
use App\Models\Item;
use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class GeneralController extends Controller
{
    use ApiResponse;
    //
    public function cities()
    {
        $cities = City::all();
        return $this->api_data_response($cities);
    }

    public function restaurants()
    {
        $restaurants = Restaurant::all();
        foreach ($restaurants as $restaurant) {
            $avg = $restaurant->reviews()->avg('rating');
            $restaurant->avg_rating = round($avg);
        }
        return $this->api_data_response($restaurants);
    }

    public function items()
    {
        $items = Item::all();
        return $this->api_data_response($items);
    }

    public function orders()
    {
        $orders = Order::all();
        return $this->api_data_response($orders);
    }  

    public function get_resturant_by_search(Request $request)
    {
        $restaurants = Restaurant::where('name','like','%'.$request->search.'%')->get();
        return $this->api_data_response($restaurants);
    }

    public function get_item_by_search(Request $request)
    {
        $items = Item::where('name','like','%'.$request->search.'%')->get();
        return $this->api_data_response($items);
    }

    public function contact_us(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'phone' => 'required|string',
            'massage' => 'required|string',
            'status' => 'required|in:complaint,suggestion,inquery',
        ]);

        $user = auth()->user();

        $contact = new ContactUs();
        $contact->user_id = $user->id;
        $contact->email = $user->email;
        $contact->phone = $request->phone;
        $contact->massage = $request->massage;
        $contact->status = $request->status;
        $contact->save();

        return $this->api_success_massage('Contact Us message sent successfully');
    }
}
