<?php
namespace App\Repositories\SmsSetting;

interface SmsSettingInterface {

    public function all();
    public function get($id);
    public function store($data);
    public function update($id, $data);
    public function delete($id);

}
