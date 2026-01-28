<?php

namespace App\Repositories\Parcel;

interface ParcelInterface
{

    public function all(string $status = null, int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc', array $select = []);
    public function deliveryManParcel();
    public function filter($request);
    public function get($id);
    public function parcelEvents($id);
    public function details($id);
    // public function statusUpdate($id, $status_id);
    public function store($request);
    public function update($request);
    public function delete($id);

    public function pickupManAssign($request);
    public function pickupManAssignedCancel($id);
    public function PickupReSchedule($request);
    public function PickupReScheduleCancel($id);
    public function receivedByPickupMan($id, $request);
    public function receivedByPickupManCancel($id);
    public function receivedWarehouse($request);
    public function receivedWarehouseCancel($id);
    public function transferToHubMultipleParcel($request);
    public function deliveryManAssignMultipleParcel($request);
    public function transferToHub($request);
    public function receivedByHub($request);
    public function receivedByHubCancel($id);
    public function transferToHubCancel($id);
    public function deliverymanAssign($request);
    public function deliverymanAssignCancel($id);
    public function deliveryReschedule($request);
    public function deliveryReScheduleCancel($id);
    public function returnToCourier($id, $request);
    public function returnToCourierCancel($id);
    public function returnAssignToMerchant($id, $request);
    public function returnAssignToMerchantCancel($id);
    public function returnAssignToMerchantReschedule($id, $request);
    public function returnAssignToMerchantRescheduleCancel($id);
    public function returnReceivedByMerchant($id, $request);
    public function returnReceivedByMerchantCancel($id);
    public function parcelDelivered($request);
    public function parcelDeliveredCancel($id);
    public function parcelPartialDelivered($request);
    public function parcelPartialDeliveredCancel($id);

    public function searchParcel($request);

    // public function search($data);
    // public function searchDeliveryManAssignMultipleParcel($data);
    // public function searchExpense($data);
    // public function searchIncome($data);
    public function parcelReceivedByMultipleHub($request);
    public function bulkPickupManAssign($request);
    public function AssignReturnToMerchantBulk($request);
    public function bulkParcels($ids);
    public function deliverymanStatusParcel($status);
    public function filterPrint($request);

    public function parcelSearch($request);


    public function deliverymanParcels($request);
    public function requestParcelDelivery($request);

    public function parcelBankToggle($id);


    public function codCollections(int $paginate = null, bool $paidByHero = null);

    public function getCharge($request);
}
