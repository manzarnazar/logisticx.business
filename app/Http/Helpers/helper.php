<?php

use Carbon\Carbon;
use App\Models\User;
use App\Enums\Status;
use App\Models\Config;
use App\Enums\UserType;
use App\Enums\ParcelStatus;
use App\Models\Backend\Hub;
use App\Models\Backend\Income;
use App\Models\Backend\Parcel;
use App\Models\Backend\Expense;
use App\Models\Backend\Payment;
use Modules\Section\Enums\Type;
use App\Models\Backend\HubInCharge;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Modules\Section\Entities\Section;
use App\Models\Backend\SmsSendSetting;
use App\Models\Backend\MerchantSetting;
use Illuminate\Support\Facades\Session;

if (!function_exists('pluck')) {
    function pluck($array, $value, $key = null)
    {
        $returnArray = [];
        if (count($array)) {
            foreach ($array as $item) {
                if ($key != null) {
                    $returnArray[$item->$key] = strtolower($value) == 'obj' ? $item : $item->$value;
                } else {
                    if ($value == 'obj') {
                        $returnArray[] = $item;
                    } else {
                        $returnArray[] = $item->$value;
                    }
                }
            }
        }
        return $returnArray;
    }
}

if (!function_exists('settingHelper')) {
    function settingHelper($key)
    {
        $data = Config::where('key', $key)->first();
        if (!blank($data)) :
            return $data->value;
        else :
            return '';
        endif;
    }
}

if (!function_exists('SmsSendSettingHelper')) {

    function SmsSendSettingHelper($status)
    {
        $data = SmsSendSetting::where(['sms_send_status' => $status, 'status' => Status::ACTIVE])->first();
        if (!blank($data)) :
            return true;
        else :
            return false;
        endif;
    }
}

//permission
if (!function_exists('hasPermission')) {
    function hasPermission($permission = null)
    {

        if (in_array($permission, Auth::user()->permissions)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('setEnv')) {
    function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name),
                $name . '=' . $value,
                file_get_contents($path)
            ));
        }
        return true;
    }
}

if (!function_exists('dateFormat')) {
    function dateFormat($newDate = null)
    {
        return date(settings('date_format'), strtotime($newDate));
    }
}

if (!function_exists('timeFormat')) {
    function timeFormat($newDate = null)
    {
        return date(settings('time_format'), strtotime($newDate));
    }
}

if (!function_exists('dateTimeFormat')) {
    function dateTimeFormat($datetime = null)
    {
        return date(settings('date_format') . ' ' . settings('time_format'), strtotime($datetime));
    }
}

if (!function_exists('parcelStatus')) {
    function parcelStatus($parcel, $request = null)
    {
        $parcelStatus = '';
        $allowStatus = [];

        if ($parcel->status  == ParcelStatus::PENDING) {
            $allowStatus = [ParcelStatus::PICKUP_ASSIGN];
        } elseif ($parcel->status == ParcelStatus::PICKUP_ASSIGN) {
            $allowStatus = [ParcelStatus::PICKUP_ASSIGN_CANCEL, ParcelStatus::PICKUP_RE_SCHEDULE, ParcelStatus::RECEIVED_WAREHOUSE,];
        } elseif (ParcelStatus::PICKUP_RE_SCHEDULE == $parcel->status) {
            $allowStatus = [ParcelStatus::PICKUP_RE_SCHEDULE_CANCEL, ParcelStatus::PICKUP_RE_SCHEDULE, ParcelStatus::RECEIVED_WAREHOUSE,];
        } elseif ($parcel->status == ParcelStatus::RECEIVED_WAREHOUSE || $parcel->status == ParcelStatus::RECEIVED_BY_HUB) {
            if ($parcel->status == ParcelStatus::RECEIVED_WAREHOUSE) {
                $allowStatus = [parcelStatus::RECEIVED_WAREHOUSE_CANCEL, ParcelStatus::TRANSFER_TO_HUB, ParcelStatus::DELIVERY_MAN_ASSIGN];
            } else {
                $allowStatus = [parcelStatus::RECEIVED_BY_HUB_CANCEL, ParcelStatus::TRANSFER_TO_HUB, ParcelStatus::DELIVERY_MAN_ASSIGN];
            }
        } elseif ($parcel->status == parcelStatus::TRANSFER_TO_HUB) {
            $allowStatus = [parcelStatus::TRANSFER_TO_HUB_CANCEL, parcelStatus::RECEIVED_BY_HUB];
        } elseif ($parcel->status == parcelStatus::RECEIVED_BY_HUB) {
            $allowStatus = [parcelStatus::RECEIVED_BY_HUB_CANCEL];
        } elseif ($parcel->status == ParcelStatus::DELIVERY_MAN_ASSIGN || $parcel->status == ParcelStatus::DELIVERY_RE_SCHEDULE) {
            if ($parcel->status == ParcelStatus::DELIVERY_MAN_ASSIGN) {
                $allowStatus = [parcelStatus::DELIVERY_MAN_ASSIGN_CANCEL, parcelStatus::DELIVERY_RE_SCHEDULE, ParcelStatus::RETURN_TO_COURIER, ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED, ParcelStatus::DELIVERED];
            } else {
                $allowStatus = [parcelStatus::DELIVERY_RE_SCHEDULE_CANCEL, parcelStatus::DELIVERY_RE_SCHEDULE, ParcelStatus::RETURN_TO_COURIER, ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED, ParcelStatus::DELIVERED];
            }
        } elseif ($parcel->status == parcelStatus::RETURN_TO_COURIER) {
            $allowStatus = [ParcelStatus::RETURN_TO_COURIER_CANCEL, ParcelStatus::RETURN_ASSIGN_TO_MERCHANT];
        } elseif ($parcel->status == ParcelStatus::RETURN_ASSIGN_TO_MERCHANT) {
            $allowStatus = [ParcelStatus::RETURN_ASSIGN_TO_MERCHANT_CANCEL, ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE, ParcelStatus::RETURN_RECEIVED_BY_MERCHANT];
        } elseif ($parcel->status == ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE) {
            $allowStatus = [ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE_CANCEL, ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE, ParcelStatus::RETURN_RECEIVED_BY_MERCHANT];
        } elseif ($parcel->status == ParcelStatus::RETURN_RECEIVED_BY_MERCHANT) {
            //
            $allowStatus = [ParcelStatus::RETURN_RECEIVED_BY_MERCHANT_CANCEL,];
        } elseif ($parcel->status == parcelStatus::DELIVERED) {
            //
            $allowStatus = [ParcelStatus::DELIVERED_CANCEL,];
        } elseif ($parcel->status == parcelStatus::PARTIAL_DELIVERED) {
            //
            $allowStatus = [ParcelStatus::PARTIAL_DELIVERED_CANCEL,];
        }



        $parcelStatusArray = [];
        if (!blank($allowStatus)) {
            foreach (config('site.status.parcel') as $key => $status) {
                if (in_array($key, $allowStatus)) {
                    $parcelStatusArray[$key] = $status;
                }
            }
        }

        if (!blank($parcelStatusArray)) {
            foreach ($parcelStatusArray as $key => $status) {

                if ($key == ParcelStatus::PICKUP_ASSIGN_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_pickup_assign_question') . '"  href="' . route("parcel.pickup.man-assigned-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::PICKUP_RE_SCHEDULE_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_pickup_reschedule_question') . '"  href="' . route("parcel.pickup.re-schedule-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::RECEIVED_BY_PICKUP_MAN_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_received_pickup_man_question') . '" href="' . route("parcel.pickup.man-received-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::RECEIVED_WAREHOUSE_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_received_warehouse_question') . '"  href="' . route("parcel.received-warehouse-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::DELIVERY_MAN_ASSIGN_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_delivery_man_assign_question') . '"  href="' . route("parcel.delivery-man-assign-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) .  '</a>';
                } elseif ($key == ParcelStatus::DELIVERY_RE_SCHEDULE_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_delivery_reschedule_question') . '"  href="' . route("parcel.delivery-re-schedule-cancel", $parcel->id) . '"  onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::TRANSFER_TO_HUB_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_transfer_hub_question') . '"  href="' . route("parcel.transfer-to-hub-cancel", $parcel->id) . '"  onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::RECEIVED_BY_HUB_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_received_by_hub_question') . '" href="' . route("parcel.received-by-hub-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::RETURN_TO_COURIER_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_return_to_courier_question') . '" href="' . route("parcel.return-to-courier-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::RETURN_ASSIGN_TO_MERCHANT_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_return_assign_to_merchant_question') . '" href="' . route("parcel.return-assign-to-merchant-cancel", $parcel->id) . '"  onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_return_reschedule_merchant_question') . '" href="' . route("parcel.return-assign-re-schedule-to-merchant-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::RETURN_RECEIVED_BY_MERCHANT_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_merchant_return_received_question') . '" href="' . route("parcel.return-received-by-merchant-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::DELIVERED_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_delivered_question') . '" href="' . route("parcel.delivered-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::PARTIAL_DELIVERED_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_partial_delivered_question') . '" href="' . route("parcel.partial-delivered-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } else {
                    if ($key == ParcelStatus::PICKUP_RE_SCHEDULE) {
                        $parcelStatus .= '<a  class="dropdown-item parcel-id-pickup-man" data-parcelstatus="' . ParcelStatus::PICKUP_ASSIGN . '" data-parcel="' . $parcel->id . '" data-parcel-hub-id="' . $parcel->hub_id . '" data-toggle="modal" data-target="#parcelstatus' . $key . '" href="#"> <i class="fa fa-repeat"></i> ' . ___('parcel.' . $status) . '</a>';
                    } elseif ($key == ParcelStatus::TRANSFER_TO_HUB) {
                        $parcelStatus .= '<a  class="dropdown-item parcel-id-transfer-hub" data-parcel="' . $parcel->id . '" data-parcel-hub-id="' . $parcel->hub_id . '" data-toggle="modal" data-target="#parcelstatus' . $key . '" href="#"> <i class="fa fa-repeat"></i> ' . ___('parcel.' . $status) . '</a>';
                    } elseif ($key == ParcelStatus::DELIVERY_RE_SCHEDULE) {
                        $parcelStatus .= '<a  class="dropdown-item parcel-id-delivery-man" data-parcelstatus="' . ParcelStatus::DELIVERY_MAN_ASSIGN . '" data-parcel="' . $parcel->id . '" data-toggle="modal" data-target="#parcelstatus' . $key . '" href="#"> <i class="fa fa-repeat"></i> ' . ___('parcel.' . $status) . '</a>';
                    } elseif ($key == ParcelStatus::RECEIVED_WAREHOUSE) {

                        $parcelStatus .= '<a  class="dropdown-item parcel-id received_warehouse" data-parcel="' . $parcel->id . '" data-toggle="modal" data-parcel="' . $parcel->id . '"  data-hub="' . $parcel->hub_id . '" data-url="' . route('parcel.received.warehouse.hub.select') . '" data-target="#parcelstatus' . $key . '" href="#"> <i class="fa fa-info"></i> ' . ___('parcel.' . $status) . '</a>';
                    } else {

                        $parcelStatus .= '<a  class="dropdown-item parcel-id" data-parcel="' . $parcel->id . '" data-parcel-hub-id="' . $parcel->hub_id . '" data-toggle="modal" data-target="#parcelstatus' . $key . '" href="#"> <i class="fa fa-share"></i> ' . ___('parcel.' . $status) . '</a>';
                    }
                }
            }
        }

        return $parcelStatus;
    }
}

if (!function_exists('DeliveryManParcelStatus')) {
    function DeliveryManParcelStatus($parcel, $request = null)
    {
        $parcelStatus = '';
        $allowStatus = [];

        if ($parcel->status == ParcelStatus::PICKUP_ASSIGN || $parcel->status == ParcelStatus::PICKUP_RE_SCHEDULE) {
            $allowStatus = [ParcelStatus::RECEIVED_WAREHOUSE];
        } elseif ($parcel->status == ParcelStatus::DELIVERY_MAN_ASSIGN || $parcel->status == ParcelStatus::DELIVERY_RE_SCHEDULE || ParcelStatus::RETURN_TO_COURIER_CANCEL) {
            $allowStatus = [ParcelStatus::RETURN_TO_COURIER, ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED];
        } elseif (ParcelStatus::RETURN_TO_COURIER == $parcel->status) {
            $allowStatus = [
                ParcelStatus::RETURN_TO_COURIER_CANCEL,
            ];
        } elseif ($parcel->status == ParcelStatus::DELIVERED) {

            $allowStatus = [];
        } elseif ($parcel->status == ParcelStatus::PARTIAL_DELIVERED) {

            $allowStatus = [ParcelStatus::PARTIAL_DELIVERED_CANCEL];
        } elseif ($parcel->status == ParcelStatus::DELIVERED_CANCEL || $parcel->status == ParcelStatus::PARTIAL_DELIVERED_CANCEL) {

            $allowStatus = [ParcelStatus::DELIVERY_RE_SCHEDULE];
        } elseif ($parcel->status == ParcelStatus::RETURN_ASSIGN_TO_MERCHANT || $parcel->status == ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE) {

            $allowStatus = [ParcelStatus::RETURN_RECEIVED_BY_MERCHANT];
        }

        $parcelStatusArray = [];
        if (!blank($allowStatus)) {
            foreach (config('site.status.parcel') as $key => $status) {
                if (in_array($key, $allowStatus)) {
                    $parcelStatusArray[$key] = $status;
                }
            }
        }


        if (!blank($parcelStatusArray)) {
            foreach ($parcelStatusArray as $key => $status) {

                if ($key == ParcelStatus::DELIVERED_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_delivered_question') . '" href="' . route("parcel.delivered-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::PARTIAL_DELIVERED_CANCEL) {
                    $parcelStatus .= '<a  class="dropdown-item" data-question="' . ___('parcel.cancel_partial_delivered_question') . '" href="' . route("parcel.partial-delivered-cancel", $parcel->id) . '" onclick="pleaseConfirm(event)"> <i class="fa fa-rotate-left"></i> ' . ___('parcel.' . $status) . '</a>';
                } elseif ($key == ParcelStatus::RECEIVED_WAREHOUSE) {

                    $parcelStatus .= '<a  class="dropdown-item parcel-id received_warehouse" data-parcel="' . $parcel->id . '" data-toggle="modal" data-parcel="' . $parcel->id . '"  data-hub="' . $parcel->hub_id . '" data-url="' . route('parcel.received.warehouse.hub.select') . '" data-target="#parcelstatus' . $key . '" href="#"> <i class="fa fa-info"></i> ' . ___('parcel.' . $status) . '</a>';
                } else {

                    $parcelStatus .= '<a  class="dropdown-item parcel-id" data-parcel="' . $parcel->id . '" data-parcel-hub-id="' . $parcel->hub_id . '" data-toggle="modal" data-target="#parcelstatus' . $key . '" href="#"> <i class="fa fa-share"></i> ' . ___('parcel.' . $status) . '</a>';
                }
            }
        }


        return $parcelStatus;
    }
}


if (!function_exists('StatusParcel')) {
    function StatusParcel($status_id)
    {
        $status = '';
        if ($status_id == ParcelStatus::PENDING) {
            $status = '<span class="bullet-badge bullet-badge-pending">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::PICKUP_ASSIGN) {
            $status = '<span class="bullet-badge bullet-badge-info">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::RECEIVED_WAREHOUSE) {
            $status = '<span class="bullet-badge bullet-badge-info">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::DELIVERY_MAN_ASSIGN) {
            $status = '<span class="bullet-badge bullet-badge-warning">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::DELIVERY_RE_SCHEDULE) {
            $status = '<span class="bullet-badge bullet-badge-info">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::RETURN_TO_COURIER) {
            $status = '<span class="bullet-badge bullet-badge-info">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::RETURN_ASSIGN_TO_MERCHANT) {
            $status = '<span class="bullet-badge bullet-badge-info">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::RETURN_MERCHANT_RE_SCHEDULE) {
            $status = '<span class="bullet-badge bullet-badge-info">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::RETURN_RECEIVED_BY_MERCHANT) {
            $status = '<span class="bullet-badge bullet-badge-success">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::DELIVERED) {
            $status = '<span class="bullet-badge bullet-badge-success">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::PARTIAL_DELIVERED) {
            $status = '<span class="bullet-badge bullet-badge-success">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::PICKUP_RE_SCHEDULE) {
            $status = '<span class="bullet-badge bullet-badge-info">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::RECEIVED_BY_PICKUP_MAN) {
            $status = '<span class="bullet-badge bullet-badge-success">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::TRANSFER_TO_HUB) {
            $status = '<span class="bullet-badge bullet-badge-info">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        } elseif ($status_id == ParcelStatus::RECEIVED_BY_HUB) {
            $status = '<span class="bullet-badge bullet-badge-info">' . ___('parcel.' . config('site.status.parcel.' . $status_id)) . '</span>';
        }
        return $status;
    }
}

if (!function_exists('merchantPayments')) {
    function merchantPayments($merchantID)
    {
        $totalMerchantPayments['paidAmount'] = 0;
        $totalMerchantPayments['pendingAmount'] = 0;
        $totalMerchantPayments['paidAmount'] =  Payment::whereIn('merchant_id', $merchantID)->where(['status' => \App\Enums\ApprovalStatus::APPROVED])->sum('amount');
        $totalMerchantPayments['pendingAmount'] =  Payment::whereIn('merchant_id', $merchantID)->where(['status' => \App\Enums\ApprovalStatus::PENDING])->sum('amount');
        return $totalMerchantPayments;
    }
}


if (!function_exists('totalParcelsCashcollection')) {
    function totalParcelsCashcollection($parcels)
    {
        $total_cash_collection = 0;
        foreach ($parcels as $key => $parcel) {
            $total_cash_collection += $parcel->sum('cash_collection');
        }
        return $total_cash_collection;
    }
}

if (!function_exists('withoutUser')) {

    function withoutUser($ids)
    {

        $user = User::WhereNotIn('id', $ids)->WhereNotIn('user_type', [UserType::DELIVERYMAN, UserType::MERCHANT])->where('status', Status::ACTIVE)->get();
        if (!blank($user)) :
            return $user;
        else :
            return [];
        endif;
    }
}

if (!function_exists('unpaidUser')) {
    function unpaidUser($ids)
    {
        $users = User::WhereIn('id', $ids)->WhereNotIn('user_type', [UserType::DELIVERYMAN, UserType::MERCHANT])->where('status', Status::ACTIVE)->get();
        if (!blank($users)) :
            return $users;
        else :
            return [];
        endif;
    }
}


if (!function_exists('user')) {
    function user($id)
    {
        $user = User::find($id);
        if (!blank($user)) :
            return $user;
        else :
            return '';
        endif;
    }
}

if (!function_exists('singleUser')) {
    function singleUser($id)
    {
        $user = User::find($id);
        if (!blank($user)) :
            return $user;
        else :
            return '';
        endif;
    }
}


//income
if (!function_exists('dayIncomeCount')) {
    function dayIncomeCount($date)
    {
        $date       = Carbon::parse($date)->format('Y-m-d');
        $income     = Income::where('date', $date)->get();
        if (!blank($income)) :
            return $income->sum('amount');
        else :
            return 0;
        endif;
    }
}

//expense
if (!function_exists('dayExpenseCount')) {
    function dayExpenseCount($date)
    {
        $date     = Carbon::parse($date)->format('Y-m-d');
        $Expense  = Expense::where('date', $date)->get();
        if (!blank($Expense)) :
            return $Expense->sum('amount');
        else :
            return 0;
        endif;
    }
}


if (!function_exists('parcelsStatus')) {

    function parcelsStatus($parcels, $ids = '', $parcel_ids = '')
    {

        if ($parcel_ids == '') :
            $parcel_ids = [];
            foreach ($parcels as $parcls) {
                foreach ($parcls as $key => $parcel) {
                    $parcel_ids[] = $parcel->id;
                }
            }
        endif;
        $parcels = Parcel::whereIn('id', $parcel_ids)->get();
        if ($ids !== '') :
            return $parcel_ids;

        else :
            return $parcels->groupBy('status');

        endif;
    }
}

if (!function_exists('idWiseParcels')) {

    function idWiseParcels($parcels, $neeId = '', $IdParcels = '')
    {

        if ($IdParcels !== '') :
            return Parcel::whereIn('id', $IdParcels)->get();
        elseif ($neeId !== '') :

            $p_ids = $parcels->pluck('id')->toArray();

            return $p_ids;
        endif;
    }
}

if (!function_exists('hubs')) {

    function hubs()
    {
        return Hub::all();
    }
}

if (!function_exists('hubIncharge')) {

    function hubIncharge()
    {
        $hub = HubInCharge::where('user_id', Auth::user()->id)->first();
        if ($hub != null) {
            return $hub->hub_id;
        } else {
            return 0;
        }
    }
}


if (!function_exists('oldLogDetails')) {

    function oldLogDetails($oldLogs, $newLogs)
    {
        foreach ($oldLogs as $key => $value) {
            if ($newLogs == $key) {
                return $value;
            }
        }
    }
}


if (!function_exists('asset')) {
    function asset($path = '')
    {
        if (strpos(php_sapi_name(), 'cli') !== false || defined('LARAVEL_START_FROM_PUBLIC')) {
            return  app('url')->asset($path);
        } else {
            return  app('url')->asset('public/' . $path);
        }
    }
}


if (!function_exists('MerchantSearchSettings')) {
    function MerchantSearchSettings($merchant_id, $key)
    {
        $settings   = MerchantSetting::where(['merchant_id' => $merchant_id, 'key' => $key])->first();
        if ($settings) :
            return $settings->value;
        endif;
        return null;
    }
}


function ___($key = null, $replace = [], $locale = null)
{
    try {
        $input       = explode('.', $key);
        $file        = $input[0];
        $term        = $input[1];
        $app_local   = defaultLanguage()->code ?? 'en';

        $jsonString  = file_get_contents(base_path('lang/' . $app_local . '/' . $file . '.json'));

        $data        = json_decode($jsonString, true);

        if (@$data[$term]) {
            return strtr($data[$term], $replace);
        }

        $data[$term] = ucfirst(strtolower(str_replace(['_', '-'], ' ', $term)));

        if (config('app.env') == 'local' && env('LANG_FILE_EDIT', false)) {
            $updatedJsonString = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            file_put_contents(base_path('lang/' . $app_local . '/' . $file . '.json'), $updatedJsonString);
        }

        return $data[$term] ?? $term;
    } catch (\Exception $e) {
        return $key;
    }
}

if (!function_exists('setEmailConfigurations')) {
    function setEmailConfigurations(): void
    {
        if (settings('mail_driver') == 'sendmail') config(['mail.mailers.sendmail.path' => settings('sendmail_path')]);

        config([
            'mail.default'                 => settings('mail_driver'),
            'mail.mailers.smtp.host'       => settings('mail_host'),
            'mail.mailers.smtp.port'       => settings('mail_port'),
            'mail.mailers.smtp.encryption' => settings('mail_encryption'),
            'mail.mailers.smtp.username'   => settings('mail_username'),
            'mail.mailers.smtp.password'   => decrypt(settings('mail_password')),
            'mail.from.address'            => settings('mail_address'),
            'mail.from.name'               => settings('mail_name')
        ]);
    }
}

if (!function_exists('demoUsers')) {

    function demoUsers()
    {
        $emails = ['superadmin@bugbuild.com', 'incharge@bugbuild.com', 'merchant@bugbuild.com', 'deliveryman@bugbuild.com'];
        return User::whereIn('email', $emails)->get();
    }
}

if (!function_exists('themeAppearance')) {
    /**
     * Get theme appearance settings.
     *
     * @param string|null $key The key of the setting to retrieve (optional).
     * @return array|string|null The theme appearance settings or the value of the specified key.
     */
    function themeAppearance($key = null): array|string|null
    {
        $theme = Cache::rememberForever('theme-appearance', fn() => Section::where('type', Type::THEME_APPEARANCE)->pluck('value', 'key')->toArray());

        return $key ? data_get($theme, $key) : $theme;
    }
}

if (!function_exists('primaryColorRgb')) {
    /**
     * Get primary color as RGB string for CSS (e.g. "255, 165, 0").
     * Uses theme appearance primary_color if set, otherwise default #FFA500.
     */
    function primaryColorRgb(): string
    {
        $hex = themeAppearance('primary_color') ?: '#FFA500';
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        return strlen($hex) === 6
            ? implode(', ', [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))])
            : '255, 165, 0';
    }
}
