<?php

namespace Database\Seeders;

use App\Enums\SalaryStatus;
use App\Enums\UserType;
use App\Models\Backend\Payroll\SalaryGenerate;
use App\Models\User;
use Illuminate\Database\Seeder;

class SalaryGenerateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::whereNot('user_type', UserType::MERCHANT)->get();

        foreach ($users as  $user) {
            $salary = new SalaryGenerate();
            $salary->user_id    = $user->id;
            $salary->month      = date('Y-m');
            $salary->amount     = $user->salary;
            $salary->allowance  = $this->allowances();
            $salary->deduction  = $this->deductions();
            $salary->status     = SalaryStatus::UNPAID;
            $salary->save();
        }
    }

    private function allowances(): array
    {
        return [
            ["name" => "Housing Allowance", "amount" => rand(3000, 5000)],
            ["name" => "Transportation Allowance", "amount" => rand(500, 900)],
            ["name" => "Meal Allowance", "amount" => rand(1500, 2000)],
            ["name" => "Healthcare Allowance", "amount" => rand(1000, 1200)],
            ["name" => "Phone Allowance", "amount" => rand(500, 900)],
        ];
    }

    private function deductions(): array
    {
        return [
            ["name" => "Income Tax", "amount" => rand(500, 1000)],
            ["name" => "Pension Contribution", "amount" => rand(200, 400)],
            ["name" => "Insurance Premium", "amount" => rand(300, 600)],
            ["name" => "Union Dues", "amount" => rand(50, 100)],
            ["name" => "Loan Repayment", "amount" => rand(200, 500)],
        ];
    }
}
