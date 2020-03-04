<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\City;
use App\User;
use App\Order;
use App\Service;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewOrder as NewOrderNotification;

class StoreOrder extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'mobile' => 'required',
            'email' => 'required|email',
            'date'  =>  'required|date_format:Y-m-d',
            'persons_count'  =>  'required|numeric',
            'city_id'  =>  'required|exists:cities,id',
            'location'  =>  'nullable',
            'address'  =>  'nullable',
            'notes'  =>  'nullable',
            'service_id' => 'required|exists:services,id',
        ];
    }

    /**
     * Create new order
     */
    public function store($validated)
    {
        $request = $this;
        $validated = $this->validated();

        $user = User::where(['mobile' => $this->mobile])->orWhere(['email' => $this->email])->first();

        # if user doesnt exist , create new user with the available information
        # remember to send the user notification with his credentials
        if ( ! $user ) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make(time()),
            ]);
        }

        # get service object
        $service = Service::where(['id' => $this->service_id])->first();
        # access provider infromation via service
        $provider = $service->provider;
        # get selected city object
        $city = City::where(['id' => $this->city_id])->first();

        # start createing new order
        $order = Order::create([
            # main order information
            'name' => $this->name,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'date' => $this->date,
            'persons_count' => $this->persons_count,
            'city_id' => $city->id,
            'address' => $this->address,
            'location' => '',
            'notes' => $this->notes,

            # store basic service information , in case it was updated
            'service_capacity' => $service->capacity,
            'service_price' => $service->price,
            'service_extra_person_price' => $service->extra_person_cost,

            'percentage_number' => $provider->getPercentage(),
            'percentage_amount' => $this->calcCateringPercentageAmount($service , $provider),

            'subtotal' => $service->price,
            'total' => $this->calcTotal($service , $provider),

            # attach foreign keys
            'service_id' => $service->id,
            'user_id' => $user->id,
            'provider_id' => $provider->id,
        ]);

        # disable this notifications for now
        # you still have aproblem in sending mails locally
        $notifyable = User::whereJsonContains('notifications->new_order', true)->active()->get();
        \Notification::send($notifyable, new NewOrderNotification($order));

        return $order;
    }

    /**
     * calcaulate order total
     * ignore taxes for now
     * just in case apply site percentage
     */
    public function calcTotal($service , $provider)
    {
        $subtotal = $service->price;
        $capacity = $service->capacity;

        # if user selects num of people more than service capacity
        if ( $this->persons_count > $capacity ) {
            $extra_persons = $this->persons_count - $capacity;
            $extra_persons_charge = $extra_persons * $service->extra_person_cost;

            $subtotal+= $extra_persons_charge;
        }

        # if we have taxes we should apply it
        return $subtotal;
    }

    /**
     * calcaulate catering amount
     */
    public function calcCateringPercentageAmount($service , $provider)
    {
        # site percentage
        $percentage = $provider->getPercentage();

        # total order amount
        $total = $this->calcTotal($service , $provider);

        # amount
        $amount = (($percentage/$total)*100);

        return $amount;
    }
}
