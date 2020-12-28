<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\OrderFormRequest;
use App\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Список заказов - получить список всех заказов в статусах 
     * “В поиске исполнителя”, “В работе”, “Выполнен”, “Отменен”
     *
     * @return \Illuminate\Http\Response
     */
    public function getOrders()
    {
        $orders = Order::get();
        if ($orders == null) return response(json_encode([
            'message' => 'Заказы не найдены'
        ], 404));

        return response(json_encode([
            'orders' => $orders,
        ]), 200);
    }

    /**
     * Информация по заказу (номер заказа) - общая информация по заказу
     * 
     * @return \Illuminate\Http\Response
     */
    public function getById(Request $request)
    {
        $order = Order::where('id', $request->id)->first();

        if ($order == null) return response(json_encode([
            'message' => 'Заказ не найден'
        ], 404));

        return response(json_encode([
            'order' => $order,
        ]), 200);
    }

    /**
     * Создание заказа  - статус автоматом “В поиске исполнителя”
     *
     * @return \Illuminate\Http\Response
     */
    public function create(OrderFormRequest $request)
    {
        $request->merge([
            'state' => 'SEARCH',
            'user_id' => Auth::user()->id,
        ]);
        $order = Order::create($request->all());

        return response(json_encode([
            'message' => 'Order successfully created',
            'order' => $order,
        ]), 201);
    }

    /** 
     * Отметить как “Выполнен” (номер заказа) - 
     * в этом случае заказ и заявка отмечаются как “Выполнен” 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function makeCompleted(Request $request)
    {
        $order = Order::where('id', $request->id)->update([
            'state' => 'DONE'
        ]);

        if ($order) {
            return response(json_encode([
                'Message' => 'Successfull, the order completed',
            ]), 200);
        }

        return response(json_encode([
            'Message' => 'Error, you should check your order id',
        ]), 404);
    }

    /** 
     * Отменить (номер заказа)
     * 
     * @return \Illuminate\Http\Response 
     */
    public function makeCancel(Request $request)
    {
        $order = Order::where('id', $request->id)
            ->where('state', '<>', 'DONE')
            ->update([
                'state' => 'CANCEL'
            ]);

        if ($order) {
            return response(json_encode([
                'Message' => 'Successfull, the order cancel',
            ]), 200);
        }

        return response(json_encode([
            'Message' => 'Error, you should check your order id, maybe it done already',
        ]), 404);
    }
}
