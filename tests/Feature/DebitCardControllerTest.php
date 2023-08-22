<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Models\DebitCard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Carbon\Carbon;
use App\Models\DebitCardTransaction;



class DebitCardControllerTest extends TestCase
{
use RefreshDatabase;

protected User $user;
protected DebitCard $debitCard;

protected function setUp(): void
{
parent::setUp();

$this->user = User::factory()->create();
Passport::actingAs($this->user);
$this->artisan('passport:install');



}

public function testCustomerCanSeeAListOfDebitCards(){
//Get access token
$accessToken = Auth::user()->createToken('authToken')->accessToken;
$this->assertJson($this->user);
$this->assertAuthenticatedAs(Auth::user());
//create cards
$card=DebitCard::factory()->count(10)->create();
$this->assertJson($card);
$response=$this->withHeaders(['Authorization'=>'Bearer'.$accessToken])
->json('GET','api/debit-cards');
$response->assertSuccessful();


}




public function testCustomerCannotSeeAListOfDebitCardsOfOtherCustomers(){
// get /debit-cards
$accessToken = Auth::user()->createToken('authToken')->accessToken;
$this->assertJson($this->user);
$this->assertAuthenticatedAs(Auth::user());
//create cards
$card=DebitCard::factory()->count(10)->create();
$count=DebitCard::where('user_id',Auth::user()->id)->count();
$this->assertEquals(0,$count);
$response=$this->withHeaders(['Authorization'=>'Bearer'.$accessToken])
->get('api/debit-cards',['user_id'=>Auth::user()->id]);
$response->assertSuccessful();

}




public function testCustomerCanCreateADebitCard()
{
$accessToken = Auth::user()->createToken('authToken')->accessToken;
$this->assertJson($this->user);
$uid=$this->user->id;
//Debit card attributes.
$data=['number'=>100000,
'type'=>'Visa Retired',
'user_id'=>$uid,
'expiration_date'=>Carbon::now(),
'created_at'=>Carbon::now()];
$response=$this->withHeaders(['Authorization'=>'Bearer'.$accessToken])
->post('api/debit-cards',$data);
$response->assertCreated();

}


public function testCustomerCanSeeASingleDebitCardDetails()
{
// get api/debit-cards/{debitCard}
$accessToken = Auth::user()->createToken('authToken')->accessToken;
$this->assertJson($this->user);
$this->assertAuthenticatedAs(Auth::user());
//create cards
$card=DebitCard::factory()->create(['user_id'=>Auth::user()->id]);
$this->assertJson($card);
$response=$this->withHeaders(['Authorization'=>'Bearer'.$accessToken])
->getJson('api/debit-cards/'.$card->id);
$response->assertJson(fn(AssertableJson $json)
=>$json->where('id',$card->id)
->etc());
$response->assertStatus(200);
}




public function testCustomerCannotSeeASingleDebitCardDetails()
{
// get api/debit-cards/{debitCard}
$accessToken = Auth::user()->createToken('authToken')->accessToken;
$this->assertJson($this->user);
$this->assertAuthenticatedAs(Auth::user());
$card=DebitCard::factory()->create();
$this->assertJson($card);
//invalid card id
$card_id=5000;
$response=$this->withHeaders(['Authorization'=>'Bearer'.$accessToken])
->getJson('api/debit-cards/'.$card_id);
$response->assertNotFound();

}

public function testCustomerCanActivateADebitCard()
{
// put api/debit-cards/{debitCard}
$accessToken = Auth::user()->createToken('authToken')->accessToken;
$this->assertJson($this->user);
$this->assertAuthenticatedAs(Auth::user());
$card=DebitCard::factory()->create(['user_id'=>Auth::user()->id]);
$this->assertJson($card);
$response=$this->withHeaders(['Authorization'=>'Bearer'.$accessToken])->putJson('api/debit-cards/'.$card->id,['is_active'=>true]);
$response->assertValid(['is_active']);
$response->assertSuccessful();



}

public function testCustomerCanDeactivateADebitCard()
{
// put api/debit-cards/{debitCard}
$accessToken = Auth::user()->createToken('authToken')->accessToken;
$this->assertJson($this->user);
$this->assertAuthenticatedAs(Auth::user());
$card=DebitCard::factory()->create(['user_id'=>Auth::user()->id]);
$this->assertJson($card);
$response=$this->withHeaders(['Authorization'=>'Bearer'.$accessToken])->putJson('api/debit-cards/'.$card->id,['is_active'=>Carbon::now()]);
$response->assertValid(['is_active']);
$response->assertSuccessful();

}





public function testCustomerCannotUpdateADebitCardWithWrongValidation()
{
// put api/debit-cards/{debitCard}
$accessToken = Auth::user()->createToken('authToken')->accessToken;
$this->assertJson($this->user);
$this->assertAuthenticatedAs(Auth::user());
$card=DebitCard::factory()->create(['user_id'=>Auth::user()->id]);
$this->assertJson($card);
$response=$this->withHeaders(['Authorization'=>'Bearer'.$accessToken])->putJson('api/debit-cards/'.$card->id,['is_active'=>'']);
$response->assertInvalid(['is_active']);
$response->assertUnprocessable();

}





public function testCustomerCanDeleteADebitCard()
{
// delete api/debit-cards/{debitCard}
$accessToken = Auth::user()->createToken('authToken')->accessToken;
$this->assertJson($this->user);
$this->assertAuthenticatedAs(Auth::user());
$card=DebitCard::factory()->create(['user_id'=>Auth::user()->id]);
$this->assertJson($card);
$response=$this->withHeaders(['Authorization'=>'Bearer'.$accessToken])
->deleteJson('api/debit-cards/'.$card->id);
$response->assertSuccessful();
$response->assertStatus(204);

}

public function testCustomerCannotDeleteADebitCardWithTransaction()
{
// delete api/debit-cards/{debitCard}
$accessToken = Auth::user()->createToken('authToken')->accessToken;
$this->assertJson($this->user);
$this->assertAuthenticatedAs(Auth::user());
$card=DebitCard::factory()->create(['user_id'=>Auth::user()->id]);
$this->assertJson($card);
$transaction=DebitCardTransaction::factory()->create(['debit_card_id'=>$card->id]);
$this->assertJson($transaction);
$response=$this->withHeaders(['Authorization'=>'Bearer'.$accessToken])
->deleteJson('api/debit-cards/'.$card->id);
$response->assertForbidden();


}

// Extra bonus for extra tests :)
















}
