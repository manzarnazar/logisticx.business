<?php

namespace App\Http\Controllers\Backend\Setting;

use Illuminate\Http\Request;
use App\Models\Backend\Currency;
use App\Http\Controllers\Controller;
use App\Http\Requests\MailTestRequest;
use App\Repositories\Settings\SettingsInterface;
use App\Http\Requests\Charges\COD\CodUpdateRequest;
use Modules\Language\Repositories\Language\LanguageInterface;

class SettingsController extends Controller
{
    protected $repo, $languageRepo;

    public function __construct(SettingsInterface $repo, LanguageInterface $languageRepo)
    {
        $this->repo         = $repo;
        $this->languageRepo = $languageRepo;
    }

    public function updateSettings(Request $request)
    {
        $result = $this->repo->UpdateSettings($request);
        if ($result['status']) {
            return redirect()->back()->with('success', $result['message']);
        }
        return back()->with('danger', $result['message'])->withInput();
    }

    public function generalSettings()
    {
        $currencies = cache()->remember('currencies', 60 * 60, fn() => Currency::all()); // Cache currencies for 1 hour
        $languages  = $this->languageRepo->all(status: true);

        return view('backend.setting.general_settings.index', compact('currencies', 'languages'));
    }

    public function recaptcha()
    {
        return view('backend.setting.recaptcha.index');
    }

    public function mailSettings()
    {
        return view('backend.setting.mail.index');
    }

    public function testSendMail(MailTestRequest $request)
    {
        $result = $this->repo->mailSendTest($request);

        if ($result['status']) {
            return  redirect()->route('settings.mail.index')->with('success', $result['message']);
        }
        return  redirect()->back()->with('danger', $result['message'])->withInput();
    }

    // Database Backup
    public function databaseBackupIndex()
    {
        return view('backend.setting.database-backup.index');
    }

    public function databaseBackupDownload()
    {
        if ($this->repo->dbBackupDownload()) {
            return redirect()->route('backup.index');
        }
        return redirect()->back();
    }

    public function codAndOthers()
    {
        return view('backend.charge.cod_and_others');
    }

    public function codAndOthersUpdate(CodUpdateRequest $request)
    {
        $result = $this->repo->UpdateSettings($request);

        if ($result['status']) {
            return redirect()->route('cod-and-others')->with('success', $result['message']);
        }
        return back()->with('danger', $result['message']);
    }
}
