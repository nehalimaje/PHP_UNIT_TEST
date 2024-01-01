<?php

namespace App\Http\Controllers\Item;

use App\Http\Controllers\Controller;
use App\Models\ItemCategoryModel;
use Illuminate\Http\Request;
use App\Models\ItemModel;
use Illuminate\Support\Facades\Auth;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;
use Validator;

class ItemController extends Controller
{
    //CODE TO GET ALL ACTIVE ITEM DETAILS
    public function index()
    {
        //$user = Auth::user();
        return ItemModel::with('category')->where('isActive', '=', 0)->get();
    }

    //CODE TO INSERT ITEM DETAILS
    public function store(Request $request)
    {
        //return $request->all();
       
        //VALIDATE ALL REQUIRED FIELDS FROM REQUEST
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'item_name' => 'required',
            'item_desc' => 'required',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0'
        ]);

        $data = array(
            'item_name' => $request->item_name,
            'item_desc' => $request->item_desc,
            'price' => $request->price,
            'quantity' => $request->quantity
        );

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $response = [
                'status'  => false,
                'message' => $errorMessage,
            ];
            return response()->json($response, 401);
        } else {
            $result = ItemModel::create($data); // INSERT ITEM DETAILS
            $item_category_data = array(
                'item_id' => $result->id,
                'category_id' =>  $request->category_id
            );

            //INSERT ITEM AND CATEGORY DETAILS
            $item_category_result = ItemCategoryModel::create($item_category_data);


            //SEND EMAIL NOTIFICATION WHEN INSERT NEW ITEM
            // Create the Transport
            $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                ->setUsername('nehalimaje@gmail.com')
                ->setPassword('talkzjkqpgnksxfm');

            // Sendmail
            $mailer = new Swift_Mailer($transport);
            $message = (new Swift_Message())
                ->setSubject('New Item Details.')
                ->setFrom(['nehalimaje@gmail.com'])
                ->setTo(['neha.limaje@xplortechnologies.com' => 'Test']);
            $message->setBody('New Item Details are added as below.' . json_encode($data));
            //$mailer->send($message);
            // if ($mailer->send($message)) {
            //     //return "Mail sent";
            // } else {
            //     //return "Mail not sent.";
            // }
            return response()->json(["status" => 400, "message" => "Item details added successfully!"]);
        }
    }

    //CODE TO UPDATE ITEM DETAILS
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
            'item_name' => 'required',
            'item_desc' => 'required',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0'
        ]);

        $item = ItemModel::find($id);
        $item->item_name = $request->item_name;
        $item->item_desc = $request->item_desc;
        $item->price = $request->price;
        $item->quantity = $request->quantity;
        $categoryID = $request->category_id;

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $response = [
                'status'  => false,
                'message' => $errorMessage,
            ];
            return response()->json($response, 401);
        } else {
            if ($item->save()) {

                //UPDATE NEW CATEGORY DETAILS IN ITEMCATEGORY TABLE
                ItemCategoryModel::where('item_id', $id)->update(['category_id' => $categoryID]);
                $data = array(
                    'item_name' => $request->item_name,
                    'item_desc' => $request->item_desc,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                    'catgory' => $categoryID
                );

                //SEND EMAIL NOTIFICATION FOR UPDATED ITEMS.
                $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                    ->setUsername('nehalimaje@gmail.com')
                    ->setPassword('talkzjkqpgnksxfm');

                $mailer = new Swift_Mailer($transport);
                $message = (new Swift_Message())
                    ->setSubject('Updated Item Details.')
                    ->setFrom(['nehalimaje@gmail.com'])
                    ->setTo(['neha.limaje@xplortechnologies.com' => 'Test']);
                $message->setBody('Item details are updated. Updated Item Details are added as below.' . json_encode($data));
                //$mailer->send($message);

                // if ($mailer->send($message)) {
                //     //return "Mail sent";
                // } else {
                //     //return "Mail not sent.";
                // }
                return response()->json(["message" => "Item details are Updated!"], 404);
            } else {
                return response()->json(["message" => "Item details are not Updated"]);
            }
        }
    }

    public function delete(Request $request, $id)
    {
        $item = ItemModel::find($id);
        $item->isActive = 1;
        $itemdetails = ItemModel::where('id', '=', '3')->first();
        $itemName = $itemdetails->item_name;
        if ($item->save()) {
            //SEND EMAIL NOTIFICATION FOR UPDATED ITEMS.
            $transport = (new Swift_SmtpTransport('smtp.gmail.com', 587, 'tls'))
                ->setUsername('nehalimaje@gmail.com')
                ->setPassword('talkzjkqpgnksxfm');

            $mailer = new Swift_Mailer($transport);
            $message = (new Swift_Message())
                ->setSubject('Item is deleted.')
                ->setFrom(['nehalimaje@gmail.com'])
                ->setTo(['neha.limaje@xplortechnologies.com' => 'Test']);
            $message->setBody('Item id : ' . $id . ' name :' . $itemName . ' is deleted.');
            //$mailer->send($message);
            // if ($mailer->send($message)) {
            //     //return "Mail sent";
            // } else {
            //     //return "Mail not sent.";
            // }

            return response()->json(["message" => "Item details deleted successfully!"], 404);
        } else {
            return response()->json(["message" => "Unable to delete item details"]);
        }
    }

    public function getItemDetails(Request $request, $id)
    {
        $item = ItemModel::where('id', '=', $id)->get();
        if ($item) {
            return response()->json(['Item' => $item]);
        } else {
            return response()->json(['message' => 'No item details found.']);
        }
    }
}
