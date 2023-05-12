<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\PackRequest;
use Illuminate\Support\Facades\Storage;
use App\Services\OneSignalService;
use Ladumor\OneSignal\OneSignal;

class PackRequestController extends Controller
{
    public function index()
    {
        $rider = auth()->guard('api')->user();
        $statuses = $this->riderAccessibleStatuses();

        $packRequests = $rider->packRequests()
            ->whereIn('status', $statuses)
            ->paginate(15);

        return response()->json(compact('packRequests'));
    } //end method index

    public function show($id)
    {
        $rider = auth()->guard('api')->user();
        $packRequest = $rider->packRequests()
            ->with(["warehouse" => function ($query) {
                $query->select("id", "location", "address");
            }])
            ->where('pack_requests.id', $id)
            ->first();

        if ($packRequest == null)
            return response()->json(['message' => 'Not found'], 404);

        return response()->json(compact('packRequest'));
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
            'image' => 'image',
        ]);

        $statuses = $this->allStatuses();

        if (!key_exists($request->status, $statuses))
            return response()->json(['message' => 'invalid value for status'], 400);

        $rider = auth()->guard('api')->user();
        $packRequest = $rider->packRequests()->where('pack_requests.id', $request->id)->first();

        if ($packRequest == null)
            return response()->json(['message' => 'pack request not found for this rider'], 404);

        if ($packRequest->status == PackRequest::STATUS['CANCELED'])
            return response()->json(['message' => 'This pack request has been canceled, and cannot be edited'], 406);

        $packRequest->status = $statuses[$request->status];

        //if image exists in the request do the following
        if ($request->has('image') || $request->image != null) {

            $image  = Storage::disk('local')
                ->put(PackRequest::STATUS_IMAGE_FOLDER_PATH, $request->file('image'));

            //delete image if it exists
            if ($packRequest->status_image_path) {
                try {
                    Storage::disk("local")->delete($packRequest->status_image_path);
                } catch (\Throwable $e) {
                }
            }

            $packRequest->status_image_path = $image;
        } //end if

        $packRequest->save();
        $message = "Pack Request '$packRequest->description' status changed to '{$request->status}' by the rider '$rider->fullname'";

        //Send push notification to all admins
        OneSignalService::sendPushToAdmins($message);

        // Send push notification to the rider
        if ($rider->devices()->exists()) {
            $message = "Pack Request '$packRequest->description' status changed to '{$request->status}''";
            $fields['include_player_ids'] = $rider->devices()->pluck("os_player_id")->toArray();
            OneSignal::sendPush($fields, $message);
        }

        return response()->json(['message' => "status updated to '{$request->status}' successfullynnn"]);
    } //end method chageStatus

    public function getStatusImage(Request $request, $id)
    {
        $rider = auth()->guard('api')->user();
        $packRequest = $rider->packRequests()->where('pack_requests.id', $request->id)->first();

        if ($packRequest == null)
            return response()->json(['message' => 'pack request not found for this rider'], 404);

        if ($packRequest->status_image_path == null || $packRequest->status_image_path == "")
            return response()->json(['message' => 'pack request does not have an image'], 404);

        $url = storage_path("app/" . preg_replace("/^\//", "", $packRequest->status_image_path));

        return response()->file($url);
    } //end method getStatusImage

    private function allStatuses()
    {
        return (new \ArrayObject(PackRequest::STATUS))->getArrayCopy();
    } //end method allStatuses

    private function riderAccessibleStatuses()
    {
        $statuses = $this->allStatuses();

        $exclude = [
            'PICKED UP',
            'CANCELED',
            'DELIVERED'
        ];

        foreach ($exclude as $e) {
            if (isset($statuses[$e]))
                unset($statuses[$e]);
        }

        return $statuses;
    } //end method riderAccessibleStatuses
}//end method PackRequestController
