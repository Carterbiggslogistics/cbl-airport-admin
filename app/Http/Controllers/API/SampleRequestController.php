<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Order;
use Illuminate\Support\Facades\Storage;
use App\Services\OneSignalService;
use Ladumor\OneSignal\OneSignal;

class SampleRequestController extends Controller
{
    public function index()
    {
        $rider = auth()->guard('api')->user();
        $statuses = $this->riderAccessibleStatuses();


        $sampleRequests = $rider->sampleRequests()
            ->whereIn('status', $statuses)
            ->paginate(15);
        return response()->json(compact('sampleRequests'));
    } //end method index

    public function show($id)
    {
        $labQuery = function ($query) {
            $query->select("id", "fullname", "email", "address", "region", "city");
        };


        $rider = auth()->guard('api')->user();
        $sampleRequest = $rider->sampleRequests()
            ->with(["lab" => $labQuery])
            ->where('orders.id', $id)
            ->first();

        if ($sampleRequest == null)
            return response()->json(['message' => 'Not found'], 404);

        return response()->json(compact('sampleRequest'));
    } //end method show

    public function getStatuses()
    {
        return response()->json([
            'statuses' => array_keys($this->allStatuses())
        ]);
    } //end method getStatuses

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required',
            'image' => 'image'
        ]);

        //get all statuses
        $statuses = $this->allStatuses();

        //ensure the status is valid
        if (!key_exists($request->status, $statuses))
            return response()->json(['message' => 'invalid value for status'], 400);

        //get the authenticated rider
        $rider = auth()->guard('api')->user();

        //get the subject sample request (from the orders table)
        $sampleRequest = $rider->sampleRequests()->where('orders.id', $request->id)->first();

        //check if sample request (or order) is valid
        if ($sampleRequest == null)
            return response()->json(['message' => 'sample request not found for this rider'], 404);

        //if the the sample request (or order ) has been canceled, return an error
        if ($sampleRequest->status == Order::STATUS['CANCELED'])
            return response()->json(['message' => 'This sample request has been canceled, and cannot be edited'], 406);

        //update the status
        $sampleRequest->status = $statuses[$request->status];

        //if image exists in the request do the following
        if ($request->has('image') || $request->image != null) {


            $image  = Storage::disk('local')
                ->put(Order::STATUS_IMAGE_FOLDER_PATH, $request->file('image'));

            //delete image if it exists
            if ($sampleRequest->status_image_path) {
                try {
                    Storage::disk("local")->delete($sampleRequest->status_image_path);
                } catch (\Throwable $e) {
                }
            }

            $sampleRequest->status_image_path = $image;
        } //end if

        //commit changes
        $sampleRequest->save();

        $message = "Sample Request to '$sampleRequest->deliveryContactName' status changed to '{$request->status}' by the rider '$rider->fullname'";
        //Send push notification to all Admin users
        OneSignalService::sendPushToAdmins($message);

        // Send push notification to the rider
        if ($rider->devices()->exists()) {
            $message = "Sample Request to '$sampleRequest->deliveryContactName' status changed to '{$request->status}'";
            $fields['include_player_ids'] = $rider->devices()->pluck("os_player_id")->toArray();
            OneSignal::sendPush($fields, $message);
        }
        
        return response()->json(['message' => "status updated to '{$request->status}' successfully"]);
    } //end method chageStatus

    public function getStatusImage(Request $request, $id)
    {
        $rider = auth()->guard("api")->user();

        //get the subject sample request (from the orders table)
        $sampleRequest = $rider->sampleRequests()->where('orders.id', $id)->first();

        //check if sample request (or order) is valid
        if ($sampleRequest == null)
            return response()->json(['message' => 'sample request not found for this rider'], 404);

        if ($sampleRequest->status_image_path == null || $sampleRequest->status_image_path == "")
            return response()->json(['message' => 'sample request does not have an image'], 404);

        $url = storage_path("app/" . preg_replace("/^\//", "", $sampleRequest->status_image_path));

        return response()->file($url);
    } //end method getStatusImage

    private function allStatuses()
    {
        return (new \ArrayObject(Order::STATUS))->getArrayCopy();
    } //end method allStatuses

    private function riderAccessibleStatuses()
    {
        $statuses = $this->allStatuses();
        if (isset($statuses['CANCELED']))
            unset($statuses['CANCELED']);

        if (isset($statuses['COMPLETED']))
            unset($statuses['COMPLETED']);

        if (isset($statuses['PICKED-UP']))
            unset($statuses['PICKED-UP']);

        return $statuses;
    } //end method riderAccessibleStatuses
}//end method SampleRequestController
