<?php

namespace App\Services;
use App\Models\Loan;
use App\Models\ReceivedRepayment;
use App\Models\User;
use App\Models\ScheduledRepayment;
class LoanService
{
    /**
     * Create a Loan
     *
     * @param  User  $user
     * @param  int  $amount
     * @param  string  $currencyCode
     * @param  int  $terms
     * @param  string  $processedAt
     *
     * @return Loan
     */




    public function createLoan(User $user, int $amount, string $currencyCode, int $terms, string $processedAt):Loan
    {
        //
    $create=Loan::factory()->create([
    'user_id'=>$user->id,
    'amount'=>$amount,
    'terms'=>$terms,
    'currency_code'=>$currencyCode,
    'processed_at'=>$processedAt,
    'outstanding_amount'=>$amount,
    'status'=>Loan::STATUS_DUE,
    ]);

//schedule repayments
$scheduledRepaymentOne = ScheduledRepayment::factory()->create([
    'loan_id'=>$create->id,
    'amount'=>1666,
    'outstanding_amount' => 1666,
    'currency_code' => Loan::CURRENCY_VND,
    'due_date' => '2020-02-20',
    'status' => ScheduledRepayment::STATUS_DUE,
    ]);

    $scheduledRepaymentTwo = ScheduledRepayment::factory()->create([
    'loan_id'=>$create->id,
    'amount'=>1666,
    'outstanding_amount' => 1666,
    'currency_code' => Loan::CURRENCY_VND,
    'due_date' => '2020-03-20',
    'status' => ScheduledRepayment::STATUS_DUE,
    ]);

    $scheduledRepaymentThree = ScheduledRepayment::factory()->create([
    'loan_id'=>$create->id,
    'amount'=>1667,
    'outstanding_amount' => 1667,
    'currency_code' => Loan::CURRENCY_VND,
    'due_date' => '2020-04-20',
    'status' => ScheduledRepayment::STATUS_DUE,
    ]);

return($create);
    }

    /**
     * Repay Scheduled Repayments for a Loan
     *
     * @param  Loan  $loan
     * @param  int  $amount
     * @param  string  $currencyCode
     * @param  string  $receivedAt
     *
     * @return ReceivedRepayment
     */
    public function repayLoan(Loan $loan, int $amount, string $currencyCode, string $receivedAt):ReceivedRepayment
    {
        //

$loan=Loan::find($loan->id);
$schedule1=ScheduledRepayment::find(1);
$schedule2=ScheduledRepayment::find(2);
$schedule3=ScheduledRepayment::find(3);

//fully paid
if($schedule3->outstanding_amount==0){
ScheduledRepayment::where('id',$schedule3->id)->update(['status'=>ScheduledRepayment::STATUS_REPAID]);

}





$receive=ReceivedRepayment::create([
'loan_id'=>$loan->id,
'amount'=>$amount,
'currency_code'=>$currencyCode,
'received_at'=>$receivedAt
]);

return($receive);
}












public function scheduledRepayments(){
return [['status'=>'due'],['status'=>'partial'],['status'=>'repaid']
     ];
}








//determine loan status
public function loan_status($amount,$outstanding_amount){
$status=null;
if($amount==$outstanding_amount){
$status=Loan::STATUS_DUE;
}else if($amount>$outstanding_amount){
$status=Loan::STATUS_REPAID;
}
return $status;
}






}
