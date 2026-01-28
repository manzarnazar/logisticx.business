<?php

namespace Modules\Installer\Http\Controllers;

use App\Models\User;
use GeoSot\EnvEditor\Facades\EnvEditor;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Modules\Installer\Http\Requests\InstallRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;


class InstallerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        return view('installer::index');
    }

    public function do_install(InstallRequest $request)
    {

        try {

            ini_set('max_execution_time', 900); //900 seconds

            $host           = $request->host;
            $dbuser         = $request->dbuser;
            $dbpassword     = $request->dbpassword;
            $dbname         = $request->dbname;

            $first_name     = $request->first_name;
            $last_name      = $request->last_name;
            $user_name      = $first_name . ' ' . $last_name;
            $email          = $request->email;
            $login_password = $request->password ? $request->password : "";

            //    check for valid database connection
            $mysqli = @new \mysqli($host, $dbuser, $dbpassword, $dbname);

            if (mysqli_connect_errno()) {
                return redirect()->back()->with('error', 'Please input valid database information.')->withInput($request->all());
            }
            $mysqli->close();

            //check for valid email
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                return redirect()->back()->with('error', 'Please input a valid email.')->withInput($request->all());
            }


            //  set database details
            $this->envWrite('DB_HOST', $host);
            $this->envWrite('DB_DATABASE', $dbname);
            $this->envWrite('DB_USERNAME', $dbuser);
            $this->envWrite('DB_PASSWORD', $dbpassword);
            // sleep(3);

            Artisan::call('key:generate', [
                '--force' => true
            ]);
            Artisan::call('config:clear');

            $requestData = [
                'name'          => $user_name,
                'email'         => $email,
                'login_password' => $login_password
            ];

            return redirect()->route('final', $requestData);
        } catch (\Exception $e) {
            return back()->with('danger', $e->getMessage())->withInput();
        }
    }


    public function finish(Request $request)
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        foreach (DB::select('SHOW TABLES') as $table) {
            $table_array = get_object_vars($table);
            Schema::drop($table_array[key($table_array)]);
        }

        Artisan::call('migrate:refresh', [
            '--force' => true
        ]);
        Artisan::call('db:seed', [
            '--force' => true
        ]);

        $user                = User::find(1);
        $user->email         = $request->email;
        $user->name          = $request->name;
        $user->password      = bcrypt($request->login_password);
        $user->save();


        $this->envWrite('APP_INSTALLED', 'yes');

        return redirect('/');
    }

    //env write
    private function envWrite($key, $value)
    {
        if (EnvEditor::keyExists($key)) {
            EnvEditor::editKey($key, '"' . trim($value) . '"');
        } else {
            EnvEditor::addKey($key, '"' . trim($value) . '"');
        }
    }
}
