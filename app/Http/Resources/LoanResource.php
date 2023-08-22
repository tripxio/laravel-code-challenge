<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use App\Models\Loan;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request):array
    {
        return [
        'id'=>$this->id,
        'user_id'=>$this->user_id,
        'amount'=>$this->amount,
        'terms'=>$this->terms,
        'processed_at'=>$this->processes_at,
        'outstanding_amount'=>$this->outstanding_amount,
        'currency_code'=>$this->currency_code
        ];
    }
}
