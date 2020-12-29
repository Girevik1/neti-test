<?php

namespace App\Http\Controllers\API;

use App\Application;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ApplicationFormRequest;
use App\Order;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * Создание (номер заказа - вызывает исполнитель)
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $currentUser = Auth::user();

        if ($currentUser->is_legal_person == 1) return response(json_encode([
            'message' => 'The intermediary cannot leave a request'
        ], 403));

        $currentOrder = Order::findOrFail($request->id);
        if ($currentOrder == null) return response(json_encode([
            'message' => 'Order not found'
        ], 404));

        $application = Application::where('order_id', $currentOrder->id)->first();
        if ($application != null) return response(json_encode([
            'message' => 'There is already an application for this order'
        ], 200));

        if ($currentOrder->user_id == $currentUser->id) return response(json_encode([
            'message' => 'The creator of the order cannot place a request for his order'
        ], 403));

        $request->merge([
            'state' => 'NEW',
            'user_id' => $currentUser->id,
            'order_id' => $currentOrder->id,
        ]);
        $application = Application::create($request->all());

        return response(json_encode([
            'message' => 'Application successfully created',
            'application' => $application,
        ]), 201);
    }

    /**
     * Принять заявку (вызывает Посредник)
     *
     * @return \Illuminate\Http\Response
     */
    public function acceptApplication(Request $request)
    {
        $currentUser = Auth::user();

        if ($currentUser->is_legal_person == 0) return response(json_encode([
            'message' => 'The executive person cannot leave a request'
        ], 403));

        $currentApplication = Application::findOrFail($request->id);

        if ($currentApplication == null) return response(json_encode([
            'message' => 'Application not found'
        ], 404));

        $order = $currentApplication->order;
        $order->state = 'WORKING';
        $currentApplication->state = 'WORKING';

        if ($order->save() && $currentApplication->save()) {
            return response(json_encode([
                'message' => 'Applications in a state WORKING',
            ]), 200);
        }

        return response(json_encode([
            'message' => 'Save error'
        ], 400));
    }
}
