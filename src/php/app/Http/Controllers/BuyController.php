<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Item;
use App\Models\Topping;
use App\Models\OrderTopping;
use App\Models\Order;
use App\Models\Ipcontent;
use App\Models\DeliveryDestination;
use App\Exceptions\BuyException;
use App\Notifications\sendPurchaseCompletedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Notifications\Notifiable;
use Payjp\Charge;
use Carbon\Carbon;
use App\Http\Requests\BuyFormRequest;

class BuyController extends Controller
{
    use Notifiable;

    public function showBuyForm()
    {
        // 既にカートに商品が存在しているかどうか判別。
        session_start();
        //セッションを切りたくなったら
        // unset($_SESSION["orderItemList"]);
        // unset($_SESSION["orderToppingList"]);
        $priceIncludeTax = 0;
        if (isset($_SESSION['orderItemList'])) {
            $orderItemList = $_SESSION['orderItemList'];
            foreach ($orderItemList as $orderItem) {
                $priceIncludeTax += $orderItem->customed_price * $orderItem->quantity;
            }
        } else {
            $orderItemList = array();
        }

        if ($priceIncludeTax != 0) {
            $tax =  (int)($priceIncludeTax * 0.08);
            $priceIncludeTax += $tax;
        } else {
            $tax = 0;
        }

        if (isset($_SESSION['orderToppingList'])) {
            $orderToppingList = $_SESSION['orderToppingList'];
            foreach ($orderToppingList as $orderTopping) {
            }
        } else {
            $orderToppingList = array();
        }
        $user = Auth::user();
        $deliveryDestinations = DeliveryDestination::where('user_id', $user->id)->orderby('id', 'ASC')->get();

        foreach ($deliveryDestinations as $key => $deliveryDestination) {
            $zipcode = $deliveryDestination->zipcode;
            $zip1    = substr($zipcode, 0, 3);
            $zip2    = substr($zipcode, 3);
            $zipcode = $zip1 . "-" . $zip2;
            $deliveryDestination->zipcode = $zipcode;

            //電話番号のフォーマットは一旦保留
            // $telephone = $deliveryDestination->telephone;
            // if (mb_strlen($telephone) == 9) {
            //     $tel1    = substr($telephone, 0, 3);
            //     $tel2    = substr($telephone, 2, 3);
            //     $tel3    = substr($telephone, 5, 3);
            // } else {
            //     $tel1    = substr($telephone, 0, 4);
            //     $tel2    = substr($telephone, 3, 2);
            //     $tel3    = substr($telephone, 5, 4);
            // }
            // $telephone = $tel1 . "-" . $tel2 . '-' . $tel3;
            // $deliveryDestination->telephone = $telephone;
        }
        return view('buy-form', ['orderItemList' => $orderItemList, 'orderToppingList' => $orderToppingList, 'priceIncludeTax' => $priceIncludeTax, 'deliveryDestinations' => $deliveryDestinations, 'tax' => $tax]);
    }

    public function buyOrderItems(BuyFormRequest $request)
    {
        $token = $request->input('card-token');
        $userId = Auth::id();
        $deliveryDestination = DeliveryDestination::where('id', $request->place)->first();

        try {
            if ($token == null) {
                $token = 0;
            }
            $this->settlement($token, $request, $deliveryDestination);
        } catch (BuyException $e) {
            return redirect()->back()
                ->with('type', 'danger')
                ->with('message', 'カートに商品が追加されていません');
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()
                ->with('type', 'danger')
                ->with('message', '購入処理が失敗しました。');
        }

        return redirect()->back()->with('status', '購入完了しました');
    }

    private function settlement($token, $request, $deliveryDestination)
    {
        DB::beginTransaction();

        try {
            //orderをテーブルにinsert
            $order = new Order();
            $order->user_id = Auth::id();
            $order->price_include_tax = $request->price_include_tax;
            $order->order_date = Carbon::now();
            $order->delivery_destination_name = $deliveryDestination->delivery_destination_name;
            $order->zipcode = $deliveryDestination->zipcode;
            $order->address = $deliveryDestination->address;
            $order->telephone = $deliveryDestination->telephone;
            $order->payment_method = $request->payment_method;
            $order->save();

            //もし商品がカートに存在しない場合
            if ($request->item_id == null) {
                throw new BuyException;
            }

            //order_itemをテーブルにinsert。orderItemListを1回回している中に、orderToppingListをn回回す必要があると思う。
            for ($i = 0; $i < count($request->onetime_id); $i++) {
                $orderItem = new OrderItem();
                $orderItem->item_id = $request->item_id[$i];
                $orderItem->order_id = DB::table('orders')->latest('id')->value('id');
                $orderItem->customed_price = $request->customed_price[$i];
                $orderItem->quantity = $request->quantity[$i];
                $orderItem->save();

                //order_toppingをテーブルにinsert
                if ($request->topping_id != null) {
                    for ($j = 0; $j < count($request->topping_id); $j++) {
                        if ($request->order_item_id[$j] == $request->onetime_id[$i]) {
                            $orderTopping = new OrderTopping();
                            $orderTopping->order_item_id = DB::table('order_items')->latest('id')->value('id');
                            $orderTopping->topping_id = $request->topping_id[$j];
                            $orderTopping->save();
                        }
                    }
                }
            }

            if ($token != 0) {
                $charge = Charge::create([
                    'card'     => $token,
                    'amount'   => $request->price_include_tax,
                    'currency' => 'jpy'
                ]);
                if (!$charge->captured) {
                    throw new \Exception('支払い確定失敗');
                }
            }

            //セッションを切って、カートの中を空にする
            session_start();
            unset($_SESSION["orderItemList"]);
            unset($_SESSION["orderToppingList"]);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        // 購入完了したらIPContentをランダムで一つ、ユーザーに付与する
        $user = Auth::user();
        $IPContent = Ipcontent::inRandomOrder()->first();
        $user->ipcontents()->sync($IPContent->id, false);

        // 購入完了したらメールを送信する
        $price_include_tax = $request->price_include_tax;
        $order_date = Carbon::now();
        $zipcode = $deliveryDestination->zipcode;
        $address = $deliveryDestination->address;
        $payment_method = '';
        if ($request->payment_method == 1) {
            $payment_method = '店頭受け取り';
        } else if ($request->payment_method == 2) {
            $payment_method = 'クレジットカード';
        }
        $user->notify(new sendPurchaseCompletedMail($price_include_tax, $order_date, $zipcode, $address, $payment_method));
    }
}
